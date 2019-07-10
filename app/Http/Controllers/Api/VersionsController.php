<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ModuleVersion;

class VersionsController extends Controller
{
    public function getVersion(Request $request)
    {
        $app_type=$request->app_type;

        switch ($app_type){
            case 'module':
                return $this->moduleVersions($request->app_identifier);
                break;
            case 'system':
                break;
        }
    }

    protected function moduleVersions($identifier='')
    {
        $current_version=ModuleVersion::where('identifier',$identifier)->first();

        if($current_version){
            $module_id=$current_version->module_id;
            $data=ModuleVersion::where([
                'is_show'=>1,
                'module_id'=>$module_id,
            ])->where('identifier','>',$identifier)->get();

            return $this->response->array([
                'code'=>1,
                'msg'=>'',
                'data'=>$this->data_format($data)
            ]);
        }else{
            return $this->response->array([
                'code'=>0,
                'msg'=>'未找到相关版本'
            ]);
        }

    }

    protected function data_format($data)
    {
        $arr=[];

        foreach ($data as $k=>$v){
            $arr[$v->version]['version']=$v->version;
            $arr[$v->version]['log']=explode('&&',$v->introduction);
            $arr[$v->version]['file_path']=$v->file_path;
            $arr[$v->version]['frame_version']=$v->frame_version;
            $arr[$v->version]['condition']='框架最低版本'.$v->frame_version;
        }

        return $arr;
    }
}
