<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
class AuditPlanDepartment extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;

    public function department_name()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }
    public function user_name()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
