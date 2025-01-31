<?php
/**
 * Created by CH Arbaz Mateen.
 * User: Arbaz Mateen
 * Date: 02-Jan-2019
 * Time: 10:30 AM
 * Desc: Database class for database related task.
 */

require_once("constants.php");

// Application
defined('APP_NAME') ? null : define("APP_NAME", "Jadeed Munshi");

// API response codes
defined('OK') ? null : define("OK", 1);
defined('NOT_OK') ? null : define("NOT_OK", 2);
defined('NOT_VALID') ? null : define("NOT_VALID", 3);
defined('NOT_FOUND') ? null : define("NOT_FOUND", 4);
defined('DATA_EMPTY') ? null : define("DATA_EMPTY", 5);
defined('UN_DELETED') ? null : define("CAN_NOT_DELETE", 6);
defined('ALREADY_EXISTS') ? null : define("ALREADY_EXISTS", 7);
defined('DISABLE') ? null : define("DISABLE", 8);
defined('DELETED') ? null : define("DELETED", 9);
defined('ALREADY_LOGIN') ? null : define("ALREADY_LOGIN", 10);

// Data limit
defined('LIMIT') ? null : define("LIMIT", 50);

// Account list filters
defined('ACCOUNT_PURCHASE_SALE_FILTER') ? null : define("ACCOUNT_PURCHASE_SALE_FILTER", 1);
defined('ACCOUNT_PAYABLE_RECEIVABLE_FILTER') ? null : define("ACCOUNT_PAYABLE_RECEIVABLE_FILTER", 2);
defined('ACCOUNT_BANKS_FILTER') ? null : define("ACCOUNT_BANKS_FILTER", 3);
defined('ACCOUNT_OTHER_THEN_BANKS_FILTER') ? null : define("ACCOUNT_OTHER_THEN_BANKS_FILTER", 4);
defined('ACCOUNT_EXPENSE_FILTER') ? null : define("ACCOUNT_EXPENSE_FILTER", 5);
defined('ACCOUNT_PARENT_FILTER') ? null : define("ACCOUNT_PARENT_FILTER", 6);
defined('PAYABLE_ACCOUNTS_FILTER') ? null : define("PAYABLE_ACCOUNTS_FILTER", 7);
defined('RECEIVABLE_ACCOUNTS_FILTER') ? null : define("RECEIVABLE_ACCOUNTS_FILTER", 8);
defined('SALARIES_PAYABLE_FILTER') ? null : define("SALARIES_PAYABLE_FILTER", 9);
defined('ENTRY_ACCOUNTS_FILTER') ? null : define("ENTRY_ACCOUNTS_FILTER", 10);
defined('OTHER_THEN_TELLER_ACCOUNTS') ? null : define("OTHER_THEN_TELLER_ACCOUNTS", 11);
defined('CASH_BANK_PAYABLE_RECEIVABLE_ACCOUNTS') ? null : define("CASH_BANK_PAYABLE_RECEIVABLE_ACCOUNTS", 12);
defined('ADVANCE_SALARY_ACCOUNTS') ? null : define("ADVANCE_SALARY_ACCOUNTS", 13);

// Fixed control Accounts
defined('ASSETS') ? null : define("ASSETS", 1);
defined('LIABILITIES') ? null : define("LIABILITIES", 2);
defined('REVENUES') ? null : define("REVENUES", 3);
defined('EXPENSES') ? null : define("EXPENSES", 4);
defined('EQUITY') ? null : define("EQUITY", 5);

// Fixed Parent Accounts
defined('CURRENT_ASSET_GROUP_UID') ? null : define("CURRENT_ASSET_GROUP_UID", 110);
defined('FIXED_ASSET_GROUP_UID') ? null : define("FIXED_ASSET_GROUP_UID", 111);
defined('CGS_EXPENSE_GROUP_UID') ? null : define("CGS_EXPENSE_GROUP_UID", 411);
defined('SALARIES_EXPENSE_GROUP_UID') ? null : define("SALARIES_EXPENSE_GROUP_UID", 412);
defined('OWNERS_EQUITY_GROUP_UID') ? null : define("OWNERS_EQUITY_GROUP_UID", 510);
defined('INVESTORS_EQUITY_GROUP_UID') ? null : define("INVESTORS_EQUITY_GROUP_UID", 511);
defined('SALES_DISCOUNT_GROUP_UID') ? null : define("SALES_DISCOUNT_GROUP_UID", 415);
defined('INCOME_FROM_SALES_GROUP_UID') ? null : define("INCOME_FROM_SALES_GROUP_UID", 310);

// Fixed Child Accounts
defined('CASH_PARENT_UID') ? null : define("CASH_PARENT_UID", 11010);
defined('STOCK_PARENT_UID') ? null : define("STOCK_PARENT_UID", 11011);
defined('BANK_PARENT_UID') ? null : define("BANK_PARENT_UID", 11012);
defined('RECEIVABLE_PARENT_UID') ? null : define("RECEIVABLE_PARENT_UID", 11013);
defined('PREPAID_EXPENSE_PARENT_UID') ? null : define("PREPAID_EXPENSE_PARENT_UID", 11014);
defined('WALK_IN_CUSTOMER_PARENT_UID') ? null : define("WALK_IN_CUSTOMER_PARENT_UID", 11016);
defined('PARTY_CLAIMS_ACCOUNTS_PARENT_UID') ? null : define("PARTY_CLAIMS_ACCOUNTS_PARENT_UID", 11017);
defined('CREDIT_CARD_PARENT_UID') ? null : define("CREDIT_CARD_PARENT_UID", 11018);
defined('PAYABLE_PARENT_UID') ? null : define("PAYABLE_PARENT_UID", 21010);
defined('AMORTIZATION_PARENT_UID') ? null : define("AMORTIZATION_PARENT_UID", 31112);
defined('SALES_REVENUE_PARENT_UID') ? null : define("SALES_REVENUE_PARENT_UID", 31010);
defined('PURCHASER_PARENT_UID') ? null : define("PURCHASER_PARENT_UID", 41110);
defined('CGS_DEPRECIATION_PARENT_UID') ? null : define("CGS_DEPRECIATION_PARENT_UID", 41111);
defined('BANK_SERVICE_CHARGES_PARENT_UID') ? null : define("BANK_SERVICE_CHARGES_PARENT_UID", 41310);
defined('OPERATING_DEPRECIATION_PARENT_UID') ? null : define("OPERATING_DEPRECIATION_PARENT_UID", 41410);
defined('SALES_TRADE_DISCOUNT_PARENT_UID') ? null : define("SALES_TRADE_DISCOUNT_PARENT_UID", 41511);
defined('CLAIMS_ACCOUNTS_PARENT_UID') ? null : define("CLAIMS_ACCOUNTS_PARENT_UID", 41112);

// Fixed Entry Accounts
defined('CASH_ACCOUNT_UID') ? null : define("CASH_ACCOUNT_UID", 110101);
defined('STOCK_ACCOUNT_UID') ? null : define("STOCK_ACCOUNT_UID", 110111);
defined('INPUT_TAX_ACCOUNT_UID') ? null : define("INPUT_TAX_ACCOUNT_UID", 110151); //tax at the time of purchase
defined('WALK_IN_CUSTOMER_ACCOUNT_UID') ? null : define("WALK_IN_CUSTOMER_ACCOUNT_UID", 110161);
defined('ASSETS_SUSPENSE_ACCOUNT_UID') ? null : define("ASSETS_SUSPENSE_ACCOUNT_UID", 112101);
defined('FBR_OUTPUT_TAX_ACCOUNT_UID') ? null : define("FBR_OUTPUT_TAX_ACCOUNT_UID", 210111); // tax at the time of sale
defined('PROVINCE_OUTPUT_TAX_ACCOUNT_UID') ? null : define("PROVINCE_OUTPUT_TAX_ACCOUNT_UID", 210112); // tax at the time of sale
defined('PURCHASER_ACCOUNT_UID') ? null : define("PURCHASER_ACCOUNT_UID", 210121);
defined('LIABILITY_SUSPENSE_ACCOUNT_UID') ? null : define("LIABILITY_SUSPENSE_ACCOUNT_UID", 211101);
defined('SALES_ACCOUNT_UID') ? null : define("SALES_ACCOUNT_UID", 310101);
defined('SALE_RETURN_ACCOUNT_UID') ? null : define("SALE_RETURN_ACCOUNT_UID", 310102);
defined('SERVICES_ACCOUNT_UID') ? null : define("SERVICES_ACCOUNT_UID", 311101);
defined('SALE_MARGIN_ACCOUNT_UID') ? null : define("SALE_MARGIN_ACCOUNT_UID", 311111);
defined('PRODUCT_LOST_RECOVER_ACCOUNT_UID') ? null : define("PRODUCT_LOST_RECOVER_ACCOUNT_UID", 410101);
defined('PURCHASE_ACCOUNT_UID') ? null : define("PURCHASE_ACCOUNT_UID", 411101);
defined('PURCHASE_RETURN_ACCOUNT_UID') ? null : define("PURCHASE_RETURN_ACCOUNT_UID", 411102);
defined('ROUND_OFF_DISCOUNT_ACCOUNT_UID') ? null : define("ROUND_OFF_DISCOUNT_ACCOUNT_UID", 414111);
defined('CASH_DISCOUNT_ACCOUNT_UID') ? null : define("CASH_DISCOUNT_ACCOUNT_UID", 415101);
defined('SERVICE_DISCOUNT_ACCOUNT_UID') ? null : define("SERVICE_DISCOUNT_ACCOUNT_UID", 415102);
defined('PRODUCT_DISCOUNT_ACCOUNT_UID') ? null : define("PRODUCT_DISCOUNT_ACCOUNT_UID", 415111);
defined('RETAILER_DISCOUNT_ACCOUNT_UID') ? null : define("RETAILER_DISCOUNT_ACCOUNT_UID", 415112);
defined('WHOLE_SELLER_DISCOUNT_ACCOUNT_UID') ? null : define("WHOLE_SELLER_DISCOUNT_ACCOUNT_UID", 415113);
defined('LOYALTY_DISCOUNT_ACCOUNT_UID') ? null : define("LOYALTY_DISCOUNT_ACCOUNT_UID", 415114);
defined('BONUS_AD_ACCOUNT_UID') ? null : define("BONUS_AD_ACCOUNT_UID", 410111);
defined('CLAIM_ISSUE_ACCOUNT_UID') ? null : define("CLAIM_ISSUE_ACCOUNT_UID", 411121);
defined('CLAIM_RECEIVED_ACCOUNT_UID') ? null : define("CLAIM_RECEIVED_ACCOUNT_UID", 411122);

defined('UNDISTRIBUTED_PROFIT_LOSS_ACCOUNT_UID') ? null : define("UNDISTRIBUTED_PROFIT_LOSS_ACCOUNT_UID", 512101);


// transaction types
defined('PURCHASE') ? null : define("PURCHASE", 1);
defined('PURCHASE_RETURN') ? null : define("PURCHASE_RETURN", 2);
defined('SALE') ? null : define("SALE", 3);
defined('SALE_RETURN') ? null : define("SALE_RETURN", 4);
defined('JV') ? null : define("JV", 5);
defined('CASH_RECEIPT') ? null : define("CASH_RECEIPT", 6);
defined('CASH_PAYMENT') ? null : define("CASH_PAYMENT", 7);
defined('BANK_RECEIPT') ? null : define("BANK_RECEIPT", 8);
defined('BANK_PAYMENT') ? null : define("BANK_PAYMENT", 9);
defined('PRODUCT_LOSS') ? null : define("PRODUCT_LOSS", 10);
defined('PRODUCT_RECOVER') ? null : define("PRODUCT_RECOVER", 11);
defined('CASH_TRANSFER') ? null : define("CASH_TRANSFER", 12);
defined('EXPENSE_PAYMENT') ? null : define("EXPENSE_PAYMENT", 13);
defined('SERVICE_INVOICE') ? null : define("SERVICE_INVOICE", 14);
defined('POST_DATED_CHEQUE') ? null : define("POST_DATED_CHEQUE", 15);
defined('ADVANCE_SALARY') ? null : define("ADVANCE_SALARY", 16);
defined('SALARY_SLIP') ? null : define("SALARY_SLIP", 17);
defined('SALARY_PAYMENT') ? null : define("SALARY_PAYMENT", 18);
defined('PRODUCT_MANUFACTURE') ? null : define("PRODUCT_MANUFACTURE", 19);
defined('SALE_TAX_PURCHASE') ? null : define("SALE_TAX_PURCHASE", 20);
defined('SALE_TAX_PURCHASE_RETURN') ? null : define("SALE_TAX_PURCHASE_RETURN", 21);
defined('SALE_TAX') ? null : define("SALE_TAX", 22);
defined('SALE_TAX_SALE_RETURN') ? null : define("SALE_TAX_SALE_RETURN", 23);
defined('SERVICE_SALE_TAX') ? null : define("SERVICE_SALE_TAX", 24);
defined('SALE_ORDER') ? null : define("SALE_ORDER", 25);

// transaction notes
defined('TRANS_NOTE_SALE_INVOICE') ? null : define("TRANS_NOTE_SALE_INVOICE", 'SALE_INVOICE');
defined('TRANS_NOTE_SALE_TAX_INVOICE') ? null : define("TRANS_NOTE_SALE_TAX_INVOICE", 'SALE_TAX_INVOICE');
defined('TRANS_NOTE_SALE_RETURN_INVOICE') ? null : define("TRANS_NOTE_SALE_RETURN_INVOICE", 'SALE_RETURN_INVOICE');
defined('TRANS_NOTE_SALE_TAX_RETURN_INVOICE') ? null : define("TRANS_NOTE_SALE_TAX_RETURN_INVOICE", 'SALE_TAX_RETURN_INVOICE');
defined('TRANS_NOTE_SERVICE_INVOICE') ? null : define("TRANS_NOTE_SERVICE_INVOICE", 'SERVICE_INVOICE');
defined('TRANS_NOTE_SERVICE_TAX_INVOICE') ? null : define("TRANS_NOTE_SERVICE_TAX_INVOICE", 'SERVICE_TAX_INVOICE');
defined('TRANS_NOTE_CASH_RECEIPT_VOUCHER') ? null : define("TRANS_NOTE_CASH_RECEIPT_VOUCHER", 'CASH_RECEIPT_VOUCHER');
defined('TRANS_NOTE_CASH_PAYMENT_VOUCHER') ? null : define("TRANS_NOTE_CASH_PAYMENT_VOUCHER", 'CASH_PAYMENT_VOUCHER');
defined('TRANS_NOTE_BANK_RECEIPT_VOUCHER') ? null : define("TRANS_NOTE_BANK_RECEIPT_VOUCHER", 'BANK_RECEIPT_VOUCHER');
defined('TRANS_NOTE_BANK_PAYMENT_VOUCHER') ? null : define("TRANS_NOTE_BANK_PAYMENT_VOUCHER", 'BANK_PAYMENT_VOUCHER');


// Voucher codes
defined('PRODUCT_LOSS_VOUCHER_CODE') ? null : define("PRODUCT_LOSS_VOUCHER_CODE", 'PLV-');
defined('PRODUCT_RECOVER_VOUCHER_CODE') ? null : define("PRODUCT_RECOVER_VOUCHER_CODE", 'PRV-');
defined('PURCHASE_VOUCHER_CODE') ? null : define("PURCHASE_VOUCHER_CODE", 'PI-');
defined('PURCHASE_RETURN_VOUCHER_CODE') ? null : define("PURCHASE_RETURN_VOUCHER_CODE", 'PRI-');
defined('SALE_TEX_PURCHASE_VOUCHER_CODE') ? null : define("SALE_TEX_PURCHASE_VOUCHER_CODE", 'STPI-');
defined('SALE_TEX_PURCHASE_RETURN_VOUCHER_CODE') ? null : define("SALE_TEX_PURCHASE_RETURN_VOUCHER_CODE", 'STPRI-');
defined('SALE_ORDER_VOUCHER_CODE') ? null : define("SALE_ORDER_VOUCHER_CODE", 'SO-');
defined('SALE_VOUCHER_CODE') ? null : define("SALE_VOUCHER_CODE", 'SI-');
defined('SALE_RETURN_VOUCHER_CODE') ? null : define("SALE_RETURN_VOUCHER_CODE", 'SRI-');
defined('SALE_TEX_SALE_VOUCHER_CODE') ? null : define("SALE_TEX_SALE_VOUCHER_CODE", 'STSI-');
defined('SALE_TEX_SALE_RETURN_VOUCHER_CODE') ? null : define("SALE_TEX_SALE_RETURN_VOUCHER_CODE", 'STSRI-');
defined('JOURNAL_VOUCHER_CODE') ? null : define("JOURNAL_VOUCHER_CODE", 'JV-');
defined('CASH_PAYMENT_VOUCHER_CODE') ? null : define("CASH_PAYMENT_VOUCHER_CODE", 'CPV-');
defined('CASH_RECEIPT_VOUCHER_CODE') ? null : define("CASH_RECEIPT_VOUCHER_CODE", 'CRV-');
defined('BANK_PAYMENT_VOUCHER_CODE') ? null : define("BANK_PAYMENT_VOUCHER_CODE", 'BPV-');
defined('BANK_RECEIPT_VOUCHER_CODE') ? null : define("BANK_RECEIPT_VOUCHER_CODE", 'BRV-');
defined('CASH_TRANSFER_CODE') ? null : define("CASH_TRANSFER_CODE", 'CT-');
defined('EXPENSE_PAYMENT_CODE') ? null : define("EXPENSE_PAYMENT_CODE", 'EPV-');
defined('SERVICE_VOUCHER_CODE') ? null : define("SERVICE_VOUCHER_CODE", 'SEI-');
defined('SERVICE_TAX_VOUCHER_CODE') ? null : define("SERVICE_TAX_VOUCHER_CODE", 'STSEI-');
defined('POST_DATED_CHEQUE_ISSUE') ? null : define("POST_DATED_CHEQUE_ISSUE", 'PDCI-');
defined('POST_DATED_CHEQUE_RECEIVED') ? null : define("POST_DATED_CHEQUE_RECEIVED", 'PDCR-');
defined('ADVANCE_SALARY_VOUCHER_CODE') ? null : define("ADVANCE_SALARY_VOUCHER_CODE", 'ASV-');
defined('SALARY_SLIP_VOUCHER_CODE') ? null : define("SALARY_SLIP_VOUCHER_CODE", 'SSV-');
defined('SALARY_PAYMENT_VOUCHER_CODE') ? null : define("SALARY_PAYMENT_VOUCHER_CODE", 'SPV-');
defined('DEPRECIATION_EXPENSE_VOUCHER_CODE') ? null : define("DEPRECIATION_EXPENSE_VOUCHER_CODE", 'DEV-');
defined('PRODUCT_MANUFACTURE_VOUCHER_CODE') ? null : define("PRODUCT_MANUFACTURE_VOUCHER_CODE", 'PMV-');

// domain
defined('DOMAIN') ? null : define("DOMAIN", "https://www.jadeedems.com");
defined('SUB_DOMAIN') ? null : define("SUB_DOMAIN", "https://jadeedems.com");
defined('SUB_DOMAIN_NAME') ? null : define("SUB_DOMAIN_NAME", "POS");
defined('AUDIENCE') ? null : define("AUDIENCE", "com.jadeedmunshi.jadeed_munshi");
defined('REPORTS_SENDING_EMAIL_ADDRESS') ? null : define("REPORTS_SENDING_EMAIL_ADDRESS", "reports@jadeedmunshi.com");
defined('NO_REPLY_SENDING_EMAIL_ADDRESS') ? null : define("NO_REPLY_SENDING_EMAIL_ADDRESS", "noreply@jadeedmunshi.com");
defined('SUPPORT_EMAIL_ADDRESS') ? null : define("SUPPORT_EMAIL_ADDRESS", "support@jadeedmunshi.com");

// FCM Project Name: Munshi
defined('FCM_SERVER_KEY') ? null : define("FCM_SERVER_KEY", "AAAA3l4FxCo:APA91bEJH1eQm_WZDbp619lR9UYWsDbcyE_IzlNYWUiJHWylbb3YBqFpRI2moKJ_d8SgDexvwsYNnv-7iSkSVK8D7b-4j8iK9kl_u2WdFiDLmZyoKmVLKLdJjOYrPrqX37uMhHUYCS_V");

$domain = DOMAIN;
$subDomain = SUB_DOMAIN;
$subDomainName = SUB_DOMAIN_NAME;
$audience = AUDIENCE;

// images path
defined('USERS_PATH') ? null : define("USERS_PATH", "images/");
defined('USERS_IMAGE_PATH') ? null : define("USERS_IMAGE_PATH", $subDomain . "/public/_api/users/images/");
defined('DEFAULT_USERS_IMAGE') ? null : define("DEFAULT_USERS_IMAGE", $subDomain . "/public/_api/users/images/default_profile_image.png");

// Company Logo Image
defined('LOGO_PATH') ? null : define("LOGO_PATH", "image/");
defined('LOGO_IMAGE_PATH') ? null : define("LOGO_IMAGE_PATH", $subDomain . "/public/_api/company_info/image/");
defined('DEFAULT_LOGO_IMAGE_PATH') ? null : define("DEFAULT_LOGO_IMAGE_PATH", $subDomain . "/public/_api/company_info/image/softagics.png");

// day end report path
defined('DAY_END_FOLDER_PATH') ? null : define("DAY_END_FOLDER_PATH", "/public/_api/day_end/");
defined('DAY_END_REPORT_FOLDER_NAME') ? null : define("DAY_END_REPORT_FOLDER_NAME", "dayEndReports");
defined('MONTH_END_REPORT_FOLDER_NAME') ? null : define("MONTH_END_REPORT_FOLDER_NAME", "monthEndReports");
defined('DAY_END_REPORT_PATH') ? null : define("DAY_END_REPORT_PATH", $subDomain . "/public/_api/day_end/dayEndReports/");
defined('MONTH_END_REPORT_PATH') ? null : define("MONTH_END_REPORT_PATH", $subDomain . "/public/_api/day_end/monthEndReports/");
defined('MONTH_END_REPORT_FILE') ? null : define("MONTH_END_REPORT_FILE", $subDomain . "/public/_api/day_end/month_end_report.php");
defined('MONTH_END_EXECUTION_FILE') ? null : define("MONTH_END_EXECUTION_FILE", $subDomain . "/public/_api/day_end/execute_month_end.php");

defined('SYNC_REPORT_FOLDER') ? null : define("SYNC_REPORT_FOLDER", "syncReports");
defined('SYNC_REPORT_FOLDER_PATH') ? null : define("SYNC_REPORT_FOLDER_PATH", "/public/_api/desktop/syncReports/");

defined('TYPE_DAY_END') ? null : define("TYPE_DAY_END", "c4ca4238a0b923820dcc509a6f75849b"); // = 1
defined('TYPE_MONTH_END') ? null : define("TYPE_MONTH_END", "c81e728d9d4c2f636f067f89cc14862c"); // = 2

$dayEndFolderPath = DAY_END_FOLDER_PATH;
$dayEndReportFolder = DAY_END_REPORT_FOLDER_NAME;
$monthEndReportFolder = MONTH_END_REPORT_FOLDER_NAME;
$dayEndReportPath = DAY_END_REPORT_PATH;
$monthEndReportPath = MONTH_END_REPORT_PATH;
$monthEndReportFile = MONTH_END_REPORT_FILE;
$monthEndExecutionFile = MONTH_END_EXECUTION_FILE;

// employee roles
defined('NONE') ? null : define('NONE', 1); // other employee
defined('EMPLOYEE') ? null : define('EMPLOYEE', 1); // other employee
defined('CASHIER') ? null : define('CASHIER', 2);
defined('TELLER') ? null : define('TELLER', 3);
defined('SALE_PERSON') ? null : define('SALE_PERSON', 4);
defined('PURCHASER') ? null : define('PURCHASER', 5);

// super admin level
defined('SUPER_ADMIN_ID') ? null : define('SUPER_ADMIN_ID', 1);
defined('SUPER_ADMIN_LEVEL') ? null : define('SUPER_ADMIN_LEVEL', 100);
defined('ADMIN_LEVEL') ? null : define('ADMIN_LEVEL', 30);
defined('MANAGER_LEVEL') ? null : define('MANAGER_LEVEL', 20);
defined('OPERATOR_LEVEL') ? null : define('OPERATOR_LEVEL', 10);

// employee filter query
defined('TELLER_ACCOUNTS_FILTER') ? null : define("TELLER_ACCOUNTS_FILTER", 1);
defined('ADMIN_CASHIER_TELLER_ACCOUNTS_FILTER') ? null : define("ADMIN_CASHIER_TELLER_ACCOUNTS_FILTER", 2);
defined('CASHIER_ACCOUNTS_FILTER') ? null : define("CASHIER_ACCOUNTS_FILTER", 3);
defined('SALESMAN_ACCOUNTS_FILTER') ? null : define("SALESMAN_ACCOUNTS_FILTER", 4);
defined('PURCHASER_ACCOUNTS_FILTER') ? null : define("PURCHASER_ACCOUNTS_FILTER", 5);

// Auth header for API JWT Key
defined('AUTH_HEADER') ? null : define("AUTH_HEADER", "HTTP_AUTH");

// Date time formats
defined('DB_TIME_STAMP_FORMAT') ? null : define("DB_TIME_STAMP_FORMAT", "Y-m-d H:i:s");
defined('DB_DATE_STAMP_FORMAT') ? null : define("DB_DATE_STAMP_FORMAT", "Y-m-d");
defined('DAY_END_DATE_FORMAT_FOR_USER') ? null : define("DAY_END_DATE_FORMAT_FOR_USER", "d-m-Y");
defined('MONTH_END_DATE_FORMAT_FOR_USER') ? null : define("MONTH_END_DATE_FORMAT_FOR_USER", "F-Y");
defined('USER_TIME_FORMAT') ? null : define("USER_TIME_FORMAT", "h:i:s A");
defined('USER_DATE_FORMAT') ? null : define("USER_DATE_FORMAT", "d-m-Y");
defined('USER_DATE_TIME_FORMAT') ? null : define("USER_DATE_TIME_FORMAT", "d-m-Y h:i:s A");
defined('ASIA_TIME_ZONE') ? null : define("ASIA_TIME_ZONE", "Asia/Karachi");

date_default_timezone_set(ASIA_TIME_ZONE);
$dbTimeStamp = date(DB_TIME_STAMP_FORMAT);
$userTimeStamp = date(USER_DATE_TIME_FORMAT);

// Depreciation
defined('DEP_PERIOD_ANNUALLY') ? null : define("DEP_PERIOD_ANNUALLY", 1);
defined('DEP_PERIOD_MONTHLY') ? null : define("DEP_PERIOD_MONTHLY", 2);
defined('DEP_PERIOD_DAILY') ? null : define("DEP_PERIOD_DAILY", 3);

defined('DEP_METHOD_SLM') ? null : define("DEP_METHOD_SLM", 1);
defined('DEP_METHOD_RBM') ? null : define("DEP_METHOD_RBM", 2);

defined('DEP_DEPRECIATION') ? null : define("DEP_DEPRECIATION", 1);
defined('DEP_AMORTIZATION') ? null : define("DEP_AMORTIZATION", 2);

defined('DEP_POSTING_AUTO') ? null : define("DEP_POSTING_AUTO", 1);
defined('DEP_POSTING_MANUAL') ? null : define("DEP_POSTING_MANUAL", 2);


// salary payment period
defined('PER_HOUR') ? null : define("PER_HOUR", 1);
defined('PER_DAY') ? null : define("PER_DAY", 2);
defined('PER_MONTH') ? null : define("PER_MONTH", 3);


// salary payment period
defined('DAILY') ? null : define("DAILY", 1);
defined('WEEKLY') ? null : define("WEEKLY", 2);
defined('MONTHLY') ? null : define("MONTHLY", 3);


// stock movement types
defined('SM_TYPE_OPENING_BALANCE') ? null : define("SM_TYPE_OPENING_BALANCE", 'OPENING BALANCE');
defined('SM_TYPE_PURCHASE') ? null : define("SM_TYPE_PURCHASE", 'PURCHASE');
defined('SM_TYPE_SALE') ? null : define("SM_TYPE_SALE", 'SALE');
defined('SM_TYPE_SALE_RETURN') ? null : define("SM_TYPE_SALE_RETURN", 'SALE RETURN');
defined('SM_TYPE_PURCHASE_RETURN') ? null : define("SM_TYPE_PURCHASE_RETURN", 'PURCHASE RETURN');
defined('SM_TYPE_SALE_ORDER') ? null : define("SM_TYPE_SALE_ORDER", 'SALE ORDER');
defined('SM_TYPE_PRODUCT_LOSS') ? null : define("SM_TYPE_PRODUCT_LOSS", 'PRODUCT LOSS');
defined('SM_TYPE_PRODUCT_RECOVER') ? null : define("SM_TYPE_PRODUCT_RECOVER", 'PRODUCT RECOVER');
defined('SM_TYPE_MANUFACTURING') ? null : define("SM_TYPE_MANUFACTURING", 'MANUFACTURING');
defined('SM_TYPE_REJECT') ? null : define("SM_TYPE_REJECT", 'REJECT/CANCEL');
defined('SM_TYPE_COMPLETE') ? null : define("SM_TYPE_COMPLETE", 'COMPLETE');
defined('SM_TYPE_PURCHASE_BONUS') ? null : define("SM_TYPE_PURCHASE_BONUS", 'PURCHASE BONUS');
defined('SM_TYPE_SALE_BONUS') ? null : define("SM_TYPE_SALE_BONUS", 'SALE BONUS');

defined('SM_TYPE_TRANSFER_TO_CLAIM') ? null : define("SM_TYPE_TRANSFER_TO_CLAIM", 'TRANSFER TO CLAIM');
defined('SM_TYPE_TRANSFER_FROM_CLAIM') ? null : define("SM_TYPE_TRANSFER_FROM_CLAIM", 'TRANSFER FROM CLAIM');
defined('SM_TYPE_CONVERT_TO_BONUS') ? null : define("SM_TYPE_CONVERT_TO_BONUS", 'CONVERT TO BONUS');
defined('SM_TYPE_CONVERT_FROM_BONUS') ? null : define("SM_TYPE_CONVERT_FROM_BONUS", 'CONVERT FROM BONUS');
defined('SM_TYPE_TRANSFER_TO_HOLD') ? null : define("SM_TYPE_TRANSFER_TO_HOLD", 'TRANSFER TO HOLD');
defined('SM_TYPE_TRANSFER_FROM_HOLD') ? null : define("SM_TYPE_TRANSFER_FROM_HOLD", 'TRANSFER FROM HOLD');


// country pakistan id fixed
defined('PAKISTAN_ID') ? null : define("PAKISTAN_ID", 164);


// fixed warehouses
defined('MAIN_WAREHOUSE_ID') ? null : define("MAIN_WAREHOUSE_ID", 1); // shelf warehouse
defined('SALE_RETURN_WAREHOUSE_ID') ? null : define("SALE_RETURN_WAREHOUSE_ID", 2);
defined('CLAIM_WAREHOUSE_ID') ? null : define("CLAIM_WAREHOUSE_ID", 3);
defined('WORK_IN_PROCESS_WAREHOUSE_ID') ? null : define("WORK_IN_PROCESS_WAREHOUSE_ID", 4);



class APIDatabase
{
    private $connection;
    private $canRollBack = false;

    function __construct()
    {
        $this->open_connection();
    }

    public function open_connection()
    {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($this->connection, 'utf8');
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
        }
    }

    public function close_connection()
    {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query_rows($query)
    {
        $result = mysqli_query($this->connection, $query);
        if(mysqli_num_rows($result)){
            return true;
        }
        return false;
    }

    public function query($query)
    {
        $result = mysqli_query($this->connection, $query);
        $this->confirm_query($result, $query);
        return $result;
    }

    public function multi_query($query)
    {
        $result = mysqli_multi_query($this->connection, $query);
        $this->confirm_query($result, $query);
        return $result;
    }

    private function confirm_query($res, $que)
    {
        if (!$res) {
            $dieReport = "Database query failed. <br />\n>>>>>> Error: " . mysqli_error($this->connection) . ". <br />\n>>>>> Query: " . $que;
            $this->rollBack();
            die($dieReport);
        }
    }

    public function escape_value($string)
    {
        $escape_string = mysqli_real_escape_string($this->connection, $string);
        return $escape_string;
    }

    public function begin_trans() {
        mysqli_autocommit($this->connection, false);
        mysqli_begin_transaction($this->connection);
        $this->canRollBack = true;
    }

    public function commit() {
        $this->canRollBack = false;
        mysqli_commit($this->connection);
        mysqli_autocommit($this->connection, true);
    }

    public function rollBack() {
        if ($this->canRollBack === true) {
            mysqli_rollback($this->connection);
            $this->canRollBack = false;
        }
        mysqli_autocommit($this->connection, true);
    }

    public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set);
    }

    public function fetch_assoc($result_set)
    {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set)
    {
        return mysqli_num_rows($result_set);
    }

    public function inserted_id()
    {
        // last inserted id
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection);
    }

}

$database = new APIDatabase();


