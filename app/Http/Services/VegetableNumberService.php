<?php

namespace App\Http\Services;
// 蔬菜地编号信息
use App\Models\VegetableNumber;
use App\Models\Admin\VegetableNumber as Admin;
use Illuminate\Support\Facades\Request;

class VegetableNumberService extends BaseService
{
    //添加蔬菜地编号
    static function addVegetableNumber($data): int
    {
        return VegetableNumber::addVegetableNumber($data);
    }

    //获取蔬菜地编号列表
    static function getVegetableNumberList($data = []): array
    {
        $page = 1;
        $pageSize = 10;
        if (isset($data["page"]) && (int)$data["page"] > 0) {
            $page = $data["page"];
        }
        if (isset($data["page_size"])) {
            $pageSize = $data["page_size"];
        }
        return self::getPageDataList(VegetableNumber::getVegetableNumberNumsByUId(), $page, $pageSize, VegetableNumber::getVegetableNumberList($data));

    }

    //删除蔬菜地编号信息
    static function delVegetableNumberById($id, $data = []): int
    {
        return VegetableNumber::delVegetableNumber($id, $data);
    }
    //根据id查询蔬菜地编号信息
    static function findVegetableNumberInfoById($id, $data = []): array
    {
        return VegetableNumber::findVegetableNumberInfoById($id, $data);
    }

    // 编辑土地




}
