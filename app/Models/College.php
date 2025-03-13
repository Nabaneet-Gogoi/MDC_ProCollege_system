<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'college_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'college_name',
        'state',
        'district',
        'type',
        'phase',
    ];

    /**
     * Get college type options for dropdown.
     *
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            'professional' => 'Professional College',
            'MDC' => 'Model Degree College (MDC)',
        ];
    }

    /**
     * Get college phase options for dropdown.
     *
     * @return array
     */
    public static function getPhaseOptions()
    {
        return [
            '1' => 'Phase 1',
            '2' => 'Phase 2',
        ];
    }

    /**
     * Get the users associated with this college.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'college_id', 'college_id');
    }
}
