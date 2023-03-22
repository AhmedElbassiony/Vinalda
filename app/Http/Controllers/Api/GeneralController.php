<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GeneralResource;
use App\Models\Stock;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function stocks()
    {
        $stocks = Stock::all();
        return response()->json(GeneralResource::collection($stocks));

    }
}
