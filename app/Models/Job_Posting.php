<?php

namespace App\Models;

use App\Redactors\LimiterRedactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Casts\CleanHtml;
use OwenIt\Auditing\Contracts\Auditable;
use App\Casts\TrimString;


class Job_Posting extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $attributeModifiers = [
        'job_Description' => LimiterRedactor::class,
        'job_Qualifications' => LimiterRedactor::class,
        'job_Remarks' => LimiterRedactor::class,
    ];

    protected $table = 'job_posting';
    protected $primaryKey = 'job_id';

    protected $fillable = [
        'company_id',
        'industry_id',
        'job_Title',
        'job_Description',
        'job_Qualifications',
        'job_Remarks',
        'job_MinWage',
        'job_MaxWage',
        'job_Type',
        'job_Edu',
        'job_Slots',
        'job_Disability',
        'job_Address',
        'barangay_id',
        'job_Duration',
        'job_Status',
        'peso_accounts_id',
        'peso_id',
        'peso_Remarks',
        'job_Duration',
        'responded_at',
    ];

    protected $casts = [
        'job_Title' => TrimString::class,
        'job_Address' => TrimString::class,
        'job_Description' => CleanHtml::class,
        'job_Qualifications' => CleanHtml::class,
        'job_Remarks' => CleanHtml::class,
        'job_Duration' => 'date',
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function job_industry()
    {
        return $this->belongsTo(Job_Industry::class, 'industry_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id');
    }

    public function peso()
    {
        return $this->belongsTo(PESO::class, 'peso_id');
    }
    public function peso_accounts()
    {
        return $this->belongsTo(PESO_Accounts::class, 'peso_accounts_id');
    }

    public function job_tags()
    {
        return $this->hasMany(Job_Tags::class, 'job_id');
    }

    public function job_applicants()
    {
        return $this->hasMany(Job_Applicants::class, 'job_id');
    }

    public function hiredApplicants()
    {
        return $this->hasMany(Job_Applicants::class, 'job_id')
            ->where('applicant_status', 'ACCEPTED');
    }

    public function slotsLeft()
    {
        // Get the total number of hired applicants
        $hiredApplicantsCount = $this->hiredApplicants()->count();

        // Calculate the remaining slots, ensuring it can't be negative
        return max($this->job_Slots - $hiredApplicantsCount, 0);
    }

    public static function fieldMappings()
    {
        return [
            'job_id' => 'Job ID',
            'company_id' => 'Company ID',
            'industry_id' => 'Industry ID',
            'job_Title' => 'Job Title',
            'job_Description' => 'Job Description',
            'job_Qualifications' => 'Job Qualifications',
            'job_Remarks' => 'Job Remarks',
            'job_MinWage' => 'Minimum Wage',
            'job_MaxWage' => 'Maximum Wage',
            'job_Type' => 'Job Type',
            'job_Edu' => 'Education Required',
            'job_Slots' => 'Available Slots',
            'job_Disability' => 'Accepts Disability',
            'job_Address' => 'Job Address',
            'barangay_id' => 'Barangay ID',
            'job_Duration' => 'Job Duration',
            'job_Status' => 'Job Status',
            'peso_accounts_id' => 'PESO Account ID',
            'peso_id' => 'PESO Branch ID',
            'peso_Remarks' => 'PESO Remarks',
            'responded_at' => 'Responded At',
        ];
    }

}
