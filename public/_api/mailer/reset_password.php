<?php
require_once("send_mail.php");
// echo 'path tested';
$sub_domain = SUB_DOMAIN;
$userEmail = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
//$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : "";
$subject = 'Password Recover Mail';
$mailContent ='
            Password Recover Mail.
            Click below Link For reset your password
                '.$_REQUEST['token'].'
';

if($userEmail!=''){
    mailToRecoverPassword($userEmail, $subject, $mailContent );
    echo 'Mail Sent';
}
?>
