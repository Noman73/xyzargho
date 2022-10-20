<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\RittikiRelation;
class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function test()
    {
       $data=RittikiRelation::all();
       
       foreach($data as $value){
            if(Collection::where('id',$value->collection_id)->count()==0){
                $rrel=RittikiRelation::where('collection_id',$value->collection_id)->delete();
            }
       } 
       return 'ok';
    }
}
