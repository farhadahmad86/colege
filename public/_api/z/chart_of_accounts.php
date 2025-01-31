<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 19-Jun-20
 * Time: 2:42 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../_db/database.php");
require_once("../functions/db_functions.php");
require_once("../functions/functions.php");

$trialExeStartTime = microtime(true);
// trial view example test ******************************************************************************************************
$accountsList = array();
$opLevelQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_level = 1 order by coa_code;";
$topLevelResult = $database->query($opLevelQuery);
while ($topLevelData = $database->fetch_assoc($topLevelResult)) {

    $controlCode = $topLevelData['coa_code'];
    $controlName = $topLevelData['coa_head_name'];

    $accountsList[$controlCode] = array('code' => $controlCode, 'name' => "$controlName", 'child' => array(), 'type' => "", "level" => 1);

    $parentQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_parent = $controlCode order by coa_code;";
    $parentResult = $database->query($parentQuery);
    while ($parentData = $database->fetch_assoc($parentResult)) {

        $parentCode = $parentData['coa_code'];
        $parentName = $parentData['coa_head_name'];

        $accountsList[$controlCode]['child'][$parentCode] = array('code' => $parentCode, 'name' => "$parentName", 'child' => array(), 'type' => "", "level" => 2);

        $childQuery = "SELECT coa_code, coa_head_name, coa_level FROM financials_coa_heads WHERE coa_parent = $parentCode order by coa_code;";
        $childResult = $database->query($childQuery);
        while ($childData = $database->fetch_assoc($childResult)) {

            $childCode = $childData['coa_code'];
            $childName = $childData['coa_head_name'];

            $accountsList[$controlCode]['child'][$parentCode]['child'][$childCode] = array('code' => $childCode, 'name' => "$childName", 'child' => array(), 'type' => "", "level" => 3);

            $entryQuery = "SELECT account_uid, account_name, account_balance FROM financials_accounts WHERE account_parent_code = $childCode order by account_uid;";
            $entryResult = $database->query($entryQuery);
            while ($entryData = $database->fetch_assoc($entryResult)) {

                $entryCode = $entryData['account_uid'];
                $entryName = $entryData['account_name'];
                $balance = $entryData['account_balance'];

                $accountsList[$controlCode]['child'][$parentCode]['child'][$childCode]['child'][] = array('code' => $entryCode, 'name' => "$entryName", 'type' => "", "level" => 4, 'balance' => $balance);

            }

        }
    }
}

// chart of accounts functions
function trialHeadEntry($entry, $id, $disable) {
    $pointerClass = $disable ? "disabled" : "pointer";
    return '
        <tr data-uid="' . $entry['code'] . '" data-expendId="' . strtolower($id) . '" onclick="expendDiv(this)" class="head">
            <th class="no-indent text-center tbl_srl_18 ' . $pointerClass . '">
                ' . $entry['code'] . '
            </th>
            <th class="text-left tbl_txt_64">
                ' . $entry['name'] . '
            </th>
            <th class="text-left tbl_srl_18">
                
            </th>
        </tr>
    ';
}

function trialAccountEntry($entry, $id) {
    if (startswith($entry['code'], ASSETS) || startswith($entry['code'], EXPENSES)) {
        if ($entry['balance'] >= 0) {
            $bal = number_format($entry['balance'], 2);
        } else {
            $bal = "(" . number_format(abs($entry['balance']), 2) . ")";
        }
    } else {
        if ($entry['balance'] < 0) {
            $bal = "(" . number_format(abs($entry['balance']), 2) . ")";
        } else {
            $bal = number_format($entry['balance'], 2);
        }
    }
    return '
        <tr data-uid="' . $entry['code'] . '" data-id="' . $id . '" data-name="' . $entry['name'] . '" class="pointer link day-end-ledger" onclick="ledger(' . $entry['code'] . ', \'' . $entry['name'] . '\')">
            <td class="no-indent text-center tbl_srl_18">
                ' . $entry['code'] . '
            </td>
            <td class="text-left tbl_txt_64">
                ' . $entry['name'] . '
            </td>
            <td class="text-right tbl_srl_18">
                ' . $bal . '
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

// chart of accounts
$srcUrl = "../day_end/src";
echo '
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="shortcut icon" href="#">

    <title>
        Chart Of Accounts
    </title>
	
    <link rel="stylesheet" type="text/css" href="' . $srcUrl . '/css/day_end.css" />

    <script>
    
        function ledger(uid, name) {
            let uidHiddenField = document.getElementById("uid");
            let nameHiddenField = document.getElementById("name");
            
            uidHiddenField.value = uid;
            nameHiddenField.value = name;
            
            let account_form = document.getElementById("account_form");
            account_form.submit();
        }
    
    </script>

</head>
<body class="gnrl-mrgn-pdng">
<form id="account_form" method="post" action="./ledger.php" target="_blank">
    <input type="hidden" value="-" name="uid" id="uid">
    <input type="hidden" value="-" name="name" id="name">
</form>
<div class="main_container"><!-- miles planet main container start -->

    <div><!-- miles planet container start -->
            <!-- Trial Balance -->
            <section class="invoice_cntnt_sec"><!-- invoice content section start here -->
                <div class="invoice_cntnt_title_bx">
                    <h2 class="gnrl-mrgn-pdng invoice_cntnt_title">
                        Chart Of Accounts <span class="expand-img-span"><img class="expand-img" src="' . $srcUrl . '/images/expand1.png" alt="Expand"  onclick="toggleExpand(1, this);"/></span>
                    </h2>
                </div>
                <table id="trial" class="table day_end_table">
                    <thead>
                        <tr>
                            <th class="text-center tbl_srl_18">
                                UID
                            </th>
                            <th class="text-left tbl_txt_64">
                                Accounts
                            </th>
                            <th class="text-left tbl_srl_18">
                                Balance
                            </th>
                        </tr>
                        </thead>
                        <tbody>
        ';

$trialBalanceHTMLReport = "";

foreach ($accountsList as $entry) {
    $trialBalanceHTMLReport .= trialEntry($entry, strtolower($entry['name']));
}

echo $trialBalanceHTMLReport;

echo '
            </tbody>
                </table><!-- table end -->
            </section><!-- invoice content section end here -->
        ';

function exeTimeDiv($time, $message = "Execution Time: ") {
    return '<div class="exe_time">' . $message . number_format($time, 4) . ' second(s)</div>';
}
$totalAccounts = getCountOfTable("financials_accounts");
$trialExeStopTime = microtime(true);
echo exeTimeDiv($trialExeStopTime - $trialExeStartTime, "Execution Time  of " . number_format($totalAccounts, 0) . " Accounts: ");

echo '
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

$database->close_connection();

