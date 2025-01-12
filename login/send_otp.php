<?php
// Menyertakan file PHPMailer secara manual
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true); // Membuat objek PHPMailer
    try {
        // Pengaturan server SMTP
        $mail->isSMTP();  
        $mail->Host = 'smtp.gmail.com'; // SMTP server Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Email pengirim
        $mail->Password = 'your-email-password'; // Password email pengirim
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Port untuk koneksi SMTP

        // Pengaturan penerima dan pengirim
        $mail->setFrom('your-email@gmail.com', 'OTP Verification');
        $mail->addAddress($email); // Email penerima

        // Isi email
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = 'Your OTP code is: ' . $otp;

        // Mengirim email
        $mail->send();
        echo "OTP has been sent to $email";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Membuat OTP acak
$otp = rand(100000, 999999); // OTP 6 digit
sendOTP('user@example.com', $otp); // Ganti dengan email penerima
?>