<?php


namespace App\Http\Controllers\Admin\Number;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Admin\VegetableNumber;
use Illuminate\Http\Request;

class AddController extends BaseController
{
    public function index()
    {
        return view('admin.number.add');
    }
    public function submit(Request $request)
    {
        $model = new VegetableNumber();
        $res = $model->creatNumber();
        if($res === true){
            return  $this->success();
        }else{
            return $this->error($res);
        }
    }
}
