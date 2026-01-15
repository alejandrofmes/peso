<?php

namespace App\Models;

use OwenIt\Auditing\Models\Audit as BaseAudit;

class CustomAudit extends BaseAudit
{
    /**
     * Additional fields you might want to add.
     *
     * @var array
     */
    protected $fillable = [
        'auditable_type',
        'auditable_id',
        'user_id',
        'event',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags',
        'created_at',
        'updated_at',
    ];

    /**
     * Custom accessor for the audit event.
     */
    public function getEventAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * You can also add methods to manipulate or format audit data as needed.
     */
    public function someCustomMethod()
    {
        // Custom logic here
    }
}
