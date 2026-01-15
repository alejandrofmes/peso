<?php

namespace App\Services;

use App\Models\CustomAudit;

class CustomAuditLogger
{
    /**
     * Log a custom audit record.
     *
     * @param string $modelType
     * @param int $modelId
     * @param string $event
     * @param array $oldValues
     * @param array $newValues
     * @param int|null $userId
     * @return void
     */
    public static function log($modelType, $modelId, $event, $oldValues = [], $newValues = [], $userId = null)
    {
        // Convert arrays to JSON strings without extra escaping
        $oldValuesJson = json_encode($oldValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $newValuesJson = json_encode($newValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        CustomAudit::create([
            'auditable_type' => $modelType,
            'auditable_id' => $modelId,
            'user_id' => $userId ?? 0, // Default to a system user ID if not provided
            'event' => $event,
            'old_values' => json_decode($oldValuesJson),
            'new_values' => json_decode($newValuesJson),
            'url' => url()->current(), // Example: use current URL
            'ip_address' => request()->ip(), // Example: use request IP address
            'agent' => request()->header('User-Agent'), // Example: use request User-Agent
        ]);
    }
}
