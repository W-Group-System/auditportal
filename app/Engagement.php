<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Engagement extends Model implements Auditable
{
    
    //
    use \OwenIt\Auditing\Auditable;

    public function department(){

        return $this->hasOne(EngagementDepartment::class);
    }
    public function auditor_data(){

        return $this->hasOne(EngagementAuditor::class);
    }
    public function findings(){
        return $this->hasMany(EngagementObservation::class);
    }

    public function action_plans()
    {
        return $this->hasMany(ActionPlan::class);
    }
    public function procedures()
    {
        return $this->hasMany(EngagementProcedure::class);
    }
    public function objectives()
    {
        return $this->hasMany(EngagementObjective::class);
    }
    public function companies()
    {
        return $this->hasMany(EngagementCompany::class);
    }
}
