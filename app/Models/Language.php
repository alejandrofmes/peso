<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Language extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'language';
    protected $primaryKey = 'language_id';

    protected $fillable = [
        'employee_id',
        'language_Type',
        'language_Read',
        'language_Write',
        'language_Speak',
        'language_Understand',
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
        'language_id' => 'Language ID',
        'employee_id' => 'Employee ID',
        'language_Type' => 'Language Type',
        'language_Read' => 'Read',
        'language_Write' => 'Write',
        'language_Speak' => 'Speak',
        'language_Understand' => 'Understand',
    ];
}

}
