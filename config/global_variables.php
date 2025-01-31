<?php
/**
 * Created by PhpStorm.
 * User: Hamza
 * Date: 16-Dec-18
 * Time: 10:56 AM
 */


// server name or root
$server_name = env('APP_URL');
$server_http_request = env('APP_URL');
$domainStorageFolderName = env('APP_PUBLIC_STORAGE');


return [

    //////////////////////////////// server name or root ///////////////////////////////////
    'server_name' => $server_name,
    'server_http_request' => $server_http_request,

    /////////////////////////////////// Day end links /////////////////////////////////////
    'execute_day_end' => $server_http_request . '/public/_api/day_end/execute_day_end.php',
    'day_end_report' => $server_http_request . '/public/_api/day_end/day_end_report.php',
//    'execute_day_end' => $server_http_request . '/public/_api/dayend/execute_day_end.php',
//    'day_end_report' => $server_http_request . '/public/_api/dayend/day_end_report.php',

    ///////////////////////////////// Site Configurations Links //////////////////////////////////////////////////
    'password_change_path' => $server_http_request . 'change_forgotten_password/',
    'common_path' => $server_http_request . 'storage/app/',
//    'common_path' => $server_http_request . 'storage/'.$domainStorageFolderName . '/app/',
    'storage_folder_name' => $domainStorageFolderName . '/app/',
    'excel_storage_folder_name' => $domainStorageFolderName . '/',
    'default_image_path' => $server_http_request . '/public/src/default_profile.png',
    'website_path' => $server_http_request . '',
    'employee_path' => '/public/employee',
    'product_path' => '/public/product',
    'inquiry_path' => '/public/inquiry',
    'form_pdf_path' => '/public/form_pdf',
    'document_pdf_path' => '/public/pdf',
    'college_logo' => '/public/college_logo',
    'company_logo' => '/public/company_logo',
    'reasons_path' => '/public/reasons_path',
    'student_status' => '/public/student_status',

    'before_image_path' => 'public/before_image',
    'designer_image_path' => 'public/designer_image',
    'after_image_path' => 'public/after_image',

    ////////////////////////////////////////// 1st level heads ///////////////////////////////
    'assets' => '1',
    'liabilities' => '2',
    'revenue' => '3',
    'expense' => '4',
    'equity' => '5',

    /////////////////////////////////// 2nd level heads ///////////////////////////////////////////////////
    'fixed_asset_second_head' => '111',
    'cgs_second_head' => '411',
    'salary_expense_second_head' => '412',
    'operating_expense_second_head' => '414',


    ////////////////////////////////////////// 3rd level heads //////////////////////////////////
    'cash' => '11010',
    'stock' => '11011',
    'bank_head' => '11012',
    'suspense'=>'11210',
    'suspense_lib'=>'21110',
    'receivable' => '11013',
    'advance_salary_head' => '11014', //advance salary parent
    'loan_head' => '11019', //Loan parent
    'walk_in_customer_head' => '11016',
    'party_claims_accounts_head' => '11017',
    'credit_card_accounts_head' => '11018',

    'payable' => '21010',
    'purchaser_account_head' => '21012',

    'amortization' => '31112',

    'salary_expense_account' => '41210',
    'depreciation' => '41111',
    'bank_service_charges' => '41310',


    /////////////////////////////////////// 4th level heads //////////////////////////////////////////

    //Assets
    'cash_in_hand' => '110101',
    'stock_in_hand' => '110111',
    'purchase_sale_tax' => '110151',
    'walk_in_customer' => '110161',
    'other_asset_suspense_account' => '112101',

    //Liability
    'sales_tax_payable_account' => '210111',
    'service_sale_tax_account' => '210112',
    'purchaser_account' => '210121',
    'other_liability_suspense_account' => '211101',

    //Revenue
    'sale_account' => '310101',
    'sales_returns_and_allowances' => '310102',
    'product_recover_loss' => '411131', //mustafa
    'product_stock_produced' => '411132', //mustafa
    'production_stock_adjustment' => '411133', //mustafa
    'service_account' => '311101',
    'sale_margin_account' => '311111',

    //Expense
    'product_loss_recover_account' => '410101',
    'product_consumed_stock_account' => '410121', //mustafa
    'purchase_account' => '411101',
    'purchase_return_and_allowances' => '411102',
    'stock_consumed' => '411103',
    'stock_produced' => '411104',
    'round_off_discount_account' => '414111',
    'new_salary_expense_account' => '41412',
    'cash_discount_account' => '415101',
    'service_discount_account' => '415102',
    'product_discount_account' => '415111',
    'retailer_discount_account' => '415112',
    'wholesaler_discount_account' => '415113',
    'loyalty_card_discount_account' => '415114',
    'trade_offer_account' => '415115',


    'bonus_allocation_deallocation' => '410111',
    'claim_issue' => '411121',
    'claim_received' => '411122',


    //Equity
    'capital_undistributed_profit_and_loss' => '512101',

    /////////////////////////////////////// combined accounts 3rd level heads //////////////////////////////////////////

    //combined accounts 3rd level
    'payable_receivable' => '21010,11013',
    'payable_receivable_cash' => '21010,11013,11010',
    'payable_receivable_cash_bank' => '21010,11013,11010,11012',
    'payable_receivable_purchaser' => '21010,11013,21012',
    'payable_receivable_walk_in_customer' => '21010,11013,11016',
    'payable_receivable_advance_salary_head' => '21010,11013,11014',
    'cash_voucher_accounts_not_in' => '11011,11014,11015,11018,11019,21011,31010,31110,31111,31112,41010,41011,41110,41111,41112,41310,41410,41411,41510,41511,51210,11110,41210,11111',
//    'cash_voucher_accounts_not_in' => '11011,11014,11015,11018,21011,31010,31110,31111,31112,41010,41011,41110,41111,41112,41310,41410,41411,41510,41511,51210,51010,11110,41210,11111',
    'bank_voucher_accounts_not_in' => '11011,11014,11019,31010,31110,31111,31112,41010,41011,41110,41111,41112,41410,41411,41510,41511,11110,41210,11111',
    'expense_voucher_accounts_cash_bank' => '11010,11012',

    'expense_voucher_accounts_not_in' => '11011,11014,11015,11018,11019,21011,31010,31110,31111,31112,41010,41110,41111,41112,41410,41411,41510,41511,51210,51010,11110,41210,11111',

    'journal_voucher_accounts_not_in' => '',
//    'journal_voucher_accounts_not_in' => '11011,11019,21012,31111',

    'salary_payment_accounts_not_in' => '11011,11015,11016,11017,11018,11210,21011,21012,21110,31010,31110,31111,31112,41010,41011,41110,41111,41112,41310,41410,41411,41510,41511,51210,51010,11110,41210,11111',

    'advance_salary_accounts_not_in' => '11011,11015,11016,11017,11018,11210,21011,21012,21110,31010,31110,31111,31112,41010,41011,41110,41111,41112,41310,41410,41411,41510,41511,51210,51010,11110,41210,11111',


    'expense_not_use_fix_head' => '410101,410102,411101,411102,414111,415111,415112,415113,415114',
    'expense_claim_fix_head' => '41112',

    // Default Account List

    'default_account_list' => '110101,110111,110151,110161,112101,210111,210112,210121,211101,310101,310102,311101,311111,410101,410111,411121,411122,411101,411102,414111,415101,415102,415111,415112,415113,415114,415115,411131,512101',

    // Default Accounts Name List

    'cash_account_name' => 'Cash',
    'stock_account_name' => 'Stock',
    'purchase_sale_tax_account_name' => 'Input Tax',
    'walk_in_customer_account_name' => 'Walk In Customer',
    'other_asset_suspense_account_name' => 'Suspense',
    'sale_sale_tax_account_name' => 'FBR Output Tax(Tax Payable)',
    'service_tax_account_name' => 'Province Output Tax(Tax Payable)',
    'purchaser_account_name' => 'Purchaser',
    'other_liability_suspense_account_name' => 'Suspense',
    'sales_account_name' => 'Sales',
    'sales_returns_and_allowances_account_name' => 'Sales Return',
    'service_account_name' => 'Services',
    'sales_margin_account_name' => 'Sale Margin',
    'product_loss_recover_account_name' => 'Product Loss & Recover',
    'purchase_account_name' => 'Purchase',
    'purchase_return_and_allowances_account_name' => 'Purchase Return',
    'round_off_discount_account_name' => 'Round off Discount',
    'cash_discount_account_name' => 'Cash Discount',
    'service_discount_account_name' => 'Service Discount',
    'product_discount_account_name' => 'Product Discount',
    'retailer_discount_account_name' => 'Retailer Discount',
    'wholesaler_discount_account_name' => 'Whole Seller Discount',
    'loyalty_discount_account_name' => 'Loyalty Card Discount',
    'capital_undistributed_profit_and_loss_account_name' => 'Undistributed Profit & Loss',

    'bonus_allocation_deallocation_account_name' => 'Bonus Allocation-Deallocation',
    'claim_issue_account_name' => 'Claim Issue',
    'claim_received_account_name' => 'Claim Received',


    // Other variables
    'cashier_account_id' => '2', // cashier
    'teller_account_id' => '3', // teller
    'seller_role_account_id' => '4', // sale-man
    'purchaser_role_id' => '5', // purchaser
    'query_sorting' => 'DESC',
    'drop_sorting' => 'ASC',


//    config('global_variables.website_path'); process to call global variable


// transaction types
    'PURCHASE' => '1',
    'PURCHASE_RETURN' => '2',
    'SALE' => '3',
    'SALE_RETURN' => '4',
    'JV' => '5',
    'CASH_RECEIPT' => '6',
    'CASH_PAYMENT' => '7',
    'BANK_RECEIPT' => '8',
    'BANK_PAYMENT' => '9',
    'PRODUCT_LOSS' => '10',
    'PRODUCT_RECOVER' => '11',
    'CASH_TRANSFER' => '12',
    'EXPENSE_PAYMENT' => '13',
    'SERVICE_INVOICE' => '14',
    'POST_DATED_CHEQUE' => '15',
    'ADVANCE_SALARY' => '16',
    'SALARY_SLIP' => '17',
    'SALARY_PAYMENT' => '18',
    'PRODUCT_MANUFACTURE' => '19',
    'PURCHASE_SALE_TAX' => '20',
    'PURCHASE_RETURN_SALE_TAX' => '21',
    'SALE_SALE_TAX' => '22',
    'SALE_RETURN_SALE_TAX' => '23',
    'SERVICE_SALE_TAX_INVOICE' => '24',
    'SALE_ORDER' => '25',
    'AJV' => '26',
    'PRODUCTION' => '27',
    'GRN_PURCHASE' => '28',
    'GRN_PURCHASE_SALE_TAX' => '29',
    'GENERATE_SALARY_SLIP' => '30',
    'CONSUMED_PRODUCED' => '31',
    'BILL_OF_LABOUR' => '32',
    'FIXED_ASSET' => '33',
    'LOAN' => '34',
    'LOAN_RECEIPT' => '41',
    'CUSTOM_VOUCHER' => '35',
    'ADVANCE_VOUCHER' => '43',
    'ADVANCE_REVERSE_VOUCHER' => '44',
    'FEE_PAID' => '36',
    'STUDENT_BOOKED' => '37',
    'INCOME_VOUCHER' => '38',
    'DISCOUNT_INCREASE_VOUCHER' => '39',
    'STUCK_OFF' => '40',
    'TRANSPORT' => '42',

    // Voucher Codes
    'GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE' => 'GRNPI-',
    'TRADE_GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE' => 'TGRNPI-',
    'PURCHASE_VOUCHER_CODE' => 'PI-',
    'TRADE_PURCHASE_VOUCHER_CODE' => 'TPI-',
    'PURCHASE_RETURN_VOUCHER_CODE' => 'PRI-',
    'TRADE_PURCHASE_RETURN_VOUCHER_CODE' => 'TPRI-',
    'PURCHASE_SALE_TAX_VOUCHER_CODE' => 'STPI-',
    'TRADE_PURCHASE_SALE_TAX_VOUCHER_CODE' => 'TSTPI-',
    'GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE_PURCHASE_SALE_TAX_VOUCHER_CODE' => 'GRNSTPI-',
    'TRADE_GOODS_RECEIPT_NOTE_PURCHASE_VOUCHER_CODE_PURCHASE_SALE_TAX_VOUCHER_CODE' => 'TGRNSTPI-',
    'PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE' => 'STPRI-',
    'TRADE_PURCHASE_RETURN_SALE_TAX_VOUCHER_CODE' => 'TSTPRI-',
    'SALE_VOUCHER_CODE' => 'SI-',
    'TRADE_SALE_VOUCHER_CODE' => 'TSI-',
    'DELIVERY_ORDER_SALE_VOUCHER_CODE' => 'DOSI-',
    'TRADE_DELIVERY_ORDER_SALE_VOUCHER_CODE' => 'TDOSI-',
    'TRADE_SALE_ORDER_SALE_VOUCHER_CODE' => 'TSOSI-',
    'TRADE_SALE_ORDER_DELIVERY_ORDER_SALE_VOUCHER_CODE' => 'TSODOSI-',
    'DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE' => 'DOSTSI-',
    'TRADE_DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE' => 'TDOSTSI-',
    'TRADE_SALE_ORDER_SALE_TAX_VOUCHER_CODE' => 'TSOSTSI-',
    'TRADE_SALE_ORDER_DELIVERY_ORDER_SALE_TAX_VOUCHER_CODE' => 'TSODOSTSI-',
    'SALE_RETURN_VOUCHER_CODE' => 'SRI-',
    'TRADE_SALE_RETURN_VOUCHER_CODE' => 'TSRI-',
    'SALE_SALE_TAX_VOUCHER_CODE' => 'STSI-',
    'TRADE_SALE_SALE_TAX_VOUCHER_CODE' => 'TSTSI-',
    'SALE_RETURN_SALE_TAX_VOUCHER_CODE' => 'STSRI-',
    'TRADE_SALE_RETURN_SALE_TAX_VOUCHER_CODE' => 'TSTSRI-',
    'JOURNAL_VOUCHER_CODE' => 'JV-',
    'JOURNAL_VOUCHER_REFERENCE_CODE' => 'JVR-',
    'APPROVAL_JOURNAL_VOUCHER_CODE' => 'AJV-',
    'FIXED_ASSET_VOUCHER_CODE' => 'FAV-',
    'LOAN_VOUCHER_CODE' => 'LV-',
    'LOAN_RECEIPT_VOUCHER_CODE' => 'LRV-',
    'CASH_RECEIPT_VOUCHER_CODE' => 'CRV-',
    'CASH_PAYMENT_VOUCHER_CODE' => 'CPV-',
    'BILL_OF_LABOUR_VOUCHER_CODE' => 'BLV-',
    'BANK_RECEIPT_VOUCHER_CODE' => 'BRV-',
    'BANK_PAYMENT_VOUCHER_CODE' => 'BPV-',
    'CUSTOM_VOUCHER_CODE' => 'CV-',
    'ADVANCE_FEE_VOUCHER_CODE' => 'AFV-',
    'ADVANCE_FEE_REVERSE_VOUCHER_CODE' => 'AFRV-',
    'FEE_PAID_VOUCHER_CODE' => 'FPV-',
    'STUDENT_BOOKED_VOUCHER_CODE' => 'SBV-',
    'STUDENT_DISCOUNT_INCREASE_CODE' => 'DIV-',
    'PRODUCT_LOSS_VOUCHER_CODE' => 'PLV-',
    'TRADE_PRODUCT_LOSS_VOUCHER_CODE' => 'TPLV-',
    'PRODUCT_CONSUMED_VOUCHER_CODE' => 'PCV-',
    'PRODUCT_PRODUCED_VOUCHER_CODE' => 'PPV-',
    'PRODUCT_RECOVER_VOUCHER_CODE' => 'PRV-',
    'TRADE_PRODUCT_RECOVER_VOUCHER_CODE' => 'TPRV-',
    'EXPENSE_PAYMENT_VOUCHER_CODE' => 'EPV-',
    'SERVICE_VOUCHER_CODE' => 'SEI-',
    'SERVICE_SALE_TAX_VOUCHER_CODE' => 'STSEI-',
    'SALARY_SLIP_VOUCHER_CODE' => 'SSV-',
    'GENERATE_SALARY_SLIP_VOUCHER_CODE' => 'GSSV-',
    'SALARY_PAYMENT_VOUCHER_CODE' => 'SPV-',
    'CASH_TRANSFER_CODE' => 'CT-',
    'ADVANCE_SALARY_VOUCHER_CODE' => 'ASV-',
    'POST_DATED_CHEQUE_ISSUE' => 'PDCI-',
    'POST_DATED_CHEQUE_RECEIVED' => 'PDCR-',
    'PRODUCT_MANUFACTURE_VOUCHER_CODE' => 'PMV-',
    'SALE_ORDER_VOUCHER_CODE' => 'SO-',
    'TRADE_SALE_ORDER_VOUCHER_CODE' => 'TSO-',
    'DELIVERY_ORDER_VOUCHER_CODE' => 'DO-',
    'TRADE_DELIVERY_ORDER_VOUCHER_CODE' => 'TDO-',
    'GOODS_RECEIPT_NOTE_CODE' => 'GRN-',
    'TRADE_GOODS_RECEIPT_NOTE_CODE' => 'TGRN-',
    'TRADE_GOODS_RECEIPT_NOTE_RETURN_CODE' => 'TGRNR-',
    'DELIVERY_CHALLAN_VOUCHER_CODE' => 'DC-',
    'TRADE_DELIVERY_CHALLAN_VOUCHER_CODE' => 'TDC-',
    'STOCK_CONSUMED_VOUCHER_CODE' => 'SC-',
    'STUCK_OFF_STUDENT_VOUCHER_CODE' => 'SOS-',
    'TRANSPORT_VOUCHER_CODE' => 'TV-',


    'ORDER_LIST_CODE' => 'OL-',

    // Product Type
    'parent_product_type' => '1',
    'child_product_type' => '2',

    // Product Type
    'product_active_status' => 'ACTIVE',
    'product_discontinue_status' => 'DISCONTINUE',
    'product_lock_status' => 'LOCK',

    //country ID
    'country_id' => '164',

    //desktop user status
    'online' => 'online',
    'offline' => 'offline',


    //bank receipt voucher type
    'brv_dr_type' => 'DR',
    'brv_cr_type' => 'CR',

    // Log
    'Journal_Voucher' => 'Journal Voucher',
    'Approval_Journal_Voucher' => 'Approval Journal Voucher',
    'Line_Break' => '&oS;',

    // API response codes
    'OK' => 1,
    'NOT_OK' => 2,
    'NOT_VALID' => 3,
    'NOT_FOUND' => 4,
    'DATA_EMPTY' => 5,
    'UN_DELETED' => 6,
    'ALREADY_EXISTS' => 7,
    'DISABLE' => 8,
    'DELETED' => 9,
    'ALREADY_LOGIN' => 10,
];
