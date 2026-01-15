<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Certificate extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    protected $table = 'certificate';
    protected $primaryKey = 'cert_id';

    protected $fillable = [
        'employee_id',
        'cert_Type_id',
        'cert_From',
        'cert_Date_Issued',
        'cert_Rating',
    ];

    protected $casts = [
        'cert_Date_Issued' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function certificateType()
    {
        return $this->belongsTo(Certificate_Type::class, 'cert_Type_id');
    }

    public static function fieldMappings()
{
    return [
        'cert_id' => 'Certificate ID',
        'employee_id' => 'Employee ID',
        'cert_Type_id' => 'Certificate Type ID',
        'cert_From' => 'Certificate From',
        'cert_Date_Issued' => 'Date Issued',
        'cert_Rating' => 'Certificate Rating',
    ];
}

}