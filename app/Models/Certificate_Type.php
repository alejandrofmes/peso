<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Certificate_Type extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'certificate_type';
    protected $primaryKey = 'cert_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cert_Name',
        'cert_Code',
        'cert_Status',
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
    public function certificate()
    {
        return $this->hasMany(Certificate::class, 'cert_type_id');
    }

    public static function fieldMappings()
    {
        return [
            'cert_type_id' => 'Certificate Type ID',
            'cert_Name' => 'Certificate Name',
            'cert_Code' => 'Certificate Code',
            'cert_Status' => 'Certificate Status',
        ];
    }

}
