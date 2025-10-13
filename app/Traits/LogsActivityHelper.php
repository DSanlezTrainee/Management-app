<?php

namespace App\Traits;

trait LogsActivityHelper
{
    /**
     * Log activity helper
     */
    protected function logActivity($action, $model = null)
    {
        $logger = activity()->causedBy(\Illuminate\Support\Facades\Auth::user());
        if ($model) {
            $logger = $logger->performedOn($model);
        }
        $logger->withProperties([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ])->log($action);
    }
}
