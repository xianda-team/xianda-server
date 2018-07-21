<?php

namespace App\Http\Controllers\Api;


class ClothingController extends BaseController
{

    public function show($id)
    {
        return \Auth::user();
    }
}
