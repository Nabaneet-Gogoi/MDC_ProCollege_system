<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class BillProgress extends Model
{
    use HasFactory, Auditable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bill_progress';
    
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
        'bill_id',
        'college_id',
        'completion_percent',
        'category_id',
        'progress_status',
        'description',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'completion_percent' => 'decimal:2',
    ];
    
    /**
     * Get the bill associated with this progress record.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'bill_id');
    }
    
    /**
     * Get the college associated with this progress record.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }
    
    /**
     * Get the work category associated with this progress record.
     */
    public function category()
    {
        return $this->belongsTo(WorkCategory::class, 'category_id', 'category_id');
    }
    
    /**
     * Get the progress status options for dropdown.
     *
     * @return array
     */
    public static function getStatusOptions()
    {
        return [
            'not_started' => 'Not Started',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
        ];
    }

    /**
     * Get related physical progress records for the same category and college.
     */
    public function relatedPhysicalProgress()
    {
        return PhysicalProgress::where('college_id', $this->bill->college_id)
            ->where('category_id', $this->category_id)
            ->latest('report_date')
            ->get();
    }
}
