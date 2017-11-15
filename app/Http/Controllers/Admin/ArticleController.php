<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\ArticleLable;
use App\Service\ArticleCategaryService;
use App\Service\ArticleService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    private $articleService;
    private $articleCateService;
    private $indexRoute;
    private $pageNum;

    public function __construct()
    {
        $this->middleware('auth');
        $this->articleService = new ArticleService();
        $this->articleCateService = new ArticleCategaryService();
        $this->indexRoute = 'admin/article/index';
        $this->pageNum = 10;
    }

    public function index(Request $request)
    {
        // 处理需要搜索的字段
        $this->articleService->handleSearchParams($request->all(), [['cate_id', '=', 'cate_id'], ['title', 'like', 'title'], ['created_at_start', '>=', 'created_at'], ['created_at_end', '<=', 'created_at']]);
        // 获取列表
        $list = $this->articleService->getList($this->pageNum);
        // 获取搜索的字段
        $seachParams = $this->articleService->searchParams;
        // 获取分类
        $cateSelectId = isset($seachParams['cate_id']) && $seachParams['cate_id'] > 0 ? $seachParams['cate_id'] : 0;
        $cateAll = $this->articleCateService->getCategarySelect(0, $cateSelectId, "<option value='0'>所有分类</option>", "cate_id");

        return view('admin.article.index', compact("list","cateAll", "seachParams"));
    }

    public function add()
    {
        $cateAll = $this->articleCateService->getCategarySelect(0, 0, '', 'cate_id');
        $lableList = ArticleLable::get();
        return view('admin.article.add', compact("cateAll", "lableList"));
    }

    public function addDo(Request $request)
    {
        $params = $request->all();
        $this->validator($params)->validate();

        $article = new Article();
        $article->cate_id = $params['cate_id'];
        $article->lable_id = $params['lable_id'];
        $article->title = empty($params['title']) ? '' : trim($params['title']);
        $article->title_img = empty($params['title_img']) ? '' : trim($params['title_img']);
        $article->description = empty($params['description']) ? '' : trim($params['description']);
        $article->content = empty($params['content']) ? '' : trim($params['content']);
        $article->save();

        $this->setMessage($request);
        return redirect($this->indexRoute);
    }

    public function edit($id)
    {
        $info = Article::find($id);
        $cateAll = $this->articleCateService->getCategarySelect(0, $info->cate_id, '', 'cate_id');
        $lableList = ArticleLable::get();
        return view('admin.article.edit', compact("cateAll", "lableList"));
    }

    protected function validator(array $data, $isEdit = 0)
    {
        if ($isEdit) {
            $ruleArr = [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ];
        } else {
            $ruleArr = [
                'title' => 'required|string|max:255|unique:articles',
            ];
        }
        return Validator::make($data, $ruleArr);
    }
}
