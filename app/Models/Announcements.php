<?php

namespace App\Models;

use App\Redactors\LimiterRedactor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Mews\Purifier\Casts\CleanHtml;

class Announcements extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory, SoftDeletes;

    protected $attributeModifiers = [
        'announcement_Content' => LimiterRedactor::class,
    ];

    protected $table = 'announcements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'announcement_id';

    protected $fillable = [
        'announcement_Title',
        'announcement_Content',
        'announcement_pubmat',
        'announcement_Status',
        'peso_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'announcement_Content' => CleanHtml::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function peso()
    {
        return $this->belongsTo(PESO::class, 'peso_id');
    }

    public static function fieldMappings()
    {
        return [
            'announcement_Title' => 'Announcement Title', //spelling
            'announcement_Content' => 'Announcement Content',
            'announcement_pubmat' => 'Announcement Publication Material',
            'announcement_Status' => 'Announcement Status',
            'peso_id' => 'PESO Branch ID',
        ];
    }

}
