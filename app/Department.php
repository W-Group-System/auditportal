<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Department extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
    public function dep_head()
    {
        return $this->hasOne(DepartmentHead::class);
    }
}
