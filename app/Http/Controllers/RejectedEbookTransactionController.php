<?php

namespace App\Http\Controllers;
use App\Helpers\HumanNameFormatterHelper;
use App\Helpers\MonthHelper;
use App\Imports\EbookTransactionsImport;
use App\Models\Author;
use App\Models\Book;
use App\Models\EbookTransaction;
use App\Models\RejectedEbookTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class RejectedEbookTransactionController extends Controller
{
    public function index(Request $request)
    {
        $months = MonthHelper::getMonths();
        $year =  RejectedEbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $books = Book::all();
        $ebook = RejectedEbookTransaction::where('quantity' ,'>' , 0)->orderBy('created_at', 'DESC')->paginate(10);
        if ($request->filter) {
            $ebook = RejectedEbookTransaction::where('quantity' ,'>' , 0)->where('author_name', 'LIKE', "%$request->filter%")->orWhere('book_title', 'LIKE', "%$request->filter%")->paginate(10);
        }
        else if($request->month){
            $ebook = RejectedEbookTransaction::where('quantity' ,'>' , 0)->where('month' , $request->month)->paginate(10);
        }
        return view('rejecteds.ebooks.index', [
            'rejected_ebooks' => $ebook
        ],compact('months' ,'year'));
    }
    public function year(Request $request){
        $ebook = RejectedEbookTransaction::where('quantity' ,'>' , 0)->where('year' , $request->years)->paginate(10);
        $months = MonthHelper::getMonths();
        $year =  RejectedEbookTransaction::select('year')->orderBy('year', 'desc')->first() ?? now()->year;
        $books = Book::all();
       
        if($request->years == "all"){
            return view('rejecteds.ebooks.index', [
                'rejected_ebooks' => RejectedEbookTransaction::where('quantity' ,'>' , 0)->orderBy('created_at', 'DESC')->paginate(10),
            ],compact('months' ,'year'));
        } 
        return view('rejecteds.ebooks.index', [
            'rejected_ebooks' => $ebook
        ],compact('months' ,'year'));  
    }

    public function delete(RejectedEbookTransaction $rejected_ebook)
    {
        $rejected_ebook->delete();
        return back();
    }

    public function edit(RejectedEbookTransaction $rejected_ebook)
    {
        $authors = Author::all();
        $months = MonthHelper::getMonths();
        return view('rejecteds.ebooks.edit')
            ->with('ebook', $rejected_ebook)
            ->with('authors', $authors)
            ->with('months', $months);
    }
    public function clear(){
        RejectedEbookTransaction::truncate();
        return back();
    }
    public function update(Request $request, RejectedEbookTransaction $rejected_ebook)
    {
      
        $request->validate([
            'author' => 'required',
            'book' => 'required',
            'class_of_trade' => 'required',
            'line_item_no' => 'required',
            'year' => 'required',
            'month' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'proceeds' => 'required',
            'royalty' => 'required',
        ]);
        
     if($request){
        $book = Book::where('title', $request->book)->first();
        
        if (!$book) {
            $book = Book::create([
                'title' => $request->book,
                'author_id' => $request->author
            ]);
        }
       // $revenue  = $request->price * $request->quantity;
        $royalty = $request->proceeds /  2;
        EbookTransaction::create([
            'author_id' => $request->author,
            'book_id' => $book->id,
            'class_of_trade' => $request->class_of_trade,
            'line_item_no' => $request->line_item_no,
            'year' => $request->year,
            'month' => $request->month,
            'flag' => $request->flag,
            'format' => $request->format,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'proceeds' => $request->proceeds,
            'royalty' => number_format($royalty ,2)
        ]);

        $rejected_ebook->delete();

        return redirect(route('rejecteds-ebooks.index'));
     }
        
    }
}
