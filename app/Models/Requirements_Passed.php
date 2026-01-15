<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Requirements_Passed extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'requirements_passed';
    protected $primaryKey = 'req_passed_id';

    protected $fillable = [
        'company_id',
        'requirement_id',
        'req_passed_Input',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirements::class, 'requirement_id');
    }

    public static function fieldMappings()
    {
        return [
            'req_passed_id' => 'Requirement Passed ID',
            'company_id' => 'Company ID',
            'requirement_id' => 'Requirement ID',
            'req_passed_Input' => 'Requirement Passed Input',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
