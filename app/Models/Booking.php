<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use mysqli;
use RuntimeException;

final class Booking
{
    private mysqli $connection;

    public function __construct()
    {
        $this->connection = Database::connection();
    }

    public function create(array $attributes): bool
    {
        $statement = $this->connection->prepare(
            'INSERT INTO bookings (full_name, email, event_date, event_type, payment_method, details)
             VALUES (?, ?, ?, ?, ?, ?)'
        );

        if (!$statement) {
            throw new RuntimeException('Unable to prepare booking insert statement.');
        }

        $statement->bind_param(
            'ssssss',
            $attributes['name'],
            $attributes['email'],
            $attributes['date'],
            $attributes['type'],
            $attributes['payment'],
            $attributes['details']
        );

        $saved = $statement->execute();
        $statement->close();

        return $saved;
    }

    public function allLatestFirst(): array
    {
        $result = $this->connection->query('SELECT * FROM bookings ORDER BY created_at DESC');

        if (!$result) {
            return [];
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $statement = $this->connection->prepare(
            'SELECT id, full_name, email, event_date, event_type, payment_method, details, status, created_at
             FROM bookings WHERE id = ?'
        );

        if (!$statement) {
            throw new RuntimeException('Unable to prepare booking lookup statement.');
        }

        $statement->bind_param('i', $id);
        $statement->execute();
        $result = $statement->get_result();
        $booking = $result ? $result->fetch_assoc() : null;
        $statement->close();

        return $booking ?: null;
    }

    public function updateStatus(int $id, string $status): bool
    {
        $statement = $this->connection->prepare('UPDATE bookings SET status = ? WHERE id = ?');

        if (!$statement) {
            throw new RuntimeException('Unable to prepare booking status update statement.');
        }

        $statement->bind_param('si', $status, $id);
        $updated = $statement->execute();
        $statement->close();

        return $updated;
    }

    public function delete(int $id): bool
    {
        $statement = $this->connection->prepare('DELETE FROM bookings WHERE id = ?');

        if (!$statement) {
            throw new RuntimeException('Unable to prepare booking delete statement.');
        }

        $statement->bind_param('i', $id);
        $deleted = $statement->execute();
        $statement->close();

        return $deleted;
    }

    public function confirmedEvents(): array
    {
        $result = $this->connection->query(
            "SELECT full_name AS title, event_date AS start, event_type FROM bookings WHERE status = 'Confirmed'"
        );

        if (!$result) {
            return [];
        }

        $events = [];

        while ($row = $result->fetch_assoc()) {
            $events[] = [
                'title' => $row['event_type'] . ': ' . $row['title'],
                'start' => $row['start'],
                'event_type' => $row['event_type'],
            ];
        }

        return $events;
    }
}
