<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Mailer;
use App\Core\Request;
use App\Models\Booking;
use Throwable;

final class BookingController extends Controller
{
    private const EVENT_TYPES = ['Festival', 'Club', 'Corporate', 'Private'];
    private const PAYMENT_METHODS = ['Cash', 'GCash'];

    public function create(): void
    {
        $this->render('booking.form', [
            'activePage' => 'booking',
            'title' => 'Book DJ Wilgen Rivas | Official Inquiry',
            'csrfToken' => Csrf::token(),
        ]);
    }

    public function store(): void
    {
        if (!Request::isPost()) {
            $this->redirect('booking.php');
        }

        if (!Csrf::validate((string) Request::post('csrf_token', ''))) {
            $this->renderStatus('error');
            return;
        }

        $bookingData = $this->validatedBookingData();

        if ($bookingData === null) {
            $this->renderStatus('error');
            return;
        }

        try {
            $booking = new Booking();

            if (!$booking->create($bookingData)) {
                $this->renderStatus('error');
                return;
            }

            $this->sendCustomerEmail($bookingData);
            $this->sendAdminNotification($bookingData);
            Csrf::regenerate();

            $this->renderStatus('success', $bookingData);
        } catch (Throwable $exception) {
            error_log($exception->getMessage());
            $this->renderStatus('error', $bookingData);
        }
    }

    private function validatedBookingData(): ?array
    {
        $name = trim((string) Request::post('name', ''));
        $email = str_replace(["\r", "\n"], '', trim((string) Request::post('email', '')));
        $date = trim((string) Request::post('date', ''));
        $type = trim((string) Request::post('type', ''));
        $payment = trim((string) Request::post('payment', ''));
        $details = trim((string) Request::post('details', ''));

        if ($name === '' || $email === '' || $date === '' || $type === '' || $payment === '') {
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        $dateIsValid = date('Y-m-d', strtotime($date)) === $date;

        if (!$dateIsValid) {
            return null;
        }

        if (!in_array($type, self::EVENT_TYPES, true) || !in_array($payment, self::PAYMENT_METHODS, true)) {
            return null;
        }

        return [
            'name' => $name,
            'email' => $email,
            'date' => $date,
            'type' => $type,
            'payment' => $payment,
            'details' => $details,
        ];
    }

    private function renderStatus(string $status, array $bookingData = []): void
    {
        $this->render('booking.status', [
            'title' => 'Booking Status | DJ Wilgen Rivas',
            'status' => $status,
            'bookingData' => $bookingData,
        ]);
    }

    private function sendCustomerEmail(array $bookingData): void
    {
        $html = sprintf(
            "
            <html>
            <body style='font-family: Arial, sans-serif; background:#0b0b0b; color:#ffffff; padding:20px;'>
                <div style='max-width:600px; margin:auto; background:#111; padding:30px; border-radius:10px;'>
                    <h2 style='color:#0d6efd;'>Booking Request Received</h2>
                    <p>Hi <strong>%s</strong>,</p>
                    <p>Thank you for your inquiry. We have received your booking request with the following details:</p>
                    <ul>
                        <li><strong>Event Date:</strong> %s</li>
                        <li><strong>Event Type:</strong> %s</li>
                        <li><strong>Payment Method:</strong> %s</li>
                    </ul>
                    <p>We will review your request and contact you shortly to confirm availability.</p>
                    <hr style='border:1px solid #333;'>
                    <p style='font-size:12px; color:#aaa;'>%s<br>Professional DJ Services</p>
                </div>
            </body>
            </html>
            ",
            e($bookingData['name']),
            e($bookingData['date']),
            e($bookingData['type']),
            e($bookingData['payment']),
            e((string) Config::get('site.name'))
        );

        Mailer::sendHtml(
            $bookingData['email'],
            'Booking Request Received | ' . (string) Config::get('site.name'),
            $html
        );
    }

    private function sendAdminNotification(array $bookingData): void
    {
        $dashboardUrl = $this->adminPanelUrl();
        $html = sprintf(
            "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2>New Booking Request</h2>
                <p><strong>Name:</strong> %s</p>
                <p><strong>Email:</strong> %s</p>
                <p><strong>Date:</strong> %s</p>
                <p><strong>Event Type:</strong> %s</p>
                <p><strong>Payment:</strong> %s</p>
                <p><strong>Details:</strong><br>%s</p>
                <p>Review the request in your <a href='%s' style='color:#0d6efd;'>Admin Dashboard</a>.</p>
            </body>
            </html>
            ",
            e($bookingData['name']),
            e($bookingData['email']),
            e($bookingData['date']),
            e($bookingData['type']),
            e($bookingData['payment']),
            nl2br(e($bookingData['details'])),
            e($dashboardUrl)
        );

        Mailer::sendHtml(
            (string) Config::get('site.admin_email'),
            'NEW BOOKING REQUEST',
            $html,
            'Booking System'
        );
    }

    private function adminPanelUrl(): string
    {
        $baseUrl = rtrim((string) Config::get('site.base_url', ''), '/');

        if ($baseUrl !== '') {
            return $baseUrl . '/admin_panel.php';
        }

        $host = $_SERVER['HTTP_HOST'] ?? '';

        if ($host === '') {
            return 'admin_panel.php';
        }

        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $directory = trim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        $path = $directory === '' ? '' : '/' . $directory;

        return sprintf('%s://%s%s/admin_panel.php', $scheme, $host, $path);
    }
}
