<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GenerateSalarySlipItemsModel;
use App\Models\SalaryPaymentItemsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SalaryReportController extends Controller
{
    public function salary_voucher()
    {
        $user = Auth::user();
        $salary_vouchers = GenerateSalarySlipItemsModel::where('gssi_employee_id', $user->user_id)->orderBy('gssi_id','desc')->get();
        return response()->json(['data' => $salary_vouchers], 200);
    }

    public function paid_salary_voucher()
    {
        $user = Auth::user();
        $paid_salary_voucher = SalaryPaymentItemsModel::where('spi_employee_id', $user->user_id)->orderBy('spi_id','desc')->get();
        return response()->json(['data' => $paid_salary_voucher], 200);
    }
}
