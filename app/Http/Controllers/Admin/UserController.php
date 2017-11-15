<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 2017/10/25
 * Time: 15:16
 */

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = \App\User::where([])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.user.index',compact("users"));
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function addDo(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $this->setMessage($request);
        return redirect('admin/user/index');
    }

    public function edit($id)
    {
        $info = User::find($id);
        return view('admin.user.edit', compact("info"));
    }

    public function editDo(Request $request)
    {
        $params = $request->all();
        $this->validator($params, 1)->validate();

        if ($params['id'] > 0) {
            $info = User::find($params['id']);
            $info->name = $params['name'];
            $info->email = $params['email'];
            $info->save();
            $this->setMessage($request);
        } else {
            $this->setMessage($request, 'danger', '操作失败！');
        }

        return redirect('admin/user/index');
    }

    public function delete(Request $request, $id)
    {
        $info = User::find($id);
        $info->delete();
        $this->setMessage($request);
        return redirect('admin/user/index');
    }

    protected function validator(array $data, $isEdit = 0)
    {
        $ruleArr = [
            'name' => 'required|string|max:255',
        ];
        if ($isEdit) {
            $ruleArr['email'] = 'required|string|email|max:255';
        } else {
            $ruleArr['email'] = 'required|string|email|max:255|unique:users';
            $ruleArr['password'] = 'required|string|min:6|confirmed';
        }
        return Validator::make($data, $ruleArr);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}