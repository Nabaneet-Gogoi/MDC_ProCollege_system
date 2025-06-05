<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable;

class Admin extends Authenticatable
{
    use Notifiable, Auditable;

    /**
     * The table associated with the model.
     * Specify this if your table name isn't the plural of the model name.
     */
    protected $table = 'admins';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'admin_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    /**
     * Automatically hash the password when it's set.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Indicates if the model should be timestamped.
     * Set to true to add created_at and updated_at columns.
     *
     * @var bool
     */
    public $timestamps = true;
}
