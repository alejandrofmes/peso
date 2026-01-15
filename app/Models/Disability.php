<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Disability extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'disability';  
    protected $primaryKey = 'disability_id';

    protected $fillable = [
        'employee_id',
        'disability_Type',
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

    public static function fieldMappings()
{
    return [
        'disability_id' => 'Disability ID',
        'employee_id' => 'Employee ID',
        'disability_Type' => 'Disability Type',
    ];
}

}
