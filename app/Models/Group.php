<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\GroupFactory> */
    use HasFactory;

    public function users(): BelongsToMany
    {
        // [参考サイト] https://blog.shonansurvivors.com/entry/laravel-pivot
        return $this->belongsToMany(User::class)
            ->withPivot('user_role_id')
            ->using(GroupUser::class);
    }

    public function groupUsers()
    {
        return $this->hasMany(GroupUser::class, 'group_id');
    }

    public function ShoppingItems()
    {
        return $this->hasMany(ShoppingItem::class, 'group_id');
    }

    public function HabitItems()
    {
        return $this->hasMany(HabitItem::class, 'group_id');
    }
}
