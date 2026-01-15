<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class License extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'license';
    protected $primaryKey = 'license_id';

    protected $fillable = [
        'employee_id',
        'license_type_id',
        'license_Validity',
    ];

    protected $casts = [
        'license_Validity' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function license_type()
    {
        return $this->belongsTo(License_Type::class, 'license_type_id');
    }

    public static function fieldMappings()
    {
        return [
            'license_id' => 'License ID',
            'employee_id' => 'Employee ID',
            'license_type_id' => 'License Type ID',
            'license_Validity' => 'License Validity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
