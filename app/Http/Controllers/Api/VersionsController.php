<?php

namespace App\Http\Controllers\Api;

use App\Models\SystemVersion;
use Illuminate\Http\Request;
use App\Models\ModuleVersion;

class VersionsController extends Controller
{
    public function getVersion(Request $request)
    {
        $app_type=$request->app_type;

        switch ($app_type){
            case 'module':
                return $this->moduleVersions($request->app_identifier,$request->version);
                break;
            case 'system':
                return $this->systemVersions($request->app_identifier);
                break;
        }
    }

    protected function moduleVersions($identifier='',$version='')
    {
        $current_version=ModuleVersion::where([
            'identifier'=>$identifier,
            'version'=>$version
        ])->first();

        if($current_version){
            $module_id=$current_version->module_id;
            $data=ModuleVersion::where([
                'is_show'=>1,
                'module_id'=>$module_id,
            ])->where('id','>',$current_version->id)->get();

            return $this->response->array([
                'code'=>1,
                'msg'=>'',
                'data'=>$this->data_format($data,'module')
            ]);
        }else{
            return $this->response->array([
                'code'=>0,
                'msg'=>'未找到相关版本'
            ]);
        }

    }

    protected function systemVersions($identifier='')
    {
        $current_version=SystemVersion::where('identifier',$identifier)->first();

        if($current_version){

            $data=SystemVersion::where([
                'is_show'=>1,
            ])->where('id','>',$current_version->id)->get();

            return $this->response->array([
                'code'=>1,
                'msg'=>'',
                'data'=>$this->data_format($data,'system')
            ]);
        }else{
            return $this->response->array([
                'code'=>0,
                'msg'=>'未找到相关版本'
            ]);
        }
    }

    protected function data_format($data,$type='system')
    {
        $arr=[];
        switch ($type){
            case 'module':
                foreach ($data as $k=>$v){
                    $arr[$v->version]['version']=$v->version;
                    $arr[$v->version]['log']=explode('&&',$v->introduction);
                    $arr[$v->version]['file_path']=$v->upgrade_file_path;
                    $arr[$v->version]['frame_version']=$v->frame_version;
                    $arr[$v->version]['condition']='框架最低版本'.$v->frame_version;
                }
                break;
            case 'system':
                foreach ($data as $k=>$v){
                    $arr[$v->version]['version']=$v->version;
                    $arr[$v->version]['log']=explode('&&',$v->introduction);
                    $arr[$v->version]['file_path']=$v->file_path;
                    $arr[$v->version]['condition']='无';
                }
                break;
        }


        return $arr;
    }
}
