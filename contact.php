<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars($_POST['name'] ?? '');
    $email   = htmlspecialchars($_POST['email'] ?? '');
    $phone   = htmlspecialchars($_POST['phone'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    $mail = new PHPMailer(true);

    try {
        // ----- CONFIG SMTP GoDaddy -----
        $mail->isSMTP();
        $mail->Host       = "smtpout.secureserver.net"; 
        $mail->SMTPAuth   = true;
        $mail->Username   = "info@yeticonstruction.com"; // ton email
        $mail->Password   = "TON_MOT_DE_PASSE_ICI";       // ton mot de passe
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // ----- EMAIL VERS TOI -----
        $mail->setFrom("info@yeticonstruction.com", "Site YETI Construction");
        $mail->addAddress("info@yeticonstruction.com"); // destinataire = toi
        $mail->addReplyTo($email, $name); // tu peux répondre direct au client

        $mail->isHTML(true);
        $mail->Subject = "Nouvelle demande de contact - YETI Construction";
        $mail->Body    = "
          <h2>Nouvelle demande de contact</h2>
          <p><strong>Nom:</strong> {$name}</p>
          <p><strong>Email:</strong> {$email}</p>
          <p><strong>Téléphone:</strong> {$phone}</p>
          <p><strong>Message:</strong><br>{$message}</p>
        ";
        $mail->send();

        // ----- EMAIL DE CONFIRMATION AU CLIENT -----
        $confirm = new PHPMailer(true);
        $confirm->isSMTP();
        $confirm->Host       = "smtpout.secureserver.net"; 
        $confirm->SMTPAuth   = true;
        $confirm->Username   = "info@yeticonstruction.com";
        $confirm->Password   = "TON_MOT_DE_PASSE_ICI";
        $confirm->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $confirm->Port       = 587;

        $confirm->setFrom("info@yeticonstruction.com", "YETI Construction");
        $confirm->addAddress($email, $name);

        $confirm->isHTML(true);
        $confirm->Subject = "Confirmation de votre demande - YETI Construction";
        $confirm->Body    = "
          <p>Bonjour {$name},</p>
          <p>Merci de nous avoir contactés ! Nous avons bien reçu votre message et notre équipe vous répondra sous peu.</p>
          <p><em>Ceci est une confirmation automatique.</em></p>
          <p>--<br>YETI Construction<br>info@yeticonstruction.com<br>418-555-0123</p>
        ";
        $confirm->send();

        echo "success";
    } catch (Exception $e) {
        echo "Erreur: {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode non autorisée.";
}
