<?php
/**
 * Created by Ch Arbaz Mateen.
 * User: Ch Arbaz Mateen.
 * Date: 09-Mar-20
 * Time: 12:39 PM
 */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: false");
header('Access-Control-Allow-Methods: POST');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
header('Access-Control-Max-Age: 0');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header('content-type: application/json; charset=UTF-8');

require_once("../functions/api_functions.php");

dieIfNotGet();
$jwt = dieIfNotAuth();


require_once("../_db/database.php");
require_once("../functions/db_functions.php");

$response = (object)array('success' => 0, 'code' => 0, 'message' => '', 'data' => array());

try {

    $SUPER_ADMIN_ID = SUPER_ADMIN_ID;
    $clientParentUID = RECEIVABLE_PARENT_UID;
    $supplierParentUID = PAYABLE_PARENT_UID;

    $SIDE_MENU_ITEM = 1;
    $ENTRY_ACCOUNT_ITEM = 2;
    $PARTY_ACCOUNT_ITEM = 3;
    $USER_ITEM = 4;

    if (isset($jwt)) {

        $userData = dieIfNotValidUser($jwt);
        $user = $userData->user;
        $loginUserId = $userData->loginUserId;
        $currentStatus = $userData->userStatus;
        $reportingGroupId = $user->user_account_reporting_group_ids; // account reporting group id

        $data = array();

        if ($loginUserId == $SUPER_ADMIN_ID) {

            // side menu
            $menuQuery = "select mcd_code as code, mcd_title as title 
                        from financials_modular_config_defination 
                        where mcd_level = 3 ORDER BY title;";
            $menuResult = $database->query($menuQuery);
            if ($menuResult && $database->num_rows($menuResult) > 0) {
                while ($menu = $database->fetch_array($menuResult)) {
                    $data[] = array(
                        'id' => $menu['code'],
                        'title' => $menu['title'],
                        'subTitle' => "",
                        'type' => $SIDE_MENU_ITEM,
                        'leading' => "",
                    );
                }
            }

            // entry accounts
            $accountsQuery = "SELECT account_uid, account_parent_code, account_name 
                                FROM financials_accounts
                                WHERE account_parent_code NOT IN ($clientParentUID, $supplierParentUID)
                                ORDER by account_name;";
            $accountsResult = $database->query($accountsQuery);
            if ($accountsResult && $database->num_rows($accountsResult) > 0) {
                while ($account = $database->fetch_array($accountsResult)) {

                    $p = getHead($account['account_parent_code']);

                    $parent = $p['parent']['parent']['name'] . '/' . $p['parent']['name'] . '/' . $p['name'];

                    $data[] = array(
                        'id' => $account['account_uid'],
                        'title' => $account['account_name'],
                        'subTitle' => $parent,
                        'type' => $ENTRY_ACCOUNT_ITEM,
                        'leading' => $parent[0],
                    );
                }
            }

            // party accounts
            $partyQuery = "SELECT account_uid, account_parent_code, account_name 
                                FROM financials_accounts
                                WHERE account_parent_code IN ($clientParentUID, $supplierParentUID)
                                ORDER by account_name;";
            $partyResult = $database->query($partyQuery);
            if ($partyResult && $database->num_rows($partyResult) > 0) {
                while ($party = $database->fetch_array($partyResult)) {

                    $p2 = getHead($party['account_parent_code']);

                    $parent2 = $p2['parent']['parent']['name'] . '/' . $p2['parent']['name'] . '/' . $p2['name'];

                    $data[] = array(
                        'id' => $party['account_uid'],
                        'title' => $party['account_name'],
                        'subTitle' => $parent2,
                        'type' => $PARTY_ACCOUNT_ITEM,
                        'leading' => $parent2[0],
                    );
                }
            }

            // users
            $usersQuery = "SELECT user_id, user_name, user_email, user_profilepic 
                            FROM financials_users 
                            WHERE user_id != $SUPER_ADMIN_ID
                            ORDER BY user_name;";
            $usersResult = $database->query($usersQuery);
            if ($usersResult && $database->num_rows($usersResult) > 0) {
                while ($usr = $database->fetch_array($usersResult)) {

                    $data[] = array(
                        'id' => $usr['user_id'],
                        'title' => $usr['user_name'],
                        'subTitle' => $usr['user_email'],
                        'type' => $USER_ITEM,
                        'leading' => $usr['user_profilepic'],
                    );

                }
            }

        } else {



        }

        usort($data, function ($a, $b) {
            return $a['title'] > $b['title'];
        });

        $response->data = $data;
        $response->code = OK;
        $response->message = "Dashboard searchable items!";


    } else {
        $response->message = "Auth token not found!";
    }

} catch (Exception $e) {
    $response->message = $e->getMessage();
}

$response->success = OK;
echo json_encode($response);

if (isset($database)) {
    $database->close_connection();
}


