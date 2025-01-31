<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PSO\NozzleController;
use App\Models\AccountGroupModel;
use App\Models\AccountHeadsModel;
use App\Models\AccountRegisterationModel;
use App\Models\AreaModel;
use App\Models\AuthorModel;
use App\Models\BrandModel;
use App\Models\CategoryInfoModel;
use App\Models\ClassModel;
use App\Models\College\AssignCoordinatorModel;
use App\Models\College\NewGroupsModel;
use App\Models\CourierModel;
use App\Models\CreditCardMachineModel;
use App\Models\CurrencyModel;
use App\Models\Department;
use App\Models\FixedAssetModel;
use App\Models\GroupInfoModel;
use App\Models\IllustratedModel;
use App\Models\ImPrintModel;
use App\Models\LanguageModel;
use App\Models\MainUnitModel;
use App\Models\ModularGroupModel;
use App\Models\Prerequisites\Advertising;
use App\Models\Prerequisites\ProductBatchRecipeModel;
use App\Models\Prerequisites\Surveyor;
use App\Models\ProductDetailsModel;
use App\Models\ProductGroupModel;
use App\Models\ProductModel;
use App\Models\ProductPackagesModel;
use App\Models\ProductRecipeModel;
use App\Models\PostingReferenceModel;
use App\Models\PublisherModel;
use App\Models\RegionModel;
use App\Models\SectorModel;
use App\Models\ServicesModel;
use App\Models\TableModel;
use App\Models\TopicModel;
use App\Models\TownModel;
use App\Models\UnitInfoModel;
use App\Models\WarehouseModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\College\BankAccountModel;
use App\Models\College\Classes;
use App\Models\College\College;
use App\Models\College\Degree;
use App\Models\College\Group;
use App\Models\College\HrPlan;
use App\Models\College\Program;
use App\Models\College\School;
use App\Models\College\Section;
use App\Models\College\Semester;
use App\Models\College\SessionModel;
use App\Models\College\Student;
use App\Models\College\Subject;
use App\Models\College\TimeTableModel;
use App\Models\CreateSectionModel;
use App\Models\DesignationModel;
use Spatie\Permission\Models\Role;

class EnabledDisabledController extends Controller
{
    public function enable_disable_department(Request $request)
    {
        $user = Department::findOrFail($request->dep_id);
        $user->dep_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'Department status updated successfully.']);
    }

    public function enable_disable_region(Request $request)
    {
        $user = RegionModel::findOrFail($request->reg_id);
        $user->reg_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_desig(Request $request)
    {
        $user = DesignationModel::findOrFail($request->desig_id);
        $user->desig_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_fixed_asset(Request $request)
    {
        $user = FixedAssetModel::findOrFail($request->fa_id);
        $user->fa_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_project_reference(Request $request)
    {
        $user = PostingReferenceModel::findOrFail($request->pr_id);
        $user->pr_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_brand(Request $request)
    {
        $user = BrandModel::findOrFail($request->br_id);
        $user->br_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_area(Request $request)
    {
        $user = AreaModel::findOrFail($request->area_id);
        $user->area_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_sector(Request $request)
    {
        $user = SectorModel::findOrFail($request->sec_id);
        $user->sec_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_account(Request $request)
    {
        $user = AccountRegisterationModel::where('account_id', '=', $request->account_id)->first();
        $user->account_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_account_group(Request $request)
    {
        $user = AccountGroupModel::findOrFail($request->ag_id);
        $user->ag_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_account_heads(Request $request)
    {
        $user = AccountHeadsModel::findOrFail($request->coa_id);
        $user->coa_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_credit_card_machine(Request $request)
    {
        $user = CreditCardMachineModel::findOrFail($request->ccm_id);
        $user->ccm_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_warehouse(Request $request)
    {
        $user = WarehouseModel::findOrFail($request->wh_id);
        $user->wh_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }


    public function enable_disable_main_unit(Request $request)
    {
        $user = MainUnitModel::findOrFail($request->mu_id);
        $user->mu_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_unit(Request $request)
    {
        $user = UnitInfoModel::findOrFail($request->unit_id);
        $user->unit_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_group(Request $request)
    {
        $user = GroupInfoModel::findOrFail($request->grp_id);
        $user->grp_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_category(Request $request)
    {
        $user = CategoryInfoModel::findOrFail($request->cat_id);
        $user->cat_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_product(Request $request)
    {
        $user = ProductModel::findOrFail($request->pro_id);
        $user->pro_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_service(Request $request)
    {
        $user = ServicesModel::findOrFail($request->ser_id);
        $user->ser_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_modular_group(Request $request)
    {
        $user = ModularGroupModel::findOrFail($request->mg_id);
        $user->mg_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_role_permission(Request $request)
    {
        $user = Role::findOrFail($request->id);
        $user->disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_town(Request $request)
    {
        $user = TownModel::findOrFail($request->town_id);
        $user->town_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_product_package(Request $request)
    {
        $user = ProductPackagesModel::findOrFail($request->pp_id);
        $user->pp_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_product_recipe(Request $request)
    {
        $user = ProductRecipeModel::findOrFail($request->pr_id);
        $user->pr_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_product_batch_recipe(Request $request)
    {
        $user = ProductBatchRecipeModel::findOrFail($request->pbr_id);
        $user->pbr_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_product_handling(Request $request)
    {
        $user = ProductGroupModel::findOrFail($request->pg_id);
        $user->pg_disabled = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    public function enable_disable_publisher(Request $request)
    {
        $publisher = PublisherModel::findOrFail($request->pub_id);
        $publisher->pub_disabled = $request->status;
        $publisher->save();

        return response()->json(['message' => 'Publisher status updated successfully.']);
    }

    public function enable_disable_topic(Request $request)
    {
        $topic = TopicModel::findOrFail($request->top_id);
        $topic->top_disabled = $request->status;
        $topic->save();

        return response()->json(['message' => 'Topic status updated successfully.']);
    }

    public function enable_disable_author(Request $request)
    {
        $author = AuthorModel::findOrFail($request->aut_id);
        $author->aut_disabled = $request->status;
        $author->save();

        return response()->json(['message' => 'Author status updated successfully.']);
    }

    public function enable_disable_class(Request $request)
    {
        $class = Classes::findOrFail($request->class_id);
        $class->class_disable_enable = $request->status;
        $class->save();

        return response()->json(['message' => 'Class status updated successfully.']);
    }

    public function enable_disable_currency(Request $request)
    {
        $currency = CurrencyModel::findOrFail($request->cur_id);
        $currency->cur_disabled = $request->status;
        $currency->save();

        return response()->json(['message' => 'Currency status updated successfully.']);
    }

    public function enable_disable_language(Request $request)
    {
        $language = LanguageModel::findOrFail($request->lan_id);
        $language->lan_disabled = $request->status;
        $language->save();

        return response()->json(['message' => 'Language status updated successfully.']);
    }

    public function enable_disable_imPrint(Request $request)
    {
        $imprint = ImPrintModel::findOrFail($request->imp_id);
        $imprint->imp_disabled = $request->status;
        $imprint->save();

        return response()->json(['message' => 'ImPrint status updated successfully.']);
    }


    public function enable_disable_illustrated(Request $request)
    {
        $illustrated = IllustratedModel::findOrFail($request->illustrated_Id);
        $illustrated->ill_disabled = $request->status;
        $illustrated->save();

        return response()->json(['message' => 'Illustrated status updated successfully.']);
    }

    public function enable_disable_product_detail(Request $request)
    {
        $product_details = ProductDetailsModel::findOrFail($request->pd_id);
        $product_details->pd_disabled = $request->status;
        $product_details->save();

        return response()->json(['message' => 'Product Details status updated successfully.']);
    }

    public function enable_disable_courier(Request $request)
    {
        $courier = CourierModel::findOrFail($request->cc_id);
        $courier->cc_disabled = $request->status;
        $courier->save();

        return response()->json(['message' => 'Courier status updated successfully.']);
    }

    public function enable_disable_table(Request $request)
    {
        $table = TableModel::findOrFail($request->tb_id);
        $table->tb_disabled = $request->status;
        $table->save();

        return response()->json(['message' => 'Courier status updated successfully.']);
    }

    public function enable_disable_advertising(Request $request)
    {
        $table = Advertising::findOrFail($request->adv_id);
        $table->adv_disabled = $request->status;
        $table->save();

        return response()->json(['message' => 'Courier status updated successfully.']);
    }

    public function enable_disable_surveyor(Request $request)
    {
        $table = Surveyor::findOrFail($request->srv_id);
        $table->srv_disabled = $request->status;
        $table->save();

        return response()->json(['message' => 'Courier status updated successfully.']);
    }

    public function enable_disable_employee(Request $request)
    {
        $user = User::findOrFail($request->emp_id);
        $user->user_disabled = $request->status;
        $user->save();
        return response()->json(['message' => 'User status updated successfully.']);
    }
    public function enable_disable_finger(Request $request)
    {
        $user = User::findOrFail($request->emp_id);
        $user->user_finger_status = $request->status;
        $user->save();

        return response()->json(['message' => 'User Finger status updated successfully.']);
    }

    public function mark_teacherOrNot(Request $request)
    {
        $user = User::findOrFail($request->teacher_id);
        $user->user_mark = $request->status;
        $user->save();

        return response()->json(['message' => 'Teacher status updated successfully.']);
    }


    //College Enable Disable Functions

    public function enable_disable_student(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->student_disable_enable = $request->status;
        $student->save();
        return response()->json(['message' => 'Student status updated successfully.']);
    }

    public function enable_disable_school(Request $request)
    {
        $schools = School::findOrFail($request->sch_id);
        $schools->sch_disable_enable = $request->status;
        $schools->save();
        return response()->json(['message' => 'School status updated successfully.']);
    }

    public function enable_disable_subject(Request $request)
    {
        // dd($request->all());
        $subjects = Subject::findOrFail($request->subject_id);
        $subjects->subject_disable_enable = $request->status;
        $subjects->save();
        return response()->json(['message' => 'Subject status updated successfully.']);
    }

    public function enable_disable_degree(Request $request)
    {
        // dd($request->all());
        $degree = Degree::findOrFail($request->degree_id);
        $degree->degree_disable_enable = $request->status;
        $degree->save();
        return response()->json(['message' => 'Degree status updated successfully.']);
    }

    public function enable_disable_groups(Request $request)
    {
        // dd($request->all());
        $degree = NewGroupsModel::findOrFail($request->degree_id);
        $degree->ng_disable_enable = $request->status;
        $degree->save();
        return response()->json(['message' => 'Group status updated successfully.']);
    }

    public function enable_disable_session(Request $request)
    {
        // dd($request->all());
        $session = SessionModel::findOrFail($request->session_id);
        $session->session_disable_enable = $request->status;
        $session->save();
        return response()->json(['message' => 'Sesion status updated successfully.']);
    }

    public function enable_disable_semester(Request $request)
    {
        // dd($request->all());
        $semester = Semester::findOrFail($request->semester_id);
        $semester->semester_disable_enable = $request->status;
        $semester->save();
        return response()->json(['message' => 'Semester status updated successfully.']);
    }

    public function enable_disable_clg_group(Request $request)
    {
        // dd($request->all());
        $clg_group = Group::findOrFail($request->group_id);
        $clg_group->group_disable_enable = $request->status;
        $clg_group->save();
        return response()->json(['message' => 'Group status updated successfully.']);
    }

    public function enable_disable_section_coordinator(Request $request)
    {
        $clg_group = AssignCoordinatorModel::findOrFail($request->ac_id);
        $clg_group->ac_disable_enable = $request->status;
        $clg_group->save();
        return response()->json(['message' => 'Assign Coordinator status updated successfully.']);
    }

    public function enable_disable_hr_plan(Request $request)
    {
        // dd($request->all());
        $hr_plan = HrPlan::findOrFail($request->hr_plan_id);
        $hr_plan->hr_plan_disable_enable = $request->status;
        $hr_plan->save();
        return response()->json(['message' => 'HR Plan status updated successfully.']);
    }

    public function enable_disable_program(Request $request)
    {
        // dd($request->all());
        $program = Program::where('program_id', $request->program_id)->first();
        $program->program_disable_enable = $request->status;
        $program->save();
        return response()->json(['message' => 'Program status updated successfully.', 'status' => $request->status, 'prom' => $request->program_id]);
    }

    public function enable_disable_section(Request $request)
    {
        $section = Section::findOrFail($request->section_id);
        $section->section_disable_enable = $request->status;
        $section->save();
        return response()->json(['message' => 'Section status updated successfully.']);
    }

    public function enable_disable_bank_info(Request $request)
    {
        $section = BankAccountModel::findOrFail($request->bi_id);
        $section->bi_disable_enable = $request->status;
        $section->save();
        return response()->json(['message' => 'Bank Info status updated successfully.']);
    }

    public function enable_disable_class_section(Request $request)
    {
        $section = CreateSectionModel::findOrFail($request->cs_id);
        // dd($request->all(),$section);
        $section->cs_disable_enable = $request->status;
        $section->save();
        return response()->json(['message' => ' Section status updated successfully.']);
    }

    public function enable_disable_class_timetable(Request $request)
    {
        $section = TimeTableModel::findOrFail($request->tm_id);
        // dd($request->all(),$section);
        $section->tm_disable_enable = $request->status;
        $section->save();
        return response()->json(['message' => 'Time Table status updated successfully.']);
    }

    public function check_class_timetable(Request $request)
    {
        $time_table = TimeTableModel::findOrFail($request->tm_id);
        $current_date = Carbon::now()->startOfDay(); // Get the current date
        $semester_start_date = Carbon::createFromFormat('Y-m-d', $time_table->semester_start_date)->startOfDay();

        if ($current_date->lt($semester_start_date)) {
            return response()->json([
                'message' => 'This click will work on ' . $semester_start_date->format('d-m-y'),
                'status' => 'info'
            ]);
        } else {
            $time_table->checks = $request->status;
            $time_table->save();

            return response()->json(['message' => 'Time Table status updated successfully.', 'status' => 'success']);
        }
    }

}
