<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DataController extends Controller
{
    public function news(Request $request)
    {
        $params = $request->input('filters');
        $params = json_decode($params, true);

        return Response::json($params);
    }
}
