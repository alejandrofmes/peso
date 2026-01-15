<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Training extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'training';
    protected $primaryKey = 'training_id';

    protected $fillable = [
        'employee_id',
        'training_Name',
        'training_From',
        'training_Cert',
        'training_Start',
        'training_End',
        'training_Status',
    ];

    protected $casts = [
        'training_Start' => 'date',
        'training_End' => 'date',
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
            'training_id' => 'Training ID',
            'employee_id' => 'Employee ID',
            'training_Name' => 'Training Name',
            'training_From' => 'Training From',
            'training_Cert' => 'Training Certificate',
            'training_Start' => 'Training Start Date',
            'training_End' => 'Training End Date',
            'training_Status' => 'Training Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
