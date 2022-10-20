<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\RittikiRelation;
use App\Models\User;
use Validator;
use DataTables;
use Auth;
use App\Models\Donor;
use Rakibhstu\Banglanumber\NumberToBangla;
class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        // return Auth::user()->hasRole('collector');
        // if(Auth::user()->hasRole('collector')){
        //     return "okkk";
        // }else{
        //     return Auth::user()->assignRole('admin');;
        // }
    //    return $get=Collection::with('donor','totalrittik')->get();
        if (request()->ajax()){
            if(Auth::user()->hasRole('collector')){
                $get=Collection::with('donor','totalrittik')->where('author_id',auth()->user()->id)->get();
            }elseif(Auth::user()->hasRole('admin')){
                $get=Collection::with('donor','totalrittik')->get();
            }
            return DataTables::of($get)
              ->addIndexColumn()
              ->addColumn('action',function($get){
                    $button  ='<div class="d-flex justify-content-center">';
                    if(Auth::user()->hasRole('admin')){
                        $button.='<a data-url="'.route('collection.edit',$get->id).'"  href="javascript:void(0)" class="btn btn-primary shadow btn-xs sharp me-1 editRow"><i class="fas fa-pencil-alt"></i></a>
                    <a data-url="'.route('collection.destroy',$get->id).'" href="javascript:void(0)" class="btn btn-secondary shadow btn-xs sharp deleteRow"><i class="fa fa-trash"></i></a>';
                    }
                    $button.='</div>';
            return $button;
          })
          ->addColumn('name',function($get){
             return $get->donor->name;
        })
        ->addColumn('adress',function($get){
            return $get->donor->adress;
        })
       ->addColumn('totalrittik',function($get){
            return $get->totalrittik->sum('ammount');
        })
        ->addColumn('total',function($get){
            return $get->totalrittik->sum('ammount')+$get->total;
        })
        ->rawColumns(['action','adress','name'])->make(true);
        }
        return view('backend.collection.collection');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator=Validator::make($request->all(),[
            'donor'=>"required|max:200|min:1",
            'date'=>"required|max:200|min:1|date_format:d-m-Y",
            'sostoyoni'=>"required|max:200|min:1",
            'istovriti'=>"required|max:200|min:1",
            'dokkhina'=>"required|max:200|min:1",
            'songothoni'=>"required|max:200|min:1",
            'pronami'=>"required|max:200|min:1",
            'advertisement'=>"required|max:200|min:1",
            'mandir_construction'=>"required|max:200|min:1",
            'various'=>"required|max:200|min:1",
            'rittiki'=>"required|max:200|min:1",
            'rittiki_ammount'=>"required|max:200|min:1",
            'kristi_bandhob'=>"required|max:200|min:1",
            'sri_thakur_vog'=>"required|max:200|min:1",
            'ananda_bazar'=>"required|max:200|min:1",
            'vatri_vojjo'=>"required|max:200|min:1",
        ]);

        if($validator->passes()){
            $collection=new Collection;
            $collection->donor_id=$request->donor;
            $collection->date=$request->date;
            $collection->datetime=strtotime($request->date);
            $collection->sostoyoni=$request->sostoyoni;
            $collection->istovriti=$request->istovriti;
            $collection->dokkhina=$request->dokkhina;
            $collection->songothoni=$request->songothoni;
            $collection->pronami=$request->pronami;
            $collection->advertise=$request->advertisement;
            $collection->mandir_construction=$request->mandir_construction;
            $collection->kristi_bandhob=$request->kristi_bandhob;
            $collection->sri_thakur_vog=$request->sri_thakur_vog;
            $collection->ananda_bazar=$request->ananda_bazar;
            $collection->vatri_vojjo=$request->vatri_vojjo;
            $collection->various=$request->various;
            $collection->total=$request->various+$request->sostoyoni+$request->istovriti+$request->dokkhina+$request->songothoni+$request->pronami+$request->advertisement+$request->mandir_construction+$request->kristi_bandhob+$request->sri_thakur_vog+$request->ananda_bazar+$request->vatri_vojjo;
            $collection->author_id=auth()->user()->id;
            $collection->save();
            $ammount=explode(',',$request->rittiki_ammount);
            $i=0;
            $total_amt=0;
            foreach(explode(',',$request->rittiki) as $data){
                $rittiki_relations=new RittikiRelation;
                $rittiki_relations->collection_id=$collection->id;
                $rittiki_relations->ammount=$ammount[$i];
                $rittiki_relations->rittiki_id=$data;
                $rittiki_relations->donor_id=$collection->donor_id;
                $rittiki_relations->author_id=auth()->user()->id;
                $rittiki_relations->save();
                $total_amt+=$ammount[$i];
                $i++;
            }
            if ($collection){
                $this->sendSms($collection->donor_id,$collection->total+$total_amt);
                return response()->json(['message'=>'Collection Added Success']);
            }
        }
        return response()->json(['error'=>$validator->getMessageBag()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(Collection::with('rittik','donor')->find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return response()->json($request->all());
        $validator=Validator::make($request->all(),[
            'donor'=>"required|max:200|min:1",
            'date'=>"required|max:200|min:10|date_format:d-m-Y",
            'sostoyoni'=>"required|max:200|min:1",
            'istovriti'=>"required|max:200|min:1",
            'dokkhina'=>"required|max:200|min:1",
            'songothoni'=>"required|max:200|min:1",
            'pronami'=>"required|max:200|min:1",
            'advertisement'=>"required|max:200|min:1",
            'mandir_construction'=>"required|max:200|min:1",
            'various'=>"required|max:200|min:1",
            'rittiki'=>"required|max:200|min:1",
            'rittiki_ammount'=>"required|max:200|min:1",
        ]);

        if($validator->passes()){
            $collection=Collection::find($id);
            $collection->donor_id=$request->donor;
            $collection->date=$request->date;
            $collection->sostoyoni=$request->sostoyoni;
            $collection->istovriti=$request->istovriti;
            $collection->dokkhina=$request->dokkhina;
            $collection->songothoni=$request->songothoni;
            $collection->pronami=$request->pronami;
            $collection->advertise=$request->advertisement;
            $collection->mandir_construction=$request->mandir_construction;
            $collection->kristi_bandhob=$request->kristi_bandhob;
            $collection->sri_thakur_vog=$request->sri_thakur_vog;
            $collection->ananda_bazar=$request->ananda_bazar;
            $collection->vatri_vojjo=$request->vatri_vojjo;
            $collection->various=$request->various;
            $collection->total=$request->various+$request->sostoyoni+$request->istovriti+$request->dokkhina+$request->songothoni+$request->pronami+$request->advertisement+$request->mandir_construction+$request->kristi_bandhob+$request->sri_thakur_vog+$request->ananda_bazar+$request->vatri_vojjo;
            $collection->author_id=auth()->user()->id;
            $collection->save();
            $ammount=explode(',',$request->rittiki_ammount);
            $rel_no=explode(',',$request->rel_no);
            $i=0;
            foreach(explode(',',$request->rittiki) as $data){
                if(isset($rel_no[$i])){
                $rittiki_relations=RittikiRelation::find($rel_no[$i]);
                $rittiki_relations->collection_id=$collection->id;
                $rittiki_relations->ammount=$ammount[$i];
                $rittiki_relations->rittiki_id=$data;
                $rittiki_relations->donor_id=$collection->donor_id;
                $rittiki_relations->author_id=auth()->user()->id;
                $rittiki_relations->save();
                $i++;
                }else{
                    $rittiki_relations=new RittikiRelation;
                    $rittiki_relations->collection_id=$collection->id;
                    $rittiki_relations->ammount=$ammount[$i];
                    $rittiki_relations->rittiki_id=$data;
                    $rittiki_relations->donor_id=$collection->donor_id;
                    $rittiki_relations->author_id=auth()->user()->id;
                    $rittiki_relations->save();
                    $i++;
                }
                
            }
            if ($collection){
                
                return response()->json(['message'=>'Collection Updated Success']);
            }
        }
        return response()->json(['error'=>$validator->getMessageBag()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=Collection::where('id',$id)->delete();
        if ($delete) {
            return response()->json(['message'=>'কালেকশন ডিলেট করা হয়েছে']);
        }else{
            return response()->json(['warning'=>'কিছু একটা ভুল করেছেন']);
        }
    }


    public function sendSms($user_id,$total)
    {
        $bangla=new NumberToBangla;
        $api_key="C2001593632a9d8ed9db24.24710771";
        $sender_id="8809601003570";
        $donor=Donor::where('id',$user_id)->first();
        $contacts=$donor->mobile;
        $type="application/json";
        $msg="আপনার প্রদত্ত ইষ্টার্ঘ্য টাকা ".$bangla->bnNum(number_format($total,2,'.',''))." শ্রদ্ধার সাথে গৃহীত হল-পক্ষে সৎসঙ্গ ফাউন্ডেশন।";
        $fields='api_key='.$api_key.'&type='.$type.'&contacts='.$contacts.'&senderid='.$sender_id.'&msg='.$msg;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://isms.mimsms.com/smsapi");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);
        // In real life you should use something like:
        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
        //          http_build_query(array('postvar1' => 'value1')));
        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);
        // Further processing ...
        return $server_output;
        // if ($server_output == "OK") { 

        //  } else { 
             
        //  }
    }
}
