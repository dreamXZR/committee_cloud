<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Module;

class ModuleTransformer extends TransformerAbstract
{
    public function transform(Module $module)
    {
        return [
            'id'=>$module->id,
            'module_name'=>$module->module_name,
            'alias'=>$module->alias,
            'intro'=>$module->introduction,
            'module_identifier'=>$module->identifier,
            'last_branch'=>$module->module_versions()->where('is_show',1)->orderBy('id','desc')->first()
        ];
    }
}