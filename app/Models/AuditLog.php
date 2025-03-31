<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'action',
        'model_type',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    /**
     * Get the admin that performed the action.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    /**
     * Scope a query to only include logs for a specific model.
     */
    public function scopeForModel($query, string $modelType, int $modelId)
    {
        return $query->where('model_type', $modelType)
                    ->where('model_id', $modelId);
    }

    /**
     * Scope a query to only include logs for a specific action.
     */
    public function scopeForAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to only include logs performed by a specific admin.
     */
    public function scopeByAdmin($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }
}
