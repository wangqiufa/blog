<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 设置警告提示
    protected function setMessage(Request $request, $alert_style = 'success', $alert_msg = '操作成功！')
    {
        $message = [
            'alert_style' => $alert_style,
            'alert_msg' => $alert_msg
        ];
        $request->session()->flash('message', $message);
    }
}
