<?php

namespace App\Http\Controllers;

use App\Imports\AuthorsImport;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class AuthorController extends Controller
{

    
    public function index()
    {
        $getauthor = Author::all();
            //foreach($getauthor as $au){
           //    $aid = $au->id;
           // }
           // $count = $bookcount->count('author_id');
           // if(empty($aid)){ }$bookcount = Book::where('author_id' , $aid); 
                $count = "soon";
            return view('author.index', [
                'authors' => Author::paginate(10),
                'authorSearch' => Author::all(),
                'count' =>$count
            ]);
        
        
    }

    public function search(Request $request)
    {
        $getauthor = Author::get();
        $author = Author::where('id', $request->author)->paginate(10);
        $bookcount = Book::where('author_id' , $request->author);
        $count = $bookcount->count('author_id');
        if ($request->author == 'all') {
            
                 foreach($getauthor as $authorkey){
                $bookcount = Book::where('author_id' , $authorkey->id);
                $count = $bookcount->count('author_id');
                return view('author.index', [
                    'authors' => Author::paginate(10),
                    'authorSearch' => Author::all(),
                    'count' =>$count
                ]);
                 }  
        }

        return view('author.index', [
            'authorSearch' => Author::all(),
            'authors' => $author,
            'count' =>$count
        ]);
    }

    public function importPage()
    {
        return view('author.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        ini_set('max_execution_time', -1);
        Excel::import(new AuthorsImport, $request->file('file')->store('temp'));
        ini_set('max_execution_time', 60);
        return back()->with('success', 'Successfully imported data');
    }

    public function create()
    {
        return view('author.create');
    }

    public function store(Request $request)
    {
        /**
         *   --- Task for Junior Dev ---
         *   Validate the incoming request
         *   Fields to validate { name, email, contact_number, address}
         *   ---------------------------
         */

        $request->uid = $this->uid($request);
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
       

        ]);
       

       // return $request;

        /**
         * Store the validated data to database
         * Use only the Model
         * ex: ModelName::create({validated data here...})
         * modify authorid (22(uear)xxx xxxx)
         * update 22/
         */
         
            $year =   Carbon::now()->format('y');
            $randid = '0123456789';
            $authorid = $year.substr(str_shuffle(str_repeat($randid, 5)), 0, 8);
         Author::create([
            'id'=>$auhtorid,
            'uid' => $request->uid,
            'title' => $request->title,
            'firstname' => $request->firstname,
            'middle_initial' => $request->middle_initial,
            'lastname' => $request->lastname,
            'suffix' => $request->suffix,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'address' => $request->address,
            
        ]);

        

        /**
         * Redirect the page to author.create
         * Add session with value of { Author successfully added to database }
         */

        return redirect(route('author.create'))->with('success', 'Author successfully added to database');
    }

    public function edit(Author $author)
    {
        return view('author.edit', compact('author'));
    }


    public function update(Request $request, Author $author)
    {
        /**
         *   --- Task for Junior Dev ---
         *   Validate the incoming request
         *   Fields to validate { name, email, contact_number, address}
         *   ---------------------------
         */

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        /**
         * Since the author is auto binded to the Model
         * We can sure that the the author exist in the database
         * What we will is to update the existing data with the updated data
         * To achieve that use the modelVariable->update()
         */

        $author->update($request->all());

        /**
         * Redirect the page to author.edit
         * Add session with value of { Author successfully updated to the database }
         */

        return redirect()->route('author.edit', ['author' => $author])->with('success', 'Author successfully updated to the database');
    }


    public function delete(Author $author)
    {
        /**
         * You can directly delete the author
         * To achieve that, use the authorVariable->delete()
         */

        $author->delete();

        /**
         * Redirect to author.index
         * Also add session with the value of { Author has been successfully deleted from the database }
         */

        return redirect()->route('author.index')->with('success', 'Author has been successfully deleted from the database');
    }

    public function uid(Request $request)
    {
        return substr(md5(time()), 0, 8).'-'.substr(uniqid(), 0, 4).'-'.substr(md5(str_shuffle($request->firstname)), 0, 4).'-'.substr(bin2hex(random_bytes(10)), 0, 4).'-'.substr(sha1(time()), 0, 12);
    }
    //add clear all author
    public function clear(){
        Author::truncate();
        return back();
     }
}
