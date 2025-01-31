<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HabitItem extends Model
{
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
    public function habitCycle()
    {
        return $this->belongsTo(HabitCycle::class);
    }
    public function habitSchedules()
    {
        return $this->hasMany(HabitSchedule::class, 'habit_item_id');
    }
}
