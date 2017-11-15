<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

/**
 * 基础服务层
 */

class BaseService
{
    public $searchParams = []; // 存放需要搜索的字段的数组
    protected $whereConditions = []; // 存放需要查询的where数组

    /**
     * 获取需要用于搜索的数据
     *
     * @param $param 请求的参数
     * @param array $whereCondition 需要查询的条件（二维数组）,每个子数组的组成：['请求过来的参数名', '条件', '数据库字段的名称']
     */
    public function handleSearchParams($param, $whereCondition = [])
    {
        if ($whereCondition) {
            foreach ($whereCondition as $val) {
                $paramField = $val[0];
                $condition = $val[1];
                $tableField = $val[2];
                $this->searchParams[$paramField] = isset($param[$paramField]) && !empty($param[$paramField]) ? $param[$paramField] : ''; // 存放搜索时的参数

                if (isset($param[$paramField]) && !empty($param[$paramField])) {
                    // 根据不同的条件组装成sql搜索数组
                    if (in_array($condition, ['=', '<', '>', '<=', '>=', 'in', 'not in'])) {
                        $this->whereConditions[] = [$tableField, $condition, $param[$paramField]];
                    } elseif ($condition === 'like') {
                        $this->whereConditions[] = [$tableField, $condition, '%' . $param[$paramField] . '%'];
                    }
                }
            }
        }
    }

    /**
     * 获取分页列表
     * @param $pageNum 每页数量
     * @return mixed
     */
    public function getList($pageNum)
    {
//        DB::connection()->enableQueryLog();
        return DB::table($this->tableName)->where($this->whereConditions)->paginate($pageNum);
//        $log = DB::getQueryLog();
//        dd($log);
    }

}