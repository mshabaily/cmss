<?php

namespace CMSS;

use CMSS\HasLogger;
use CMSS\Response;
use CMSS\Singleton;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    use Singleton;
    use HasLogger;

    private $system_address;

    protected function __construct()
    {
        self::load_logger('mailer');
        $host = $_SERVER['SERVER_NAME'] ?? 'localhost';
        $this->system_address = 'system@' . $host;
    }

    public function send($from, $to, $subject, $content) : Response
    {

        $from = $from ? $from : $this->system_address;

        try {
            if (!filter_var($from, FILTER_VALIDATE_EMAIL) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
                return new Response(400, 'Invalid address');
            }

            if ($subject === '') {
                return new Response(400, 'Invalid subject');
            }

            if ($content === '') {
                return new Response(400, 'Invalid content');
            }

            $mail = new PHPMailer(true);

            $mail->isMail();

            $mail->setFrom($from);
            $mail->addAddress($to);

            $mail->Subject = $subject;
            $mail->Body = $content;
            $mail->isHTML(false);

            $mail->send();

            $this->log('Email sent');

            return new Response(200, 'email sent');
        } catch (Exception $e) {
            $this->error('Email failed');

            return new Response(500, 'email failed: ' . $e->getMessage());
        }
    }
}