<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Requirements extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'requirements';
    protected $primaryKey = 'requirement_id';

    protected $fillable = [
        'requirement_Title',
        'requirement_Status',
        'requirement_Type',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function requirements_passed()
    {
        return $this->hasMany(Requirements_Passed::class, 'requirement_id');
    }

    public function requirementPassed()
    {
        return $this->hasOne(Requirements_Passed::class, 'requirement_id', 'requirement_id');
    }

    public static function fieldMappings()
    {
        return [
            'requirement_id' => 'Requirement ID',
            'requirement_Title' => 'Requirement Title',
            'requirement_Status' => 'Requirement Status',
            'requirement_Type' => 'Requirement Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
