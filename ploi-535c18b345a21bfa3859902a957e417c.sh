#!/bin/bash

set -e
if [[ "feat: update article to include Statamic Static Site Caching" =~ "[no ci]" ]]; then
    echo "Skipping deployment upon commit message request."
    exit 0
fi

cd /home/mariohamann-sljur/mariohamann.com
git pull origin master

composer install --no-interaction --prefer-dist --optimize-autoloader
echo "" | sudo -S service php8.2-fpm reload


npx pnpm i & npx pnpm build

php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan statamic:stache:warm
php artisan statamic:search:update --all
php artisan statamic:static:clear
php artisan statamic:static:warm
php artisan statamic:assets:generate-presets

echo "🚀 Application deployed!"