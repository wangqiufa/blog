<?php

namespace App\Http\Controllers\Admin;

use App\Model\ArticleCategary;
use App\Service\ArticleCategaryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleCategaryController extends Controller
{
    private $articleCategaryService;
    private $indexRoute;

    public function __construct()
    {
        $this->middleware('auth');
        $this->articleCategaryService = new ArticleCategaryService();
        $this->indexRoute = 'admin/articleCategary/index';
    }

    public function index()
    {
        $list = $this->articleCategaryService->getCategary();
        return view('admin.article_categary.index', compact("list"));
    }

    public function add()
    {
        $cateAll = $this->articleCategaryService->getCategarySelect();
        return view('admin.article_categary.add', compact("cateAll"));
    }

    public function addDo(Request $request)
    {
        $params = $request->all();
        $this->validator($params)->validate();

        $articleCategary = new ArticleCategary();
        $articleCategary->pid = $params['pid'];
        $articleCategary->name = $params['name'];
        $articleCategary->sort = $params['sort'];
        $articleCategary->save();

        $this->setMessage($request);
        return redirect($this->indexRoute);
    }

    public function delete(Request $request, $id)
    {
        $this->articleCategaryService->deleteAllCategary($id);
        $this->setMessage($request);
        return redirect($this->indexRoute);
    }

    public function edit($id)
    {
        $info = ArticleCategary::find($id);
        $cateAll = $this->articleCategaryService->getCategarySelect(0, $info['pid']);
        return view('admin.article_categary.edit', compact("info", "cateAll"));
    }

    public function editDo(Request $request)
    {
        $params = $request->all();
        $this->validator($params, 1)->validate();

        if ($params['id'] > 0) {
            $info = ArticleCategary::find($params['id']);
            $info->pid = $params['pid'];
            $info->name = $params['name'];
            $info->sort = $params['sort'];
            $info->save();
            $this->setMessage($request);
        } else {
            $this->setMessage($request, 'danger', '操作失败！');
        }

        return redirect('admin/articleCategary/index');
    }

    protected function validator(array $data, $isEdit = 0)
    {
        if ($isEdit) {
            $ruleArr = [
                'name' => 'required|string|max:255',
            ];
        } else {
            $ruleArr = [
                'name' => 'required|string|max:255|unique:article_categary',
            ];
        }
        return Validator::make($data, $ruleArr);
    }
}
