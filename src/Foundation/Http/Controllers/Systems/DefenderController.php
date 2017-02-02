<?php namespace Orchid\Foundation\Http\Controllers\Systems;

use Orchid\Foundation\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DefenderController extends Controller
{

    /**
     * @return string
     */
    public function index()
    {
        $defenderList = Storage::allFiles('defender');
        $list = array_pop($defenderList);
        $list = $list ? json_decode(Storage::get($list)) : [];


        return view('dashboard::container.systems.defender.index',[
           'list' => $list
        ]);

    }

}
