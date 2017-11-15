<?php

namespace App\Service;

use App\Model\ArticleCategary;

class ArticleCategaryService extends BaseService
{
    // 获取分类列表
    public function getCategary($pid = 0, &$result = [], $spacs = 0)
    {
        $spacs += 6;

        $categarys = ArticleCategary::where('pid', $pid)->orderBy('sort', 'desc')->get();

        foreach ($categarys as $categary) {
            $categary->name = str_repeat('&nbsp;', $spacs) . '|--' . $categary->name;
            $result[] = $categary;
            $this->getCategary($categary->id, $result, $spacs);
        }

        return $result;
    }

    // 获取分类下拉列表
    public function getCategarySelect($pid = 0, $selected = 0, $firstOption = "<option value='0'>顶级分类</option>", $selectName = 'pid')
    {
        $list = $this->getCategary($pid);

        $str = "<select name='{$selectName}' class='form-control'>";
        if ($firstOption) {
            $str .= $firstOption;
        }

        foreach ($list as $val) {
            $selectedStr = '';
            if ($val['id'] == $selected) {
                $selectedStr = 'selected';
            }
            $str .= "<option value='{$val['id']}' {$selectedStr}>{$val['name']}</option>";
        }
        return $str .= '</select>';
    }

    // 删除分类（包括所有子类）
    public function deleteAllCategary($id)
    {
        $info = ArticleCategary::find($id);
        $this->deleteChrildCategary($id); // 删除所有子分类
        $info->delete();
    }

    // 根据父id删除所有子分类
    private function deleteChrildCategary($id)
    {
        $list = ArticleCategary::where('pid', $id)->get();
        foreach ($list as $val) {
            $info = ArticleCategary::find($val['id']);
            $chrildPid = $info['id'];
            $info->delete();
            $this->deleteChrildCategary($chrildPid);
        }
    }

}