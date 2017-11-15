<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use zgldh\QiniuStorage\QiniuStorage;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function test()
    {
        return view('common.upload.test');
    }

    // 上传图片
    public function img(Request $request)
    {
        $file = $_FILES['picture'];

        $path = $request->input('pathName', 'default'); // 模块路径

        // 设置路径和名称
        $filePath = 'blog/' . $path . '/' . date('YmdHis') . '/';
        $fileName = $filePath . rand(10000,99999) . 'jpg';

        $disk = \Storage::disk('qiniu');
        $disk->put($fileName, file_get_contents($file['tmp_name']));               //上传文件

        return response()->json([
            'status' => 1,
            'imgsrc' => $disk->downloadUrl($fileName)
        ]);
    }
}
