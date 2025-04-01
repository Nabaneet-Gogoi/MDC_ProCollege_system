<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Release extends Model
{
    use HasFactory, Auditable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'releases';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'release_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'release_amt',
        'release_date',
        'funding_id',
        'desc',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
        'release_amt' => 'decimal:2',
    ];
    
    /**
     * Get the funding that this release is associated with.
     */
    public function funding()
    {
        return $this->belongsTo(Funding::class, 'funding_id', 'funding_id');
    }
    
    /**
     * Get the college associated with this release through the funding.
     */
    public function college()
    {
        return $this->hasOneThrough(
            College::class,
            Funding::class,
            'funding_id', // Foreign key on the fundings table...
            'college_id', // Foreign key on the colleges table...
            'funding_id', // Local key on the releases table...
            'college_id'  // Local key on the fundings table...
        );
    }
}
