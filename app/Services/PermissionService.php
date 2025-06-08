<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class PermissionService
{
    public function checkPermission(string $action, string $modelName)
    {
        $permission = strtolower($modelName) . '.' . $action;

        if (!Auth::user()->can($permission)) {
            abort(403, 'Bu əməliyyatı yerinə yetirməyə icazəniz yoxdur.');
        }
    }
}
