<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalProgress extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'physical_progress';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'progress_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'college_id',
        'funding_id',
        'category_id',
        'report_date',
        'completion_percent',
        'progress_status',
        'description',
        'reported_by',
        'verified_by',
        'verification_date',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'report_date' => 'date',
        'verification_date' => 'date',
        'completion_percent' => 'decimal:2',
    ];
    
    /**
     * Get the college associated with this progress.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }
    
    /**
     * Get the funding associated with this progress.
     */
    public function funding()
    {
        return $this->belongsTo(Funding::class, 'funding_id', 'funding_id');
    }
    
    /**
     * Get the work category for this progress.
     */
    public function category()
    {
        return $this->belongsTo(WorkCategory::class, 'category_id', 'category_id');
    }
    
    /**
     * Get progress status options for dropdown
     */
    public static function getStatusOptions()
    {
        return [
            'not_started' => 'Not Started',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
        ];
    }
}
