<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitCycle extends Model
{
    public function habitItems()
    {
        return $this->hasMany(HabitItem::class, 'habit_cycle_id');
    }
}
