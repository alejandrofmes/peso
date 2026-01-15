<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experimental_Features extends Model
{
    use HasFactory;

    protected $table = 'experimental_features';
    protected $primaryKey = 'feature_id';

    protected $fillable = [
        'feature_Name',
        'feature_Status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function fieldMappings()
    {
        return [
            'feature_Name' => 'Feature Name',
            'feature_Status' => 'Feature Status',
        ];
    }

}
