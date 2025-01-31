<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DayEndController;
use App\Http\Controllers\SaveImageController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelDataImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        return $row;
//        $employee = new User();
//        $user = Auth::user();
//
//        $get_day_end = new DayEndController();
//        $day_end = $get_day_end->day_end();
//
//        $controller = new Controller();
//        $brwsr_rslt = $controller->getBrwsrInfo();
//        $ip_rslt = $controller->getIp();
//
//
//        $employee->user_department_id = $row['user_department_id'];
//        $employee->user_level = $row['user_type'];
//        $employee->user_role_id = $row['role'];
//        $employee->user_designation = ucwords( $row['designation'] );
//        $employee->user_name = ucwords( $row['name'] );
//        $employee->user_father_name = ucwords( $row['father_name'] );
//        $employee->user_mobile = $row['mobile'];
//
//        $employee->user_createdby = $user->user_id;
//        $employee->user_datetime = Carbon::now()->toDateTimeString();
//        $employee->user_day_end_id = $day_end->de_id;
//        $employee->user_day_end_date = $day_end->de_datetime;
//        $employee->user_brwsr_info = $brwsr_rslt;
//        $employee->user_ip_adrs = $ip_rslt;
//        $employee->user_update_datetime = Carbon::now()->toDateTimeString();
//
//        if ( !empty( $row['parent_head'] ) && !empty( $row['basic_salary'] ) && !empty( $row['salary_period
//'] ) && !empty( $row['hour_per_day'] ) && !empty( $row['holidays_id'] ) ) {
//            $employee->user_salary_person = 1;
//        }
//
//        $employee->save();
//
//
//        $employee_id = $employee->user_id;
//        $employee_name = $employee->user_name;
//        $employee->user_employee_code = $this->generate_employee_code($employee_id, $employee_name);
//        $employee->save();
//
//
//        return new User([
//
//        ]);

    }
}
