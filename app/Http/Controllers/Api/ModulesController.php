<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Transformers\ModuleTransformer;

class ModulesController extends Controller
{
    public function index(Request $request)
    {
        $limit=$request->limit;
        $page=$request->page;

        if($limit && $page){
            $modules=Module::where('is_show',1)->with('module_versions')->orderBy('sort')->paginate($limit);
            return $this->response->paginator($modules,new ModuleTransformer());
        }else{
            $modules=Module::where('is_show',1)->with('module_versions')->orderBy('sort')->get();
            return $this->response->collection($modules,new ModuleTransformer());
        }

    }

    public function show(Request $request)
    {
        $module=Module::find($request->module);

        return $module->detail;
    }

    public function downModuleInstall(Request $request)
    {
        $file_path=$request->file_path;

        //file_put_contents('log.log',json_encode($request->all()));
    }

    public function check(Request $request)
    {
        $module_identifier=$request->module_identifier;
        $identifier=$request->identifier;
        $frame_version=$request->frame_version;

        $user=User::where([
            'identifier'=>$identifier,
            'status'=>1
        ])->first();

        if($user){
            $module=Module::where('identifier',$module_identifier)->first();
            if($module){
                $last_module_version=$module->module_versions()->where('is_show',1)->orderBy('id','desc')->first();
                if(!$last_module_version){
                    $res=[
                        'code'=>0,
                        'msg'=>'暂无版本'
                    ];
                    return $this->response->array($res);
                }
                if(version_compare($frame_version,$last_module_version->frame_version) == -1){
                    $res=[
                        'code'=>0,
                        'msg'=>'框架版本太低,请先升级框架'
                    ];
                }else{
                    $res=[
                        'code'=>1,
                        'msg'=>'可以安装',
                        'file_path'=>$last_module_version->complete_file_path
                    ];
                }
            }else{
                $res=[
                    'code'=>0,
                    'msg'=>'该模块不存在'
                ];
            }
        }else{
            $res=[
                'code'=>0,
                'msg'=>'用户无法使用此操作,请重新绑定平台账号'
            ];
        }

        return $this->response->array($res);
    }
}
