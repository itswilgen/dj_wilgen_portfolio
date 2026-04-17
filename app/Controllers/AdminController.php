<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Mailer;
use App\Core\Request;
use App\Core\Response;
use App\Models\AdminUser;
use App\Models\Booking;
use App\Models\Gallery;
use Throwable;

final class AdminController extends Controller
{
    private const ALLOWED_STATUSES = ['Pending', 'Confirmed', 'Declined'];

    public function dashboard(): void
    {
        $this->requireAdmin();

        try {
            $booking = new Booking();

            $this->render('admin.dashboard', [
                'title' => 'Admin Dashboard | DJ Wilgen Rivas',
                'bookings' => $booking->allLatestFirst(),
                'csrfToken' => Csrf::token(),
                'deleted' => Request::get('deleted'),
                'update' => Request::get('update'),
                'upload' => Request::get('upload'),
            ]);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());

            $this->render('admin.dashboard', [
                'title' => 'Admin Dashboard | DJ Wilgen Rivas',
                'bookings' => [],
                'csrfToken' => Csrf::token(),
                'deleted' => Request::get('deleted'),
                'update' => 'error',
                'upload' => Request::get('upload'),
            ]);
        }
    }

    public function updateStatus(): void
    {
        $this->requireAdmin();
        $this->ensurePost();
        $this->ensureValidCsrf();

        $id = Request::post('id');
        $newStatus = trim((string) Request::post('status', ''));

        if (!ctype_digit((string) $id)) {
            $this->redirect('admin_panel.php?update=error');
        }

        if (!in_array($newStatus, self::ALLOWED_STATUSES, true)) {
            $this->redirect('admin_panel.php?update=error');
        }

        $bookingId = (int) $id;

        try {
            $bookingModel = new Booking();
            $booking = $bookingModel->findById($bookingId);

            if ($booking === null) {
                $this->redirect('admin_panel.php?update=error');
            }

            $bookingModel->updateStatus($bookingId, $newStatus);
            $this->sendStatusEmail($booking, $newStatus);

            $this->redirect('admin_panel.php?update=success');
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $this->redirect('admin_panel.php?update=error');
        }
    }

    public function deleteBooking(): void
    {
        $this->requireAdmin();
        $this->ensurePost();
        $this->ensureValidCsrf();

        $id = Request::post('id');

        if (!ctype_digit((string) $id)) {
            Response::abort(400, 'Invalid booking ID');
        }

        try {
            $bookingModel = new Booking();
            $bookingModel->delete((int) $id);
            $this->redirect('admin_panel.php?deleted=success');
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            Response::abort(500, 'Delete failed');
        }
    }

    public function uploadPhoto(): void
    {
        $this->requireAdmin();
        $this->ensurePost();
        $this->ensureValidCsrf();

        $gallery = new Gallery();
        $status = $gallery->upload(Request::file('event_photo') ?? []);
        $this->redirect('admin_panel.php?upload=' . $status);
    }

    public function fetchEvents(): void
    {
        $this->requireAdmin();

        try {
            $booking = new Booking();
            Response::json($booking->confirmedEvents());
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            Response::json([], 500);
        }
    }

    private function requireAdmin(): void
    {
        if (!AdminUser::check()) {
            $this->redirect('login.php');
        }
    }

    private function ensurePost(): void
    {
        if (!Request::isPost()) {
            Response::abort(405, 'Invalid request method');
        }
    }

    private function ensureValidCsrf(): void
    {
        if (!Csrf::validate((string) Request::post('csrf_token', ''))) {
            Response::abort(403, 'Invalid CSRF token');
        }
    }

    private function sendStatusEmail(array $booking, string $newStatus): void
    {
        if (!in_array($newStatus, ['Confirmed', 'Declined'], true)) {
            return;
        }

        $subject = $newStatus === 'Confirmed'
            ? 'CONFIRMED: Your Booking with ' . (string) Config::get('site.name')
            : 'Regarding your booking request - ' . (string) Config::get('site.name');

        $body = $newStatus === 'Confirmed'
            ? sprintf(
                "
                <html>
                <body style='font-family: Arial; padding: 20px; background: #f4f4f4;'>
                    <div style='max-width: 600px; margin: auto; background: #fff; padding: 30px; border-top: 5px solid #198754;'>
                        <h2 style='color: #198754;'>Booking Confirmed!</h2>
                        <p>Hi <strong>%s</strong>,</p>
                        <p>I am happy to inform you that I am available for your event on <strong>%s</strong>.</p>
                        <p>Your slot is now officially reserved in my calendar.</p>
                        <p>Regards,<br><strong>%s</strong></p>
                    </div>
                </body>
                </html>
                ",
                e($booking['full_name']),
                e($booking['event_date']),
                e((string) Config::get('site.name'))
            )
            : sprintf(
                "
                <html>
                <body style='font-family: Arial; padding: 20px; background: #f4f4f4;'>
                    <div style='max-width: 600px; margin: auto; background: #fff; padding: 30px; border-top: 5px solid #dc3545;'>
                        <h2 style='color: #dc3545;'>Apologies...</h2>
                        <p>Hi <strong>%s</strong>,</p>
                        <p>Thank you for reaching out for your event on <strong>%s</strong>.</p>
                        <p>Unfortunately, I am not available on that date due to a prior commitment or scheduling conflict.</p>
                        <p>I hope we can work together on a future event.</p>
                        <hr style='border: 0; border-top: 1px solid #eee; margin: 20px 0;'>
                        <p>Best regards,<br><strong>%s</strong></p>
                    </div>
                </body>
                </html>
                ",
                e($booking['full_name']),
                e($booking['event_date']),
                e((string) Config::get('site.name'))
            );

        Mailer::sendHtml((string) $booking['email'], $subject, $body);
    }
}
