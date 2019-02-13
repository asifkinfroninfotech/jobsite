<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;

use View;
use Laravolt\Avatar\Avatar;
use File;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\CompanyImport;

class ExcelImportController extends Controller
{

       //New changes to import excel

       public function importcompany(Request $request)
       {
     
        return view('tenants.importcompanies');    
   
       }
   






    public function importExcel(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ],
        [   
            'import_file.required'    => 'Please select an excel file in the format we supplied.',
        ]);
        
     
        Session::forget('emailerror');
        Session::forget('emailerror1');
        
        Excel::import(new CompanyImport, request()->file('import_file'));

    
        if((session('emailerror')!=null))
        {
            // $str1 ="";
            // $str = 'Email '.implode (", ", session('emailerror')).' already exists.';
            // if((session('emailerror1')!=null))
            // {
            //     $str1 ='Email '.implode (", ", session('emailerror1')).' not valid.';
            // }
            

            return back()->with('emailexist', session('emailerror'));



            
            // dd(session('emailerror'));
        }
        
        else
        {
            return back()->with('success', 'Data imported successfully.');
        }
        
    }
}