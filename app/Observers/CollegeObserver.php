<?php

namespace App\Observers;

use App\Models\College;
use Illuminate\Support\Facades\DB;

class CollegeObserver
{
    /**
     * Handle the College "deleted" event.
     * 
     * This will reset the auto-increment counter to the next available ID
     * after a college has been deleted.
     *
     * @param  \App\Models\College  $college
     * @return void
     */
    public function deleted(College $college)
    {
        // Get the highest existing ID
        $maxId = College::max('college_id');
        
        // If there are no records left, reset to 1
        // Otherwise set to max ID + 1
        $newAutoIncrement = $maxId ? $maxId + 1 : 1;
        
        // Reset the auto-increment value
        DB::statement("ALTER TABLE colleges AUTO_INCREMENT = {$newAutoIncrement}");
    }
} 