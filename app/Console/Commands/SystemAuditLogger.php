<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Services\AuditLogService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class SystemAuditLogger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:log
                            {model : The model class name (e.g., App\\Models\\College)}
                            {model_id : The ID of the model}
                            {action : The action being performed (e.g., backup, export, import)}
                            {description : Description of the action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log system operations for audit tracking';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelClass = $this->argument('model');
        $modelId = $this->argument('model_id');
        $action = $this->argument('action');
        $description = $this->argument('description');
        
        try {
            // Check if model class exists
            if (!class_exists($modelClass)) {
                $this->error("Model class {$modelClass} does not exist");
                return 1;
            }
            
            // Find the model
            $model = $modelClass::find($modelId);
            
            if (!$model instanceof Model) {
                $this->error("No {$modelClass} found with ID {$modelId}");
                return 1;
            }
            
            // Log the action
            AuditLogService::logCustomAction(
                $action,
                $model,
                $description,
                null,
                ['system_initiated' => true, 'command' => 'system:log']
            );
            
            $this->info("System action '{$action}' logged successfully");
            return 0;
            
        } catch (\Exception $e) {
            $this->error("Error logging system action: {$e->getMessage()}");
            return 1;
        }
    }
} 