<?php
/**
 * Created by Ch Arbaz Mateen.
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

$ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "not found";

$type = isset($_REQUEST['type']) ? $_REQUEST['type'] : "";
$mail = isset($_REQUEST['mail']) ? $_REQUEST['mail'] : 0;

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

$undistributedProfitLossAccountUID = UNDISTRIBUTED_PROFIT_LOSS_ACCOUNT_UID;

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

$closingType = "MONTHLY";

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
        Month End Report
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
$cssContent =  $srcUrl . '/css/day_end.css' or "";
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
        Month End Report
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
 * HTML Script Footer
 *
 * ******************************************************************************************************************************
 */
$htmlScriptsFooter = '
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
<script src="' . $srcUrl . '/js/jquery.js" ></script>
<script src="' . $srcUrl . '/js/copy.js"></script>

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
            <div class="day_end_header_con month_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="' . $companyLogo . '" alt="' . $companyName . '" class="logo-img"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Month End Report
                    </h1>
                </div><!-- header title box end -->

                <div class="day_end_header_detail_bx"><!-- header detail box start -->
                    <p class="detail_para darkorange">
                        Without Execution&nbsp;
                    </p>
                    <p class="detail_para">
                        Date:
                        <span>
                            00-0000
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
$currentDayEndId = isset($_REQUEST['did']) ? $database->escape_value($_REQUEST['did']) : 0;
$currentDayEndDate = "";
$currentDayEndIsLocked = true;
$lastClosedDayEnd = null;
$lastClosedDayEndId = 0;
$lastClosedDayEndDate = "";
$isLastClosedDayEndAvailable = false;

$firstDayEndOfMonth = null;
$lastDayEndOfMonth = null;

$firstDayEndOfMonthId = 0;
$lastDayEndOfMonthId = 0;

$firstDayEndOfMonthDate = "";
$lastDayEndOfMonthDate = "";

$currentDayEnd = getDayEndWithId($currentDayEndId);

if ($currentDayEnd->found === true) {

    $currentDayEndId = $currentDayEnd->id;
    $currentDayEndDate = $currentDayEnd->date;

    if (isLastDayOfMonth($currentDayEndDate)) {

        try {

            $cDate = new DateTime($currentDayEndDate);
            $currentMonth = $cDate->format(MONTH_END_DATE_FORMAT_FOR_USER);
            $currentUserReadableDate = $currentMonth;

        } catch (Exception $e) {}

    } else {
        $error = true;
        $dieReport = $htmlHeader;
        $dieReport .= $headerSectionBeforeDate;
        $dieReport .= error("Month End Error", "Today is not the last day of month, Month End only execute at the last day of Month!");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);
    }

    $firstDayEndOfMonth = getFirstDayEndOfCurrentMonth();

    if ($firstDayEndOfMonth->found == true) {

        $firstDayEndOfMonthId = $firstDayEndOfMonth->id;
        $firstDayEndOfMonthDate = $firstDayEndOfMonth->date;

    } else {
        $error = true;
        $dieReport = $htmlHeader;
        $dieReport .= $headerSectionBeforeDate;
        $dieReport .= error("Month End Error", "Unable to found first day end of current Month!");
        $dieReport .= $htmlFooter;

        if (isset($database)) {
            $database->close_connection();
        }

        die($dieReport);
    }

} else {
    $error = true;
    $dieReport = $htmlHeader;
    $dieReport .= $headerSectionBeforeDate;
    $dieReport .= error("Month End Error", "Current date is not available for month end execution!");
    $dieReport .= $htmlFooter;

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 * ******************************************************************************************************************************
 *
 * Get Month End Config
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

$monthlyCompleteReport = false;

$loginUserId = isset($_POST['uid']) ? $database->escape_value($_POST['uid']) : 0;
$userPassword = isset($_POST['upass']) ? $database->escape_value($_POST['upass']) : "";
$loginClgId = isset($_REQUEST['clg_id']) ? $database->escape_value($_REQUEST['clg_id']) : 0;

$dayEndConfigQuery = "SELECT dec_cash_check, dec_bank_check, dec_product_check, dec_warehouse_check, dec_create_trial,
                            dec_create_closing_stock, dec_create_cash_bank_closing, dec_create_pnl,
                            dec_create_balance_sheet, dec_create_pnl_distribution
                        FROM financials_day_end_config WHERE dec_clg_id ='$loginClgId';";// AND dec_id = 1;";

$dayEndConfigResult = $database->query($dayEndConfigQuery);

if ($dayEndConfigResult && $database->num_rows($dayEndConfigResult) == 1) {
    $dayEndConfig = (object)$database->fetch_assoc($dayEndConfigResult);

    $cashCheck = $dayEndConfig->dec_cash_check == "2";
    $bankCheck = $dayEndConfig->dec_bank_check == "2";
    $productCheck = $dayEndConfig->dec_product_check == "2";
    $warehouseCheck = $dayEndConfig->dec_warehouse_check == "2";

    $createTrial = $dayEndConfig->dec_create_trial == "2";
    $creatClosingStock = $dayEndConfig->dec_create_closing_stock == "2";
    $createCashBankOpeningClosing = $dayEndConfig->dec_create_cash_bank_closing == "2";
    $createPnL = $dayEndConfig->dec_create_pnl == "2";
    $createBalanceSheet = $dayEndConfig->dec_create_balance_sheet == "2";
    $createPnlDistribution = $dayEndConfig->dec_create_pnl_distribution == "2";

    $monthlyCompleteReport = ($createTrial || $creatClosingStock || $createCashBankOpeningClosing || $createPnL || $createBalanceSheet || $createPnlDistribution);

} else {

    $dieReport = $htmlHeader;
    $dieReport .= $headerSection;
    $dieReport .= error("Month End Configuration Not Found", "Did'nt found Month End Configuration data to show report or Month End Execution!");
    $dieReport .= $htmlFooter;

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 * ******************************************************************************************************************************
 *
 * Header Section including Company Logo and Month End Date
 *
 * ******************************************************************************************************************************
 */
$headerSection = '
        <!-- Header Logo, Title, Date -->
        <header class="day_end_header">
            <div class="day_end_header_con month_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="' . $companyLogo . '" alt="' . $companyName . '" height="50"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Month End Report
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
 * Header Section including Company Logo and Month End Date and Error
 *
 * ******************************************************************************************************************************
 */
$headerErrorSection = '
        <!-- Header Logo, Title, Date -->
        <header class="day_end_header">
            <div class="day_end_header_con month_end_header_con"><!-- header container start -->

                <div class="day_end_logo_con"><!-- header logo container start -->
                    <div class="logo_bx gnrl-blk"><!-- header logo box start -->
                        <img src="' . $companyLogo . '" alt="' . $companyName . '" height="50"/>
                    </div><!-- header logo box end -->
                </div><!-- header logo container end -->

                <div class="day_end_title_bx"><!-- header title box start -->
                    <h1>
                        Month End Report
                    </h1>
                </div><!-- header title box end -->

                <div class="day_end_header_detail_bx"><!-- header detail box start -->
                    <p class="detail_para red">
                        Report Error&nbsp;
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
// $loginUserId = isset($_REQUEST['uid']) ? $database->escape_value($_REQUEST['uid']) : 0;
// $userPassword = isset($_REQUEST['upass']) ? $database->escape_value($_REQUEST['upass']) : "";

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
            $dieReport .= error("Invalid User", "You are not Authorized to View/Execute Month End due to your account status id 'DISABLE'!");
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
 *******************************************************************************************************************************
 *
 * Cash Account Error
 *
 * ******************************************************************************************************************************
 */
$cashErrorReport = "";

//if ($cashCheck) {
$getCashAccountsQuery = "SELECT account_uid as UID, account_name as name FROM financials_accounts WHERE cr_clg_id = $loginClgId AND account_parent_code = $cashParentUID;";
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
        $accountBalanceObject = getAccountClosingBalance($accountUID,$loginClgId);
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
//}

/*
 *******************************************************************************************************************************
 *
 * Bank Account Error
 *
 * ******************************************************************************************************************************
 */
$bankErrorReport = "";

//if ($bankCheck) {
$getBankAccountsQuery = "SELECT account_uid as UID, account_name as name FROM financials_accounts WHERE account_clg_id = $loginClgId AND account_parent_code = $bankParentUID;";
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
        $accountBalanceObject = getAccountClosingBalance($accountUID,$loginClgId);
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
//}

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

//if ($productCheck) {
$getProductsQuery = "SELECT pro_p_code, pro_title, pro_qty_for_sale, pro_hold_qty, pro_bonus_qty, pro_claim_qty, pro_qty_wo_bonus, pro_quantity
                    FROM financials_products
                    WHERE pro_clg_id = $loginClgId AND (pro_qty_for_sale < 0 OR pro_hold_qty < 0 OR pro_bonus_qty < 0 OR pro_claim_qty < 0 OR pro_qty_wo_bonus < 0 OR pro_quantity < 0);";
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
//}

/*
 *******************************************************************************************************************************
 *
 * Product Quantity Error in Warehouse
 *
 * ******************************************************************************************************************************
 */
$warehouseQuantityErrorReport = "";

//if ($warehouseCheck) {
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
//}

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
 * Start Month End Processing
 *
 * ******************************************************************************************************************************
*/
//$database->begin_trans();

/*
 *******************************************************************************************************************************
 *
 * Start Month End Processing
 *
 * ******************************************************************************************************************************
*/
//if (!$error && !$rollBack) {
//    $query = "UPDATE financials_day_end SET de_datetime_status = 'PROCESSING' WHERE de_id = $currentDayEndId AND de_month_status = 'PENDING'
//                ORDER BY de_id DESC LIMIT 1;";
//
//    $result = $database->query($query);
//
//    if(!$result || $database->affected_rows() != 1) {
//        $error = true;
//        $rollBack = true;
//
//        $dieReport = $htmlHeader;
//        $dieReport .= $headerSection;
//        $dieReport .= error("Month End Processing Error", "Unable to start Month End processing!");
//        $dieReport .= $htmlFooter;
//
//        if (isset($database)) {
//            $database->close_connection();
//        }
//
//        die($dieReport);
//    }
//}

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
$trialBalanceError = false;
$trialBalanceErrorMessage = "";

//if ($createTrial || ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
$createTrial = true;
if (!$error) {
    $trialExeStartTime = microtime(true);

    $totalAccounts = getCountOfTable("financials_accounts",$loginClgId,"fa");

    $trialTotalDebit = 0;
    $trialTotalCredit = 0;
    $trialDifference = 0;

    $opLevelQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_clg_id = $loginClgId AND coa_level = 1;";
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
                                    WHERE account_clg_id = $loginClgId AND account_parent_code = $childCode;";
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
//                                if ($entryTodayOpeningType == 'DR') {
//                                    $previousDRBalance = $entryTodayOpeningBalance;
//                                } else if ($entryTodayOpeningType == 'CR') {
//                                    $previousCRBalance = $entryTodayOpeningBalance;
//                                }
//                            } else {
                        if ($entryMonthlyOpeningType == 'DR') {
                            $previousDRBalance = $entryMonthlyOpeningBalance;
                        } else if ($entryMonthlyOpeningType == 'CR') {
                            $previousCRBalance = $entryMonthlyOpeningBalance;
                        }
//                            }
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
//                            $inwards = (double)$entryTodayDebit;
//                            $outwards = (double)$entryTodayCredit;
//                            $openingBalance = (double)$entryTodayOpeningBalance;
//                        } else {
                    $inwards = (double)$entryMonthlyDebit;
                    $outwards = (double)$entryMonthlyCredit;
                    $openingBalance = (double)$entryMonthlyOpeningBalance;
                    $openingBalanceType = $entryMonthlyOpeningType;
//                        }

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
//                                if (!$monthlyCompleteReport) {
//                                    $totalDr = (double)$previousDRBalance;
//                                    $totalCr = (double)$previousCRBalance;
//                                } else {
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
//                                }
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
//                            if ($firstDayEndOfMonthId == 1) {
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
                        array('parent' => $childCode, 'code' => $entryCode, 'name' => "$entryName", 'level' => 4, 'type' => $balanceType, 'opening_type' => $openingBalanceType, 'opening' => $openingBalance, 'inwards' => $inwards, 'outwards' => $outwards, 'balance' => $balanceBF);

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

    /*
     *
     * Save trial balance entries
     *

    foreach ($trialViewList as $control) {
        $controlCode = $control['code'];
        $controlName = $database->escape_value($control['name']);
        $controlType = $control['type'];
        $controlLevel = $control['level'];
        $controlBalance = $control['balance'];
        $parents = $control['child'];

        // save control account entry
        if ($controlType == "DR") {
            $controlTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', 0, $controlCode, '$controlName', $controlLevel, $controlBalance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
        } elseif ($controlType == "CR") {
            $controlTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', 0, $controlCode, '$controlName', $controlLevel, NULL, $controlBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
        } else {
            if (startsWith($controlCode, ASSETS) || startsWith($controlCode, EXPENSES)) { // debit zero
                $controlTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', 0, $controlCode, '$controlName', $controlLevel, 0, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
            } else { // credit zero
                $controlTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', 0, $controlCode, '$controlName', $controlLevel, NULL, 0, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
            }
        }

        $controlTBResult = $database->query($controlTBQuery);
        if (!$controlTBResult) {
            $rollBack = true;
            $error = true;
            $trialBalanceError = true;
            $trialBalanceErrorMessage .= "Unable to save Trial Balance entry of '$controlName' at amount " . number_format($controlBalance, 2);
            break;
        }

        foreach ($parents as $parent) {
            $parentCode = $parent['code'];
            $parentName = $database->escape_value($parent['name']);
            $parentType = $parent['type'];
            $parentLevel = $parent['level'];
            $parentBalance = $parent['balance'];
            $children = $parent['child'];

            // save parent account entry
            if ($parentType == "DR") {
                $parentTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $controlCode, $parentCode, '$parentName', $parentLevel, $parentBalance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
            } elseif ($parentType == "CR") {
                $parentTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $controlCode, $parentCode, '$parentName', $parentLevel, NULL, $parentBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
            } else {
                if (startsWith($parentCode, ASSETS) || startsWith($parentCode, EXPENSES)) { // debit zero
                    $parentTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $controlCode, $parentCode, '$parentName', $parentLevel, 0, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                } else { // credit zero
                    $parentTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $controlCode, $parentCode, '$parentName', $parentLevel, NULL, 0, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                }
            }

            $parentTBResult = $database->query($parentTBQuery);
            if (!$parentTBResult) {
                $rollBack = true;
                $error = true;
                $trialBalanceError = true;
                $trialBalanceErrorMessage .= "Unable to save Trial Balance entry of '$parentName' at amount " . number_format($parentBalance, 2);
                break;
            }

            foreach ($children as $child) {
                $childCode = $child['code'];
                $childName = $database->escape_value($child['name']);
                $childType = $child['type'];
                $childLevel = $child['level'];
                $childBalance = $child['balance'];
                $entries = $child['child'];

                // save child account entry
                if ($childType == "DR") {
                    $childTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $parentCode, $childCode, '$childName', $childLevel, $childBalance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                } elseif ($childType == "CR") {
                    $childTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $parentCode, $childCode, '$childName', $childLevel, NULL, $childBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                } else {
                    if (startsWith($childCode, ASSETS) || startsWith($childCode, EXPENSES)) { // debit zero
                        $childTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $parentCode, $childCode, '$childName', $childLevel, 0, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                    } else { // credit zero
                        $childTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $parentCode, $childCode, '$childName', $childLevel, NULL, 0, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                    }
                }

                $childTBResult = $database->query($childTBQuery);
                if (!$childTBResult) {
                    $rollBack = true;
                    $error = true;
                    $trialBalanceError = true;
                    $trialBalanceErrorMessage .= "Unable to save Trial Balance entry of '$childName' at amount " . number_format($childBalance, 2);
                    break;
                }

                foreach ($entries as $entry) {
                    $entryCode = $entry['code'];
                    $entryName = $database->escape_value($entry['name']);
                    $entryType = $entry['type'];
                    $entryLevel = $entry['level'];
                    $entryBalance = $entry['balance'];

                    // save entry account entry
                    if ($entryType == "DR") {
                        $entryTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $childCode, $entryCode, '$entryName', $entryLevel, $entryBalance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                    } elseif ($entryType == "CR") {
                        $entryTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $childCode, $entryCode, '$entryName', $entryLevel, NULL, $entryBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                    } else {
                        if (startsWith($entryCode, ASSETS) || startsWith($entryCode, EXPENSES)) { // debit zero
                            $entryTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $childCode, $entryCode, '$entryName', $entryLevel, 0, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                        } else { // credit zero
                            $entryTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
                                VALUES ('$closingType', $childCode, $entryCode, '$entryName', $entryLevel, NULL, 0, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
                        }
                    }

                    $entryTBResult = $database->query($entryTBQuery);
                    if (!$entryTBResult) {
                        $rollBack = true;
                        $error = true;
                        $trialBalanceError = true;
                        $trialBalanceErrorMessage .= "Unable to save Trial Balance entry of '$entryName' at amount " . number_format($entryBalance, 2);
                        break;
                    }

                }
            }
        }
    }*/

    /*
     * Display trial balance
     */
    $trialBalanceHTMLReport .= '
            <!-- Trial Balance -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        Trial Balance <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(1, this);"/></span>
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

    // save trial total
//        $totalTBQuery = "INSERT INTO financials_trial_balance (tb_type, tb_parent_uid, tb_account_uid, tb_account_name, tb_account_level, tb_total_debit, tb_total_credit, tb_day_end_id, tb_day_end_date, tb_datetime)
//                          VALUES ('$closingType', 0, 0, 'Total', 0, $trialTotalDebit, $trialTotalCredit, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
//
//        $totalTBResult = $database->query($totalTBQuery);
//        if (!$totalTBResult) {
//            $rollBack = true;
//            $error = true;
//            $trialBalanceError = true;
//            $trialBalanceErrorMessage .= "Unable to save Trial Balance total balance.";
//        }


    $trialExeStopTime = microtime(true);
    $trialBalanceHTMLReport .= exeTimeDiv($trialExeStopTime - $trialExeStartTime, "Execution Time  of " . number_format($totalAccounts, 0) . " Accounts: ");

    $trialDifference = abs((double)number_format($trialTotalDebit, 2, '.', '') - (double)number_format($trialTotalCredit, 2, '.', ''));
//        $trialDifference = abs(round(floor($trialTotalDebit)) - round(floor($trialTotalCredit)));

    if ($trialDifference > 0) {
        $diffErr = "Trial Balance is not equal, Difference amount is: <strong> " . number_format($trialDifference, 2) . " </strong> Please contact to your admin to adjust this amount. Trial must be Equal for Month End procedure!";
        $trialBalanceHTMLReport .= shortError($diffErr);
        $error = true;
        $rollBack = true;
    }

    if ($trialBalanceError) {
        $error = true;
        $rollBack = true;
        $trialBalanceHTMLReport .= shortError($trialBalanceErrorMessage);
    }

}
//}

/*
 *******************************************************************************************************************************
 *
 * Stop if Error
 *
 * ******************************************************************************************************************************
 */
if ($error || $rollBack) {
    $dieReport = $htmlHeader;
    $dieReport .= $headerErrorSection;
//    $dieReport .= $dailyDepreciationHTMPReport;
//    $dieReport .= $monthlyDepreciationHTMPReport;
    $dieReport .= $trialBalanceHTMLReport;
    $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved!");
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 *******************************************************************************************************************************
 *
 * Closing Stock
 *
 * ******************************************************************************************************************************
 */
$stockValuesHTMLReport = '';

//if ($creatClosingStock || ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($monthlyCompleteReport) {
//    $creatClosingStock = true;
if (!$error) {
    $stockExeStartTime = microtime(true);

    $totalProducts = getCountOfTable("financials_products",$loginClgId,"pro");

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
//if ($monthlyCompleteReport) {
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
$incomeStatementError = false;
$incomeStatementErrorMessage = "";

$NET_SALES_CODE = 11;
$CGS_CODE = 12;
$CGS_PURCHASES_CODE = 120; // change to cgsEntry function also
$GROSS_REVENUE_CODE = 13;
$NET_OPERATING_INCOME_CODE = 14;

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($monthlyCompleteReport) {
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

    // PnL portions arrays
    $pnlSalesEntryList = array();
    $pnlCGSEntryList = array();
    $grossRevenueEntry = array();
    $pnlExpensesList = array();
    $netOperatingIncomeEntry = array();
    $pnlOtherRevenueList = array();

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

    $netSalesValue = ($totalSalesValue - $totalSalesReturnValue - $tradeDiscountChildEntryBalance);

    $pnlSalesEntryList = array('parent' => 0, 'code' => $NET_SALES_CODE, 'name' => "Net Sales", 'level' => 2, 'child' => $pnlSalesChildList, 'balance' => $netSalesValue);

    $incomeStatementHTMLReport .= pnlSalesEntry($pnlSalesEntryList, 'pnl-' . strtolower($pnlSalesEntryList['name']));

    // save sale entries
    /*
    $salesParentCode = $pnlSalesEntryList['parent'];
    $salesCode = $pnlSalesEntryList['code'];
    $salesName = $database->escape_value($pnlSalesEntryList['name']);
    $salesLevel = $pnlSalesEntryList['level'];
    $salesAmount = $pnlSalesEntryList['balance'];
    $salesChild = $pnlSalesEntryList['child'];

    $salesPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                        VALUES ('$closingType', $salesParentCode, $salesCode, '$salesName', $salesLevel, '', NULL, NULL, $salesAmount, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $salesPnLResult = $database->query($salesPnLQuery);
    if (!$salesPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError = true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$salesName'";
    }

    foreach ($salesChild as $child1) {
        $sales2ParentCode = $child1['parent'];
        $sales2Code = $child1['code'];
        $sales2Name = $database->escape_value($child1['name']);
        $sales2Level = $child1['level'];
        $sales2Amount = $child1['balance'];

        $sales2PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                        VALUES ('$closingType', $sales2ParentCode, $sales2Code, '$sales2Name', $sales2Level, '', NULL, $sales2Amount, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $sales2PnLResult = $database->query($sales2PnLQuery);
        if (!$sales2PnLResult) {
            $rollBack = true;
            $error = true;
            $incomeStatementError = true;
            $incomeStatementErrorMessage .= "Unable to save Income Statement item '$sales2Name'";
            break;
        }

        if (array_key_exists('child', $child1)) {
            $sales2Child = $child1['child'];
            foreach ($sales2Child as $child2) {
                $sales3ParentCode = $child2['parent'];
                $sales3Code = $child2['code'];
                $sales3Name = $database->escape_value($child2['name']);
                $sales3Level = $child2['level'];
                $sales3Amount = $child2['balance'];

                $sales3PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                        VALUES ('$closingType', $sales3ParentCode, $sales3Code, '$sales3Name', $sales3Level, '', $sales3Amount, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $sales3PnLResult = $database->query($sales3PnLQuery);
                if (!$sales3PnLResult) {
                    $rollBack = true;
                    $error = true;
                    $incomeStatementError = true;
                    $incomeStatementErrorMessage .= "Unable to save Income Statement item '$sales3Name'";
                    break;
                }

            }
        }

    }*/


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

    //save CGS entries
    /*
    $cgsParentCode = $pnlCGSEntryList['parent'];
    $cgsCode = $pnlCGSEntryList['code'];
    $cgsName = $database->escape_value($pnlCGSEntryList['name']);
    $cgsLevel = $pnlCGSEntryList['level'];
    $cgsBalance = $pnlCGSEntryList['balance'];
    $cgsChild = $pnlCGSEntryList['child'];

    $cgsPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $cgsParentCode, $cgsCode, '$cgsName', $cgsLevel, '', NULL, NULL, $cgsBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $cgsPnLResult = $database->query($cgsPnLQuery);
    if (!$cgsPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$cgsName'";
    }

    foreach ($cgsChild as $cgsChild1) {
        $cgs2ParentCode = $cgsChild1['parent'];
        $cgs2Code = $cgsChild1['code'];
        $cgs2Name = $database->escape_value($cgsChild1['name']);
        $cgs2Level = $cgsChild1['level'];
        $cgs2Balance = $cgsChild1['balance'];

        $cgs2PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $cgs2ParentCode, $cgs2Code, '$cgs2Name', $cgs2Level, '', NULL, $cgs2Balance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $cgs2PnLResult = $database->query($cgs2PnLQuery);
        if (!$cgs2PnLResult) {
            $rollBack = true;
            $error = true;
            $incomeStatementError= true;
            $incomeStatementErrorMessage .= "Unable to save Income Statement item '$cgs2Name'";
            break;
        }

        if (array_key_exists('child', $cgsChild1)) {
            $cgs2Child = $cgsChild1['child'];
            foreach ($cgs2Child as $cgsChild2) {
                $cgs3ParentCode = $cgsChild2['parent'];
                $cgs3Code = $cgsChild2['code'];
                $cgs3Name = $database->escape_value($cgsChild2['name']);
                $cgs3Level = $cgsChild2['level'];
                $cgs3Balance = $cgsChild2['balance'];

                $cgs3PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $cgs3ParentCode, $cgs3Code, '$cgs3Name', $cgs3Level, '', $cgs3Balance, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $cgs3PnLResult = $database->query($cgs3PnLQuery);
                if (!$cgs3PnLResult) {
                    $rollBack = true;
                    $error = true;
                    $incomeStatementError= true;
                    $incomeStatementErrorMessage .= "Unable to save Income Statement item '$cgs3Name'";
                    break;
                }

            }
        }
    }*/


    // gross revenue entry
    $grossRevenueValue = $netSalesValue - $totalCGSValue;

    $grossRevenueEntry = array('parent' => 0, 'code' => $GROSS_REVENUE_CODE, 'name' => "Gross Revenue", 'level' => 4, 'balance' => $grossRevenueValue);

    $incomeStatementHTMLReport .= pnlAccountLikeNoLinkEntry($grossRevenueEntry, strtolower($grossRevenueEntry['name']), 3);

    //save gross revenue
    /*
    $grParentCode = $grossRevenueEntry['parent'];
    $grCode = $grossRevenueEntry['code'];
    $grName = $database->escape_value($grossRevenueEntry['name']);
    $grLevel = $grossRevenueEntry['level'];
    $grBalance = $grossRevenueEntry['balance'];

    $grPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $grParentCode, $grCode, '$grName', $grLevel, '', NULL, NULL, $grBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $grPnLResult = $database->query($grPnLQuery);
    if (!$grPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$grName'";
    }*/


    // expenses
    $totalExpenses = 0;

    $pnlExpensesList = $trialViewList[EXPENSES];
    $pnlTempExpensesBalance = $trialViewList[EXPENSES]['balance'];
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

    $totalExpenses = $pnlTempExpensesBalance - $pnlTempCGSExpenseBalance - $pnlTempTradeDiscountBalance;
    $pnlExpensesList['balance'] = $totalExpenses;
    $pnlExpensesList['parent'] = 0;

    $incomeStatementHTMLReport .= pnlExpEntry($pnlExpensesList, 'pnl-' . strtolower($pnlExpensesList['name']));

    // save expenses
    /*
    $expParentCode = $pnlExpensesList['parent'];
    $expCode = $pnlExpensesList['code'];
    $expName = $database->escape_value($pnlExpensesList['name']);
    $expLevel = $pnlExpensesList['level'];
    $expType = $pnlExpensesList['type'];
    $expBalance = $pnlExpensesList['balance'];
    $expChild = $pnlExpensesList['child'];

    $expPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $expParentCode, $expCode, '$expName', $expLevel, '$expType', NULL, NULL, $expBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $expPnLResult = $database->query($expPnLQuery);
    if (!$expPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$expName'";
    }

    foreach ($expChild as $expChild1) {
        $exp2ParentCode = $expChild1['parent'];
        $exp2Code = $expChild1['code'];
        $exp2Name = $database->escape_value($expChild1['name']);
        $exp2Level = $expChild1['level'];
        $exp2Type = $expChild1['type'];
        $exp2Balance = $expChild1['balance'];
        $exp2Child = $expChild1['child'];

        $exp2PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $exp2ParentCode, $exp2Code, '$exp2Name', $exp2Level, '$exp2Type', NULL, $exp2Balance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $exp2PnLResult = $database->query($exp2PnLQuery);
        if (!$exp2PnLResult) {
            $rollBack = true;
            $error = true;
            $incomeStatementError= true;
            $incomeStatementErrorMessage .= "Unable to save Income Statement item '$exp2Name'";
            break;
        }

        foreach ($exp2Child as $expChild2) {
            $exp3ParentCode = $expChild2['parent'];
            $exp3Code = $expChild2['code'];
            $exp3Name = $database->escape_value($expChild2['name']);
            $exp3Level = $expChild2['level'];
            $exp3Type = $expChild2['type'];
            $exp3Balance = $expChild2['balance'];
            $exp3Child = $expChild2['child'];

            $exp3PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $exp3ParentCode, $exp3Code, '$exp3Name', $exp3Level, '$exp3Type', $exp3Balance, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

            $exp3PnLResult = $database->query($exp3PnLQuery);
            if (!$exp3PnLResult) {
                $rollBack = true;
                $error = true;
                $incomeStatementError= true;
                $incomeStatementErrorMessage .= "Unable to save Income Statement item '$exp3Name'";
                break;
            }

            foreach ($exp3Child as $expChild3) {
                $exp4ParentCode = $expChild3['parent'];
                $exp4Code = $expChild3['code'];
                $exp4Name = $database->escape_value($expChild3['name']);
                $exp4Level = $expChild3['level'];
                $exp4Type = $expChild3['type'];
                $exp4Balance = $expChild3['balance'];

                $exp4PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $exp4ParentCode, $exp4Code, '$exp4Name', $exp4Level, '$exp4Type', $exp4Balance, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $exp4PnLResult = $database->query($exp4PnLQuery);
                if (!$exp4PnLResult) {
                    $rollBack = true;
                    $error = true;
                    $incomeStatementError= true;
                    $incomeStatementErrorMessage .= "Unable to save Income Statement item '$exp4Name'";
                    break;
                }

            }
        }
    }*/


    // net operating income
    $netOperatingIncome = $grossRevenueValue - $totalExpenses;

    $netOperatingIncomeEntry = array('parent' => 0, 'code' => $NET_OPERATING_INCOME_CODE, 'name' => "Net Operating Income", 'level' => 4, 'balance' => $netOperatingIncome);

    $incomeStatementHTMLReport .= pnlAccountLikeNoLinkEntry($netOperatingIncomeEntry, strtolower($netOperatingIncomeEntry['name']), 3);

    //save net operating income
    /*
    $nopParentCode = $netOperatingIncomeEntry['parent'];
    $nopCode = $netOperatingIncomeEntry['code'];
    $nopName = $database->escape_value($netOperatingIncomeEntry['name']);
    $nopLevel = $netOperatingIncomeEntry['level'];
    $nopBalance = $netOperatingIncomeEntry['balance'];

    $nopPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $nopParentCode, $nopCode, '$nopName', $nopLevel, '', NULL, NULL, $nopBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $nopPnLResult = $database->query($nopPnLQuery);
    if (!$nopPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$nopName'";
    }*/

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

    // save revenues
    /*
    $revParentCode = $pnlOtherRevenueList['parent'];
    $revCode = $pnlOtherRevenueList['code'];
    $revName = $database->escape_value($pnlOtherRevenueList['name']);
    $revLevel = $pnlOtherRevenueList['level'];
    $revType = $pnlOtherRevenueList['type'];
    $revBalance = $pnlOtherRevenueList['balance'];
    $revChild = $pnlOtherRevenueList['child'];

    $revPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $revParentCode, $revCode, '$revName', $revLevel, '$revType', NULL, NULL, $revBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $revPnLResult = $database->query($revPnLQuery);
    if (!$revPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$revName'";
    }

    foreach ($revChild as $revChild1) {
        $rev2ParentCode = $revChild1['parent'];
        $rev2Code = $revChild1['code'];
        $rev2Name = $database->escape_value($revChild1['name']);
        $rev2Level = $revChild1['level'];
        $rev2Type = $revChild1['type'];
        $rev2Balance = $revChild1['balance'];
        $rev2Child = $revChild1['child'];

        $rev2PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $rev2ParentCode, $rev2Code, '$rev2Name', $rev2Level, '$rev2Type', NULL, $rev2Balance, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $rev2PnLResult = $database->query($rev2PnLQuery);
        if (!$rev2PnLResult) {
            $rollBack = true;
            $error = true;
            $incomeStatementError= true;
            $incomeStatementErrorMessage .= "Unable to save Income Statement item '$rev2Name'";
            break;
        }

        foreach ($rev2Child as $revChild2) {
            $rev3ParentCode = $revChild2['parent'];
            $rev3Code = $revChild2['code'];
            $rev3Name = $database->escape_value($revChild2['name']);
            $rev3Level = $revChild2['level'];
            $rev3Type = $revChild2['type'];
            $rev3Balance = $revChild2['balance'];
            $rev3Child = $revChild2['child'];

            $rev3PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $rev3ParentCode, $rev3Code, '$rev3Name', $rev3Level, '$rev3Type', $rev3Balance, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

            $rev3PnLResult = $database->query($rev3PnLQuery);
            if (!$rev3PnLResult) {
                $rollBack = true;
                $error = true;
                $incomeStatementError= true;
                $incomeStatementErrorMessage .= "Unable to save Income Statement item '$rev3Name'";
                break;
            }

            foreach ($rev3Child as $revChild3) {
                $rev4ParentCode = $revChild3['parent'];
                $rev4Code = $revChild3['code'];
                $rev4Name = $database->escape_value($revChild3['name']);
                $rev4Level = $revChild3['level'];
                $rev4Type = $revChild3['type'];
                $rev4Balance = $revChild3['balance'];

                $rev4PnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', $rev4ParentCode, $rev4Code, '$rev4Name', $rev4Level, '$rev4Type', $rev4Balance, NULL, NULL, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $rev4PnLResult = $database->query($rev4PnLQuery);
                if (!$rev4PnLResult) {
                    $rollBack = true;
                    $error = true;
                    $incomeStatementError= true;
                    $incomeStatementErrorMessage .= "Unable to save Income Statement item '$rev4Name'";
                    break;
                }

            }
        }
    }*/

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


    // save net profit / loss
    /*
    $nplName = "Net " . $netProfitOrLoss;

    $nplPnLQuery = "INSERT INTO financials_income_statement(
                                    is_closing_type, is_parent_uid, is_account_uid, is_account_name, is_level, is_type, is_amount1, is_amount2, is_amount3, is_day_end_id, is_day_end_date, is_current_datetime)
                    VALUES ('$closingType', 0, 0, '$nplName', 0, '', NULL, NULL, $netProfitOrLossAbsoluteAmount, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $nplPnLResult = $database->query($nplPnLQuery);
    if (!$nplPnLResult) {
        $rollBack = true;
        $error = true;
        $incomeStatementError= true;
        $incomeStatementErrorMessage .= "Unable to save Income Statement item '$nplName'";
    }*/


    $pnlExeStopTime = microtime(true);
    $incomeStatementHTMLReport .= exeTimeDiv($pnlExeStopTime - $pnlExeStartTime);

    if ($incomeStatementError) {
        $error = true;
        $rollBack = true;
        $incomeStatementHTMLReport .= shortError($incomeStatementErrorMessage);
    } else {
        if ($netProfitOrLossAmount < 0) {
            $incomeStatementHTMLReport .= shortError("Sorry for your Loss!");
        }
    }

}
//}

/*
 *******************************************************************************************************************************
 *
 * Stop if Error
 *
 * ******************************************************************************************************************************
 */
if ($error || $rollBack) {
    $dieReport = $htmlHeader;
    $dieReport .= $headerErrorSection;
//    $dieReport .= $dailyDepreciationHTMPReport;
//    $dieReport .= $monthlyDepreciationHTMPReport;
    $dieReport .= $trialBalanceHTMLReport;
    $dieReport .= $stockValuesHTMLReport;
    $dieReport .= $cashFlowStatementHTMLReport;
    $dieReport .= $incomeStatementHTMLReport;
    $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved!");
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
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
        if ($entry['type'] == 'DR') {
            $amount = '(' . number_format($entry['balance'], 2) . ')';
        } elseif ($entry['type'] == 'CR') {
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
 * Getting all Profit/Loss accounts from capital registration
 *
 * ******************************************************************************************************************************
 */
$allRegisteredProfitAndLossAccountsList = array();
$allRegisteredProfitAndLossAccountsQuery = "SELECT group_concat(cr_profit_loss_account_uid) as pnlAccounts FROM financials_capital_register WHERE account_clg_id = $loginClgId;";
$allRegisteredProfitAndLossAccountsResult = $database->query($allRegisteredProfitAndLossAccountsQuery);
if ($allRegisteredProfitAndLossAccountsResult && $database->num_rows($allRegisteredProfitAndLossAccountsResult) > 0) {

    $tempPnLAccountsData = $database->fetch_assoc($allRegisteredProfitAndLossAccountsResult)['pnlAccounts'];
    $allRegisteredProfitAndLossAccountsList = explode(',', $tempPnLAccountsData);
    array_push($allRegisteredProfitAndLossAccountsList, $undistributedProfitLossAccountUID);

} else {
    $dieReport = $htmlHeader;
    $dieReport .= $headerSection;
    $dieReport .= error("Month End Execution Stop", "No registered capital found for Balance Sheet and Profit / Loss distribution!");
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 *******************************************************************************************************************************
 *
 * Reset account previous closing balance for today's
 *
 * ******************************************************************************************************************************
 */
//if ($createPnL || $createBalanceSheet || $createPnlDistribution) {
if ($mail == 1) {
    $accClosingResetQuery = "UPDATE financials_accounts SET account_monthly_opening_type = '', account_monthly_opening = 0, account_monthly_debit = 0, account_monthly_credit = 0 WHERE account_clg_id = $loginClgId AND account_id > 0;";
    $accClosingResetResult = $database->query($accClosingResetQuery);
    if (!$accClosingResetResult) {
        $error = true;
        $rollBack = true;
    }
}

/*
 *******************************************************************************************************************************
 *
 * Balance Sheet
 *
 * ******************************************************************************************************************************
 */
$balanceSheetHTMLReport = '';
$balanceSheetError = false;
$balanceSheetErrorMessage = "";

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($monthlyCompleteReport) {
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

    // save bs assets
    /*
    $bsAssetsParentCode = $bsAssetEntries['parent'];
    $bsAssetsCode = $bsAssetEntries['code'];
    $bsAssetsName = $database->escape_value($bsAssetEntries['name']);
    $bsAssetsLevel = $bsAssetEntries['level'];
    $bsAssetsType = $bsAssetEntries['type'];
    $bsAssetsBalance = $bsAssetEntries['balance'];
    $bsAssetsChild = $bsAssetEntries['child'];

    $bsAssetsQuery = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsAssetsParentCode, $bsAssetsCode, '$bsAssetsName', $bsAssetsLevel, '$bsAssetsType', $bsAssetsBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $bsAssetsResult = $database->query($bsAssetsQuery);
    if (!$bsAssetsResult) {
        $rollBack = true;
        $error = true;
        $balanceSheetError = true;
        $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsAssetsName'";
    }

    foreach ($bsAssetsChild as $bsAssetsChild1) {
        $bsAssets2ParentCode = $bsAssetsChild1['parent'];
        $bsAssets2Code = $bsAssetsChild1['code'];
        $bsAssets2Name = $database->escape_value($bsAssetsChild1['name']);
        $bsAssets2Level = $bsAssetsChild1['level'];
        $bsAssets2Type = $bsAssetsChild1['type'];
        $bsAssets2Balance = $bsAssetsChild1['balance'];
        $bsAssets2Child = $bsAssetsChild1['child'];

        $bsAssets2Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsAssets2ParentCode, $bsAssets2Code, '$bsAssets2Name', $bsAssets2Level, '$bsAssets2Type', $bsAssets2Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $bsAssets2Result = $database->query($bsAssets2Query);
        if (!$bsAssets2Result) {
            $rollBack = true;
            $error = true;
            $balanceSheetError = true;
            $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsAssets2Name'";
            break;
        }

        foreach ($bsAssets2Child as $bsAssetsChild2) {
            $bsAssets3ParentCode = $bsAssetsChild2['parent'];
            $bsAssets3Code = $bsAssetsChild2['code'];
            $bsAssets3Name = $database->escape_value($bsAssetsChild2['name']);
            $bsAssets3Level = $bsAssetsChild2['level'];
            $bsAssets3Type = $bsAssetsChild2['type'];
            $bsAssets3Balance = $bsAssetsChild2['balance'];
            $bsAssets3Child = $bsAssetsChild2['child'];

            $bsAssets3Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsAssets3ParentCode, $bsAssets3Code, '$bsAssets3Name', $bsAssets3Level, '$bsAssets3Type', $bsAssets3Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

            $bsAssets3Result = $database->query($bsAssets3Query);
            if (!$bsAssets3Result) {
                $rollBack = true;
                $error = true;
                $balanceSheetError = true;
                $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsAssets3Name'";
                break;
            }

            foreach ($bsAssets3Child as $bsAssetsChild3) {
                $bsAssets4ParentCode = $bsAssetsChild3['parent'];
                $bsAssets4Code = $bsAssetsChild3['code'];
                $bsAssets4Name = $database->escape_value($bsAssetsChild3['name']);
                $bsAssets4Level = $bsAssetsChild3['level'];
                $bsAssets4OpeningType = $bsAssetsChild3['opening_type'];
                $bsAssets4OpeningBalance = $bsAssetsChild3['opening'];
                $bsAssets4Inwards = $bsAssetsChild3['inwards'];
                $bsAssets4Outwards = $bsAssetsChild3['outwards'];
                $bsAssets4Type = $bsAssetsChild3['type'];
                $bsAssets4Balance = $bsAssetsChild3['balance'];

                $bsAssets4Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsAssets4ParentCode, $bsAssets4Code, '$bsAssets4Name', $bsAssets4Level, '$bsAssets4Type', $bsAssets4Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $bsAssets4Result = $database->query($bsAssets4Query);
                if (!$bsAssets4Result) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsAssets4Name'";
                    break;
                }

                // save opening closing balance of assets entry account
                $bsAssetsOCBQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
                                    VALUES ($bsAssets4Code, '$bsAssets4Name', '$bsAssets4OpeningType', $bsAssets4OpeningBalance, $bsAssets4Inwards, $bsAssets4Outwards, $bsAssets4Balance, '$bsAssets4Type', '$closingType', $currentDayEndId, '$currentDayEndDate');";

                $bsAssetsOCBResult = $database->query($bsAssetsOCBQuery);

                if (!$bsAssetsOCBResult) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Closing Balance of item '$bsAssets4Name'";
                    break;
                }

            }
        }
    }

    $bsAssets5Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', 0, 0, 'Total Assets', 0, '', $bsAssetBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $bsAssets5Result = $database->query($bsAssets5Query);
    if (!$bsAssets5Result) {
        $rollBack = true;
        $error = true;
        $balanceSheetError = true;
        $balanceSheetErrorMessage .= "Unable to save Balance Sheet item 'Total Assets'";
    }*/


    // liability
    $bsLiabilityBalance = 0;
    $bsLiabilitiesEntries = $trialViewList[LIABILITIES];

    $bsLiabilityBalance = $bsLiabilitiesEntries['balance'];
    $bsLiabilityBalanceType = $bsLiabilitiesEntries['type'];

    $balanceSheetHTMLReport .= bsEntry($bsLiabilitiesEntries, 'bs-' . strtolower($bsLiabilitiesEntries['name']));

    // save bs liability
    /*
    $bsLiabilityParentCode = $bsLiabilitiesEntries['parent'];
    $bsLiabilityCode = $bsLiabilitiesEntries['code'];
    $bsLiabilityName = $database->escape_value($bsLiabilitiesEntries['name']);
    $bsLiabilityLevel = $bsLiabilitiesEntries['level'];
    $bsLiabilityType = $bsLiabilitiesEntries['type'];
    $bsLiabilityBalance = $bsLiabilitiesEntries['balance'];
    $bsLiabilityChild = $bsLiabilitiesEntries['child'];

    $bsLiabilityQuery = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsLiabilityParentCode, $bsLiabilityCode, '$bsLiabilityName', $bsLiabilityLevel, '$bsLiabilityType', $bsLiabilityBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $bsLiabilityResult = $database->query($bsLiabilityQuery);
    if (!$bsLiabilityResult) {
        $rollBack = true;
        $error = true;
        $balanceSheetError= true;
        $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsLiabilityName'";
    }

    foreach ($bsLiabilityChild as $bsLiabilityChild1) {
        $bsLiability2ParentCode = $bsLiabilityChild1['parent'];
        $bsLiability2Code = $bsLiabilityChild1['code'];
        $bsLiability2Name = $database->escape_value($bsLiabilityChild1['name']);
        $bsLiability2Level = $bsLiabilityChild1['level'];
        $bsLiability2Type = $bsLiabilityChild1['type'];
        $bsLiability2Balance = $bsLiabilityChild1['balance'];
        $bsLiability2Child = $bsLiabilityChild1['child'];

        $bsLiability2Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsLiability2ParentCode, $bsLiability2Code, '$bsLiability2Name', $bsLiability2Level, '$bsLiability2Type', $bsLiability2Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $bsLiability2Result = $database->query($bsLiability2Query);
        if (!$bsLiability2Result) {
            $rollBack = true;
            $error = true;
            $balanceSheetError = true;
            $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsLiability2Name'";
            break;
        }

        foreach ($bsLiability2Child as $bsLiabilityChild2) {
            $bsLiability3ParentCode = $bsLiabilityChild2['parent'];
            $bsLiability3Code = $bsLiabilityChild2['code'];
            $bsLiability3Name = $database->escape_value($bsLiabilityChild2['name']);
            $bsLiability3Level = $bsLiabilityChild2['level'];
            $bsLiability3Type = $bsLiabilityChild2['type'];
            $bsLiability3Balance = $bsLiabilityChild2['balance'];
            $bsLiability3Child = $bsLiabilityChild2['child'];

            $bsLiability3Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsLiability3ParentCode, $bsLiability3Code, '$bsLiability3Name', $bsLiability3Level, '$bsLiability3Type', $bsLiability3Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

            $bsLiability3Result = $database->query($bsLiability3Query);
            if (!$bsLiability3Result) {
                $rollBack = true;
                $error = true;
                $balanceSheetError = true;
                $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsLiability3Name'";
                break;
            }

            foreach ($bsLiability3Child as $bsLiabilityChild3) {
                $bsLiability4ParentCode = $bsLiabilityChild3['parent'];
                $bsLiability4Code = $bsLiabilityChild3['code'];
                $bsLiability4Name = $database->escape_value($bsLiabilityChild3['name']);
                $bsLiability4Level = $bsLiabilityChild3['level'];
                $bsLiability4OpeningType = $bsLiabilityChild3['opening_type'];
                $bsLiability4OpeningBalance = $bsLiabilityChild3['opening'];
                $bsLiability4Inwards = $bsLiabilityChild3['inwards'];
                $bsLiability4Outwards = $bsLiabilityChild3['outwards'];
                $bsLiability4Type = $bsLiabilityChild3['type'];
                $bsLiability4Balance = $bsLiabilityChild3['balance'];

                $bsLiability4Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsLiability4ParentCode, $bsLiability4Code, '$bsLiability4Name', $bsLiability4Level, '$bsLiability4Type', $bsLiability4Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $bsLiability4Result = $database->query($bsLiability4Query);
                if (!$bsLiability4Result) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsLiability4Name'";
                    break;
                }

                // save opening closing balance of liability entry account
                $bsLiabilityOCBQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
                                    VALUES ($bsLiability4Code, '$bsLiability4Name','$bsLiability4OpeningType', $bsLiability4OpeningBalance, $bsLiability4Inwards, $bsLiability4Outwards, $bsLiability4Balance, '$bsLiability4Type', '$closingType', $currentDayEndId, '$currentDayEndDate');";

                $bsLiabilityOCBResult = $database->query($bsLiabilityOCBQuery);

                if (!$bsLiabilityOCBResult) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Closing Balance of item '$bsLiability4Name'";
                    break;
                }

            }
        }
    }*/


    // equity
    $bsEquityBalance = 0;
    $bsEquityEntries = $trialViewList[EQUITY];

    $bsEquityBalance = $bsEquityEntries['balance'];

    $balanceSheetHTMLReport .= bsEntry($bsEquityEntries, 'bs-' . strtolower($bsEquityEntries['name']));

    // save bs equity
    /*
    $bsEquityParentCode = $bsEquityEntries['parent'];
    $bsEquityCode = $bsEquityEntries['code'];
    $bsEquityName = $database->escape_value($bsEquityEntries['name']);
    $bsEquityLevel = $bsEquityEntries['level'];
    $bsEquityType = $bsEquityEntries['type'];
    $bsEquityBalance = $bsEquityEntries['balance'];
    $bsEquityChild = $bsEquityEntries['child'];

    $bsEquityQuery = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsEquityParentCode, $bsEquityCode, '$bsEquityName', $bsEquityLevel, '$bsEquityType', $bsEquityBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

    $bsEquityResult = $database->query($bsEquityQuery);
    if (!$bsEquityResult) {
        $rollBack = true;
        $error = true;
        $balanceSheetError = true;
        $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsEquityName'";
    }

    foreach ($bsEquityChild as $bsEquityChild1) {
        $bsEquity2ParentCode = $bsEquityChild1['parent'];
        $bsEquity2Code = $bsEquityChild1['code'];
        $bsEquity2Name = $database->escape_value($bsEquityChild1['name']);
        $bsEquity2Level = $bsEquityChild1['level'];
        $bsEquity2Type = $bsEquityChild1['type'];
        $bsEquity2Balance = $bsEquityChild1['balance'];
        $bsEquity2Child = $bsEquityChild1['child'];

        $bsEquity2Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsEquity2ParentCode, $bsEquity2Code, '$bsEquity2Name', $bsEquity2Level, '$bsEquity2Type', $bsEquity2Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

        $bsEquity2Result = $database->query($bsEquity2Query);
        if (!$bsEquity2Result) {
            $rollBack = true;
            $error = true;
            $balanceSheetError = true;
            $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsEquity2Name'";
            break;
        }

        foreach ($bsEquity2Child as $bsEquityChild2) {
            $bsEquity3ParentCode = $bsEquityChild2['parent'];
            $bsEquity3Code = $bsEquityChild2['code'];
            $bsEquity3Name = $database->escape_value($bsEquityChild2['name']);
            $bsEquity3Level = $bsEquityChild2['level'];
            $bsEquity3Type = $bsEquityChild2['type'];
            $bsEquity3Balance = $bsEquityChild2['balance'];
            $bsEquity3Child = $bsEquityChild2['child'];

            $bsEquity3Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsEquity3ParentCode, $bsEquity3Code, '$bsEquity3Name', $bsEquity3Level, '$bsEquity3Type', $bsEquity3Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

            $bsEquity3Result = $database->query($bsEquity3Query);
            if (!$bsEquity3Result) {
                $rollBack = true;
                $error = true;
                $balanceSheetError = true;
                $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsEquity3Name'";
                break;
            }

            foreach ($bsEquity3Child as $bsEquityChild3) {
                $bsEquity4ParentCode = $bsEquityChild3['parent'];
                $bsEquity4Code = $bsEquityChild3['code'];
                $bsEquity4Name = $database->escape_value($bsEquityChild3['name']);
                $bsEquity4Level = $bsEquityChild3['level'];
                $bsEquity4OpeningType = $bsEquityChild3['opening_type'];
                $bsEquity4OpeningBalance = $bsEquityChild3['opening'];
                $bsEquity4Inwards = $bsEquityChild3['inwards'];
                $bsEquity4Outwards = $bsEquityChild3['outwards'];
                $bsEquity4Type = $bsEquityChild3['type'];
                $bsEquity4Balance = $bsEquityChild3['balance'];

                $bsEquity4Query = "INSERT INTO financials_balance_sheet(
                                    bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
                    VALUES ('$closingType', $bsEquity4ParentCode, $bsEquity4Code, '$bsEquity4Name', $bsEquity4Level, '$bsEquity4Type', $bsEquity4Balance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";

                $bsEquity4Result = $database->query($bsEquity4Query);
                if (!$bsEquity4Result) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$bsEquity4Name'";
                    break;
                }

                // save opening closing balance of equity entry account except profit and loss of each owner/investor
                if ($netProfitOrLossAbsoluteAmount > 0 && in_array($bsEquity4Code, $allRegisteredProfitAndLossAccountsList)) {
                    // do not add all registered pnl account into opening closing table
                    // these account added to opening closing table after profit distribution
                    continue;
                }

                $bsEquityOCBQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
                                    VALUES ($bsEquity4Code, '$bsEquity4Name', '$bsEquity4OpeningType', $bsEquity4OpeningBalance, $bsEquity4Inwards, $bsEquity4Outwards, $bsEquity4Balance, '$bsEquity4Type', '$closingType', $currentDayEndId, '$currentDayEndDate');";

                $bsEquityOCBResult = $database->query($bsEquityOCBQuery);

                if (!$bsEquityOCBResult) {
                    $rollBack = true;
                    $error = true;
                    $balanceSheetError = true;
                    $balanceSheetErrorMessage .= "Unable to save Closing Balance of item '$bsEquity4Name'";
                    break;
                }

            }
        }
    }*/


    // current profit / loss
    if ($netProfitOrLossAbsoluteAmount > 0) {
        $bsProfitLossAmount = $netProfitOrLoss == "Profit" ? number_format($netProfitOrLossAbsoluteAmount, 2) : "(" . number_format($netProfitOrLossAbsoluteAmount, 2) . ")";

        $cPoL = "Current $netProfitOrLoss";

        $balanceSheetHTMLReport .= '
                <tr class="normalHover">
                    <td class="text-left tbl_txt_59">
                        ' . $cPoL . '
                    </td>
                    <td class="text-right tbl_srl_18">
                        ' . $bsProfitLossAmount . '
                    </td>
                    <td class="text-right tbl_srl_18">

                    </td>
                </tr>
            ';

        // save current profit / loss
//            $bsCurrentPoLQuery = "INSERT INTO financials_balance_sheet(
//                                        bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
//                        VALUES ('$closingType', 0, 0, '$cPoL', 0, '', $netProfitOrLossAbsoluteAmount, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
//
//            $bsCurrentPoLResult = $database->query($bsCurrentPoLQuery);
//            if (!$bsCurrentPoLResult) {
//                $rollBack = true;
//                $error = true;
//                $balanceSheetError = true;
//                $balanceSheetErrorMessage .= "Unable to save Balance Sheet item '$cPoL'";
//            }

    }


    if ($bsLiabilityBalanceType == 'DR') {
        $bsLiabilityBalance = $bsLiabilityBalance * (-1);
    }

    // total liability + equity
    $bsTotalLiabilityEquityBalance = (double)$bsLiabilityBalance + (double)$bsEquityBalance + (double)$netProfitOrLossAmount;

    $balanceSheetHTMLReport .= '
            <tr class="normalHover">
                <th class="text-left tbl_txt_59">
                    Total (Liabilities + Equity)
                </th>
                <td class="text-right tbl_srl_18">

                </td>
                <th class="text-right tbl_srl_18 gnrl-bg">
                    ' . number_format($bsTotalLiabilityEquityBalance, 2) . '
                </th>
            </tr>
        ';

    $balanceSheetHTMLReport .= '
            </tbody>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

    // save total liability + equity
//        $bsLiabilityEquityQuery = "INSERT INTO financials_balance_sheet(
//                                        bs_closing_type, bs_parent_uid, bs_account_uid, bs_account_name, bs_level, bs_type, bs_amount, bs_day_end_id, bs_day_end_date, bs_current_datetime)
//                        VALUES ('$closingType', 0, 0, 'Total (Liabilities + Equity)', 0, '', $bsTotalLiabilityEquityBalance, $currentDayEndId, '$currentDayEndDate', '$dbTimeStamp');";
//
//        $bsLiabilityEquityResult = $database->query($bsLiabilityEquityQuery);
//        if (!$bsLiabilityEquityResult) {
//            $rollBack = true;
//            $error = true;
//            $balanceSheetError = true;
//            $balanceSheetErrorMessage .= "Unable to save Balance Sheet item 'Total (Liabilities + Equity)'";
//        }


    $bsExeStopTime = microtime(true);
    $balanceSheetHTMLReport .= exeTimeDiv($bsExeStopTime - $bsExeStartTime);

    $bsDiff = abs((double)number_format($bsAssetBalance, 2, '.', '') - (double)number_format($bsTotalLiabilityEquityBalance, 2, '.', ''));

    if ($bsDiff > 0) {
        $diffErr = "Balance Sheet is not equal, Difference amount is: <strong> " . number_format($bsDiff, 2) . " </strong> Please contact to your admin to adjust this amount. Balance Sheet must be Equal for Month End procedure!";
        $balanceSheetHTMLReport .= shortError($diffErr);
        $error = true;
    }

    if ($balanceSheetError) {
        $rollBack = true;
        $error = true;
        $balanceSheetHTMLReport .= shortError($balanceSheetErrorMessage);
    }
}
//}

/*
 *******************************************************************************************************************************
 *
 * Stop if Error
 *
 * ******************************************************************************************************************************
 */
if ($error || $rollBack) {
    $dieReport = $htmlHeader;
    $dieReport .= $headerErrorSection;
//    $dieReport .= $dailyDepreciationHTMPReport;
//    $dieReport .= $monthlyDepreciationHTMPReport;
    $dieReport .= $trialBalanceHTMLReport;
    $dieReport .= $stockValuesHTMLReport;
    $dieReport .= $cashFlowStatementHTMLReport;
    $dieReport .= $incomeStatementHTMLReport;
    $dieReport .= $balanceSheetHTMLReport;
    $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved!");
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 *******************************************************************************************************************************
 *
 * Profit Distribution
 *
 * ******************************************************************************************************************************
 */
$profitLossDistributionHTMLReport = '';
$profitLossDistributionError = false;
$profitLossDistributionErrorMessage = "";

//if ($createTrial && $creatClosingStock && ($createPnL || $createBalanceSheet || $createPnlDistribution)) {
//if ($monthlyCompleteReport) {
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

            $pnlOpType = "";
            $pnlOpBalance = 0;
            $pnlOpInwards = 0;
            $pnlOpOutwards = 0;

            if (array_key_exists(substr($profitAndLossAccountUID, 0, 1), $trialViewList)) {
                if (array_key_exists(substr($profitAndLossAccountUID, 0, 3), $trialViewList[substr($profitAndLossAccountUID, 0, 1)]['child'])) {
                    if (array_key_exists(substr($profitAndLossAccountUID, 0, 5), $trialViewList[substr($profitAndLossAccountUID, 0, 1)]['child'][substr($profitAndLossAccountUID, 0, 3)]['child'])) {
                        if (array_key_exists($profitAndLossAccountUID, $trialViewList[substr($profitAndLossAccountUID, 0, 1)]['child'][substr($profitAndLossAccountUID, 0, 3)]['child'][substr($profitAndLossAccountUID, 0, 5)]['child'])) {
                            $entryPnLAccount = $trialViewList[substr($profitAndLossAccountUID, 0, 1)]['child'][substr($profitAndLossAccountUID, 0, 3)]['child'][substr($profitAndLossAccountUID, 0, 5)]['child'][$profitAndLossAccountUID];
                            $pnlOpType = $entryPnLAccount['opening_type'];
                            $pnlOpBalance = $entryPnLAccount['opening'];
                            $pnlOpInwards = $entryPnLAccount['inwards'];
                            $pnlOpOutwards = $entryPnLAccount['outwards'];
                        }
                    }
                }
            }

            $capUser = getUser($capitalRegistration['cr_user_id']);
            $capUserName = "Unknown";
            if ($capUser->found == true) {
                $capUserName = $capUser->properties->user_name;
            }

            $totalCapital = 0;

            $capitalAccountBalance = getAccountClosingBalance($capitalAccountUID,$loginClgId)->balance;
            $profitAndLossAccountBalance = getAccountClosingBalance($profitAndLossAccountUID,$loginClgId)->balance;
            $reserveAccountBalance = getAccountClosingBalance($reserveAccountUID,$loginClgId)->balance;
            $drawingAccountBalance = getAccountClosingBalance($drawingAccountUID,$loginClgId)->balance;

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


            // save admin profit and hit account ledger
            $drBalance = 0;
            $crBalance = 0;

            $type = "";

            if ($netProfitOrLoss == "Profit") {
                $crBalance = $netProfitOrLossAbsoluteAmount;
                $type = "Credit";
                $pnlOpOutwards += $netProfitOrLossAbsoluteAmount;
                $newProfitAndLossAccountBalance = $profitAndLossAccountBalance + $netProfitOrLossAbsoluteAmount;
            } else {
                $drBalance = $netProfitOrLossAbsoluteAmount;
                $type = "Debit";
                $pnlOpInwards += $netProfitOrLossAbsoluteAmount;
                $newProfitAndLossAccountBalance = $profitAndLossAccountBalance - $netProfitOrLossAbsoluteAmount;
            }

            $adminPoLRemarks = "'$netProfitOrLoss' amount " . number_format($netProfitOrLossAbsoluteAmount, 2) . " $type for dated $currentUserReadableDate";
            $adminPoLRemarks = $database->escape_value($adminPoLRemarks);

//                $adminPnLBalanceQuery = "INSERT INTO financials_balances(
//                                bal_account_id, bal_transaction_type, bal_dr, bal_cr, bal_total, bal_remarks, bal_transaction_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_user_id)
//                                VALUES (
//                                    $profitAndLossAccountUID, 'DAY_END_PROFIT_LOSS', $drBalance, $crBalance, $newProfitAndLossAccountBalance, '$adminPoLRemarks', 0, $currentDayEndId, '$currentDayEndDate', '$adminPoLRemarks', '', $loginUserId
//                                    );";
//
//                $adminPnLBalanceResult = $database->query($adminPnLBalanceQuery);
//
//                if (!$adminPnLBalanceResult) {
//                    $error = true;
//                    $rollBack = True;
//                    $balanceSheetError = true;
//                    $balanceSheetErrorMessage .= "Unable to save admin $netProfitOrLoss to ledger";
//                }

            // save admin profit to account opening closing
            if ($newProfitAndLossAccountBalance >= 0) {
                $newProfitAndLossAccountBalanceType = "CR";
            } else {
                $newProfitAndLossAccountBalanceType = "DR";
            }

            $newProfitAndLossAccountBalance = abs($newProfitAndLossAccountBalance);

            $capAccountName = $database->escape_value("Profit & Loss - $capUserName");

//                $adminPnLOCBalanceQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
//                        VALUES ($profitAndLossAccountUID, '$capAccountName', '$pnlOpType', $pnlOpBalance, $pnlOpInwards, $pnlOpOutwards, $newProfitAndLossAccountBalance, '$newProfitAndLossAccountBalanceType', '$closingType', $currentDayEndId, '$currentDayEndDate');";
//
//                $adminPnLOCBalanceResult = $database->query($adminPnLOCBalanceQuery);
//
//                if (!$adminPnLOCBalanceResult) {
//                    $rollBack = true;
//                    $error = true;
//                    $balanceSheetError = true;
//                    $balanceSheetErrorMessage .= "Unable to save closing balance of admin $netProfitOrLoss";
//                }


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

                $capitalAccountBalance = getAccountClosingBalance($capitalAccountUID,$loginClgId)->balance;
                $profitAndLossAccountBalance = getAccountClosingBalance($profitAndLossAccountUID,$loginClgId)->balance;
                $reserveAccountBalance = getAccountClosingBalance($reserveAccountUID,$loginClgId)->balance;
                $drawingAccountBalance = getAccountClosingBalance($drawingAccountUID,$loginClgId))->balance;

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
                    (SELECT count(*) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $SLEEPING_PARTNER) as sleeping
                ";

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
                    (SELECT group_concat(cr_user_id) FROM financials_capital_register WHERE cr_clg_id = $loginClgId AND cr_partner_nature = $SLEEPING_PARTNER) as sleeping
                ";

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

                $eachProfitAndLossAccountUID = $eachProfit->profit_loss_account_uid;

                $pnlOpType = "";
                $pnlOpBalance = 0;
                $pnlOpInwards = 0;
                $pnlOpOutwards = 0;

                if (array_key_exists(substr($eachProfitAndLossAccountUID, 0, 1), $trialViewList)) {
                    if (array_key_exists(substr($eachProfitAndLossAccountUID, 0, 3), $trialViewList[substr($eachProfitAndLossAccountUID, 0, 1)]['child'])) {
                        if (array_key_exists(substr($eachProfitAndLossAccountUID, 0, 5), $trialViewList[substr($eachProfitAndLossAccountUID, 0, 1)]['child'][substr($eachProfitAndLossAccountUID, 0, 3)]['child'])) {
                            if (array_key_exists($eachProfitAndLossAccountUID, $trialViewList[substr($eachProfitAndLossAccountUID, 0, 1)]['child'][substr($eachProfitAndLossAccountUID, 0, 3)]['child'][substr($eachProfitAndLossAccountUID, 0, 5)]['child'])) {
                                $entryPnLAccount = $trialViewList[substr($eachProfitAndLossAccountUID, 0, 1)]['child'][substr($eachProfitAndLossAccountUID, 0, 3)]['child'][substr($eachProfitAndLossAccountUID, 0, 5)]['child'][$eachProfitAndLossAccountUID];
                                $pnlOpType = $entryPnLAccount['opening_type'];
                                $pnlOpBalance = $entryPnLAccount['opening'];
                                $pnlOpInwards = $entryPnLAccount['inwards'];
                                $pnlOpOutwards = $entryPnLAccount['outwards'];
                            }
                        }
                    }
                }

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


                // save all owners/investors profit and hit ledgers
                $profitAndLossAccount = getAccountClosingBalance($eachProfitAndLossAccountUID,$loginClgId);
                $profitAndLossAccountBalance = $profitAndLossAccount->balance;

                if ($totalProfitLossAmount != 0) {

                    $drBalance = 0;
                    $crBalance = 0;

                    $type = "";

                    if ($netProfitOrLoss == "Profit") {
                        $crBalance = $totalProfitLossAmount;
                        $type = "Credit";
                        $pnlOpOutwards += $totalProfitLossAmount;
                        $newProfitAndLossAccountBalance = $profitAndLossAccountBalance + $totalProfitLossAmount;
                    } else {
                        $drBalance = $totalProfitLossAmount;
                        $type = "Debit";
                        $pnlOpInwards += $totalProfitLossAmount;
                        $newProfitAndLossAccountBalance = $profitAndLossAccountBalance - $totalProfitLossAmount;
                    }

                    $adminPoLRemarks = "'$netProfitOrLoss' amount " . number_format($totalProfitLossAmount, 2) . " $type for dated $currentUserReadableDate";
                    $adminPoLRemarks = $database->escape_value($adminPoLRemarks);

//                        $adminPnLBalanceQuery = "INSERT INTO financials_balances(
//                                bal_account_id, bal_transaction_type, bal_dr, bal_cr, bal_total, bal_remarks, bal_transaction_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_user_id)
//                                VALUES (
//                                    $eachProfitAndLossAccountUID, 'DAY_END_PROFIT_LOSS', $drBalance, $crBalance, $newProfitAndLossAccountBalance, '$adminPoLRemarks', 0, $currentDayEndId, '$currentDayEndDate', '$adminPoLRemarks', '', $loginUserId
//                                    );";
//
//                        $adminPnLBalanceResult = $database->query($adminPnLBalanceQuery);
//
//                        if (!$adminPnLBalanceResult) {
//                            $error = true;
//                            $rollBack = True;
//                            $balanceSheetError = true;
//                            $balanceSheetErrorMessage .= "Unable to save admin $netProfitOrLoss to ledger";
//                            break;
//                        }

                }


                // save all owners/investors profit closing balance
                if ($newProfitAndLossAccountBalance >= 0) {
                    $newProfitAndLossAccountBalanceType = 'CR';
                } else{
                    $newProfitAndLossAccountBalanceType = 'DR';
                }

                $newProfitAndLossAccountBalance = abs($newProfitAndLossAccountBalance);

                $capAccountName = $database->escape_value("Profit & Loss - $capUserName");

//                    $adminPnLOCBalanceQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
//                        VALUES ($eachProfitAndLossAccountUID, '$capAccountName', '$pnlOpType', $pnlOpBalance, $pnlOpInwards, $pnlOpOutwards, $newProfitAndLossAccountBalance, '$newProfitAndLossAccountBalanceType', '$closingType', $currentDayEndId, '$currentDayEndDate');";
//
//                    $adminPnLOCBalanceResult = $database->query($adminPnLOCBalanceQuery);
//
//                    if (!$adminPnLOCBalanceResult) {
//                        $rollBack = true;
//                        $error = true;
//                        $balanceSheetError = true;
//                        $balanceSheetErrorMessage .= "Unable to save closing balance of admin $netProfitOrLoss";
//                        break;
//                    }


            }

            if ($totalTotalAmount != $netProfitOrLossAbsoluteAmount) {
                $remainingPnLAmount = $netProfitOrLossAbsoluteAmount - $totalTotalAmount;
                $undistributedProfitAndLossAmount += $remainingPnLAmount;
            }

            if (number_format($undistributedProfitAndLossAmount, 2, '.', '') != 0.00) {

                $totalTotalAmount += $undistributedProfitAndLossAmount;

                $pnlOpType = "";
                $pnlOpBalance = 0;
                $pnlOpInwards = 0;
                $pnlOpOutwards = 0;

                if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 1), $trialViewList)) {
                    if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 3), $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'])) {
                        if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 5), $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'])) {
                            if (array_key_exists($undistributedProfitLossAccountUID, $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'][substr($undistributedProfitLossAccountUID, 0, 5)]['child'])) {
                                $entryPnLAccount = $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'][substr($undistributedProfitLossAccountUID, 0, 5)]['child'][$undistributedProfitLossAccountUID];
                                $pnlOpType = $entryPnLAccount['opening_type'];
                                $pnlOpBalance = $entryPnLAccount['opening'];
                                $pnlOpInwards = $entryPnLAccount['inwards'];
                                $pnlOpOutwards = $entryPnLAccount['outwards'];
                            }
                        }
                    }
                }

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


                // save Undistributed Profit & Loss balance and hit ledgers
                $undistributedProfitLossAccount = getAccountClosingBalance($undistributedProfitLossAccountUID,$loginClgId);
                $undistributedProfitLossAccountBalance = $undistributedProfitLossAccount->balance;

                $drBalance = 0;
                $crBalance = 0;

                $type = "";

                if ($netProfitOrLoss == "Profit") {
                    $crBalance = $undistributedProfitAndLossAmount;
                    $type = "Credit";
                    $pnlOpOutwards += $undistributedProfitAndLossAmount;
                    $newUndistributedProfitLossAccountBalance = $undistributedProfitLossAccountBalance + $undistributedProfitAndLossAmount;
                } else {
                    $drBalance = $undistributedProfitAndLossAmount;
                    $type = "Debit";
                    $pnlOpInwards += $undistributedProfitAndLossAmount;
                    $newUndistributedProfitLossAccountBalance = $undistributedProfitLossAccountBalance - $undistributedProfitAndLossAmount;
                }

                $undistributedPoLRemarks = "'$netProfitOrLoss' amount " . number_format($undistributedProfitAndLossAmount, 2) . " $type for dated $currentUserReadableDate";
                $undistributedPoLRemarks = $database->escape_value($undistributedPoLRemarks);

//                    $undistributedPnLBalanceQuery = "INSERT INTO financials_balances(
//                                bal_account_id, bal_transaction_type, bal_dr, bal_cr, bal_total, bal_remarks, bal_transaction_id, bal_day_end_id, bal_day_end_date, bal_detail_remarks, bal_voucher_number, bal_user_id)
//                                VALUES (
//                                    $undistributedProfitLossAccountUID, 'DAY_END_PROFIT_LOSS', $drBalance, $crBalance, $newUndistributedProfitLossAccountBalance, '$undistributedPoLRemarks', 0, $currentDayEndId, '$currentDayEndDate', '$undistributedPoLRemarks', '', $loginUserId
//                                    );";
//
//                    $undistributedPnLBalanceResult = $database->query($undistributedPnLBalanceQuery);
//
//                    if (!$undistributedPnLBalanceResult) {
//                        $error = true;
//                        $rollBack = True;
//                        $balanceSheetError = true;
//                        $balanceSheetErrorMessage .= "Unable to save Undistributed Profit & Loss closing balance";
//                    }


                // save Undistributed Profit & Loss closing balance
                if ($newUndistributedProfitLossAccountBalance >= 0) {
                    $newUndistributedProfitLossAccountBalanceType = 'CR';
                } else{
                    $newUndistributedProfitLossAccountBalanceType = 'DR';
                }

                $newUndistributedProfitLossAccountBalance = abs($newUndistributedProfitLossAccountBalance);

//                    $newUndistributedProfitLossAccountOCBalancesQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
//                        VALUES ($undistributedProfitLossAccountUID, 'Undistributed Profit & Loss', '$pnlOpType', $pnlOpBalance, $pnlOpInwards, $pnlOpOutwards, $newUndistributedProfitLossAccountBalance, '$newUndistributedProfitLossAccountBalanceType', '$closingType', $currentDayEndId, '$currentDayEndDate');";
//
//                    $newUndistributedProfitLossAccountOCBalancesResult = $database->query($newUndistributedProfitLossAccountOCBalancesQuery);
//
//                    if (!$newUndistributedProfitLossAccountOCBalancesResult) {
//                        $rollBack = true;
//                        $error = true;
//                        $balanceSheetError = true;
//                        $balanceSheetErrorMessage .= "Unable to save Undistributed Profit & Loss closing balance";
//                    }


            } else {
                // save previous undistributed profit/loss to opening closing if its zero
                $undistributedProfitLossAccount = getAccountClosingBalance($undistributedProfitLossAccountUID,$loginClgId);
                $undistributedProfitLossAccountBalance = $undistributedProfitLossAccount->balance;

                if ($undistributedProfitLossAccountBalance >= 0) {
                    $newUndistributedProfitLossAccountBalanceType = 'CR';
                } else {
                    $newUndistributedProfitLossAccountBalanceType = 'DR';
                }

                $newUndistributedProfitLossAccountBalance = abs($undistributedProfitLossAccountBalance);

                $pnlOpType = "";
                $pnlOpBalance = 0;
                $pnlOpInwards = 0;
                $pnlOpOutwards = 0;

                if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 1), $trialViewList)) {
                    if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 3), $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'])) {
                        if (array_key_exists(substr($undistributedProfitLossAccountUID, 0, 5), $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'])) {
                            if (array_key_exists($undistributedProfitLossAccountUID, $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'][substr($undistributedProfitLossAccountUID, 0, 5)]['child'])) {
                                $entryPnLAccount = $trialViewList[substr($undistributedProfitLossAccountUID, 0, 1)]['child'][substr($undistributedProfitLossAccountUID, 0, 3)]['child'][substr($undistributedProfitLossAccountUID, 0, 5)]['child'][$undistributedProfitLossAccountUID];
                                $pnlOpType = $entryPnLAccount['opening_type'];
                                $pnlOpBalance = $entryPnLAccount['opening'];
                                $pnlOpInwards = $entryPnLAccount['inwards'];
                                $pnlOpOutwards = $entryPnLAccount['outwards'];
                            }
                        }
                    }
                }

//                    $undistributedProfitLossAccountBalancesQuery = "INSERT INTO financials_account_opening_closing_balance (aoc_account_uid, aoc_account_name, aoc_op_type, aoc_op_balance, aoc_inwards, aoc_outwards, aoc_balance, aoc_type, aoc_closing_type, aoc_day_end_id, aoc_day_end_date)
//                        VALUES ($undistributedProfitLossAccountUID, 'Undistributed Profit & Loss', '$pnlOpType', $pnlOpBalance, $pnlOpInwards, $pnlOpOutwards, $newUndistributedProfitLossAccountBalance, '$newUndistributedProfitLossAccountBalanceType', '$closingType', $currentDayEndId, '$currentDayEndDate');";
//
//                    $undistributedProfitLossAccountBalancesResult = $database->query($undistributedProfitLossAccountBalancesQuery);
//
//                    if (!$undistributedProfitLossAccountBalancesResult) {
//                        $rollBack = true;
//                        $error = true;
//                        $balanceSheetError = true;
//                        $balanceSheetErrorMessage .= "Unable to save Undistributed Profit & Loss closing balance";
//                    }
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

        if ($profitLossDistributionError) {
            $profitLossDistributionHTMLReport .= shortError($profitLossDistributionErrorMessage);
        }

    } else {

        $error = true;

        $profitLossDistributionHTMLReport .= shortError("No capital account found for distribution " . $netProfitOrLoss . "!");

    }

}

//}

/*
 *******************************************************************************************************************************
 *
 * Stop if Error
 *
 * ******************************************************************************************************************************
 */
if ($error || $rollBack) {
    $dieReport = $htmlHeader;
    $dieReport .= $headerErrorSection;
    $dieReport .= $dailyDepreciationHTMPReport;
    $dieReport .= $monthlyDepreciationHTMPReport;
    $dieReport .= $trialBalanceHTMLReport;
    $dieReport .= $stockValuesHTMLReport;
    $dieReport .= $cashFlowStatementHTMLReport;
    $dieReport .= $incomeStatementHTMLReport;
    $dieReport .= $balanceSheetHTMLReport;
    $dieReport .= $profitLossDistributionHTMLReport;
    $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved!");
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);
}

/*
 *******************************************************************************************************************************
 *
 * Closing of day end date and move to next date
 *
 * ******************************************************************************************************************************
*/
$dayClosingError = false;
$dayClosingErrorMessage = "";

if ($error || $rollBack) {

//    $query = "UPDATE financials_day_end SET de_datetime_status = 'CLOSE', de_update_datetime = '$dbTimeStamp', de_createdby = $loginUserId, de_ip_adrs = '$ipAddress', de_brwsr_info = '$type'
//                WHERE de_datetime_status = 'PROCESSING' AND de_id = $currentDayEndId ORDER BY de_id DESC LIMIT 1;";
//
//    $result = $database->query($query);
//
//    if(!$result || $database->affected_rows() != 1) {
//        $error = true;
//        $rollBack = true;
//        $dayClosingError = true;
//        $dayClosingErrorMessage .= "Unable to Close current day end!";
//    }

    $dieReport = $htmlHeader;
    $dieReport .= $headerErrorSection;
    $dieReport .= $dailyDepreciationHTMPReport;
    $dieReport .= $monthlyDepreciationHTMPReport;
    $dieReport .= $trialBalanceHTMLReport;
    $dieReport .= $stockValuesHTMLReport;
    $dieReport .= $cashFlowStatementHTMLReport;
    $dieReport .= $incomeStatementHTMLReport;
    $dieReport .= $balanceSheetHTMLReport;
    $dieReport .= $profitLossDistributionHTMLReport;
    $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved!");

    if ($dayClosingError) {
        $dieReport .= shortError($dayClosingErrorMessage);
    }
    $dieReport .= $htmlFooter;

    $database->rollBack();

    if (isset($database)) {
        $database->close_connection();
    }

    die($dieReport);

} else {

//    $query = "UPDATE financials_day_end SET de_datetime_status = 'CLOSE', de_update_datetime = '$dbTimeStamp', de_createdby = $loginUserId, de_ip_adrs = '$ipAddress', de_brwsr_info = '$type'
//                WHERE de_datetime_status = 'PROCESSING' AND de_id = $currentDayEndId ORDER BY de_id DESC LIMIT 1;";
//
//    $result = $database->query($query);
//
//    if(!$result || $database->affected_rows() != 1) {
//
//        $error = true;
//        $rollBack = true;
//        $dayClosingError = true;
//        $dayClosingErrorMessage .= "Unable to Close current day end!";
//
//        $dieReport = $htmlHeader;
//        $dieReport .= $headerErrorSection;
//        $dieReport .= $dailyDepreciationHTMPReport;
//        $dieReport .= $monthlyDepreciationHTMPReport;
//        $dieReport .= $trialBalanceHTMLReport;
//        $dieReport .= $stockValuesHTMLReport;
//        $dieReport .= $cashFlowStatementHTMLReport;
//        $dieReport .= $incomeStatementHTMLReport;
//        $dieReport .= $balanceSheetHTMLReport;
//        $dieReport .= $profitLossDistributionHTMLReport;
//        $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved! " . $dayClosingErrorMessage);
//        $dieReport .= $htmlFooter;
//
//        $database->rollBack();
//
//        if (isset($database)) {
//            $database->close_connection();
//        }
//
//        die($dieReport);
//
//    }

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

/*
 *******************************************************************************************************************************
 *
 * Success message
 *
 * ******************************************************************************************************************************
 */
$successMessage = "";
if (!$error && !$rollBack) {
    $successMessage = successMessage("Month End Executed Successfully", "Month End Executed and report generated Successfully.");
}

/*
 *******************************************************************************************************************************
 *
 * Generate Complete Report
 *
 * ******************************************************************************************************************************
 */
// print content
$content = "";
$content .= $htmlHeader;
$content .= $headerSection;
//$content .= $dailyDepreciationHTMPReport;
//$content .= $monthlyDepreciationHTMPReport;
$content .= $trialBalanceHTMLReport;
$content .= $stockValuesHTMLReport;
$content .= $cashFlowStatementHTMLReport;
$content .= $incomeStatementHTMLReport;
$content .= $balanceSheetHTMLReport;
$content .= $profitLossDistributionHTMLReport;
$content .= $successMessage;

// mail content
$mailContent = "";
$mailContent .= $htmlInternalCSSHeader;
$mailContent .= $headerSection;
//$mailContent .= $dailyDepreciationHTMPReport;
//$mailContent .= $monthlyDepreciationHTMPReport;
$mailContent .= $trialBalanceHTMLReport;
$mailContent .= $stockValuesHTMLReport;
$mailContent .= $cashFlowStatementHTMLReport;
$mailContent .= $incomeStatementHTMLReport;
$mailContent .= $balanceSheetHTMLReport;
$mailContent .= $profitLossDistributionHTMLReport;
$mailContent .= $successMessage;

/*
 *******************************************************************************************************************************
 *
 * Month End executed successfully, now committing all changes
 *
 * ******************************************************************************************************************************
*/
$successMessage = "";
if (!$error && !$rollBack) {
//    $database->commit();

    $reportExeStopTime = microtime(true);

    // note section
    $noteSectionWithURLs = "";
    $noteSectionWithOutURLs = getInfoSection($userName, $userEmail, $userCellNumber, $userTimeStamp, $reportExeStopTime - $reportExeStartTime);

    // save complete report as html file
    $dayEndHTMLReportCompleteURL = "";

    if ($mail == 1) {

        try {

            $currentDayEndIdMD5 = md5($currentDayEndId);
            $fp = fopen($monthEndReportFolder . "/" . $currentDayEndIdMD5 . ".html","wb");

            $fileWriteContent = $content;
            $fileWriteContent .= $noteSectionWithOutURLs;
            $fileWriteContent .= $htmlScriptsFooter;

            fwrite($fp, $fileWriteContent);
            fclose($fp);
            $dayEndHTMLReportCompleteURL = $subDomain . $dayEndFolderPath . "view_report.php?t=" . TYPE_MONTH_END . "&n=" . $currentDayEndIdMD5;

        } catch (Exception $e) {
            echo "File error<br />";
        }

        $noteSectionWithURLs = getInfoSection($userName, $userEmail, $userCellNumber, $userTimeStamp, $reportExeStopTime - $reportExeStartTime, $dayEndHTMLReportCompleteURL);

//     save month end report url
        $dayEndReportURLQuery = "UPDATE financials_day_end SET de_month_end_report_url = '$dayEndHTMLReportCompleteURL', de_last_day_of_month = 1, de_month_status = 'REPORTED' WHERE de_id = $currentDayEndId LIMIT 1;";
        $dayEndReportURLResult = $database->query($dayEndReportURLQuery);
        echo "day end updated fro month report<br />";

    }

    $content .= $noteSectionWithOutURLs;
    $content .= $htmlFooter;

//    try {
//
//        $date = new DateTime($currentDayEndDate);
//        $nDate = $date->modify('+1 day');
//        $newDate = $nDate->format(DB_DATE_STAMP_FORMAT);
//
//        $query = "INSERT INTO financials_day_end (de_datetime_status, de_datetime, de_first_day_of_month, de_createdby, de_current_datetime, de_ip_adrs, de_brwsr_info)
//                        VALUES ('OPEN', '$newDate', 1, $loginUserId, '$dbTimeStamp', '$ipAddress', '$type');";
//
//        $result = $database->query($query);
//
//        if(!$result || $database->affected_rows() != 1) {
//
//            $error = true;
//            $rollBack = true;
//            $dayClosingError = true;
//            $dayClosingErrorMessage .= "System cannot moved to the next Date!";
//
//            $autoReset = resetAutoIncrementOf('financials_day_end', 'de_id', $database);
//            if ($autoReset != true) {
//                $dayClosingErrorMessage .= "Failed to reset the current the Day Closing id!";
//            }
//
//            $dieReport = $htmlHeader;
//            $dieReport .= $headerErrorSection;
//            $dieReport .= $dailyDepreciationHTMPReport;
//            $dieReport .= $monthlyDepreciationHTMPReport;
//            $dieReport .= $trialBalanceHTMLReport;
//            $dieReport .= $stockValuesHTMLReport;
//            $dieReport .= $cashFlowStatementHTMLReport;
//            $dieReport .= $incomeStatementHTMLReport;
//            $dieReport .= $balanceSheetHTMLReport;
//            $dieReport .= $profitLossDistributionHTMLReport;
//            $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved! " . $dayClosingErrorMessage);
//            $dieReport .= $htmlFooter;
//
//            $database->rollBack();
//
//            if (isset($database)) {
//                $database->close_connection();
//            }
//
//            die($dieReport);
//
//        }
//
//    } catch (Exception $e) {
//
//        $error = true;
//        $rollBack = true;
//        $dayClosingError = true;
//        $dayClosingErrorMessage .= "System cannot moved to the next Date!";
//
//        $autoReset = resetAutoIncrementOf('financials_day_end', 'de_id', $database);
//        if ($autoReset != true) {
//            $dayClosingErrorMessage .= "Failed to reset the current the Day Closing id!";
//        }
//
//        $dieReport = $htmlHeader;
//        $dieReport .= $headerErrorSection;
//        $dieReport .= $dailyDepreciationHTMPReport;
//        $dieReport .= $monthlyDepreciationHTMPReport;
//        $dieReport .= $trialBalanceHTMLReport;
//        $dieReport .= $stockValuesHTMLReport;
//        $dieReport .= $cashFlowStatementHTMLReport;
//        $dieReport .= $incomeStatementHTMLReport;
//        $dieReport .= $balanceSheetHTMLReport;
//        $dieReport .= $profitLossDistributionHTMLReport;
//        $dieReport .= error("Month End Execution Stop", "Month End Stop and unable to process until the above Error(s) resolved! " . $dayClosingErrorMessage);
//        $dieReport .= $htmlFooter;
//
//        $database->rollBack();
//
//        if (isset($database)) {
//            $database->close_connection();
//        }
//
//        die($dieReport);
//
//    }

}

/*
 *******************************************************************************************************************************
 *
 * Committing
 *
 * ******************************************************************************************************************************
 */
if ($mail == 1) {
//    $database->commit();

    // mail to login user
    $mailContent .= $noteSectionWithURLs;
    $mailContent .= $htmlFooter;
    mailTo($userEmail, "Month End Report of $currentUserReadableDate", $mailContent);

}


/*
 *******************************************************************************************************************************
 *
 * Print Complete Report
 *
 * ******************************************************************************************************************************
 */
echo $content;

if (isset($database)) {
    $database->close_connection();
}
