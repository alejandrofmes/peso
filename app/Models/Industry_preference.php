<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Industry_preference extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'industry_preference';
    protected $primaryKey = 'industry_pref_id';

    protected $fillable = [
        'employee_id',
        'industry_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function job_industry()
    {
        return $this->belongsTo(Job_Industry::class, 'industry_id');
    }

    public static function fieldMappings()
{
    return [
        'industry_pref_id' => 'Industry Preference ID',
        'employee_id' => 'Employee ID',
        'industry_id' => 'Industry ID',
    ];
}

}
