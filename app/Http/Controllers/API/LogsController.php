<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Log;

class LogsController extends Controller
{
    //
    public function index(Log $log){
        return response()->json($log->all());
    }
}
