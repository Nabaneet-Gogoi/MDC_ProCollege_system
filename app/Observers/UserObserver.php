<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     * 
     * This will reset the auto-increment counter to the next available ID
     * after a user has been deleted.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // Get the highest existing ID
        $maxId = User::max('user_id');
        
        // If there are no records left, reset to 1
        // Otherwise set to max ID + 1
        $newAutoIncrement = $maxId ? $maxId + 1 : 1;
        
        // Reset the auto-increment value
        DB::statement("ALTER TABLE users AUTO_INCREMENT = {$newAutoIncrement}");
    }
} 