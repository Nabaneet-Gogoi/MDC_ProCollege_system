<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bills';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'bill_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'college_id',
        'funding_id',
        'user_id',
        'bill_no',
        'bill_amt',
        'bill_date',
        'bill_status',
        'description',
        'admin_remarks',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'bill_date' => 'date',
        'bill_amt' => 'decimal:2',
    ];
    
    /**
     * Get the college associated with this bill.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }
    
    /**
     * Get the funding associated with this bill.
     */
    public function funding()
    {
        return $this->belongsTo(Funding::class, 'funding_id', 'funding_id');
    }
    
    /**
     * Get the user who submitted this bill.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    /**
     * Get the progress records for this bill.
     */
    public function progress()
    {
        return $this->hasMany(BillProgress::class, 'bill_id', 'bill_id');
    }
    
    /**
     * Get the payments associated with this bill.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'bill_id', 'bill_id');
    }
    
    /**
     * Get the status options for dropdown
     */
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'paid' => 'Paid',
        ];
    }
    
    /**
     * Generate a unique bill number.
     *
     * @param int $collegeId
     * @return string
     */
    public static function generateBillNumber($collegeId)
    {
        $college = College::find($collegeId);
        if (!$college) {
            return 'BILL-' . now()->format('YmdHis');
        }
        
        $prefix = substr(strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $college->college_name)), 0, 3);
        $count = self::where('college_id', $collegeId)->count() + 1;
        
        return $prefix . '-BILL-' . str_pad($count, 4, '0', STR_PAD_LEFT) . '-' . now()->format('Ymd');
    }
}
