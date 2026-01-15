<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Job_Industry extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'job_industry';
    protected $primaryKey = 'industry_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'industry_Title',
        'industry_Code',
        'industry_Status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    public function industry_preference()
    {
        return $this->hasMany(Industry_preference::class, 'industry_id');
    }

    public function company_industry_line()
    {
        return $this->hasMany(Company_Industry_Line::class, 'industry_id');
    }
    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'industry_id');
    }

    public static function fieldMappings()
{
    return [
        'industry_id' => 'Industry ID',
        'industry_Title' => 'Industry Title',
        'industry_Code' => 'Industry Code',
        'industry_Status' => 'Industry Status',
    ];
}

}
