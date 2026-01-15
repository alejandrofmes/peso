<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Job_Positions extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'job_positions';
    protected $primaryKey = 'position_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'position_Title',
        'position_Code',
        'position_Status',

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
    public function job_preference()
    {
        return $this->hasMany(Job_Preference::class, 'position_id');
    }
    public function job_tags()
    {
        return $this->hasMany(Job_Tags::class, 'position_id');
    }

    public static function fieldMappings()
{
    return [
        'position_id' => 'Position ID',
        'position_Title' => 'Position Title',
        'position_Code' => 'Position Code',
        'position_Status' => 'Position Status',
    ];
}

}
