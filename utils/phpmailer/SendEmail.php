<?php
require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendEmail
{

    function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer();
        $mail->setLanguage($langcode = 'pt-br', $lang_path = './language');

        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'maimiodibaum@gmail.com';
            $mail->Password = 'atetyrkzjthzaoor';
            $mail->Port = 587;

            $mail->setFrom('syschat@gmail.com');
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($mail->send()) {
                header('location:' . BASE_URL);
            } else {
                header('location:' . BASE_URL);
            }
        } catch (Exception $e) {
            echo 'Erro ao enviar mensagem:' .
                $mail->ErrorInfo;
        }
    }
}
