<?php


namespace App\Http\Controllers\Admin\Number;


use App\Http\Controllers\Admin\BaseController;
use App\Http\Services\VegetableNumberService;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        $request->input("limit",10);
        $data = ["land_id" => $request->land_id??1];
        $result = VegetableNumberService::getPageDataListByAdmin($data);
        return view('admin.number.index',compact("result"));
    }

    public function data(Request $request)
    {
        $data = ["land_id" => $request->land_id ?? 1];
        $userData = VegetableNumberService::getPageDataListByAdmin($data);
        return $this->success($userData);
    }
}
