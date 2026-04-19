# DJ Wilgen Portfolio

This project now uses a simple custom PHP MVC structure with OOP classes.

## Structure

- `app/Core` - shared framework-style classes such as config, database, request, response, session, CSRF, mailer, and view rendering
- `app/Controllers` - page, booking, auth, and admin controllers
- `app/Models` - booking, gallery, and admin user models
- `app/Views` - public pages, booking screens, admin screens, and shared partials
- root `.php` files - lightweight entry points that keep the existing URLs working

## Notes

- Database settings can be changed in `app/config.php` or via environment variables.
- The admin password can be configured with `ADMIN_PASSWORD` or `ADMIN_PASSWORD_HASH`.
- Session data is stored in a signed cookie, which works better on serverless platforms like Vercel.
- Existing URLs like `booking.php`, `process_booking.php`, and `admin_panel.php` still work.

## Vercel

- `vercel.json` is included and uses the `vercel-php` community runtime.
- Set these environment variables in Vercel: `DB_HOST`, `DB_PORT`, `DB_USERNAME`, `DB_PASSWORD`, `DB_DATABASE`, `APP_KEY`, `APP_URL`, and either `ADMIN_PASSWORD` or `ADMIN_PASSWORD_HASH`.
- Gallery uploads are intentionally blocked on Vercel because this app still writes new files to local disk. Use Vercel Blob, Cloudinary, or S3 for runtime uploads.
- The repository currently includes large video files. On Vercel Hobby, source uploads are limited to 100 MB, so you will likely need to move those assets to external storage/CDN or upgrade your plan.
