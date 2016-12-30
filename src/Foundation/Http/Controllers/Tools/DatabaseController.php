<?php

namespace Orchid\Foundation\Http\Controllers\Tools;

use Illuminate\Http\Request;
use Orchid\Foundation\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index(){

        $systemsTables = DB::select('SHOW TABLES');
        $tables = [];
        foreach ($systemsTables as $table) {
            foreach ($table as $key => $value)
                $tables[] = $value;
        }



    }

}
