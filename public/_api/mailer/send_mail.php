<?php
/**
 * Created by CH Arbaz Mateen.
 * User: Arbaz Mateen
 * Date: 30-Jul-18
 * Time: 12:25 AM
 * Desc: Send verification link to user's email address.
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require_once("../_db/database.php");

//try {
    //Server settings
//    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
//    $mail->isSMTP();                                            // Set mailer to use SMTP
//    $mail->Host       = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
//    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//    $mail->Username   = 'user@example.com';                     // SMTP username
//    $mail->Password   = 'secret';                               // SMTP password
//    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
//    $mail->Port       = 587;                                    // TCP port to connect to
//
    //Recipients
//    $mail->setFrom('from@example.com', 'Mailer');
//    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
//    $mail->addAddress('ellen@example.com');               // Name is optional
//    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com');
//    $mail->addBCC('bcc@example.com');
//
//    // Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
//
//    // Content
//    $mail->isHTML(true);                                  // Set email format to HTML
//    $mail->Subject = 'Here is the subject';
//    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//    $mail->send();
//
//} catch (Exception $e) {
//    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//}

function mailOnly($toEmail, $subject, $mailBody, $ccEmail = null, $bccEmail = null) {

    $appName = APP_NAME;
    $clientName = SUB_DOMAIN_NAME;
    $setFrom = NO_REPLY_SENDING_EMAIL_ADDRESS;

    try {

        $mail = new PHPMailer(true);
        $mail->setFrom($setFrom, $clientName . ' - ' . $appName);

        $mail->addAddress($toEmail);

        if ($ccEmail != null) {
            $mail->addCC($ccEmail);
        }

        if ($bccEmail != null) {
            $mail->addBCC($bccEmail);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $mailBody;
        $mail->send();

    } catch (Exception $e) {}
}

function mailTo($toEmail, $subject, $mailBody, $ccEmail = null, $bccEmail = null) {

    $appName = APP_NAME;
    $clientName = SUB_DOMAIN_NAME;
    $setFrom = SUPPORT_EMAIL_ADDRESS;

    try {

        $mail = new PHPMailer(true);
        $mail->setFrom($setFrom, $clientName . ' - ' . $appName);

        $mail->addAddress($toEmail);

        if ($ccEmail != null) {
            $mail->addCC($ccEmail);
        }

        if ($bccEmail != null) {
            $mail->addBCC($bccEmail);
        }

//        $mail->isHTML(true);
//        $mail->Subject = $subject;
//        $mail->Body = $mailBody;
//        $mail->send();
        $mail->Subject = $subject;
        $mail->msgHTML($mailBody);
        $mail->send();

//        mailToSupport($subject, $mailBody);

    } catch (Exception $e) {}
}

function mailToMany($emails, $subject, $mailBody, $ccEmails = null, $bccEmails = null) {

    $appName = APP_NAME;
    $clientName = SUB_DOMAIN_NAME;
    $setFrom = NO_REPLY_SENDING_EMAIL_ADDRESS;

    try {

        $mail = new PHPMailer(true);
        $mail->setFrom($setFrom, $clientName . ' - ' . $appName);

        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        if ($ccEmails != null) {
            foreach ($ccEmails as $email) {
                $mail->addCC($email);
            }
        }

        if ($bccEmails != null) {
            foreach ($bccEmails as $email) {
                $mail->addBCC($email);
            }
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $mailBody;
        $mail->send();

    } catch (Exception $e) {}
}

function mailToSupport($subject, $body) {

    $appName = APP_NAME;
    $clientName = SUB_DOMAIN_NAME;
    $setFrom = NO_REPLY_SENDING_EMAIL_ADDRESS;

//    $supportEmailAddress = SUPPORT_EMAIL_ADDRESS;
    $reportsEmailAddress = REPORTS_SENDING_EMAIL_ADDRESS;

    try {

        $mail = new PHPMailer(true);
        $mail->setFrom($setFrom, $clientName . ' - ' . $appName);

        $mail->addAddress($reportsEmailAddress);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->send();

    } catch (Exception $e) {}

}

function mailToRecoverPassword($toEmail, $subject, $mailBody, $ccEmail = null, $bccEmail = null) {

    $appName = APP_NAME;
    $clientName = SUB_DOMAIN_NAME;
    $setFrom = SUPPORT_EMAIL_ADDRESS;

    try {

        $mail = new PHPMailer(true);
        $mail->setFrom($setFrom, $clientName . ' - ' . $appName);

        $mail->addAddress($toEmail);

        if ($ccEmail != null) {
            $mail->addCC($ccEmail);
        }

        if ($bccEmail != null) {
            $mail->addBCC($bccEmail);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $mailBody;
        $mail->send();

//        mailToSupport($subject, $mailBody);

    } catch (Exception $e) {}
}

