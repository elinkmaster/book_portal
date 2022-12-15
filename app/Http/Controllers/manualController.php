<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;
use Response;

class manualController extends Controller
{
    public function viewManual(){
        return Response::make(file_get_contents('images/Instmanual.pdf'), 200, [
            'content-type'=>'application/pdf',
        ]);
    }
    public function viewVersion(){
        return view('docs.manual');
    }
}
