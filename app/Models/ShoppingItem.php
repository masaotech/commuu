<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingItem extends Model
{
    /** @use HasFactory<\Database\Factories\ShoppingItemFactory> */
    use HasFactory;

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
