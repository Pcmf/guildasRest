<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
// Carregar as configurações do email
require_once 'db/emailConfigs.php';

class sendEmail {

    private $mail;

    public function __construct() {
        // Instantiation and passing `true` enables exceptions
        $this->mail = new PHPMailer(false);

    }
    
    public function send($dt) {
        try {
            //Server settings
         //   $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $this->mail->isSMTP();                                            // Send using SMTP
            $this->mail->Host = HOST;                    // Set the SMTP server to send through
            $this->mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $this->mail->Username = 'teste@gestlifes.com';                     // SMTP username
            $this->mail->Password = PASSWORD;                               // SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $this->mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $this->mail->setFrom('teste@gestlifes.com', 'Testes');
            //  $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
            $this->mail->addAddress($dt->emailTo);               // Name is optional
            //  $mail->addReplyTo('info@example.com', 'Information');
            //  $mail->addCC('cc@example.com');
            //  $mail->addBCC('bcc@example.com');
            // Attachments
            //   $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //   $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            // Content
            $this->mail->isHTML(true);                                  // Set email format to HTML
            $this->mail->Subject = $dt->assunto;
            $this->mail->Body = $dt->corpoemail;
            $this->mail->AltBody = $dt->corpoemail;

            $this->mail->send();
            return 0;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
    