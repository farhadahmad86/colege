<?php

namespace App\Http\Middleware\CheckRole;

use App\InfoBox;
use App\InfoBoxChild;
use App\Models\EmployeeModel;
use App\Models\ModularConfigDefinitionModel;
use App\Models\SystemConfigModel;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Route;
use Session;

class CheckAccountantRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        if ($request->user()->user_role_id == config('global_variables.teller_account_id')) {
//            return redirect()->route('teller/dashboard');
//        }

        if ($request->user()->user_login_status == 'DISABLE') {
            return redirect()->route('logout');
        }

        $route1 = Route::current()->getName();

        $info_bx = InfoBox::where('ib_url', $route1)->first();
        if (isset($info_bx) && !empty($info_bx)):
            $info_bx_child = InfoBoxChild::where('ib_id', $info_bx->ib_id)->get();
        else:
            $info_bx_child = '';
        endif;

        Session::put('info_bx', $info_bx);
        Session::put('info_bx_child', $info_bx_child);

        if ($request->user()->user_level != 100) {
            $route = Route::current()->getName();

            $third_level_modules = Session::get('third_level_modules');

            if ($request->ajax()) {
                return $next($request);
            }


//            if ($route != 'index' && $route != 'home') {
//
//                $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//
////dd(!in_array($check_module, $third_level_modules),$third_level_modules,$check_module);
//                if($check_module) {
//                    if (!in_array($check_module, $third_level_modules)) {
//
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                }
//
//
//            }


//            switch ($route) {
//                case 'add_region':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_area':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_sector':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'receivables_account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'payables_account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'expense_account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'first_level_chart_of_account':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_second_level_chart_of_account':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_third_level_chart_of_account':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'default_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_account_group':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_registration':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cash_transfer':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_credit_card_machine':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_warehouse':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_employee':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_main_unit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_unit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_group':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_category':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_product':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_services':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_transfer_product_stock':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_loss':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_recover':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_opening_balance':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'parties_opening_balance':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_invoice_on_net':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_return_full_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_return_partial_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_return_without_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_invoice_on_net':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'services_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'services_invoice_on_cash':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_return_full_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_return_partial_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_return_without_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'income_tax_purchase_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_tax_purchase_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'income_tax_sale_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_tax_sale_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'service_tax_invoice':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'warehouse_stock':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'transfer_product_stock_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cash_receipt_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cash_payment_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'online_payment_receive':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'online_payment_paid':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_post_dated_cheque_issue':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_post_dated_cheque_received':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_receipt_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_payment_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'journal_voucher_bank':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'journal_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'expense_payment_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_advance_salary':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_slip_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_payment_voucher':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'region_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'area_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sector_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_receivable_payable_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'chart_of_account':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'default_account_list_view':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_group_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'credit_card_machine_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'warehouse_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'employee_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'main_unit_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'unit_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'group_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'category_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'purchase_return_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'income_tax_purchase_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_tax_purchase_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_return_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'income_tax_sale_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_tax_sale_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'service_tax_sale_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'party_wise_opening_closing':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_receivable_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'account_payable_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'aging_report_party_wise_purchase':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'aging_report_party_wise_sale':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'aging_report_product_wise':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_person_wise_profit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'client_wise_profit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'supplier_wise_profit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_wise_profit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'sale_invoice_wise_profit':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_ledger_stock_wise':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_ledger_amount_wise':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_last_purchase_rate_verification':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_last_sale_rate_verification':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'add_modular_group':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'modular_group_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cashbook':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'start_day_end':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'trial_balance':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'income_statement':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'balance_sheet':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'expense_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'second_level_chart_of_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'third_level_chart_of_account_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'pending_cash_transfer_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'approve_cash_transfer_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'reject_cash_transfer_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'pending_cash_receive_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'approve_cash_receive_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'reject_cash_receive_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'services_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_loss_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'product_recover_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'services_invoice_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cash_receipt_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'cash_payment_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_receipt_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'bank_payment_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'post_dated_cheque_issue_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'approve_post_dated_cheque_issue_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'reject_post_dated_cheque_issue_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'post_dated_cheque_received_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'approve_post_dated_cheque_received_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'reject_post_dated_cheque_received_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'journal_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'expense_payment_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'advance_salary_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_slip_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'salary_payment_voucher_list':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                case 'company_info':
//                    $check_module = ModularConfigDefinitionModel::where('mcd_web_route', '=', $route)->pluck('mcd_code')->first();
//                    if (!in_array($check_module, $third_level_modules)) {
//                        return redirect('index')->with('fail', 'Your are not Authorized For This Page');
//                    }
//                    break;
//                default:
//                    return $next($request);
//                    break;
//            }
        }


        // system config code start

        $chk_sstm_cnfg = SystemConfigModel::pluck('sc_all_done')->first();
        $sbmit_url_wrd = 'submit_';
        $rmve_sbmit_url_wrd = $get_post_url_name = $sbmit_url = '';


//        if(isset($chk_sstm_cnfg) && $chk_sstm_cnfg === 0) {

//            if (strpos($route1, $sbmit_url_wrd) !== false) {
//                $rmve_sbmit_url_wrd = str_replace($sbmit_url_wrd, '', $route1);
//                $get_post_url_name = ModularConfigDefinitionModel::where('mcd_web_route', 'like', '%' . $rmve_sbmit_url_wrd . '%')->first();
//            }
//            if (isset($get_post_url_name) && !empty($get_post_url_name)) {
//                $sbmit_url = $get_post_url_name->mcd_web_route;
//            }


//            $menu_sstm_cnfg = ModularConfigDefinitionModel::where('mcd_before_config', '1')->where('mcd_web_route', '=', $route1)->orwhere('mcd_web_route', '=', $sbmit_url)->first();

//            if ( ($request->isMethod('POST')) || ($request->isMethod('get') && strpos($route1, 'list') !== false) ) {
//                if (!empty($menu_sstm_cnfg) && $menu_sstm_cnfg->mcd_before_config === 1 && $menu_sstm_cnfg->mcd_system_config_file === null) {
//                    $this->modular_sstm_cnfg_file($menu_sstm_cnfg->mcd_id);
//                }
//                elseif( $route1 === 'submit_update_profile'){
//                    $sstm_cnfg_tbl = SystemConfigModel::find(1);
//                    $sstm_cnfg_tbl->sc_profile_update = 1;
//                    $sstm_cnfg_tbl->update();
//                }
//                elseif( $route1 === 'update_company_info'){
//                    $sstm_cnfg_tbl = SystemConfigModel::find(1);
//                    $sstm_cnfg_tbl->sc_company_info_update = 1;
//                    $sstm_cnfg_tbl->update();
//                }
//                elseif( $route1 === 'update_product_opening_stock'){
//                    $sstm_cnfg_tbl = SystemConfigModel::find(1);
//                    $sstm_cnfg_tbl->sc_products_added = 1;
//                    $sstm_cnfg_tbl->update();
//                }
//                elseif( $route1 === 'submit_capital_registration'){
//                    $sstm_cnfg_tbl = SystemConfigModel::find(1);
//                    $sstm_cnfg_tbl->sc_products_added = 1;
//                    $sstm_cnfg_tbl->update();
//                }
//                elseif( $route1 === 'update_account_opening_balance'){
////                    $sstm_cnfg_tbl = SystemConfigModel::find(1);
////                    $sstm_cnfg_tbl->sc_opening_trial_complete = 1;
////                    $sstm_cnfg_tbl->sc_all_done = 1;
////                    $sstm_cnfg_tbl->update();
//                }
//            }

//        }



        // system config code end


        return $next($request);
    }

    private function modular_sstm_cnfg_file($id){
        $menu_sstm_cnfg_update = ModularConfigDefinitionModel::find($id);
        $menu_sstm_cnfg_update->mcd_system_config_file = 1;
        $menu_sstm_cnfg_update->update();
    }
}
