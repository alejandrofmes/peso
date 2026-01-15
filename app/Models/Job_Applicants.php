<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Job_Applicants extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'job_applicants';
    protected $primaryKey = 'applicant_id';

    protected $fillable = [
        'employee_id',
        'job_id',
        'applicant_Resume',
        'applicant_Status',
        'peso_Status',
        'company_Remarks',
        'peso_Remarks',
        'peso_Letter',
        'applicant_Notif',
        'peso_accounts_id',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function peso_accounts()
    {
        return $this->belongsTo(PESO_Accounts::class, 'peso_accounts_id');
    }

    public function job_posting()
    {
        return $this->belongsTo(Job_Posting::class, 'job_id');
    }

    public static function fieldMappings()
    {
        return [
            'applicant_id' => 'Applicant ID',
            'employee_id' => 'Employee ID',
            'job_id' => 'Job ID',
            'applicant_Resume' => 'Resume',
            'applicant_Status' => 'Application Status',
            'peso_Status' => 'PESO Status',
            'company_Remarks' => 'Company Remarks',
            'peso_accounts_id' => 'PESO Account',
            'peso_Remarks' => 'PESO Remarks',
            'peso_Letter' => 'PESO Letter',
            'applicant_Notif' => 'Notification',
            'responded_at' => 'Response Date',
        ];
    }

}
