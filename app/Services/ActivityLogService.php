<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogService
{
    /**
     * Log an activity.
     *
     * @param string $action
     * @param string|null $modelType
     * @param int|null $modelId
     * @param string|null $description
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return \App\Models\ActivityLog
     */
    public static function log($action, $modelType = null, $modelId = null, $description = null, $oldValues = null, $newValues = null)
    {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}