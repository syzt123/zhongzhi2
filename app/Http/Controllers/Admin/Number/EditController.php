<?php


namespace App\Http\Controllers\Admin\Number;


use App\Http\Controllers\Admin\BaseController;
use App\Models\Admin\VegetableNumber;
use Illuminate\Http\Request;

class EditController extends BaseController
{
    public function index(Request $request, $id)
    {
        $Number = VegetableNumber::find($id);
        return view('admin.number.edit',compact('Number'));
    }
    public function submit(Request $request)
    {
        $model = new VegetableNumber();
        $res = $model->editNumber();
        if($res === true){
            return  $this->success();
        }else{
            return $this->error($res);
        }
    }
}
