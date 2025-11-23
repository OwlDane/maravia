# Railway Environment Variables Setup

## Required Environment Variables

Set these in your Railway dashboard under **Variables** tab:

### Essential Variables
```bash
APP_NAME=Maravia
APP_ENV=production
APP_DEBUG=false
APP_URL=https://maravia.up.railway.app
ASSET_URL=https://maravia.up.railway.app

# Generate a new key with: php artisan key:generate --show
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
```

### Database (Auto-configured by Railway MySQL plugin)
```bash
# These are automatically set when you add MySQL plugin
DB_CONNECTION=mysql
DB_HOST=${MYSQLHOST}
DB_PORT=${MYSQLPORT}
DB_DATABASE=${MYSQLDATABASE}
DB_USERNAME=${MYSQLUSER}
DB_PASSWORD=${MYSQLPASSWORD}
```

### Session & Cache
```bash
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

### Logging
```bash
LOG_CHANNEL=stack
LOG_LEVEL=error
```

## How to Set Variables in Railway

1. Go to your Railway project dashboard
2. Click on your service
3. Go to **Variables** tab
4. Click **+ New Variable**
5. Add each variable one by one
6. Click **Deploy** to apply changes

## Important Notes

- ⚠️ **Never commit `.env` file to git**
- ✅ The `.env.example` file is safe to commit (no secrets)
- 🔑 Generate a new `APP_KEY` for production (don't use local key)
- 🔄 After setting variables, Railway will automatically redeploy

## Generate APP_KEY

Run locally:
```bash
php artisan key:generate --show
```

Copy the output and set it as `APP_KEY` in Railway.
