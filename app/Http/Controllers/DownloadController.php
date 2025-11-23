<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class DownloadController extends Controller
{
    public function downloadPhoto(Photo $photo, Request $request)
    {
        // Check if photo is active
        if (!$photo->is_active) {
            abort(404);
        }

        // Increment download count if column exists
        if (Schema::hasColumn('photos', 'download_count')) {
            $photo->increment('download_count');
        }

        // Record user activity if authenticated
        if (Auth::check()) {
            Auth::user()->recordActivity('download', $photo);
            
            // Update user stats
            if (Auth::user()->stats) {
                Auth::user()->stats->increment('total_downloads');
            }
        }

        $size = $request->get('size', 'original');
        $watermark = false; // watermark disabled globally

        try {
            // If Intervention Image is unavailable, serve the original file directly
            if (!class_exists(\Intervention\Image\ImageManager::class)) {
                $imagePath = storage_path('app/public/' . $photo->path);
                if (!file_exists($imagePath)) {
                    // Serve static placeholder if available
                    $placeholder = public_path('images/placeholder.jpg');
                    if (file_exists($placeholder)) {
                        return Response::download($placeholder, $this->generateFilename($photo, $size, false));
                    }
                    // Last resort: small transparent PNG
                    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWNgYGBgAAAABQABh6X8qQAAAABJRU5ErkJggg==');
                    return Response::make($png, 200, [
                        'Content-Type' => 'image/png',
                        'Content-Disposition' => 'attachment; filename="' . $this->generateFilename($photo, $size, false) . '"',
                        'Content-Length' => strlen($png),
                    ]);
                }
                $filename = $this->generateFilename($photo, $size, false);
                return Response::download($imagePath, $filename);
            }

            $manager = new ImageManager(new Driver());
            
            // Get the original image path
            $imagePath = storage_path('app/public/' . $photo->path);
            
            if (!file_exists($imagePath)) {
                // Generate a placeholder image dynamically
                $canvas = $manager->create(1600, 1000);
                $canvas->fill('#f5f5f5');
                // Simple band
                $canvas->drawRectangle(0, 900, 1600, 1000, function ($draw) {
                    $draw->background('rgba(0,0,0,0.85)');
                });
                $title = $photo->title ?: config('app.name', 'Maravia');
                $canvas->text($title, 40, 940, function ($font) {
                    $font->size(42);
                    $font->color('#ffffff');
                    $font->align('left');
                    $font->valign('top');
                });

                $imageData = $canvas->toJpeg(90);
                $filename = $this->generateFilename($photo, $size, false);
                return Response::make($imageData, 200, [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                    'Content-Length' => strlen($imageData),
                ]);
            }

            // Load the image
            $image = $manager->read($imagePath);

            // Resize based on requested size
            switch ($size) {
                case 'small':
                    $image->scale(width: 800);
                    break;
                case 'medium':
                    $image->scale(width: 1200);
                    break;
                case 'large':
                    $image->scale(width: 1920);
                    break;
                case 'original':
                default:
                    // Keep original size
                    break;
            }

            // Watermark disabled

            // Generate filename
            $filename = $this->generateFilename($photo, $size, false);

            // Convert to JPEG and get binary data
            $imageData = $image->toJpeg(90);

            return Response::make($imageData, 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Content-Length' => strlen($imageData),
            ]);

        } catch (\Exception $e) {
            abort(500, 'Error processing image: ' . $e->getMessage());
        }
    }

    private function addWatermark($image, Photo $photo)
    {
        $width = $image->width();
        $height = $image->height();

        // Create watermark text
        $schoolName = config('app.name', 'Maravia');
        $watermarkText = $schoolName . ' - ' . $photo->title;
        
        // Calculate font size based on image dimensions
        $fontSize = max(16, min(48, $width / 25));
        
        // Add semi-transparent overlay at bottom
        $overlayHeight = 80;
        $image->drawRectangle(0, $height - $overlayHeight, $width, $height, function ($draw) {
            $draw->background('rgba(0, 0, 0, 0.8)');
        });

        // Add main watermark text
        $image->text($watermarkText, 20, $height - 50, function ($font) use ($fontSize) {
            $font->size($fontSize);
            $font->color('#ffffff');
            $font->align('left');
            $font->valign('top');
        });

        // Add smaller copyright text
        $copyrightText = ' ' . date('Y') . ' ' . config('app.name', 'Maravia') . ' - All Rights Reserved';
        $image->text($copyrightText, 20, $height - 25, function ($font) use ($fontSize) {
            $font->size($fontSize * 0.7);
            $font->color('#cccccc');
            $font->align('left');
            $font->valign('top');
        });

        // Add website URL
        $websiteUrl = request()->getSchemeAndHttpHost();
        $image->text($websiteUrl, $width - 20, $height - 25, function ($font) use ($fontSize) {
            $font->size($fontSize * 0.7);
            $font->color('#cccccc');
            $font->align('right');
            $font->valign('top');
        });

        // Add diagonal watermark for extra protection
        $diagonalText = strtoupper($schoolName);
        $image->text($diagonalText, $width / 2, $height / 2, function ($font) use ($fontSize, $width) {
            $font->size($fontSize * 3);
            $font->color('rgba(255, 255, 255, 0.08)');
            $font->align('center');
            $font->valign('middle');
            $font->angle(45);
        });

        // Add user info if authenticated
        if (Auth::check()) {
            $userText = 'Downloaded by: ' . Auth::user()->name;
            $image->text($userText, $width - 20, $height - 50, function ($font) use ($fontSize) {
                $font->size($fontSize * 0.6);
                $font->color('#ffffff');
                $font->align('right');
                $font->valign('top');
            });
        }

        return $image;
    }

    private function generateFilename(Photo $photo, string $size, bool $watermark): string
    {
        $basename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $photo->title);
        $basename = trim($basename, '_');
        
        if (empty($basename)) {
            $basename = 'photo_' . $photo->id;
        }

        $suffix = '';
        if ($size !== 'original') {
            $suffix .= '_' . $size;
        }
        if ($watermark) {
            $suffix .= '_watermarked';
        }

        return $basename . $suffix . '.jpg';
    }

    public function bulkDownload(Request $request)
    {
        $request->validate([
            'photo_ids' => 'required|array|max:50', // Limit bulk downloads
            'photo_ids.*' => 'exists:photos,id',
            'size' => 'in:small,medium,large,original',
            // watermark removed
        ]);

        $photos = Photo::whereIn('id', $request->photo_ids)
                      ->where('is_active', true)
                      ->get();

        if ($photos->isEmpty()) {
            abort(404, 'No valid photos found');
        }

        // Record bulk download activity
        if (Auth::check()) {
            Auth::user()->recordActivity('bulk_download', null, [
                'photo_count' => $photos->count(),
                'photo_ids' => $request->photo_ids
            ]);
            
            // Update user stats
            if (Auth::user()->stats) {
                Auth::user()->stats->increment('total_downloads', $photos->count());
            }
        }

        $size = $request->get('size', 'medium');
        $watermark = false; // disabled globally

        // Create a temporary zip file
        $zipFileName = 'maravia_gallery_' . date('Y-m-d_H-i-s') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== TRUE) {
            abort(500, 'Cannot create zip file');
        }

        try {
            $useProcessor = class_exists(\Intervention\Image\ImageManager::class);
            $manager = $useProcessor ? new ImageManager(new Driver()) : null;

            foreach ($photos as $photo) {
                $imagePath = storage_path('app/public/' . $photo->path);
                
                if (!file_exists($imagePath)) {
                    continue;
                }

                // If image processor exists, optionally resize; else add original file
                $filename = $this->generateFilename($photo, $size, false);
                if ($useProcessor) {
                    $image = $manager->read($imagePath);
                    switch ($size) {
                        case 'small':
                            $image->scale(width: 800); break;
                        case 'medium':
                            $image->scale(width: 1200); break;
                        case 'large':
                            $image->scale(width: 1920); break;
                    }
                    $imageData = $image->toJpeg(90);
                    $zip->addFromString($filename, $imageData);
                } else {
                    // Add original without processing
                    $zip->addFile($imagePath, $filename);
                }

                // Increment download count
                $photo->increment('download_count');
            }

            $zip->close();

            // Return zip file for download
            return Response::download($zipPath, $zipFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            if (file_exists($zipPath)) {
                unlink($zipPath);
            }
            abort(500, 'Error creating zip file: ' . $e->getMessage());
        }
    }

    public function getDownloadStats()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $userStats = [
            'total_downloads' => $user->stats->total_downloads ?? 0,
            'downloads_this_month' => $user->activities()
                ->where('activity_type', 'download')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
            'downloads_this_week' => $user->activities()
                ->where('activity_type', 'download')
                ->where('created_at', '>=', now()->startOfWeek())
                ->count(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $userStats
        ]);
    }
}
