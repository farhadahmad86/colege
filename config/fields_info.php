<?php


return [

    'sale_return_search' => [
        'description' => 'Enter sale invoice number and press Enter button.',

    ],

    'search_btn' => [
        'description' => 'Search this Item',
    ],



    'about_form_fields' => [

        'add' => [
            'description' => 'Add this item',
        ],
        'refresh' => [
            'description' => 'Refresh this item',
        ],
 'barcode' => [
            'description' => 'Generate barcode',
        ],

        'control_account' => [
            'description' => 'BasicPackage elements of accounting',
            'example' => 'i.e ASSET EXPENSE CAPITAL LIABILITY INCOME',
            'validations' => 'No Validation',
        ],

        'parent_account' => [
            'description' => 'First linked account from chart of account',
            'benefits' => 'First linked account  with chart of account',
            'example' => 'Classification of accounts like expense classification could be CGS expense, selling expense and operating expense',
        ],

        'child_account' => [
            'description' => 'First linked account from parent account',
            'benefits' => 'First linked account  with parent account',
            'example' => 'Classification of bank accounts like current account, saving account and loan account',
        ],
        'town' => [
            'description' => 'Name of particular locations that is fall in a particular sector under area',
            'benefits' => 'Town Classification according to Area',
            'example' => '"i.e
Region: Multan
Area: Central Multan
Sector: Dolat Gate
Town: Dolat Gate Allang (town 1)
Dolat Gate Market (town 2)"
',
        ],

        'party_registration' => [

            'general_fields' => [
                'remarks' => [
                    'description' => 'Some extra information about this page.',
                    'benefits' => 'For better understanding',
                    'example' => 'i.e top sale since 2015',
                    'validations' => 'No Validation',
                ],
            ],


            'region' => [
                'name' => [
                    'description' => 'Name of regions where organization performing its operations.',
                    'benefits' => 'Sales Analasys region wise',
                    'example' => 'i.e Multan,Khanewal etc',
                    'validations' => 'No Validation',
                ],
            ],
            'area' => [
                'area_title' => [
                    'description' => 'Name of locations that is fall in a particular region',
                    'benefits' => 'Area classification according to region',
                    'example' => 'i.e. South Multan, North Multan, Center Multan',
                    'validations' => 'No Validation',
                ],
            ],
            'sector' => [
                'sector_title' => [
                    'description' => 'Name of particular locations that is fall in a particular area under region',
                    'benefits' => 'Sector classification according to region and area',
                    'example' => 'i.e
Region: Multan
Area: Central Multan
Sector: Dolat Gate
',
                    'validations' => 'No Validation',
                ],
            ],
            'client_registration' => [

                'account_ledger_access_group' => [
                    'description' => 'Specific users can view section on their privileges',
                    'benefits' => 'Ensure system data security ',
                    'example' => 'i.e administration,accounts,teller',
                ],
                'customer_title' => [
                    'description' => 'This represent ledger title or account title',
                    'benefits' => 'Party identification',
                    'example' => 'i.e Mr. Ahmad is owner of UN Ambro(Company)',
                    'validations' => 'No Validation',
                ],
                'sale_person' => [
                    'description' => 'List of salesman who is entertaining this particular customer',

                ],
                'print_name' => [
                    'description' => 'Name to be printed on Invoices',
                    'benefits' => 'Better understanding or recognition',
                    'example' => 'i.e Hamza(0707)',
                    'validations' => 'No Validation',
                ],
                'cnic' => [
                    'description' => 'National Identity Number',
                    'benefits' => 'No Replication',
                    'example' => '21321-32132131-5(Aslam)
21321-32132131-6(Aslam)
',
                    'validations' => 'No Validation',
                ],
                'address' => [
                    'description' => 'Residence of person to contact',
                    'benefits' => 'Tracing person in emergency',
                    'example' => '126-E  Gulistan Colony Multan',
                    'validations' => 'No Validation',
                ],
                'proprietor' => [
                    'description' => 'Owner of business or entity',
                    'benefits' => 'Identified person role in the organization',
                    'example' => 'i.e Irshad-ul-Haq CEO of CSP, Softagics',
                    'validations' => 'No Validation',
                ],
                'company_code' => [
                    'description' => 'Company code given by HR Department',
                    'example' => 'i.e 0707',
                ],
                'mobile' => [
                    'description' => 'A personal phone to contact',
                    'benefits' => 'Keep in contact 24/7',
                    'example' => 'i.e 0321-2121214',
                ],
                'whatsApp' => [
                    'description' => 'Digital App Number',
                    'benefits' => 'Share digital media',
                    'example' => 'i.e 0321-2121214',
                ],
                'phone' => [
                    'description' => 'Land line number of person or organization',
                    'benefits' => 'Call land line to land line officially',
                    'example' => 'i.e 0615-235654',
                ],
                'email' => [
                    'description' => 'Electronic message plateform id',
                    'benefits' => 'Digitally convey messages via internet',
                    'example' => 'i.e example@example.com',
                ],
                'gst' => [
                    'description' => 'General Sales Tax No',
                    'benefits' => 'sales tax invoice working',
                    'example' => 'i.e 1234567',
                ],
                'ntn' => [
                    'description' => 'National Taxation Number',
                    'benefits' => 'sales tax invoice working',
                    'example' => 'i.e 1234567',
                ],
                'credit_limit' => [
                    'description' => 'A limit allowed to a party for credit transactions',
                    'benefits' => 'Controlling working capital',
                    'example' => 'i.e 50000',
                ],
                'manual_ledger_number' => [
                    'description' => 'Manual book account page number',
                    'benefits' => 'Manual Tracking of Account',
                    'example' => 'i.e 32',
                ],

            ],
            'supplier_registration' => [
                'account_title' => [
                    'description' => 'This represent ledger title or account title',
                    'benefits' => 'Party identification',
                    'example' => 'i.e Mr. Ahmad is owner of UN Ambro(Company)',
                    'validations' => 'No Validation',
                ],
                'purchaser' => [],

            ],
        ],

        'account_registration' => [
            'bank_account' => [

                'account_viewing_group' => [],
                'account_ledger' => [
                    'description' => 'Bank account name',
                    'benefits' => 'accounts reports against ledger',
                    'example' => 'HBL - Habib Bank Limited',
                    'validations' => 'No Validation',
                ],
            ],
            'salary_account' => [
                'parent_account' => [
                    'description' => 'Parent title of particular account head',
                    'example' => 'Default',
                    'validations' => 'No Validation',
                ],
                'account_viewing_group' => [],
                'account_ledger' => [
                    'description' => 'Employee title',
                    'benefits' => 'High lites departments and their sections',
                    'example' => 'i.e. Muhammad Aslam Account Department',
                    'validations' => 'No Validation',
                ],
            ],
            'expense_account' => [
                'Account Viewing Group' => [],
                'account_legder' => [
                    'description' => 'Expense ledger name',
                    'benefits' => 'control and monitoring of expense ledgers',
                    'example' => 'i.e Entertainment',
                ],
            ],
            'group_account' => [

            ],
            'parent_account' => [

            ],
            'fixed_account' => [
                'account_id' => [],
                'account_title' => [],

            ],
            'reporting_group' => [
                'account_viewing_group_name' => [
                    'description' => 'Specific users can view section on their privileges',
                    'benefits' => 'Ensure system data security ',
                    'example' => 'i.e administration,accounts,teller',
                    'validations' => 'No Validation',
                ],

            ],
            'entry_account' => [

                'account_viewing_group' => [],
                'account_legder' => [
                    'description' => 'ledger name',
                    'benefits' => 'control and monitoring of ledgers',
                    'example' => '"i.e Entertainment Repair & Maintenance"',
                ],

            ],
        ],

        'general_registration' => [
            'credit_card_machine' => [
                'machine_title' => [
                    'description' => 'Credit card machine bank account name',
                    'benefits' => 'Easy to understand from whom bank account belong',
                    'example' => 'i.e. Bank Alfalah Account no. 21231313 can be engaged with',
                ],
                'percentage' => [
                    'description' => 'Percentage of bank services expense to would be deducted from total value of transaction',
                    'example' => 'i.e. 2.3%',
                ],
                'merchant_code' => [
                    'description' => 'Machine associated code with bank',
                    'benefits' => 'Easy to identify credit card transaction',
                    'example' => 'i.e. 231233322321',
                ],
                'Bank' => [],
            ],
            'warehouse' => [
                'warehouse_title' => [
                    'description' => 'Products kept in different warehouse.',
                    'benefits' => 'every product can be handle from all warehouses at the tome of sales and purchases.',
                    'example' => 'Like: Product A available 3 units in warehouse 1,
2 units in warehouse 2,
5 units in warehouse 3,
It you have 6 units sales of Product A, could be manage warehouse wise.',
                ],
                'address' => [],
            ],
            'employee' => [
                'account_ledger_access_officials' => [],
                'product_reporting_group' => [],
                'modular_group' => [
                    'description' => 'Working option',
                    'benefits' => 'different working option for different module',
                ],
                'user_type' => [
                    'description' => 'User level',
                    'benefits' => 'User access monitoring',
                ],
                'role' => [
                    'description' => 'Employee working description',
                    'benefits' => 'working classification of employee',
                ],
                'designation' => [
                    'description' => 'Department designation',
                    'benefits' => 'Department wise software module allocation',
                    'example' => 'i.e. Manager Accounts Manager Operation Manager Admin',
                ],
                'name' => [
                    'description' => 'Account title',
                ],
                'father_name' => [
                    'description' => 'Name of Employee Father',
                ],
                'username' => [
                    'description' => 'User login name',
                    'benefits' => 'can login in software with this name',
                    'example' => 'i.e. username',
                ],
                'email' => [],
                'mobile_no.' => [],
                'emergency_contact' => [
                    'description' => 'In case of emergency  immediate contact number of relatives',
                    'benefits' => 'suppose or girl friend number if unmarried',
                    'example' => 'i.e. username',
                ],
                'cnic' => [],
                'family_code' => [
                    'description' => 'Specific Code given by nadra',
                    'benefits' => 'condition of blood relation in same organization',
                ],
                'marital_status' => [
                    'description' => 'Status of Marriage',
                    'benefits' => 'Employee Responsibilities',
                ],
                'city' => [
                    'description' => 'Permanent Residence City',
                ],

            ],

        ],

        'product_registration' => [
            'main_unit' => [
                'title' => [
                    'description' => 'Identify the measurement of product',
                    'benefits' => 'Identify product dealing unit',
                ],
            ],
            'unit' => [
                'main_unit' => [
                    'description' => 'identify the measurement of product',
                    'benefits' => 'Identify product dealing unit',
                ],
                'unit_title' => [
                    'description' => 'to identify the scaling measurement of product',
                    'benefits' => 'Follow SI standards',
                ],
                'scale_size' => [
                    'description' => 'scale size of unit like in Kgs, Number of Unit, Milligram and etc.',
                    'benefits' => 'Packing size of product bundle',
                ],

            ],
            'group' => [
                'group_title' => [
                    'description' => 'This feature basically built to identify the nature of product',
                    'benefits' => 'identify the nature of product',
                ],
                'Tax_%' => [
                    'description' => 'The % of Tax in this field , automatically tax %  should be applied on all mentioned products in the Group.',
                    'benefits' => 'Automation of tax calculation if products are sales tax registered',
                ],
                'retailer_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'whole_seller_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'loyalty_card_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],

            ],
            'category' => [
                'group_title' => [
                    'description' => 'This feature basically built to identify the nature of product',
                    'benefits' => 'identify the nature of product',
                ],
                'category_title' => [
                    'description' => 'A user can mention name according to his requirement',
                    'benefits' => 'Classification of bundle of products',
                ],
                'use_group_Tax/Discount' => [
                    'description' => 'A option available for user either he wants to use the tax and discount rates of Group title or not',
                    'benefits' => 'Ease of selection for automatic tax/discount calculation',
                ],
                'tax_%' => [
                    'description' => 'The % of Tax in this field , automatically tax %  should be applied on all mentioned products in the Group.',
                    'benefits' => 'Automation of tax calculation if products are sales tax registered',
                ],
                'retailer_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'whole_seller_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'loyalty_card_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],

            ],
            'product' => [
                'group_title' => [
                    'description' => 'Grouping of a product',
                    'benefits' => 'identify the nature of product',
                ],
                'category_title' => [
                    'description' => 'Classifications of products',
                    'benefits' => 'Controlling and monitoring products',
                ],
                'product_group' => [
                    'description' => 'A bundle of some products for better controlling and monitoring inventory',
                    'benefits' => 'identify the nature of product',
                ],
                'main_unit' => [
                    'description' => 'identify the measurement of product',
                    'benefits' => 'identify the measurement of product',
                ],
                'unit' => [
                    'description' => 'to identify the scaling measurement of product',
                    'benefits' => 'to identify the scaling measurement of product',
                ],
                'use_category_tax_discount' => [
                    'description' => 'Choose Category Tax% or individual product tax %',
                    'benefits' => 'Ease of selection for automatic tax/discount calculation',
                ],
                'Tax_%' => [
                    'description' => 'The % of Tax in this field , automatically tax %  should be applied on all mentioned products in the Group.',
                    'benefits' => 'Automation of tax calculation if products are sales tax registered',
                ],
                'retailer_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'whole_seller_discount_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'loyalty_card_%' => [
                    'description' => 'Discount % for Customers categorically',
                    'benefits' => 'Categorized customer eligible to get decided discount',
                ],
                'product_barcode' => [
                    'description' => 'A unique identification code for product',
                    'benefits' => 'Fast product invoicing ',
                ],
                'product_title' => [
                    'description' => 'Product Ledger',
                    'benefits' => 'Controlling and monitoring products',
                ],
                'purchase_price' => [
                    'description' => 'Product purchasing price',
                ],
                'bottom_price' => [
                    'description' => 'Minimum value for a product to be sold',
                    'benefits' => 'Controlling invoicing',
                ],
                'sale_price' => [
                    'description' => 'Final value of product to be sold',
                ],
                'expiry' => [
                    'description' => 'Period of product usage',
                    'benefits' => 'To utilize maximum quantity before absolute',
                ],
                'minimum_qty' => [
                    'description' => 'Bottom quantity of a product to reorder',
                ],
                'alert' => [
                    'description' => 'Minimum product quantity alert',
                ],

            ],
            'service' => [
                'service_title' => [
                    'description' => 'Service Ledger',
                ],

            ],


        ],

        'purchase_invoice' => [
            'purchase_invoice' => [
                'account_title' => [],
                'party_reference' => [
                    'description' => 'Info about party',
                ],
                'invoice_type' => [
                    'description' => 'Commercial invoice or tax invoice',

                ],
                'code' => [
                    'description' => 'Product barcode',
                ],
                'Product_title' => [
                    'description' => 'Product barcode',

                ],
                'warehouse' => [
                    'description' => 'receiving destination of particular product',

                ],
                'qty' => [
                    'description' => 'Number of products',
                ],
                'bonus' => [
                    'description' => 'Free number of products',
                ],
                'rate' => [
                    'description' => 'Value of product to be sold',
                ],
                'discount%' => [
                    'description' => 'discount % on per product',
                ],
                'sale_tax_inclusive_exclusive' => [
                    'description' => 'Tax included in gross value or excluded in gross value',
                ],
                'amount' => [
                    'description' => 'Total purchase amount',
                ],
                'round_off_cash_discount' => [
                    'description' => 'round of discount fractions converts paisas into rupee',
                ],
            ],

            'purchase_invoice_return' => [
                'account_title' => [],
                'party_reference' => [
                    'description' => 'Info about party',
                ],
                'invoice_type' => [
                    'description' => 'Commercial invoice or tax invoice',
                ],
                'invoice_number' => [
                    'description' => 'An invoice number is a unique number generated by a business issuing an invoice to a client.',
                ],
                'code' => [
                    'description' => 'Product barcode',
                ],
                'Product_title' => [
                    'description' => 'Product barcode',

                ],
                'warehouse' => [
                    'description' => 'receiving destination of particular product',

                ],
                'qty' => [
                    'description' => 'Number of products',
                ],
                'bonus' => [
                    'description' => 'Free number of products',
                ],
                'rate' => [
                    'description' => 'Value of product to be sold',
                ],
                'discount%' => [
                    'description' => 'discount % on per product',
                ],
                'sale_tax_inclusive_exclusive' => [
                    'description' => 'Tax included in gross value or excluded in gross value',
                ],
                'amount' => [
                    'description' => 'Total purchase amount',
                ],
                'round_off_cash_discount' => [
                    'description' => 'round of discount fractions converts paisas into rupee',
                ],
            ],
        ],

        'invoice' => [

            'sale_man' => [
                'description' => 'A particular employee of the organization is responsible to handle this client transactions.',
                'benefits' => 'Organization make a policy of incentive / commission on sales target,this field is helpful to mentioned sales volume of a particular period.',
                'example' => 'Organization have 5 salesman on different sales counter / terrority,
for example counter 1 sales =150,000.00
counter 2 = 90,000.00
Counter 3= 120,000.00
Counter 4=20,000.00
counter 5= 0
Total sales for the month of June 20=380,000.00',
            ],

            'transaction_type' => [
                'description' => 'Cash/Credit',
                'benefits' => 'Segragation for Cash Flow understanding.Either Sales Turnover is better or a Cash flow position is better for going concern of an organization.',
                'example' => 'Cash Sales=160,000.00
Credit Sales=200,000.00
Total Sales- 360,000.00',
            ],


            'party_reference' => [
                'description' => 'From whom introduce this customer',
                'benefits' => 'Data bank what kind of marketing tool impacts on sales busting.',
            ],

            'invoice_type' => [
                'description' => 'FBR needs proper Tax invoice record along with serial number',
                'benefits' => 'A complete sequal detail available to putt the data in Revenue department Record',
                'example' => 'STI# (Sales Tax Invoice number would be available date wise and serial wise. Sales Tax Payable Ledger will indicate the amount that is submit able for revenue department.',

            ],

            'round_off_discount' => [
                'description' => 'The value in paisas/ panny would be rounded off in rupee by the mathematical method.',
                'benefits' => 'The First currency in the pakistan for physical cash transaction is rupee, Paisas coins are obsoleted.A cash taller/ customer cannot performing the monetory activity in paisas.',
                'example' => 'A product purchase for 58.30 rupees and salod with 3% margin so the sales amount would be equal to Rs=60.05
1) How can customer will pay .05 paisa and if
2) Taller will post entry of Rs=60.05 and physical cash he get was Rs=60
3) at the time of business closing a lum sum amount would be fall in shortage.',

            ],

            'item_discount(Product_Dis/Service_Dis)' => [
                'description' => 'A single product discount % can be feed at the time of sales transaction.',
                'benefits' => 'Customer handling & Competitor comparison ',
                'example' => 'If Product Dis of a particular product is 5% and customer demands 5% teller can take decision at the spot with the decision of sales invoice value.',

            ],

            'product_tax' => [
                'description' => 'Product Gross amount and Net amount treated simultaneously',
                'benefits' => 'Product Value can be maintained easily and discount % depends on product value',
                'example' => 'Rs=100 product value with inclusive tax 17 %.
Normally official calculate it direct that Product value is Rs=83 nad Tax value is Rs=17, Its wrong Calculation
Correct calculation is Product Value is Rs=85.47 and Tax values is Rs=14.53',

            ],

            'Payment(Cash_Received/Credit_Card/Cash_Return)' => [
                'description' => 'Payment Mode',
                'benefits' => 'Either customer wants to pay cash or credit card or with both option.',
                'example' => 'Customer sales invoice is Rs=9000
He wants to pay Rs=1500 cash and Rs=7500 from credit card.software user can perform this action easily',

            ],

            'Cash_Discount' => [
                'description' => 'Invoice Discount at the time of cash receiving.',
                'benefits' => 'Customer obliged',
                'example' => 'Customer sales invoice is Rs=9000
He wants to take Rs=500 more cash discount.software user can perform this action easily with assigned permission rights.',

            ],

            'Total(Total_Item/Sub_Total/Total_Taxes)' => [
                'description' => 'Invoice Bill Amount Value & Number of Products quantity.',

            ],

            'Discount_Type' => [
                'description' => 'Multi Type of Customer Handling with Aggred Sales Contract/ Agreement.',
                'benefits' => 'Retailer/ Whole seller discount mentioned at the time of Customer Registration, A Discount offer could be entertained all kind of customers.',


            ],
            'grand_total' => [
                'description' => 'Invoice value after all type of discounts and taxes',

            ],


            'qty' => [
                'description' => 'Number of products',
            ],
            'bonus' => [
                'description' => 'Free number of products',
            ],
            'rate' => [
                'description' => 'Value of product to be sold',
            ],
            'discount%' => [
                'description' => 'discount % on per product',
            ],
            'sale_tax_inclusive_exclusive' => [
                'description' => 'Tax included in gross value or excluded in gross value',
            ],
            'amount' => [
                'description' => 'Total purchase amount',
            ],
            'round_off_cash_discount' => [
                'description' => 'round of discount fractions converts paisas into rupee',
            ],


        ],

        'cash_voucher' => [
            'cash_receipt_voucher' => [

                'cash_account' => [
                    'description' => 'Main cash account',
                ],

                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],

                'amount' => [
                    'description' => 'Total cash received value(figure)',
                ],

            ],

            'cash_payment_voucher' => [
                'cash_account' => [
                    'description' => 'Main cash account',
                ],
                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'amount' => [
                    'description' => 'Total cash received value(figure)',
                ],

            ],
        ],

        'bank_voucher' => [
            'post_dated_cheque_issue' => [

                'issue_by' => [
                    'description' => 'Bank account number',
                ],

                'issue_to' => [
                    'description' => 'Party/Bank account number / any other ledger',
                ],
                'amount' => [
                    'description' => 'Total cheque value in figures',
                ],

                'cheque_date' => [
                    'description' => 'Actual date of presents in bank
',
                ],

            ],

            'post_dated_cheque_received' => [
                'received_by' => [
                    'description' => 'Bank account number',
                ],
                'received_to' => [
                    'description' => 'Party/Bank account number / any other ledger',
                ],
                'amount' => [
                    'description' => 'Total cheque value in figures',
                ],
                'cheque_date' => [
                    'description' => 'Actual date of presents in bank',
                ],

            ],

            'bank_receipt_voucher' => [
                'Bank' => [
                    'description' => 'Bank account number',
                ],
                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

            'bank_payment_voucher' => [
                'bank' => [
                    'description' => 'Bank account Ledger',
                ],
                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

            'bank_journal_voucher' => [
                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'dr_cr' => [
                    'description' => 'Total cheque value in figures',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],
        ],

        'journal_voucher' => [
            'journal_voucher' => [

                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'dr_cr' => [
                    'description' => 'Total cheque value in figures',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

        ],

        'expense_voucher' => [
            'expense_payment_voucher' => [

                'account' => [
                    'description' => 'All cash and bank accounts',
                ],
                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

        ],

        'salary_voucher' => [
            'advanced_salary' => [

                'advance_paid_account' => [
                    'description' => 'Account from where advance amount has been paid',
                ],
                'advance_employee_account' => [
                    'description' => 'Employee who receive advance from his salary',
                ],

                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

            'generate_salary_slip' => [

                'select_employee' => [
                    'description' => 'Employee who receive advance from his salary',
                ],
                'basic_salary' => [
                    'description' => 'Employee basic salary value(figure)',
                ],

                'salary_based_conditions' => [
                    'description' => 'Employee on daily wages/Employee on monthly bases/Employee on part time professional consultancy',
                ],

                'off_days' => [
                    'description' => 'Paid Leaves',
                ],

                'working_days_in_month' => [
                    'description' => 'Total official days',
                ],

                'working_hours_day' => [
                    'description' => 'Total official hours',
                ],

                'days_hours' => [
                    'description' => 'BasicPackage condition of salary payment',
                ],

                'attended_days' => [
                    'description' => 'Total working  days of an employee',
                ],

                'attended_hours' => [
                    'description' => 'Total working hours present of an employee',
                ],

                'salary_payment_method' => [],

                'salary_month' => [
                    'description' => 'Month name salary is dispersed to',
                ],

                'code' => [
                    'description' => 'Account code if the posting ledger code remembered then put here other wise search via name',
                ],

                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],

                'allowance_deduction' => [
                    'description' => 'Type of amount given/deducted',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

            'salary_payment_voucher' => [

                'account' => [
                    'description' => 'All cash and bank accounts',
                ],
                'account_title' => [
                    'description' => 'Account title if the posting ledger code remembered then put here other wise search via name',
                ],
                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

        ],

        'configurations' => [
            'add_modular_group' => [

                'modular_group_name' => [
                    'description' => 'Name of access control module',
                ],
                'select_module' => [
                    'description' => 'Choose module to be added in new module',
                ],
            ],

            'company_info' => [

                'name' => [
                    'description' => 'Name of company',
                ],


                'fax_number' => [
                    'description' => 'Company fax number',
                ],

                'facebook' => [
                    'description' => 'Company Facebook profile url',
                ],

                'twitter' => [
                    'description' => 'Company Twitter profile url',
                ],

                'youTube' => [
                    'description' => 'Company YouTube Channel url',
                ],

                'google' => [
                    'description' => 'Company Google profile url',
                ],

                'instagram' => [
                    'description' => 'Company Instagram profile url',
                ],

                'address' => [],
                'profile_image' => [
                    'description' => 'Company Profile Image',
                ],

            ],

            'cash_transfer' => [

                'cash_transfer_to' => [
                    'description' => 'Main cash account associated with sub cash account',
                    'benefits' => 'If 2-3 employee holds physical cash of organization could be traceable',
                    'example' => 'i.e Teller 1 transfers cash 50K to Main cash department',

                ],

                'amount' => [
                    'description' => 'Cash amount to transferred',
                    'benefits' => 'Easy handling of physical cash',
                    'example' => 'i.e. 50000',
                ],

            ],

        ],

        'new' => [
            'product_clubbing' => [

                'parent_code' => [
                    'description' => 'Product ledger code',
                ],
                'parent_name' => [
                    'description' => 'Product edger',
                    'benefits' => 'Controlling and monitoring products',

                ],

                'product_code' => [
                    'description' => 'A unique identification code for product',
                    'benefits' => 'Fast product invoicing ',
                    'example' => 'i.e Teller 1 transfers cash 50K to Main cash department',
                ],
            ],

            'product_packages' => [

                'package_name' => [
                    'description' => 'A bundle of multi products linked in a single barcode for sales invoice.',
                    'benefits' => 'In a Single click associated products with main products could be sales out.',
                    'example' => 'Like: in a grocery store 5 kg suger on a lower rate would be available with other products sales.
In a book store all books of class 1 can be bundle in course 1.
etc,etc',
                ],

                'auto_add' => [
                    'description' => 'Option to add product detail in invoice',
                ],

                'Code' => [
                    'description' => 'Product barcode number',
                ],

                'product_name' => [
                    'description' => 'Product Ledger',
                ],

                'qty' => [
                    'description' => 'Number of products quantity',
                ],

                'rate' => [
                    'description' => 'Value of product to be sold',
                ],

                'amount' => [
                    'description' => 'Total value in figures',
                ],

            ],

            'product_recipe' => [

                'recipe_name' => [],

                'code' => [
                    'description' => 'Product barcode number',
                ],

                'product' => [
                    'description' => 'Product ledger',
                ],

                'qty' => [
                    'description' => 'Number of products quantity',
                ],

                'auto_add' => [],

                'Code' => [
                    'Product barcode number',
                ],

                'product_name' => [],


            ],

            'manufacture_product' => [

                'recipe' => [],

                'account' => [],

                'code' => [
                    'description' => 'Product barcode number',
                ],

                'product' => [],

                'qty' => [
                    'description' => 'Number of products quantity',
                ],

                'complete_date' => [],
                'auto_add' => [],
                'product_name' => [],
                'account_name' => [],
                'amount' => [],


            ],

            'sale_return' => [

                'account_name' => [],

                'packages' => [],

                'party_reference' => [
                    'description' => 'Info about party',
                ],
                'invoice_type' => [
                    'description' => 'Commercial invoice or tax invoice',
                ],

                'discount_type' => [],
                'invoice_number' => [],
                'for_desktop' => [],

                'code' => [
                    'description' => 'Product barcode number',
                ],
                'product_name' => [
                    'description' => 'Product registered name',
                ],

                'qty' => [
                    'description' => 'Number of products quantity',
                ],
                'bonus' => [
                    'description' => 'Free number of products',
                ],

                'rate' => [
                    'description' => 'Value of product to be sold',
                ],

                'discount%' => [
                    'description' => 'discount % on per product',
                ],

                '(Sale Tax, Inclusive/Exclusive)' => [],
                'amount' => [],
                'round_off_cash_discount' => [],
            ],

            'Asset_Registration' => [

                'Asset_Register_#' => [
                    'description' => 'Manual Asset Register Number posting.',
                    'benefits' => 'Asset detail could be collected from Manual register and application record.',
                    'example' => 'An Asset have a manual code designed from organization normally mark on Asset, that identity can be called here.',
                ],
                'Importer/Supplier_Detail' => [
                    'description' => 'Vendor detail, either its purchased locally or imports from abroad.
Vendor detail feeds here.',
                    'benefits' => 'In case of repetition of Asset purchase a data will guide same product purchased from whom and from where in favour to make decision on fruitfully grounds.',
                    'example' => 'An Asset imports from aboard but after sal;es services is not available in that geographical area.
But a local vendor arranges same asset with after sales service facility.
Organization can take decision on real grounds.',
                ],

                'Asset_Guarantee_Period' => [
                    'description' => 'Asset subsidiary part guarantee period.',
                    'benefits' => 'If required maintenance can be monitor either is it free till period or not.',
                    'example' => 'Air Conditioner compressor gas leakage with in a season so it should be free maintenance in next season,if compressor in guarantee with 3 years.',
                ],
                'Asset_Specification' => [
                    'description' => 'Technical Features in operating.',
                    'benefits' => 'What kind of situation we use this Asset.',
                    'example' => 'Like Air Conditioner inventor have a specification of Heat n Cool or only coll.',
                ],
                'Asset_Capacity' => [
                    'description' => 'Technical Feature in Output.',
                    'benefits' => 'Either this Asset is sufficient in the particular criteria.',
                    'example' => 'Air Conditioner 1.5 Ton is sufficient for 14x14 room in Ground Floor.
But at 1sty floor room size should be 14x12 to take efficiency at Ground floor.',
                ],
                'Asset_Size' => [
                    'description' => 'Width and Length and Weight.',
                    'benefits' => 'Allocation space where Assets operates.',
                    'example' => '10 Ton Machinery can be installed on ground floor but if organization needs to installed on 1st floor , Organization assured the secured measurement of Safety.',
                ],
                'Depreciation_Method' => [
                    'description' => 'Two renowned Depreciation method facility available in the software.
1) Straight Line
2) Reducing Balancing Method
',
                    'benefits' => 'To be calculate depreciation of a particular asset on organization owns decision.',
                    'example' => 'Straight Line match Depreciation iis 5000/- would be same till asset dispose off
Reducing Balancing Method , depreciation would be vary from last year like 1st 5000. next year 4500',
                ],
                'Depreciation/Amortization' => [
                    'description' => 'Land Will be amortized every year normally.',
                    'benefits' => 'provide option to revaluation of assets at the end of period.',
                ],
                'Depreciation_Parent_Account' => [
                    'description' => 'Depreciation Expense Parent account will change on the basis of asset Nature.',
                    'benefits' => 'Depreciation can be account for in different expenses head.',
                    'example' => 'Machinery  depreciation would be a part of CGS.Vehicle depreciation would be a part of Selling Exp.Computer and laptops would be a part of Operation expenses.',
                ],

                'Depreciation_Chile_Account' => [
                    'description' => 'Specification of Depreciation.',
                    'benefits' => 'Expenses classification variant wise.',
                    'example' => 'Like in CGS Machinery Depreciation is a parent account.Packing Machinery & Processing Machinery are two variants.',
                ],
                'Asset_Purchase_Price' => [
                    'description' => 'What type of expenses booked in asset cost.',
                    'benefits' => 'Either On Asset Purchase Price or with etc',
                    'example' => 'Like a Machinery Cost is Rs=100000 but the installation cost and carriage cost would be treated in Capital Expense or a Revenue Expense',
                ],
                'Residule_Value' => [
                    'description' => 'What Value would be at the time od Asset dispose off',
                    'benefits' => 'This value will less from Asset Price in favour to account for depreciation expense',
                    'example' => 'An Air Conditioner purchase at Rs=60000 for 5 Year but after 5 year this asset can be sold of Rs=8000',
                ],
                'Useful_Life_In_Year(s)' => [
                    'description' => 'Period of Asset utilization',
                    'benefits' => 'How long organization take utilized the asset.',
                    'example' => 'An Air conditioner can be performs 3 to 5 years properly.',
                ],

                'Execute_Depreciation' => [
                    'description' => 'Depreciation expense books on daily/ monthly or yearly basis.',
                    'benefits' => 'Depreciation expense depends on sales or production directly.',
                ],
                'Depreciation%Per_Year' => [
                    'description' => 'Depreciation Expenses % yearly.',
                ],

                'Posting_Auto/Manual' => [
                    'description' => 'Depreciation entry Direct posting at the period end or manual feeding by any authorized official.',
                ],

                'Acquisition_Date' => [
                    'description' => 'Date of Asset kept in organization if same day not in working.',
                ],


            ],

            'Capital_Registration' => [


                'Relation_With_Director' => [
                    'description' => 'Who offers to put investment in particular organization.',
                ],
                'Nature' => [
                    'description' => 'Director Rights Either is he investor or have right to check books of accounts.',
                ],


            ],

            'Product_Reporting_Group' => [

                'Product_Handling_Group_Title' => [
                    'description' => 'A Particular employee can post or view authorized Product Ledger and Posting.',
                    'benefits' => 'Departmental staff could not be view other department product ledger.',
                    'example' => 'Production department will handle raw stock,semi finished and finished goods stock according to Production Schedule. But Sales department can vier only the information of Finished Goods Stock.',
                ],


            ],

        ],

    ],

];































