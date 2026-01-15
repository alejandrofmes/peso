<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PESO extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'peso';
    protected $primaryKey = 'peso_id';

    protected $fillable = [
        'peso_Description',
        'peso_Email',
        'peso_Phone',
        'peso_Tel',
        'peso_Fax',
        'peso_Img',
        'municipality_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id');
    }
    public function peso_accounts()
    {
        return $this->hasMany(PESO_Accounts::class, 'peso_id');
    }

    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'peso_id');
    }

    public function partnerships()
    {
        return $this->hasMany(Partnerships::class, 'peso_id');
    }

    public static function fieldMappings()
    {
        return [
            'peso_id' => 'PESO BRANCH ID',
            'municipality_id' => 'Municipality ID',
            'peso_Description' => 'PESO Branch Description',
            'peso_Email' => 'PESO Branch Email',
            'peso_Phone' => 'PESO Branch Phone Number',
            'peso_Tel' => 'PESO Branch Telephone Number',
            'peso_Fax' => 'PESO Branch Fax Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
