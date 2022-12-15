<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Helpers\MonthHelper;
use App\Helpers\NameHelper;
use App\Models\EbookTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EbookRoyaltyController extends Controller
{
    public function index(){
      $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $months = MonthHelper::getMonths();

        $author = Author::get();
        $ebooktransaction = EbookTransaction ::where('quantity','<>' ,0)->orderBy('author_id', 'DESC')->paginate(10);
        return view('royalties.ebook',['ebook_transactions' => $ebooktransaction,],compact('author','months', 'year'));
       
    }
    public function search(Request $request){
        $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $months = MonthHelper::getMonths();

        $author = Author::get();
        if($request->months == "all"){
            $ebooktransaction = EbookTransaction ::orderBy('author_id', 'ASC')->paginate(10);
            return view('royalties.ebook',['ebook_transactions' => $ebooktransaction,],compact('author','months' ,'year'));
        }else{
            $ebooktransaction = EbookTransaction ::where('month' , $request->months)->orderBy('author_id', 'ASC')->paginate(10);
            return view('royalties.ebook',['ebook_transactions' => $ebooktransaction,],compact('author','months' ,'year'));
        }
       
       
        if($request->author_id == 'all'){
          
            $ebooktransaction = EbookTransaction ::orderBy('author_id', 'ASC')->paginate(10);
            return view('royalties.ebook',['ebook_transactions' => $ebooktransaction,],compact('author','months' ,'year'));
        }else{
          
            return view('royalties.ebook',['ebook_transactions' => EbookTransaction::where('author_id',$request->author_id)->orderBy('author_id', 'ASC')->paginate(10)], compact('author','months' ,'year'));
        }
    }
    public function filter(Request $request){
        $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $months = MonthHelper::getMonths();
        $author = Author::get();
      
     
      if($request->years =="all"){
        return redirect()->route('er.index');
    
      }
      else{  

          return view('royalties.ebook', [
          'ebook_transactions' => EbookTransaction::where('quantity' ,'>', 0)->where('year', $request->years)->paginate(10)
          ], compact('author', 'months','year'));
        }   
    }
    public function sort(Request $request){
        switch($request->sort){
            case 'ASC':
                $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
                $months = MonthHelper::getMonths();
                $author = Author::orderBy('firstname' ,'ASC')->orderBy('lastname' , 'ASC');
                        
                return view('royalties.ebook', [
                    'ebook_transactions' => EbookTransaction::orderBy('book_id','ASC')->paginate(10)
                ], compact('author','months' ,'year'));
            break;
            case 'DESC':
                $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
                $author = Author::orderBy('firstname' ,'DESC')->orderBy('lastname' , 'DESC');
                $months = MonthHelper::getMonths();
                return view('royalties.ebook', [
                    'ebook_transactions' => EbookTransaction::orderBy('book_id','DESC')->paginate(10)
                ], compact('author','months' ,'year'));
            break;
            case 'EASC':
                $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
                $author = Author::orderBy('firstname' ,'ASC')->orderBy('lastname' , 'ASC');
                $months = MonthHelper::getMonths();    
                return view('royalties.ebook', [
                    'ebook_transactions' => EbookTransaction::orderBy('royalty','ASC')->orderBy('author_id' , 'ASC')->paginate(10)
                ], compact('author','months' ,'year'));
            break;
            case 'EDSC':
                $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
                $author = Author::orderBy('firstname' ,'DESC')->orderBy('lastname' , 'DESC');
                $months = MonthHelper::getMonths();      
                return view('royalties.ebook', [
                    'ebook_transactions' => EbookTransaction::orderBy('royalty','DESC')->orderBy('author_id' , 'DESC')->paginate(10)
                ], compact('author','months' ,'year'));
            break;
            default:
        $months = MonthHelper::getMonths();
        $author = Author::get();
        $author = Author::get();
        $year =  EbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $ebooktransaction = EbookTransaction ::orderBy('author_id', 'ASC')->paginate(10);
        return view('royalties.ebook',['ebook_transactions' => $ebooktransaction,],compact('author','months' ,'year'));

        }
    }
}
