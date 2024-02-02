<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentGroup extends Model
{
    //

    public function dep()
    {
        return $this->hasMany(DepartmentGroup::class,'name','name');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
