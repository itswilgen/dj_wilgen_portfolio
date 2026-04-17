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
- Existing URLs like `booking.php`, `process_booking.php`, and `admin_panel.php` still work.
