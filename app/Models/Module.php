<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function module_versions()
    {
        return $this->hasMany(ModuleVersion::class,'module_id','id');
    }
}
