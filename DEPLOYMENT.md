# Laravel Blog Deployment Guide

## Problem Solved: ViteManifestNotFoundException

If you encounter the error:
```
Illuminate\Foundation\ViteManifestNotFoundException
vendor/laravel/framework/src/Illuminate/Foundation/Vite.php:946

Vite manifest not found at: /path/to/your/public/build/manifest.json
```

This means the Vite assets haven't been built for production.

## Solution

### 1. Build Vite Assets for Production

Always run this command before deploying:

```bash
npm install
npm run build
```

This will:
- Install Node.js dependencies
- Build CSS and JavaScript assets for production
- Generate the `public/build/manifest.json` file
- Optimize and minify assets

### 2. Files That Must Be Copied to Production

Make sure these files and folders are included in your deployment:

```
public/build/
├── manifest.json
└── assets/
    ├── app-[hash].css
    └── app-[hash].js

package.json
package-lock.json

deploy.sh
```

### 3. Deployment Script

Use the provided `deploy.sh` script for proper deployment:

```bash
chmod +x deploy.sh
./deploy.sh
```

### 4. Manual Deployment Steps

If you're deploying manually, follow these steps:

1. Copy all files to production server
2. Run `npm install` on production server
3. Run `npm run build` on production server
4. Run `composer install --no-dev --optimize-autoloader`
5. Clear caches:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```
6. Optimize application:
   ```bash
   php artisan route:cache
   php artisan config:cache
   ```

### 5. Why This Happens

The Vite manifest file is generated only when you run `npm run build`. Without this file, Laravel cannot find the compiled assets and throws the ViteManifestNotFoundException.

### 6. Development vs Production

- **Development**: Use `npm run dev` (with Vite dev server)
- **Production**: Use `npm run build` (optimized assets)

### 7. Common Issues

- **Issue**: Manifest file missing in production
- **Cause**: Forgot to run `npm run build`
- **Solution**: Run build command and copy the generated files

- **Issue**: Old manifest file
- **Cause**: Code changes but assets not rebuilt
- **Solution**: Run `npm run build` again

### 8. Verification

After deployment, check if these files exist in production:
- `public/build/manifest.json`
- `public/build/assets/app-*.css`
- `public/build/assets/app-*.js`