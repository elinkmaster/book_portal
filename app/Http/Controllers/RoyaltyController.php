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
      $year =PodTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
      $months = MonthHelper::getMonths();
      $author = Author::get();
      $author = Author::all();
      $book = Book::all();
      $pod = Podtransaction ::where('quantity' ,'>', 0)->orderBy('author_id', 'ASC')->paginate(10);
   
       return view('royalties.pod',['pod_transactions' => $pod],compact('author','year' , 'months'));
    }
    public function search(Request  $request)
    {
      $author = Author::all();
      $months = MonthHelper::getMonths();
      $year =PodTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
          if($request->author_id == 'all'){
          
              return view('royalties.pod', [
                  'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->orderBy('author_id', 'ASC')->paginate(10)
              ], compact('author', 'months' , 'year'));
          }
          else{
             
              return view('royalties.pod', [
                  'pod_transactions' => PodTransaction::where('author_id' , $request->author_id)->where('quantity' ,'>', 0)->orderBy('author_id', 'ASC')->paginate(10)
              ], compact('author', 'months', 'year'));
          }
      
      
   
    
    }
    public function yearfil(Request $request){
        
      $year =PodTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
      $author = Author::all();
      $months = MonthHelper::getMonths(); 
      if($request->years =="all"){
        return redirect()->route('royalty.index');
    
      }
      else{  

          return view('royalties.pod', [
          'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->where('year', $request->years)->paginate(10)
          ], compact('author', 'months','year'));
        }   
    }
    public function sort(Request  $request)
    {
      $year =PodTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
      $author = Author::all();
      $months = MonthHelper::getMonths(); 
        switch($request->sort){
           case 'ASC':
                   
               return view('royalties.pod', [
                   'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->orderBy('book_id','ASC')->paginate(10)
               ], compact('author', 'months','year'));
          break;
           case 'DESC':
            
              return view('royalties.pod', [
                   'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->orderBy('book_id','DESC')->paginate(10)
               ], compact('author', 'months','year'));
          break;
           case 'RASC':
             
               return view('royalties.pod', [
                  'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->orderBy('royalty','ASC')->orderBy('author_id' , 'ASC')->paginate(10)
               ], compact('author', 'months','year'));
           break;
           case 'RDSC':
              
              return view('royalties.pod', [
                   'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->orderBy('royalty','DESC')->orderBy('author_id' , 'DESC')->paginate(10)
               ], compact('author', 'months','year'));
           break;
           

        }
       if($request->months=="all"){
            return redirect()->route('royalty.index');
        
       }else{
          
           return view('royalties.pod', [
               'pod_transactions' => PodTransaction::where('quantity' ,'>', 0)->where('month', $request->months)->orderBy('book_id','DESC')->paginate(10)
           ], compact('author', 'months','year'));
       }

      
    }
   
}
