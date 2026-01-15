<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Employee extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'employee';
    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'user_id',
        'fname',
        'mname',
        'lname',
        'suffix',
        'height',
        'gender',
        'civilstatus',
        'religion',
        'birthdate',
        'pnumber',
        'address',
        'barangay_id',
        'tinnum',
        'empstatus',
        'empstatusdesc',
        'ofw',
        'fourp',
        'fourpID',
        'pimg',
        'resume',
        'empDesc',
        'empprofile',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }
    public function certificate()
    {
        return $this->hasMany(Certificate::class, 'employee_id');
    }
    public function disability()
    {
        return $this->hasMany(Disability::class, 'employee_id');
    }
    public function language()
    {
        return $this->hasMany(Language::class, 'employee_id');
    }
    public function education()
    {
        return $this->hasMany(Education::class, 'employee_id');
    }
    public function eligibility()
    {
        return $this->hasMany(Eligibility::class, 'employee_id');
    }
    public function job_applicants()
    {
        return $this->hasMany(Job_Applicants::class, 'employee_id');
    }
    public function job_preference()
    {
        return $this->hasMany(Job_Preference::class, 'employee_id');
    }
    public function license()
    {
        return $this->hasMany(License::class, 'employee_id');
    }
    public function program_reg()
    {
        return $this->hasMany(Program_Reg::class, 'employee_id');
    }
    public function skills()
    {
        return $this->hasMany(Skills::class, 'employee_id');
    }
    public function training()
    {
        return $this->hasMany(Training::class, 'employee_id');
    }
    public function work_exp()
    {
        return $this->hasMany(Work_Exp::class, 'employee_id');
    }

    public function industry_preference()
    {
        return $this->hasMany(Industry_preference::class, 'employee_id');
    }

    public function activeApplications()
    {
        return $this->hasMany(Job_Applicants::class, 'employee_id')
            ->whereNotIn('applicant_status', ['COMPLETED', 'REJECTED']);

    }

    public static function fieldMappings()
    {
        return [
            'employee_id' => 'Employee ID',
            'user_id' => 'User ID',
            'fname' => 'First Name',
            'mname' => 'Middle Name',
            'lname' => 'Last Name',
            'suffix' => 'Suffix',
            'height' => 'Height',
            'gender' => 'Gender',
            'civilstatus' => 'Civil Status',
            'religion' => 'Religion',
            'birthdate' => 'Birthdate',
            'pnumber' => 'Phone Number',
            'address' => 'Address',
            'barangay_id' => 'Barangay ID',
            'tinnum' => 'TIN Number',
            'empstatus' => 'Employment Status',
            'empstatusdesc' => 'Employment Status Description',
            'ofw' => 'OFW Status',
            'fourp' => '4Ps Member',
            'fourpID' => '4Ps Household No.',
            'pimg' => 'Profile Image',
            'resume' => 'Resume',
            'empDesc' => 'Employee Description',
            'empprofile' => 'Employee Profile Status',
        ];
    }

}
