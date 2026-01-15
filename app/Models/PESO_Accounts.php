<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PESO_Accounts extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'peso_accounts';
    protected $primaryKey = 'peso_accounts_id';

    protected $fillable = [
        'peso_id',
        'user_id',
        'peso_accounts_Fname',
        'peso_accounts_Mname',
        'peso_accounts_Lname',
        'peso_accounts_Pnumber',
        'municipality_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function peso()
    {
        return $this->belongsTo(PESO::class, 'peso_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function job_posting()
    {
        return $this->hasMany(Job_Posting::class, 'peso_accounts_id');
    }

    public static function fieldMappings()
    {
        return [
            'peso_accounts_id' => 'PESO Account ID',
            'peso_id' => 'PESO Branch ID',
            'user_id' => 'User ID',
            'peso_accounts_Pnumber' => 'PESO Phone Number',
            'peso_accounts_Fname' => 'PESO First Name',
            'peso_accounts_Mname' => 'PESO Middle Name',
            'peso_accounts_Lname' => 'PESO Last Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

}
