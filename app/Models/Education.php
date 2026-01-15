<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Education extends Model implements Auditable
{

    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $primaryKey = 'education_id';

    protected $table = 'education';
    protected $fillable = [
        'employee_id',
        'edu_School',
        'edu_Level',
        'edu_Course',
        'edu_Started',
        'edu_Ended',
        'edu_Ongoing',
    ];

    protected $casts = [
        'edu_Started' => 'date',
        'edu_Ended' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public static function fieldMappings()
{
    return [
        'education_id' => 'Education ID',
        'employee_id' => 'Employee ID',
        'edu_School' => 'School Name',
        'edu_Level' => 'Education Level',
        'edu_Course' => 'Course',
        'edu_Started' => 'Start Date',
        'edu_Ended' => 'End Date',
        'edu_Ongoing' => 'Ongoing',
    ];
}

}
