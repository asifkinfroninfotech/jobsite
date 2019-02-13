<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use View;
use Carbon\Carbon;

class MyPortfolioController extends Controller
{
    public function index()
    {

    if(true)
    {
      $pipelinefolders=DB::table('pipelinefolders')->where('companyid',session('companyid'))->where('tenantid', session('tenantid'))->get();
      
      $collection_data= [
        'country' => DB::table('country as c')->select('c.countryid as id','c.name')
                  ->where('c.activestatus','1')->get(), 
        'investmentstages' => DB::table('investmentstages as is')->select('is.investmentstageid as id','is.stagename as name')
                   ->where('tenantid',session('tenantid'))->get(),        

                   'sdgs' => DB::table('sdg_master as sm')->select('sm.sdgid as id','sm.sdg as name')
                   ->where('sm.tenantid',session('tenantid'))
                   ->where('sm.activestatus','1')->get(),
         
         'dd_status' => DB::table('dd_status as ds')->select('ds.ddstatusid as id'
           ,'ds.ddstatus as name')
                   ->where('ds.tenantid',session('tenantid'))->get(),
                           ]; 

      return view('my_portfolio.myportfolio',compact('pipelinefolders','collection_data'));
    }
    else
    {
         return redirect()->route('logout');
    }
    }


    public function GetMyPipelineDeals(Request $request)
    {
      $userid=Session('userid');
      $companyid=Session('companyid');
      $pagesize=3;
      $folderid=$request->folderid;
      $query = DB::table('pipelinedeals as pd')
      ->join('deals as d', 'pd.dealid', 'd.dealid')
      ->leftjoin('company as c','c.companyid','d.companyid') 
      ->leftjoin('country as cn','cn.countryid','c.countryid')
      ->leftjoin('pipelinedeal_pipelinefolders as pdf','pd.pipelinedealid','pdf.pipelinedealid')
      ->leftjoin('pipelinefolders as pf','pf.folderid','pdf.folderid')
      ->leftjoin('currency as cur','d.currencyid','cur.currencyid')        
      ->where('pd.companyid',session('companyid'))
      ->where('pdf.folderid',$folderid)
      ->where('pd.IsPermissionDenied',0);
      // $query->where(function ($query) {
      //     $query->where('pd.companyid','!=', Session('companyid'))
      //           ->orwhereNull('pd.companyid');
      // });
      
      $searchtext=$request->searchtext;
      $sortby=$request->sortby;
      $countryids=$request->countryids;//ids
      // $sectorids=$request->sectorids;//ids
      $investmentstages=$request->investmentstages;//value
      // $investmentsizes=$request->investmentsizes;//value
      $ddstatus=$request->ddstatus;//value
      $sdgs=$request->sdgs;//ids
      $active=$request->active;
  
      if(isset($countryids) && !empty($countryids))
        $query->whereIn('c.countryid', explode(',', $countryids));
  
  
      if(isset($investmentstages) && !empty($investmentstages))
      {
          $query->whereIn('d.investmentstage', explode(',', $investmentstages));
      }
  
      // if(isset($investmentsizes) && !empty($investmentsizes))
      // {
      //     $query->whereIn('d.investmentsize', explode(',', $investmentsizes));
      // }
  
      if(isset($ddstatus) && !empty($ddstatus))
      {
          $query->whereIn('pd.pipelinedealstatus', explode(',', $ddstatus));
      }
  
      if(isset($searchtext) && !empty($searchtext))
      {
       $query->where(function ($query ) use ($searchtext)
                {
                 $query->where('d.investmentstage', 'like', '%' . $searchtext . '%')
                  ->orWhere('c.name','like', '%' . $searchtext . '%')
                  ->orWhere('c.statusmessage','like', '%' . $searchtext . '%')
                  ->orWhere('d.projectname', 'like', '%' . $searchtext . '%')
                  ->orWhere('cn.name','like', '%' . $searchtext . '%');
                });
      }
  
      if(isset($sdgs) && !empty($sdgs))
      {
          $query->whereIn('d.dealid', function($q2) use($sdgs) 
          { 
              $q2->select('dealid')->from('deal_sdgs')->whereIn('sdgid', explode(',', $sdgs));
           }
      );
      }
  
      

          if(isset($sortby) && !empty($sortby))
          {
              switch ($sortby) {
                  case 'Name':
                  $query->orderBy('d.projectname');
                      break;
      
                      case 'Investment':
                      $query->orderBy('d.totalinvestmentrequired');
                      break;
                  
                  default:
                      
                      break;
              }
              
          }
          
              if(isset($active) && !empty($active))
   {
    $query->where(function ($query ) use ($active)
             {
               $query->where('d.deal_active','=', $active);
             });
   }
          

          $data = $query->select('pd.pipelinedealid','pd.parentpipelinedealid','d.dealid','c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country'
          ,'d.totalviews','d.totalinvestmentrequired','cur.symbol','pf.foldername','pd.pipelinedealstatus','pd.startdate','pd.completeddate','d.projectname','d.companyid','d.deal_active')->paginate($pagesize);

          $dealids="";
         
          foreach ($data as $key => $value) {
      
              if ($dealids=="")
              {
                  $dealids=$value->dealid;
              }
              else
              {
                  $dealids=$dealids.",". $value->dealid;
              }
             
          }
      
          $deals_sdgs=DB::table('deal_sdgs as ds')
                      ->join('sdg_master as m','m.sdgid','ds.sdgid') 
                      ->whereIn('ds.dealid', explode(',', $dealids))
                      ->select('ds.dealid','m.sdg')
                      ->get();

                      $companyids="";
                      $pipelinedealids="";
                      $parent_pipelinedealids="";
                      foreach ($data as $key => $value) {
                  
                          if ($companyids=="")
                          {
                              $companyids=$value->companyid;
                              if(isset($value->parentpipelinedealid) && !empty($value->parentpipelinedealid))
                              {
                                $pipelinedealids="'".$value->parentpipelinedealid."'";
                                $parent_pipelinedealids=$value->parentpipelinedealid;
                              }
                              else
                              {
                                $pipelinedealids="'".$value->pipelinedealid."'";
                                $parent_pipelinedealids=$value->pipelinedealid;
                              }
                          
                          }
                          else
                          {
                              $companyids=$companyids.",". $value->companyid;
                              if(isset($value->parentpipelinedealid) && !empty($value->parentpipelinedealid))
                              {
                                $pipelinedealids= $pipelinedealids.",'". $value->parentpipelinedealid."'";
                                $parent_pipelinedealids=$parent_pipelinedealids.",".$value->parentpipelinedealid;
                              }
                              else
                              {
                                $pipelinedealids= $pipelinedealids.",'". $value->pipelinedealid."'";
                                $parent_pipelinedealids=$parent_pipelinedealids.",".$value->pipelinedealid;
                              }
                              
                          }
                      }

                      $deal_company_users=DB::table('usercompanies as uc')
                                          ->join('deals as d','uc.companyid','d.companyid')
                                          ->join('users as u','u.userid','uc.userid')
                                          ->whereIn('uc.companyid', explode(',', $companyids))
                                          ->where('uc.recordstatus','Active')
                                          ->select('d.dealid','uc.companyid','uc.userid','u.firstname','u.lastname','u.profileimage')
                                          ->get();

                    $loggedin_company_users=DB::table('usercompanies as uc')
                                          ->join('users as u','u.userid','uc.userid')
                                          ->where('uc.companyid', session('companyid'))
                                          ->where('uc.recordstatus','Active')
                                          ->select('uc.companyid','uc.userid','u.firstname','u.lastname','u.profileimage')
                                          ->get();

                    $modulequestionstatus;
                    if(isset($pipelinedealids) && !empty($pipelinedealids))
                    {
                    $modulequestionstatus=DB::select(DB::raw("SELECT pd.pipelinedealid,
                    (select Count(*) from dd_questions where pipelinedealid=pd.pipelinedealid) as tquestions ,
                    (select Count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and questionstatus='Completed') as completedquestions, 
                    (select count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and questionstatus='Pending' and userid is not null)  as progress 
                    FROM pipelinedeals as pd where pd.pipelinedealid in ($pipelinedealids)"));  
                    
                    if(isset($modulequestionstatus) || !empty($modulequestionstatus))
                    {
                    $modulequestionstatus=json_encode($modulequestionstatus);
                    }

                    }                    
 

                  $pipelinefolders=DB::table('pipelinefolders')->where('companyid',session('companyid'))->where('tenantid', session('tenantid'))->get();   
                     
                      //$view=View::make('my_portfolio._attached_deals',compact('data','deals_sdgs','deal_company_users','loggedin_company_users','modulequestionstatus','pipelinefolders'))->render();
                      
                  $parent_pipelinedeal_data=DB::table('pipelinedeals')
                                            ->WhereIn('pipelinedealid',explode(",",$parent_pipelinedealids))
                                            ->select('pipelinedealid','parentpipelinedealid','tenantid','dealid','companyid','pipelinedealstatus','updated','startdate','completeddate')
                                            ->get();
                                            
                    
                                            $helper= \App\Helpers\AppHelper::instance();
                                            $All_Associated_company=$helper->get_All_Associated_Companies($pipelinedealids);
                                            if(isset($All_Associated_company) && !empty($All_Associated_company))
                                            {
                                            $All_Associated_company=json_encode($All_Associated_company);
                                            }                           
                      
                  if(isset($data[0]))
                  {
                   $view=View::make('my_portfolio._attached_deals',compact('data','deals_sdgs','deal_company_users','loggedin_company_users','modulequestionstatus','pipelinefolders','parent_pipelinedeal_data','All_Associated_company'))->render();
                   return $view;
                  }
                  else
                  {
                   $view='<div class="project-box mar-one-rem"><div class="project-info">'.trans('notfoundlang.my_portfolio').'</div></div>';
                   echo $view;
                  }

    }



    public function CreateNewPipelineFolder(Request $request)
    {
          $foldername=$request->input('foldername');

          $checkfor_duplicate=DB::table('pipelinefolders')
          ->where('tenantid',session('tenantid'))
          ->where('companyid',session('companyid'))
          ->where('foldername',$foldername)
          ->get();

          if($checkfor_duplicate!=null && count($checkfor_duplicate)>0)
          {
            return response()->json(['status'=>'Duplicate']);
          }
          else
          {
            $helper= \App\Helpers\AppHelper::instance();
             DB::table('pipelinefolders')->insert(
               [
                 'folderid'=>$helper->fnGetUniqueID(16, 'pipelinefolders', 'folderid') ,
                 'companyid'=>session('companyid'),
                 'tenantid'=>session('tenantid'),
                 'foldername'=>$foldername
               ]);
               return response()->json(['status'=>'Success']);
          }
    }

    public function ChangePipelineDealFolder(Request $request)
    {
        $pipelinedealid=$request->input('pipelinedealid');
        $folderid=$request->input('folderid');

        DB::table('pipelinedeal_pipelinefolders')->where('pipelinedealid',$pipelinedealid)
      ->update(
        [
        'folderid' => $request->input('folderid'),
        ]
       );
       return response()->json(['status'=>'Success']);

    }


    public function startpipelinedeal(Request $request)
    {
        $pipelinedealid=$request->input('pipelinedealid');
        $startdate=date('Y-m-d');
        DB::table('pipelinedeals')->where('pipelinedealid',$pipelinedealid)
        ->update(
          [
          'pipelinedealstatus' => 'Due Diligence In Progress',
          'startdate' => $startdate
          ]
         );

         $mgroup=DB::table('pipelinedeal_message_groups')
         ->where('pipelinedealid',$pipelinedealid)
         ->where('grouptype','General')
         ->where('tenantid',session('tenantid'))
         ->first();
         $helper= \App\Helpers\AppHelper::instance();
         
         if(isset($mgroup)==false)
         {
            DB::table('pipelinedeal_message_groups')->insert(
                [
                  'groupid'=>$helper->fnGetUniqueID(16, 'pipelinedeal_message_groups', 'groupid'),
                  'pipelinedealid'=>$pipelinedealid,
                  'tenantid'=>session('tenantid'),
                  'groupname'=>'General',
                  'activestatus'=>'Active',
                  'grouptype'=>'General'

                ]);
         }

         $actiontaken=\App\Helpers\AppGlobal::$DD_started;
         $userid=session('userid');
         $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
         if(isset($user_obj))
         {
           $name=$user_obj->firstname.' '.$user_obj->lastname;  
           $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
           $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
         }
         $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);

         return response()->json(['status'=>'Success']);
    }

    
    
    public function active(Request $request)
        {
            if(isset($request->userid)&& !empty($request->userid))
            {
              DB::statement("UPDATE deals SET deal_active = 'active' where dealid = '".$request->userid."'");
            
              return response()->json(['message'=>'Success']); 
            }
        }
        public function inactive(Request $request)
        {
             if(isset($request->userid)&& !empty($request->userid))
            {
              DB::statement("UPDATE deals SET deal_active = 'inactive' where dealid = '".$request->userid."'");
            
              return response()->json(['message'=>'Success']); 
            }
        }
        public function archive(Request $request)
        {
            if(isset($request->userid)&& !empty($request->userid))
            {
              DB::statement("UPDATE deals SET deal_active = 'archive' where dealid = '".$request->userid."'");
            
              return response()->json(['message'=>'Success']); 
            } 
        }
    
    
    
    
}
