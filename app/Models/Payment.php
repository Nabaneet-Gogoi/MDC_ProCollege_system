<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bill_id',
        'payment_amt',
        'payment_date',
        'payment_status',
        'transaction_reference',
        'remarks',
        'admin_remarks',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'date',
        'payment_amt' => 'decimal:2',
    ];
    
    /**
     * Get the bill associated with this payment.
     */
    public function bill()
    {
        return $this->belongsTo(Bill::class, 'bill_id', 'bill_id');
    }
    
    /**
     * Get the status options for dropdown
     */
    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'processed' => 'Processed',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
        ];
    }
} 