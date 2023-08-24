<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class EngagementCompany extends Model implements Auditable
{
    
    //
    use \OwenIt\Auditing\Auditable;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
