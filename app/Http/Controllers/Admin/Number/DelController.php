<?php


namespace App\Http\Controllers\Admin\Number;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Admin\VegetableLand;
use Illuminate\Http\Request;

class DelController extends BaseController
{
    public function index(Request $request, $id)
    {
        $land = VegetableV::find($id);
        $res = $land->delete();
        if($res){
            return $this->success();
        }else{
            return $this->error('删除失败！');
        }
    }
}
