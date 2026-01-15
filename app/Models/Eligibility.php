<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Eligibility extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'eligibility';
    protected $primaryKey = 'eligibility_id';

    protected $fillable = [
        'employee_id',
        'eligibility_Type',
        'eligibility_Date',
    ];

    protected $casts = [
        'eligibility_Date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function eligibility_type()
    {
        return $this->belongsTo(Eligibility_Type::class, 'eligibility_Type');
    }


    public static function fieldMappings()
{
    return [
        'eligibility_id' => 'Eligibility ID',
        'employee_id' => 'Employee ID',
        'eligibility_Type' => 'Eligibility Type ID',
        'eligibility_Date' => 'Eligibility Date',
    ];
}

}
