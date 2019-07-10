<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleVersion extends Model
{
    public function module()
    {
        return $this->belongsTo(Module::class,'module_id','id');
    }
}
