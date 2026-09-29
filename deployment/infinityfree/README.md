# FanHub+ on InfinityFree

## Package contents

`FanHubPlus-InfinityFree.zip` contains the Laravel application, compiled Vite assets, production PHP dependencies, and files currently stored on the public disk. It does not contain `.env`, `.env.backup`, local SQLite data, `node_modules`, or the Windows `public/storage` junction.

## Upload

1. Back up the existing `htdocs` files in InfinityFree File Manager or FTP.
2. Upload and extract the ZIP into the domain's `htdocs` folder so `app`, `bootstrap`, `public`, `storage`, and `vendor` are directly inside `htdocs`.
3. Keep the package's root `.htaccess` and Laravel's `public/.htaccess`. The root rules route requests through `public` and serve `/storage/...` files from `storage/app/public`; InfinityFree does not support Laravel storage symlinks.
4. Create a `.env` file in the `htdocs` root. Use the production settings from the local `.env.backup`, then verify these values:

   ```dotenv
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://fanhubplus.page.gd
   DB_CONNECTION=mysql
   DB_HOST=<exact MySQL hostname from InfinityFree MySQL Databases>
   DB_PORT=3306
   DB_DATABASE=<database name from InfinityFree>
   DB_USERNAME=<database username from InfinityFree>
   DB_PASSWORD=<database password from InfinityFree>
   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   FILESYSTEM_DISK=public
   ```

   Preserve the existing `APP_KEY`. Do not upload the local `.env` because it points to XAMPP MySQL. Do not put the production `.env` inside `public`.

5. Confirm the remote MySQL database already has the app tables before switching the domain over. InfinityFree does not provide terminal access, so Laravel migrations cannot be run there. Do not import a database dump over an existing database without backing it up first.
6. Visit the domain and check the homepage, sign-in, shop images, and uploaded avatars.

## Hosting constraints

InfinityFree runs Laravel's dependencies and frontend build only after they are prepared locally. The ZIP includes `vendor` without Composer development dependencies and excludes `node_modules`. Background queue workers and scheduled Artisan commands are unavailable on the free plan.

