<?php
require_once("send_mail.php");
// echo 'path tested';
$sub_domain = SUB_DOMAIN;
$userEmail = isset($_REQUEST['email']) ? $_REQUEST['email'] : "";
$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : "";
$mailContent = $_REQUEST['mailContent'].'
            Thanks you for joining with us!
                '.$_REQUEST['mailContent'].'
                Website:<a href="'.$sub_domain.'">'.$sub_domain.'</a>
';

if($userEmail!=''){
    mailTo($userEmail, $subject, $mailContent );
    echo 'Mail Sent';
}
?>
