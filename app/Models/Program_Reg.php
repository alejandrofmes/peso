<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Program_Reg extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'program_reg';
    protected $primaryKey = 'program_reg_id';

    protected $fillable = [
        'employee_id',
        'program_id',
        'program_reg_Status',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function programs()
    {
        return $this->belongsTo(Programs::class, 'program_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public static function fieldMappings()
    {
        return [
            'program_reg_id' => 'Program Registration ID',
            'employee_id' => 'Employee ID',
            'program_id' => 'Program ID',
            'program_reg_Status' => 'Program Registration Status',
            'responded_at' => 'Responded At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
