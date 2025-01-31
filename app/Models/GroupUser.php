<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
// class GroupUser extends Model
class GroupUser  extends Pivot
{
    protected $table = 'group_user';

    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
