<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Collection;
use App\Models\Submission;
use DataTables;

class CollectorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);

    }

    public function getData()
    {
        // return User::with('collection','submission')->get();
        if (request()->ajax()){
            $get=User::with('collection','submission')->get();
            return DataTables::of($get)
            ->addIndexColumn()
        ->addColumn('sostoyoni',function($get){
            return $get->collection->sum('sostoyoni');
       })
       ->addColumn('istovriti',function($get){
        return $get->collection->sum('istovriti');
        })
        ->addColumn('dokkhina',function($get){
        return $get->collection->sum('dokkhina');
        })
        ->addColumn('songothoni',function($get){
        return $get->collection->sum('songothoni');
        })
        ->addColumn('pronami',function($get){
        return $get->collection->sum('pronami');
        })
        ->addColumn('advertise',function($get){
        return $get->collection->sum('advertise');
        })
        ->addColumn('mandir_construction',function($get){
        return $get->collection->sum('mandir_construction');
        })
        ->addColumn('various',function($get){
        return $get->collection->sum('various');
        })
        ->addColumn('kristi_bandhob',function($get){
          return $get->collection->sum('kristi_bandhob');
          })
        ->addColumn('sri_thakur_vog',function($get){
          return $get->collection->sum('sri_thakur_vog');
          })
        ->addColumn('ananda_bazar',function($get){
            return $get->collection->sum('ananda_bazar');
          })
        ->addColumn('various',function($get){
          return $get->collection->sum('various');
          })
        ->addColumn('totalrittik',function($get){
          $totalrittik=0;
          foreach($get->collection as $rtk){
            $totalrittik+=$rtk->totalrittik->sum('ammount');
          }
          return $totalrittik;
          })
        ->addColumn('total',function($get){
          $totalrittik=0;
          foreach($get->collection as $rtk){
            $totalrittik+=$rtk->totalrittik->sum('ammount');
          }
          return $get->collection->sum('total')+$totalrittik;
          })
        ->addColumn('balance',function($get){
          $totalrittikAmt=0;
          foreach($get->collection as $rittik){
            $totalrittikAmt+=intval($rittik->totalrittik->sum('ammount'));
          }
          return intval($get->collection->sum('total')+$totalrittikAmt)-intval($get->submission->sum('ammount'));
        })
        ->addColumn('submission',function($get){
          return intval($get->submission->sum('ammount'));
        })
          ->rawColumns(['action'])->make(true);
        }
        return view('backend.collector-data.collector-data');
    }
    public function myOwnCollection()
    {
      // return User::with('collection','submission')->get();
      if (request()->ajax()){
        $get=User::with('collection','submission')->get();
        return DataTables::of($get)
        ->addIndexColumn()
    ->addColumn('sostoyoni',function($get){
        return $get->collection->sum('sostoyoni');
   })
   ->addColumn('istovriti',function($get){
    return $get->collection->sum('istovriti');
    })
    ->addColumn('dokkhina',function($get){
    return $get->collection->sum('dokkhina');
    })
    ->addColumn('songothoni',function($get){
    return $get->collection->sum('songothoni');
    })
    ->addColumn('pronami',function($get){
    return $get->collection->sum('pronami');
    })
    ->addColumn('advertise',function($get){
    return $get->collection->sum('advertise');
    })
    ->addColumn('mandir_construction',function($get){
    return $get->collection->sum('mandir_construction');
    })
    ->addColumn('various',function($get){
    return $get->collection->sum('various');
    })
    ->addColumn('kristi_bandhob',function($get){
      return $get->collection->sum('kristi_bandhob');
      })
    ->addColumn('sri_thakur_vog',function($get){
      return $get->collection->sum('sri_thakur_vog');
      })
    ->addColumn('ananda_bazar',function($get){
      return $get->collection->sum('ananda_bazar');
      })
    ->addColumn('totalrittik',function($get){
      $totalrittik=0;
      foreach($get->collection as $rtk){
        $totalrittik+=$rtk->totalrittik->sum('ammount');
      }
      return $totalrittik;
      })
    ->addColumn('total',function($get){
      $totalrittik=0;
      foreach($get->collection as $rtk){
        $totalrittik+=$rtk->totalrittik->sum('ammount');
      }
      return $get->collection->sum('total')+$totalrittik;
      })
    ->addColumn('balance',function($get){
      $totalrittikAmt=0;
      foreach($get->collection as $rittik){
        $totalrittikAmt+=intval($rittik->totalrittik->sum('ammount'));
      }
      return intval($get->collection->sum('total')+$totalrittikAmt)-intval($get->submission->sum('ammount'));
    })
    ->addColumn('submission',function($get){
      return intval($get->submission->sum('ammount'));
    })
      ->rawColumns(['action'])->make(true);
    }
    return view('backend.own-collector-data.own-collector-data');
    }


    public function collectorBalance($id)
    {
      $collection=Collection::with('totalrittik')->where('author_id',$id)->get();
      // return $collection->sum('total');
      $rittik_amt=0;
      foreach($collection as $rittik){
          $rittik_amt+=$rittik->totalrittik->sum('ammount');
      }

      $total=$collection->sum('total');
      $sub_total=$total+$rittik_amt;
      $submission=Submission::where('collector_id',$id)->sum('ammount');
      $balance=($sub_total-$submission);
      return $balance;
    }
}
