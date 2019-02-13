<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use View;
use Carbon\Carbon;

class DealPipelineController extends Controller
{
    //
public function index()
{

    $actypes=DB::table('accountingcompanytypes')
    ->get();
   $tenantid=session('tenantid');
    if(isset($tenantid)==true)
    {

         $collection_data= [
         'country' => DB::table('country as c')->select('c.countryid as id','c.name')
                   ->where('c.activestatus','1')->get(), 
         'sectors' => DB::table('sectors as s')->select('s.sectorid as id','s.name')
                   ->where('tenantid',session('tenantid'))->get(),
         'investmentstages' => DB::table('investmentstages as is')->select('is.investmentstageid as id','is.stagename as name')
                    ->where('tenantid',session('tenantid'))->get(),        
         'investmentsizes' => DB::table('averageinvestmentsizes as ais')->select('ais.averageinvestmentsizeid as id','ais.investmentsize as name')          
                    ->where('ais.tenantid',session('tenantid'))
                    ->where('ais.activestatus','1')->get(),
         'sdgs' => DB::table('sdg_master as sm')->select('sm.sdgid as id','sm.sdg as name')
                    ->where('sm.tenantid',session('tenantid'))
                    ->where('sm.activestatus','1')->get(),
          
          'dd_status' => DB::table('dd_status as ds')->select('ds.ddstatusid as id'
          	,'ds.ddstatus as name')
                    ->where('ds.tenantid',session('tenantid'))->get(),
                            ]; 
                            
                            

        //   dd($collection_data['dd_status'][0]->id);

        return view('dealpipeline.dealpipelinelisting',compact('collection_data'));

    }
    else
    {
         return redirect()->route('logout');
    }

/*	$companyid=Session('companyid');//40339f8421f111e8
    $pcompanyid="40339f8421f111e8";
  	$deals=DB::select('Call getEnterpriseDeals("$pcompanyid","","","")')->paginate(1);
  	dd($deals);*/

/*  	var $deals=DB::table('deals')

  	DB::table('deals as d')
        ->leftjoin('pipelinedeals as pd', 'pd.dealid', 'd.dealid')
        ->where('pd.companyid','!=',$companyid) 
                   ->where('friends.recordtype','receiver')
                   ->where('friends.tenantid',session('tenantid'))
                   ->select('users.firstname as user_firstname','users.lastname as user_lastname','users.profileimage','companytypes.companytype','company.name as companyname','company.companyid')  
                   ->get(); */


	
}

  public function getDeals(Request $request)
  {
    $userid=Session('userid');
    $companyid=Session('companyid');
    $tenantid=session('tenantid');
    if(isset($tenantid)==false)
    {
        return redirect()->route('logout');
    }

    $pagesize=10;

    $deals_already_working=DB::select(DB::raw("SELECT distinct dealid from pipelinedeals where companyid='$companyid' and tenantid='$tenantid'
                                               UNION
                                               SELECT distinct dealid from pipelinedeals where pipelinedealid in (select pipelinedealid from draft_pipelinedeals where companyid='$companyid'  and tenantid='$tenantid')  and tenantid='$tenantid'
                                               UNION
                                               SELECT distinct dealid from pipelinedeals where pipelinedealid in (select parentpipelinedealid from pipelinedeals where companyid='$companyid' and parentpipelinedealid is not null  and tenantid='$tenantid') and tenantid='$tenantid'
    "));

    $dealids='';
    foreach ($deals_already_working as $key => $value) {

        if ($dealids=="")
        {
         $dealids=$value->dealid;
        }
        else
        {
         $dealids=$dealids.",". $value->dealid;
        }
    }

    // $actual_deals=DB::select(DB::raw("SELECT distinct dealid from deals"));
    // $actual_dealids='';
    // foreach ($actual_deals as $key => $value) {

    //     if ($actual_dealids=="")
    //     {
    //      $actual_dealids=$value->dealid;
    //     }
    //     else
    //     {
    //      $actual_dealids=$actual_dealids.",". $value->dealid;
    //     }
    // }
   
    $query = DB::table('deals as d')
    // ->leftjoin('pipelinedeals as pd', 'pd.dealid', 'd.dealid')
    ->leftjoin('company as c','c.companyid','d.companyid') 
    ->leftjoin('country as cn','cn.countryid','c.countryid')
    ->where('d.dealstatus','=','public')
    ->where('d.deal_active','!=','inactive')
    ->where('d.tenantid', $tenantid)
    ->whereNotIn('d.dealid',explode(",",$dealids))
      ;          
    

  
    $searchtext=$request->searchtext;
    $sortby=$request->sortby;
    $countryids=$request->countryids;//ids
    $sectorids=$request->sectorids;//ids
    $investmentstages=$request->investmentstages;//value
    $investmentsizes=$request->investmentsizes;//value
    $ddstatus=$request->ddstatus;//value
    $sdgs=$request->sdgs;//ids

    if(isset($countryids) && !empty($countryids))
      $query->whereIn('c.countryid', explode(',', $countryids));


    if(isset($investmentstages) && !empty($investmentstages))
    {
        $query->whereIn('d.investmentstage', explode(',', $investmentstages));
    }

    if(isset($investmentsizes) && !empty($investmentsizes))
    {
        $query->whereIn('d.investmentsize', explode(',', $investmentsizes));
    }

    // if(isset($ddstatus) && !empty($ddstatus))
    // {
    //     $query->whereIn('pd.pipelinedealstatus', explode(',', $ddstatus));
    // }

    if(isset($searchtext) && !empty($searchtext))
    {
     $query->where(function ($query ) use ($searchtext)
              {
               $query->where('d.investmentstage', 'like', '%' . $searchtext . '%')
                ->orWhere('c.name','like', '%' . $searchtext . '%')
                ->orWhere('c.statusmessage','like', '%' . $searchtext . '%')
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

    if(isset($sectorids) && !empty($sectorids))
    {
      $query->whereIn('c.companyid', function($q1) use($sectorids) 
        { 
            $q1->select('companyid')->from('companysectors')->whereIn('sectorid', explode(',', $sectorids));
         }
    );
    }
        // ->orderBy('updated', 'desc');
        if(isset($sortby) && !empty($sortby))
        {
            switch ($sortby) {
                case 'company':
                $query->orderBy('c.name');
                    break;
    
                    case 'totalinvestment':
                    $query->orderBy('d.totalinvestmentrequired');
                    break;
                
                default:
                    
                    break;
            }
            
        }
    
    $data = $query->select('d.dealid','c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.currencyid','d.projectname','deal_active')->paginate($pagesize);

    $dealids="";
    $currencyid="";
    $q_dealids="";            
    foreach ($data as $key => $value) {

        if ($dealids=="")
        {
            $dealids=$value->dealid;
            $q_dealids="'".$value->dealid."'";
        }
        else
        {
            $dealids=$dealids.",". $value->dealid;
            $q_dealids=$q_dealids.","."'".$value->dealid."'";
        }
       
    }
        

    $deals_sdgs=DB::table('deal_sdgs as ds')
                ->join('sdg_master as m','m.sdgid','ds.sdgid') 
                ->whereIn('ds.dealid', explode(',', $dealids))
                ->where('ds.tenantid', $tenantid)
                ->select('ds.dealid','m.sdg')
                ->get();
    

    // $deals_dd_parents=DB::select(DB::raw("Select pd.dealid,c.profileimage,c.name as company from pipelinedeals as pd 
    //                   Join company as c on c.companyid=pd.companyid
    //                   Where pd.dealid in ($q_dealids) and pd.parentpipelinedealid is null and pd.startdate is not null 
    //                   and pd.pipelinedealstatus='Due Diligence In Progress'")); 

                      $deals_dd_parents=DB::table('pipelinedeals as pd')
                                       ->join('company as c','c.companyid','pd.companyid')
                                       ->where('pd.tenantid', $tenantid)
                                       ->whereIn('pd.dealid',explode(',', $dealids))
                                       ->Where('pd.pipelinedealstatus','Due Diligence In Progress')
                                       ->WhereNotNull('pd.startdate')
                                       ->WhereNull('pd.parentpipelinedealid')
                                       ->select('pd.dealid','c.profileimage','c.name as company')
                                       ->get();


    if(isset($data[0]) || !empty($data[0]))
    {
    $view=View::make('dealpipeline._deals',compact('data','deals_sdgs','deals_dd_parents'))->render();
    }
    else
    {
        $view=$view='<div class="project-box mar-one-rem"><div class="project-info">'.trans('notfoundlang.deals_pipeline').'</div></div>';
    }
     return $view;
  }

 public function getDealFolders(Request $request)
 {
    $dealid=$request->dealid;
    if(isset($dealid) && !empty($dealid))
    {
        $deal_folders=DB::table('pipelinefolders as pd')
        ->where('pd.tenantid', session('tenantid'))
        ->where('pd.companyid', session('companyid'))
        ->select('pd.folderid','pd.foldername')
        ->get();
        // , 'clickfunction'=>'fnAttachDeal('.$dealid.');'
        $popup_details=array('popupcase'=>'showinterest',
                          'title'=>'Add To My Portfolio',
                          'buttoncaption' =>'Add',
                          'dealid'=>$dealid
                    );
        $view=View::make('dealpipeline._pop_up_show_interest',compact('deal_folders','popup_details'))->render();
        return $view;
    }
 }

 public function attachDealByShowInterest(Request $request)
 {
    $helper= \App\Helpers\AppHelper::instance();
    $userid=Session('userid');
    $tenantid=Session('tenantid');
    $companyid=Session('companyid');
    $folderid=$request->input('folderid');

    $dealid=$request->input('dealid');

    if(isset($companyid) && !empty($companyid))
    {
        if(isset($dealid) && !empty($dealid))
        {
           $pipelinedeal=DB::table('pipelinedeals')
                         ->where('dealid',$dealid) 
                         ->where('companyid',$companyid)
                         ->where('tenantid',$tenantid)
                         ->first();

            if($pipelinedeal==null)   
            {     
                $pipelinedealid=$helper->fnGetUniqueID(16, 'pipelinedeals', 'pipelinedealid');     
            DB::table('pipelinedeals')->insert(
                [
                'pipelinedealid' => $pipelinedealid,
                'tenantid'=> $tenantid,
                'dealid' => $dealid,
                'companyid' => $companyid,
                'pipelinedealstatus' => 'Due Diligence New'
                ]
               );

               DB::table('pipelinedeal_pipelinefolders')->insert(
                [
                'pipelinedealid' => $pipelinedealid,
                'tenantid'=> $tenantid,
                'folderid' => $folderid
                ]
               );

               $actiontaken=\App\Helpers\AppGlobal::$DD_deal_Added;
               $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);

            }




            return response()->json(['status'=>'Success']);
        }
        else
        {
            return response()->json(['status'=>'Deal not available.']);  
        }
    }
    else
    {
        return response()->json(['status'=>'Not logged in.']);  
    }

   
 }

}
