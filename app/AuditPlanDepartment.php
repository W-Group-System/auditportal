<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
class AuditPlanDepartment extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
}
