#!/usr/bin/env bash
# ==============================================================================
# ABVHPS AWS EC2 / ECS Production Deployment Automation Script
# ==============================================================================
set -e

echo "🚀 [1/8] Starting ABVHPS AWS Production Deployment Pipeline..."

# 1. Maintain application directory
APP_DIR="${APP_DIR:-/var/www/abvhps}"
cd "$APP_DIR"

# 2. Put application into maintenance mode gracefully (Optional during zero-downtime Blue/Green)
# php artisan down --render="errors::503" --secret="deployment-bypass-key" || true

# 3. Pull latest release from version control
echo "📦 [2/8] Fetching release codebase..."
git fetch origin main
git reset --hard origin/main

# 4. Install production PHP dependencies (no development libraries)
echo "🐘 [3/8] Installing production PHP dependencies..."
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

# 5. Install frontend packages and build optimized assets
echo "⚡ [4/8] Building Vite production assets..."
npm ci --no-audit --prefer-offline
npm run build

# 6. Execute safe database schema migrations (Non-destructive)
echo "🗄️ [5/8] Running database migrations on AWS RDS..."
php artisan migrate --force

# 7. Optimize Laravel cache for production performance
echo "⚙️ [6/8] Caching configuration, routes, and views..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 8. Manage storage symlink if local storage disk is used
if [ "$FILESYSTEM_DISK" = "local" ] || [ "$FILESYSTEM_DISK" = "public" ]; then
    echo "🔗 Ensuring public storage symlink..."
    php artisan storage:link || true
fi

# 9. Restart persistent background queue workers
echo "🔄 [7/8] Restarting queue workers..."
php artisan queue:restart || true

# 10. Bring application live
# php artisan up || true

echo "✅ [8/8] ABVHPS AWS Production Deployment Completed Successfully!"
