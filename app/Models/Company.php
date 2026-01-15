<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'company';
    protected $primaryKey = 'company_id';

    protected $fillable = [
        'user_id',
        'business_Name',
        'trade_Name',
        'company_TIN',
        'company_Type',
        'employer_Type',
        'employer_Type_Desc',
        'company_Total_workforce',
        'company_Address',
        'barangay_id',
        'contact_Person',
        'contact_Person_position',
        'company_Pnum',
        'company_Tnum',
        'company_Fnum',
        'company_Email',
        'company_Status',
        'company_img',
        'company_Desc',
    ];

    protected $casts = [
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
    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'company_id');
    }

    public function company_industry_line()
    {
        return $this->hasMany(Company_Industry_Line::class, 'company_id');
    }

    public function requirements_passed()
    {
        return $this->hasMany(Requirements_Passed::class, 'company_id');
    }

    public function partnerships()
    {
        return $this->hasMany(Partnerships::class, 'company_id');
    }

    /**
     * Get the total count of hired applicants for the company.
     *
     * @return int
     */
    public function getTotalHiredApplicants($peso_id)
    {
        // Retrieve all job posting IDs associated with the company, filtered by industry
        $jobPostingIds = $this->job_posting()
            ->where('peso_id', $peso_id) // Filter by industry peso_id
            ->pluck('job_id');

        // Count the total number of applicants with status 'ACCEPTED'
        return Job_Applicants::whereIn('job_id', $jobPostingIds)
            ->where('applicant_Status', 'ACCEPTED')
            ->count();
    }

    public static function fieldMappings()
    {
        return [
            'company_id' => 'Company ID',
            'user_id' => 'User ID',
            'business_Name' => 'Business Name',
            'trade_Name' => 'Trade Name',
            'company_TIN' => 'Company TIN',
            'company_Type' => 'Company Type',
            'employer_Type' => 'Employer Type',
            'employer_Type_Desc' => 'Employer Type Description',
            'company_Total_workforce' => 'Total Workforce',
            'company_Address' => 'Company Address',
            'barangay_id' => 'Barangay ID',
            'contact_Person' => 'Contact Person',
            'contact_Person_position' => 'Contact Person Position',
            'company_Pnum' => 'Company Phone Number',
            'company_Tnum' => 'Company Telephone Number',
            'company_Fnum' => 'Company Fax Number',
            'company_Email' => 'Company Email',
            'company_Status' => 'Company Status',
            'company_img' => 'Company Image',
            'company_Desc' => 'Company Description',
        ];
    }

}
