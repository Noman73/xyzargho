<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function test()
    {
       $data=Collection::all();
       foreach($data as $value){
            $collection=Collection::find($value->id);
            $collection->datetime=strtotime($value->date);
            $collection->save();
       } 
       return 'ok';
    }
}
