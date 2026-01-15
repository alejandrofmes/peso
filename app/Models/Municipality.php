<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Municipality extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'municipality';
    protected $primaryKey = 'municipality_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'province_id',
        'municipality_Name',
        'municipality_Code',
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

    /**
     * Get the province that owns the municipality.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }
    public function barangay()
    {
        return $this->hasMany(Barangay::class, 'municipality_id');
    }
    public function peso()
    {
        return $this->hasMany(PESO::class, 'municipality_id');
    }
    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'municipality_id');
    }
    public function programs()
    {
        return $this->hasMany(Programs::class, 'municipality_id');
    }

    public static function fieldMappings()
    {
        return [
            'municipality_id' => 'Municipality ID',
            'province_id' => 'Province ID',
            'municipality_Name' => 'Municipality Name',
            'municipality_Code' => 'Municipality Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
