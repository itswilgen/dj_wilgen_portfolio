<?php

declare(strict_types=1);

namespace App\Core;

final class Mailer
{
    public static function sendHtml(
        string $to,
        string $subject,
        string $html,
        ?string $fromName = null,
        ?string $fromEmail = null,
        ?string $replyTo = null
    ): bool {
        $senderEmail = $fromEmail ?: (string) Config::get('site.from_email');
        $senderName = $fromName ?: (string) Config::get('site.name');
        $replyAddress = $replyTo ?: (string) Config::get('site.reply_to');

        $headers = [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            sprintf('From: %s <%s>', $senderName, $senderEmail),
            sprintf('Reply-To: %s', $replyAddress),
        ];

        return mail($to, $subject, $html, implode("\r\n", $headers));
    }
}
