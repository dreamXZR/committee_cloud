<?php

namespace App\Http\Controllers\Api;

use App\Models\SystemVersion;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function connection(Request $request)
    {
        $version=$request->version;
        $current_version=$this->get_current_version();

        $upgrade=version_compare($current_version,$version);

        return $this->response->array([
            'message'=>'通信正常',
            'upgrade'=>$upgrade
        ]);
    }

    public function bind(Request $request)
    {
        $credentials=[
            'email'=>$request->email,
            'password'=>$request->password
        ];


        if (!\Auth::attempt($credentials)) {
            $res=[
                'code'=>0,
                'msg'=>'账号密码有误'
            ];
        }else{
            $user=User::where('email',$credentials['email'])->first();

            $res=[
              'code'=>1,
              'msg'=>'云平台绑定成功',
              'data'=>$user->identifier,
            ];
        }

        return $this->response->array($res);
    }

    public function get_current_version()
    {
        $system_version=SystemVersion::where('is_show',1)->orderBy('id','desc')->first();

        if($system_version){
            return $system_version->version;
        }else{
            return '1.0.0';
        }
    }
}
