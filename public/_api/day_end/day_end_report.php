<?php
/**
 * Created by Ch Arbaz Mateen.
 * * Reviwed by Syed Mustafa Haider, Muzamil Imran,
 * User: Ch Arbaz Mateen.
 * Date: 09-Jan-20
 * Time: 12:45 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$reportExeStartTime = microtime(true);

require_once("../_db/database.php");
require_once("../functions/functions.php");
//require_once("../functions/db_functions.php");
require_once("../functions/day_end_functions.php");
require_once("../mailer/send_mail.php");

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";


$rollBack = false;
$error = false;

$assetsTopLevelUID = ASSETS;
$liabilityTopLevelUID = LIABILITIES;
$revenueTopLevelUID = REVENUES;
$expensesTopLevelUID = EXPENSES;
$equityTopLevelUID = EQUITY;

$cashParentUID = CASH_PARENT_UID;
$bankParentUID = BANK_PARENT_UID;
$stockParentUID = STOCK_PARENT_UID;
$salesTradeDiscountParentUID = SALES_TRADE_DISCOUNT_PARENT_UID;


$cgsExpensesGroupUID = CGS_EXPENSE_GROUP_UID;

$cashAccountUID = CASH_ACCOUNT_UID;
$stockAccountUID = STOCK_ACCOUNT_UID;
$salesAccountUID = SALES_ACCOUNT_UID;
$saleReturnAccountUID = SALE_RETURN_ACCOUNT_UID;
$purchaseAccountUID = PURCHASE_ACCOUNT_UID;
$purchaseReturnAccountUID = PURCHASE_RETURN_ACCOUNT_UID;
$claimReceivedAccountUID = CLAIM_RECEIVED_ACCOUNT_UID;
$claimIssueAccountUID = CLAIM_ISSUE_ACCOUNT_UID;


$ownerEquityParentAccountUID = OWNERS_EQUITY_GROUP_UID;
$investorEquityParentAccountUID = INVESTORS_EQUITY_GROUP_UID;

$tellerId = TELLER;

$entryAccountsCompleteList = array();
$trialViewList = array();

$totalSalesValue = 0;
$totalSalesReturnValue = 0;
$totalPurchaseValue = 0;
$totalPurchaseReturnValue = 0;
$claimReceivedValue = 0;
$claimIssueValue = 0;
$openingStockBalance = 0;
$closingStockBalance = 0;

$profitAndLossAccountValue = 0;

$dayEndHTMLReport = "";
$currentUserReadableDate = "";

$srcUrl = "";
if ($type == "android") {
    $srcUrl = "./src";
} else {
    $srcUrl = "$subDomain/public/_api/day_end/src";
}



/*
 * ******************************************************************************************************************************
 *
 * HTML Header
 *
 * ******************************************************************************************************************************
 */
$htmlHeader = '
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="#">

    <title>
        Day End Report
    </title>

    <link rel="stylesheet" type="text/css" href="' . $srcUrl . '/css/day_end.css" />


</head>
<body class="gnrl-mrgn-pdng">

<div class="main_container"><!-- miles planet main container start -->

    <div class="report_container"><!-- miles planet container start -->

';

/*
 * ******************************************************************************************************************************
 *
 * HTML Mail Header
 *
 * ******************************************************************************************************************************
 */
$mailContentSrcPath = $subDomain . "/public/_api/day_end/src/";
//$cssContent = file_get_contents('' . $srcUrl . '/css/day_end.css') or "";
$cssContent = $srcUrl . '/css/day_end.css' or "";
$cssContent = str_replace( "../", $mailContentSrcPath, $cssContent);

$htmlInternalCSSHeader = '
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="#">

    <title>
        Day End Report
    </title>
    <style type="text/css">

    ' . $cssContent . '

    </style>

</head>
<body class="gnrl-mrgn-pdng">

<div class="main_container"><!-- miles planet main container start -->

    <div class="report_container"><!-- miles planet container start -->

';

/*
 * ******************************************************************************************************************************
 *
 * HTML Footer
 *
 * ******************************************************************************************************************************
 */
$htmlFooter = '
        <!-- Footer Note -->
        <div class="note_well_bx">
            <div class="note_well_title_bx">
                <h3 class="note_well_title">
                    Note
                </h3>
            </div>
            <div class="note_well_cntnt">
                If you found anything wrong like calculation error, something missing or any kind of critical error that you think is not the part of a normal day end procedure, please contact to admin ASAP (As Soon As Possible) or mail us at <a href="mailto:support@jadeedmunshi.com"> support@jadeedmunshi.com </a> and do not execute Day End until the issue you found is not resolved. Thank you.
            </div>
        </div>

		<div class="clear"></div>

    </div><!-- miles planet container end -->

</div><!-- miles planet main container end -->

<script type="text/javascript">

    let getExpendDiv = "";

    function expendDiv(e) {
        getExpendDiv = e.getAttribute("data-expendId");
        let obj = document.getElementById(getExpendDiv);
        if (obj != null) {
            obj.classList.toggle("heightIncrease");
        }
    }

    function expand(e) {
        getExpendDiv = e.getAttribute("data-expendId");
        let obj = document.getElementById(getExpendDiv);
        if (obj != null) {
            obj.classList.add("heightIncrease");
        }
    }

    function collapse(e) {
        getExpendDiv = e.getAttribute("data-expendId");
        let obj = document.getElementById(getExpendDiv);
        if (obj != null) {
            obj.classList.remove("heightIncrease");
        }
    }

    function toggleExpand(id, img) {
        let imgSrc = $(img).attr("src");
        let collapseSrc = "' . $srcUrl . '/images/collapse1.png";
        let expandSrc = "' . $srcUrl . '/images/expand1.png";
        let src = "";
        let expanded = true;
        if (imgSrc.indexOf("collapse1.png") >= 0) {
            src = expandSrc;
            expanded = true;
        } else {
            src = collapseSrc;
            expanded = false;
        }

        $(img).attr("src", src);
        let tableId = "";
        switch (id) {
            case 1:
                tableId = "#trial";
                break;
            case 2:
                tableId = "#cash";
                break;
            case 3:
                tableId = "#pnl";
                break;
            case 4:
                tableId = "#bs";
                break;
        }

        if (expanded) {
            $(tableId + " tr[data-expendId]").each(function (key, row) {
                collapse(row);
            });
        } else {
            $(tableId + " tr[data-expendId]").each(function (key, row) {
                expand(row);
            });
        }
    }

</script>

<!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
';

if ($type == "android") {
    $htmlFooter .= '<script src="' . $srcUrl . '/js/jquery.js" ></script>';
}

$htmlFooter .= '<script src="' . $srcUrl . '/js/copy.js"></script>

<div id="snackbar"></div>
</body>
</html>
';

/*
 * ******************************************************************************************************************************
 *
 * Functions
 *
 * ******************************************************************************************************************************
 */
function error($title, $errorMessage) {

    return '
    <!-- Error Message with Title -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    ' . $title . '
                </h2>
            </div>
            <p class="alert-well">
                ' . $errorMessage . '
            </p>
        </section><!-- invoice content section end here -->
    ';
}

function shortError($errorMessage) {
    return '
        <p class="alert-well">
            ' . $errorMessage . '
        </p>
    ';
}

function shortSuccess($message) {
    return '
        <p class="success-well">
            ' . $message . '
        </p>
    ';
}

function exeTimeDiv($time, $message = "Execution Time: ") {
    return '<div class="exe_time">' . $message . number_format($time, 4) . ' second(s)</div>';
}

function e($message) {
    echo $message . "<br />";
}

function successMessage($title, $message) {
    return '
    <!-- Error Message with Title -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    ' . $title . '
                </h2>
            </div>
            <p class="success-well">
                ' . $message . '
            </p>
        </section><!-- invoice content section end here -->
    ';
}

function p($array) {
    print_r($array);
    echo "<br /><br />";
}

function json($array) {
    header('Content-Type: application/json');
    echo json_encode($array, JSON_PRETTY_PRINT);
    echo "<br /><br />";
}

/*
 * ******************************************************************************************************************************
 *
 * Company Info
 *
 * ******************************************************************************************************************************
 */
$companyLogo = DEFAULT_LOGO_IMAGE_PATH;
$companyName = '';
$companyInfo = null;
$companyInfoData = getCompanyInfo();
if ($companyInfoData->found == true) {
    $companyInfo = $companyInfoData->properties;
    $companyLogo = $companyInfo->ci_logo;
    $companyName = $companyInfo->ci_name;
}


/*
 * ******************************************************************************************************************************
 *
 * Header Section only Company Logo
 *
 * ******************************************************************************************************************************
 */
$headerSectionBeforeDate = '
        <!-- Header Logo, Title, Date -->
        <header class="day_end_header">
            <div class="day_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="' . $companyLogo . '" alt="' . $companyName . '" class="logo-img"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Day End Report
                    </h1>
                </div><!-- header title box end -->

                <div class="day_end_header_detail_bx"><!-- header detail box start -->
                    <p class="detail_para darkorange">
                        Without Execution&nbsp;
                    </p>
                    <p class="detail_para">
                        Date:
                        <span>
                            00-00-0000
                        </span>
                    </p>
                </div><!-- header detail box end -->

            </div><!-- header container end -->
            <div class="clear"></div>
        </header><!-- header end here -->
';

/*
 * ******************************************************************************************************************************
 *
 * Day ends ids
 *
 * ******************************************************************************************************************************
 */
$currentDayEndId = 0;
$currentDayEndIsLocked = true;
$currentDayEndDate = "";
$lastClosedDayEndId = 0;
$lastClosedDayEndDate = "";
$isLastClosedDayEndAvailable = false;
$isThisLastDayOfMonth = false;

$currentDayEnd = getOpenDayEnd();

if ($currentDayEnd->found === true) {

    $currentDayEndIsLocked = $currentDayEnd->status == 'LOCKED';
    $currentDayEndId = $currentDayEnd->id;
    $currentDayEndDate = $currentDayEnd->date;
    $isThisLastDayOfMonth = isLastDayOfMonth($currentDayEndDate);

    try {

        $currentDate = new DateTime($currentDayEndDate);
        $currentDate = $currentDate->format(USER_DATE_FORMAT);
        $currentUserReadableDate = $currentDate;

    } catch (Exception $e) {}


    if ($currentDayEndId > 1) {

        $lastClosedDayEnd = getLastCloseDayEnd();

        if ($lastClosedDayEnd->found == true) {
            $lastClosedDayEndId = $lastClosedDayEnd->id;
            $lastClosedDayEndDate = $lastClosedDayEnd->date;
            $isLastClosedDayEndAvailable = true;
        } else {
            $error = true;
            $dieReport = $htmlHeader;
            $dieReport .= $headerSectionBeforeDate;
            $dieReport .= error("Previous Day End Not Found", "There is an error found while getting the last closed day end data!");
            $dieReport .= $htmlFooter;

            if (isset($database)) {
                $database->close_connection();
            }

            die($dieReport);
        }

    }

    if ($currentDayEndId - 1 != $lastClosedDayEndId) {
        $error = true;
        $dieReport = $htmlHeader;
        $dieReport .= $headerSectionBeforeDate;
        $dieReport .= error("Day End Not Found", "There is some error during day end process, one or more id's between 2 parallel day ends is not found. Please contact to your admin!. Current DayEndId: $currentDayEndId, Last Closed DayEndId: $lastClosedDayEndId.");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);
    }

} else {

    $pendingMonthEnd = getPendingMonthEnd();

    if ($pendingMonthEnd->found == true) {

        // call to month end report
//        $monthEndReport = "";
//
//        $monthEndId = $pendingMonthEnd->id;
//
//        try {
//
//            $url = $monthEndReportFile;
//
//            $fields = array(
//                'type' => urlencode(isset($_REQUEST['type']) ? $_REQUEST['type'] : "android"),
//                'did' => urlencode($monthEndId),
//                'uid' => urlencode(isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : 0),
//                'upass' => urlencode(isset($_REQUEST['upass']) ? $database->escape_value($_REQUEST['upass']) : ""),
//                'mail' => urlencode(0)
//            );
//
//            $fields_string = "";
//            foreach($fields as $key => $value) { $fields_string .= $key . '=' . $value . '&'; }
//            rtrim($fields_string, '&');
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_POST, count($fields));
//            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
//            curl_setopt($ch, CURLOPT_URL, $url);
//            $monthEndReport = curl_exec($ch);
//            curl_close($ch);
//
//        } catch (Exception $e) {}
//
//        die($monthEndReport);


        $error = true;
        $dieReport = $htmlHeader;
        $dieReport .= $headerSectionBeforeDate;
        $dieReport .= successMessage("Month End Pending", "Month End is still pending for execution, Please execute Day End to Complete the Execution...");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);

    } else {
        $error = true;
        $dieReport = $htmlHeader;
        $dieReport .= $headerSectionBeforeDate;
        $dieReport .= error("Day End Error", "Current day end is not available for execution!");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);
    }
}

/*
 * ******************************************************************************************************************************
 *
 * Get Day End Config
 *
 * ******************************************************************************************************************************
 */
$dayEndConfig = null;

$cashCheck = false;
$bankCheck = false;
$productCheck = false;
$warehouseCheck = false;
$createTrial = false;
$creatClosingStock = false;
$createCashBankOpeningClosing = false;
$createPnL = false;
$createBalanceSheet = false;
$createPnlDistribution = false;
$trialType='';

$loginUserId = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : 0;
$loginClgId = isset($_REQUEST['clg_id']) ? $database->escape_value($_REQUEST['clg_id']) : 0;
$userPassword = isset($_REQUEST['upass']) ? $database->escape_value($_REQUEST['upass']) : "";

$dailyCompleteReport = false;
// echo $loginClgId;
// exit();

$dayEndConfigQuery = "SELECT dec_cash_check, dec_bank_check, dec_product_check, dec_warehouse_check, dec_create_trial,
                            dec_create_closing_stock, dec_create_cash_bank_closing, dec_create_pnl,
                            dec_create_balance_sheet, dec_create_pnl_distribution
                        FROM financials_day_end_config WHERE dec_clg_id =".$loginClgId;

$dayEndConfigResult = $database->query($dayEndConfigQuery);

if ($dayEndConfigResult && $database->num_rows($dayEndConfigResult) == 1) {
    $dayEndConfig = (object)$database->fetch_assoc($dayEndConfigResult);

    $cashCheck = $dayEndConfig->dec_cash_check == "1";
    $bankCheck = $dayEndConfig->dec_bank_check == "1";
    $productCheck = $dayEndConfig->dec_product_check == "1";
    $warehouseCheck = $dayEndConfig->dec_warehouse_check == "1";

    $createTrial = $dayEndConfig->dec_create_trial == "1";

    if($createTrial==1){
        $trialType="(Day-End)";
    }else{
        $trialType="(Month-End)";
    }

    $creatClosingStock = $dayEndConfig->dec_create_closing_stock == "1";
    $createCashBankOpeningClosing = $dayEndConfig->dec_create_cash_bank_closing == "1";
    $createPnL = $dayEndConfig->dec_create_pnl == "1";
    $createBalanceSheet = $dayEndConfig->dec_create_balance_sheet == "1";
    $createPnlDistribution = $dayEndConfig->dec_create_pnl_distribution == "1";

    $dailyCompleteReport = ($createTrial || $creatClosingStock || $createCashBankOpeningClosing || $createPnL || $createBalanceSheet || $createPnlDistribution);

} else {

    $dieReport = $htmlHeader;
    $dieReport .= $headerSection;
    $dieReport .= error("Day End Configuration Not Found", "Did'nt found Day End Configuration data to show report or Day End Execution!");
    $dieReport .= $htmlFooter;

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 * ******************************************************************************************************************************
 *
 * Header Section including Company Logo and Day End Date
 *
 * ******************************************************************************************************************************
 */
$headerSection = '
        <!-- Header Logo, Title, Date -->
        <header class="day_end_header">
            <div class="day_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="' . $companyLogo . '" alt="' . $companyName . '" height="50"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Day End Report
                    </h1>
                </div><!-- header title box end -->

                <div class="day_end_header_detail_bx"><!-- header detail box start -->
                    <p class="detail_para darkorange">
                        Without Execution&nbsp;
                    </p>
                    <p class="detail_para">
                        Date:
                        <span>
                            ' . $currentUserReadableDate . '
                        </span>
                    </p>
                </div><!-- header detail box end -->

            </div><!-- header container end -->
            <div class="clear"></div>
        </header><!-- header end here -->
';

/*
 * ******************************************************************************************************************************
 *
 * Auth token / User Credentials verification
 *
 * ******************************************************************************************************************************
 */
//$loginUserId = isset($_POST['uid']) ? $database->escape_value($_POST['uid']) : 0;
//$userPassword = isset($_POST['upass']) ? $database->escape_value($_POST['upass']) : "";
$loginUserId = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : 0;
$userPassword = isset($_REQUEST['upass']) ? $database->escape_value($_REQUEST['upass']) : "";

$userName = "";
$userEmail = "";
$userCellNumber = "";

if ($loginUserId > 0 && $userPassword != "") {

    $userQuery = "SELECT user_name, user_email, user_mobile, user_password, user_login_status FROM financials_users WHERE user_id = $loginUserId LIMIT 1";
    $userResult = $database->query($userQuery);

    if ($userResult && $database->num_rows($userResult) == 1) {

        $userData = $database->fetch_assoc($userResult);

        $userName = $userData['user_name'];
        $userEmail = $userData['user_email'];
        $userCellNumber = $userData['user_mobile'];
        $hashPassword = $userData['user_password'];
        $userStatus = $userData['user_login_status'];

        if ($userStatus == "DISABLE") {
            $error = true;
            $rollBack = true;

            $dieReport = $htmlHeader;
            $dieReport .= $headerSection;
            $dieReport .= error("Invalid User", "You are not Authorized to View/Execute Day End due to your account status id 'DISABLE'!");
            $dieReport .= $htmlFooter;

            if (isset($database)) {
                $database->close_connection();
            }

            die($dieReport);

        } else {

            $passwordMatch = 0;

            $passwordMatch = password_verify($userPassword, $hashPassword);
            if (empty($passwordMatch)) {
                $passwordMatch = 0;
            }

            if ($passwordMatch != 1) {
                $error = true;
                $rollBack = true;

                $dieReport = $htmlHeader;
                $dieReport .= $headerSection;
                $dieReport .= error("Invalid Credentials", "Username/Password is not valid, Please check and try again!");
                $dieReport .= $htmlFooter;

                if (isset($database)) {
                    $database->close_connection();
                }

                die($dieReport);
            }
        }

    } else {
        $error = true;
        $rollBack = true;

        $dieReport = $htmlHeader;
        $dieReport .= $headerSection;
        $dieReport .= error("User not Found", "Did't found user associate given Credentials!");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);
    }

} else {
    $error = true;
    $rollBack = true;

    $dieReport = $htmlHeader;
    $dieReport .= $headerSection;
    $dieReport .= error("Credentials not Found", "User Credentials not Found, Please provide Username/Password!");
    $dieReport .= $htmlFooter;

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 * ******************************************************************************************************************************
 *
 * Check if any Teller is Still Online
 *
 * ******************************************************************************************************************************
 */
$onlineUsersQuery = "SELECT * FROM financials_users WHERE user_role_id = $tellerId and lower(user_desktop_status) = 'online';";
$onlineUsersResult = $database->query($onlineUsersQuery);

$userOnlineErrorReport = '';
$userTableHtml = '';
$onlineUsersFound = false;

if ($onlineUsersResult && isset($onlineUsersResult) && $database->num_rows($onlineUsersResult) > 0) {

    $userTableHtml = '
        <!-- Tellers Still Online -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Tellers Still Online
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_18">
                        Employee Code
                    </th>
                    <th class="text-left tbl_txt_28">
                        Full Name
                    </th>
                    <th class="text-center tbl_srl_18">
                        Email
                    </th>
                    <th class="text-center tbl_srl_18">
                        Cell #
                    </th>
                </tr>
                </thead>
                <tbody>
                ';

    while ($onlineUser = $database->fetch_array($onlineUsersResult)) {
        $onlineUsersFound = true;
        $error = true;
        $rollBack = true;

        $userTableHtml .= '
            <tr class="normalHover">
                <td class="text-center tbl_srl_18">
                    ' . $onlineUser['user_employee_code'] . '
                </td>
                <td class="text-left tbl_txt_28">
                    ' . $onlineUser['user_name'] . '
                </td>
                <td class="text-left tbl_srl_18">
                    <a href="' . $onlineUser['user_name'] . '">' . $onlineUser['user_email'] . '</a>
                </td>
                <td class="text-center tbl_srl_18">
                    <a href="' . $onlineUser['user_name'] . '">' . $onlineUser['user_mobile'] . '</a>
                </td>
            </tr>
        ';

    }

    $userTableHtml .= '
        </tbody>
            </table><!-- table end -->
			<p class="alert-well">
                Some of the Tellers are still online, Please make sure they Offline properly!
            </p>
        </section><!-- invoice content section end here -->
    ';

    if ($onlineUsersFound == true) {

        $error = true;
        $rollBack = true;

        $userOnlineErrorReport .= $htmlHeader;
        $userOnlineErrorReport .= $headerSection;
        $userOnlineErrorReport .= $userTableHtml;
        $userOnlineErrorReport .= shortError('<a href="' . $subDomain . '/force_offline_user" target="_blank">Force Offline Users</a>');
        $userOnlineErrorReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($userOnlineErrorReport);
    }

}

/*
 *******************************************************************************************************************************
 *
 * Cash Account Error
 *
 * ******************************************************************************************************************************
 */
$cashErrorReport = "";

if ($cashCheck || $isThisLastDayOfMonth) {
    $getCashAccountsQuery = "SELECT account_uid as UID, account_name as name FROM financials_accounts WHERE account_parent_code = $cashParentUID;";
    $getCashAccountsResult = $database->query($getCashAccountsQuery);
    if ($getCashAccountsResult && $database->num_rows($getCashAccountsResult) > 0) {

        $tempCashErrorReport = '
        <!-- Cash Accounts Error -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Cash Accounts Error
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_18">
                        Account Code
                    </th>
                    <th class="text-left tbl_txt_64">
                        Account Title
                    </th>
                    <th class="text-center tbl_srl_18">
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody>
    ';

        $cashError = 0;

        while ($cashAccounts = $database->fetch_array($getCashAccountsResult)) {

            $accountUID = $cashAccounts['UID'];
            $accountName = $cashAccounts['name'];
            $accountBalanceObject = getAccountClosingBalance($accountUID);
            $accountBalance = $accountBalanceObject->balance;

            if ($accountBalance < 0) {
                $cashError++;
                $error = true;

                $tempCashErrorReport .= '
                <tr class="normalHover">
                    <th class="text-center tbl_srl_18 pointer" onclick=\'copyThis(this)\'>
                        ' . $accountUID . '
                    </th>
                    <th class="text-left tbl_txt_64">
                        ' . $accountName . '
                    </th>
                    <td class="text-right tbl_srl_18">
						' . number_format($accountBalance, 2, '.', ',') . '
                    </td>
                </tr>
            ';

                $rollBack = true;
            }

        }

        $tempCashErrorReport .= '
        </tbody>
            </table><!-- table end -->
			<p class="alert-well">
                Cash account balance should not be treated as negative!
            </p>
        </section><!-- invoice content section end here -->
    ';

        if($cashError > 0) {
            $cashErrorReport .= $tempCashErrorReport;
        }
    }
}

/*
 *******************************************************************************************************************************
 *
 * Bank Account Error
 *
 * ******************************************************************************************************************************
 */
$bankErrorReport = "";

if ($bankCheck || $isThisLastDayOfMonth) {
    $getBankAccountsQuery = "SELECT account_uid as UID, account_name as name FROM financials_accounts WHERE account_parent_code = $bankParentUID;";
    $getBankAccountsResult = $database->query($getBankAccountsQuery);

    if ($getBankAccountsResult && $database->num_rows($getBankAccountsResult) > 0) {

        $tempBankErrorReport = '
        <!-- Cash Accounts Error -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Bank Accounts Error
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_18">
                        Account Code
                    </th>
                    <th class="text-left tbl_txt_64">
                        Account Title
                    </th>
                    <th class="text-center tbl_srl_18">
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody>
    ';

        $bankError = 0;

        while ($bankAccounts = $database->fetch_array($getBankAccountsResult)) {

            $accountUID = $bankAccounts['UID'];
            $accountName = $bankAccounts['name'];
            $accountBalanceObject = getAccountClosingBalance($accountUID);


            $accountBalance = $accountBalanceObject->balance;


            if ($accountBalance < 0) {
                $bankError++;
                $error = true;

                $tempBankErrorReport .= '
                <tr class="normalHover">
                    <th class="text-center tbl_srl_18 pointer" onclick=\'copyThis(this)\'>
                        ' . $accountUID . '
                    </th>
                    <th class="text-left tbl_txt_64">
                        ' . $accountName . '
                    </th>
                    <td class="text-right tbl_srl_18">
						' . number_format($accountBalance, 2, '.', ',') . '
                    </td>
                </tr>
            ';

                $rollBack = true;
            }

        }



        $tempBankErrorReport .= '
        </tbody>
            </table><!-- table end -->
			<p class="alert-well">
                Bank account balance should not be treated as negative!
            </p>
        </section><!-- invoice content section end here -->
    ';

        if($bankError > 0) {
            $bankErrorReport .= $tempBankErrorReport;
        }
    }
}

/*
 *******************************************************************************************************************************
 *
 * Product Quantity Error function
 *
 * ******************************************************************************************************************************
 */
function proNegative($qty) {
    return $qty < 0 ? "pro_negative" : "";
}

/*
 *******************************************************************************************************************************
 *
 * Product Quantity Error
 *
 * ******************************************************************************************************************************
 */
$quantityErrorReport = "";

if ($productCheck || $isThisLastDayOfMonth) {
    $getProductsQuery = "SELECT pro_p_code, pro_title, pro_qty_for_sale, pro_hold_qty, pro_bonus_qty, pro_claim_qty, pro_qty_wo_bonus, pro_quantity
                    FROM financials_products
                    WHERE pro_qty_for_sale < 0 OR pro_hold_qty < 0 OR pro_bonus_qty < 0 OR pro_claim_qty < 0 OR pro_qty_wo_bonus < 0 OR pro_quantity < 0;";
    $getProductsResult = $database->query($getProductsQuery);
    if ($getProductsResult) {

        $inventoryErrorReport = '
        <!-- Inventory Error -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Inventory Error
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_13">
                        Barcode
                    </th>
                    <th class="text-left tbl_txt_28">
                        Product Title
                    </th>
                    <th class="text-center tbl_srl_6">
                        Qty for Sale
                    </th>
                    <th class="text-center tbl_srl_6">
                        Hold Qty
                    </th>
                    <th class="text-center tbl_srl_6">
                        Bonus Qty
                    </th>
                    <th class="text-center tbl_srl_6">
                        Claim Qty
                    </th>
                    <th class="text-center tbl_srl_6">
                        Qty w/o Bonus
                    </th>
                    <th class="text-center tbl_srl_6">
                        Total Qty
                    </th>
                </tr>
                </thead>
                <tbody>
    ';
        $inventoryError = 0;

        while ($products = $database->fetch_array($getProductsResult)) {

            $proBarCode = $products['pro_p_code'];
            $productTitle = $products['pro_title'];
            $proQtyForSale = $products['pro_qty_for_sale'];
            $proHoldQty = $products['pro_hold_qty'];
            $proBonusQty = $products['pro_bonus_qty'];
            $proClaimQty = $products['pro_claim_qty'];
            $proQtyWOBonus = $products['pro_qty_wo_bonus'];
            $proQuantity = $products['pro_quantity'];

            $inventoryError++;
            $error = true;

            $inventoryErrorReport .= '
            <tr class="normalHover">
                <th class="text-center tbl_srl_13 pointer" onclick=\'copyThis(this)\'>
                    ' . $proBarCode . '
                </th>
                <th class="text-left tbl_txt_28">
                    ' . $productTitle . '
                </th>
                <td class="text-right tbl_srl_6 ' . proNegative($proQtyForSale) . '">
                    ' . number_format($proQtyForSale, 3) . '
                </td>
                <td class="text-right tbl_srl_6 ' . proNegative($proHoldQty) . '">
                    ' . number_format($proHoldQty, 3) . '
                </td>
                <td class="text-right tbl_srl_6 ' . proNegative($proBonusQty) . '">
                    ' . number_format($proBonusQty, 3) . '
                </td>
                <td class="text-right tbl_srl_6 ' . proNegative($proClaimQty) . '">
                    ' . number_format($proClaimQty, 3) . '
                </td>
                <td class="text-right tbl_srl_6 ' . proNegative($proQtyWOBonus) . '">
                    ' . number_format($proQtyWOBonus, 3) . '
                </td>
                <td class="text-right tbl_srl_6 ' . proNegative($proQuantity) . '">
                    ' . number_format($proQuantity, 3) . '
                </td>
            </tr>
        ';

            $rollBack = true;

        }

        $inventoryErrorReport .= '
        </tbody>
            </table><!-- table end -->
			<p class="alert-well">
                Products quantity of Sale, Hold, Bonus, Claim, Quantity wihout Bonus and Total Quantity should not be treated as negative!
            </p>
        </section><!-- invoice content section end here -->
    ';

        if($inventoryError > 0) {
            $quantityErrorReport .= $inventoryErrorReport;
        }
    }
}

/*
 *******************************************************************************************************************************
 *
 * Product Quantity Error in Warehouse
 *
 * ******************************************************************************************************************************
 */
$warehouseQuantityErrorReport = "";

if ($warehouseCheck || $isThisLastDayOfMonth) {
    $getProductsQuery = "SELECT pro_p_code, pro_title, wh_title, whs_stock
                        FROM financials_warehouse_stock
                            JOIN financials_products ON whs_product_code = pro_p_code
                            join financials_warehouse on wh_id = whs_warehouse_id;";
    $getProductsResult = $database->query($getProductsQuery);
    if ($getProductsResult) {

        $warehousesErrorReport = '
        <!-- Warehouse Inventory Error -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Warehouse Inventory Error
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-center tbl_srl_18">
                         Barcode
                    </th>
                    <th class="text-left tbl_txt_64">
                        Product Title
                    </th>
                    <th class="text-center tbl_srl_18">
                        Warehouse
                    </th>
                    <th class="text-center tbl_srl_18">
                        Quantity
                    </th>
                </tr>
                </thead>
                <tbody>
    ';
        $warehousesError = 0;

        while ($products = $database->fetch_array($getProductsResult)) {

            $proBarCode = $products['pro_p_code'];
            $productTitle = $products['pro_title'];
            $warehouse = $products['wh_title'];
            $productQuantity = $products['whs_stock'];

            if ($productQuantity < 0) {
                $warehousesError++;
                $error = true;

                $warehousesErrorReport .= '
                <tr class="normalHover">
                    <th class="text-center tbl_srl_18 pointer" onclick=\'copyThis(this)\'>
                        ' . $proBarCode . '
                    </th>
                    <th class="text-left tbl_txt_64">
                        ' . $productTitle . '
                    </th>
                    <td class="text-left tbl_srl_18">
						' . $warehouse . '
                    </td>
                    <td class="text-right tbl_srl_18">
						' . number_format($productQuantity, 3) . '
                    </td>
                </tr>
            ';

                $rollBack = true;

            }

        }

        $warehousesErrorReport .= '
        </tbody>
            </table><!-- table end -->
			<p class="alert-well">
                Products quantity should not be treated as negative in warehouses!
            </p>
        </section><!-- invoice content section end here -->
    ';

        if($warehousesError > 0) {
            $warehouseQuantityErrorReport .= $warehousesErrorReport;
        }
    }
}

/*
 *******************************************************************************************************************************
 *
 * All Errors Report and Stop day end Process
 *
 * ******************************************************************************************************************************
 */
if ($error || $rollBack) {
    $dieReport = $htmlHeader;
    $dieReport .= $headerSection;
    $dieReport .= $cashErrorReport;
    $dieReport .= $bankErrorReport;
    $dieReport .= $quantityErrorReport;
    $dieReport .= $warehouseQuantityErrorReport;
    $dieReport .= $htmlFooter;

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}


















/*
 *******************************************************************************************************************************
 *
 * Daily Depreciation
 *
 * ******************************************************************************************************************************
 */
$dailyDepreciationHTMPReport = "";

if (!$error) {
    $dailyDepExeStartTime = microtime(true);

    $annually = DEP_PERIOD_ANNUALLY;
    $monthly = DEP_PERIOD_MONTHLY;
    $daily = DEP_PERIOD_DAILY;

    $slm = DEP_METHOD_SLM;
    $rbm = DEP_METHOD_RBM;

    $depreciation = DEP_DEPRECIATION;
    $amortization = DEP_AMORTIZATION;

    $auto = DEP_POSTING_AUTO;
    $manual = DEP_POSTING_MANUAL;


    $dailyDepQuery = "SELECT fa_id, fa_account_name, fa_link_account_uids, fa_price, fa_residual_value,
                        fa_useful_life_year, fa_useful_life_day, fa_dep_entries, fa_dep_percentage_day, fa_method, fa_book_value, fa_acquisition_date
                        FROM financials_fixed_asset
                        WHERE fa_dep_period = $daily
                          and fa_posting = $auto
                          and fa_dep_amo = $depreciation
                          and fa_dep_entries < fa_useful_life_day
                          and '$currentDayEndDate' >= fa_acquisition_date;";

    $dailyDepResult = $database->query($dailyDepQuery);

    if ($dailyDepResult && $database->num_rows($dailyDepResult) > 0) {

        $dailyDepreciationHTMPReport .= '
            <!-- Daily Depreciation -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Daily Depreciation
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-left tbl_txt_28">
                        Asset Name
                    </th>
                    <th class="text-center tbl_srl_10">
                        Initial Value
                    </th>
                    <th class="text-center tbl_srl_6">
                        End Value
                    </th>
                    <th class="text-center tbl_srl_6">
                        Life (Y)
                    </th>
                    <th class="text-center tbl_srl_6">
                        Dep %
                    </th>
                    <th class="text-center tbl_srl_6">
                        Method
                    </th>
                    <th class="text-center tbl_srl_13">
                        Acc. Dep
                    </th>
                    <th class="text-center tbl_srl_6">
                        Dep Exp
                    </th>
                    <th class="text-center tbl_srl_10">
                        Total Dep
                    </th>
                    <th class="text-center tbl_srl_10">
                        Book Value
                    </th>
                </tr>
                </thead>
                <tbody>
        ';

        $totalDailyDepExp = 0;

        while ($dep = $database->fetch_array($dailyDepResult)) {

            $fixedAssetEntryId = $dep['fa_id'];
            $bookValue = $dep['fa_book_value'];
            $price = $dep['fa_price'];
            $residuaValue = $dep['fa_residual_value'];
            $depPercentage = $dep['fa_dep_percentage_day'];

            $lifeInDays = $dep['fa_useful_life_day'];
            $depEntries = $dep['fa_dep_entries'];

            $methodName = $dep['fa_method'] == $slm ? "SLM" : "RBM";

            $depAccounts = explode(',', $dep['fa_link_account_uids']);
            $depAssetAccountUID = $depAccounts[0];
            $depAccDepAssetAccountUID = $depAccounts[1];
            $depDepExpenseAccountUID = $depAccounts[2];

            $accDepAssetAccountBalance = getAccountClosingBalance($depAccDepAssetAccountUID)->balance;

            if ($methodName === "SLM") {
                $todaysDepExp = (($price - $residuaValue) * $depPercentage) / 100;
                $newBookValue = $price + $accDepAssetAccountBalance - $todaysDepExp;
            } else {
                $todaysDepExp = (($bookValue - $residuaValue) * $depPercentage) / 100;
                $newBookValue = $bookValue - $todaysDepExp;
            }

            $dailyDepreciationHTMPReport .= '
                <tr>
                    <th class="text-left tbl_txt_28">
                        ' . $dep['fa_account_name'] . '
                    </th>
                    <td class="text-right tbl_srl_10">
                        ' . number_format($price, 2) . '
                    </td>
                    <td class="text-right tbl_srl_6">
                        ' . number_format($residuaValue, 2) . '
                    </td>
                    <td class="text-center tbl_srl_6">
                        ' . $dep['fa_useful_life_year'] . '
                    </td>
                    <td class="text-right tbl_srl_6">
                        ' . number_format($depPercentage, 6) . '
                    </td>
                    <td class="text-center tbl_srl_6">
                        ' . $methodName . '
                    </td>
                    <td class="text-right tbl_srl_13">
                        ' . number_format($accDepAssetAccountBalance, 2) . '
                    </td>
                    <td class="text-right tbl_srl_6">
                        ' . number_format($todaysDepExp, 2) . '
                    </td>
                    <td class="text-right tbl_srl_10">
                        ' . number_format($accDepAssetAccountBalance - $todaysDepExp, 2) . '
                    </td>
                    <td class="text-right tbl_srl_10">
                        ' . number_format($newBookValue, 2) . '
                    </td>
                </tr>
            ';

            $totalDailyDepExp += $todaysDepExp;
        }

        $dailyDepreciationHTMPReport .= '
            </tbody>
            <tfoot>
                <tr>
                    <th class="text-center tbl_txt_28">
                        Total Expense
                    </th>
                    <td colspan="6" class="text-right tbl_srl_10">

                    </td>
                    <td class="text-right tbl_srl_6">
                        ' . number_format($totalDailyDepExp, 2) . '
                    </td>
                    <td colspan="2" class="text-right tbl_srl_10">

                    </td>
                </tr>
            </tfoot>
            </table><!-- table end -->
        </section><!-- invoice content section end here -->
        ';

        $dailyDepExeStopTime = microtime(true);
        $dailyDepreciationHTMPReport .= exeTimeDiv($dailyDepExeStopTime - $dailyDepExeStartTime);

        $dailyDepreciationHTMPReport .= '
            <p class="info-well">
                This is only view of calculation, Depreciation expense occur at the time of Day End Execution.
            </p>
        ';

    }

}

/*
 *******************************************************************************************************************************
 *
 * Monthly Depreciation
 *
 * ******************************************************************************************************************************
 */
$monthlyDepreciationHTMPReport = '';

if (!$error) {
    $monthDepExeStartTime = microtime(true);

    if ($isThisLastDayOfMonth) {

        $monthlyDepQuery = "SELECT fa_id, fa_account_name, fa_link_account_uids, fa_price, fa_residual_value,
                        fa_useful_life_year, fa_useful_life_month, fa_dep_entries, fa_dep_percentage_month, fa_dep_percentage_year, fa_method, fa_book_value,
                        fa_acquisition_date, DATEDIFF('$currentDayEndDate', fa_acquisition_date) as days
                        FROM financials_fixed_asset
                        WHERE fa_dep_period = $monthly
                          and fa_posting = $auto
                          and fa_dep_amo = $depreciation
                          and fa_dep_entries < fa_useful_life_month
                          and '$currentDayEndDate' >= fa_acquisition_date
                          and DATEDIFF('$currentDayEndDate', fa_acquisition_date) > 0;";

        $monthlyDepResult = $database->query($monthlyDepQuery);

        if ($monthlyDepResult && $database->num_rows($monthlyDepResult) > 0) {

            $monthlyDepreciationHTMPReport .= '
                <!-- Monthly Depreciation -->
                <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                    <div class="invoice_cntnt_title_bx">
                        <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                            Monthly Depreciation
                        </h2>
                    </div>
                    <table class="table day_end_table">
                        <thead>
                        <tr>
                            <th class="text-left tbl_txt_28">
                                Asset Name
                            </th>
                            <th class="text-center tbl_srl_10">
                                Initial Value
                            </th>
                            <th class="text-center tbl_srl_6">
                                End Value
                            </th>
                            <th class="text-center tbl_srl_6">
                                Life (Y)
                            </th>
                            <th class="text-center tbl_srl_6">
                                Dep %
                            </th>
                            <th class="text-center tbl_srl_6">
                                Method
                            </th>
                            <th class="text-center tbl_srl_13">
                                Acc. Dep
                            </th>
                            <th class="text-center tbl_srl_6">
                                Dep Exp
                            </th>
                            <th class="text-center tbl_srl_10">
                                Total Dep
                            </th>
                            <th class="text-center tbl_srl_10">
                                Book Value
                            </th>
                        </tr>
                        </thead>
                        <tbody>
            ';

            $totalMonthlyDepExp = 0;

            while ($dep = $database->fetch_array($monthlyDepResult)) {

                $fixedAssetEntryId = $dep['fa_id'];
                $bookValue = $dep['fa_book_value'];
                $price = $dep['fa_price'];
                $residuaValue = $dep['fa_residual_value'];
                $depPercentage = $dep['fa_dep_percentage_month'];
                $depPercentageYear = $dep['fa_dep_percentage_year'];

                $lifeInMonths = $dep['fa_useful_life_month'];
                $depEntries = $dep['fa_dep_entries'];

                $depStartDate = $dep['fa_acquisition_date'];
                $depDays = $dep['days'];

                $methodName = $dep['fa_method'] == $slm ? "SLM" : "RBM";

                $depAccounts = explode(',', $dep['fa_link_account_uids']);
                $depAssetAccountUID = $depAccounts[0];
                $depAccDepAssetAccountUID = $depAccounts[1];
                $depDepExpenseAccountUID = $depAccounts[2];

                $accDepAssetAccountBalance = getAccountClosingBalance($depAccDepAssetAccountUID)->balance;

//                if ($depEntries == 0) {
//                    $depPercentage = ($depPercentageYear / 365) * $depDays;
//                }

                if ($methodName === "SLM") {
                    $monthlyDepExp = (($price - $residuaValue) * $depPercentage) / 100;
                    $newBookValue = $price + $accDepAssetAccountBalance - $monthlyDepExp;
                } else {
                    $monthlyDepExp = (($bookValue - $residuaValue) * $depPercentage) / 100;
                    $newBookValue = $bookValue - $monthlyDepExp;
                }

                $monthlyDepreciationHTMPReport .= '
                    <tr>
                        <th class="text-left tbl_txt_28">
                            ' . $dep['fa_account_name'] . '
                        </th>
                        <td class="text-right tbl_srl_10">
                            ' . number_format($price, 2) . '
                        </td>
                        <td class="text-right tbl_srl_6">
                            ' . number_format($residuaValue, 2) . '
                        </td>
                        <td class="text-center tbl_srl_6">
                            ' . $dep['fa_useful_life_year'] . '
                        </td>
                        <td class="text-right tbl_srl_6">
                            ' . number_format($depPercentage, 6) . '
                        </td>
                        <td class="text-center tbl_srl_6">
                            ' . $methodName . '
                        </td>
                        <td class="text-right tbl_srl_13">
                            ' . number_format($accDepAssetAccountBalance, 2) . '
                        </td>
                        <td class="text-right tbl_srl_6">
                            ' . number_format($monthlyDepExp, 2) . '
                        </td>
                        <td class="text-right tbl_srl_10">
                            ' . number_format($accDepAssetAccountBalance - $monthlyDepExp, 2) . '
                        </td>
                        <td class="text-right tbl_srl_10">
                            ' . number_format($newBookValue, 2) . '
                        </td>
                    </tr>
                ';

                $totalMonthlyDepExp += $monthlyDepExp;
            }

            $monthlyDepreciationHTMPReport .= '
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center tbl_txt_28">
                            Total Expense
                        </th>
                        <td colspan="6" class="text-right tbl_srl_10">

                        </td>
                        <td class="text-right tbl_srl_6">
                            ' . number_format($totalMonthlyDepExp, 2) . '
                        </td>
                        <td colspan="2" class="text-right tbl_srl_10">

                        </td>
                    </tr>
                </tfoot>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
            ';

            $monthDepExeStopTime = microtime(true);
            $monthlyDepreciationHTMPReport .= exeTimeDiv($monthDepExeStopTime - $monthDepExeStartTime);

            $monthlyDepreciationHTMPReport .= '
                <p class="info-well">
                    This is only view of calculation, Depreciation expense occur at the time of Month End Execution.
                </p>
            ';

        }

    }
}

/*
 *******************************************************************************************************************************
 *
 * Trial Balance Functions
 *
 * ******************************************************************************************************************************
 */
function trialHeadEntry($entry, $id, $disable) {
    $dr = $entry['type'] == 'DR' ? number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2) : "";
    $cr = $entry['type'] == 'CR' ? number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2) : "";
    $pointerClass = $disable ? "disabled" : "pointer";


    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="text-left tbl_txt_64 ' . $pointerClass . '">
                ' . $entry['name'] . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $dr . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $cr . '
            </th>
        </tr>
    ';
}

function trialAccountEntry($entry, $id) {
    $dr = $entry['type'] == 'DR' ? number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2) : "";
    $cr = $entry['type'] == 'CR' ? number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2) : "";
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger">
            <td class="text-left tbl_txt_64">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $dr . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $cr . '
            </td>
        </tr>
    ';
}

function trialEntry($entry, $id) {
    $child = $entry['child'];
    $childCounter = 0;

    $titleEntry = trialHeadEntry($entry, $id, count($child) == 0);
    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="3" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($entry['level'] === 3) {
                $childEntry .= trialAccountEntry($item, $item['code']);
            } else {
                $childEntry .= trialEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

//function trialDieWithError($title, $message, $header, $footer, $database) {
//    $database->close_connection();
//    return $header . '
//        <!-- Error Message with Title -->
//        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
//            <div class="invoice_cntnt_title_bx">
//                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
//                    ' . $title . '
//                </h2>
//            </div>
//            <p class="alert-well">
//                ' . $message . '
//            </p>
//        </section><!-- invoice content section end here -->
//    ' . $footer;
//}

/*
 *******************************************************************************************************************************
 *
 * Trial Balance
 *
 * ******************************************************************************************************************************
 */
$trialBalanceHTMLReport = '';

//if ($createTrial || ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($dailyCompleteReport) {
//    $createTrial = true;
if (!$error) {
    $trialExeStartTime = microtime(true);

    $totalAccounts = getCountOfTable("financials_accounts");

    $trialTotalDebit = 0;
    $trialTotalCredit = 0;
    $trialDifference = 0;

    $opLevelQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_level = 1;";
    $topLevelResult = $database->query($opLevelQuery);

    while ($topLevelData = $database->fetch_assoc($topLevelResult)) {

        $controlCode = $topLevelData['coa_code'];
        $controlName = $topLevelData['coa_head_name'];

        $trialViewList[$controlCode] =
            array('parent' => 0, 'code' => $controlCode, 'name' => "$controlName", 'level' => 1, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

        $parentQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_parent = $controlCode;";
        $parentResult = $database->query($parentQuery);


        while ($parentData = $database->fetch_assoc($parentResult)) {

            $parentCode = $parentData['coa_code'];
            $parentName = $parentData['coa_head_name'];


            $childAccounts = array();

            $trialViewList[$controlCode]['child'][$parentCode] =
                array('parent' => $controlCode, 'code' => $parentCode, 'name' => "$parentName", 'level' => 2, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

            $childQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_parent = $parentCode;";
            $childResult = $database->query($childQuery);

            while ($childData = $database->fetch_assoc($childResult)) {

                $childCode = $childData['coa_code'];
                $childName = $childData['coa_head_name'];
                $entryAccounts = array();

                // uncomment to view empty parent, child heads
//                    $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode] =
//                        array('parent' => $parentCode, 'code' => $childCode, 'name' => "$childName", 'level' => 3, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

                $entryQuery = "SELECT
                                    account_uid, account_name,
                                    account_today_opening_type, account_today_opening, account_today_debit, account_today_credit,
                                    account_monthly_opening_type, account_monthly_opening, account_monthly_debit, account_monthly_credit
                                    FROM financials_accounts
                                    WHERE account_parent_code = $childCode";
                $entryResult = $database->query($entryQuery);


                while ($entryData = $database->fetch_assoc($entryResult)) {

                    $entryCode = $entryData['account_uid'];
                    $entryName = $entryData['account_name'];

                    $entryTodayOpeningType = $entryData['account_today_opening_type'];
                    $entryTodayOpeningBalance = $entryData['account_today_opening'];
                    $entryTodayDebit = $entryData['account_today_debit'];
                    $entryTodayCredit = $entryData['account_today_credit'];
                    $entryMonthlyOpeningType = $entryData['account_monthly_opening_type'];
                    $entryMonthlyOpeningBalance = $entryData['account_monthly_opening'];
                    $entryMonthlyDebit = $entryData['account_monthly_debit'];
                    $entryMonthlyCredit = $entryData['account_monthly_credit'];

                    $previousDRBalance = 0;
                    $previousCRBalance = 0;

                    $firstDayEndOfThisMonthId = 0;
                    $openingBalance = 0;
                    $openingBalanceType = "";

                    // get previous balance of each account
                    if ($currentDayEndId > 1) {
//                            if ($createPnL || $createBalanceSheet || $createPnlDistribution) {
                        if ($dailyCompleteReport) {
                            if ($entryTodayOpeningType == 'DR') {
                                $previousDRBalance = $entryTodayOpeningBalance;
                            } else if ($entryTodayOpeningType == 'CR') {
                                $previousCRBalance = $entryTodayOpeningBalance;
                            }
                        } else {
                            if ($entryMonthlyOpeningType == 'DR') {
                                $previousDRBalance = $entryMonthlyOpeningBalance;
                            } else if ($entryMonthlyOpeningType == 'CR') {
                                $previousCRBalance = $entryMonthlyOpeningBalance;
                            }
                        }
                    }


                    /*if ($currentDayEndId > 1) {

                        if ($createPnL || $createBalanceSheet || $createPnlDistribution) {
                            $previousAccountOCEntry = getAccountOpeningClosingBalanceFrom($entryCode, $lastClosedDayEndId);
                            $opening = $previousAccountOCEntry;
                            if ($previousAccountOCEntry->found === true) {
                                $openingBalance = $opening->balance;
                                if ($previousAccountOCEntry->type == 'DR') {
                                    $previousDRBalance = $previousAccountOCEntry->balance;
                                } else if ($previousAccountOCEntry->type == 'CR') {
                                    $previousCRBalance = $previousAccountOCEntry->balance;
                                }

//                                } else {
//                                    $dieReport = trialDieWithError("Opening Balance Error", "Opening balances of accounts not found!", $htmlHeader . $headerSection, $htmlFooter, $database);
//                                    die($dieReport);
                            }
                        } else {
                            $firstDateOfMonth = getFirstDayOfMonth($currentDayEndDate);
                            $firstDayEndOfThisMonthData = getDayEndWithDate($firstDateOfMonth);
                            if ($firstDayEndOfThisMonthData->found == true) {
                                $firstDayEndOfThisMonthId = $firstDayEndOfThisMonthData->id;

                                $previousAccountOCEntry = getAccountOpeningClosingBalanceFrom($entryCode, $firstDayEndOfThisMonthId);
                                $opening = $previousAccountOCEntry;
                                if ($previousAccountOCEntry->found === true) {
                                    $openingBalance = $opening->balance;
                                    if ($previousAccountOCEntry->type == 'DR') {
                                        $previousDRBalance = $previousAccountOCEntry->balance;
                                    } else if ($previousAccountOCEntry->type == 'CR') {
                                        $previousCRBalance = $previousAccountOCEntry->balance;
                                    }

                                } else {

                                    $dieReport .= trialDieWithError("Opening Balance Error", "Opening balances of accounts not found!", $htmlHeader . $headerSection, $htmlFooter, $database);

                                    die($dieReport);

                                }

                            } else {
                                $firstDayEndOfThisMonthData = getFirstDayEnd();
                                if ($firstDayEndOfThisMonthData->found == true) {
                                    $firstDayEndOfThisMonthId = $firstDayEndOfThisMonthData->id;

                                    $previousAccountOCEntry = getAccountOpeningClosingBalanceFrom($entryCode, $firstDayEndOfThisMonthId);
                                    $opening = $previousAccountOCEntry;
                                    if ($previousAccountOCEntry->found === true) {
                                        $openingBalance = $opening->balance;
                                        if ($previousAccountOCEntry->type == 'DR') {
                                            $previousDRBalance = $previousAccountOCEntry->balance;
                                        } else if ($previousAccountOCEntry->type == 'CR') {
                                            $previousCRBalance = $previousAccountOCEntry->balance;
                                        }

                                    } else {

                                        $dieReport .= trialDieWithError("Opening Balance Error", "Opening balances of accounts not found!", $htmlHeader . $headerSection, $htmlFooter, $database);

                                        die($dieReport);

                                    }

                                } else {

                                    $dieReport .= trialDieWithError("Opening Balance Error", "Opening balances of accounts not found, while getting the first day of this month!", $htmlHeader . $headerSection, $htmlFooter, $database);

                                    die($dieReport);

                                }
                            }
                        }

                    }*/

                    /*if ($createPnL || $createBalanceSheet || $createPnlDistribution) {
                        // today's debit, credit value of each account
                        $openingClosingBalancesQuery = "SELECT sum(bal_dr) as totalDebit, sum(bal_cr) as totalCredit
                                                        FROM financials_balances
                                                        WHERE bal_account_id = $entryCode AND bal_day_end_id = $currentDayEndId;";
                    } else {
                        // till today's debit, credit value of each account
                        $openingClosingBalancesQuery = "SELECT sum(bal_dr) as totalDebit, sum(bal_cr) as totalCredit
                                                        FROM financials_balances
                                                        WHERE bal_account_id = $entryCode AND (bal_day_end_id >= $firstDayEndOfThisMonthId AND bal_day_end_id <= $currentDayEndId);";
                    }*/

                    /*$openingClosingBalancesResult = $database->query($openingClosingBalancesQuery);
                    if ($openingClosingBalancesResult && $database->num_rows($openingClosingBalancesResult) > 0) {
                        $accountAmountDifference = $database->fetch_assoc($openingClosingBalancesResult);

                        $inwards = (double)$accountAmountDifference['totalDebit'];
                        $outwards = (double)$accountAmountDifference['totalCredit'];*/

//                        if ($createPnL || $createBalanceSheet || $createPnlDistribution) {
                    if ($dailyCompleteReport) {
                        $inwards = (double)$entryTodayDebit;
                        $outwards = (double)$entryTodayCredit;
                        $openingBalance = (double)$entryTodayOpeningBalance;
                        $openingBalanceType = $entryTodayOpeningType;
                    } else {
                        $inwards = (double)$entryMonthlyDebit;
                        $outwards = (double)$entryMonthlyCredit;
                        $openingBalance = (double)$entryMonthlyOpeningBalance;
                        $openingBalanceType = $entryMonthlyOpeningType;
                    }

                    $totalDr = 0;
                    $totalCr = 0;


                    if ($entryCode == $stockAccountUID) {
                        if ($currentDayEndId == 1) {
                            $stockOpeningBalance = getAccountOpeningBalance($stockAccountUID);
                            if ($stockOpeningBalance->found === true) {
                                if ($stockOpeningBalance->balance != 0) {
                                    if ($stockOpeningBalance->type == 'DR') {
                                        $totalDr = $stockOpeningBalance->balance;
                                    } else if ($stockOpeningBalance->type == 'CR') {
                                        $totalDr = $stockOpeningBalance->balance;
                                    }
                                }
                            }
                        } else {

                            if ($dailyCompleteReport) {
                                $totalDr = (double)$previousDRBalance;
                                $totalCr = (double)$previousCRBalance;

                            } else {
                                if ($entryMonthlyOpeningType != '' && $entryMonthlyOpeningBalance != 0) {
                                    $totalDr = (double)$previousDRBalance;
                                    $totalCr = (double)$previousCRBalance;
                                } else {
                                    $stockOpeningBalance = getAccountOpeningBalance($stockAccountUID);
                                    if ($stockOpeningBalance->found === true) {
                                        if ($stockOpeningBalance->balance != 0) {
                                            if ($stockOpeningBalance->type == 'DR') {
                                                $totalDr = $stockOpeningBalance->balance;
                                            } else if ($stockOpeningBalance->type == 'CR') {
                                                $totalDr = $stockOpeningBalance->balance;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        $totalDr = $inwards + (double)$previousDRBalance;
                        $totalCr = $outwards + (double)$previousCRBalance;
                    }

//                        if ($currentDayEndId > 1 && $entryCode == $stockAccountUID) {
//                            $totalDr = (double)$previousDRBalance;
//                            $totalCr = (double)$previousCRBalance;
//                        } else {
//                            $totalDr = $inwards + (double)$previousDRBalance;
//                            $totalCr = $outwards + (double)$previousCRBalance;
//                        }

                    $balanceType = "";
                    $balanceBF = 0;

                    if ($totalDr > $totalCr) {

                        $balanceType = "DR";
                        $balanceBF = (double)abs($totalDr - $totalCr);

                    } else if ($totalDr < $totalCr) {

                        $balanceType = "CR";
                        $balanceBF = (double)abs($totalCr - $totalDr);

                    } else {
                        continue;
                    }


                    // stock opening balance
//                        if ($entryCode == $stockAccountUID) {
//
//                            if ($currentDayEndId == 1 || !$dailyCompleteReport) {
//
//                                $stockOpeningBalance = getAccountOpeningBalance($stockAccountUID);
//
//                                if ($stockOpeningBalance->found === true) {
//                                    if ($stockOpeningBalance->balance > 0) {
//
//                                        if ($stockOpeningBalance->type == 'DR') {
//
//                                            $balanceType = "DR";
//                                            $balanceBF = $stockOpeningBalance->balance;
//
//                                        } else if ($stockOpeningBalance->type == 'CR') {
//
//                                            $balanceType = "CR";
//                                            $balanceBF = $stockOpeningBalance->balance;
//
//                                        }
//
//                                    } else {
//
//                                        $balanceType = "DR";
//                                        $balanceBF = 0;
//
//                                    }
//                                }
//
//                            } else {
//
//                                if ($previousDRBalance > 0) {
//
//                                    $balanceType = "DR";
//                                    $balanceBF = (double)$previousDRBalance;
//
//                                } else if ($previousCRBalance > 0) {
//
//                                    $balanceType = "CR";
//                                    $balanceBF = (double)$previousCRBalance;
//
//                                }
//
//                            }
//                        }
//                        }

                    // fixed accounts value for PnL
                    switch ($entryCode) {
                        case $salesAccountUID:
                            $totalSalesValue = (double)$balanceBF;
                            break;
                        case $saleReturnAccountUID:
                            $totalSalesReturnValue = (double)$balanceBF;
                            break;
                        case $purchaseAccountUID:
                            $totalPurchaseValue = (double)$balanceBF;
                            break;
                        case $purchaseReturnAccountUID:
                            $totalPurchaseReturnValue = (double)$balanceBF;
                            break;
                        case $stockAccountUID:
                            $openingStockBalance = (double)$balanceBF;
                            break;
                        case $claimIssueAccountUID:
                            $claimIssueValue = (double)$balanceBF;
                            break;
                        case $claimReceivedAccountUID:
                            $claimReceivedValue = (double)$balanceBF;
                            break;
                    }

                    // uncomment to view empty parent, child heads
//                        $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode]['child'][$entryCode] =
//                            array('parent' => $childCode, 'code' => $entryCode, 'name' => "$entryName", 'level' => 4, 'type' => $balanceType, 'opening' => $opening, 'inwards' => $inwards, 'outwards' => $outwards, 'balance' => $balanceBF);

                    // comment to view empty parent, child heads
                    $entryAccounts[$entryCode] =
                        array('parent' => $childCode, 'code' => $entryCode, 'name' => "$entryName", 'level' => 4, 'type' => $balanceType, 'opening' => $openingBalance, 'inwards' => $inwards, 'outwards' => $outwards, 'balance' => $balanceBF);

                }

                // comment to view empty parent, child heads
                if (count($entryAccounts) > 0) {
                    $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode] =
                        array('parent' => $parentCode, 'code' => $childCode, 'name' => "$childName", 'level' => 3, 'child' => array(), 'type' => '', 'opening' => 0.00, 'inwards' => 0.00, 'outwards' => 0.00, 'balance' => 0.00);

                    $trialViewList[$controlCode]['child'][$parentCode]['child'][$childCode]['child'] = $entryAccounts;
                }

            }

            // comment to view empty parent, child heads
            if (count($trialViewList[$controlCode]['child'][$parentCode]['child']) == 0) {
                unset($trialViewList[$controlCode]['child'][$parentCode]);
            }

        }
    }
//print_r($trialViewList);
//        exit();
    /*
     * Calculate balances upwards
     */

    foreach ($trialViewList as $entry) {

        $entryCode = $entry['code'];
        $child = $entry['child'];
        $entry2Balance = 0;
        $entry2Type = '';

        foreach ($child as $entry2) {

            $entry2Code = $entry2['code'];
            $child2 = $entry2['child'];
            $entry3Balance = 0;
            $entry3Type = '';

            foreach ($child2 as $entry3) {

                $entry3Code = $entry3['code'];
                $child3 = $entry3['child'];
                $entry4Opening = 0;
                $entry4Inwards = 0;
                $entry4Outwards = 0;
                $entry4Balance = 0;
                $entry4Type = '';

                foreach ($child3 as $entry4) {

                    if ($entryCode == $assetsTopLevelUID || $entryCode == $expensesTopLevelUID) {

                        if ($entry4['type'] == 'DR') {
                            $entry4Balance += (double)$entry4['balance'];
                        } else {
                            $entry4Balance -= (double)$entry4['balance'];
                        }
                        if ($entry4Balance >= 0) {
                            $entry4Type = 'DR';
                        } else {
                            $entry4Type = 'CR';
                        }
                    } else {
                        if ($entry4['type'] == 'DR') {
                            $entry4Balance -= (double)$entry4['balance'];
                        } else {
                            $entry4Balance += (double)$entry4['balance'];
                        }
                        if ($entry4Balance >= 0) {
                            $entry4Type = 'CR';
                        } else {
                            $entry4Type = 'DR';
                        }
                    }

                    $entry4Opening += (double)$entry4['opening'];
                    $entry4Inwards += (double)$entry4['inwards'];
                    $entry4Outwards += (double)$entry4['outwards'];

                }

                $entry4Balance = abs($entry4Balance);
                $trialViewList[$entryCode]['child'][$entry2Code]['child'][$entry3Code]['opening'] = $entry4Opening;
                $trialViewList[$entryCode]['child'][$entry2Code]['child'][$entry3Code]['inwards'] = $entry4Inwards;
                $trialViewList[$entryCode]['child'][$entry2Code]['child'][$entry3Code]['outwards'] = $entry4Outwards;
                $trialViewList[$entryCode]['child'][$entry2Code]['child'][$entry3Code]['balance'] = $entry4Balance;
                $trialViewList[$entryCode]['child'][$entry2Code]['child'][$entry3Code]['type'] = $entry4Type;

                if ($entryCode == $assetsTopLevelUID || $entryCode == $expensesTopLevelUID) {
                    if ($entry4Type == 'DR') {
                        $entry3Balance += $entry4Balance;
                    } else {
                        $entry3Balance -= $entry4Balance;
                    }
                    if ($entry3Balance >= 0) {
                        $entry3Type = 'DR';
                    } else {
                        $entry3Type = 'CR';
                    }
                } else {
                    if ($entry4Type == 'DR') {
                        $entry3Balance -= $entry4Balance;
                    } else {
                        $entry3Balance += $entry4Balance;
                    }
                    if ($entry3Balance >= 0) {
                        $entry3Type = 'CR';
                    } else {
                        $entry3Type = 'DR';
                    }
                }
            }

            $entry3Balance = abs($entry3Balance);
            $trialViewList[$entryCode]['child'][$entry2Code]['balance'] = $entry3Balance;
            $trialViewList[$entryCode]['child'][$entry2Code]['type'] = $entry3Type;

            if ($entryCode == $assetsTopLevelUID || $entryCode == $expensesTopLevelUID) {
                if ($entry3Type == 'DR') {
                    $entry2Balance += $entry3Balance;
                } else {
                    $entry2Balance -= $entry3Balance;
                }
                if ($entry2Balance >= 0) {
                    $entry2Type = 'DR';
                } else {
                    $entry2Type = 'CR';
                }
            } else {
                if ($entry3Type == 'DR') {
                    $entry2Balance -= $entry3Balance;
                } else {
                    $entry2Balance += $entry3Balance;
                }
                if ($entry2Balance >= 0) {
                    $entry2Type = 'CR';
                } else {
                    $entry2Type = 'DR';
                }
            }

        }

        $entry2Balance = abs($entry2Balance);
        $trialViewList[$entryCode]['balance'] = $entry2Balance;
        $trialViewList[$entryCode]['type'] = $entry2Type;

        if ($entry2Type == 'DR') {
            $trialTotalDebit += $entry2Balance;
        } else {
            $trialTotalCredit += $entry2Balance;
        }
    }

    $trialBalanceHTMLReport .= '

            <!-- Trial Balance -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">

                        Trial Balance '.$trialType.' <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(1, this);"/></span>
                    </h2>
                </div>
                <table id="trial" class="table day_end_table">
                    <thead>
                        <tr>
                            <th class="text-left tbl_txt_64">
                                Accounts
                            </th>
                            <th class="text-center tbl_srl_18">
                                Debit
                            </th>
                            <th class="text-center tbl_srl_18">
                                Credit
                            </th>
                        </tr>
                        </thead>
                        <tbody>
        ';

    foreach ($trialViewList as $entry) {
        $trialBalanceHTMLReport .= trialEntry($entry, strtolower($entry['name']));
    }

    $trialBalanceHTMLReport .= '
            </tbody>
                    <tfoot>
                    <tr class="day_end_table_ttl">
                        <th>
                            Total
                        </th>
                        <td class="text-right tbl_srl_18">
                            ' . number_format($trialTotalDebit, 2) . '
                        </td>
                        <td class="text-right tbl_srl_18">
                            ' . number_format($trialTotalCredit, 2) . '
                        </td>
                    </tr>
                    </tfoot>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

    $trialExeStopTime = microtime(true);
    $trialBalanceHTMLReport .= exeTimeDiv($trialExeStopTime - $trialExeStartTime, "Execution Time  of " . number_format($totalAccounts, 0) . " Accounts: ");

    $trialDifference = abs((double)number_format($trialTotalDebit, 2, '.', '') - (double)number_format($trialTotalCredit, 2, '.', ''));
//        $trialDifference = abs(round(floor($trialTotalDebit)) - round(floor($trialTotalCredit)));

    if ($trialDifference > 0) {
        $diffErr = "Trial Balance is not equal, Difference amount is: <strong> " . number_format($trialDifference, 2) . " </strong> Please contact to your admin to adjust this amount. Trial must be Equal for Day End procedure!";
        $trialBalanceHTMLReport .= shortError($diffErr);
        $error = true;
    }

}
//}

/*
 *******************************************************************************************************************************
 *
 * Closing Stock
 *
 * ******************************************************************************************************************************
 */
$stockValuesHTMLReport = '';

//if ($creatClosingStock || ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($dailyCompleteReport) {
//    $creatClosingStock = true;
if (!$error) {
    $stockExeStartTime = microtime(true);

    $totalProducts = getCountOfTable("financials_products");

    $stockAtPurchaseRate = getEndingInventoryOfPurchaseRateNew();
    $stockAtAverageRate = getEndingInventoryOfNetRateNew();

//    $closingStockBalance = (double)$stockAtPurchaseRate;
    $closingStockBalance = (double)$stockAtAverageRate;

    $stockValuesHTMLReport .= '
        <!-- Closing Stock -->
        <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
            <div class="invoice_cntnt_title_bx">
                <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                    Closing Stock
                </h2>
            </div>
            <table class="table day_end_table">
                <thead>
                <tr>
                    <th class="text-left tbl_txt_80">
                        Stock Value
                    </th>
                    <th class="text-center tbl_srl_20">
                        Amount
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="normalHover">
                    <td class="text-left tbl_txt_59">
                        At Last Purchase Rate
                    </td>
                    <td class="text-right tbl_srl_20">
                        ' . number_format($stockAtPurchaseRate, 2) . '
                    </td>
                </tr>
                <tr class="normalHover">
                    <td class="text-left tbl_txt_59">
                        At Average Rate
                    </td>
                    <td class="text-right tbl_srl_20">
                        ' . number_format($stockAtAverageRate, 2) . '
                    </td>
                </tr>
                </tbody>
            </table><!-- table end -->
        </section><!-- invoice content section end here -->
    ';

    $stockExeStopTime = microtime(true);
    $stockValuesHTMLReport .= exeTimeDiv($stockExeStopTime - $stockExeStartTime, "Execution Time  of " . number_format($totalProducts, 0) . " Products: ");
}
//}

/*
 *******************************************************************************************************************************
 *
 * Cash/Bank Account Balances Functions
 *
 * ******************************************************************************************************************************
 */
function cashFlowHeadEntry($entry, $id, $disable) {
    $pointerClass = $disable ? "disabled" : "pointer";
    $balance = $entry['type'] == "DR" ? number_format($entry['balance'], 2) : "(" . number_format($entry['balance'], 2) . ")";
    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="text-left tbl_txt_28 ' . $pointerClass . '">
                ' . $entry['name'] . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . number_format($entry['opening'], 2) . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . number_format($entry['inwards'], 2) . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . number_format($entry['outwards'], 2) . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $balance . '
            </th>
        </tr>
    ';
}

function cashFlowAccountEntry($entry, $id) {
    $balance = $entry['type'] == "DR" ? number_format($entry['balance'], 2) : "(" . number_format($entry['balance'], 2) . ")";
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger">
            <td class="text-left tbl_txt_28">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . number_format($entry['opening'], 2) . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . number_format($entry['inwards'], 2) . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . number_format($entry['outwards'], 2) . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $balance . '
            </td>
        </tr>
    ';
}

function cashFlowEntry($entry, $id) {
    $child = $entry['child'];

    $titleEntry = cashFlowHeadEntry($entry, $id, count($child) == 0);
    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="5" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childEntry .= cashFlowAccountEntry($item, $item['code']);
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

/*
 *******************************************************************************************************************************
 *
 * Cash/Bank Account Balances
 *
 * ******************************************************************************************************************************
 */
$cashFlowStatementHTMLReport = '';

//if ($createTrial && $createCashBankOpeningClosing) {
//if ($dailyCompleteReport) {
if (!$error) {
    $cashFlowExeStartTime = microtime(true);

    $cashFlowStatementHTMLReport .= '
            <!-- Cash/Bank Account Balances -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        Cash/Bank Account Balances <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(2, this);"/></span>
                    </h2>
                </div>
                <table id="cash" class="table day_end_table">
                    <thead>
                    <tr>
                        <th class="text-left tbl_txt_28">
                            Account Title
                        </th>
                        <th class="text-center tbl_srl_18">
                            Opening
                        </th>
                        <th class="text-center tbl_srl_18">
                            Inwards
                        </th>
                        <th class="text-center tbl_srl_18">
                            Outwards
                        </th>
                        <th class="text-center tbl_srl_18">
                            Closing
                        </th>
                    </tr>
                    </thead>
                    <tbody>
        ';

    $cashEntryFound = false;
    $bankEntryFound = false;

    if (array_key_exists(CURRENT_ASSET_GROUP_UID, $trialViewList[ASSETS]['child'])) {
        if (array_key_exists(CASH_PARENT_UID, $trialViewList[ASSETS]['child'][CURRENT_ASSET_GROUP_UID]['child'])) {
            $cashEntries = $trialViewList[ASSETS]['child'][CURRENT_ASSET_GROUP_UID]['child'][CASH_PARENT_UID];
            $cashFlowStatementHTMLReport .= cashFlowEntry($cashEntries, "cf-" . strtolower($cashEntries['name']));
            $cashEntryFound = true;
        }
    }


    if (array_key_exists(CURRENT_ASSET_GROUP_UID, $trialViewList[ASSETS]['child'])) {
        if (array_key_exists(BANK_PARENT_UID, $trialViewList[ASSETS]['child'][CURRENT_ASSET_GROUP_UID]['child'])) {
            $bankEntries = $trialViewList[ASSETS]['child'][CURRENT_ASSET_GROUP_UID]['child'][BANK_PARENT_UID];
            $cashFlowStatementHTMLReport .= cashFlowEntry($bankEntries, "cf-" . strtolower($bankEntries['name']));
            $bankEntryFound = true;
        }
    }

    if (!$cashEntryFound && !$bankEntryFound) {
        $cashFlowStatementHTMLReport .= '
                <tr>
                    <td colspan="5" class="text-center tbl_txt_28">
                        No Cash or Bank account\'s Opening, Inwards, Outwards and Closing found!
                    </td>
                </tr>
            ';
    }

    $cashFlowStatementHTMLReport .= '
            </tbody>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

    $cashFlowExeStopTime = microtime(true);
    $cashFlowStatementHTMLReport .= exeTimeDiv($cashFlowExeStopTime - $cashFlowExeStartTime);
}
//}

/*
 *******************************************************************************************************************************
 *
 * Income Statement functions
 *
 * ******************************************************************************************************************************
 */
function pnlHeadEntry($entry, $id, $disable, $negative = false) {
    $pointerClass = $disable ? "disabled" : "pointer";
    $amount = number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2);
    if ($negative) $amount = "(" . $amount . ")";
    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="text-left tbl_txt_46 ' . $pointerClass . '">
                ' . $entry['name'] . '
            </th>
            <th class="text-right tbl_srl_18">

            </th>
            <th class="text-right tbl_srl_18">

            </th>
            <th class="text-right tbl_srl_18">
                ' . $amount . '
            </th>
        </tr>
    ';
}

function pnlHeadLikeEntry($entry, $id, $disable, $amountColumn, $negative = false) {
    $pointerClass = $disable ? "disabled" : "pointer";
    $amount = number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2);
    if ($negative) $amount = "(" . $amount . ")";
    $amount1 = $amountColumn == 1 ? $amount : "";
    $amount2 = $amountColumn == 2 ? $amount : "";
    $amount3 = $amountColumn == 3 ? $amount : "";
    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="text-left tbl_txt_46 ' . $pointerClass . '">
                ' . $entry['name'] . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $amount1 . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $amount2 . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $amount3 . '
            </th>
        </tr>
    ';
}

function pnlAccountEntry($entry, $id, $negative = false) {
    $amount = number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2);
    if ($negative) $amount = "(" . $amount . ")";
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger">
            <td class="text-left tbl_txt_46">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">

            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount . '
            </td>
            <td class="text-right tbl_srl_18">

            </td>
        </tr>
    ';
}

function pnlAccountLikeEntry($entry, $id, $amountColumn, $negative = false) {
    $amount = number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2);
    if ($negative) $amount = "(" . $amount . ")";
    $amount1 = $amountColumn == 1 ? $amount : "";
    $amount2 = $amountColumn == 2 ? $amount : "";
    $amount3 = $amountColumn == 3 ? $amount : "";
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger">
            <td class="text-left tbl_txt_46">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount1 . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount2 . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount3 . '
            </td>
        </tr>
    ';
}

function pnlAccountLikeNoLinkEntry($entry, $id, $amountColumn, $negative = false) {
    $amount = number_format($entry['balance'] == '' ? 0 : $entry['balance'], 2);
    if ($negative) $amount = "(" . $amount . ")";
    $amount1 = $amountColumn == 1 ? $amount : "";
    $amount2 = $amountColumn == 2 ? $amount : "";
    $amount3 = $amountColumn == 3 ? $amount : "";
    return '
        <tr data-uid="' . $entry['code'] . '" data-ledgerId="' . $id . '" class="normalHover">
            <td class="text-left tbl_txt_46">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount1 . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount2 . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount3 . '
            </td>
        </tr>
    ';
}

function pnlSalesEntry($entry, $id) {
    $child = $entry['child'];
    $childCounter = 0;

    if (startsWith($entry['code'], SALES_TRADE_DISCOUNT_PARENT_UID)) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 2, true);
    } else {
        $titleEntry = pnlHeadEntry($entry, $id, count($child) == 0);
    }

    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="4" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($item['level'] === 4) {
                if (startsWith($item['code'], SALES_TRADE_DISCOUNT_PARENT_UID)) {
                    $childEntry .= pnlAccountLikeEntry($item, $item['code'], 1);
                } else {
                    $childEntry .= pnlAccountEntry($item, $item['code'], $item['code'] == SALE_RETURN_ACCOUNT_UID);
                }
            } else {
                $childEntry .= pnlSalesEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

function pnlCGSEntry($entry, $id) {
    $child = $entry['child'];
    $childCounter = 0;

    if (startsWith($entry['code'], 120) || startsWith($entry['code'], CGS_EXPENSE_GROUP_UID)) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 2);
    } else {
        $titleEntry = pnlHeadEntry($entry, $id, count($child) == 0, ($entry['level'] == 2 && $entry['code'] == 0));
    }

    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="4" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($item['level'] === 4) {
                if (startsWith($item['code'], PURCHASER_PARENT_UID) || startsWith($item['code'], CLAIMS_ACCOUNTS_PARENT_UID) || startsWith($entry['code'], CGS_EXPENSE_GROUP_UID)) {
                    $childEntry .= pnlAccountLikeEntry($item, $item['code'], 1, ($item['code'] == PURCHASE_RETURN_ACCOUNT_UID || $item['code'] == CLAIM_ISSUE_ACCOUNT_UID));
                } else {
                    $childEntry .= pnlAccountEntry($item, $item['code'], $item['name'] == 'Closing Stock');
                }
            } else {
                $childEntry .= pnlCGSEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

function pnlExpEntry($entry, $id) {

    if ($entry['code'] == CGS_EXPENSE_GROUP_UID || $entry['code'] == SALES_TRADE_DISCOUNT_PARENT_UID) return "";

    $child = $entry['child'];
    $childCounter = 0;
    $titleEntry = '';

    if ($entry['level'] == 1) {
        $titleEntry = pnlHeadEntry($entry, $id, count($child) == 0, true);
    } elseif ($entry['level'] == 2) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 2, $entry['type'] == 'CR');
    } elseif ($entry['level'] == 3) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 1, $entry['type'] == 'CR');
    }

    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="4" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($item['level'] === 4) {
                $childEntry .= pnlAccountLikeEntry($item, $item['code'], 1, $item['type'] == 'CR');
            } else {
                $childEntry .= pnlExpEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

function pnlRevEntry($entry, $id) {

    if ($entry['code'] == CGS_EXPENSE_GROUP_UID || $entry['code'] == SALES_TRADE_DISCOUNT_PARENT_UID) return "";

    $child = $entry['child'];
    $childCounter = 0;
    $titleEntry = '';

    if ($entry['level'] == 1) {
        $titleEntry = pnlHeadEntry($entry, $id, count($child) == 0);
    } elseif ($entry['level'] == 2) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 2, $entry['type'] == 'DR');
    } elseif ($entry['level'] == 3) {
        $titleEntry = pnlHeadLikeEntry($entry, $id, count($child) == 0, 1, $entry['type'] == 'DR');
    }

    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="4" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($item['level'] === 4) {
                $childEntry .= pnlAccountLikeEntry($item, $item['code'], 1, $item['type'] == 'DR');
            } else {
                $childEntry .= pnlRevEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

/*
 *******************************************************************************************************************************
 *
 * Income Statement
 *
 * ******************************************************************************************************************************
 */
$incomeStatementHTMLReport = '';
$netProfitOrLoss = 'Profit';
$netProfitOrLossAmount = 0;
$netProfitOrLossAbsoluteAmount = 0;

$NET_SALES_CODE = 11;
$CGS_CODE = 12;
$CGS_PURCHASES_CODE = 120; // change to cgsEntry function also
$GROSS_REVENUE_CODE = 13;
$NET_OPERATING_INCOME_CODE = 14;

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
if ($dailyCompleteReport) {
    if (!$error) {
        $pnlExeStartTime = microtime(true);

        $incomeStatementHTMLReport .= '
            <!-- Income Statement -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        Income Statement <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(3, this);"/></span>
                    </h2>
                </div>
                <table id="pnl" class="table day_end_table">
                    <tbody>
        ';


        // sales entry
        $pnlSalesChildList = array();
        $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => $salesAccountUID, 'name' => "Sales", 'level' => 4, 'balance' => $totalSalesValue);
        $pnlSalesChildList[] = array('parent' => $NET_SALES_CODE, 'code' => $saleReturnAccountUID, 'name' => "Sales Return", 'level' => 4, 'balance' => $totalSalesReturnValue);

        // trade discount entry
        $tradeDiscountChildEntryBalance = 0;

        if (array_key_exists(SALES_DISCOUNT_GROUP_UID, $trialViewList[EXPENSES]['child'])) {
            if (array_key_exists(SALES_TRADE_DISCOUNT_PARENT_UID, $trialViewList[EXPENSES]['child'][SALES_DISCOUNT_GROUP_UID]['child'])) {
                $tradeDiscountChildEntry = $trialViewList[EXPENSES]['child'][SALES_DISCOUNT_GROUP_UID]['child'][SALES_TRADE_DISCOUNT_PARENT_UID];
                $tradeDiscountChildEntry['parent'] = $NET_SALES_CODE;
                $pnlSalesChildList[] = $tradeDiscountChildEntry;
                $tradeDiscountChildEntryBalance = $tradeDiscountChildEntry['balance'];
            }
        }

        $netSalesValue = $netSalesValue = ($totalSalesValue - $totalSalesReturnValue - $tradeDiscountChildEntryBalance);

        $pnlSalesEntryList = array('parent' => 0, 'code' => $NET_SALES_CODE, 'name' => "Net Sales", 'level' => 2, 'child' => $pnlSalesChildList, 'balance' => $netSalesValue);

        $incomeStatementHTMLReport .= pnlSalesEntry($pnlSalesEntryList, 'pnl-' . strtolower($pnlSalesEntryList['name']));


        // CGS entry
        $totalPurchases = $totalPurchaseValue - $totalPurchaseReturnValue;
        $totalClaims = $claimReceivedValue - $claimIssueValue;
        $totalCGSExpenses = 0;

        $cgsChildList = array();
        $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $stockAccountUID, 'name' => "Opening Stock", 'level' => 4, 'balance' => $openingStockBalance);

        $purchasesChildList = array();
        $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $purchaseAccountUID, 'name' => "Purchase", 'level' => 4, 'balance' => $totalPurchaseValue);
        $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $claimReceivedAccountUID, 'name' => "Claim Received", 'level' => 4, 'balance' => $claimReceivedValue);
        $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $purchaseReturnAccountUID, 'name' => "Purchase Return", 'level' => 4, 'balance' => $totalPurchaseReturnValue);
        $purchasesChildList[] = array('parent' => $CGS_PURCHASES_CODE, 'code' => $claimIssueAccountUID, 'name' => "Claim Issue", 'level' => 4, 'balance' => $claimIssueValue);

        $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $CGS_PURCHASES_CODE, 'name' => "Purchases", 'level' => 3, 'child' => $purchasesChildList, 'balance' => $totalPurchases + $totalClaims);

        $cgsExpenseChildList = array();

        if (array_key_exists(CGS_EXPENSE_GROUP_UID, $trialViewList[EXPENSES]['child'])) {
            $cgsExpensesParent = $trialViewList[EXPENSES]['child'][CGS_EXPENSE_GROUP_UID]['child'];

            foreach ($cgsExpensesParent as $cgsExp) {
                $child = $cgsExp['child'];
                foreach ($child as $exp) {
                    if ($exp['code'] == $purchaseAccountUID || $exp['code'] == $purchaseReturnAccountUID || $exp['code'] == $claimReceivedAccountUID || $exp['code'] == $claimIssueAccountUID) {
                        continue;
                    }
                    $cgsExpenseChildList[] = $exp;
                    $totalCGSExpenses += $exp['balance'];
                }
            }

            if (count($cgsExpenseChildList) > 0) {
                $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => CGS_EXPENSE_GROUP_UID, 'name' => "CGS Expenses", 'level' => 3, 'child' => $cgsExpenseChildList, 'balance' => $totalCGSExpenses);
            }

        }


        $cgsChildList[] = array('parent' => $CGS_CODE, 'code' => $stockAccountUID, 'name' => "Closing Stock", 'level' => 4, 'balance' => $closingStockBalance);

        $totalCGSValue = (($openingStockBalance + ($totalPurchases + $totalClaims + $totalCGSExpenses)) - $closingStockBalance);

        $pnlCGSEntryList = array('parent' => 0, 'code' => $CGS_CODE, 'name' => "CGS (Cost of Goods Sold) ", 'level' => 2, 'child' => $cgsChildList, 'balance' => $totalCGSValue);

        $incomeStatementHTMLReport .= pnlCGSEntry($pnlCGSEntryList, 'cgs-' . strtolower($pnlCGSEntryList['name']));


        // gross revenue entry
        $grossRevenueValue = $netSalesValue - $totalCGSValue;

        $grossRevenueEntry = array('parent' => 0, 'code' => $GROSS_REVENUE_CODE, 'name' => "Gross Revenue", 'level' => 4, 'balance' => $grossRevenueValue);

        $incomeStatementHTMLReport .= pnlAccountLikeNoLinkEntry($grossRevenueEntry, strtolower($grossRevenueEntry['name']), 3);


        // expenses
        $totalExpenses = 0;

        $pnlExpensesList = $trialViewList[EXPENSES];
        $pnlTempExpensesBalance = $trialViewList[EXPENSES]['balance'];
        $pnlTempExpensesBalanceType = $trialViewList[EXPENSES]['type'];
        $pnlTempCGSExpenseBalance = 0;
        $pnlTempSalesDiscountBalance = 0;
        $pnlTempTradeDiscountBalance = 0;

        if (array_key_exists(CGS_EXPENSE_GROUP_UID, $pnlExpensesList['child'])) {
            $pnlTempCGSExpenseBalance = $pnlExpensesList['child'][CGS_EXPENSE_GROUP_UID]['balance'];
            unset($pnlExpensesList['child'][CGS_EXPENSE_GROUP_UID]);
        }

        if (array_key_exists(SALES_DISCOUNT_GROUP_UID, $pnlExpensesList['child'])) {
            $pnlTempSalesDiscountBalance = $pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['balance'];
            if (array_key_exists(SALES_TRADE_DISCOUNT_PARENT_UID, $pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['child'])) {
                $pnlTempTradeDiscountBalance = $pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['child'][SALES_TRADE_DISCOUNT_PARENT_UID]['balance'];
                unset($pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['child'][SALES_TRADE_DISCOUNT_PARENT_UID]);
            }
            $pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['balance'] = $pnlTempSalesDiscountBalance - $pnlTempTradeDiscountBalance;
            if (count($pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]['child']) == 0) {
                unset($pnlExpensesList['child'][SALES_DISCOUNT_GROUP_UID]);
            }
        }

        if ($pnlTempExpensesBalanceType == 'CR') {
            $pnlTempExpensesBalance = $pnlTempExpensesBalance * -1;
        }

        $totalExpenses = $pnlTempExpensesBalance - $pnlTempCGSExpenseBalance - $pnlTempTradeDiscountBalance;
        $pnlExpensesList['balance'] = $totalExpenses;
        $pnlExpensesList['parent'] = 0;

        $incomeStatementHTMLReport .= pnlExpEntry($pnlExpensesList, 'pnl-' . strtolower($pnlExpensesList['name']));


        // net operating income
        $netOperatingIncome = $grossRevenueValue - $totalExpenses;

        $netOperatingIncomeEntry = array('parent' => 0, 'code' => $NET_OPERATING_INCOME_CODE, 'name' => "Net Operating Income", 'level' => 4, 'balance' => $netOperatingIncome);

        $incomeStatementHTMLReport .= pnlAccountLikeNoLinkEntry($netOperatingIncomeEntry, strtolower($netOperatingIncomeEntry['name']), 3);


        // other revenues
        $totalOtherRevenue = 0;

        $pnlOtherRevenueList = $trialViewList[REVENUES];
        $pnlOtherRevenueBalance = $trialViewList[REVENUES]['balance'];

        $pnlOtherRevenueSalesBalance = 0;
        $pnlOtherRevenueSalesReturnBalance = 0;

        if (array_key_exists(INCOME_FROM_SALES_GROUP_UID, $pnlOtherRevenueList['child'])) {
            if (array_key_exists(SALES_REVENUE_PARENT_UID, $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'])) {
                $tempSalesRevenueChildList = $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'][SALES_REVENUE_PARENT_UID]['child'];

                if (array_key_exists(SALES_ACCOUNT_UID, $tempSalesRevenueChildList)) {
                    $pnlOtherRevenueSalesBalance = $tempSalesRevenueChildList[SALES_ACCOUNT_UID]['balance'];
                    unset($tempSalesRevenueChildList[SALES_ACCOUNT_UID]);
                }

                if (array_key_exists(SALE_RETURN_ACCOUNT_UID, $tempSalesRevenueChildList)) {
                    $pnlOtherRevenueSalesReturnBalance = $tempSalesRevenueChildList[SALE_RETURN_ACCOUNT_UID]['balance'];
                    unset($tempSalesRevenueChildList[SALE_RETURN_ACCOUNT_UID]);
                }

                $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'][SALES_REVENUE_PARENT_UID]['child'] = $tempSalesRevenueChildList;


                // ***********************************
                $saleRevBal = $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'][SALES_REVENUE_PARENT_UID]['balance'];
                $saleRevBal -= ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
                $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'][SALES_REVENUE_PARENT_UID]['type'] = ($saleRevBal < 0) ? 'DR' : 'CR';
                $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['child'][SALES_REVENUE_PARENT_UID]['balance'] = abs($saleRevBal);
                // ***********************************


                // ***********************************
                $incomeFrmSaleBal = $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['balance'];
                $incomeFrmSaleBal -= ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
                $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['type'] = ($incomeFrmSaleBal < 0) ? 'DR' : 'CR';
                $pnlOtherRevenueList['child'][INCOME_FROM_SALES_GROUP_UID]['balance'] = abs($incomeFrmSaleBal);
                // ***********************************

            }
        }

        $totalOtherRevenue = $pnlOtherRevenueBalance - ($pnlOtherRevenueSalesBalance - $pnlOtherRevenueSalesReturnBalance);
        $pnlOtherRevenueList['balance'] = $totalOtherRevenue;
        $pnlOtherRevenueList['type'] = ($totalOtherRevenue < 0) ? 'DR' : 'CR';
        $pnlOtherRevenueList['parent'] = 0;

        $incomeStatementHTMLReport .= pnlRevEntry($pnlOtherRevenueList, 'pnl-' . strtolower($pnlOtherRevenueList['name']));

        // net profit / loss
        $netProfitOrLossAmount = $netOperatingIncome + $totalOtherRevenue;
        $netProfitOrLossAbsoluteAmount = abs($netProfitOrLossAmount);

        $netProfitOrLossAmount = number_format($netProfitOrLossAmount, 2, '.', '');
        $netProfitOrLossAbsoluteAmount = number_format($netProfitOrLossAbsoluteAmount, 2, '.', '');

        $lossColorClass = '';
        if ($netProfitOrLossAmount < 0) {
            $netProfitOrLoss = "Loss";
            $lossColorClass = 'loss';
        }

        $incomeStatementHTMLReport .= '
            </tbody>
                    <tfoot>
                        <tr class="day_end_table_ttl ' . $lossColorClass . '">
                            <th>
                                Net ' . $netProfitOrLoss . '
                            </th>
                            <td class="text-right tbl_srl_18">

                            </td>
                            <td class="text-right tbl_srl_18">

                            </td>
                            <td class="text-right tbl_srl_18">
                                ' . number_format($netProfitOrLossAbsoluteAmount, 2) . '
                            </td>
                        </tr>
                    </tfoot>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

        $pnlExeStopTime = microtime(true);
        $incomeStatementHTMLReport .= exeTimeDiv($pnlExeStopTime - $pnlExeStartTime);

        if ($netProfitOrLossAmount < 0) {
            $incomeStatementHTMLReport .= shortError("Sorry for your Loss!");
        }
    }
}

/*
 *******************************************************************************************************************************
 *
 * Balance Sheet functions
 *
 * ******************************************************************************************************************************
 */
function entryTypeAmount($entry) {
    $amount = '0.00';
    if (startsWith($entry['code'], ASSETS)) {
        if ($entry['type'] == 'DR') {
            $amount = number_format($entry['balance'], 2);
        } elseif ($entry['type'] == 'CR') {
            $amount = '(' . number_format($entry['balance'], 2) . ')';
        }
    } else {
//        print_r($entry);
        if ($entry['type'] == 'CR') { // Muzammil DR to CR
            $amount = '(' . number_format($entry['balance'], 2) . ')';
        } elseif ($entry['type'] == 'DR') { // Muzammil CR to DR
            $amount = number_format($entry['balance'], 2);
        }
    }
    return $amount;
}

function bsHeadEntry($entry, $id, $disable) {
    $amount = entryTypeAmount($entry);
    $pointerClass = $disable ? "disabled" : "pointer";
    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="text-left tbl_txt_64 ' . $pointerClass . '">
                ' . $entry['name'] . '
            </th>
            <th class="text-right tbl_srl_18">
                ' . $amount . '
            </th>
            <th class="text-right tbl_srl_18">

            </th>
        </tr>
    ';
}

function bsAccountEntry($entry, $id) {
    $amount = entryTypeAmount($entry);
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger">
            <td class="text-left tbl_txt_64">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $amount . '
            </td>
            <td class="text-right tbl_srl_18">

            </td>
        </tr>
    ';
}

function bsEntry($entry, $id) {
    $child = $entry['child'];
    $childCounter = 0;

    $titleEntry = bsHeadEntry($entry, $id, count($child) == 0);
    $childEntry = "";

    if (count($child) > 0) {
        $childEntry .= '
                <tr class="setHeight heightZero" id="' . $id . '">
                        <td colspan="3" class="gnrl-mrgn-pdng">
                            <table class="table">
            ';
        foreach ($child as $item) {
            $childCounter++;
            if ($entry['level'] === 3) {
                $childEntry .= bsAccountEntry($item, $item['code']);
            } else {
                $childEntry .= bsEntry($item, $id . $childCounter);
            }
        }
        $childEntry .= '
                </table>
                        </td>
                    </tr>
            ';
    }

    return $titleEntry . $childEntry;
}

/*
 *******************************************************************************************************************************
 *
 * Balance Sheet
 *
 * ******************************************************************************************************************************
 */
$balanceSheetHTMLReport = '';

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
if ($dailyCompleteReport) {
    if (!$error) {
        $bsExeStartTime = microtime(true);

        $balanceSheetHTMLReport .= '
            <!-- Balance Sheet -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        Balance Sheet <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(4, this);"/></span>
                    </h2>
                </div>
                <table id="bs" class="table day_end_table">
                    <tbody>
        ';


        // assets
        $bsAssetBalance = 0;
        $bsAssetEntries = $trialViewList[ASSETS];

        $bsCurrentAssetBalance = 0;
        $bsStockChildBalance = 0;
        $bsStockEntryBalance = 0;
        $bsAssetBalance = $bsAssetEntries['balance'];
        if (array_key_exists(CURRENT_ASSET_GROUP_UID, $bsAssetEntries['child'])) {
            $bsCurrentAssetBalance = $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['balance'];
            if (array_key_exists(STOCK_PARENT_UID, $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'])) {
                $bsStockChildBalance = $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['balance'];
                if (array_key_exists(STOCK_ACCOUNT_UID, $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['child'])) {
                    $bsStockEntryBalance = $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['child'][STOCK_ACCOUNT_UID]['balance'];
                    // **********************************
                    $bsStockEntryBalance -= $openingStockBalance;
                    $bsStockEntryBalance += $closingStockBalance;

                    $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['child'][STOCK_ACCOUNT_UID]['balance'] = $bsStockEntryBalance;
                    $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['child'][STOCK_ACCOUNT_UID]['type'] = $bsStockEntryBalance < 0 ? 'CR' : 'DR';
                    // **********************************
                }
                // **********************************
                $bsStockChildBalance -= $openingStockBalance;
                $bsStockChildBalance += $closingStockBalance;

                $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['balance'] = $bsStockChildBalance;
                $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['child'][STOCK_PARENT_UID]['type'] = $bsStockChildBalance < 0 ? 'CR' : 'DR';
                // **********************************
            }
            // **********************************
            $bsCurrentAssetBalance -= $openingStockBalance;
            $bsCurrentAssetBalance += $closingStockBalance;

            $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['balance'] = $bsCurrentAssetBalance;
            $bsAssetEntries['child'][CURRENT_ASSET_GROUP_UID]['type'] = $bsCurrentAssetBalance < 0 ? 'CR' : 'DR';
            // **********************************
        }

        // **********************************
        $bsAssetBalance -= $openingStockBalance;
        $bsAssetBalance += $closingStockBalance;

        $bsAssetEntries['balance'] = $bsAssetBalance;
        $bsAssetEntries['type'] = $bsAssetBalance < 0 ? 'CR' : 'DR';
        // **********************************

        $balanceSheetHTMLReport .= bsEntry($bsAssetEntries, 'bs-' . strtolower($bsAssetEntries['name']));

        $balanceSheetHTMLReport .= '
            <tr class="normalHover">
                <th class="text-left tbl_txt_59">
                    Total Assets
                </th>
                <td class="text-right tbl_srl_18">

                </td>
                <th class="text-right tbl_srl_18 gnrl-bg">
                    ' . number_format($bsAssetBalance, 2) . '
                </th>
            </tr>
        ';


        // liability
        $bsLiabilityBalance = 0;
        $bsLiabilitiesEntries = $trialViewList[LIABILITIES];
//print_r($bsLiabilitiesEntries);
        $bsLiabilityBalance = $bsLiabilitiesEntries['balance'];
        $bsLiabilityBalanceType = $bsLiabilitiesEntries['type'];

        $balanceSheetHTMLReport .= bsEntry($bsLiabilitiesEntries, 'bs-' . strtolower($bsLiabilitiesEntries['name']));


        // equity
        $bsEquityBalance = 0;
        $bsEquityEntries = $trialViewList[EQUITY];

        $bsEquityBalance = $bsEquityEntries['balance'];

        $balanceSheetHTMLReport .= bsEntry($bsEquityEntries, 'bs-' . strtolower($bsEquityEntries['name']));


        // current profit / loss
        if ($netProfitOrLossAbsoluteAmount > 0) {
            $bsProfitLossAmount = $netProfitOrLoss == "Profit" ? number_format($netProfitOrLossAbsoluteAmount, 2) : "(" . number_format($netProfitOrLossAbsoluteAmount, 2) . ")";

            $balanceSheetHTMLReport .= '
                <tr class="normalHover">
                    <td class="text-left tbl_txt_59">
                        Current ' . $netProfitOrLoss . '
                    </td>
                    <td class="text-right tbl_srl_18">
                        ' . $bsProfitLossAmount . '
                    </td>
                    <td class="text-right tbl_srl_18">

                    </td>
                </tr>
            ';
        }


        if ($bsLiabilityBalanceType == 'CR') { // Muzammil DR to CR
//            $bsLiabilityBalance = $bsLiabilityBalance * (-1); // Comented by Muzammil
        }
// echo $bsLiabilityBalance ."+". $bsEquityBalance ."+".$netProfitOrLossAmount;
        // total liability + equity
        $bsTotalLiabilityEquityPnLBalance = $bsLiabilityBalance + $bsEquityBalance + $netProfitOrLossAmount;

        $bsTotalLiabilityEquityPnLBalanceDisplay=0; // mustafa
        if($bsTotalLiabilityEquityPnLBalance > 0){$bsTotalLiabilityEquityPnLBalanceDisplay= number_format($bsTotalLiabilityEquityPnLBalance,2);}else{$abc =abs
        ($bsTotalLiabilityEquityPnLBalance);
            $bsTotalLiabilityEquityPnLBalanceDisplay='('.number_format($abc,2).')';
        }
        $balanceSheetHTMLReport .= '
            <tr class="normalHover">
                <th class="text-left tbl_txt_59">
                    Total (Liabilities + Equity)
                </th>
                <td class="text-right tbl_srl_18">

                </td>
                <th class="text-right tbl_srl_18 gnrl-bg">
                    ' . $bsTotalLiabilityEquityPnLBalanceDisplay . '
                </th>
            </tr>
        ';

        $balanceSheetHTMLReport .= '
            </tbody>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

        $bsExeStopTime = microtime(true);
        $balanceSheetHTMLReport .= exeTimeDiv($bsExeStopTime - $bsExeStartTime);

        $bsDiff = abs((double)number_format($bsAssetBalance, 2, '.', '') - (double)number_format($bsTotalLiabilityEquityPnLBalance, 2, '.', '')); // Muzammil Added + instead of -

        if ($bsDiff > 0) {
            $diffErr = "Balance Sheet is not equal, Difference amount is: <strong> " . number_format($bsDiff, 2) . " </strong> Please contact to your admin to adjust this amount. Balance Sheet must be Equal for Day End procedure!";
            $balanceSheetHTMLReport .= shortError($diffErr);
            $error = true;
        }

    }
}

/*
 *******************************************************************************************************************************
 *
 * Profit Distribution
 *
 * ******************************************************************************************************************************
 */
$profitLossDistributionHTMLReport = '';

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
if ($dailyCompleteReport) {
    if (!$error && $netProfitOrLossAbsoluteAmount > 0) {
        $profitDisExeStartTime = microtime(true);

        $profitLossDistributionHTMLReport .= '
            <!-- Profit Distribution -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        ' . $netProfitOrLoss . ' Distribution
                        <span class="gnrl-mrgn-pdng gnrl-blk">
                        </span>
                    </h2>
                </div>
                <table class="table day_end_table">
                    <thead>
                    <tr>
                        <th class="text-left tbl_txt_13">
                            User
                        </th>
                        <th class="text-center tbl_srl_18">
                            Capital
                        </th>
                        <th class="text-center tbl_srl_6">
                            Actual %
                        </th>
                        <th class="text-center tbl_srl_6">
                            Fxd. Profit %
                        </th>
                        <th class="text-center tbl_srl_6">
                            Fxd. Loss %
                        </th>
                        <th class="text-center tbl_srl_6">
                            ' . $netProfitOrLoss . ' Amount
                        </th>
                        <th class="text-center tbl_srl_6">
                            Plus
                        </th>
                        <th class="text-center tbl_srl_18">
                            Total
                        </th>
                    </tr>
                    </thead>
                    <tbody>
        ';


        $ACTIVE_PARTNER = 1;
        $SLEEPING_PARTNER = 2;

        $DIVIDE_TO_ALL_EQUALLY = 1;
        $DIVIDE_TO_ALL_OWNERS_EQUALLY = 2;
        $DIVIDE_TO_ALL_INVESTORS_EQUALLY = 3;
        $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY = 4;
        $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY = 5;

        $capQuery = "SELECT cr_parent_account_uid, cr_capital_account_uid, cr_profit_loss_account_uid, cr_drawing_account_uid, cr_reserve_account_uid, cr_user_id, cr_partner_nature,
                    cr_is_custom_profit, cr_is_custom_loss, cr_fixed_profit_per, cr_fixed_loss_per, cr_remaning_profit_division, cr_remaning_loss_division FROM financials_capital_register;";

        $capResult = $database->query($capQuery);
        $numRows = $database->num_rows($capResult);

        if ($capResult && $numRows > 0) {

            if ($numRows == 1) {

                $capitalRegistration = $database->fetch_assoc($capResult);

                $capitalAccountUID = $capitalRegistration['cr_capital_account_uid'];
                $profitAndLossAccountUID = $capitalRegistration['cr_profit_loss_account_uid'];
                $reserveAccountUID = $capitalRegistration['cr_reserve_account_uid'];
                $drawingAccountUID = $capitalRegistration['cr_drawing_account_uid'];

                $capUser = getUser($capitalRegistration['cr_user_id']);
                $capUserName = "Unknown";
                if ($capUser->found == true) {
                    $capUserName = $capUser->properties->user_name;
                }

                $totalCapital = 0;

                $capitalAccountBalance = getAccountClosingBalance($capitalAccountUID)->balance;
                $profitAndLossAccountBalance = getAccountClosingBalance($profitAndLossAccountUID)->balance;
                $reserveAccountBalance = getAccountClosingBalance($reserveAccountUID)->balance;
                $drawingAccountBalance = getAccountClosingBalance($drawingAccountUID)->balance;

                $totalCapital = ($capitalAccountBalance + $profitAndLossAccountBalance + $reserveAccountBalance) - $drawingAccountBalance;

                $profitLossDistributionHTMLReport .= '
                    <tr class="normalHover">
                        <th class="text-left tbl_txt_13">
                            ' . $capUserName . '
                        </th>
                        <td class="text-right tbl_srl_18">
                            ' . number_format($totalCapital, 2) . '
                        </td>
                        <td class="text-right tbl_srl_6">
                            100.00
                        </td>
                        <td class="text-right tbl_srl_6">
                            100.00
                        </td>
                        <td class="text-right tbl_srl_6">
                            100.00
                        </td>
                        <td class="text-right tbl_srl_6">
                            ' . number_format($netProfitOrLossAbsoluteAmount, 2) . '
                        </td>
                        <td class="text-right tbl_srl_6">
                            0.00
                        </td>
                        <th class="text-right tbl_srl_18">
                            ' . number_format($netProfitOrLossAbsoluteAmount, 2) . '
                        </th>
                    </tr>
                ';

            } else {

                $totalCapital = 0;
                $allCapitals = array();

                $undistributedProfitAndLossAmount = 0;

                $profitOrLossAddToAll = 0;
                $profitOrLossAddToAllOwners = 0;
                $profitOrLossAddToAllInvestors = 0;
                $profitOrLossAddToAllActives = 0;
                $profitOrLossAddToAllSleeping = 0;

                while ($capitalRegistration = $database->fetch_assoc($capResult)) {

                    $parentUID = $capitalRegistration['cr_parent_account_uid'];
                    $partnerNature = $capitalRegistration['cr_partner_nature'];
                    $capitalAccountUID = $capitalRegistration['cr_capital_account_uid'];
                    $profitAndLossAccountUID = $capitalRegistration['cr_profit_loss_account_uid'];
                    $reserveAccountUID = $capitalRegistration['cr_reserve_account_uid'];
                    $drawingAccountUID = $capitalRegistration['cr_drawing_account_uid'];
                    $userId = $capitalRegistration['cr_user_id'];

                    $isCustomProfit = $capitalRegistration['cr_is_custom_profit'];
                    $isCustomLoss = $capitalRegistration['cr_is_custom_loss'];

                    $customProfitPer = $capitalRegistration['cr_fixed_profit_per'];
                    $customLossPer = $capitalRegistration['cr_fixed_loss_per'];

                    $remainingProfitDiv = $capitalRegistration['cr_remaning_profit_division'];
                    $remainingLossDiv = $capitalRegistration['cr_remaning_loss_division'];

                    $capUser = getUser($userId);
                    $capUserName = "Unknown";
                    if ($capUser->found == true) {
                        $capUserName = $capUser->properties->user_name;
                    }

                    $individualCapital = 0;

                    $capitalAccountBalance = getAccountClosingBalance($capitalAccountUID)->balance;
                    $profitAndLossAccountBalance = getAccountClosingBalance($profitAndLossAccountUID)->balance;
                    $reserveAccountBalance = getAccountClosingBalance($reserveAccountUID)->balance;
                    $drawingAccountBalance = getAccountClosingBalance($drawingAccountUID)->balance;

                    $individualCapital = ($capitalAccountBalance + $profitAndLossAccountBalance + $reserveAccountBalance) - $drawingAccountBalance;

                    $totalCapital += $individualCapital;

                    $allCapitals[] = (object)array(
                        'parent_uid' => $parentUID,
                        'partner_nature' => $partnerNature,
                        'capital_account_uid' => $capitalAccountUID,
                        'profit_loss_account_uid' => $profitAndLossAccountUID,
                        'reserve_account_uid' => $reserveAccountUID,
                        'drawing_account_uid' => $drawingAccountUID,
                        'user_id' => $userId,
                        'user_name' => $capUserName,
                        'capital' => $individualCapital,

                        'is_custom_profit' => $isCustomProfit,
                        'is_custom_loss' => $isCustomLoss,

                        'custom_profit_per' => $customProfitPer,
                        'custom_loss_per' => $customLossPer,

                        'remaining_profit_div' => $remainingProfitDiv,
                        'remaining_loss_div' => $remainingLossDiv
                    );

                }

                $capCountsQuery = "SELECT
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId) as capitals,
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_parent_account_uid LIKE '$ownerEquityParentAccountUID%') as owners,
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_parent_account_uid LIKE '$investorEquityParentAccountUID%') as investors,
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $ACTIVE_PARTNER) as active,
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $SLEEPING_PARTNER) as sleeping";

                $capCountsResult = $database->query($capCountsQuery);

                $capCounts = 0;
                $ownersCount = 0;
                $investorsCount = 0;
                $activeCount = 0;
                $sleepingCount = 0;

                if ($capCountsResult) {
                    $countsData = $database->fetch_assoc($capCountsResult);

                    $capCounts = $countsData['capitals'];
                    $ownersCount = $countsData['owners'];
                    $investorsCount = $countsData['investors'];
                    $activeCount = $countsData['active'];
                    $sleepingCount = $countsData['sleeping'];
                }



                $capUserCountsQuery = "SELECT
                    (SELECT group_concat(cr_user_id) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_parent_account_uid LIKE '$ownerEquityParentAccountUID%') as owners,
                    (SELECT group_concat(cr_user_id) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_parent_account_uid LIKE '$investorEquityParentAccountUID%') as investors,
                    (SELECT group_concat(cr_user_id) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $ACTIVE_PARTNER) as active,
                    (SELECT group_concat(cr_user_id) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $SLEEPING_PARTNER) as sleeping";

                $capUserCountsResult = $database->query($capUserCountsQuery);

                $ownerIds = "";
                $investorIds = "";
                $activeIds = "";
                $sleepingIds = "";

                if ($capUserCountsResult) {
                    $countsData = $database->fetch_assoc($capUserCountsResult);

                    $ownerIds = $countsData['owners'];
                    $investorIds = $countsData['investors'];
                    $activeIds = $countsData['active'];
                    $sleepingIds = $countsData['sleeping'];
                }




                $printProfitDiv = array();

                foreach ($allCapitals as $capital) {

                    $actualRatio = $totalCapital == 0 ? 0 : ($capital->capital / $totalCapital) * 100;
                    $customProfitRatio = $actualRatio;
                    $customLossRatio = $actualRatio;

                    $remainingProfitRatio = 0;
                    $remainingLossRatio = 0;

                    if ($capital->is_custom_profit == 1) {
                        $customProfitRatio = ($customProfitRatio * $capital->custom_profit_per) / 100;

                        $remainingProfitRatio = $actualRatio - $customProfitRatio;

                    }

                    if ($capital->is_custom_loss == 1) {
                        $customLossRatio = ($customLossRatio * $capital->custom_loss_per) / 100;

                        $remainingLossRatio = $actualRatio - $customLossRatio;

                    }

                    $profitLossAmount = 0;

                    if ($netProfitOrLoss == "Profit") {
                        $profitLossAmount = ($netProfitOrLossAbsoluteAmount * $customProfitRatio) / 100;

                        if ($capital->is_custom_profit == 1 && $remainingProfitRatio > 0) {

                            $divideThisProfitAmount = ($netProfitOrLossAbsoluteAmount * $remainingProfitRatio) / 100;

                            // profit division
                            switch ($capital->remaining_profit_div) {
                                case $DIVIDE_TO_ALL_EQUALLY:
                                    $profitOrLossAddToAll += $divideThisProfitAmount / $capCounts;
                                    break;
                                case $DIVIDE_TO_ALL_OWNERS_EQUALLY:
                                    if ($ownersCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisProfitAmount;
                                    } else {
                                        $profitOrLossAddToAllOwners += $divideThisProfitAmount / $ownersCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_INVESTORS_EQUALLY:
                                    if ($investorsCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisProfitAmount;
                                    } else {
                                        $profitOrLossAddToAllInvestors += $divideThisProfitAmount / $investorsCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY:
                                    if ($activeCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisProfitAmount;
                                    } else {
                                        $profitOrLossAddToAllActives += $divideThisProfitAmount / $activeCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY:
                                    if ($sleepingCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisProfitAmount;
                                    } else {
                                        $profitOrLossAddToAllSleeping += $divideThisProfitAmount / $sleepingCount;
                                    }
                                    break;
                            }

                        }

                    } elseif ($netProfitOrLoss == "Loss") {
                        $profitLossAmount = ($netProfitOrLossAbsoluteAmount * $customLossRatio) / 100;

                        if ($capital->is_custom_loss == 1 && $remainingLossRatio > 0) {

                            $divideThisLossAmount = ($netProfitOrLossAbsoluteAmount * $remainingLossRatio) / 100;

                            // loss division
                            switch ($capital->remaining_loss_div) {
                                case $DIVIDE_TO_ALL_EQUALLY:
                                    $profitOrLossAddToAll += $divideThisLossAmount / $capCounts;
                                    break;
                                case $DIVIDE_TO_ALL_OWNERS_EQUALLY:
                                    if ($ownersCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisLossAmount;
                                    } else {
                                        $profitOrLossAddToAllOwners += $divideThisLossAmount / $ownersCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_INVESTORS_EQUALLY:
                                    if ($investorsCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisLossAmount;
                                    } else {
                                        $profitOrLossAddToAllInvestors += $divideThisLossAmount / $investorsCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_ACTIVE_PARTNERS_EQUALLY:
                                    if ($activeCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisLossAmount;
                                    } else {
                                        $profitOrLossAddToAllActives += $divideThisLossAmount / $activeCount;
                                    }
                                    break;
                                case $DIVIDE_TO_ALL_SLEEPING_PARTNERS_EQUALLY:
                                    if ($sleepingCount == 0) {
                                        $undistributedProfitAndLossAmount += $divideThisLossAmount;
                                    } else {
                                        $profitOrLossAddToAllSleeping += $divideThisLossAmount / $sleepingCount;
                                    }
                                    break;
                            }

                        }

                    }

                    $printProfitDiv[] = (object)array(
                        'user_id' => $capital->user_id,
                        'user_name' => $capital->user_name,
                        'parent_uid' => $capital->parent_uid,
                        'partner_nature' => $capital->partner_nature,
                        'capital' => $capital->capital,
                        'profit_loss_account_uid' => $capital->profit_loss_account_uid,
                        'actual_ratio' => $actualRatio,
                        'custom_profit_ratio' => $customProfitRatio,
                        'custom_loss_ratio' => $customLossRatio,
                        'profit_loss' => $profitLossAmount
                    );

                }


                $totalSystemCapital = 0;
                $totalActualRatio = 0;
                $totalCustomProfitRatio = 0;
                $totalCustomLossRatio = 0;
                $totalPnL = 0;
                $totalDiv = 0;
                $totalTotalAmount = 0;

                foreach ($printProfitDiv as $eachProfit) {

                    $totalProfitLossAmount = $eachProfit->profit_loss;
                    $divisionProfitLossAmount = 0;
                    $capUserId = $eachProfit->user_id;
                    $parentUID = $eachProfit->parent_uid;
                    $partnerNature = $eachProfit->partner_nature;

                    $divisionProfitLossAmount += $profitOrLossAddToAll;

                    if (in_array($capUserId, explode(',', $ownerIds))) {
                        $divisionProfitLossAmount += $profitOrLossAddToAllOwners;
                    } elseif (in_array($capUserId, explode(',', $investorIds))) {
                        $divisionProfitLossAmount += $profitOrLossAddToAllInvestors;
                    }

                    if (in_array($capUserId, explode(',', $activeIds))) {
                        $divisionProfitLossAmount += $profitOrLossAddToAllActives;
                    } elseif (in_array($capUserId, explode(',', $sleepingIds))) {
                        $divisionProfitLossAmount += $profitOrLossAddToAllSleeping;
                    }

                    $totalProfitLossAmount += $divisionProfitLossAmount;

                    $profitLossDistributionHTMLReport .= '
                        <tr class="normalHover">
                            <th class="text-left tbl_txt_13">
                                ' . $eachProfit->user_name . '
                            </th>
                            <td class="text-right tbl_srl_18">
                                ' . number_format($eachProfit->capital, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($eachProfit->actual_ratio, 4) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($eachProfit->custom_profit_ratio, 4) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($eachProfit->custom_loss_ratio, 4) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($eachProfit->profit_loss, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($divisionProfitLossAmount, 2) . '
                            </td>
                            <th class="text-right tbl_srl_18">
                                ' . number_format($totalProfitLossAmount, 2) . '
                            </th>
                        </tr>
                    ';

                    $totalSystemCapital += $eachProfit->capital;
                    $totalActualRatio += $eachProfit->actual_ratio;
                    $totalCustomProfitRatio += $eachProfit->custom_profit_ratio;
                    $totalCustomLossRatio += $eachProfit->custom_loss_ratio;
                    $totalPnL += $eachProfit->profit_loss;
                    $totalDiv += $divisionProfitLossAmount;
                    $totalTotalAmount += $totalProfitLossAmount;

                }

                if ($totalTotalAmount != $netProfitOrLossAbsoluteAmount) {
                    $remainingPnLAmount = $netProfitOrLossAbsoluteAmount - $totalTotalAmount;
                    $undistributedProfitAndLossAmount += $remainingPnLAmount;
                }

                if (number_format($undistributedProfitAndLossAmount, 2, '.', '') != 0.00) {

                    $totalTotalAmount += $undistributedProfitAndLossAmount;

                    $profitLossDistributionHTMLReport .= '
                        <tr class="loss">
                            <th class="text-left tbl_txt_13">
                                Undistributed ' . $netProfitOrLoss . '
                            </th>
                            <td colspan="6" class="text-right tbl_srl_18">
                                Some of your selected profit/loss distribution option is not meets the current case!
                            </td>
                            <td class="text-right tbl_srl_18">
                                ' . number_format($undistributedProfitAndLossAmount, 2) . '
                            </td>
                        </tr>
                    ';

                }

                $profitLossDistributionHTMLReport .= '
                    <tfoot>
                        <tr class="day_end_table_ttl">
                            <th>
                                Total
                            </th>
                            <td class="text-right tbl_srl_18">
                                ' . number_format($totalSystemCapital, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($totalActualRatio, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($totalCustomProfitRatio, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($totalCustomLossRatio, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($totalPnL, 2) . '
                            </td>
                            <td class="text-right tbl_srl_6">
                                ' . number_format($totalDiv, 2) . '
                            </td>
                            <th class="text-right tbl_srl_18">
                                ' . number_format($totalTotalAmount, 2) . '
                            </th>
                        </tr>
                    </tfoot>
                ';

            }

            $profitLossDistributionHTMLReport .= '
                </tbody>
                    </table><!-- table end -->
                </section><!-- invoice content section end here -->
            ';

            $profitDisExeStopTime = microtime(true);
            $profitLossDistributionHTMLReport .= exeTimeDiv($profitDisExeStopTime - $profitDisExeStartTime);

            $profitLossDistributionHTMLReport .= '
                <p class="alert-well">
                    This is only view of calculation, ' . $netProfitOrLoss . ' distribute at the time of Day End Execution.
                </p>
            ';

        } else {

            $error = true;

            $profitLossDistributionHTMLReport .= shortError("No capital account found for distribution " . $netProfitOrLoss . "!");

        }

    }

}

/*
 *******************************************************************************************************************************
 *
 * Success message
 *
 * ******************************************************************************************************************************
 */
$successMessage = "";
if (!$error && !$rollBack) {
    $successMessage = successMessage("Report Generated", "Day End report without execution generated Successfully.");
}

/*
 *******************************************************************************************************************************
 *
 * Info Section
 *
 * ******************************************************************************************************************************
 */
function getInfoSection($userName, $userEmail, $userCellNumber, $userTimeStamp, $exeTime, $detailLink = null) {

    $detailLinkHTML = "";
    if ($detailLink != null) {
        $detailLinkHTML = '
            <p class="review_cntnt review_cntnt_see_more">
                Click <a href="' . $detailLink . '"> here </a> to see detail report
            </p>
        ';
    }

    return '
        <!-- Footer Generated By -->
        <footer class="day_end_footer"><!-- footer section start here -->
            <div class="day_end_review_bx"><!-- footer container start -->
                <div class="review_title_bx"><!-- footer title box start -->
                    <h1 class="review_title">
                        INFO
                    </h1>
                </div><!-- footer sub title box end -->
                <div class="review_cntnt_bx gnrl-blk gnrl-mrgn-pdng"><!-- header detail box start -->
                    <p class="review_cntnt">
                        Name
                        <span>
                            ' . $userName . '
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Email
                        <span>
                            <a href="mailto:' . $userEmail . '">' . $userEmail . '</a>
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Cell #
                        <span>
                            <a href="tel:' . $userCellNumber . '">' . $userCellNumber . '</a>
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Generated
                        <span>
                            ' . $userTimeStamp . '
                        </span>
                    </p>
                    <p class="review_cntnt">
                        Exe Time
                        <span>
                            ' . number_format($exeTime, 3) . ' second(s)
                        </span>
                    </p>
                    ' . $detailLinkHTML . '
                </div><!-- header detail box end -->
            </div><!-- footer container end -->

            <div class="sign_bx"><!-- header container start -->
                <div class="sign_title_bx"><!-- header title box start -->
                    <h1 class="sign_title">
                        Authorised Sign
                    </h1>
                </div><!-- header title box end -->
            </div><!-- header container end -->
            <div class="clear"></div>
        </footer><!-- footer section end here -->
    ';
}

$reportExeStopTime = microtime(true);

$generatedBySectionHTMLReport = getInfoSection($userName, $userEmail, $userCellNumber, $userTimeStamp, $reportExeStopTime - $reportExeStartTime);

/*
 *******************************************************************************************************************************
 *
 * Complete Report
 *
 * ******************************************************************************************************************************
 */
$content = "";
$content .= $htmlHeader;
$content .= $headerSection;
$content .= $dailyDepreciationHTMPReport;
$content .= $monthlyDepreciationHTMPReport;
$content .= $trialBalanceHTMLReport;
$content .= $stockValuesHTMLReport;
$content .= $cashFlowStatementHTMLReport;
$content .= $incomeStatementHTMLReport;
$content .= $balanceSheetHTMLReport;
$content .= $profitLossDistributionHTMLReport;
$content .= $successMessage;
$content .= $generatedBySectionHTMLReport;
$content .= $htmlFooter;
echo $content;


$mailContent = "";
$mailContent .= $htmlInternalCSSHeader;
$mailContent .= $headerSection;
$mailContent .= $dailyDepreciationHTMPReport;
$mailContent .= $monthlyDepreciationHTMPReport;
$mailContent .= $trialBalanceHTMLReport;
$mailContent .= $stockValuesHTMLReport;
$mailContent .= $cashFlowStatementHTMLReport;
$mailContent .= $incomeStatementHTMLReport;
$mailContent .= $balanceSheetHTMLReport;
$mailContent .= $profitLossDistributionHTMLReport;
$mailContent .= $successMessage;
$mailContent .= $generatedBySectionHTMLReport;
$mailContent .= $htmlFooter;

//mailTo("arbaz.mateen@softagics.com", "New Day End Report", $mailContent, "shahzaibsnipers@gmail.com");


if (isset($database)) {
    $database->close_connection();
}
