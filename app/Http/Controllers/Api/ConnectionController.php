<?php

namespace App\Http\Controllers\Api;

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

    public function bind()
    {
        return 22222222222;
    }

    public function get_current_version()
    {
        return '1.0.0';
    }
}
