<?php

namespace App\Models;

use App\Redactors\LimiterRedactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Mews\Purifier\Casts\CleanHtml;

class Programs extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $attributeModifiers = [
        'program_Description' => LimiterRedactor::class,
        'program_Qualification' => LimiterRedactor::class,
        'program_Remarks' => LimiterRedactor::class,
    ];

    protected $table = 'programs';
    protected $primaryKey = 'program_id';

    protected $fillable = [
        'program_Title',
        'program_Modality',
        'program_Type',
        'program_Host',
        'program_Slots',
        'industry_id',
        'program_Datetime',
        'program_Deadline',
        'program_Location',
        'program_Description',
        'program_Qualification',
        'program_Remarks',
        'program_Status',
        'program_pubmat',
        'program_Status',
        'peso_id',
    ];

    protected $casts = [
        'program_Description' => CleanHtml::class,
        'program_Qualification' => CleanHtml::class,
        'program_Remarks' => CleanHtml::class,
        'program_Datetime' => 'datetime',
        'program_Deadline' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function job_industry()
    {
        return $this->belongsTo(Job_Industry::class, 'industry_id');
    }
    public function peso()
    {
        return $this->belongsTo(PESO::class, 'peso_id');
    }

    public function program_reg()
    {
        return $this->hasMany(Program_Reg::class, 'program_id');
    }
    public function program_tags()
    {
        return $this->hasMany(Program_Tags::class, 'program_id');
    }

    public function attendedJobseekers()
    {
        return $this->hasMany(Program_Reg::class, 'program_id')
            ->where('program_reg_Status', 'COMPLETED');
    }

    public static function fieldMappings()
    {
        return [
            'program_id' => 'Program ID',
            'program_Title' => 'Program Title',
            'program_Modality' => 'Program Modality',
            'program_Type' => 'Program Type',
            'program_Host' => 'Program Host',
            'program_Slots' => 'Program Slots',
            'industry_id' => 'Industry ID',
            'program_Datetime' => 'Program Datetime',
            'program_Deadline' => 'Program Deadline',
            'program_Location' => 'Program Location',
            'program_Description' => 'Program Description',
            'program_Qualification' => 'Program Qualification',
            'program_Remarks' => 'Program Remarks',
            'program_Status' => 'Program Status',
            'program_pubmat' => 'Program Publication Material',
            'peso_id' => 'PESO Branch ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
