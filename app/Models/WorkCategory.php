<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkCategory extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_categories';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'category_id';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_name',
        'description',
        'is_active',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Get the bill progress records associated with this category.
     */
    public function billProgress()
    {
        return $this->hasMany(BillProgress::class, 'category_id', 'category_id');
    }
    
    /**
     * Get the physical progress reports for this category.
     */
    public function physicalProgress()
    {
        return $this->hasMany(PhysicalProgress::class, 'category_id', 'category_id');
    }
    
    /**
     * Get active categories for dropdown lists.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getActiveCategories()
    {
        return self::where('is_active', true)->orderBy('category_name')->get();
    }
    
    /**
     * Get categories as array for dropdown.
     *
     * @return array
     */
    public static function getCategoriesForDropdown()
    {
        return self::where('is_active', true)
            ->orderBy('category_name')
            ->pluck('category_name', 'category_id')
            ->toArray();
    }
}
