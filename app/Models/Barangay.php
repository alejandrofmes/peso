<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Barangay extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    protected $table = 'barangay';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'barangay_id';

    protected $fillable = [
        'municipality_id',
        'barangay_Name',
        'barangay_Code',
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
     * Get the municipality that owns the barangay.
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'barangay_id');
    }
    public function employee()
    {
        return $this->hasMany(Employee::class, 'barangay_id');
    }

    public static function fieldMappings()
    {
        return [
            'barangay_id' => 'Barangay ID',
            'municipality_id' => 'Municipality ID',
            'barangay_Name' => 'Barangay Name',
            'barangay_Code' => 'Barangay Code',
        ];
    }

}
