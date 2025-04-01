<?php

namespace App\Traits;

use App\Services\AuditLogService;
use Illuminate\Database\Eloquent\Model;

trait Auditable
{
    /**
     * Boot the trait.
     * 
     * @return void
     */
    public static function bootAuditable()
    {
        // Log model creation
        static::created(function (Model $model) {
            AuditLogService::logCreation($model);
        });

        // Log model updates
        static::updated(function (Model $model) {
            $oldValues = $model->getOriginal();
            AuditLogService::logUpdate($model, $oldValues);
        });

        // Log model deletion
        static::deleted(function (Model $model) {
            AuditLogService::logDeletion($model);
        });
    }
} 