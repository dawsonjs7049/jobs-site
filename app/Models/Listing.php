<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    public function scopeFilter($query, array $filters)
    {
        // if there is a tag, do this, else ignore this block
        if($filters['tag'] ?? false)
        {
            // % is the wildcard, anything before or after is OK
            $query->where('tags', 'like', '%' . $filters['tag'] . '%');
        }

        // if there is a search term (someone pressed the search button, do this, else ignore this block)
        if($filters['search'] ?? false)
        {
            // % is the wildcard, anything before or after is OK
            $query->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('company', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('tags', 'like', '%' . $filters['search'] . '%');
        }
    }
}
