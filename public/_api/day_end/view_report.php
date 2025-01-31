<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 26-Mar-20
 * Time: 3:18 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");

$dayEndReportsFolder = DAY_END_REPORT_FOLDER_NAME;
$monthEndReportsFolder = MONTH_END_REPORT_FOLDER_NAME;

$DAY_END_REPORT = TYPE_DAY_END; // = 1
$MONTH_END_REPORT = TYPE_MONTH_END; // = 2

$reportName = isset($_REQUEST['n']) ? $_REQUEST['n'] : ""; // file name 1 or askdjshakdjashkdjashdk_kfaghskdjsghakdjahskd
$reportType = isset($_REQUEST['t']) ? $_REQUEST['t'] : "0"; // type aksjdhaskjdhaksjdhaskj

$fileName = "";
$type = 0;
$folder = "";

if ($reportName == "" && $reportType == "0") {
    die("Parameters not found!");
}


if ($reportType == $DAY_END_REPORT) {

    $type = 1;

    $folder = $dayEndReportsFolder;

    $d = explode('_', $reportName);

    if (count($d) == 2) {

        $fileName = $d[0];
        $type = $d[1];

        if ($type == $DAY_END_REPORT) {
            $type = 1;
        } elseif ($type == $MONTH_END_REPORT) {
            $type = 2;
        } else {
            die("Report type is not found!");
        }

    } else {
        $fileName = $reportName;
    }

} elseif ($reportType == $MONTH_END_REPORT) {

    $type = 2;

    $folder = $monthEndReportsFolder;

    $d = explode('_', $reportName);

    if (count($d) == 2) {

        $fileName = $d[0];
        $type = $d[1];

        if ($type == $DAY_END_REPORT) {
            $type = 1;
        } elseif ($type == $MONTH_END_REPORT) {
            $type = 2;
        } else {
            die("Report type is not found!");
        }

    } else {
        $fileName = $reportName;
    }

} else {

    $d = explode('_', $reportName);

    if (count($d) == 2) {

        $fileName = $d[0];
        $type = $d[1];

        if ($type == $DAY_END_REPORT) {
            $type = 1;
            $folder = $dayEndReportsFolder;
        } elseif ($type == $MONTH_END_REPORT) {
            $type = 2;
            $folder = $monthEndReportsFolder;
        } else {
            die("Report type is not found!");
        }

    } else {
        die("Report type is not found!");
    }

}

try {

    $file = "$folder/$fileName.html";

    if (file_exists($file)) {
        $fileContent = file_get_contents($file);
        echo $fileContent;
    } else {
        die("Report not found!");
    }

} catch (Exception $e) {
    echo "Report not found Error: " . $e->getMessage();
}


