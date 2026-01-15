<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Eligibility_Type extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'eligibility_type';
    protected $primaryKey = 'eligibility_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'eligibility_Name',
        'eligibility_Code',
        'eligibility_Status',
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

    public function job_posting()
    {
        return $this->hasMany(Eligibility::class, 'eligibility_id');
    }

    public static function fieldMappings()
    {
        return [
            'eligibility_type_id' => 'Eligibility Type ID',
            'eligibility_Name' => 'Eligibility Name',
            'eligibility_Code' => 'Eligibility Code',
            'eligibility_Status' => 'Eligibility Status',
        ];
    }

}
