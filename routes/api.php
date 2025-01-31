<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamApiController;
use App\Http\Controllers\Api\FeeApiController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\Api\SalaryReportController;
use App\Http\Controllers\Api\StudentAttendanceApiController;
use App\Http\Controllers\Api\TeacherAttendanceApiController;
use App\Http\Controllers\College\CronJobController;
use App\Http\Controllers\College\FeeVoucherController;
use App\Http\Controllers\PackagesController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/***************************************************************************/
/******************************** Cron JOb Income Entry Routes ******************************/
/***************************************************************************/
Route::get('/every_month_auto_income_entry/{id}', [CronJobController::class, 'every_month_auto_income_entry'])->name('every_month_auto_income_entry');

Route::get('/ledger/{account_id}', [AuthController::class, 'ledger'])->name('ledger');


Route::get('/user_login', [AuthController::class, 'staff_login'])->name('user_login');
Route::post('/user_login', [AuthController::class, 'staff_login'])->name('user_login');

Route::get('/student_login', [AuthController::class, 'student_login'])->name('student_login');
Route::post('/student_login', [AuthController::class, 'student_login'])->name('student_login');


Route::get('/post_voucher', [FeeApiController::class, 'post_voucher'])->name('post_voucher');
Route::post('/post_voucher', [FeeApiController::class, 'post_voucher'])->name('post_voucher');

Route::get('/bill_inquiry', [FeeApiController::class, 'bill_inquiry'])->name('bill_inquiry');
Route::post('/bill_inquiry', [FeeApiController::class, 'bill_inquiry'])->name('bill_inquiry');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/student_result/{type?}', [AuthController::class, 'student_result'])->name('student_result');
    Route::get('/student_result_dev/{type?}', [AuthController::class, 'student_result_dev'])->name('student_result_dev');

    Route::post('/update_device_token', [AuthController::class, 'update_device_token'])->name('update_device_token');
    Route::get('/notification_list', [AuthController::class, 'notification_list'])->name('notification_list');
//Route::post('/student_result', [AuthController::class,'student_result'])->name('student_result');


    Route::get('/upload_image', [AuthController::class, 'upload_image'])->name('upload_image');
    Route::get('/attendance_calculation', [AuthController::class, 'attendance_calculation'])->name('attendance_calculation');
    Route::get('/month_attendance', [AuthController::class, 'month_attendance'])->name('month_attendance');
    Route::get('/course_outline', [AuthController::class, 'course_outline'])->name('course_outline');
    Route::get('/subjects', [AuthController::class, 'subjects'])->name('subjects');
    Route::get('/comp_info', [AuthController::class, 'comp_info'])->name('comp_info');
    Route::get('/get_paid_voucher', [FeeVoucherController::class, 'get_paid_voucher'])->name('get_paid_voucher');

    Route::get('/get_lecture', [LectureController::class, 'get_lecture'])->name('get_lecture');



//Route::get('/auto_submit_db_backup', 'DatabaseBackUpController@auto_submit_db_backup')->name('auto_submit_db_backup');
//farhad route
///Burhan
    Route::get('/exams', [ExamApiController::class, 'teacherExam'])->name('exams');
    Route::get('/coordinator_sections', [StudentAttendanceApiController::class, 'coordinator_sections'])->name('coordinator_sections');
    Route::get('/section_student', [StudentAttendanceApiController::class, 'section_student'])->name('section_student');
    Route::get('/teacher_class', [ExamApiController::class, 'teacher_classes'])->name('teacher_class');
    Route::get('/coordinator_classes', [StudentAttendanceApiController::class, 'coordinator_classes'])->name('coordinator_classes');
    Route::post('/store_attendance', [StudentAttendanceApiController::class, 'store'])->name('store_attendance');
    ///Burhan
    Route::get('/teacherClasses', [StudentAttendanceApiController::class, 'teacherClasses'])->name('teacherClasses');
    Route::get('/classExams', [StudentAttendanceApiController::class, 'classExams'])->name('classExams');
    Route::get('/classSubjects', [StudentAttendanceApiController::class, 'classSubjects'])->name('classSubjects');
    Route::get('/examMarks', [StudentAttendanceApiController::class, 'examMarks'])->name('examMarks');
    //farhad
    Route::get('/time_table', [AuthController::class, 'time_table'])->name('time_table');
    Route::get('/get_teacher_timeWise', [TeacherAttendanceApiController::class, 'get_current_teacher'])->name('get_current_teacher');
    Route::get('/get_teachers_data_timeWise', [TeacherAttendanceApiController::class, 'get_teachers_data_timeWise'])->name('get_teachers_data_timeWise');
    Route::post('/submit_teacher_attendance_timeWise', [TeacherAttendanceApiController::class, 'store_time'])->name('submit_lecturer_attendance_time');
    Route::post('/lecturer_attendance_list', [\App\Http\Controllers\College\MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');
    Route::get('/lecturer_attendance_list/{array?}/{str?}', [\App\Http\Controllers\College\MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');
    Route::get('/time_table_teacherWise', [TeacherAttendanceApiController::class, 'schedule'])->name('schedule');
    Route::get('/attendance_list_user', [TeacherAttendanceApiController::class, 'attendance'])->name('attendance');

    Route::get('/salary_voucher', [SalaryReportController::class, 'salary_voucher'])->name('salary_voucher');
    Route::get('/paid_salary_voucher', [SalaryReportController::class, 'paid_salary_voucher'])->name('paid_salary_voucher');

    Route::get('/branch_session/{id}', [PackagesController::class, 'branch_session'])->name('branch.branch_session');

});
    Route::get('/get_all_user', [TeacherAttendanceApiController::class, 'get_user'])->name('get_all_user');
    Route::post('/post_biometric', [TeacherAttendanceApiController::class, 'get_biometric'])->name('post_biometric');
    Route::post('/post_attendance', [TeacherAttendanceApiController::class, 'post_attendance'])->name('post_attendance');
