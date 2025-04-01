<?php

use Illuminate\Support\Facades\Schema;

/**
 * Check if a column exists in a table
 *
 * @param string $table
 * @param string $column
 * @return bool
 */
if (!function_exists('schema_has_column')) {
    function schema_has_column($table, $column)
    {
        return Schema::hasColumn($table, $column);
    }
} 