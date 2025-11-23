# Railway Deployment Fix

## Issues Fixed

### 1. Missing server.php (RESOLVED ✓)
- **Problem**: PHP built-in server couldn't find `server.php`
- **Solution**: Created `server.php` in project root

### 2. Migration Order Issues (RESOLVED ✓)
- **Problem**: `comment_reactions` table tried to reference `photo_comments` before it was created
- **Root Cause**: Migration timestamps were out of order
- **Solution**: 
  - Renamed `2024_01_15_000000_create_comment_reactions_table.php` → `2024_08_27_142055_create_comment_reactions_table.php`
  - Renamed `2024_01_16_000000_create_photo_votes_table.php` → `2024_08_27_132609_create_photo_votes_table.php`
  - Created cleanup migration `2024_08_27_142054_drop_comment_reactions_if_exists.php`

### 3. Migration Execution (IMPROVED ✓)
- **Created**: `railway.sh` startup script
- **Updated**: `Procfile` to use the startup script
- **Benefit**: Ensures migrations run before server starts

## Correct Migration Order

```
1. photos (2024_08_27_132603)
2. photo_votes (2024_08_27_132609) - depends on photos
3. photo_comments (2024_08_27_142050) - depends on photos
4. comment_reactions cleanup (2024_08_27_142054) - drops if exists
5. comment_reactions (2024_08_27_142055) - depends on photo_comments
```

## Next Steps

1. **Commit all changes**:
   ```bash
   git add .
   git commit -m "Fix Railway deployment: add server.php, fix migration order"
   git push
   ```

2. **On Railway Dashboard**:
   - Option A: Redeploy (migrations will auto-fix)
   - Option B: If still failing, reset the database and redeploy

## Files Changed

- ✅ `server.php` (created)
- ✅ `railway.sh` (created)
- ✅ `Procfile` (updated)
- ✅ `database/migrations/2024_08_27_142054_drop_comment_reactions_if_exists.php` (created)
- ✅ `database/migrations/2024_08_27_142055_create_comment_reactions_table.php` (renamed)
- ✅ `database/migrations/2024_08_27_132609_create_photo_votes_table.php` (renamed)
