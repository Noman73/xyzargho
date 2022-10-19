<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use DataTables;
class SubmissionListController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:collector');
    }
    public function index()
    {
        if (request()->ajax()){
            $get=Submission::with('collector')->where('collector_id',auth()->user()->id)->get();
            return DataTables::of($get)
              ->addIndexColumn()
              ->addColumn('action',function($get){
              $button  ='<div class="d-flex justify-content-center">X
          </div>';
            return $button;
          })
          ->addColumn('date',function($get){
            return date('d M Y',strtotime($get->created_at));
        })
          ->rawColumns(['action','collector'])->make(true);
        }
        return view('backend.submission_list.submission');
    }
}
