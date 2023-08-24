<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class ConfigEngagement extends Model implements Auditable
{
    
    //
    use \OwenIt\Auditing\Auditable;
}
