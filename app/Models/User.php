<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Auditable;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'college_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the college associated with the user.
     * Returns null for RUSA users who aren't associated with a specific college.
     */
    public function college()
    {
        return $this->belongsTo(College::class, 'college_id', 'college_id');
    }

    /**
     * Check if the user is a college user.
     *
     * @return bool
     */
    public function isCollegeUser(): bool
    {
        return $this->role === 'college';
    }

    /**
     * Check if the user is a RUSA user.
     *
     * @return bool
     */
    public function isRUSAUser(): bool
    {
        return $this->role === 'RUSA';
    }
}
