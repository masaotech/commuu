<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    public function groupUsers()
    {
        return $this->hasMany(GroupUser::class, 'user_role_id');
    }
}
