<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 08-Apr-20
 * Time: 2:59 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../functions/api_functions.php");

$up = isset($_REQUEST['up']) ? $database->escape_value($_REQUEST['up']) : "";
$uid = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : "";

if($up==""||$uid==""){
    dieWithError("Upload API Authentication Failed!", null);
}else{
    $lgnUser = getUser($uid);

    if ($lgnUser->found == true) {
        $upwd = $lgnUser->properties->user_password;
        if(!password_verify($up,$upwd)){
            dieWithError("User Authentication Failed!", null);
        }
    }else{
        dieWithError("User Authentication Failed!", null);
    }
}

$pendingSyncFileDirectory = "pending_sync_files/";

$target_dir = ''; //Directory to save the file that comes from client application.
$tmp_name = $_FILES["file"]["tmp_name"];
$target_file  = $_FILES["file"]["name"];
$uploadOk = 1;
$textFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    unlink($target_file);
}

// Check file size
if ($_FILES["file"]["size"] > 50000000) {
    dieWithError("Sorry, your file is too large!", null);
    $uploadOk = 0;
}

// Allow certain file formats
if($textFileType != "txt" ) {
    dieWithError("Sorry, only TXT files are allowed!", null);
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    dieWithError("Sorry, your file was not uploaded!", null);
} else {
    if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {

        $syncFileTimeStampFormat = 'd_m_Y_h_i_s_a';

        date_default_timezone_set(ASIA_TIME_ZONE);
        $syncTimeStamp = date($syncFileTimeStampFormat);

        $pendingFileName = 'U_' . explode('.', $target_file)[0] . '_' . $syncTimeStamp . '.txt';

        if (move_uploaded_file($tmp_name, $pendingSyncFileDirectory . $pendingFileName)) {

            try {

                $url = $subDomain . '/public/_api/desktop_toes/sync_sales.php';
                $fields = array(
                    'dt' => urlencode(2),
                    'fn' => urlencode($pendingFileName),
                    'up' => urlencode($up),
                    'uid' => urlencode($uid)
                );

                $fields_string = "";
                foreach ($fields as $key => $value) {
                    $fields_string .= $key . '=' . $value . '&';
                }
                rtrim($fields_string, '&');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_URL, $url);
                $syncReport = curl_exec($ch);

                echo $syncReport;

            } catch (Exception $e) {
                dieWithError("Sorry, there was an error while syncing your file!", null);
            }

        } else {
            dieWithError("Sorry, there was an error uploading your file!", null);
        }

    } else {
        dieWithError("Sorry, there was an error uploading your file!", null);
    }
}


































/*

try {

    date_default_timezone_set("Asia/Karachi");
    $longTimeStamp = date('d_m_Y_h_i_s_a');

    $myFile = "./JSON" . $u_id . ".txt";

    $fullFileName = 'U' . $u_id . '_' . 'C' . $counter . '_' . 'D' . $dayEndId . '_' . $longTimeStamp;
    rename($myFile, "syncs/$fullFileName.txt");

} catch (Exception $e) {

    $myFile = "./JSON" . $u_id . ".txt";
    unlink($myFile) or die("Couldn't delete file");

}

*/
