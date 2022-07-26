<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Helpers\MonthHelper;
use App\Helpers\NameHelper;
use App\Models\PodTransaction;
use Illuminate\Support\Facades\DB;

class RoyaltyController extends Controller
{
    public function index()
    {
        $author = Author::get();
        $author = Author::all();
        foreach($author as $authors){
            $podtran = Podtransaction ::orderBy('author_id', 'ASC')->paginate(10);
            $podlists = Podtransaction ::where('author_id',$authors->id);
    
            $hbound = Podtransaction::where('author_id' , $authors->id)->where('format' , 'Perfectbound');
            $paperBackquan = 0;
            $paperRev = 0;
            $paperHigh = 0;
            foreach ($hbound as $pod){
                $paperBackquan += $pod->quantity;
                $paperRev += $pod->price * $pod->quantity;
                if($pod->price > $paperHigh) { $paperHigh = $pod->price; }
            }

            $paperRoyalty = $paperRev * 0.15;
            $paperRev  = number_format($paperRev ,2);
           
        }   
        


        return view('royalties.pod', [
            'cnt' => $paperBackquan, 
            'pod_transactions' => $podtran,
        ], compact('author'));
    }
    public function search(Request  $request)
    {
        if($request->author_id == 'all'){
            $author = Author::all();
      
            return view('royalties.pod', [
                'pod_transactions' => PodTransaction::orderBy('author_id', 'ASC')->paginate(10)
            ], compact('author'));
        }else{
            $author = Author::all();
      
        return view('royalties.pod', [
            'pod_transactions' => PodTransaction::where('author_id' , $request->author_id)->orderBy('author_id', 'ASC')->paginate(10)
        ], compact('author'));
        }
        
   
    
    }
   
}
