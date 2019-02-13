<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use App\Models\Pipelinedeal;
use App\Models\DdModule;
use App\Models\DdQuestion;
use View;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use File;
use App\Models\User;


class AdminController extends Controller
{
   public function index()
   {
       return view('adminview.dashboard');
   }

   public function get_admin_dashboard()
   {
      return view('adminview.dashboard');
   }
   
   public function company()
   {
    
       $companytypes=DB::table('companytypes as ct')
             ->select('ct.companytype')->get();                    
       
       
       
       
          $company=DB::table('company as c') 
          ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
          ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
          ->leftjoin('tenants as t','c.tenantid','t.tenantid')        
          ->where('c.companystatus','Verified')        
          ->select('c.activestatus','c.tenantid','c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype','t.firstname as tenantfirstname','t.company as tenantcompany','t.lastname as tenantlastname','t.minilogo as tenantminilogo')->take(10)->get();
          
        

          $companyids="";
   
          foreach ($company as $key => $value) {
      
              if ($companyids=="")
              {
                  $companyids=$value->companyid;
              }
              else
              {
                  $companyids=$companyids.",". $value->companyid;
              }
             
          }
      
          $company_sectors=DB::table('companysectors as cs')
                      ->join('sectors as s','s.sectorid','cs.sectorid') 
                      ->whereIn('cs.companyid', explode(',', $companyids))
                      ->select('cs.companyid','s.name as sectorname')
                      ->get();

           $collection = collect(json_decode($company_sectors, true));
                       $cnt=0;$sectornames='';

                      foreach ($company as $key => $value) {
                        $value->sectors="";
                        $value->scount=0;
                        $cnt=0;
                        $sectornames='';
                        $data = $collection->where('companyid', $value->companyid);
                        if($data!=null)
                        {
                             foreach($data as $k)
                             {
                               if($cnt<2)
                               {
                                if($sectornames=='')
                                {
                                  $sectornames=$k['sectorname'];
                                }
                                else
                                {
                                  $sectornames=$sectornames .','.$k['sectorname'];
                                }
                              }
                                $cnt=$cnt+1;
                             }

                              $value->scount=$cnt;
                               $value->sectors=$sectornames;
                        }
                       
                       }
        
        
       
       
       return view('adminview.company',compact('company','companytypes'));
   }


 //new changes related to the company data  

  public function getcompanydata(Request $request)
  {

   $search=$request->search;
   $types=$request->types;

   $getpagesize = 10;




    $companytypes=DB::table('companytypes as ct')
    ->select('ct.companytype')->get();                    




 $company=DB::table('company as c') 
 ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
 ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
 ->leftjoin('tenants as t','c.tenantid','t.tenantid')        
 ->where('c.companystatus','Verified');
 
 
 if(isset($search) && !empty($search))
 {
    $company->where('c.name','like', '%' . $search . '%');
    $company->orwhere('ct.companytype','like','%'.$search.'%');
    $company->orwhere('t.company','like','%'.$search.'%');
    // $company->orWhere(DB::raw("CONCAT('t.firstname', ' ','t.lastname')"), 'LIKE', "%".$search."%");

 }


 if(isset($types) && !empty($types))
 {
    $company->where('ct.companytypeid',$types);
 }

 if(isset($request->sort) && !empty($request->sort))
 {
     switch ($request->sort) {
         case 'tenant':
         $company->orderBy('t.company');
             break;
         case 'companyname':
         $company->orderBy('c.name');
         break;
         case 'companytype':
         $company->orderBy('ct.companytype');
         break;
         
     }
     
 }


 $company=$company->select('c.activestatus','c.tenantid','c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.company as tenantcompany','t.minilogo as tenantminilogo')->paginate($getpagesize);
 


 $companyids="";

 foreach ($company as $key => $value) {

     if ($companyids=="")
     {
         $companyids=$value->companyid;
     }
     else
     {
         $companyids=$companyids.",". $value->companyid;
     }
    
 }

 $company_sectors=DB::table('companysectors as cs')
             ->join('sectors as s','s.sectorid','cs.sectorid') 
             ->whereIn('cs.companyid', explode(',', $companyids))
             ->select('cs.companyid','s.name as sectorname')
             ->get();

  $collection = collect(json_decode($company_sectors, true));
              $cnt=0;$sectornames='';

             foreach ($company as $key => $value) {
               $value->sectors="";
               $value->scount=0;
               $cnt=0;
               $sectornames='';
               $data = $collection->where('companyid', $value->companyid);
               if($data!=null)
               {
                    foreach($data as $k)
                    {
                      if($cnt<2)
                      {
                       if($sectornames=='')
                       {
                         $sectornames=$k['sectorname'];
                       }
                       else
                       {
                         $sectornames=$sectornames .','.$k['sectorname'];
                       }
                     }
                       $cnt=$cnt+1;
                    }

                     $value->scount=$cnt;
                      $value->sectors=$sectornames;
               }
              
              }

              $view=View::make('adminview.companytabledata.companydata',compact('company','companytypes'))->render();
              return $view;

  }


//new changes related to user data

public function getuserdata(Request $request)
{

 $search=$request->search;
 $types=$request->types;
 $getuserpagesize = 10;


 $status='Active';
 $status=$status.','.'Inactive';
          
       $users=DB::table('users as us') 
          ->join('usercompanies as uc', 'uc.userid', '=', 'us.userid')
          ->join('company as c','uc.companyid','c.companyid')
          ->join('companytypes as ct','ct.companytypeid','c.companytypeid') 
          ->leftjoin('country as cn','c.countryid','cn.countryid')
          ->leftjoin('tenants as t','us.tenantid','t.tenantid')
          ->wherein('uc.recordstatus',explode(',', $status));

          if(isset($search) && !empty($search))
          {
             $users->where('c.name','like', '%' . $search . '%');
             $users->orwhere('ct.companytype','like','%'.$search.'%');
             $users->orwhere('t.company','like','%'.$search.'%');
             $users->orwhere('us.firstname','like','%'.$search.'%');
          
          }
        
          if(isset($request->sort) && !empty($request->sort))
         {
     switch ($request->sort) {
         case 'tenant':
         $users->orderBy('t.company');
             break;
         case 'username':
        $users->orderBy('us.firstname');
        break;    
         case 'companyname':
         $users->orderBy('c.name');
         break;
         case 'companytype':
         $users->orderBy('ct.companytype');
         break;
         
       }
     
   }

       


         $users= $users->select('t.tenantid','us.userid','us.profileimage as userprofileimage','us.firstname','us.lastname','c.profileimage','c.name','c.companyid','ct.companytype','us.userposition','uc.userrole','uc.recordstatus as Status','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.minilogo as tenantminilogo','t.company as tenantcompany')
          ->paginate($getuserpagesize);


$view=View::make('adminview.usertabledata.userdata',compact('users'))->render();
return $view;

}


//new changes related to deal data

public function getdealdata(Request $request)
{

 $search=$request->search;
 $types=$request->types;
 $getdealpagesize = 10;

 $query = DB::table('deals as d')
 ->leftjoin('company as c','c.companyid','d.companyid') 
 ->join('companytypes as ct','ct.companytypeid','c.companytypeid') 
 ->leftjoin('country as cn','cn.countryid','c.countryid')
 ->leftjoin('users as us','us.userid','d.userid')
  ->leftjoin('currency as cur','d.currencyid','cur.currencyid')
  ->leftjoin('tenants as t','d.tenantid','t.tenantid');


  if(isset($search) && !empty($search))
  {
     $query->where('c.name','like', '%' . $search . '%');
     
     $query->orwhere('t.company','like','%'.$search.'%');

     $query->orwhere('d.investmentstage','like','%'.$search.'%');

     $query->orwhere('d.projectname','like','%'.$search.'%');
    
  
  }

  if(isset($request->sort) && !empty($request->sort))
  {
switch ($request->sort) {
  case 'tenant':
  $query->orderBy('t.company');
      break;
  case 'companyname':
  $query->orderBy('c.name');
  break;
  case 'stage':
  $query->orderBy('d.investmentstage');
  break;
  case 'projectname':
  $query->orderBy('d.projectname');
  break;
  
}

}


$datas = $query->select('c.companyid','ct.companytype','c.profileimage as companyprofileimage','t.tenantid','c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.dealid','d.investmentstructure','d.purposeofinvestment','d.projectname','us.profileimage','us.firstname','us.lastname','cur.symbol','c.companyid','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.minilogo as tenantminilogo','t.company as tenantcompany')->paginate($getdealpagesize);
 


$view=View::make('adminview.dealtabledata.dealdata',compact('datas'))->render();
return $view;

}





      public function deal()
   {
     $query = DB::table('deals as d')
      ->leftjoin('company as c','c.companyid','d.companyid') 
      ->join('companytypes as ct','ct.companytypeid','c.companytypeid') 
      ->leftjoin('country as cn','cn.countryid','c.countryid')
      ->leftjoin('users as us','us.userid','d.userid')
       ->leftjoin('currency as cur','d.currencyid','cur.currencyid')
       ->leftjoin('tenants as t','d.tenantid','t.tenantid');

     
     $data = $query->select('c.companyid','ct.companytype','c.profileimage as companyprofileimage','t.tenantid','c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.dealid','d.investmentstructure','d.purposeofinvestment','d.projectname','us.profileimage','us.firstname','us.lastname','cur.symbol','c.companyid','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.minilogo as tenantminilogo','t.company as tenantcompany')->get();
 
   
     
     
    return view('adminview.deal',compact('data'));
   }
         public function user()
         {
    $status='Active';
    $status=$status.','.'Inactive';
             
          $users=DB::table('users as us') 
             ->join('usercompanies as uc', 'uc.userid', '=', 'us.userid')
             ->join('company as c','uc.companyid','c.companyid')
             ->join('companytypes as ct','ct.companytypeid','c.companytypeid') 
             ->leftjoin('country as cn','c.countryid','cn.countryid')
             ->leftjoin('tenants as t','us.tenantid','t.tenantid')
             ->wherein('uc.recordstatus',explode(',', $status))
             ->select('t.tenantid','us.userid','us.profileimage as userprofileimage','us.firstname','us.lastname','c.profileimage','c.name','c.companyid','ct.companytype','us.userposition','uc.userrole','uc.recordstatus as Status','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.minilogo as tenantminilogo','t.company as tenantcompany')
             ->get();
            
            
             return view('adminview.user',compact('users'));
   }
       public function duediligence()
   {
       $pipelinedeal=DB::table('pipelinedeals as pd')
               ->leftjoin('deals as dl', 'pd.dealid', 'dl.dealid')
               ->leftjoin('company as c','pd.companyid','c.companyid')
               ->leftjoin('country as cn','c.countryid','cn.countryid')
               ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
               ->leftjoin('currency as cur','dl.currencyid','cur.currencyid')
               ->leftjoin('tenants as t','pd.tenantid','t.tenantid') 
               ->whereNull('pd.parentpipelinedealid')
               ->select('pd.tenantid','pd.pipelinedealid','pd.parentpipelinedealid','c.companyid','c.name as companyname','c.profileimage as companyprofileimage','dl.projectname','dl.investmentstage','dl.totalinvestmentrequired','cn.name as country','dl.dealid','pd.pipelinedealstatus','cur.symbol','ct.companytype','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.minilogo as tenantminilogo','t.company as tenantcompany')->get();
       return view('adminview.duediligence',compact('pipelinedeal'));
   }
   
         public function tenant()
   {
             
          $tenant=DB::table('tenants as te') 
             ->leftjoin('tenants_landingpage as tl', 'te.tenantid', '=', 'tl.tenantid')
             ->where('te.tenantstatus','Verified')
              ->select('te.tenantid','tl.logo as logoimage','te.firstname','te.lastname','te.company as tenantcompany','tl.telephone','tl.address','te.email','te.tenantactive','te.minilogo as minilogoimage')->get();
          //dd($tenant);  
          return view('adminview.tenant',compact('tenant'));

   }
   
   public function gotouser(Request $request)
   {

       Auth::loginUsingId([$request->userid]);
       return redirect()->action('UserController@index');

   }
   public function gotoadmin(Request $request)
   {
       $adminuser = -1;
       $getadmin=DB::table('usercompanies as uc') 
        ->leftjoin('users as u', 'u.userid', '=', 'uc.userid')
        ->where('uc.companyid',$request->companyid)
       ->where('uc.userrole',0)
       ->where('uc.recordstatus','Active')
       ->first();  
       
       
       if(isset($getadmin) && !empty($getadmin))
       {
        //    $getadmin->userid;
           $adminuser = 1;
           
       }
       
       
       if($adminuser > 0)
       {
        // $request->session()->flush();
        Auth::loginUsingId([$getadmin->userid]);
        return redirect()->action('UserController@index');
       }
       else
       {
        session()->flash('adminmsg', 'Sorry not found admin.');
        return redirect()->back();
       }

   }
   
   public function maketenantactive(Request $request)
   {
       $tenantid=$request->tenantid;
       if(isset($tenantid) && !empty($tenantid))
       {
           DB::table('tenants')->where('tenantid',$tenantid)->update(['tenantactive' => '1']);
       }
   }
   public function maketenantinactive(Request $request)
   {
         $tenantid=$request->tenantid;
         if(isset($tenantid) && !empty($tenantid))
       {
           DB::table('tenants')->where('tenantid',$tenantid)->update(['tenantactive' => '0']);
       }
   }
   public function gototenant(Request $request)
   {
       $redirectdash=-1;
       $getadmin=DB::table('tenants_landingpage as tl') 
       ->where('tl.tenantid',$request->tenantid)
      ->first(); 

       
       
       if(isset($getadmin) && !empty($getadmin))
       {
           session(['tenantid'=>$getadmin->tenantid]);

           if(empty($getadmin->logo) || empty($getadmin->telephone) || empty($getadmin->address) || empty($getadmin->open_hours) || empty($getadmin->facebook) || empty($getadmin->twitter) || empty($getadmin->linkedin))
           {
               $redirectdash = 1;
           }
           else
               $redirectdash = 0;
       }
       
       if($redirectdash > 0)
       {
            // return redirect('/edit-landing-page');
             return redirect('/tenant/dashboard');
       }
       else
       {
           //return redirect('/tenant_login');

           return redirect('/logout');
       }
       
       
   }

   public function makecompanyactive(Request $request)
   {
     $companyid=$request->companyid;  
     
    DB::table('company')
            ->where('companyid',$companyid)
            ->update(['activestatus' => 'Active']);      
       
       
   }
   public function makecompanyinactive(Request $request)
   {
       $companyid=$request->companyid; 
       DB::table('company')
            ->where('companyid',$companyid)
            ->update(['activestatus' => 'In-Active']);     
       
   }


   public function openrequestpage()
   {
       return view('adminview.Requests.requests');
   }


   public function get_tenant_requests(Request $request)
   {
       $searchtext=$request->searchtext;
       $sortby=$request->sortby;

         $query = DB::table('tenants as t')
           ->where('t.tenantstatus','Unverified');
         
         if(isset($searchtext) && !empty($searchtext))
         {
          $query->where(function ($query ) use ($searchtext)
                   {
                    $query->Where('t.firstname','like', '%' . $searchtext . '%')
                     ->orWhere('t.lastname','like', '%' . $searchtext . '%')
                     ->orWhere('t.company','like', '%' . $searchtext . '%')
                     ->orWhere('t.email','like', '%' . $searchtext . '%');
                     
                   });
         }

         if(isset($sortby) && !empty($sortby))
         {
             switch ($sortby) {
                 case 'name':
                 $query->orderBy('t.firstname');
                     break;
                    
             }
             
         }
    
         $tenants=$query->select('t.tenantid','t.firstname','t.lastname','t.company','t.email','t.phone','t.address1 as address','t.minilogo as minilogoimage')->get();
         $view=View::make('adminview.Requests._tenant_list',compact('tenants'))->render();
                
         return $view;
   }


   public function get_tenant_previous_requests(Request $request)
   {
       $searchtext=$request->searchtext;
       $sortby=$request->sortby;

         $query = DB::table('request_history as t')
         ->leftjoin('tenants as ot','ot.tenantid','t.entityid')
         ->where('t.type','Tenant');
         
         if(isset($searchtext) && !empty($searchtext))
         {
          $query->where(function ($query ) use ($searchtext)
                   {
                    $query->Where('t.name','like', '%' . $searchtext . '%')
                     ->orWhere('t.email','like', '%' . $searchtext . '%')
                     ->orWhere('t.companytype','like', '%' . $searchtext . '%');
                    });
         }

         if(isset($sortby) && !empty($sortby))
         {
             switch ($sortby) {
                 case 'name':
                 $query->orderBy('t.name');
                     break;
             }
         }
    
         $tenants=$query->select('t.entityid as tenantid','t.name','t.email','t.status','t.datetime','t.companytype','ot.minilogo as minilogoimage')->get();
         $view=View::make('adminview.Requests._tenant_request_history',compact('tenants'))->render();
                
         return $view;
   }


   public function Verify_Decline_Tenant_Requests(Request $request)
   {
       $type=$request->type;
       $tenantid=$request->tenantid;
       $TemplateCode='';
       $helper= \App\Helpers\AppHelper::instance();

       if(!isset($type) || !isset($tenantid))
       {
           return response()->json(['message'=>'Failed']); 
       }

       $user_obj=DB::table('users')->where('tenantid',$tenantid)->where('is_tenant',1)->first();
       $tenant_obj=DB::table('tenants')->where('tenantid',$tenantid)->first();
       if(!isset($user_obj) || !isset($user_obj))
       {
           return response()->json(['message'=>'Failed']); 
       }
       if($type=='Verify')
       {
          DB::update(DB::raw("Update tenants set tenantstatus='Verified',activestatus='Active' where tenantid='$tenantid'"));
          $helper->InsertDefault_DD_Template($tenantid);
          $TemplateCode= \App\Helpers\AppGlobal::$Tenant_Request_Accepted_ToJoin_Artha_TemplateCode;

          DB::table('request_history')->insert(
            [
              'requestid'=>$helper->fnGetUniqueID(16, 'request_history', 'requestid') ,
              'type'=>'Tenant',
              'tenantid'=>$tenantid,
              'entityid'=>$tenantid,
              'name'=>$tenant_obj->firstname.' '.$tenant_obj->lastname,
              'companytype'=>$tenant_obj->company,
              'sectors'=>'',
              'status'=>'Verified',
              'email'=>$tenant_obj->email
            ]);
          
       }
       else if($type=='Decline')
       {
        DB::table('request_history')->insert(
            [
              'requestid'=>$helper->fnGetUniqueID(16, 'request_history', 'requestid') ,
              'type'=>'Tenant',
              'tenantid'=>$tenantid,
              'entityid'=>$tenantid,
              'name'=>$tenant_obj->firstname.' '.$tenant_obj->lastname,
              'companytype'=>$tenant_obj->company,
              'sectors'=>'',
              'status'=>'Declined',
              'email'=>$tenant_obj->email
            ]);

           DB::delete(DB::raw("Delete from tenants where tenantid='$tenantid'"));
           DB::delete(DB::raw("Delete from users where tenantid='$tenantid' and is_tenant=1"));
           DB::delete(DB::raw("Delete from subscriptions where tenant_tenantid='$tenantid'"));
           $TemplateCode= \App\Helpers\AppGlobal::$Tenant_Request_Rejected_ToJoin_Artha_TemplateCode;
       }

              //Sending Tenant Accept/Reject Email
             
              if(isset($TemplateCode) && !empty($TemplateCode))
              {
                $TemplateMaster=DB::table('email_master_templates')->first();
                 if(isset($TemplateMaster))
                 {
                   $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                   if(isset($Template))
                   {
                     $MessageBody=$Template->message;
                     $MessageBody=str_replace("%%CONTACTUS_LINK%%",\App\Helpers\AppGlobal::$Artha_Contact_Us_Link,$MessageBody);
                     $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login';
                     $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                     $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
       
       
                     $Message_with_master= $TemplateMaster->content;   
                     $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$Message_with_master);
                     $Message_with_master=str_replace('%%EMAILCONTENT%%',$MessageBody,$Message_with_master);
       
                                 $forgetpwdlink=\App\Helpers\AppGlobal::$App_Domain.'/forgotpassword';
                                 $Message_with_master=str_replace("%%LOGIN_LINK%%",$loginlink,$Message_with_master);
                                 $Message_with_master=str_replace("%%FORGETPWD_LINK%%",$forgetpwdlink,$Message_with_master);
                                 $t_logo=\App\Helpers\AppGlobal::$Artha_Logo;
                                 $t_logo= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_logo); 
          
                                 $Message_with_master=str_replace("%%EMAIL_LOGO_LINK%%",$t_logo,$Message_with_master);
                                 $Message_with_master=str_replace("%%CONTACTUS_LINK%%",\App\Helpers\AppGlobal::$Artha_Contact_Us_Link,$Message_with_master);
                                 $Message_with_master=str_replace("%%PRIVACYPOLICY_LINK%%",\App\Helpers\AppGlobal::$Artha_Privacy_Policy_Link,$Message_with_master);
                                 $Message_with_master=str_replace("%%COMPANY_NAME%%",\App\Helpers\AppGlobal::$Artha_Company_Name,$Message_with_master);
                                 $Message_with_master=str_replace("%%YEAR%%",date('Y'),$Message_with_master);
                                 $Message_with_master=str_replace("%%COMPANY_ADDRESS%%",\App\Helpers\AppGlobal::$Artha_Company_Address,$Message_with_master);
               
                                 $Message_with_master=$helper->getSocialLinks('email_to_tenant',$tenantid,$Message_with_master);
                                 $Template->fromname=\App\Helpers\AppGlobal::$Artha_From_Name;
                                 $Template->fromemail=\App\Helpers\AppGlobal::$Artha_From_Email;

                                 $email=$user_obj->email;
       
                     $helper->SendEmail($Template,$email,$Message_with_master);
                   }
                 }
       
       
              }
       
              //End of Welcome Email

              return response()->json(['message'=>'Success']); 
   }
   
   
}
