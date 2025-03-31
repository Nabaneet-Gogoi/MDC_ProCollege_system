<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogService
{
    /**
     * Log an action performed on a model.
     *
     * @param string $action The action performed (create, update, delete, etc.)
     * @param Model $model The model being acted upon
     * @param string $description A human-readable description of the action
     * @param array|null $oldValues The old values (for updates)
     * @param array|null $newValues The new values (for creates/updates)
     * @return AuditLog The created audit log entry
     */
    public static function log(
        string $action, 
        Model $model, 
        string $description, 
        array $oldValues = null, 
        array $newValues = null
    ): AuditLog {
        $admin = Auth::guard('admin')->user();
        
        return AuditLog::create([
            'admin_id' => $admin ? $admin->admin_id : null,
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
    
    /**
     * Log a model creation.
     *
     * @param Model $model The created model
     * @param string|null $description Custom description (optional)
     * @return AuditLog
     */
    public static function logCreation(Model $model, string $description = null): AuditLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} created";
        
        return self::log(
            'create',
            $model,
            $description,
            null,
            $model->toArray()
        );
    }
    
    /**
     * Log a model update.
     *
     * @param Model $model The updated model
     * @param array $oldValues The old values
     * @param string|null $description Custom description (optional)
     * @return AuditLog
     */
    public static function logUpdate(Model $model, array $oldValues, string $description = null): AuditLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} updated";
        
        return self::log(
            'update',
            $model,
            $description,
            $oldValues,
            $model->toArray()
        );
    }
    
    /**
     * Log a model deletion.
     *
     * @param Model $model The deleted model
     * @param string|null $description Custom description (optional)
     * @return AuditLog
     */
    public static function logDeletion(Model $model, string $description = null): AuditLog
    {
        $modelName = class_basename($model);
        $description = $description ?? "{$modelName} deleted";
        
        return self::log(
            'delete',
            $model,
            $description,
            $model->toArray(),
            null
        );
    }
    
    /**
     * Log a custom action.
     *
     * @param string $action The action name
     * @param Model $model The related model
     * @param string $description A description of the action
     * @param array|null $oldValues Old values if applicable
     * @param array|null $newValues New values if applicable
     * @return AuditLog
     */
    public static function logCustomAction(
        string $action,
        Model $model,
        string $description,
        array $oldValues = null,
        array $newValues = null
    ): AuditLog {
        return self::log($action, $model, $description, $oldValues, $newValues);
    }
} 