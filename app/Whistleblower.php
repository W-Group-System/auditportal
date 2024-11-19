<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Whistleblower extends Model
{
    //
    public function attachments()
    {
        return $this->hasMany(WhistleblowerAttachment::class);
    }
}
