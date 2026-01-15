<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Partnerships extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'partnerships';
    protected $primaryKey = 'partnership_id';

    protected $fillable = [
        'peso_id',
        'company_id',
        'partnership_Status',
        'partnership_Remarks',
        'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function peso()
    {
        return $this->belongsTo(PESO::class, 'peso_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public static function fieldMappings()
    {
        return [
            'partnership_id' => 'Partnership ID',
            'peso_id' => 'PESO Branch ID',
            'company_id' => 'Company ID',
            'partnership_Status' => 'Partnership Status',
            'partnership_Remarks' => 'PESO Remarks',
            'responded_at' => 'Responded At',
        ];
    }

}
