<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Content;
use Illuminate\Support\Facades\Input;
use \App\Models\Bugreport;
use DB;


class ContentController extends Controller
{
  
    public function getcontent()
    {
        
        
       $content= Content::where('tenantid',Session('tenantid'))
                          ->where('contentstatus', 'Active')
                          ->get();

        
        
        
        
        
        
//        $pipelinedeals_New=pipelinedeal::with('dd_modules')
//                   ->where('companyid',session('companyid'))
//                   ->with(['company' => function($c){
//                    $c->select('companyid','name','statusmessage')
//                    ->with(['usercompany' => function($uc){
//                    $uc->select('userid','recordstatus','companyid')
//                      ->with('user');
//                   }]);
//
//
//                   }])
//
//                  ->with(['deal' => function($c){
//                    $c->select('dealid','proposedusesoffunds','investmentstage','totalinvestmentrequired','companyid')
//                    ->with(['company' => function($u){
//                      $u->select('companyid','name','statusmessage')
//                      ->with(['usercompany' => function($uc){
//                         $uc->select('userid','recordstatus','companyid')
//                            ->with('user');
//                   }]);
//                    }]);
//                   }])
//                     
//                   ->limit(3)
//                   ->get();
        
        return view('content.content')->with('content', $content);
        
        
    }
    
    
    public function getslugcontent($slug)
    {
        $content1= Content::where('tenantid',Session('tenantid'))
                          ->where('contentstatus', 'Active')
                          ->where('slug',$slug)
                          ->get();
        
        
        
        
        $content2= Content::where('tenantid',Session('tenantid'))
                          ->where('contentstatus', 'Active')
                          ->get();
        $country=DB::select( DB::raw("select countryid,name from country"));
        $data=['content1'=>$content1,'content2'=>$content2,'country'=>$country];
        
        //$data=['content1'=>$content1,'content2'=>$content2];
        
       
        return view('content.content',compact('data'));
        
        
    }
    
    public function emailsave(Request $request)
    {
        
        
        
        
        
    
     
        
    $bugreport=new Bugreport();
    
       $bugreport->yourname=$request->input('name');
       $bugreport->pageurl=$request->input('pageurl');
       $bugreport->youremail=$request->input('email');
       $bugreport->countryid=$request->input('country');
       $bugreport->description=$request->input('descrition');
       $bugreport->tenantid=Session('tenantid');
       $random_bytes = mcrypt_create_iv(12, MCRYPT_DEV_URANDOM);
       $string = base64_encode($random_bytes);
       $bugreport->tenantid=Session('tenantid');
       $bugreport->bugreportid=$string;
    
       $bugreport->save();
        return redirect('/content/report-bugs')->with('response','Bug added successfully!!');
        
    }
    
    
    
    
    
    
}
