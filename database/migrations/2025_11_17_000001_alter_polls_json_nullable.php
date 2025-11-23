<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('polls')) {
            try {
                DB::statement('ALTER TABLE polls MODIFY options JSON NULL');
            } catch (\Throwable $e) {
                // ignore if already correct or column missing
            }
            try {
                DB::statement('ALTER TABLE polls MODIFY votes JSON NULL');
            } catch (\Throwable $e) {
                // ignore if already correct or column missing
            }
        }
    }

    public function down(): void
    {
        // No-op: reverting JSON nullability is unnecessary and may fail across MySQL versions
    }
};
