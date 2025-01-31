<?php

namespace App\Models\College;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Master extends Authenticatable
{
    use HasFactory;
    use Notifiable, HasRoles;

    protected $table = 'masters';
    protected $guard = 'master';
    // Primary Key attributes
    protected $primaryKey = 'id';
    public $incrementing = true;

    // Timestamp Attribures
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'user_id','user_employee_code','user_designation','user_name','user_father_name','user_username', 'email', 'user_password','user_mobile','user_emergency_contact','user_cnic','user_commission_per','user_target_amount','user_address','user_address_2','user_profilepic','user_folder','user_createdby','user_datetime','user_login_status','user_religion','user_d_o_j','user_account_reporting_group_ids','user_product_reporting_group_ids','user_modular_group_id','user_role_id','user_level','user_reset_password','user_nationality','user_family_code','user_marital_status','user_city','user_blood_group','user_salary_person','user_have_credentials','user_teller_cash_account_uid','user_teller_wic_account_uid','user_purchaser_cash_account_uid','user_purchaser_wic_account_uid','user_day_end_id','user_day_end_date','user_delete_status','user_deleted_by','user_web_status','user_desktop_status','user_disabled','user_android_status','user_ios_status','user_ip_adrs','user_brwsr_info','user_update_datetime','user_fcm_token','user_send_day_end_report','user_send_month_end_report','user_send_sync_report'
    // ];
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // tabel name

//    protected $dateFormat = 'U';
//    const CREATED_AT = 'creation_date';
//    const UPDATED_AT = 'last_update';

    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Overrides the method to ignore the remember token.
     */
//    public function setAttribute($key, $value)
//    {
//        $isRememberTokenAttribute = $key == $this->getRememberTokenName();
//        if (!$isRememberTokenAttribute)
//        {
//            parent::setAttribute($key, $value);
//        }
//    }
//
////    nabeel
////    check if user has a session id
//    public function hasSession(){
//        return(
//            !empty($this->session_id) &&
//            Session::getHandler()->read($this->session_id)
//        );
//    }
//
////    save new session id
//    public function saveSession($session_id){
//        $this->session_id = $session_id;
//        $this->save();
//    }
//
//    public function getUserExpiryDateAttribute($valuse)
//    {
//        return date('d-M-Y', strtotime($valuse));
//    }
}
