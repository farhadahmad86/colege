<?php

namespace App\Traits;
trait RolePermissionTrait
{
    function __construct()
    {
        // Registration Start
        // Employee
        $this->middleware('permission:Employee|Employee List', ['only' => ['add_employee', 'employee_list', 'edit_employee']]);

        // Role N Permission
        $this->middleware('permission:Modular Group List|Modular Group', ['only' => ['role_permission_list', 'add_role_permission', 'submit_role_permission', 'edit_role_permission', 'update_role_permission']]);

        // Role N Permission
//        $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['role_permission_list','add_role_permission','submit_role_permission','edit_role_permission','update_role_permission']]);

//         Region
        $this->middleware('permission:Region List|Region', ['only' => ['region_list', 'add_region', 'submit_region', 'edit_region', 'update_region']]);

        // Area
        $this->middleware('permission:Area List|Area', ['only' => ['area_list', 'add_area', 'submit_area', 'edit_area', 'update_area']]);

        // Sector
        $this->middleware('permission:Sector List|Sector', ['only' => ['sector_list', 'add_sector', 'submit_sector', 'edit_sector', 'update_sector']]);

        // Town
        $this->middleware('permission:Town List|Town', ['only' => ['town_list', 'add_town', 'submit_town', 'edit_town', 'update_town']]);

        // Client Supplier
        $this->middleware('permission:Client/Supplier List|Client/Supplier', ['only' => ['account_receivable_payable_simple_list', 'receivables_account_registration', 'edit_account_receivable_payable']]);

        // Bank
        $this->middleware('permission:Client/Supplier List|Client/Supplier', ['only' => ['bank_account_list', 'bank_account_registration', 'edit_account']]);

        // Salary
        $this->middleware('permission:Salary Account List|Salary Account', ['only' => ['salary_account_list', 'salary_account_registration', 'edit_account']]);

        // Expense
        $this->middleware('permission:Expense Account List|Expense Account', ['only' => ['expense_account_list', 'expense_account_registration', 'edit_account']]);
//
        // Chart Of Accounts Tree
        $this->middleware('permission:Chart Of Account Tree', ['only' => ['first_level_chart_of_account']]);

        // Parent Account
        $this->middleware('permission:Parent Account List|Parent Account', ['only' => ['second_level_chart_of_account_list', 'add_second_level_chart_of_account', 'edit_second_level_chart_of_account']]);

        // Child Account
        $this->middleware('permission:Child Account List|Child Account', ['only' => ['third_level_chart_of_account_list', 'add_third_level_chart_of_account', 'edit_third_level_chart_of_account']]);

        // Account Reporting Group
        $this->middleware('permission:Account Reporting Group List|Account Reporting Group', ['only' => ['account_group_list', 'add_account_group', 'edit_account_group']]);

        // Entry Account
        $this->middleware('permission:Entry Account List|Entry Account', ['only' => ['account_list', 'account_registration', 'edit_account']]);

        // Entry Account
        $this->middleware('permission:Entry Account List|Entry Account', ['only' => ['account_list', 'account_registration', 'edit_account']]);

        // Asset Registration
        $this->middleware('permission:Asset Registration List|Asset Registration', ['only' => ['fixed_asset_list', 'fixed_asset', 'edit_fixed_asset']]);

        // Capital Registration
        $this->middleware('permission:Capital Registration List|Capital Registration', ['only' => ['capital_registration_list', 'capital_registration', 'edit_capital_registration']]);

        // Cash Transfer
        $this->middleware('permission:Reject Cash Transfer List|Cash Transfer|Approve Cash Transfer List|pending_cash_transfer_list', ['only' => ['reject_cash_transfer_list', 'cash_transfer', 'approve_cash_transfer_list', 'pending_cash_transfer_list']]);

        // Credit Card Machine
        $this->middleware('permission:Credit Card Machine List|Credit Card Machine', ['only' => ['credit_card_machine_list', 'add_credit_card_machine', 'edit_credit_card_machine']]);

        // Warehouse
        $this->middleware('permission:Warehouse List|Warehouse', ['only' => ['warehouse_list', 'add_warehouse', 'edit_warehouse']]);

        // Modular Group
//        $this->middleware('permission:Modular Group List|Create Modular Group', ['only' => ['modular_group_list', 'add_modular_group', 'edit_modular_group']]);

        // Department
//        $this->middleware('permission:Department List|Department Create', ['only' => ['index', 'create', 'edit']]);

        // Posting Reference
        $this->middleware('permission:Posting Reference List|Posting Reference', ['only' => ['posting_reference_list', 'add_posting_reference', 'edit_posting_reference']]);

        // Product Group
        $this->middleware('permission:Product Reporting Group List|Product Reporting Group', ['only' => ['product_group_list', 'product_group', 'edit_product_group']]);

        // Main Unit
        $this->middleware('permission:Main Unit List|Main Unit', ['only' => ['main_unit_list', 'add_main_unit', 'edit_main_unit']]);

        // Unit
        $this->middleware('permission:Unit List|Unit', ['only' => ['unit_list', 'add_unit', 'edit_unit']]);

        // Group
        $this->middleware('permission:Group List|Group', ['only' => ['group_list', 'add_group', 'edit_group']]);

        // Category
        $this->middleware('permission:Category List|Category', ['only' => ['category_list', 'add_category', 'edit_category']]);

        // Brand
        $this->middleware('permission:Brand List|Brand', ['only' => ['brand_list', 'add_brand', 'edit_brand']]);

        // Product
        $this->middleware('permission:Product List|Product|Product Price List', ['only' => ['product_list', 'add_product', 'edit_product', 'product_price_update', 'online_product_list']]);

        // Service
        $this->middleware('permission:Service List|Service', ['only' => ['services_list', 'add_services', 'edit_services']]);

        // Product Clubbing
        $this->middleware('permission:Product Clubbing List|Product Clubbing', ['only' => ['product_clubbing_list', 'product_clubbing', 'edit_product_clubbing']]);

        // Product Packages
        $this->middleware('permission:Product Packages List|Product Packages', ['only' => ['product_packages_list', 'product_packages', 'edit_product_packages']]);

        // Product List Stock Wise
        $this->middleware('permission:Product Ledger Stock Wise List|Product Wise Ledger|Product Ledger Amount Wise', ['only' => ['product_ledger_stock_wise', 'product_wise_ledger', 'product_ledger_amount_wise']]);


        // Trade Product Packages
        $this->middleware('permission:Trade Product Packages List|Trade Product Packages', ['only' => ['trade_product_packages_list', 'trade_product_packages', 'edit_product_clubbing']]);
//        // Registration End
//
//        // Voucher Start
        // Cash Receipt Voucher
        $this->middleware('permission:Cash Receipt Voucher List|Cash Receipt Voucher|Post Cash Receipt Voucher', ['only' => ['cash_receipt_voucher_list', 'cash_receipt_voucher', 'cash_receipt_post_voucher_list', 'edit_cash_receipt_voucher']]);

        $this->middleware('permission:Cash Receipt Voucher List', ['only' => ['cash_receipt_voucher_list']]);
        $this->middleware('permission:Cash Receipt Voucher', ['only' => ['cash_receipt_voucher']]);
        $this->middleware('permission:Post Cash Receipt Voucher', ['only' => ['cash_receipt_post_voucher_list']]);

        // Cash Payment Voucher
        $this->middleware('permission:Cash Payment Voucher List|Cash Payment Voucher|Post Cash Payment Voucher', ['only' => ['cash_payment_voucher_list', 'cash_payment_voucher', 'cash_payment_post_voucher_list']]);

        $this->middleware('permission:Cash Payment Voucher List', ['only' => ['cash_payment_voucher_list']]);
        $this->middleware('permission:Cash Payment Voucher', ['only' => ['cash_payment_voucher']]);
        $this->middleware('permission:Post Cash Payment Voucher', ['only' => ['cash_payment_post_voucher_list']]);

        // Bank Receipt Voucher
        $this->middleware('permission:Bank Receipt Voucher List|Bank Receipt Voucher|Post Bank Receipt Voucher List', ['only' => ['bank_receipt_voucher_list', 'bank_receipt_voucher', 'bank_receipt_post_voucher_list']]);

        $this->middleware('permission:Bank Receipt Voucher List', ['only' => ['bank_receipt_voucher_list']]);
        $this->middleware('permission:Bank Receipt Voucher', ['only' => ['bank_receipt_voucher']]);
        $this->middleware('permission:Post Bank Receipt Voucher List', ['only' => ['bank_receipt_post_voucher_list']]);

        // Bank Payment Voucher
        $this->middleware('permission:Bank Payment Voucher List|Bank Payment Voucher|Post Bank Payment Voucher List', ['only' => ['bank_payment_voucher_list', 'bank_payment_voucher', 'bank_payment_post_voucher_list']]);

        $this->middleware('permission:Bank Payment Voucher List', ['only' => ['bank_payment_voucher_list']]);
        $this->middleware('permission:Bank Payment Voucher', ['only' => ['bank_payment_voucher']]);
        $this->middleware('permission:Post Bank Payment Voucher List', ['only' => ['bank_payment_post_voucher_list']]);

        // Post Dated Cheque Issue
        $this->middleware('permission:Cheque Issuance Rejected List|Post Dated Cheque Issuance|Cheque Issuance Confirmed List|Cheque Issuance Pending List', ['only' => ['reject_post_dated_cheque_issue_list', 'add_post_dated_cheque_issue',
            'approve_post_dated_cheque_issue_list', 'post_dated_cheque_issue_list']]);

        $this->middleware('permission:Cheque Issuance Rejected List', ['only' => ['reject_post_dated_cheque_issue_list']]);
        $this->middleware('permission:Post Dated Cheque Issuance', ['only' => ['add_post_dated_cheque_issue']]);
        $this->middleware('permission:Cheque Issuance Confirmed List', ['only' => ['approve_post_dated_cheque_issue_list']]);
        $this->middleware('permission:Cheque Issuance Pending List', ['only' => ['post_dated_cheque_issue_list']]);

        // Post Dated Cheque Receive
        $this->middleware('permission:Cheque Receive Rejected List|Post Dated Cheque Receive|Cheque Receive Confirmed List|Cheque Receive Pending List', ['only' => ['reject_post_dated_cheque_received_list', 'add_post_dated_cheque_received',
            'approve_post_dated_cheque_received_list', 'post_dated_cheque_received_list']]);

        $this->middleware('permission:Cheque Receive Rejected List', ['only' => ['reject_post_dated_cheque_received_list']]);
        $this->middleware('permission:Post Dated Cheque Receive', ['only' => ['add_post_dated_cheque_received']]);
        $this->middleware('permission:Cheque Receive Confirmed List', ['only' => ['approve_post_dated_cheque_received_list']]);
        $this->middleware('permission:Cheque Receive Pending List', ['only' => ['post_dated_cheque_received_list']]);

        // Credit Card Machine Settlement
        $this->middleware('permission:Credit Card Machine Settlement List|Credit Card Machine Settlement', ['only' => ['credit_card_machine_settlement_list', 'credit_card_machine_settlement', 'edit_credit_card_machine_settlement']]);

        // Bank Journal Voucher
        $this->middleware('permission:Bank Journal Voucher', ['only' => ['journal_voucher_bank']]);

        // Journal Voucher
        $this->middleware('permission:Journal Voucher List|Journal Voucher', ['only' => ['journal_voucher_list', 'journal_voucher']]);

        $this->middleware('permission:Journal Voucher List', ['only' => ['journal_voucher_list']]);
        $this->middleware('permission:Journal Voucher', ['only' => ['journal_voucher']]);

        // Reference Journal Voucher
        $this->middleware('permission:Reference Journal Voucher List|Reference Journal Voucher', ['only' => ['journal_voucher_reference_list', 'journal_voucher_reference']]);
        $this->middleware('permission:Reference Journal Voucher List', ['only' => ['journal_voucher_reference_list']]);
        $this->middleware('permission:Reference Journal Voucher', ['only' => ['journal_voucher_reference']]);
//
        // Expense Payment Voucher
        $this->middleware('permission:Expense Payment Voucher List|Expense Payment Voucher|Post Expense Payment Voucher', ['only' => ['expense_payment_voucher_list', 'expense_payment_voucher', 'expense_payment_post_voucher_list']]);

        $this->middleware('permission:Expense Payment Voucher List', ['only' => ['expense_payment_voucher_list']]);
        $this->middleware('permission:Expense Payment Voucher', ['only' => ['expense_payment_voucher']]);
        $this->middleware('permission:Post Expense Payment Voucher', ['only' => ['expense_payment_post_voucher_list']]);

        // Approval Journal Voucher
        $this->middleware('permission:Approval Journal Voucher List|Approval Journal Voucher|Approval Journal Voucher Approved List|Approval Journal Voucher Rejected List', ['only' => ['approval_journal_voucher_list', 'approval_journal_voucher', 'approval_journal_voucher_approved_list', 'approval_journal_voucher_rejected_list']]);

        $this->middleware('permission:Approval Journal Voucher List', ['only' => ['approval_journal_voucher_list']]);
        $this->middleware('permission:Approval Journal Voucher', ['only' => ['approval_journal_voucher']]);
        $this->middleware('permission:Approval Journal Voucher Approved List', ['only' => ['approval_journal_voucher_approved_list']]);
        $this->middleware('permission:Approval Journal Voucher Rejected List', ['only' => ['approval_journal_voucher_rejected_list']]);

        // Approval Bank Journal Voucher
        $this->middleware('permission:Approval Bank Journal Voucher|Approval Journal Voucher Reference', ['only' => ['approval_journal_voucher_bank', 'approval_journal_voucher_reference']]);

        // Approval Journal Voucher Project List
        $this->middleware('permission:Approval Journal Voucher Project List|', ['only' => ['approval_journal_voucher_project_list']]);

        // Bill Of Labour Voucher
        $this->middleware('permission:Bill of Labour Voucher List|Bill of Labour Voucher|Post Bill of Labour Voucher list', ['only' => ['bill_of_labour_voucher_list', 'bill_of_labour_voucher', 'bill_of_labour_post_voucher_list']]);

        $this->middleware('permission:Bill of Labour Voucher List', ['only' => ['bill_of_labour_voucher_list']]);
        $this->middleware('permission:Bill of Labour Voucher|Post Bill of Labour Voucher list', ['only' => ['bill_of_labour_voucher']]);
        $this->middleware('permission:Post Bill of Labour Voucher list', ['only' => ['bill_of_labour_post_voucher_list']]);

        // Fixed Asset Voucher
        $this->middleware('permission:Fixed Asset Voucher List|Fixed Asset Voucher', ['only' => ['fixed_asset_voucher_list', 'fixed_asset_voucher']]);

        $this->middleware('permission:Fixed Asset Voucher List', ['only' => ['fixed_asset_voucher_list']]);
        $this->middleware('permission:Fixed Asset Voucher', ['only' => ['fixed_asset_voucher']]);

        // Loan Payment Voucher
        $this->middleware('permission:Loan Payment Voucher List|Loan Payment Voucher', ['only' => ['loan_voucher_list', 'loan_voucher']]);

        $this->middleware('permission:Loan Payment Voucher List', ['only' => ['loan_voucher_list']]);
        $this->middleware('permission:Loan Payment Voucher', ['only' => ['loan_voucher']]);
        // Voucher End

        // Loan Receipt Voucher
        $this->middleware('permission:Loan Receipt Voucher List|Loan Receipt Voucher', ['only' => ['loan_receipt_voucher_list', 'loan_receipt_voucher']]);

        $this->middleware('permission:Loan Receipt Voucher List', ['only' => ['loan_receipt_voucher_list']]);
        $this->middleware('permission:Loan Receipt Voucher', ['only' => ['loan_receipt_voucher']]);
        // Voucher End

        // Invoice Start
        // Purchase Invoice
        $this->middleware('permission:Purchase List|Purchase Invoice', ['only' => ['purchase_invoice_list', 'purchase_invoice']]);

        $this->middleware('permission:Purchase List', ['only' => ['purchase_invoice_list']]);
        $this->middleware('permission:Purchase Invoice', ['only' => ['purchase_invoice']]);
        // Purchase Tax Invoice
        $this->middleware('permission:Purchase (Tax) List', ['only' => ['sale_tax_purchase_invoice_list']]);

        $this->middleware('permission:Purchase Tax Invoice', ['only' => ['purchase_tax_invoice']]);

        // Purchase Return Invoice
        $this->middleware('permission:Purchase Return List|Purchase Return', ['only' => ['purchase_return_invoice_list', 'purchase_return_invoice']]);

        $this->middleware('permission:Purchase Return List', ['only' => ['purchase_return_invoice_list']]);
        $this->middleware('permission:Purchase Return', ['only' => ['purchase_return_invoice']]);
        // Purchase Tax Return Invoice
        $this->middleware('permission:Purchase Return List|Purchase Tax Return', ['only' => ['sale_tax_purchase_return_invoice_list', 'purchase_tax_return_invoice']]);

        $this->middleware('permission:Purchase Tax Return List', ['only' => ['sale_tax_purchase_return_invoice_list']]);
        $this->middleware('permission:Purchase Tax Return', ['only' => ['purchase_tax_return_invoice']]);

        // Trade Purchase Invoice
        $this->middleware('permission:Purchase List|Trade Purchase Inoice', ['only' => ['trade_purchase_invoice_list', 'trade_purchase_invoice']]);

        $this->middleware('permission:Purchase List|', ['only' => ['trade_purchase_invoice_list']]);
        $this->middleware('permission:Trade Purchase Invoice', ['only' => ['trade_purchase_invoice']]);
        // Trade Purchase Tax Invoice
        $this->middleware('permission:Purchase Return List|Purchase Tax Return', ['only' => ['trade_sale_tax_purchase_invoice_list', 'trade_purchase_tax_invoice']]);

        $this->middleware('permission:Purchase Return List', ['only' => ['trade_purchase_tax_invoice']]);
        $this->middleware('permission:Purchase Tax Return', ['only' => ['trade_purchase_tax_invoice']]);

        // Trade Purchase Return Invoice
        $this->middleware('permission:Purchase Return List|Purchase Return', ['only' => ['trade_purchase_return_invoice_list', 'trade_purchase_return_invoice']]);
        // Trade Purchase Tax Return Invoice
        $this->middleware('permission:Purchase Return List|Purchase Tax Return', ['only' => ['trade_sale_tax_purchase_return_invoice_list', 'trade_purchase_tax_return_invoice']]);

        // Sale Invoice
        $this->middleware('permission:Sale List|Sale Invoice', ['only' => ['sale_invoice_list', 'sale_invoice']]);

        $this->middleware('permission:Sale List', ['only' => ['sale_invoice_list']]);
        $this->middleware('permission:Sale Invoice', ['only' => ['sale_invoice']]);
        // Sale Tax Invoice
        $this->middleware('permission:Sale (Tax) List|Sale Invoice', ['only' => ['sale_tax_sale_invoice_list', 'sale_tax_invoice']]);

        $this->middleware('permission:Sale List', ['only' => ['sale_tax_sale_invoice_list']]);
        $this->middleware('permission:Sale Tax Invoice', ['only' => ['sale_tax_invoice']]);

        // Sale Return Invoice
        $this->middleware('permission:Sale Return List|Sale Return', ['only' => ['sale_return_invoice_list', 'sale_return_invoice']]);

        $this->middleware('permission:Sale Return List', ['only' => ['sale_return_invoice_list']]);
        $this->middleware('permission:Sale Return', ['only' => ['sale_return_invoice']]);

        // Sale Return Tax Invoice
        $this->middleware('permission:Sale (Tax) Return List|Sale Tax Return', ['only' => ['sale_tax_sale_return_invoice_list', 'sale_tax_return_invoice']]);

        // Trade Sale Invoice
        $this->middleware('permission:Sale Invoice List|Sale Invoice', ['only' => ['trade_sale_invoice_list', 'trade_sale_invoice']]);

        $this->middleware('permission:Sale Invoice List', ['only' => ['trade_sale_invoice_list']]);
        $this->middleware('permission:Sale Invoice', ['only' => ['trade_sale_invoice']]);

        // Trade Sale Tax Invoice
        $this->middleware('permission:Sale Tax Invoice List|Sale Tax Invoice', ['only' => ['trade_sale_tax_sale_invoice_list', 'trade_sale_tax_invoice']]);

        $this->middleware('permission:Sale Tax Invoice List', ['only' => ['trade_sale_tax_sale_invoice_list']]);
        $this->middleware('permission:Sale Tax Invoice', ['only' => ['trade_sale_tax_invoice']]);

        // Trade Sale Return Invoice
        $this->middleware('permission:Sale Return Invoice List|Sale Return Invoice', ['only' => ['trade_sale_return_invoice_list', 'trade_sale_return_invoice']]);

        $this->middleware('permission:Sale Return Invoice List', ['only' => ['trade_sale_return_invoice_list']]);
        $this->middleware('permission:Sale Return Invoice', ['only' => ['trade_sale_return_invoice']]);

        // Trade Sale Return Tax Invoice
        $this->middleware('permission:Sale Tax Return Invoice List|Sale Tax Return Invoice', ['only' => ['trade_sale_tax_sale_return_invoice_list', 'trade_sale_tax_return_invoice']]);

        $this->middleware('permission:Sale Tax Return Invoice List', ['only' => ['trade_sale_tax_sale_return_invoice_list']]);
        $this->middleware('permission:Sale Tax Return Invoice', ['only' => ['trade_sale_tax_return_invoice']]);
        // Invoice End
        // Stock Movement Start
        // Transfer Product Stock
        $this->middleware('permission:Warehouse Transfer List|Warehouse Transfer', ['only' => ['transfer_product_stock_list', 'add_transfer_product_stock']]);
        // Trade Transfer Product Stock
        $this->middleware('permission:Warehouse Transfer List|Warehouse Transfer', ['only' => ['trade_transfer_product_stock_list', 'add_trade_transfer_product_stock']]);

        // Product Lost
        $this->middleware('permission:Product Lost List|Product Lost', ['only' => ['product_loss_list', 'product_loss']]);

        $this->middleware('permission:Product Lost List', ['only' => ['product_loss_list']]);
        $this->middleware('permission:Product Lost', ['only' => ['product_loss']]);
        // Trade Product Lost
        $this->middleware('permission:Product Lost List|Product Lost', ['only' => ['trade_product_loss_list', 'trade_product_loss']]);

        $this->middleware('permission:Product Lost List', ['only' => ['trade_product_loss_list']]);
        $this->middleware('permission:Product Lost', ['only' => ['trade_product_loss']]);

        // Product Recover
        $this->middleware('permission:Product Recover List|Product Recover', ['only' => ['product_recover_list', 'product_recover']]);
        // Trade Product Recover
        $this->middleware('permission:Product Recover List|Product Recover', ['only' => ['trade_product_recover_list', 'trade_product_recover']]);

        // Convert Quantity
        $this->middleware('permission:Convert Quantity List|Convert Quantity', ['only' => ['convert_quantity_list', 'convert_quantity']]);
        // Trade Convert Quantity
        $this->middleware('permission:Convert Quantity List|Convert Quantity', ['only' => ['trade_convert_quantity_list', 'trade_convert_quantity']]);

        // Claim Issuance To Vendor
        $this->middleware('permission:Claim Issuance To Vendor List|Claim Issuance To Vendor', ['only' => ['claim_stock_issue_to_party_list', 'add_claim_stock_issue_to_party']]);
        // Trade Claim Issuance To Vendor
        $this->middleware('permission:Claim Issuance To Vendor List|Claim Issuance To Vendor', ['only' => ['trade_claim_stock_issue_to_party_list', 'add_trade_claim_stock_issue_to_party']]);

        // Claim Receive From Vendor
        $this->middleware('permission:Claim Receive From Vendor List|Claim Receive From Vendor', ['only' => ['claim_stock_receive_list', 'add_claim_stock_receive']]);
        // Trade Claim Receive From Vendor
        $this->middleware('permission:Claim Receive From Vendor List|Claim Receive From Vendor', ['only' => ['trade_claim_stock_receive_list', 'add_trade_claim_stock_receive']]);
        // Stock Movement End

        // Manufacturing Start
        // Recipe
        $this->middleware('permission:Receipe List|Receipe', ['only' => ['product_recipe_list', 'product_recipe']]);
        // Production Stock Adjustment
        $this->middleware('permission:Production Stock Adjustment List|Production Stock Adjustment', ['only' => ['production_stock_adjustment_list', 'production_stock_adjustment']]);

        // Manufacturing End

        // Supply Chain Start
        // Sale Order
        $this->middleware('permission:Sale Order List|Sale Order', ['only' => ['sale_order_list', 'sale_order']]);
        // Trade Sale Order
        $this->middleware('permission:Trade Sale Order List|Sale Order', ['only' => ['trade_sale_order_list', 'trade_sale_order']]);

        // Delivery Order
        $this->middleware('permission:Delivery Order List|Delivery Order|Delivery Order Sale Invoice', ['only' => ['delivery_order_invoice_list', 'delivery_order', 'delivery_order_sale_invoice']]);
        // Trade Delivery Order
        $this->middleware('permission:Trade Delivery Order List|Trade Delivery Order|Trade Delivery Order Sale Invoice|Trade Delivery Order Sale Tax Invoice', ['only' => ['trade_delivery_order_invoice_list', 'trade_delivery_order', 'trade_delivery_order_sale_invoice', 'trade_delivery_order_sale_tax_invoice']]);

        // Delivery Challan
        $this->middleware('permission:Delivery Challan List|Delivery Challan', ['only' => ['delivery_challan_list', 'delivery_challan']]);
        // Trade Delivery Challan
        $this->middleware('permission:Trade Delivery Challan List|Trade Delivery Challan', ['only' => ['trade_delivery_challan_list', 'trade_delivery_challan']]);

        // Goods Receipt Note
        $this->middleware('permission:Goods Receipt Note List|Goods Receipt Note|Goods Receipt Note Purchase Invoice', ['only' => ['goods_receipt_note_list', 'goods_receipt_note', 'grn_purchase_invoice']]);

        // Trade Goods Receipt Note
        $this->middleware('permission:Goods Receipt Note List|Trade Goods Receipt Note|Trade Goods Receipt Note Purchase Invoice', ['only' => ['trade_goods_receipt_note_list', 'trade_goods_receipt_note', 'trade_grn_purchase_invoice']]);
        // Trade Goods Receipt Note Return
        $this->middleware('permission:Goods Receipt Note Return List|Trade Goods Receipt Note Return', ['only' => ['trade_goods_receipt_note_return_list', 'trade_goods_receipt_note_return']]);

        // Stock Inward
        $this->middleware('permission:Stock Inward List|Stock Inward', ['only' => ['stock_inward_list', 'stock_inward']]);
        // Stock Outward
        $this->middleware('permission:Goods Receipt Note List|Trade Goods Receipt Note', ['only' => ['stock_outward_list', 'stock_outward']]);
        // Supply Chain End

        // HR Module Start
        // Advance Salary Voucher
//        $this->middleware('permission:Advance Salary Voucher List|Advance Salary Voucher', ['only' => ['advance_salary_list', 'add_new_advance_salary']]);
        // Generate Salary Voucher
//        $this->middleware('permission:Generate Salary Slip Voucher List|Generate Salary Slip Voucher', ['only' => ['generate_salary_slip_voucher_list', 'generate_salary_slip_voucher']]);
        // Salary Payment Voucher
        $this->middleware('permission:Salary Payment Voucher List|Salary Payment Voucher', ['only' => ['salary_payment_list', 'new_salary_payment_voucher']]);
        // Loan
        $this->middleware('permission:Loan List|Loan', ['only' => ['loan_list', 'add_loan']]);
        $this->middleware('permission:Month Wise Salary List', ['only' => ['month_wise_salary_detail_list']]);
        $this->middleware('permission:Loan Pending List', ['only' => ['loan_pending_list']]);
        // HR Module End

        // Financials Start
        // Ledgers
        $this->middleware('permission:Parties Ledger|Account Ledger|Daily Activity Report', ['only' => ['parties_account_ledger', 'chart_of_account_ledger', 'today_report_list']]);
        // Day Closing
        $this->middleware('permission:Day Closing Execution|Day End Reports', ['only' => ['start_day_end', 'day_end_reports']]);
        // Financial Presentation
        $this->middleware('permission:Income Statement|Balance Sheet', ['only' => ['profit_n_loss_generator', 'balance_sheet_report_generator']]);
        // Financials End

        // System Configuration Start
        // Day End Configuration
        $this->middleware('permission:Day End Configuration|Invoice Configuration', ['only' => ['day_end_config', 'report_config']]);
        // System Configuration End

        // Reports Start
        // Reports
        $this->middleware('permission:Client & Supplier Reports', ['only' => ['account_receivable_payable_list']]);
        $this->middleware('permission:Product Margin Reports', ['only' => ['product_margin_report']]);
        $this->middleware('permission:Project Wise Expense Report', ['only' => ['project_wise_expense_report']]);

        // Profit Reports
        $this->middleware('permission:Cash Book', ['only' => ['cashbook']]);
        $this->middleware('permission:Party Wise Opening Closing', ['only' => ['party_wise_opening_closing']]);
        $this->middleware('permission:Account Payable List', ['only' => ['account_payable_list',]]);
        $this->middleware('permission:Account Receivable List', ['only' => ['account_receivable_list']]);
        $this->middleware('permission:Product Wise Profit|', ['only' => ['product_wise_profit']]);
        $this->middleware('permission:Supplier Wise Profit', ['only' => ['supplier_wise_profit']]);
        $this->middleware('permission:Client Wise Profit', ['only' => ['client_wise_profit']]);
        $this->middleware('permission:Sale Person Wise Profit', ['only' => ['sale_invoice_wise_profit']]);
        $this->middleware('permission:Sale Invoice Wise Profit|Sale Report', ['only' => ['sale_invoice_wise_profit']]);
        $this->middleware('permission:Sale Report', ['only' => ['sale_report']]);

        // Stock Reports
        $this->middleware('permission:Warehouse Stock', ['only' => ['warehouse_stock']]);
        $this->middleware('permission:Product Last Sale Rate', ['only' => ['product_last_sale_rate_verification']]);
        $this->middleware('permission:Product Last Purchase Rate', ['only' => ['product_last_purchase_rate_verification']]);
        $this->middleware('permission:Stock Activity Report', ['only' => ['stock_activity_report']]);
        $this->middleware('permission:Party Wise Last Sale Rate', ['only' => ['party_last_sale_rate_verification']]);
        $this->middleware('permission:Party Wise Last Purchase Rate', ['only' => ['party_last_purchase_rate_verification']]);

        // Aging Reports
        $this->middleware('permission:Customer Aging Report', ['only' => ['customer_aging_report']]);
        $this->middleware('permission:Supplier Aging Report', ['only' => ['supplier_aging_report']]);
        $this->middleware('permission:Product Aging Report', ['only' => ['aging_report_product_wise']]);
        $this->middleware('permission:Party Wise Sale Aging Report', ['only' => ['aging_report_party_wise_sale']]);
        $this->middleware('permission:Party Wise Last Purchase Rate', ['only' => ['party_last_purchase_rate_verification']]);

        // Sale Register
        $this->middleware('permission:Sale Register', ['only' => ['sale_register']]);
        // Purchase Register
        $this->middleware('permission:Purchase Register', ['only' => ['purchase_register']]);

        // Reports End
        // Force Offline Start
        $this->middleware('permission:Force Offline', ['only' => ['force_offline_user']]);
        // Force Offline End


// Reports End
        // Force Offline Start
        $this->middleware('permission:Force Offline', ['only' => ['force_offline_user']]);
        $this->middleware('permission:Force Offline Web', ['only' => ['force_offline_user_web']]);
        // Force Offline End


        // college permission
        $this->middleware('permission:Dashboard|S-Dash', ['only' => ['student_dashboard']]);
        $this->middleware('permission:Create Installments', ['only' => ['create_installments']]);

        $this->middleware('permission:Degree', ['only' => ['add_degree']]);
        $this->middleware('permission:Degree List', ['only' => ['degree_list']]);
        $this->middleware('permission:Fee Summary Report', ['only' => ['fee_summary_report']]);
        $this->middleware('permission:Edit Exam', ['only' => ['edit_exam']]);
        
        $this->middleware('permission:Custom Voucher Pending List', ['only' => ['custom_voucher_pending_list']]);

    }
}
