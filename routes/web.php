<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Testing
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AdvanceFeeVoucherController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\College\AnnouncementController;
use App\Http\Controllers\College\AssignCoordinatorController;
use App\Http\Controllers\College\BranchController;
use App\Http\Controllers\College\ChangeStudentStatusReasonController;
use App\Http\Controllers\College\ClassesController;
use App\Http\Controllers\College\CollegeController;
use App\Http\Controllers\College\CollegeReportController;
use App\Http\Controllers\College\ComponentController;
use App\Http\Controllers\College\CourseOutlineController;
use App\Http\Controllers\College\DegreeController;
use App\Http\Controllers\College\DocumentUploadController;
use App\Http\Controllers\College\ExamController;
use App\Http\Controllers\College\FeeVoucherController;
use App\Http\Controllers\College\GroupController;
use App\Http\Controllers\College\HrPlanController;
use App\Http\Controllers\College\InquiryController;
use App\Http\Controllers\College\MarkTeacherAttendanceController;
use App\Http\Controllers\College\MarkExamController;
use App\Http\Controllers\College\PaidFeeVoucherController;
use App\Http\Controllers\College\SchoolController;
use App\Http\Controllers\College\SemesterController;
use App\Http\Controllers\College\SessionController;
use App\Http\Controllers\College\StudentBookedPackageController;
use App\Http\Controllers\College\StudentController;
use App\Http\Controllers\College\StudentPromotionController;
use App\Http\Controllers\College\StudentTransferController;
use App\Http\Controllers\College\SubjectController;
use App\Http\Controllers\College\ProgramController;
use App\Http\Controllers\College\SectionController;
use App\Http\Controllers\College\StudentAttendanceController;
use App\Http\Controllers\College\SubjectAssignController;
use App\Http\Controllers\College\TeacherLoadController;
use App\Http\Controllers\College\TimeTableController;
use App\Http\Controllers\College\TransportRouteController;
use App\Http\Controllers\College\UploadLectureController;
use App\Http\Controllers\College\WeightageController;
use App\Http\Controllers\ReportConfigController;
use App\InfoBox;
use App\InfoBoxChild;
use App\Models\ModularConfigDefinitionModel;
use App\Models\ProductModel;
use App\Models\StudentAttendanceModel;

Route::get('/get_apk', function (\Illuminate\Http\Request $request) {
    return view('downloadApk.download_app');
})->name('get_apk');
Route::middleware(['auth', 'check.login'])->group(function () {
    Route::get('/add_role_permission', 'RolesPermissionController@add_role_permission')->name('add_role_permission');

    Route::post('/submit_role_permission', 'RolesPermissionController@submit_role_permission')->name('submit_role_permission');

    Route::get('/role_permission_list', 'RolesPermissionController@role_permission_list')->name('role_permission_list');

    Route::post('/role_permission_list', 'RolesPermissionController@role_permission_list')->name('role_permission_list');

    Route::post('/edit_role_permission', 'RolesPermissionController@edit_role_permission')->name('edit_role_permission');

    Route::post('/update_role_permission', 'RolesPermissionController@update_role_permission')->name('update_role_permission');

    Route::get('/edit_role_permission', 'RolesPermissionController@role_permission_list')->name('edit_role_permission');

    Route::post('/delete_role_permission', 'RolesPermissionController@delete_role_permission')->name('delete_role_permission');

    Route::get('/user_expiry_alert', 'PackagesController@user_expiry_alert')->name('user_expiry_alert');

    Route::get('/product_clubbing_test', function (\Illuminate\Http\Request $request) {
        $status = 0;
        $edit_products = [];
        $pro_code = $request->product_code;

        if (isset($pro_code) && !empty($pro_code)) {
            $edit_product = ProductModel::where('pro_p_code', $pro_code)
                ->pluck('pro_clubbing_codes')
                ->first();
            $edit_products = explode(',', $edit_product);
            $status = 1;
        }

        $user = Auth::loginUsingId(1);
        $query = ProductModel::query();
        if ($user->user_level != 100) {
            $query->where('pro_reporting_group_id', $user->user_product_reporting_group_ids);
        }

        $products = $query
            ->where('pro_type', config('global_variables.parent_product_type'))
            ->where('pro_delete_status', '!=', 1)
            ->where('pro_disabled', '!=', 1)
            ->where('pro_status', config('global_variables.product_active_status'))
            ->orderby('pro_title', 'ASC')
            ->get();

        $product_code = '';
        $product_name = '';
        foreach ($products as $product) {
            $selected = $pro_code == $product->pro_code ? 'selected' : '';
            $product_code .= "<option value='$product->pro_p_code' $selected>$product->pro_p_code</option>";
            $product_name .= "<option value='$product->pro_p_code' $selected>$product->pro_title</option>";
        }

        return view('_ab.testing.product_clubbing', compact('product_code', 'product_name', 'edit_products', 'status'));
    })->name('product_clubbing_test');
});
/***************************************************************************/
/***************************** Login Routes ******************************/
/***************************************************************************/

Route::get('/', 'LoginController@login_form')->name('login');

Route::get('/login', 'LoginController@login_form')->name('login');

//login
Route::post('/signin', 'LoginController@login')->name('signin');

Route::get('/signin', 'LogoutController@logout')->name('signin');

//logout
Route::get('/logout', 'LogoutController@logout')->name('logout');

//password reset
Route::get('/password_reset', 'LoginController@password_reset')->name('password_reset');

//password_reset_email
Route::post('/password_reset_email', 'LoginController@password_reset_email')->name('password_reset_email');

//password_reset
Route::get('/change_forgotten_password/{token}', 'LoginController@change_forgotten_password')->name('change_forgotten_password');

//update_forget_password
Route::post('/update_forget_password', 'LoginController@update_forget_password')->name('update_forget_password');

Route::get('/pso_form', function () {
    return view('pso_form/pso_form');
});

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth', 'check.login'])->group(function () {
    Route::get('/sale_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SaleInvoiceController@sale_items_view_details_pdf_SH')->name('sale_items_view_details_pdf_sh');
    Route::get('/sale_items_view_details/view/{id}', 'SaleInvoiceController@sale_items_view_details_SH')->name('sale_items_view_details_sh');

    Route::get('/sale_order_items_view_details/view/pdf/{id}/{array?}/{str?}', 'SaleOrderController@sale_order_items_view_details_pdf_SH')->name('sale_order_items_view_details_pdf_sh');
    Route::get('/sale_order_items_view_details/view/{id}', 'SaleOrderController@sale_order_items_view_details_SH')->name('sale_order_items_view_details_sh');

    Route::get('/sale_tax_sale_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleInvoiceController@sale_sale_tax_items_view_details_pdf_SH')->name('sale_sale_tax_items_view_details_pdf_SH');

    Route::get('/sale_tax_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleReturnInvoiceController@sale_return_saletax_items_view_details_pdf_SH')->name('sale_return_saletax_items_view_details_pdf_SH');

    Route::get('/trade_sale_tax_sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'TradeInvoices\TradeSaleTaxReturnInvoiceController@trade_sale_return_saletax_items_view_details_pdf_SH')->name('trade_sale_return_saletax_items_view_details_pdf_SH');

    Route::get('/sale_return_invoice_list/view/pdf/{id}/{array?}/{str?}', 'SaleReturnInvoiceController@sale_return_items_view_details_pdf_SH')->name('sale_return_items_view_details_pdf_SH');

    /***************************************************************************/
    /********************* College Routes Start **********************/
    /***************************************************************************/

    /***************************************************************************/
    /********************* Branch Routes **********************/
    /***************************************************************************/
    Route::get('add_branch', [BranchController::class, 'create'])->name('add_branch');
    Route::post('store_branch', [BranchController::class, 'store'])->name('store_branch');
    // Route::get('/', [BranchController::class, 'index'])->name('branch.index');
    //    Route::get('/pdf', [BranchController::class, 'branchPdf'])->name('branch.pdf');
    // Route::get('edit/{branch}', [BranchController::class, 'edit'])->name('branch.edit');
    // Route::put('update/{branch}', [BranchController::class, 'update'])->name('branch.update');
    Route::get('/branch_list', [BranchController::class, 'index'])->name('branch_list');

    Route::post('/branch_list', [BranchController::class, 'index'])->name('branch_list');

    Route::post('/edit_branch', [BranchController::class, 'edit'])->name('edit_branch');

    Route::post('/update_branch', [BranchController::class, 'update'])->name('update_branch');

    Route::get('/edit_branch', [BranchController::class, 'index'])->name('edit_branch');

    Route::post('/delete_branch', [BranchController::class, 'delete_branch'])->name('delete_branch');

    /***************************************************************************/
    /********************* Degree Routes **********************/
    /***************************************************************************/

    Route::get('add_degree', [DegreeController::class, 'create'])->name('add_degree');
    Route::post('store_degree', [DegreeController::class, 'store'])->name('store_degree');
    // Route::get('/', [DegreeController::class, 'index'])->name('degree.index');
    // Route::get('edit/{degree}', [DegreeController::class, 'edit'])->name('degree.edit');
    // Route::put('update/{degree}', [DegreeController::class, 'update'])->name('degree.update');

    Route::get('degree_list', [DegreeController::class, 'index'])->name('degree_list');

    Route::post('degree_list', [DegreeController::class, 'index'])->name('degree_list');

    Route::post('/edit_degree', [DegreeController::class, 'edit'])->name('edit_degree');

    Route::get('/edit_degree', [DegreeController::class, 'index'])->name('edit_degree');

    Route::post('/update_degree', [DegreeController::class, 'update'])->name('update_degree');

    Route::post('/delete_degree', [DegreeController::class, 'delete_degree'])->name('delete_degree');

    /***************************************************************************/
    /********************* Session Routes **********************/
    /***************************************************************************/
    Route::get('add_session', [SessionController::class, 'create'])->name('add_session');
    Route::post('store_session', [SessionController::class, 'store'])->name('store_session');
    // Route::get('/', [SessionController::class, 'index'])->name('session.index');
    // Route::get('edit/{session}', [SessionController::class, 'edit'])->name('session.edit');
    // Route::put('update/{session}', [SessionController::class, 'update'])->name('session.update');

    Route::get('session_list', [SessionController::class, 'index'])->name('session_list');

    Route::post('session_list', [SessionController::class, 'index'])->name('session_list');

    Route::post('/edit_session', [SessionController::class, 'edit'])->name('edit_session');

    Route::post('/update_session', [SessionController::class, 'update'])->name('update_session');

    Route::get('/edit_session', [SessionController::class, 'index'])->name('edit_session');

    Route::post('/delete_session', [SessionController::class, 'delete_session'])->name('delete_session');

    /***************************************************************************/
    /********************* Semester Routes **********************/
    /***************************************************************************/
    Route::get('add_semester', [SemesterController::class, 'create'])->name('add_semester');
    Route::post('store_semester', [SemesterController::class, 'store'])->name('store_semester');
    //    Route::get('/', [SemesterController::class, 'index'])->name('semester.index');
    // Route::get('edit/{semester}', [SemesterController::class, 'edit'])->name('semester.edit');
    // Route::put('update/{semester}', [SemesterController::class, 'update'])->name('semester.update');

    Route::get('semester_list', [SemesterController::class, 'index'])->name('semester_list');

    Route::post('semester_list', [SemesterController::class, 'index'])->name('semester_list');

    Route::post('/edit_semester', [SemesterController::class, 'edit'])->name('edit_semester');

    Route::post('/update_semester', [SemesterController::class, 'update'])->name('update_semester');

    Route::get('/edit_semester', [SemesterController::class, 'index'])->name('edit_semester');

    Route::post('/delete_semester', [SemesterController::class, 'delete_semester'])->name('delete_semester');
    /***************************************************************************/
    /********************* Inquiry Routes **********************/
    /***************************************************************************/

    Route::get('add_inquiry', [InquiryController::class, 'create'])->name('add_inquiry');
    Route::post('store_inquiry', [InquiryController::class, 'store'])->name('store_inquiry');
    // Route::get('/', [InquiryController::class, 'index'])->name('inquiry.index');
    // Route::get('edit/{inquiry}', [InquiryController::class, 'edit'])->name('inquiry.edit');
    //        Route::put('update/{inquiry}', [SemesterController::class, 'update'])->name('semester.update');

    Route::get('inquiry_list', [InquiryController::class, 'index'])->name('inquiry_list');

    Route::post('inquiry_list', [InquiryController::class, 'index'])->name('inquiry_list');

    Route::get('/inquiry_to_student/{id}', [InquiryController::class, 'edit'])->name('inquiry_to_student');

    Route::post('/update_inquiry', [InquiryController::class, 'update'])->name('update_inquiry');

    Route::get('/edit_inquiry/{array?}/{str?}', [InquiryController::class, 'edit_inquiry'])->name('edit_inquiry');

    Route::post('/edit_inquiry/{array?}/{str?}', [InquiryController::class, 'edit_inquiry'])->name('edit_inquiry');

    Route::post('/delete_inquiry', [InquiryController::class, 'delete_inquiry'])->name('delete_inquiry');

    /***************************************************************************/
    /********************* Student Routes **********************/
    /***************************************************************************/

    Route::post('/student_transfer', [StudentTransferController::class, 'student_transfer'])->name('student_transfer');

    Route::get('/student_transfer/{array?}/{str?}', [StudentTransferController::class, 'student_transfer'])->name('student_transfer');

    Route::post('/student_transfer_list', [StudentTransferController::class, 'student_transfer_list'])->name('student_transfer_list');

    Route::get('/student_transfer_list/{array?}/{str?}', [StudentTransferController::class, 'student_transfer_list'])->name('student_transfer_list');

    Route::post('/submit_student_transfer', [StudentTransferController::class, 'submit_student_transfer'])->name('submit_student_transfer');

    Route::get('/transfer_student_attendace_record/{array?}/{str?}', [StudentTransferController::class, 'transfer_student_attendace_record'])->name('transfer_student_attendace_record');

    Route::post('/transfer_student_attendace_record', [StudentTransferController::class, 'transfer_student_attendace_record'])->name('transfer_student_attendace_record');


    /***************************************************************************/
    /********************* Student Routes **********************/
    /***************************************************************************/

    Route::get('/student_dashboard/{array?}/{str?}', [StudentController::class, 'student_dashboard'])->name('student_dashboard');
    Route::post('/student_dashboard', [StudentController::class, 'student_dashboard'])->name('student_dashboard');

    Route::get('/stuck_off_students/{array?}/{str?}', [StudentController::class, 'stuck_off_students'])->name('stuck_off_students');
    Route::post('/stuck_off_students', [StudentController::class, 'stuck_off_students'])->name('stuck_off_students');

    //    Route::get('student_dashboard', [StudentController::class, 'student_dashboard'])->name('student_dashboard');
    //    Route::get('student_dashboard', [StudentController::class, 'student_dashboard'])->name('student_dashboard');
    Route::get('add_student', [StudentController::class, 'create'])->name('add_student');
    Route::post('store_student', [StudentController::class, 'store'])->name('store_student');
    // Route::get('/', [StudentController::class, 'index'])->name('student.index');
    // Route::get('edit/{student}', [StudentController::class, 'edit'])->name('student.edit');
    //        Route::put('update/{inquiry}', [SemesterController::class, 'update'])->name('semester.update');

    Route::get('student_list', [StudentController::class, 'index'])->name('student_list');

    Route::post('student_list', [StudentController::class, 'index'])->name('student_list');

    Route::post('/edit_student', [StudentController::class, 'edit_student'])->name('edit_student');

    Route::post('/update_student', [StudentController::class, 'update_student'])->name('update_student');

    Route::get('/edit_student', [StudentController::class, 'index'])->name('edit_student');

    Route::post('/delete_student', [StudentController::class, 'delete_student'])->name('delete_student');

    Route::post('/change_student_status', [StudentController::class, 'change_student_status'])->name('change_student_status');

    Route::post('/change_student_status_active', [StudentController::class, 'change_student_status_active'])->name('change_student_status_active');

    Route::get('/get_instalment_details', [StudentController::class, 'get_instalment_details'])->name('get_instalment_details');

    Route::get('student_ledger', [StudentController::class, 'student_ledger'])->name('student_ledger');

    Route::post('student_ledger', [StudentController::class, 'student_ledger'])->name('student_ledger');

    Route::get('issue_rollno', [StudentController::class, 'issue_rollno'])->name('issue_rollno');
    Route::post('issue_rollno', [StudentController::class, 'issue_rollno'])->name('issue_rollno');

    Route::post('submit_rollno', [StudentController::class, 'submit_rollno'])->name('submit_rollno');

    Route::get('issue_matricMarks', [CollegeReportController::class, 'issue_matricMarks'])->name('issue_matricMarks');
    Route::post('issue_matricMarks', [CollegeReportController::class, 'issue_matricMarks'])->name('issue_matricMarks');
    Route::post('submit_matricMarks', [CollegeReportController::class, 'submit_matricMarks'])->name('submit_matricMarks');

    Route::get('mark_graduate', [StudentController::class, 'mark_graduate'])->name('mark_graduate');
    Route::post('submit_mark_graduate', [StudentController::class, 'submit_mark_graduate'])->name('submit_mark_graduate');
    Route::get('get_active_students', [StudentController::class, 'get_active_students'])->name('get_active_students');
    Route::get('graduate_list', [StudentController::class, 'graduate_list'])->name('graduate_list');

    Route::post('graduate_list', [StudentController::class, 'graduate_list'])->name('graduate_list');

    /***************************************************************************/
    /********************* School Routes **********************/
    /***************************************************************************/
    Route::get('add_school', [SchoolController::class, 'create'])->name('add_school');
    Route::post('store_school', [SchoolController::class, 'store'])->name('store_school');
    // Route::get('/', [SchoolController::class, 'index'])->name('school.index');
    // Route::get('edit/{school}', [SchoolController::class, 'edit'])->name('school.edit');
    // Route::put('update/{school}', [SchoolController::class, 'update'])->name('school.update');

    Route::get('school_list', [SchoolController::class, 'index'])->name('school_list');

    Route::post('school_list', [SchoolController::class, 'index'])->name('school_list');

    Route::post('/edit_school', [SchoolController::class, 'edit'])->name('edit_school');

    Route::get('/edit_school', [SchoolController::class, 'index'])->name('edit_school');

    Route::post('/update_school', [SchoolController::class, 'update'])->name('update_school');

    Route::post('/delete_school', [SchoolController::class, 'delete_school'])->name('delete_school');

    /***************************************************************************/
    /********************* Group Routes **********************/
    /***************************************************************************/

    Route::get('create_group', [GroupController::class, 'create_group'])->name('create_group');
    Route::post('store_new_group', [GroupController::class, 'store_new_group'])->name('store_new_group');

    Route::get('new_group_list', [GroupController::class, 'new_group_list'])->name('new_group_list');

    Route::post('new_group_list', [GroupController::class, 'new_group_list'])->name('new_group_list');

    Route::post('/edit_new_group', [GroupController::class, 'edit_new_group'])->name('edit_new_group');

    Route::get('/edit_new_group', [GroupController::class, 'new_group_list'])->name('edit_new_group');

    Route::post('/update_new_group', [GroupController::class, 'update_new_group'])->name('update_new_group');

    Route::post('/delete_new_group', [GroupController::class, 'delete_new_group'])->name('delete_new_group');

    Route::get('add_college_group', [GroupController::class, 'create'])->name('add_college_group');
    // Route::post('add_college_group', [GroupController::class, 'create'])->name('add_college_group');
    Route::post('store_college_group', [GroupController::class, 'store'])->name('store_college_group');
    // Route::get('/', [GroupController::class, 'index'])->name('group.index');
    // Route::get('edit/{group}', [GroupController::class, 'edit'])->name('group.edit');
    // Route::put('update/{group}', [GroupController::class, 'update'])->name('group.update');

    Route::get('college_group_list', [GroupController::class, 'index'])->name('college_group_list');

    Route::post('college_group_list', [GroupController::class, 'index'])->name('college_group_list');

    Route::post('/edit_college_groups', [GroupController::class, 'edit'])->name('edit_college_groups');

    Route::get('/edit_college_group', [GroupController::class, 'index'])->name('edit_college_group');

    Route::post('/update_college_groups', [GroupController::class, 'update'])->name('update_college_groups');

    Route::post('/delete_college_groups', [GroupController::class, 'delete_group'])->name('delete_college_groups');

    /***************************************************************************/
    /*********************Class Section Routes Start **********************/
    /***************************************************************************/
    // Burhan

    Route::get('/add_section/{class_id}', [SectionController::class, 'create'])->name('add_section');
    // Route::post('/add_section', [SectionController::class, 'create'])
    Route::post('/store_section', [SectionController::class, 'store'])->name('store_section');

    Route::get('/class_section_list/{id}', [SectionController::class, 'class_section_list'])->name('class_section_list');

    // Route::post('/section_list/{id}', [SectionController::class, 'index'])->name('section_list');

    // Route::get('/edit_class_section', [SectionController::class, 'edit'])->name('edit_class_section');

    Route::post('/edit_class_section', [SectionController::class, 'edit'])->name('edit_class_section');

    Route::post('/update_class_sections', [SectionController::class, 'update'])->name('update_class_sections');

    /***************************************************************************/
    /********************* Classes Routes **********************/
    /***************************************************************************/

    Route::post('class_dashboard', [ClassesController::class, 'dashboard'])->name('class_dashboard');
    Route::get('class_dashboard', [ClassesController::class, 'dashboard'])->name('class_dashboard');
    Route::get('add_class', [ClassesController::class, 'create'])->name('add_class');
    Route::post('store_class', [ClassesController::class, 'store'])->name('store_class');
    // Route::get('/', [ClassesController::class, 'index'])->name('class.index');
    // Route::get('edit/{classes}', [ClassesController::class, 'edit'])->name('class.edit');
    // Route::put('update/{classes}', [ClassesController::class, 'update'])->name('class.update');

    Route::get('class_list', [ClassesController::class, 'index'])->name('class_list');

    Route::post('class_list', [ClassesController::class, 'index'])->name('class_list');

    Route::post('/edit_classes', [ClassesController::class, 'edit'])->name('edit_classes');

    Route::get('/edit_classes', [ClassesController::class, 'index'])->name('edit_classes');

    Route::post('/update_classes', [ClassesController::class, 'update'])->name('update_classes');

    Route::post('/delete_classes', [ClassesController::class, 'delete_class'])->name('delete_classes');

    /***************************************************************************/
    /********************* HR Plan Routes **********************/
    /***************************************************************************/

    Route::get('add_hr_plan', [HrPlanController::class, 'create'])->name('add_hr_plan');
    Route::post('store_hr_plan', [HrPlanController::class, 'store'])->name('store_hr_plan');
    // Route::get('/', [HrPlanController::class, 'index'])->name('hr_plan.index');
    // Route::get('edit/{hrPlan}', [HrPlanController::class, 'edit'])->name('hr_plan.edit');
    // Route::put('update/{hrPlan}', [HrPlanController::class, 'update'])->name('hr_plan.update');
    // })->middleware('auth:hr_plan');

    Route::get('hr_plan_list', [HrPlanController::class, 'index'])->name('hr_plan_list');

    Route::post('hr_plan_list', [HrPlanController::class, 'index'])->name('hr_plan_list');

    Route::post('/edit_hr_plan', [HrPlanController::class, 'edit'])->name('edit_hr_plan');

    Route::post('/update_hr_plan', [HrPlanController::class, 'update'])->name('update_hr_plan');

    Route::get('/edit_hr_plan', [HrPlanController::class, 'index'])->name('edit_hr_plan');

    Route::post('/delete_hr_plan', [HrPlanController::class, 'delete_hr_plan'])->name('delete_hr_plan');

    /***************************************************************************/
    /********************* Subject Routes **********************/
    /***************************************************************************/

    // farhad
    Route::get('add_subject', [SubjectController::class, 'create'])->name('add_subject');
    Route::post('store_subject', [SubjectController::class, 'store'])->name('store_subject');
    // Route::get('/', [SubjectController::class, 'index'])->name('subject.index');
    // Route::get('edit/{subject}', [SubjectController::class, 'edit'])->name('subject.edit');
    // Route::put('update/{subject}', [SubjectController::class, 'update'])->name('subject.update');

    Route::get('subject_list', [SubjectController::class, 'index'])->name('subject_list');

    Route::post('subject_list', [SubjectController::class, 'index'])->name('subject_list');

    Route::post('/edit_subject', [SubjectController::class, 'edit'])->name('edit_subject');

    Route::post('/update_subject', [SubjectController::class, 'update'])->name('update_subject');

    Route::get('/edit_subject', [SubjectController::class, 'index'])->name('edit_subject');

    Route::post('/delete_subject', [SubjectController::class, 'delete_subject'])->name('delete_subject');

    /***************************************************************************/
    /********************* College Routes **********************/
    /***************************************************************************/

    Route::get('add_college', [CollegeController::class, 'create'])->name('add_college');
    Route::post('store_college', [CollegeController::class, 'store'])->name('store_college');
    // Route::get('/', [CollegeController::class, 'index'])->name('college.index');
    // Route::get('edit/{college}', [CollegeController::class, 'edit'])->name('college.edit');
    // Route::put('update/{college}', [CollegeController::class, 'update'])->name('college.update');

    Route::get('college_list', [CollegeController::class, 'index'])->name('college_list');

    Route::post('college_list', [CollegeController::class, 'index'])->name('college_list');

    Route::post('/edit_college', [CollegeController::class, 'edit'])->name('edit_college');

    Route::post('/update_college', [CollegeController::class, 'update'])->name('update_college');

    Route::get('/edit_college', [CollegeController::class, 'index'])->name('edit_college');

    Route::post('/delete_college', [CollegeController::class, 'delete_college'])->name('delete_college');

    /***************************************************************************/
    /********************* College Routes End **********************/
    /***************************************************************************/

    /***************************************************************************/
    /********************* Ajax Routes End **********************/
    /***************************************************************************/

    Route::get('/get_employee', [AjaxController::class, 'get_employee'])->name('get_employee');
    Route::get('/get_all_employees', [AjaxController::class, 'get_all_employees'])->name('get_all_employees');
    Route::get('/get_semester', [AjaxController::class, 'get_semester'])->name('get_semester');
    Route::get('/get_teacher', [AjaxController::class, 'get_teacher'])->name('get_teacher');
    Route::get('/get_program', [AjaxController::class, 'get_program'])->name('get_program');
    Route::get('/get_groups', [AjaxController::class, 'get_groups'])->name('get_groups');
    Route::get('/get_sections', [AjaxController::class, 'get_sections'])->name('get_sections');
    Route::get('/get_section', [AjaxController::class, 'get_section'])->name('get_section');
    Route::get('/get_subjects', [AjaxController::class, 'get_subjects'])->name('get_subjects');
    Route::get('/get_section_subject', [AjaxController::class, 'get_section_subject'])->name('get_section_subject');
    Route::get('/get_teachers', [AjaxController::class, 'get_teachers'])->name('get_teachers');
    Route::get('/get_student', [AjaxController::class, 'get_student'])->name('get_student');
    Route::get('/get_all_teachers', [AjaxController::class, 'get_all_teachers'])->name('get_all_teachers');
    Route::get('/get_allsubjects', [AjaxController::class, 'get_allsubjects'])->name('get_allsubjects');
    Route::get('/get_teacher_subject', [AjaxController::class, 'get_teacher_subject'])->name('get_teacher_subject');
    Route::get('/get_subject_time', [AjaxController::class, 'get_subject_time'])->name('get_subject_time');
    Route::get('/get_current_teacher', [AjaxController::class, 'get_current_teacher'])->name('get_current_teacher');
    Route::get('/get_teachers_all_time', [AjaxController::class, 'get_teachers_all_time'])->name('get_teachers_all_time');
    Route::get('/get_coordinator_section', [AjaxController::class, 'get_coordinator_section'])->name('get_coordinator_section');
    Route::get('/get_present_student', [AjaxController::class, 'get_present_student'])->name('get_present_student');
    Route::get('/get_student_data', [AjaxController::class, 'get_student_data'])->name('get_student_data');
    Route::get('/get_date', [AjaxController::class, 'get_date'])->name('get_date');
    Route::get('/get_students_for_promotion', [AjaxController::class, 'get_students_for_promotion'])->name('get_students_for_promotion');

    /***************************************************************************/
    /********************* Subject Assign Routes End **********************/
    /***************************************************************************/
    // farhad

    // Route::get('/assign_subject', [SubjectAssignController::class, 'assign_subject'])->name('assign_subject');

    Route::get('/subject_assign', [SubjectAssignController::class, 'create'])->name('subject_assign');

    Route::post('/submit_subject_assign', [SubjectAssignController::class, 'store'])->name('submit_subject_assign');

    Route::post('/subject_assign_list', [SubjectAssignController::class, 'list'])->name('subject_assign_list');

    Route::get('/subject_assign_list/{array?}/{str?}', [SubjectAssignController::class, 'list'])->name('subject_assign_list');

    Route::post('/subject_assign_edit', [SubjectAssignController::class, 'edit'])->name('subject_assign_edit');

    Route::post('/subject_assign_update', [SubjectAssignController::class, 'update'])->name('subject_assign_update');

    Route::get('/subject_assign_edit', [SubjectAssignController::class, 'list'])->name('subject_assign_edit');

    Route::get('/get_expiry', [SubjectAssignController::class, 'get_expiry'])->name('get_expiry');

    /***************************************************************************/
    /********************* Lecturer Attendance Routes End **********************/
    /***************************************************************************/
    //  farhad

    // Route::get('/add_lecturer_attendance', [MarkTeacherAttendanceController::class, 'create'])->name('add_lecturer_attendance');

    // Route::post('/submit_lecturer_attendance', [MarkTeacherAttendanceController::class, 'store'])->name('submit_lecturer_attendance');

    // Route::post('/lecturer_attendance_list', [MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');

    // Route::get('/lecturer_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');

    // Route::get('/edit_lecturer_attendance/{id}', [MarkTeacherAttendanceController::class, 'edit'])->name('edit_lecturer_attendance');
    // Route::get('/edit_extra_lecturer_attendance/{id}', [MarkTeacherAttendanceController::class, 'edit_extra'])->name('edit_extra_lecturer_attendance');

    // Route::get('/lecturer_attendance_view_details/view/{id}', [MarkTeacherAttendanceController::class, 'lecturer_attendance_view_details_SH'])->name('lecturer_attendance_view_details_SH');

    // Route::post('/update_lecturer_attendance', [MarkTeacherAttendanceController::class, 'update'])->name('update_lecturer_attendance');
    // Route::post('/update_extra_lecturer_attendance', [MarkTeacherAttendanceController::class, 'update_extra'])->name('update_extra_lecturer_attendance');

    // // Route::get('/edit_lecturer_attendance', [MarkTeacherAttendanceController::class, 'index'])->name('edit_lecturer_attendance');

    // Route::get('/get_Lecturer_attendance', [MarkTeacherAttendanceController::class, 'get_Lecturer_attendance'])->name('get_Lecturer_attendance');

    // Route::get('/mark_end_time_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    // Route::post('/mark_end_time_attendance_list', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    // Route::post('/mark_end_attendance', [MarkTeacherAttendanceController::class, 'mark_end_attendance'])->name('mark_end_attendance');

    // time Attendance
    Route::get('/add_lecturer_attendance', [MarkTeacherAttendanceController::class, 'create'])->name('add_lecturer_attendance');

    Route::post('/submit_lecturer_attendance', [MarkTeacherAttendanceController::class, 'store'])->name('submit_lecturer_attendance');

    Route::post('/submit_lecturer_attendance_time', [MarkTeacherAttendanceController::class, 'store_time'])->name('submit_lecturer_attendance_time');

    Route::post('/lecturer_attendance_list', [MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');

    Route::get('/lecturer_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'index'])->name('lecturer_attendance_list');

    Route::get('/edit_lecturer_attendance/{id}', [MarkTeacherAttendanceController::class, 'edit'])->name('edit_lecturer_attendance');
    Route::get('/edit_extra_lecturer_attendance/{id}', [MarkTeacherAttendanceController::class, 'edit_extra'])->name('edit_extra_lecturer_attendance');

    Route::get('/lecturer_attendance_view_details/view/{id}', [MarkTeacherAttendanceController::class, 'lecturer_attendance_view_details_SH'])->name('lecturer_attendance_view_details_SH');

    Route::post('/update_lecturer_attendance', [MarkTeacherAttendanceController::class, 'update'])->name('update_lecturer_attendance');
    Route::post('/update_extra_lecturer_attendance', [MarkTeacherAttendanceController::class, 'update_extra'])->name('update_extra_lecturer_attendance');

    // Route::get('/edit_lecturer_attendance', [MarkTeacherAttendanceController::class, 'index'])->name('edit_lecturer_attendance');

    Route::get('/get_Lecturer_attendance', [MarkTeacherAttendanceController::class, 'get_Lecturer_attendance'])->name('get_Lecturer_attendance');

    Route::get('/mark_end_time_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    Route::post('/mark_end_time_attendance_list', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    Route::post('/mark_end_attendance', [MarkTeacherAttendanceController::class, 'mark_end_attendance'])->name('mark_end_attendance');

    /***************************************************************************/
    /********************* Student Attendance Routes Start **********************/
    /***************************************************************************/
    // Burhan //

    Route::get('/mark_student_attendance/{array?}/{str?}', [StudentAttendanceController::class, 'create'])->name('mark_student_attendance');

    Route::post('/mark_student_attendance', [StudentAttendanceController::class, 'create'])->name('mark_student_attendance');

    Route::post('/store_student_attendance', [StudentAttendanceController::class, 'store'])->name('store_student_attendance');

    Route::get('/student_attendance_list/{array?}/{str?}', [StudentAttendanceController::class, 'index'])->name('student_attendance_list');

    Route::post('/student_attendance_list', [StudentAttendanceController::class, 'index'])->name('student_attendance_list');

    Route::post('/monthly_attendance_list', [StudentAttendanceController::class, 'monthly_report'])->name('monthly_attendance_list');

    Route::get('/monthly_attendance_list', [StudentAttendanceController::class, 'monthly_report'])->name('monthly_attendance_list');

    Route::post('/branch_wise_report', [StudentAttendanceController::class, 'branch_wise_report'])->name('branch_wise_report');

    Route::get('/branch_wise_report/{array?}/{str?}', [StudentAttendanceController::class, 'branch_wise_report'])->name('branch_wise_report');

    Route::post('/college_wise_report', [StudentAttendanceController::class, 'college_wise_report'])->name('college_wise_report');

    Route::get('/college_wise_report/{array?}/{str?}', [StudentAttendanceController::class, 'college_wise_report'])->name('college_wise_report');

    Route::post('/edit_student_attendance', [StudentAttendanceController::class, 'edit'])->name('edit_student_attendance');

    Route::post('/update_student_attendance', [StudentAttendanceController::class, 'update'])->name('update_student_attendance');

    Route::post('/class_attendance_view_detail', [StudentAttendanceController::class, 'class_attendance_view_detail'])->name('class_attendance_view_detail');

    Route::get('/class_attendance_view_detail/view/{class_id}/{cs_id}/{date}', [StudentAttendanceController::class, 'class_attendance_view_detail_SH'])->name('class_attendance_view_detail_SH');

    Route::get('/class_attendance_view_detail/pdf/{class_id}/{cs_id}/{date}', [StudentAttendanceController::class, 'class_attendance_view_detail_pdf_SH'])->name('class_attendance_view_detail_pdf_SH');

    // Route::get('/class_attendance_view_detail/view/{class_id}/{section_id}/{date}', [StudentAttendanceController::class, 'class_attendance_view_detail'])->name('class_attendance_view_detail');

    /***************************************************************************/
    /********************* Programs Routes start **********************/
    /***************************************************************************/
    // Burhan//

    Route::get('/add_program', [ProgramController::class, 'create'])->name('add_program');

    Route::post('/store_program', [ProgramController::class, 'store'])->name('store_program');

    Route::get('/program_list/{array?}/{str?}', [ProgramController::class, 'index'])->name('program_list');

    Route::post('/program_list', [ProgramController::class, 'index'])->name('program_list');

    Route::post('/edit_program', [ProgramController::class, 'edit'])->name('edit_program');

    Route::get('/edit_program', [ProgramController::class, 'edit'])->name('edit_program');

    Route::post('/update_program', [ProgramController::class, 'update'])->name('update_program');

    Route::post('/delete_program', [ProgramController::class, 'delete_program'])->name('delete_program');

    // Route::post('/subject_assign_edit', [SubjectAssignController::class, 'edit'])->name('subject_assign_edit');

    // Route::post('/subject_assign_update', [SubjectAssignController::class, 'update'])->name('subject_assign_update');
    /***************************************************************************/
    /********************* Programs Routes End **********************/
    /***************************************************************************/

    // Route::post('/subject_assign_edit', [SubjectAssignController::class, 'edit'])->name('subject_assign_edit');

    // Route::post('/subject_assign_update', [SubjectAssignController::class, 'update'])->name('subject_assign_update');
    /***************************************************************************/
    /********************* Create Outline Routes End **********************/
    /***************************************************************************/

    /***************************************************************************/
    /********************* Section Routes Start **********************/
    /***************************************************************************/
    // Burhan

    Route::get('/create_section', [SectionController::class, 'create_section'])->name('create_section');

    Route::post('/section_store', [SectionController::class, 'section_store'])->name('section_store');

    Route::get('/section_list/{array?}/{str?}', [SectionController::class, 'section_list'])->name('section_list');

    Route::post('/section_list', [SectionController::class, 'section_list'])->name('section_list');

    Route::get('/edit_section', [SectionController::class, 'edit_section'])->name('edit_section');

    Route::post('/edit_section', [SectionController::class, 'edit_section'])->name('edit_section');

    Route::post('/update_section', [SectionController::class, 'update_section'])->name('update_section');

    /***************************************************************************/
    /********************* Create Outline Routes End **********************/
    /***************************************************************************/
    // Burhan

    Route::get('/create_outline', [CourseOutlineController::class, 'create'])->name('create_outline');

    Route::post('/submit_course_outline', [CourseOutlineController::class, 'store'])->name('submit_course_outline');

    Route::get('/course_outline_list/{array?}/{str?}', [CourseOutlineController::class, 'index'])->name('course_outline_list');

    Route::post('/course_outline_list', [CourseOutlineController::class, 'index'])->name('course_outline_list');

    Route::post('/edit_outlines', [CourseOutlineController::class, 'edit_outlines'])->name('edit_outlines');

    Route::post('/update_outlines', [CourseOutlineController::class, 'update_outlines'])->name('update_outlines');

    Route::get('/edit_outlines', [CourseOutlineController::class, 'edit_outlines'])->name('edit_outlines');

    // Route::post('/subject_assign_edit', [SubjectAssignController::class, 'edit'])->name('subject_assign_edit');

    // Route::post('/subject_assign_update', [SubjectAssignController::class, 'update'])->name('subject_assign_update');
    /***************************************************************************/
    /********************* Section Routes End **********************/
    /***************************************************************************/

    /***************************************************************************/
    /***************************** Force Offline User Routes *******************/
    /***************************************************************************/

    // farhad
    Route::get('/force_offline_user_web', 'AllReportsController@force_offline_user_web')->name('force_offline_user_web');

    Route::post('/force_offline_user_web', 'AllReportsController@force_offline_user_web')->name('force_offline_user_web');

    Route::post('/update_force_offline_user_web', 'EmployeeController@update_force_offline_user_web')->name('update_force_offline_user_web');

    Route::post('/update_all_force_offline_user_web', 'EmployeeController@update_all_force_offline_user_web')->name('update_all_force_offline_user_web');

    /***************************************************************************/
    /***************************** End Force Offline User Routes *******************/
    /***************************************************************************/

    /***************************************************************************/
    /********************* Time Table Routes Start **********************/
    /***************************************************************************/

    // farhad
    Route::get('/add_time_table', [TimeTableController::class, 'create'])->name('add_time_table');

    Route::post('/store_time_table', [TimeTableController::class, 'store'])->name('store_time_table');

    Route::get('/timetable_view_details/view/{id}', [TimeTableController::class, 'timetable_view_details_SH'])->name('timetable_view_details_SH');
    Route::get('/timetable_view_details/pdf/{id}', [TimeTableController::class, 'timetable_view_details_pdf_SH'])->name('timetable_view_details_pdf_SH');

    Route::get('/time_table_list', [TimeTableController::class, 'index'])->name('time_table_list');

    Route::post('/time_table_list', [TimeTableController::class, 'index'])->name('time_table_list');

    Route::post('/edit_time_table', [TimeTableController::class, 'edit'])->name('edit_time_table');

    Route::get('/edit_time_table', [TimeTableController::class, 'index'])->name('edit_time_table');

    Route::post('/update_time_table', [TimeTableController::class, 'update'])->name('update_time_table');

    Route::post('/delete_time_table', [TimeTableController::class, 'delete'])->name('delete_time_table');

    /***************************************************************************/
    /********************* Time Table Routes End **********************/
    /***************************************************************************/

    /***************************************************************************/
    /********************* Student Booked Package Routes **********************/
    /***************************************************************************/

    Route::get('/student_register_list/{array?}/{str?}', [StudentBookedPackageController::class, 'student_register_list'])->name('student_register_list');
    //    Route::get('student_register_list', [StudentBookedPackageController::class, 'student_register_list'])->name('student_register_list');

    Route::post('student_register_list', [StudentBookedPackageController::class, 'student_register_list'])->name('student_register_list');

    Route::post('/create_installments', [StudentBookedPackageController::class, 'create_installments'])->name('create_installments');
    Route::get('/create_installments/{array?}/{str?}', [StudentBookedPackageController::class, 'create_installments'])->name('create_installments');

    Route::post('/submit_student_package', [StudentBookedPackageController::class, 'submit_student_package'])->name('submit_student_package');

    Route::post('/submit_discount_increase_package', [StudentBookedPackageController::class, 'submit_discount_increase_package'])->name('submit_discount_increase_package');

    Route::get('/get_package', [StudentBookedPackageController::class, 'get_package'])->name('get_package');

    Route::post('/submit_student_installment', [StudentBookedPackageController::class, 'submit_student_installment'])->name('submit_student_installment');


    //post voucher list
    Route::get('/finalized_package_posting_list/{array?}/{str?}', [StudentBookedPackageController::class, 'finalized_package_posting_list'])->name('finalized_package_posting_list');

    Route::post('/finalized_package_posting_list', [StudentBookedPackageController::class, 'finalized_package_posting_list'])->name('finalized_package_posting_list');

    // post voucher route
    Route::post('/post_finalized_student_package/{id}', [StudentBookedPackageController::class, 'post_finalized_student_package'])->name('post_finalized_student_package');
    // post voucher route end

    // discount increments route start
    //discount increments voucher list
    Route::get('/discount_increase_package_list/{array?}/{str?}', [StudentBookedPackageController::class, 'discount_increase_package_list'])->name('discount_increase_package_list');

    Route::post('/discount_increase_package_list', [StudentBookedPackageController::class, 'discount_increase_package_list'])->name('discount_increase_package_list');

    // post discount and increment voucher route
    Route::post('/post_discount_increment_package/{id}', [StudentBookedPackageController::class, 'post_discount_increment_package'])->name('post_discount_increment_package');
    // post voucher route end
    // discount increments route start

    /***************************************************************************/
    /********************* Component Routes start **********************/
    /***************************************************************************/
    // Burhan//

    Route::get('/create_component', [ComponentController::class, 'create'])->name('create_component');

    Route::post('/store_component', [ComponentController::class, 'store'])->name('store_component');

    Route::get('/component_list/{array?}/{str?}', [ComponentController::class, 'index'])->name('component_list');

    Route::post('/component_list', [ComponentController::class, 'index'])->name('component_list');

    Route::post('/edit_component', [ComponentController::class, 'edit'])->name('edit_component');

    Route::post('/update_component', [ComponentController::class, 'update'])->name('update_component');

    Route::get('/edit_component', [ComponentController::class, 'edit'])->name('edit_component');

    // Route::post('/delete_component', [ComponentController::class, 'delete_component'])->name('delete_component');
    //
    /***************************************************************************/
    /********************* Upload Lecture Routes start **********************/
    /***************************************************************************/
    // Mustafa//

    Route::get('/create_upload_lecture', [UploadLectureController::class, 'create'])->name('create_upload_lecture');

    Route::post('/store_upload_lecture', [UploadLectureController::class, 'store'])->name('store_upload_lecture');

    Route::get('/upload_lecture_list/{array?}/{str?}', [UploadLectureController::class, 'index'])->name('upload_lecture_list');

    Route::post('/upload_lecture_list', [UploadLectureController::class, 'index'])->name('upload_lecture_list');

    Route::post('/edit_upload_lecture', [UploadLectureController::class, 'edit'])->name('edit_upload_lecture');

    Route::post('/update_upload_lecture', [UploadLectureController::class, 'update'])->name('update_upload_lecture');

    Route::get('/edit_upload_lecture', [UploadLectureController::class, 'edit'])->name('edit_upload_lecture');

    Route::post('/delete_upload_lecture', [UploadLectureController::class, 'delete_upload_lecture'])->name('delete_upload_lecture');
    /***************************************************************************/
    /********************* Exam Routes start **********************/
    /***************************************************************************/
    // Burhan//

    Route::get('/create_exam', [ExamController::class, 'create_exam'])->name('create_exam');

    Route::post('/store_exam', [ExamController::class, 'store'])->name('store_exam');

    Route::post('/store_exam_marks', [MarkExamController::class, 'store_exam_marks'])->name('store_exam_marks');

    Route::get('/exam_list/{array?}/{str?}', [ExamController::class, 'index'])->name('exam_list');

    Route::post('/exam_list', [ExamController::class, 'index'])->name('exam_list');

    Route::post('/edit_exam', [ExamController::class, 'edit'])->name('edit_exam');

    Route::get('/edit_exam', [ExamController::class, 'edit'])->name('edit_exam');

    Route::post('/update_exam', [ExamController::class, 'update'])->name('update_exam');

    Route::get('/exam_class_list', [ExamController::class, 'exam_class_list'])->name('exam_class_list');

    Route::post('/exam_class_list', [ExamController::class, 'exam_class_list'])->name('exam_class_list');

    Route::post('/group_subject_list', [ExamController::class, 'group_subject_list'])->name('group_subject_list');


    Route::get('/group_subject_list', [ExamController::class, 'group_subject_list'])->name('group_subject_list');

    Route::get('/mark_subject/{array?}/{str?}', [ExamController::class, 'mark_subject'])->name('mark_subject');

    Route::post('/mark_subject', [ExamController::class, 'mark_subject'])->name('mark_subject');

    Route::post('/subject_mark_report', [MarkExamController::class, 'subject_mark_report'])->name('subject_mark_report');

    Route::get('/class_result', [MarkExamController::class, 'class_result'])->name('class_result');

    Route::post('/class_result', [MarkExamController::class, 'class_result'])->name('class_result');

    Route::get('/result_sheet/{array?}/{str?}/{type?}', [MarkExamController::class, 'result_sheet'])->name('result_sheet');

    Route::post('/result_sheet', [MarkExamController::class, 'result_sheet'])->name('result_sheet');

    Route::get('/section_result/{array?}/{str?}', [MarkExamController::class, 'section_result'])->name('section_result');

    Route::post('/section_result', [MarkExamController::class, 'section_result'])->name('section_result');
    Route::get('/get_result', [MarkExamController::class, 'get_result'])->name('get_result');

    Route::post('/delete_program', [ProgramController::class, 'delete_program'])->name('delete_program');

    /***************************************************************************/
    /********************* Assign Attendance **********************/
    /***************************************************************************/
    // Farhad

    Route::get('assign_coordinator', [AssignCoordinatorController::class, 'create'])->name('assign_coordinator');

    Route::post('store_assign_coordinator', [AssignCoordinatorController::class, 'store'])->name('store_assign_coordinator');

    Route::get('assign_coordinator_list', [AssignCoordinatorController::class, 'index'])->name('assign_coordinator_list');

    Route::post('assign_coordinator_list', [AssignCoordinatorController::class, 'index'])->name('assign_coordinator_list');

    Route::post('/edit_assign_coordinator', [AssignCoordinatorController::class, 'edit'])->name('edit_assign_coordinator');

    Route::get('/edit_assign_coordinator', [AssignCoordinatorController::class, 'index'])->name('edit_assign_coordinator');

    Route::post('/update_assign_coordinator', [AssignCoordinatorController::class, 'update'])->name('update_assign_coordinator');

    Route::post('/delete_assign_coordinator', [AssignCoordinatorController::class, 'delete_group'])->name('delete_assign_coordinator');

    /***************************************************************************/
    /********************* Subject Weightage **********************/
    /***************************************************************************/
    // Farhad

    Route::get('add_weightage', [WeightageController::class, 'create'])->name('add_weightage');

    Route::post('store_weightage', [WeightageController::class, 'store'])->name('store_weightage');

    Route::get('weightage_list', [WeightageController::class, 'index'])->name('weightage_list');

    Route::post('weightage_list', [WeightageController::class, 'index'])->name('weightage_list');

    Route::post('/edit_weightage', [WeightageController::class, 'edit'])->name('edit_weightage');

    Route::get('/edit_weightage', [WeightageController::class, 'index'])->name('edit_weightage');

    Route::post('/update_weightage', [WeightageController::class, 'update'])->name('update_weightage');

    Route::post('/delete_weightage', [WeightageController::class, 'delete_group'])->name('delete_weightage');

    /***************************************************************************/
    /********************* Teacher Load **********************/
    /***************************************************************************/
    // Farhad

    Route::get('add_teacher_load', [TeacherLoadController::class, 'create'])->name('add_teacher_load');

    Route::post('store_teacher_load', [TeacherLoadController::class, 'store'])->name('store_teacher_load');

    Route::get('teacher_load_list', [TeacherLoadController::class, 'index'])->name('teacher_load_list');

    Route::post('teacher_load_list', [TeacherLoadController::class, 'index'])->name('teacher_load_list');

    Route::post('/edit_teacher_load', [TeacherLoadController::class, 'edit'])->name('edit_teacher_load');

    Route::get('/edit_teacher_load', [TeacherLoadController::class, 'index'])->name('edit_teacher_load');

    Route::post('/update_teacher_load', [TeacherLoadController::class, 'update'])->name('update_teacher_load');

    Route::post('/delete_teacher_load', [TeacherLoadController::class, 'delete_group'])->name('delete_teacher_load');

    /***************************************************************************/
    /***************************** Reason Routes ******************************/
    /***************************************************************************/

    Route::get('/add_reason', [ChangeStudentStatusReasonController::class, 'add_reason'])->name('add_reason');

    Route::post('/submit_reason', [ChangeStudentStatusReasonController::class, 'submit_reason'])->name('submit_reason');

    Route::get('/reason_list/{array?}/{str?}', [ChangeStudentStatusReasonController::class, 'reason_list'])->name('reason_list');

    Route::post('/reason_list', [ChangeStudentStatusReasonController::class, 'reason_list'])->name('reason_list');

    Route::post('/edit_reason', [ChangeStudentStatusReasonController::class, 'edit_reason'])->name('edit_reason');

    Route::post('/update_reason', [ChangeStudentStatusReasonController::class, 'update_reason'])->name('update_reason');

    Route::get('/edit_reason', [ChangeStudentStatusReasonController::class, 'reason_list'])->name('edit_reason');

    /***************************************************************************/
    /********************* Reports Routes **********************/
    /***************************************************************************/

    Route::get('/fee_register/{array?}/{str?}', [CollegeReportController::class, 'fee_register'])->name('fee_register');

    Route::post('/fee_register', [CollegeReportController::class, 'fee_register'])->name('fee_register');

    Route::get('/custom_fee_register/{array?}/{str?}', [CollegeReportController::class, 'custom_fee_register'])->name('custom_fee_register');

    Route::post('/custom_fee_register', [CollegeReportController::class, 'custom_fee_register'])->name('custom_fee_register');

    Route::get('/fee_summary_report/{array?}/{str?}', [CollegeReportController::class, 'fee_summary_report'])->name('fee_summary_report');

    Route::post('/fee_summary_report', [CollegeReportController::class, 'fee_summary_report'])->name('fee_summary_report');

    Route::get('/teacher_day_attendance/{array?}/{str?}', [CollegeReportController::class, 'teacher_day_attendance'])->name('teacher_day_attendance');

    Route::post('/teacher_day_attendance', [CollegeReportController::class, 'teacher_day_attendance'])->name('teacher_day_attendance');

    Route::get('/teacher_analyze_report/{array?}/{str?}', [CollegeReportController::class, 'teacher_analyze_report'])->name('teacher_analyze_report');

    Route::post('/teacher_analyze_report', [CollegeReportController::class, 'teacher_analyze_report'])->name('teacher_analyze_report');

    Route::post('/student_analysis_report', [CollegeReportController::class, 'student_analysis_report'])->name('student_analysis_report');

    Route::get('/student_analysis_report/{array?}/{str?}', [CollegeReportController::class, 'student_analysis_report'])->name('student_analysis_report');

    Route::post('/teacher_subject_exam_report', [CollegeReportController::class, 'teacher_subject_exam_report'])->name('teacher_subject_exam_report');

    Route::get('/teacher_subject_exam_report/{array?}/{str?}', [CollegeReportController::class, 'teacher_subject_exam_report'])->name('teacher_subject_exam_report');

    Route::post('/subject_wise_exam_report', [CollegeReportController::class, 'subject_wise_exam_report'])->name('subject_wise_exam_report');

    Route::get('/subject_wise_exam_report/{array?}/{str?}', [CollegeReportController::class, 'subject_wise_exam_report'])->name('subject_wise_exam_report');

    /***************************************************************************/
    /********************* Extra Lecture Amount **********************/
    /***************************************************************************/
    // farhad
    Route::get('extra_amount_list', [ReportConfigController::class, 'extra_lecture_amount_list'])->name('extra_amount_list');

    Route::post('/edit_extra_amount', [ReportConfigController::class, 'edit_extra_amount'])->name('edit_extra_amount');

    Route::post('/update_extra_amount', [ReportConfigController::class, 'update_extra_amount'])->name('update_extra_amount');

    Route::post('/delete_extra_amount', [ReportConfigController::class, 'delete_extra_amount'])->name('delete_extra_amount');

    /***************************************************************************/
    /********************* Extra Lecture Amount **********************/
    /***************************************************************************/
    // farhad
    Route::get('/add_other_attendance', [MarkTeacherAttendanceController::class, 'create_other_attendance'])->name('add_other_attendance');

    Route::post('/store_other_attendance', [MarkTeacherAttendanceController::class, 'store_other_attendance'])->name('store_other_attendance');

    Route::post('/other_attendance_list', [MarkTeacherAttendanceController::class, 'other_attendance_list'])->name('other_attendance_list');

    Route::get('/other_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'other_attendance_list'])->name('other_attendance_list');

    Route::post('/edit_other_attendance', [MarkTeacherAttendanceController::class, 'edit_other_attendance'])->name('edit_other_attendance');

    Route::get('/other_attendance_view_details/view/{id}', [MarkTeacherAttendanceController::class, 'other_attendance_view_details_SH'])->name('other_attendance_view_details_SH');

    Route::post('/update_other_attendance', [MarkTeacherAttendanceController::class, 'update_other_attendance'])->name('update_other_attendance');

    // Route::get('/edit_other_attendance', [MarkTeacherAttendanceController::class, 'index'])->name('edit_other_attendance');

    Route::get('/get_Lecturer_attendance', [MarkTeacherAttendanceController::class, 'get_Lecturer_attendance'])->name('get_Lecturer_attendance');

    Route::get('/mark_end_time_attendance_list/{array?}/{str?}', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    Route::post('/mark_end_time_attendance_list', [MarkTeacherAttendanceController::class, 'mark_end_time_attendance_list'])->name('mark_end_time_attendance_list');

    Route::post('/mark_end_attendance', [MarkTeacherAttendanceController::class, 'mark_end_attendance'])->name('mark_end_attendance');

    /***************************************************************************/
    /********************* Transport Route **********************/
    /***************************************************************************/
//    Burhan
    Route::get('/add_route', [TransportRouteController::class, 'add_route'])->name('add_route');

    Route::post('/submit_route', [TransportRouteController::class, 'submit_route'])->name('submit_route');

    Route::get('/route_list/{array?}/{str?}', [TransportRouteController::class, 'route_list'])->name('route_list');

    Route::post('/route_list', [TransportRouteController::class, 'route_list'])->name('route_list');

    Route::post('/edit_route', [TransportRouteController::class, 'edit_route'])->name('edit_route');

    Route::post('/update_route', [TransportRouteController::class, 'update_route'])->name('update_route');

    Route::get('/edit_route', [TransportRouteController::class, 'route_list'])->name('edit_route');

    /***************************************************************************/
    /********************* Promotion Route **********************/
    /***************************************************************************/
//    Burhan
    Route::get('/class_promotion', [StudentPromotionController::class, 'promotion'])->name('class_promotion');

    Route::post('/submit_class_promotion', [StudentPromotionController::class, 'submit_class_promotion'])->name('submit_class_promotion');

    Route::get('/promotion_list/{array?}/{str?}', [StudentPromotionController::class, 'promotion_list'])->name('promotion_list');

    Route::post('/promotion_list', [StudentPromotionController::class, 'promotion_list'])->name('promotion_list');

    Route::post('/edit_prmotion', [StudentPromotionController::class, 'edit_prmotion'])->name('edit_prmotion');

    Route::post('/update_prmotion', [StudentPromotionController::class, 'update_prmotion'])->name('update_prmotion');

    Route::get('/edit_prmotion', [StudentPromotionController::class, 'prmotion_list'])->name('edit_prmotion');

    /***************************************************************************/
    /********************* Promotion Route **********************/
    /***************************************************************************/
//    Burhan
    Route::get('/announcement', [AnnouncementController::class, 'create'])->name('announcement');

    Route::post('/store_announcement', [AnnouncementController::class, 'store_announcement'])->name('store_announcement');

    Route::get('/announcement_list/{array?}/{str?}', [AnnouncementController::class, 'announcement_list'])->name('announcement_list');

    Route::post('/announcement_list', [AnnouncementController::class, 'announcement_list'])->name('announcement_list');

    Route::post('/edit_prmotion', [StudentPromotionController::class, 'edit_prmotion'])->name('edit_prmotion');

    Route::post('/update_prmotion', [StudentPromotionController::class, 'update_prmotion'])->name('update_prmotion');

    Route::get('/edit_prmotion', [StudentPromotionController::class, 'prmotion_list'])->name('edit_prmotion');
    /***************************************************************************/
    /********************* Documents Route **********************/
    /***************************************************************************/
//    Burhan
    Route::get('document_uplaod', [DocumentUploadController::class, 'document_uplaod'])->name('document_uplaod');

    Route::post('store_document_upload', [DocumentUploadController::class, 'store_document_upload'])->name('store_document_upload');

    Route::get('document_list/{array?}/{str?}', [DocumentUploadController::class, 'document_list'])->name('document_list');

    Route::post('document_list', [DocumentUploadController::class, 'document_list'])->name('document_list');

    Route::post('/store_announcement', [AnnouncementController::class, 'store_announcement'])->name('store_announcement');

    Route::get('/announcement_list/{array?}/{str?}', [AnnouncementController::class, 'announcement_list'])->name('announcement_list');

    Route::post('/announcement_list', [AnnouncementController::class, 'announcement_list'])->name('announcement_list');

    Route::post('/edit_prmotion', [StudentPromotionController::class, 'edit_prmotion'])->name('edit_prmotion');

    Route::post('/update_prmotion', [StudentPromotionController::class, 'update_prmotion'])->name('update_prmotion');

    Route::get('/edit_prmotion', [StudentPromotionController::class, 'prmotion_list'])->name('edit_prmotion');

    /***************************************************************************/
    /********************* Advance Fee Voucher Route **********************/
    /***************************************************************************/
    Route::post('/submit_advance_voucher', [AdvanceFeeVoucherController::class, 'submit_advance_voucher'])->name('submit_advance_voucher');

    Route::get('/advance_fee_voucher_list/{array?}/{str?}', [AdvanceFeeVoucherController::class, 'advance_fee_voucher_list'])->name('advance_fee_voucher_list');

    Route::post('/advance_fee_voucher_list', [AdvanceFeeVoucherController::class, 'advance_fee_voucher_list'])->name('advance_fee_voucher_list');

    Route::post('/adv_fee_items_view_details', [AdvanceFeeVoucherController::class, 'adv_fee_items_view_details'])->name('adv_fee_items_view_details');


    Route::get('/adv_fee_items_view_details/view/{id}/{reg_no}', [AdvanceFeeVoucherController::class, 'adv_fee_items_view_details_SH'])->name('adv_fee_items_view_details_SH');

    Route::get('/adv_fee_items_view_details/pdf/{id}/{reg_no}', [AdvanceFeeVoucherController::class, 'adv_fee_items_view_details_pdf_SH'])->name('adv_fee_items_view_details_pdf_SH');

    /*fee voucher pending list*/
    Route::get('/advance_fee_voucher_pending_list/{array?}/{str?}', [AdvanceFeeVoucherController::class, 'advance_fee_voucher_pending_list'])->name('advance_fee_voucher_pending_list');

    Route::post('/advance_fee_voucher_pending_list', [AdvanceFeeVoucherController::class, 'advance_fee_voucher_pending_list'])->name('advance_fee_voucher_pending_list');

    Route::post('/paid_single_advance_fee_voucher/{id}', [PaidFeeVoucherController::class, 'paid_single_advance_fee_voucher'])->name('paid_single_advance_fee_voucher');

    Route::post('/reverse_advance_fee_voucher', [AdvanceFeeVoucherController::class, 'reverse_advance_fee_voucher'])->name('reverse_advance_fee_voucher');

    Route::get('/advance_fee_reverse_voucher_list/{array?}/{str?}', [AdvanceFeeVoucherController::class, 'advance_fee_reverse_voucher_list'])->name('advance_fee_reverse_voucher_list');

    Route::post('/advance_fee_reverse_voucher_list', [AdvanceFeeVoucherController::class, 'advance_fee_reverse_voucher_list'])->name('advance_fee_reverse_voucher_list');

    /* Push Voucher */
    Route::get('/push_voucher', [FeeVoucherController::class, 'push_voucher'])->name('push_voucher');
});
