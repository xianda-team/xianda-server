<?php
namespace App\Http\Controllers\Api;



class WearController extends BaseController
{

    public function show($id)
    {
        return \Auth::user();
    }
}
