<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Avatar;
use View;



class CompanyController extends Controller
{

    public function view(Request $request) {

     $otherUserView="No"; 
     $calledfrom=$request->calledfrom;

      
      if(isset($request->calledfrom) && !empty($request->calledfrom) && $request->calledfrom=="tenant")
      {
      $getadmin=DB::table('usercompanies as uc') 
        ->where('uc.companyid',$request->company)
        ->leftjoin('users as us', 'uc.userid', '=', 'us.userid')
        ->where('uc.userrole',0)
        ->first();  
       session(['userid'=> $getadmin->userid]);
 
      }
          
      
      $quserid=Session('userid');//$request->user;

           //Code for friend  
         $getfriend=DB::table('friends as f')
        ->where('f.userid','=',session('userid'))
        ->select('userid','friendid','recordtype')        
        ->get(); 
            
          //
      $qcompanyid=$request->company;
      $qcompanytype=$request->companytype;
      if((isset($qcompanyid) && !empty($qcompanyid) ) && (isset($qcompanytype) && !empty($qcompanytype) ))
      {

      }
      else{
        $qcompanyid = session('companyid');
        $qcompanytype=session('usertype');
      }

            // - Starts (harshita) - //
       
            $tenantid = Session('tenantid');
            $usercompany = session('companyid');
            $reqviewcompany = $qcompanyid;
            if (trim($reqviewcompany) != '' && trim($reqviewcompany) != trim($usercompany)) {
                $otherUserView="Yes"; 
                $whereArr = array(
                    'companyid' => $reqviewcompany,
                    'visitdate' => date('Y-m-d', time()),
                );
                $visitor_info = DB::table('companyvisitors')->where($whereArr)->first();
                if (!empty($visitor_info)) {
                    $id = $visitor_info->companyvisitorid;
                    $count = intval($visitor_info->visitorcount) + 1;
                    DB::table('companyvisitors')->where('companyvisitorid', $id)->update(['visitorcount' => $count]);
                   
                } else {
                    $insArr = array(
                        'companyid' => $reqviewcompany,
                        'visitorcount' => 1,
                        'visitdate' => date('Y-m-d', time()),
                        'tenantid' => $tenantid,
                    );
                    DB::table('companyvisitors')->insert($insArr);
                }
            }
            
            // - Ends (harshita) - //
        $puplic_doc_count = DB::select(DB::raw("Select Count(*) as c from documents where companyid='$qcompanyid' and documentstatus='Public'"))[0]->c;
        $private_doc_count = DB::select(DB::raw("Select Count(*) as c from documents where companyid='$qcompanyid' and documentstatus='Private'"))[0]->c;

        //New Code To Display Deals Data

        $session_Companyid=session('companyid');
        $deals_already_working=DB::select(DB::raw("SELECT distinct dealid from pipelinedeals where companyid='$session_Companyid' and tenantid='$tenantid'
        UNION
        SELECT distinct dealid from pipelinedeals where pipelinedealid in (select pipelinedealid from draft_pipelinedeals where companyid='$session_Companyid'  and tenantid='$tenantid')  and tenantid='$tenantid'
        UNION
        SELECT distinct dealid from pipelinedeals where pipelinedealid in (select parentpipelinedealid from pipelinedeals where companyid='$session_Companyid' and parentpipelinedealid is not null  and tenantid='$tenantid') and tenantid='$tenantid'
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

$query = DB::table('deals as d')
->leftjoin('company as c','c.companyid','d.companyid') 
->leftjoin('country as cn','cn.countryid','c.countryid')
->where('d.dealstatus','=','public')
->where('d.deal_active','!=','inactive')
->where('d.tenantid', $tenantid)
->whereNotIn('d.dealid',explode(",",$dealids))
->where('d.companyid',$qcompanyid);

$query->orderBy('d.updated');

$deals = $query->select('d.companyid','d.dealid','c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.currencyid','d.projectname','deal_active')->get();

$dealids="";
$currencyid="";
$q_dealids="";            
foreach ($deals as $key => $value) {

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

            $deals_dd_parents=DB::table('pipelinedeals as pd')
            ->join('company as c','c.companyid','pd.companyid')
            ->where('pd.tenantid', $tenantid)
            ->whereIn('pd.dealid',explode(',', $dealids))
            ->Where('pd.pipelinedealstatus','Due Diligence In Progress')
            ->WhereNotNull('pd.startdate')
            ->WhereNull('pd.parentpipelinedealid')
            ->select('pd.dealid','c.profileimage','c.name as company')
            ->get();


            
            // $gallery_images=DB::table('gallery as g')
            //       ->where('g.userid',$quserid)
            //       ->where('g.companyid',$qcompanyid)
            //       ->where('g.type','Image')
            //       ->get();

            $gallery_images=DB::select(DB::raw("SELECT * FROM gallery where companyid = '$qcompanyid' and type = 'Image'"));

            $gallery_videos=DB::table('gallery as g')
                 ->where('g.companyid',$qcompanyid)
                 ->where('g.type','Video')
                 ->get();                  

           


        //End Of New Code To Display Deals


        if($qcompanytype== "Enterprises") {
          
       
          $company_information = DB::table('company')->where('companyid', $qcompanyid)->first();
          $country = DB::table('country')->select('name')->where( 'countryid', $company_information->countryid )->first();
          $members = DB::table('usercompanies')
                               ->select('userid')
                               ->where('userid', '!=' , $quserid )
                               ->where('companyid', $qcompanyid)
                               ->where('recordstatus','=','Active')
                               ->get();

          $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();

          $sectors=array();
          if($sector_id->isNotEmpty()) {
              foreach ($sector_id as $sectorid) {
                    $sectors[] =  DB::table('sectors')
                          ->select('name')
                          ->where('sectorid', $sectorid->sectorid )
                          ->first();
              }
          }

          $prefered_by = DB::table('company')
                                    ->select('name')
                                    ->where('referredbyid', $company_information->referredbyid )
                                    ->first();
          $entity_type = DB::table('accountingcompanytypes')
                                    ->select('companytype')
                                    ->where('accountingcompanytypeid', $company_information->accountingcompanytype )
                                    ->first();
          $currency = DB::table('currency')
                                    ->select('currencyname','code','symbol')
                                    ->where('currencyid', $company_information->preferedcurrencyid )
                                    ->first();                                                
                              
          $historical_data = DB::table('company_financialinfo_past')
                            ->select('historical_year', 'averageannualrevenue', 'annualoperatingcosts', 'averagenetincome')
                            ->where('companyid', $qcompanyid)
                            ->get();
          $documents = DB::table('documents')
                            ->where('companyid', $qcompanyid)
                            ->get() ;
          $videofile = DB::table('companyvideos')
                            ->where('companyid', $qcompanyid)
                            ->first() ;

          $team_members=array();
          foreach ($members as $member) {
            $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
          } 
          
          $data = [
                  'company_information' => $company_information,
                  'country' => $country,
                  'sectors' => $sectors,
                  'documents' => $documents,
                  'historical_data' => $historical_data,
                  'videofile' => $videofile,
                  'team_member' => $team_members,
                  'entity_type' => $entity_type,
                  'currency' => $currency,
                  'prefered_by' => $prefered_by,
                  'friends'=> $getfriend,
                  'puplic_doc_count'=>$puplic_doc_count,
                  'private_doc_count'=>$private_doc_count,
          ]; 
           
          return view('enterprise.profile_view', compact('data','calledfrom','otherUserView','deals','deals_sdgs','deals_dd_parents','gallery_images','gallery_videos'));

        } elseif ($qcompanytype == 'Investors' ) {

          $company_information = DB::table('company')->where('companyid', $qcompanyid)->first();
          
          $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();

          $sectors=array();
          if($sector_id->isNotEmpty()) {
              foreach ($sector_id as $sectorid) {
                    $sectors[] =  DB::table('sectors')
                          ->select('name')
                          ->where('sectorid', $sectorid->sectorid )
                          ->first();
              }
          }
         

          // dd($sectors);
          /*$sectors =  DB::table('sectors')
                               ->select('name')
                               ->where('sectorid', DB::table('companysectors')
                                                         ->select('sectorid')
                                                         ->where('companyid', session('companyid') )
                                                         ->first()->sectorid
                                      )
                               ->first();*/
          $country = DB::table('country')->select('name')->where( 'countryid', $company_information->countryid )->first();
          $members = DB::table('usercompanies')
          ->select('userid')
          ->where('userid', '!=' , $quserid )
          ->where('companyid', $qcompanyid)
//          ->where('recordstatus','!=','Deleted')
//          ->where('recordstatus','!=','Invited')
          ->where('recordstatus','=','Active')        
          ->get();
          $documents = DB::table('documents')
                              ->where('companyid', $qcompanyid)
                              ->get() ;
          $videofile = DB::table('companyvideos')
                              ->where('companyid', $qcompanyid)
                              ->first() ;
          $team_members=array();  
          foreach ($members as $member) {
            $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
          }                    
          
           $currencysymbol = DB::table('currency')
                     ->select('symbol')
                     ->where('currencyid', $company_information->currencyid)
                     ->first();
          
          
           if(!isset($currencysymbol) || empty($currencysymbol))
           {
               $currencysymbol=(object)array("symbol"=>'£');
              // $currencysymbol->symbol='ed477d';
           }
           
           
           
          $data = [
                    'company_information' => $company_information,
                    'sectors' => $sectors,
                    'documents' => $documents,
                    'videofile' => $videofile,
                    'team_member' => $team_members,
                    'country' => $country,
                    'currencysymbol' => $currencysymbol,
                    'friends'=>$getfriend,
                     'puplic_doc_count'=>$puplic_doc_count,
             'private_doc_count'=>$private_doc_count,
          ]; 
          
          return view('investor.profile_view', compact('data','calledfrom','otherUserView','deals','deals_sdgs','deals_dd_parents','gallery_images','gallery_videos'));

        } elseif($qcompanytype == 'ESOs') {

          $company_information = DB::table('company')->where('companyid', $qcompanyid)->first();
          $members = DB::table('usercompanies')
          ->select('userid')
          ->where('userid', '!=' , $quserid )
          ->where('companyid', $qcompanyid)
//          ->where('recordstatus','!=','Deleted')
//          ->where('recordstatus','!=','Invited')
          ->where('recordstatus','=','Active')        
          ->get();
          $team_size = DB::table('teamsize')
                                    ->select('teamsize')
                                    ->where('teamsizeid', $company_information->teamsizeid )
                                    ->first();
          $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();

          $sectors=array();
          if($sector_id->isNotEmpty()) {
              foreach ($sector_id as $sectorid) {
                    $sectors[] =  DB::table('sectors')
                          ->select('name')
                          ->where('sectorid', $sectorid->sectorid )
                          ->first();
              }
          }
                                    
          $state = DB::table('state')
                                    ->select('name')
                                    ->where('stateid', $company_information->stateid )
                                    ->first();
          $country = DB::table('country')
                                    ->select('name')
                                    ->where('countryid', $company_information->countryid )
                                    ->first();                                                    
          $documents = DB::table('documents')
                              ->where('companyid', $qcompanyid)
                              ->get() ;
          $videofile = DB::table('companyvideos')
                              ->where('companyid', $qcompanyid)
                              ->first() ;
         
          $team_members=array();  
          foreach ($members as $member) {
            $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
          }                    
          
          $data = [
                    'company_information' => $company_information,
                    'sectors' => $sectors,
                    'documents' => $documents,
                    'videofile' => $videofile,
                    'team_member' => $team_members,
                    'team_size' => $team_size,
                    'country' => $country,
                    'state' => $state,
                    'friends'=>$getfriend,
                     'puplic_doc_count'=>$puplic_doc_count,
             'private_doc_count'=>$private_doc_count, 
          ]; 
          
          return view('eso.profile_view', compact('data','calledfrom','otherUserView','deals','deals_sdgs','deals_dd_parents','gallery_images','gallery_videos') );

        } else {

          $company_information = DB::table('company')->where('companyid', $qcompanyid)->first();
          $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();

                     $cc_id= DB::table('company_corecompetency')
                     ->select('corecompetency_id')
                     ->where('companyid', $qcompanyid )
                     ->get();

                     $sectors=array();
          if($sector_id->isNotEmpty()) {
              foreach ($sector_id as $sectorid) {
                    $sectors[] =  DB::table('sectors')
                          ->select('name')
                          ->where('sectorid', $sectorid->sectorid )
                          ->first();
              }
          }
          
          

          $core_competency=array();
        
           if($cc_id->isNotEmpty()) {
              foreach ($cc_id as $ccid) {
                    $cc[] =  DB::table('corecompetencies')
                          ->select('corecompetency')
                          ->where('corecompetencyid', $ccid->corecompetency_id )
                          ->first();
              }
          }
          $members = DB::table('usercompanies')
          ->select('userid')
          ->where('userid', '!=' , $quserid )
          ->where('companyid', $qcompanyid)
//          ->where('recordstatus','!=','Deleted')
//          ->where('recordstatus','!=','Invited')
          ->where('recordstatus','=','Active')        
          ->get();
          $documents = DB::table('documents')
                              ->where('companyid', $qcompanyid)
                              ->get() ;
          $state = DB::table('state')
                                    ->select('name')
                                    ->where('stateid', $company_information->stateid )
                                    ->first();
          $country = DB::table('country')
                                    ->select('name')
                                    ->where('countryid', $company_information->countryid )
                                    ->first(); 
                                                        
          $videofile = DB::table('companyvideos')
                              ->where('companyid', $qcompanyid)
                              ->first() ;

          $team_members=array();                 
          foreach ($members as $member) {
            $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
          }                    
          
          $data = [
                    'company_information' => $company_information,
                    'sectors' => $sectors,
                    'documents' => $documents,
                    'videofile' => $videofile,
                    'team_member' => $team_members,
                    'country' => $country,
                    'state' => $state,
                    'core_competency'=>isset($cc)==true?$cc:'',
                    'friends'=>$getfriend,
                     'puplic_doc_count'=>$puplic_doc_count,
             'private_doc_count'=>$private_doc_count,
          ]; 
          
          return view('service_provider.profile_view', compact('data','calledfrom','otherUserView','deals','deals_sdgs','deals_dd_parents','gallery_images','gallery_videos') );
        }
    
    }

    public function edit( Request $request ) {

        if(session('usertype') == "Enterprises") { 
        
        $company_information = DB::table('company')->where('companyid', session('companyid'))->first();
        $companycurrency='';
        if(isset($company_information->preferedcurrencyid) && !empty($company_information->preferedcurrencyid))
        {
          $companycurrency= DB::table('currency')
          ->where('currencyid',$company_information->preferedcurrencyid)
          ->first();
        }
        else
        {
          $companycurrency= DB::table('currency')
          ->where('code',\App\Helpers\AppGlobal::$Default_Currency_Code)
          ->first();
        }

        $countries = [
                        'total_countries' => DB::table('country')
                                                    ->select('name','countryid')
                                                    ->get()->toArray(),
                        'selected_country' => DB::table('company')
                                                    ->select('countryid')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first(),
                        'current_country' => DB::table('country')
                                                    ->select('name')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first()
                                                  
        ];
        $FillableStates;
        if($company_information->countryid!=null)
        {
          $FillableStates=DB::table('state')->where('countryid',$company_information->countryid)->select('name','stateid')->get()->toArray();
        }
        else
        {
          $FillableStates=DB::table('state')->select('name','stateid')->get()->toArray();
        }

        $states = [
                    'total_states' => $FillableStates,//DB::table('state')->select('name','stateid')->get()->toArray(),
                    'selected_state' => DB::table('company')
                                                  ->select('stateid')
                                                  ->where('stateid', $company_information->stateid )
                                                  ->first()
        ];

        $referred_by = [
                         'total_users' => DB::table('users')
                                                   ->select('username','userid','firstname','lastname')
                                                   ->where('userid', '!=' , session('userid'))
                                                   ->get()
                                                   ->toArray(),
                         'selected_user' => DB::table('company')
                                                    ->select('referredbyid')
                                                    ->where('referredbyid', $company_information->referredbyid )
                                                    ->first()
        ]; 
                      
        $currency =  [
                        'all_currency' => DB::table('currency')
                                                  ->select('currencyid','currencyname')
                                                  ->get()
                                                  ->toArray(),

                        'selected_currency' =>  DB::table('company')
                                                  ->select('preferedcurrencyid')
                                                  ->where('companyid', session('companyid'))
                                                  ->first()  
        ];  

        $entity_type =  [
                        'entity' => DB::table('accountingcompanytypes')
                                                  ->select('accountingcompanytypeid','companytype')
                                                  ->get()
                                                  ->toArray(),

                        'selected_entity' =>  DB::table('company')
                                                  ->select('accountingcompanytype')
                                                  ->where('companyid', session('companyid'))
                                                  ->first()  
        ];        
                  
        $sectors = [
                     'total_sectors' => DB::table('sectors')->select('name','sectorid')->get()->toArray(),
                     'selected_sector' => DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray()
        ];

                   
        $fundsundermanagement = DB::table('fundsundermanagement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();
        $averageinvestmentsizes = DB::table('averageinvestmentsizes')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();  
        $levelofinvolvement = DB::table('levelofinvolvement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();    

        
        $historical_data = DB::table('company_financialinfo_past')
                            ->select('historical_year', 'averageannualrevenue', 'annualoperatingcosts', 'averagenetincome')
                            ->where('companyid', session('companyid'))
                            ->get();
        
        $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
        $videofile = DB::table('companyvideos')
                            ->where('companyid', session('companyid'))
                            ->first();                    
        $data = [ 
                  'company_information' => $company_information,
                  'fundsundermanagement' => $fundsundermanagement,
                  'averageinvestmentsizes' => $averageinvestmentsizes,
                  'historical_data' => $historical_data,
                  'levelofinvolvement' => $levelofinvolvement,
                  'countries' => $countries,
                  'currency' => $currency,
                  'entity_type' => $entity_type,
                  'states' => $states,
                  'sectors' => $sectors,
                  'referred_by' => $referred_by,
                  'documents' => $documents,
                  'videofile' => $videofile,
                  'companycurrency'=>$companycurrency
        ];
            // dd($data['company_information']);
        return view('enterprise.profile_edit', compact('data'));


        } elseif ( session('usertype') == 'Investors' ) {

        $company_information = DB::table('company')->where('companyid', session('companyid'))->first();
        $countries = [
                        'total_countries' => DB::table('country')
                                                    ->select('name','countryid')
                                                    ->get()->toArray(),
                        'selected_country' => DB::table('company')
                                                    ->select('countryid')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first(),
                        'current_country' => DB::table('country')
                                                    ->select('name')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first()
                                                  
        ];
        $FillableStates;
        if($company_information->countryid!=null)
        {
          $FillableStates=DB::table('state')->where('countryid',$company_information->countryid)->select('name','stateid')->get()->toArray();
        }
        else
        {
          $FillableStates=DB::table('state')->select('name','stateid')->get()->toArray();
        }

        $states = [
                    'total_states' => $FillableStates,//DB::table('state')->select('name','stateid')->get()->toArray(),
                    'selected_state' => DB::table('company')
                                                  ->select('stateid')
                                                  ->where('stateid', $company_information->stateid )
                                                  ->first()
        ];

        $sectors = [
                     'total_sectors' => DB::table('sectors')->select('name','sectorid')->get()->toArray(),
                     'selected_sector' => DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray()
        ]; 
        $fundsundermanagement = DB::table('fundsundermanagement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();
        $averageinvestmentsizes = DB::table('averageinvestmentsizes')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();  
        $levelofinvolvement = DB::table('levelofinvolvement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();    
        $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get() ;
        $videofile = DB::table('companyvideos')
                            ->where('companyid', session('companyid'))
                            ->first() ; 
        $currency=DB::table('currency')->get();       
        $currencyid=$company_information->currencyid;
        
                                                                                
        $data = [ 
                  'company_information' => $company_information,
                  'countries' => $countries,
                  'states' => $states,
                  'sectors' => $sectors,
                  'fundsundermanagement' => $fundsundermanagement,
                  'averageinvestmentsizes' => $averageinvestmentsizes,
                  'levelofinvolvement' => $levelofinvolvement,
                  'documents' => $documents,
                  'videofile' => $videofile,
                  'currency' => $currency,
                  'currencyid' => $currencyid,
        ];
        
        return view('investor.profile_edit', compact('data'));

        } elseif(session('usertype') == 'ESOs') {

        $company_information = DB::table('company')->where('companyid', session('companyid'))->first();
        $team_size = [
                       'teamsize' => DB::table('teamsize')
                                                     ->select('teamsize','teamsizeid')
                                                     ->get()->toArray(),
                       'selected_teamsize' => DB::table('company')
                                                    ->select('teamsizeid')
                                                    ->where('teamsizeid', $company_information->teamsizeid )
                                                    ->first()
        ];
        $countries = [
                        'total_countries' => DB::table('country')
                                                    ->select('name','countryid')
                                                    ->get()->toArray(),
                        'selected_country' => DB::table('company')
                                                    ->select('countryid')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first(),
                        'current_country' => DB::table('country')
                                                    ->select('name')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first()
                                                  
        ];
        $FillableStates;
        if($company_information->countryid!=null)
        {
          $FillableStates=DB::table('state')->where('countryid',$company_information->countryid)->select('name','stateid')->get()->toArray();
        }
        else
        {
          $FillableStates=DB::table('state')->select('name','stateid')->get()->toArray();
        }

        $states = [
                    'total_states' => $FillableStates,//DB::table('state')->select('name','stateid')->get()->toArray(),
                    'selected_state' => DB::table('company')
                                                  ->select('stateid')
                                                  ->where('stateid', $company_information->stateid )
                                                  ->first()
        ];

        $sectors = [
                     'total_sectors' => DB::table('sectors')->select('name','sectorid')->get()->toArray(),
                     'selected_sector' => DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray()
        ]; 
        $fundsundermanagement = DB::table('fundsundermanagement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();
        $averageinvestmentsizes = DB::table('averageinvestmentsizes')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();  
        $levelofinvolvement = DB::table('levelofinvolvement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();    
        $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get() ;
        $videofile = DB::table('companyvideos')
                            ->where('companyid', session('companyid'))
                            ->first() ;                    
                                                                                
        $data = [ 
                  'company_information' => $company_information,
                  'countries' => $countries,
                  'states' => $states,
                  'sectors' => $sectors,
                  'fundsundermanagement' => $fundsundermanagement,
                  'team_size' => $team_size,
                  'averageinvestmentsizes' => $averageinvestmentsizes,
                  'levelofinvolvement' => $levelofinvolvement,
                  'documents' => $documents,
                  'videofile' => $videofile,
        ];  //dd($data['sectors']);
        
        return view('eso.profile_edit', compact('data'));

        } else {

          $company_information = DB::table('company')->where('companyid', session('companyid'))->first();
        $countries = [
                       'total_countries' => DB::table('country')
                                                    ->select('name','countryid')
                                                    ->get()->toArray(),
                       'selected_country' => DB::table('company')
                                                    ->select('countryid')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first(),
                      'current_country' => DB::table('country')
                                                    ->select('name')
                                                    ->where('countryid', $company_information->countryid )
                                                    ->first()
                                    
        ];

        $FillableStates;
        if($company_information->countryid!=null)
        {
          $FillableStates=DB::table('state')->where('countryid',$company_information->countryid)->select('name','stateid')->get()->toArray();
        }
        else
        {
          $FillableStates=DB::table('state')->select('name','stateid')->get()->toArray();
        }

        $states = [
                    'total_states' => $FillableStates,//DB::table('state')->select('name','stateid')->get()->toArray(),
                    'selected_state' => DB::table('company')
                                                  ->select('stateid')
                                                  ->where('stateid', $company_information->stateid )
                                                  ->first()
        ];

        $referred_by = [
                         'total_users' => DB::table('users')
                                                   ->select('username','userid')
                                                   ->where('userid', '!=' , session('userid'))
                                                   ->get()
                                                   ->toArray(),
                         'selected_user' => DB::table('company')
                                                    ->select('referredbyid')
                                                    ->where('referredbyid', $company_information->referredbyid )
                                                    ->first()
        ]; 
                      
        $currency =  [
                        'all_currency' => DB::table('currency')
                                                  ->select('currencyid','currencyname')
                                                  ->get()
                                                  ->toArray(),

                        'selected_currency' =>  DB::table('company')
                                                  ->select('preferedcurrencyid')
                                                  ->where('companyid', session('companyid'))
                                                  ->first()  
        ];  

        $entity_type =  [
                        'entity' => DB::table('accountingcompanytypes')
                                                  ->select('accountingcompanytypeid','companytype')
                                                  ->get()
                                                  ->toArray(),

                        'selected_entity' =>  DB::table('company')
                                                  ->select('accountingcompanytype')
                                                  ->where('companyid', session('companyid'))
                                                  ->first()  
        ];        
                  
        $sectors = [
                     'total_sectors' => DB::table('sectors')->select('name','sectorid')->get()->toArray(),
                     'selected_sector' => DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray()
        ];  //dd($sectors);

        $cc = [
          'total_cc' => DB::table('corecompetencies')->select('corecompetency','corecompetencyid')->get()->toArray(),
          'selected_cc' => DB::table('company_corecompetency')
                                        ->select('corecompetency_id')
                                        ->where('companyid', session('companyid') )
                                        ->get()->toArray()
             ];

                   
        $fundsundermanagement = DB::table('fundsundermanagement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();
        $averageinvestmentsizes = DB::table('averageinvestmentsizes')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();  
        $levelofinvolvement = DB::table('levelofinvolvement')
                                            ->where('activestatus', 1)
                                            ->get()
                                            ->toArray();    

        
        $historical_data = DB::table('company_financialinfo_past')
                            ->select('historical_year', 'averageannualrevenue', 'annualoperatingcosts', 'averagenetincome')
                            ->where('companyid', session('companyid'))
                            ->get();
        
        $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
        $videofile = DB::table('companyvideos')
                            ->where('companyid', session('companyid'))
                            ->first();                    
        $data = [ 
                  'company_information' => $company_information,
                  'fundsundermanagement' => $fundsundermanagement,
                  'averageinvestmentsizes' => $averageinvestmentsizes,
                  'historical_data' => $historical_data,
                  'levelofinvolvement' => $levelofinvolvement,
                  'countries' => $countries, 
                  'currency' => $currency,
                  'entity_type' => $entity_type,
                  'states' => $states,
                  'sectors' => $sectors,
                  'referred_by' => $referred_by,
                  'documents' => $documents,
                  'videofile' => $videofile,
                  'cc' => $cc
        ];
              
          return view('service_provider.profile_edit', compact('data'));
        }
    }


    public function update( Request $request ) {
           //dd($request->all()); 
          
         if($request->has('user_info')) {
                  
           $data = [ 
                  'name' => $request->input('company_name'),
                  'email' => $request->input('email'),
                  'telephone' => $request->input('telephone'),
                  'website' => $request->input('website'),
                  'skype' => $request->input('skype'),
                  'twitter' => $request->input('twitter'),
                  'address' => $request->input('address'), 
                  'city' => $request->input('city'),
                  'zip' => $request->input('zip'),
                  'countryid' => $request->input('country'),
                  'stateid' => $request->input('state'),
                  'preferedcurrencyid' => $request->input('currency'),
                  'numberofemployees' => $request->input('numberofemployees'),
                  'yearsinvolved' => $request->input('yearsinvolved'),
                  'numbertodate' => $request->input('numbertodate'),
                  'taxidnumber' => $request->input('taxidnumber'),  
                  'preferedinvestmentaveragesize' => $request->input('preferedinvestmentaveragesize'),
                  'fundsundermanagement' => $request->input('fundsundermanagement'),
                  'levelofinvolvement' => $request->input('levelofinvolvement'),
                  'isonbehalfofinstitution' => $request->input('isonbehalfofinstitution'),
                  'mission' => $request->input('mission'),
                  'outcomes' => $request->input('outcomes'),
                  'currencyid'=> $request->input('currency'),
                  
                  // Enterprise fields
                  
                  'impactinfo_info' => $request->input('impactinfo_info'),
                  'impactinfo_socialbenefitimpact' => $request->input('social_impact'),
                  'impactinfo_environmentbenefitimpact' => $request->input('environmental_impact'),
                  'impactinfo_specificbeneficiaries' => $request->input('specific_impact'),
                  'financialinfo_auditedfinancialstatement' => (boolean) $request->input('audited_financial_statements'),
                  

                  'accountingcompanytype' => $request->input('entity_type'),
                  'businesssummary' => $request->input('business_summary'),
                  'onelinepitch' => $request->input('oneline_pitch'),
                  'salesstrategy' => $request->input('sales_strategy'),
                  'competativeadvantage' => $request->input('competative_advantage'),
                  'existingpatents' => $request->input('existing_patents'),
                  'recognition' => $request->input('recognition'),
                  'hearaboutartha' => $request->input('hear_about_artha'),


                  'foundedyear' => $request->input('year_founded'),
                  'financialinfo_informationdate' => $request->input('current_financials'),
                  'financialinfo_currentassets' => $request->input('current_assets'),
                  'financialinfo_totalassets' => $request->input('total_assets'),
                  'financialinfo_currentliabilities' => $request->input('current_liabilities'),
                  'financialinfo_totalliabilities' => $request->input('total_liabilities'),
                  'financialinfo_totalequity' => $request->input('total_equity'),
                  'financialinfo_netcash' => $request->input('net_cash'),
                  'financialinfo_ebitda' => $request->input('ebitda'),

                  // Service provider 
                  
                  'aboutus' => $request->input('about_us'),
                  'previousclients' => $request->input('previous_clients'),
                  'pastclients' => $request->input('past_clients'),
                  //'taxidnumber' => $request->input('tax_id_number'),
                  'foundedyear' => $request->input('year_founded'),
                  'statusmessage' => $request->input('status_message'),
                  'affiliations' => $request->input('notable_partnerships'),

                  // Eso
                  
                  'teamsizeid' => $request->input('teamsize'),
                  'noofenterprisesupported' => $request->input('noofenterprisesupported')

                   
                  
            ];  //dd($request->input('specializedsectors'));
            
            DB::table('company')->where('companyid', session('companyid'))->update($data);
             $specializedsectors = $request->input('specializedsectors');
            if(isset($specializedsectors) && !empty($specializedsectors) ) {
              DB::table('companysectors')->where('companyid', session('companyid') )->delete();
              foreach ($request->input('specializedsectors') as $sectors) {
                $helper= \App\Helpers\AppHelper::instance();
                
                DB::table('companysectors')
                           
                           ->insert(['tenantid' => session('tenantid'),
                                     'companyid' => session('companyid'),
                                     'sectorid' => $sectors ,
                                     'companysectorid' => $helper->fnGetUniqueID('16','companysectors','companysectorid')
                          ]); 
                                   
              }
          }
          else{
            DB::table('companysectors')->where('companyid', session('companyid') )->delete();
          }
          
          $corecompetencies = $request->input('corecompetency');
          if(isset($corecompetencies) && !empty($corecompetencies) ) {
            DB::table('company_corecompetency')->where('companyid', session('companyid') )->delete();
            foreach ($request->input('corecompetency') as $cc) {
              $helper= \App\Helpers\AppHelper::instance();
              
              DB::table('company_corecompetency')
                         
                         ->insert(['tenantid' => session('tenantid'),
                                   'companyid' => session('companyid'),
                                   'corecompetency_id' => $cc ,
                                   'company_corecompetency_id' => $helper->fnGetUniqueID('16','company_corecompetency','company_corecompetency_id')
                        ]); 
                                 
            }
        }
        else
        {
          DB::table('company_corecompetency')->where('companyid', session('companyid') )->delete();
        }


          return redirect()->back();            

        } elseif( $request->has('documents') ) {

               return response()->json(['success'=>true]);
               //$company_id = $request->input('company_id');
               
/*               $response['status'] = 0 ;
               if( $request->hasFile('public_document') ) { 
                 
                   $file = $request->file('public_document');
                   $extension = $file->getClientOriginalExtension();
                   $mime = $file->getClientMimeType();
                   $original_filename = $file->getClientOriginalName();
                   $filename = $file->getFilename().'.'.$extension;
                   $response['status'] = Storage::disk('private')->put( $filename,file_get_contents($file),'private');
                   $data = [ 
                             'u_id' => Auth::id(),
                             'c_id' => $company_id,
                             'documents' => $filename,
                             'file_name' => $original_filename
                          ];

                    if($response['status']) {
                      DB::table('company_documents')->insert($data);  
                      $response['message'] = 'File Uploded Successfully' ;
                    }
                   
                   return redirect()->route('company.show', ['id' => $company_id] )->with($response);  
              } 

              if( $request->hasFile('private_document') ) { 
                 
                   $file = $request->file('private_document');
                   $extension = $file->getClientOriginalExtension();
                   $mime = $file->getClientMimeType();
                   $original_filename = $file->getClientOriginalName();
                   $filename = $file->getFilename().'.'.$extension;
                   $response['status'] = Storage::disk('public')->put( $filename,file_get_contents($file),'private');
                   $data = [ 
                             'd_id' => $request->input('deal_id'),
                             'u_id' => Auth::id(),
                             'c_id' => $company_id,
                             'documents' => $original_filename,
                             'visibility' => 'private'
                          ];

                    if($response['status']) {
                      DB::table('deal_documents')->insert($data);  
                      $response['message'] = 'File Uploded Successfully' ;
                    }
                   
                   return redirect()->route('deal.show', ['id' => $deal_id ] )->with($response);  
              }

*/
          }
    }


    public function coverLogoUpdate(Request $request)
    {

       if( $request->hasFile('file') ) { 
         if( $request->input('profile_image') || $request->input('cover_image') ) {
             $helper= \App\Helpers\AppHelper::instance();
             $response['status'] = 0 ;                
             $file = $request->file('file');
             $extension = $file->getClientOriginalExtension();
             $mime = $file->getClientMimeType();
             $original_filename = $file->getClientOriginalName();
             $filename = $file->getFilename().'.'.$extension;

             $uploadDir = 'storage';
             $tmpFile = $_FILES['file']['tmp_name'];  
             if($request->input('profile_image'))
             {
               $document_application_name=$helper->fnGetUniqueID('5','company','profileimage');
              $document_application_name = $document_application_name.'.'.$extension;
               
              $filename = $uploadDir.'/company/profileimage/'. $document_application_name;
               if(move_uploaded_file($tmpFile,$filename))
               {
             $response['status']=1;
             
           $filename = $file->getFilename().'.'.$extension;;
           
             $column = $request->input('cover_image') ? 'coverimage' : 'profileimage' ;
               }
             }
              if($request->input('cover_image'))
             {
                   $document_application_name=$helper->fnGetUniqueID('5','company','coverimage');
                   $document_application_name = $document_application_name.'.'.$extension;
                   
                   $filename = $uploadDir.'/company/coverimage/'. $document_application_name;
                   if(move_uploaded_file($tmpFile,$filename))
                   {
                       $response['status']=1;
                       
             
             $filename = $file->getFilename().'.'.$extension;
            
             $column = $request->input('cover_image') ? 'coverimage' : 'profileimage' ;
             
                   }
             }
             
             
             
          if($response['status']) {
                DB::table('company')
                     ->where('companyid',session('companyid'))
                     ->update([ $column => $document_application_name ]); 
             
              return response()->json(['success'=>true]);
            }
            
            
            
            
           
            return redirect()->back()->with($response);
        }

      }

    }

    
    public function videoUpdate(Request $request)
        {    $helper= \App\Helpers\AppHelper::instance();
             if( $request->hasFile('file') ) { 
               $response['status'] = 0 ;                
               $videofile = $request->file('file');
               $extension = $videofile->getClientOriginalExtension();
               $mime = $videofile->getClientMimeType();
               $original_filename = $videofile->getClientOriginalName();
               $filename = $videofile->getFilename().'.'.$extension;
               
               $document_application_name=$helper->fnGetUniqueID('5','companyvideos','videopath');
               $document_application_name = $document_application_name.'.'.$extension;
               
             
               $uploadDir = 'storage';
               $tmpFile = $_FILES['file']['tmp_name']; 
               
               
                $filename = $uploadDir.'/company/videos/'. $document_application_name;
                   if(move_uploaded_file($tmpFile,$filename))
                   {
                 $response['status']=1;
                 
                $filename = $_FILES['file']['name'];
               
                   }
                if($response['status'])
                {
                 $count = DB::table('companyvideos')->where('companyid',session('companyid'))->count();
                   if($count)
                   {
                     DB::table('companyvideos')->where('companyid',session('companyid'))->delete();
                   }
                   DB::table('companyvideos')
                           ->where('companyid',session('companyid'))
                           ->insert([
                                      'companyvideosid' => $helper->fnGetUniqueID('16','companyvideos','companyvideosid'),
                                      'companyid' => session('companyid'),
                                      'videotitle' => $original_filename,
                                      'videopath' => $document_application_name
                                    ]); 
    
                  return response()->json(['success'=>true]);
                }
    
                return redirect()->back()->with($response);
            }
        }



    public function documentUpdate( Request $request) {
        $helper= \App\Helpers\AppHelper::instance();
         if( $request->hasFile('file') )
         {
                if( $request->input('public_documents') || $request->input('private_documents') ) {
                   $response['status'] = 0 ;                
                   $public_document = $request->file('file');
                   $documentstatus = $request->input('public_documents') ? 'Public' : 'Private';
                   $disk = $request->input('public_documents') ? 'public_document' : 'private_document';
                   $extension = $public_document->getClientOriginalExtension();
                   $mime = $public_document->getClientMimeType();
                   //$mime = ucwords(strtok($mime, '/'));
                  //  $mime = explode('/', $mime, 2);
                  //  $mime = $mime[0];

                  $filetype="";
                   if (strpos($mime, 'image') !== false)
                   {
                    $filetype='Image';
                   }
                   else if(strpos($mime, 'video') !== false)
                   {
                    $filetype='Video';
                   }
                   else{
                    $filetype='Document';
                   }
                   $filename_with_ext = $public_document->getClientOriginalName();
                   $filename_without_ext = pathinfo($filename_with_ext, PATHINFO_FILENAME);
                   
                   $filename = $public_document->getFilename().'.'.$extension;

                   $document_application_name=$helper->fnGetUniqueID('16','documents','documentname');
                   $document_application_name = $document_application_name.'.'.$extension;


                    if($documentstatus=='Public')
                    {
                      $public_document->move('storage/company/documents/public', $document_application_name);
                    }
                    else{
                      $public_document->move('storage/company/documents/private', $document_application_name);
                    }

                  //  $response['status'] = Storage::disk($disk)
                  //                                      ->put( $filename,file_get_contents($public_document),'private');
                   
                  //  if($response['status']) {
                        DB::table('documents')
                             ->insert([
                                       'userid' => session('userid'),
                                       'documentid' => $helper->fnGetUniqueID('16','documents','documentid'),
                                       'documentname' => $filename_without_ext,
                                       'documenttitle' => $document_application_name,
                                       'documentdescription' => $document_application_name,
                                       'extention' => $extension,
                                       'type' => $filetype,
                                       'companyid' => session('companyid'),
                                       'documentstatus' => $documentstatus
                                ]); 
                      
                      return response()->json(['success'=>true]);
                    // }
                   
                   return redirect()->back()->with($response);  
                }
            } 
              return response()->json(['success'=>false]);
        }
        
        
        
        public function galleryUpdate( Request $request) {
        $helper= \App\Helpers\AppHelper::instance();
         if( $request->hasFile('file') )
         {
                if( $request->input('gallery')  ) {
                   $response['status'] = 0 ;                
                   $gallery_images = $request->file('file');
                   $documentstatus = $request->input('gallery') ? 'galleryimages' : 'galleryvideos';
                   //$disk = $request->input('public_documents') ? 'public_document' : 'private_document';
                   $extension = $gallery_images->getClientOriginalExtension();
                   $mime = $gallery_images->getClientMimeType();
                   //$mime = ucwords(strtok($mime, '/'));
                  //  $mime = explode('/', $mime, 2);
                  //  $mime = $mime[0];

                   $filetype="";
                   if (strpos($mime, 'image') !== false)
                   {
                    $filetype='Image';
                   }
                   else if(strpos($mime, 'video') !== false)
                   {
                    $filetype='Video';
                   }
                  
                   $filename_with_ext = $gallery_images->getClientOriginalName();
                   $filename_without_ext = pathinfo($filename_with_ext, PATHINFO_FILENAME);
                   
                   $filename = $gallery_images->getFilename().'.'.$extension;

                   $gallery_name=$helper->fnGetUniqueID('16','gallery','galleryname');
                   $gallery_name = $gallery_name.'.'.$extension;


                    if($filetype=="Image")
                    {
                      $gallery_images->move('storage/company/gallery/images', $gallery_name);
                    }
                    else if($filetype=="Video")
                    {
                      $gallery_images->move('storage/company/gallery/videos',$gallery_name);
                    }

                  //  $response['status'] = Storage::disk($disk)
                  //                                      ->put( $filename,file_get_contents($public_document),'private');
                   
                  //  if($response['status']) {
                        DB::table('gallery')
                             ->insert([
                                       'userid' => session('userid'),
                                       'galleryid' => $helper->fnGetUniqueID('16','gallery','galleryid'),
                                       'galleryname' => $filename_without_ext,
                                       'gallerytitle' => $gallery_name,
                                       'gallerydescription' =>  $gallery_name,
                                       'extension' => $extension,
                                       'type' => $filetype,
                                       'companyid' => session('companyid'),
//                                       'documentstatus' => $documentstatus
                                ]); 
                      
                      return response()->json(['success'=>true]);
                    // }
                   
                   return redirect()->back()->with($response);  
                }
            } 
              return response()->json(['success'=>false]);
        }
        
        
        
        
        

         public function documentDelete( Request $request )
         {
              $response['status'] = false;
              $response['message'] = 'Delete Fail';

              $document_ids = $request->input('document_id');
              
              foreach ($document_ids as $document_id) {
                DB::table('documents')->where('documentid',$document_id)->delete();
                $response = array(
                  'message' => 'Delete Successfully', 
                  'status'  => true,
                  'alert-type' => 'success'
                );
                session(['response' => $response ]);
              }
              session(['response' => $response ]);

              return session('response');
            
          }

          public function documentDownload($id)
          {  
              try 
              {
                $file_name = DB::table('documents')->select('documenttitle')->where('documentid', $id)->first()->documenttitle; 
                $file_path = public_path('storage/company/documents/public/'.$file_name);
                return response()->download($file_path);  
              } catch (Exception $e) {
                report($e);
              }
              

          }


          public function deletedocuments(Request $request)
          {
            $tenantid=Session('tenantid');
            $type=$request->type;
            $documents=json_decode($request->documentlist, true);
            $myPublicFolder = public_path();
            $file_path ='storage/company/documents/'.$type.'/';

            foreach ($documents as $value => $key ) 
            {
                  try
                  {
                    $file_name = DB::table('documents')->select('documenttitle')->where('documentid', $key['documentid'])->first()->documenttitle; 
                    if($file_name!=null)
                    {
                      $file =$file_path . $file_name;  
                      if(file_exists(public_path($file_path.$file_name))){
                        unlink(public_path($file_path.$file_name));
                      }
                      // File::delete($file_path);
                      DB::table('documents')->where('documentid',$key['documentid'])->delete();
                    }
                  }
                  catch(Exception $e) {
                    // report($e);
                  }
                }

                return response()->json(['message'=>'Success']); 
          }
          


          public function deletegallery(Request $request)
          {
            $tenantid=Session('tenantid');
            $fileloction="";
            $type=$request->type;
            if(isset($type) && !empty($type))
            {
              if($type=="galleryimages")
              {
                $fileloction="images";
              }
              else if($type=="galleryvideos")
              {
                $fileloction="videos";
              }
            }
            $documents=json_decode($request->gallerylist, true);
            $myPublicFolder = public_path();
            $file_path ='storage/company/gallery/'.$fileloction.'/';

            foreach ($documents as $value => $key ) 
            {
                  try
                  {
                    $file_name = DB::table('gallery')->select('gallerytitle')->where('galleryid', $key['documentid'])->first()->gallerytitle; 
                    if($file_name!=null)
                    {
                      $file =$file_path . $file_name;  
                      if(file_exists(public_path($file_path.$file_name))){
                        unlink(public_path($file_path.$file_name));
                      }
                      // File::delete($file_path);
                      DB::table('gallery')->where('galleryid',$key['documentid'])->delete();
                    }
                  }
                  catch(Exception $e) {
                    // report($e);
                  }
                }

                return response()->json(['message'=>'Success']); 
          }
          





            public function currencysymbol(Request $request)
          {
              //echo $request->currency;
              $currency=DB::table('currency')->where('currencyid',$request->currency)->get();
              return $currency[0]->symbol;
          }
          
          public function getprojectcompanylist(Request $request)
          {
              $tenantid=$request->tenantid;
              $companyarray=array();
              $companylist = DB::table('company')
                                    ->select('name','statusmessage','companytypeid','companyid','profileimage')
                                    ->where('name','like', "%".$request->searchtext."%" )
                                    ->where('tenantid',$tenantid)
                                    ->where('companystatus','Verified')
                                    ->where('activestatus','Active')
                                    ->get();
              foreach($companylist as $companylist)
              {
         $companprofileimage="";
         
         if(isset($companylist->profileimage) && !empty($companylist->profileimage) )
         {
             $companprofileimage='/storage/company/profileimage/'.$companylist->profileimage;
         }  
         else
         {
          $companprofileimage="";
          // $avatar = new Avatar();
          // $companprofileimage = $avatar->create($company->name)->toBase64();
         }

                  
         $value=array('name'=>$companylist->name,'statusmessage'=>$companylist->statusmessage,'companytypeid'=>$companylist->companytypeid,'companyid'=>$companylist->companyid,'img'=>$companprofileimage);
         
         array_push( $companyarray, $value );
         
         
            }
              return  json_encode($companyarray);
              
              
              
              
              
              
          }
          
          public function autocompletetemplate(Request $request)
          {
             $data=$request->item;
             
             $companylist = DB::table('company')
                     ->select('name','profileimage','statusmessage')
                     ->where('companyid', $data )
                     ->first();
             $view=View::make('tenants._auto_comp_view',compact('companylist'))->render();

            return $view; 
              
          }
          

}
