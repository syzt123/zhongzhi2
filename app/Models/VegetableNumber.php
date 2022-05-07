<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//土地蔬菜编号表
class VegetableNumber extends Model
{
    protected $table = 'vegetable_number';
    protected $dateFormat = 'U';

    const CREATED_AT = 'create_time';
    const UPDATED_AT = null;

    // 新增
    static function addVegetableNumber($data): int
    {
        return self::with([])->insertGetId($data);
    }

    // 查询
    static function getVegetableNumberList($data = []): array
    {
        $lists = self::with([]);
        $page = 1;
        $pageSize = 10;
        $sort = 'desc';// desc asc
        if (isset($data["page"]) && (int)$data["page"] > 0) {
            $page = $data["page"];
            unset($data["page"]);
        }
        if (isset($data["page_size"])) {
            $pageSize = $data["page_size"];
            unset($data["page_size"]);
        }
        if (count($data)) {
            $lists = $lists->where($data);
        }
        $skipNums = ($page - 1) * $pageSize;
        $lists = $lists->skip($skipNums)->limit($pageSize)->orderBy("id", $sort)->get();

        if ($lists) {
            return $lists->toArray();
        }
        return [];
    }

    // 删除
    static function delVegetableNumber($id, $data = []): int
    {
        $model = self::with([])->where("id", $id);
        if (count($data)) {
            $model = $model->where($data);
        }
        return $model->delete();
    }

    // 总数
    static function getVegetableNumberNumsByUId(): int
    {
        $model = self::with([]);
        return $model->count();
    }


    // 查询根据id或者条件
    static function findVegetableNumberInfoById($id, $data = []): array
    {
        $model = self::with([]);
        if ($id != null){
            $model = $model->where("id", $id);
        }
        if (count($data)) {
            $model = $model->where($data);
        }
        $rs = $model->first();
        if ($rs != null) {
            return $rs->toArray();
        }
        return [];
    }
}
