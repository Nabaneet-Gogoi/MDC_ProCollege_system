<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funding extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fundings';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'funding_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'college_id',
        'approved_amt',
        'central_share',
        'state_share',
        'utilization_status',
    ];
    
    /**
     * Get the college that owns the funding.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }
    
    /**
     * Get the releases for this funding.
     */
    public function releases()
    {
        return $this->hasMany(Release::class, 'funding_id', 'funding_id');
    }
    
    /**
     * Get the total amount released for this funding.
     * 
     * @return float
     */
    public function getTotalReleasedAttribute()
    {
        return $this->releases()->sum('release_amt');
    }
    
    /**
     * Get the remaining balance for this funding.
     * 
     * @return float
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->approved_amt - $this->total_released;
    }
    
    /**
     * Get the percentage of funds utilized.
     * 
     * @return float
     */
    public function getUtilizationPercentageAttribute()
    {
        if ($this->approved_amt <= 0) {
            return 0;
        }
        
        return ($this->total_released / $this->approved_amt) * 100;
    }
    
    /**
     * Calculate and set the funding amounts based on college type and phase.
     * 
     * MDC Phase 1: 8 crores (50:50)
     * MDC Phase 2: 12 crores (90:10)
     * Professional: 26 crores (90:10)
     * 
     * @param College $college
     * @return array
     */
    public static function calculateFundingForCollege(College $college)
    {
        $approvedAmount = 0;
        $centralShare = 0;
        $stateShare = 0;
        
        if ($college->type === 'MDC') {
            if ($college->phase === '1') {
                $approvedAmount = 8.00;
                $centralShare = $approvedAmount * 0.5; // 50%
                $stateShare = $approvedAmount * 0.5;   // 50%
            } else { // Phase 2
                $approvedAmount = 12.00;
                $centralShare = $approvedAmount * 0.9; // 90%
                $stateShare = $approvedAmount * 0.1;   // 10%
            }
        } else { // Professional
            $approvedAmount = 26.00;
            $centralShare = $approvedAmount * 0.9; // 90%
            $stateShare = $approvedAmount * 0.1;   // 10%
        }
        
        return [
            'approved_amt' => $approvedAmount,
            'central_share' => $centralShare,
            'state_share' => $stateShare
        ];
    }
}
