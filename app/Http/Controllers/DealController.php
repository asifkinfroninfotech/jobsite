<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use View;
use Carbon\Carbon;
use File;

class DealController extends Controller
{
  public function index()
  {
    $tenantid=session('tenantid');
    if(isset($tenantid)==false)
    {
        return redirect()->route('logout');
    }
 $collection_data= [
        'country' => DB::table('country as c')->select('c.countryid as id','c.name')
                  ->where('c.activestatus','1')->get(), 
        'sectors' => DB::table('sectors as s')->select('s.sectorid as id','s.name')
                  ->where('tenantid',session('tenantid'))->get(),
                
        'investmentsizes' => DB::table('averageinvestmentsizes as ais')->select('ais.averageinvestmentsizeid as id','ais.investmentsize as name')          
                   ->where('ais.tenantid',session('tenantid'))
                   ->where('ais.activestatus','1')->get(),
     
        'totalviewcount' => DB::table('deals as ds')->select('ds.totalviews as totalview')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(), 
     
        'projectname' => DB::table('deals as ds')->select('ds.projectname as projectname')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(),    
     
        'projectstage' => DB::table('deals as ds')->select('ds.investmentstage as projectstage')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(), 
     
        'projectstructure' => DB::table('deals as ds')->select('ds.investmentstructure as projectstructure')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(), 
        'investmentpurpose' => DB::table('deals as ds')->select('ds.purposeofinvestment as investmentpurpose')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(),  
     
         'proposedfunds' => DB::table('deals as ds')->select('ds.proposedusesoffunds as proposedusesoffunds')          
                   ->where('ds.tenantid',session('tenantid'))
                   ->where('ds.userid',session('userid'))
                   ->distinct()
                   ->get(),      
     ]; 
        
                           

        
      

return view('mydeals.dealslisting',compact('collection_data'));

 }
  
 

   
   
   
  public function getDeals(Request $request)
  {
   $userid=Session('userid');
   $companyid=Session('companyid');
   $tenantid=session('tenantid');
   
    
  
   
   $pagesize= \App\Helpers\AppGlobal::fnGet_MyDealsPageSize();
  
   $query = DB::table('deals as d')
  
   ->leftjoin('company as c','c.companyid','d.companyid') 
   ->leftjoin('country as cn','cn.countryid','c.countryid')
   ->leftjoin('users as us','us.userid','d.userid')
   ->leftjoin('currency as cur','d.currencyid','cur.currencyid')
   ->where('d.tenantid',$tenantid);
           
   
           
           
   $query->where(function ($query) {
       $query->where('d.companyid','=', Session('companyid'))
              ->where('d.userid','=', Session('userid')); 
            
   });
   
   $searchtext=$request->searchtext;
   $sortby=$request->sortby;
   $countryids=$request->countryids;//ids
   $sectorids=$request->sectorids;//ids
   
   $investmentsizes=$request->investmentsizes;//value
   $totalviewcount=$request->totalviewcount;//value
   $projectname=$request->projectname;//value
   $projectstage=$request->projectstage;//value
   $projectstructure=$request->projectstructure;//value
   $investmentpurpose=$request->investmentpurpose;//value
   $proposedfunds=$request->proposedfunds;//value
   $active=$request->active;

   if(isset($countryids) && !empty($countryids))
     $query->whereIn('c.countryid', explode(',', $countryids));


   

   if(isset($investmentsizes) && !empty($investmentsizes))
   {
       $query->whereIn('d.investmentsize', explode(',', $investmentsizes));
   }
   if(isset($totalviewcount) && !empty($totalviewcount))
   {
       $query->whereIn('d.totalviews', explode(',', $totalviewcount));
   }
   if(isset($projectname) && !empty($projectname))
   {
       $query->whereIn('d.projectname', explode(',', $projectname));
   }
    if(isset($projectstage) && !empty($projectstage))
   {
       $query->whereIn('d.investmentstage', explode(',', $projectstage));
   }
    if(isset($projectstructure) && !empty($projectstructure))
   {
       $query->whereIn('d.investmentstructure', explode(',', $projectstructure));
   }
        if(isset($investmentpurpose) && !empty($investmentpurpose))
   {
       $query->whereIn('d.purposeofinvestment', explode(',', $investmentpurpose));
   }
       if(isset($proposedfunds) && !empty($proposedfunds))
   {
       $query->whereIn('d.proposedusesoffunds', explode(',', $proposedfunds));
   }

  
   if(isset($searchtext) && !empty($searchtext))
   {
    $query->where(function ($query ) use ($searchtext)
             {
         
         $query->where('d.totalviews','=', $searchtext)
                 ->orWhere('d.projectname','like', '%' . $searchtext . '%')
                 ->orWhere('d.investmentstage','like', '%' . $searchtext . '%')
                 ->orWhere('d.investmentstructure','like', '%' . $searchtext . '%')
                 ->orWhere('d.purposeofinvestment','like', '%' . $searchtext . '%')
                 ->orWhere('d.proposedusesoffunds','like', '%' . $searchtext . '%');
         
         
        
             });
   }

   
   
    if(isset($active) && !empty($active))
   {
    $query->where(function ($query ) use ($active)
             {
               $query->where('d.deal_active','=', $active);
             });
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
               case 'projectname':
               $query->orderBy('d.projectname');
                   break;
               
               case 'totalinvestment':
               $query->orderBy('d.investmentstructure');
                   break;
               
               default:
                   
                   break;
           }
           
       }
   
   //$data = $query->select('c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired')->paginate($pagesize);

   
  
   
       
       
       
   $data = $query->select('c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.dealid','d.investmentstructure','d.purposeofinvestment','d.projectname','us.profileimage','us.firstname','us.lastname','cur.symbol')->paginate($pagesize);
 
   
 //dd($data);
 
   
   
//   if(isset($data[0]) || !empty($data[0]))
 //  {
   $view=View::make('mydeals._deals',compact('data','deals_documents_privatecount','deals_documents_publiccount'))->render();
//   }
//   else
//   {
//        $view='<div class="project-box mar-one-rem"><div class="project-info">'.trans('notfoundlang.my_deals').'</div></div>';
//   }
   return $view;
 }
  
  
  
  
  
  
    public function NewDeal()
    {
        $companyid=Session('companyid');
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

$investmentstages = DB::table('investmentstages')
                                 ->get()
                                 ->toArray();  

$purposeofrequestedinvestment = DB::table('fund_category')
                                 ->get()
                                 ->toArray();
$investmentstructures = DB::table('investmentstructures')
                                 ->where('activestatus',1)
                                 ->get()
                                 ->toArray();
                                 
$levelofinvolvement = DB::table('levelofinvolvement')
                                 ->where('activestatus', 1)
                                 ->get()
                                 ->toArray();   

$currency=DB::table('currency')->get();
$sdgmaster=DB::table('sdg_master')->get();
                  
                                                                     
$data = [ 
       'company_information' => $company_information,
       'countries' => $countries,
       'investmentstages' =>$investmentstages,
       'purposeofrequestedinvestment'=>$purposeofrequestedinvestment,
       'investmentstructures' => $investmentstructures,
       'currency' => $currency, 
       'sdg_master'=>$sdgmaster,        

    //    'documents' => $documents,
    //    'videofile' => $videofile,
];  
         return view('mydeals.deal_new', compact('data'));
    }

    public function SaveNewDeal(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
                  $userid=Session('userid');
                  $tenantid=Session('tenantid');

                  $dealid=$helper->fnGetUniqueID(16, 'deals', 'dealid');
                  
                  
                  DB::table('deals')->insert(
                    [
                    'dealid' => $dealid, 
                    'companyid' => session('companyid'),
                    'tenantid'=> $tenantid,
                    'projectname' => $request->input('project_name'),
                    'proposedusesoffunds' => $request->input('proposed_uses_of_funds'),
                    'investmentstage' => $request->input('investmentstage'),
                    'monthlyoperatingcost'=> $request->input('monthly_operating_costs'),
                    'totalinvestmentrequired'=> $request->input('total_investment_required'),
                    'premoneyvaluation'=> $request->input('pre_money_valuation'),
                    'projectedirr'=> $request->input('projected_irr'),
                    'purposeofinvestment'=> $request->input('purpose_of_requested_investment'),
                    'investmentstructure'=> $request->input('investment_structure'),
                    'loanterm_year'=> $request->input('loan_term_year'),
                    'loanterm_month'=> $request->input('loan_term_month'),
                    'existinginvestors'=> $request->input('previous_investores'),
                    'additionaldetails'=> $request->input('additional_info'),
                    'userid' => $userid,
                    'currencyid' =>$request->input('currency'),     

                    ]
                   );
                  
                //For deals sdg  
                  $sdg=$request->input('sdg');
                  
                  if(isset($sdg) && !empty($sdg))
                  {
                    for($i=0;$i<count($sdg);$i++)
                    {
                     $dealsdgid=$helper->fnGetUniqueID(16,'deal_sdgs','dealsdgid');
                     DB::table('deal_sdgs')->insert(
                             [
                                 'dealsdgid' => $dealsdgid,
                                 'dealid' => $dealid,
                                 'tenantid' => $tenantid,
                                 'sdgid' => $sdg[$i],
                                 
                             ]
                             ); 
                     
                     
                    }
                  }

                  
                // For Projected Financial OPTIONAL
                for ($i=2; $i < 6; $i++) { 
                    DB::table('deals_projected_financials')->insert(
                        [
                        'dealid' => $dealid, 
                        'tenantid'=> $tenantid,
                        'projected_year' => $request->input('Year_'.$i),
                        'year_number' => $i,
                        'totalrevenue' => $request->input('Year_'.$i.'_tr'),
                        'totalannualoperatingcost'=> $request->input('Year_'.$i.'_taoc'),
                        'ebitda'=> $request->input('Year_'.$i.'_ebtda'),
                        'netcash'=> $request->input('Year_'.$i.'_netcash'),
 
                        ]
                       );
                }
           
                return redirect('/my-deals');

    }


    public function EditDeal(Request $request)
    {
        $dealid=$request->dealid;//"BvDYWFansviNyYKK";//
        session()->put('dealid', $dealid);
        $companyid=Session('companyid');
        // $deal_info = DB::table('company')->where('companyid', session('companyid'))->first();
        $deal_info = DB::table('deals as d')->where('d.dealid',$dealid)
        ->leftjoin('company as c','c.companyid','d.companyid') 
        ->leftjoin('country as cn','cn.countryid','c.countryid')
        ->leftjoin('currency as cur','cur.currencyid','d.currencyid') 
              
        ->select('d.dealid','d.companyid','d.proposedusesoffunds','d.investmentstage','d.investmentsize',
        'd.monthlyoperatingcost','d.totalinvestmentrequired','d.premoneyvaluation','d.projectedirr','d.purposeofinvestment','d.investmentstructure',
        'd.loanterm_year','d.loanterm_month','d.existinginvestors','d.additionaldetails','d.projectname','d.profileimage','d.coverimage','d.video','cur.currencyid','cur.symbol',
        'c.profileimage as c_profileimage','c.coverimage as c_coverimage','c.countryid','c.name as dealcompanyname')
        ->first();

        $deal_info->totalinvestmentrequired=str_replace(',','',$deal_info->totalinvestmentrequired);

        $countries = [
             'current_country' => DB::table('country')
                                         ->select('name')
                                         ->where('countryid', $deal_info->countryid )
                                         ->first()
        ];

      $investmentstages = DB::table('investmentstages')
                                 ->get()
                                 ->toArray();  

      $purposeofrequestedinvestment = DB::table('fund_category')
                                 ->get()
                                 ->toArray();
      $investmentstructures = DB::table('investmentstructures')
                                 ->where('activestatus',1)
                                 ->get()
                                 ->toArray();

  // $documents = DB::table('deals_documents')
  //                                ->where('dealid', $dealid)
  //                                ->get();

    $projectedfinancials= DB::table('deals_projected_financials')
    ->where('dealid', $dealid)
    ->get();                            
                              
       
    
     $selectedsdg= DB::table('deal_sdgs')
    ->where('dealid', $dealid)
    ->get();
    
    
    $currency=DB::table('currency')
    ->get();        
    
    $sdgmaster=DB::table('sdg_master')->get();//Removed Tenant ID Check 2018-08-31
    
                                                                     
$data = [ 
       'deal_info' => $deal_info,
       'countries' => $countries,
       'investmentstages' =>$investmentstages,
       'purposeofrequestedinvestment'=>$purposeofrequestedinvestment,
       'investmentstructures' => $investmentstructures,
       'projectedfinancials' => $projectedfinancials,
       'currency'=>$currency, 
       'sdg_master'=>$sdgmaster,        
       'sdg_selected'=>$selectedsdg,       
];  
         return view('mydeals.deal_edit', compact('data'));
    }


    public function UpdateDeal(Request $request)
    {
      $userid=Session('userid');
      $tenantid=Session('tenantid');

      $dealid=$request->input('dealid');
       $helper= \App\Helpers\AppHelper::instance();
      DB::table('deals')->where('dealid',$dealid)
      ->update(
        [
        'projectname' => $request->input('project_name'),
        'proposedusesoffunds' => $request->input('proposed_uses_of_funds'),
        'investmentstage' => $request->input('investmentstage'),
        'monthlyoperatingcost'=> $request->input('monthly_operating_costs'),
        'totalinvestmentrequired'=> $request->input('total_investment_required'),
        'premoneyvaluation'=> $request->input('pre_money_valuation'),
        'projectedirr'=> $request->input('projected_irr'),
        'purposeofinvestment'=> $request->input('purpose_of_requested_investment'),
        'investmentstructure'=> $request->input('investment_structure'),
        'loanterm_year'=> $request->input('loan_term_year'),
        'loanterm_month'=> $request->input('loan_term_month'),
        'existinginvestors'=> $request->input('previous_investores'),
        'additionaldetails'=> $request->input('additional_info'),
        'currencyid'=> $request->input('currency'),    
        // 'userid' => $userid,
        ]
       );
      
      //for deleting sdgs
      
      DB::table('deal_sdgs')
      ->where('dealid',$dealid)
      ->delete();
      
      
      //For deals sdg  
                  $sdg=$request->input('sdg');
                  
                  if(isset($sdg) && !empty($sdg))
                  {
                    for($i=0;$i<count($sdg);$i++)
                    {
                     $dealsdgid=$helper->fnGetUniqueID(16,'deal_sdgs','dealsdgid');
                     DB::table('deal_sdgs')->insert(
                             [
                                 'dealsdgid' => $dealsdgid,
                                 'dealid' => $dealid,
                                 'tenantid' => $tenantid,
                                 'sdgid' => $sdg[$i],
                                 
                             ]
                             ); 
                    }
                  }

      
      
      
      
    // For Projected Financial OPTIONAL
    for ($i=2; $i < 6; $i++) {
        $existingR= DB::table('deals_projected_financials')->where('dealid',$dealid)->where('year_number',$i)->first();
        if(isset($existingR) && !empty($existingR))
        {
          DB::table('deals_projected_financials')->where('dealsprojectedfinancialsid',$existingR->dealsprojectedfinancialsid)
          ->update(
            [
            'projected_year' => $request->input('Year_'.$i),
            'year_number' => $i,
            'totalrevenue' => $request->input('Year_'.$i.'_tr'),
            'totalannualoperatingcost'=> $request->input('Year_'.$i.'_taoc'),
            'ebitda'=> $request->input('Year_'.$i.'_ebtda'),
            'netcash'=> $request->input('Year_'.$i.'_netcash'),
            ]
           );
        }
    }

    $response['status'] = 1 ; 
    return redirect()->back()->with($response);

    }



    public function coverLogoUpdate(Request $request)
    {

       if( $request->hasFile('file') ) { 
         if( $request->input('profile_image') || $request->input('cover_image') ) {
            $dealid=$request->input('dealid');  
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
               $document_application_name=$helper->fnGetUniqueID('8','deals','profileimage');
              $document_application_name = $document_application_name.'.'.$extension;
               
              $filename = $uploadDir.'/deal/profileimage/'. $document_application_name;
               if(move_uploaded_file($tmpFile,$filename))
               {
             $response['status']=1;
             
           $filename = $file->getFilename().'.'.$extension;;
           
             $column = $request->input('cover_image') ? 'coverimage' : 'profileimage' ;
               }
             }
              if($request->input('cover_image'))
             {
                   $document_application_name=$helper->fnGetUniqueID('8','deals','coverimage');
                   $document_application_name = $document_application_name.'.'.$extension;
                   
                   $filename = $uploadDir.'/deal/coverimage/'. $document_application_name;
                   if(move_uploaded_file($tmpFile,$filename))
                   {
                       $response['status']=1;
                       
             $filename = $file->getFilename().'.'.$extension;
             $column = $request->input('cover_image') ? 'coverimage' : 'profileimage' ;
                   }
             }
          if($response['status']) {
                DB::table('deals')
                     ->where('dealid',$dealid)
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
               
               $document_application_name=$helper->fnGetUniqueID('8','deals','video');
               $document_application_name = $document_application_name.'.'.$extension;
               
             
               $uploadDir = 'storage';
               $tmpFile = $_FILES['file']['tmp_name']; 
               $dealid=$request->input('dealid');  
               $filename = $uploadDir.'/deal/video/'. $document_application_name;
               if(move_uploaded_file($tmpFile,$filename))
               {
                   
                //$response['status']=1;
               // $filename = $_FILES['file']['name'];
                DB::table('deals')->where('dealid',$dealid)
                ->update(['video' => $document_application_name]);
    
                 return response()->json(['success'=>true]);
                 
                 
                  }
//                if($response['status'])
//                {
//               
//                }
    
                return redirect()->back()->with($response);
            }
        }



    public function documentUpdate( Request $request) {
        $helper= \App\Helpers\AppHelper::instance();
         if( $request->hasFile('file') )
         {
                if( $request->input('public_documents') || $request->input('private_documents') ) {
                   $response['status'] = 0 ; 
                   $dealid=$request->input('dealid');               
                   $public_document = $request->file('file');
                   $documentstatus = $request->input('public_documents') ? 'Public' : 'Private';
                   $disk = $request->input('public_documents') ? 'public_document' : 'private_document';
                   $extension = $public_document->getClientOriginalExtension();
                   $mime = $public_document->getClientMimeType();

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

                   $document_application_name=$helper->fnGetUniqueID('16','deals_documents','documentid');
                   $document_application_name = $document_application_name.'.'.$extension;


                    if($documentstatus=='Public')
                    {
                      $public_document->move('storage/deal/documents/public', $document_application_name);
                    }
                    else{
                      $public_document->move('storage/deal/documents/private', $document_application_name);
                    }

                        DB::table('deals_documents')
                             ->insert([
                                       'userid' => session('userid'),
                                       'documentid' => $helper->fnGetUniqueID('16','documents','documentid'),
                                       'documentname' => $filename_without_ext,
                                       'documenttitle' => $document_application_name,
                                       'documentdescription' => $document_application_name,
                                       'extention' => $extension,
                                       'type' => $filetype,
                                       'dealid' => $dealid,
                                       'documentstatus' => $documentstatus
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
                DB::table('deals_documents')->where('documentid',$document_id)->delete();
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
                $file_name = DB::table('deals_documents')->select('documenttitle')->where('documentid', $id)->first()->documenttitle; 
                $file_path = public_path('storage/deal/documents/public/'.$file_name);
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
            $file_path ='storage/deal/documents/'.$type.'/';

            foreach ($documents as $value => $key ) 
            {
                  try
                  {
                    $file_name = DB::table('deals_documents')->select('documenttitle')->where('documentid', $key['documentid'])->first()->documenttitle; 
                    if($file_name!=null)
                    {
                      $file =$file_path . $file_name;  
                      if(file_exists(public_path($file_path.$file_name))){
                        unlink(public_path($file_path.$file_name));
                      }
                      // File::delete($file_path);
                      DB::table('deals_documents')->where('documentid',$key['documentid'])->delete();
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

          public function ViewDeal(Request $request)
          {
            $calledfrom=$request->calledfrom;

              $dealid=$request->dealid;//"BvDYWFansviNyYKK";//
              session()->put('dealid', $dealid);
              $companyid=Session('companyid');
              

              // $deal_info = DB::table('company')->where('companyid', session('companyid'))->first();
              $deal_info = DB::table('deals as d')->where('d.dealid',$dealid)
              ->leftjoin('company as c','c.companyid','d.companyid') 
              ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
              ->leftjoin('country as cn','cn.countryid','c.countryid')
              ->leftjoin('currency as cur','cur.currencyid','d.currencyid') 
                    
              ->select('d.dealid','d.companyid','d.proposedusesoffunds','d.investmentstage','d.investmentsize',
              'd.monthlyoperatingcost','d.totalinvestmentrequired','d.premoneyvaluation','d.projectedirr','d.purposeofinvestment','d.investmentstructure',
              'd.loanterm_year','d.loanterm_month','d.existinginvestors','d.additionaldetails','d.projectname','d.profileimage','d.coverimage','d.video','cur.currencyid','cur.symbol',
              'c.profileimage as c_profileimage','c.coverimage as c_coverimage','c.countryid','c.name as company','c.statusmessage','ct.companytype','d.deal_active')
              ->first();

              //New CoDE
              if(isset($calledfrom)&&!empty($calledfrom)&&($calledfrom=="tenant"))
              {
              if(isset($deal_info->companyid)&&!empty($deal_info->companyid))
              {
                  $getadmin=DB::table('usercompanies as uc') 
                  ->where('uc.companyid',$deal_info->companyid)
                  ->leftjoin('users as us', 'uc.userid', '=', 'us.userid')
                  ->where('uc.userrole',0)
                  ->where('uc.recordstatus','Active')
                 ->first();
                session(['userid'=> $getadmin->userid]);  
              }
              }
              //New CoDE


              $who_is_viewing="Owner";
              if(isset($deal_info))
              {
                  if($deal_info->companyid!=$companyid)
                  {
                      DB::update("Update deals set totalviews=totalviews+1 where dealid='$dealid'");
                      $who_is_viewing="Other";
                  }
              }
      
      
              $countries = [
                   'current_country' => DB::table('country')
                                               ->select('name')
                                               ->where('countryid', $deal_info->countryid )
                                               ->first()
              ];
      
            $investmentstages = DB::table('investmentstages')
                                        ->get()
                                       ->toArray();  
      
            $purposeofrequestedinvestment = DB::table('fund_category')
                                       ->get()
                                       ->toArray();
            $investmentstructures = DB::table('investmentstructures')
                                       ->where('activestatus',1)
                                       ->get()
                                       ->toArray();
      
      
          $projectedfinancials= DB::table('deals_projected_financials')
          ->where('dealid', $dealid)
          ->get();                            
                                    
             
          
           $selectedsdg= DB::table('deal_sdgs')
          ->where('dealid', $dealid)
          ->get();
          
          
          $currency=DB::table('currency')
          ->get();        
          
          $sdgmaster=DB::table('sdg_master')->get();

          $tenantid=session('tenantid');
          $d_query="SELECT d.companyid as deal_companyid,pd.pipelinedealid,c.companyid,c.name as company,c.profileimage,ct.companytype,pd.startdate,pd.completeddate,'' as CanRequest FROM pipelinedeals as pd
          join company as c on c.companyid=pd.companyid
          join companytypes as ct on ct.companytypeid=c.companytypeid
          join deals as d on d.dealid=pd.dealid
          where pd.dealid='$dealid' and pd.tenantid='$tenantid' and pd.parentpipelinedealid is null and pd.startdate is not null";
         
         $duediligence_parents=DB::select(DB::raw($d_query));


         
         $pdids="";
         foreach ($duediligence_parents as $key => $value) {

          if ($pdids=="")
          {
           $pdids="'".$value->pipelinedealid."'";
          }
          else
          {
           $pdids=$pdids.",'". $value->pipelinedealid."'";
          }
        }

        $pdeals_Companies;
        $pdeals_Public_Documents=[];

        if(!empty($pdids))
        {
        $pdeals_Companies=DB::select(DB::raw("
        SELECT pipelinedealid,companyid,'Parent' as type FROM `pipelinedeals` WHERE 
        pipelinedealid in ($pdids)
        UNION 
        SELECT pipelinedealid,companyid,'Associates' as type FROM `pipelinedeals` WHERE 
        parentpipelinedealid in ($pdids)
        UNION
        Select pipelinedealid,companyid,status as type from draft_pipelinedeals where pipelinedealid in ($pdids)
        ")); 

        $pdeals_Public_Documents=DB::select(DB::raw("Select * from pipelinedeal_documents where pipelinedealid in ($pdids) and documentstatus='Public'"));

        }
      
        foreach ($duediligence_parents as $key => $value) 
        {
               $isExists='';
               if(isset($pdeals_Companies) && !empty($pdeals_Companies))
               {
                foreach ($pdeals_Companies as $key1 => $c) {    
                    if($c->companyid==session('companyid') && $c->pipelinedealid==$value->pipelinedealid)
                    {
                        $isExists='Yes';
                        // $value->CanRequest='No';
                        // break;
                    }
                }
               }
                if($isExists=='Yes')
                {
                    $value->CanRequest='No';
                }
                else
                {
                    $value->CanRequest='Yes';
                }
                
                //checking if the logged in company is the owner of the deal.
                if($value->deal_companyid==session('companyid'))
                {
                    $value->CanRequest='No';
                }
                                               
          }

       // UNION
        // Select companyid,'Owner' as type from deals where dealid=(select dealid from pipelinedeals where pipelinedealid='$pdids') 

         $puplic_doc_count=DB::select(DB::raw("Select Count(*) as c from deals_documents where dealid='$dealid' and documentstatus='Public'"))[0]->c;
         $private_doc_count = DB::select(DB::raw("Select Count(*) as c from deals_documents where dealid='$dealid' and documentstatus='Private'"))[0]->c;

             
      $data = [ 
             'deal_info' => $deal_info,
             'countries' => $countries,
             'investmentstages' =>$investmentstages,
             'purposeofrequestedinvestment'=>$purposeofrequestedinvestment,
             'investmentstructures' => $investmentstructures,
            //  'documents' => $documents,
             'projectedfinancials' => $projectedfinancials,
             'currency'=>$currency, 
             'sdg_master'=>$sdgmaster,        
             'sdg_selected'=>$selectedsdg,  
             'duediligence_parents'=>$duediligence_parents,
             'pdeals_Public_Documents'=>$pdeals_Public_Documents,  
             'puplic_doc_count'=>$puplic_doc_count,
             'private_doc_count'=>$private_doc_count,
              ];

              // return view('mydeals.deal_edit', compact('data'));
               return view('mydeals.deal_view', compact('data','calledfrom','who_is_viewing'));      
          }


          public function generateaccessrequest(Request $request)
          {
              $dealid=$request->dealid;
              $pipelinedealid=$request->pipelinedealid;
              $tenantid=session('tenantid');
              if(isset($pipelinedealid))
              {
                $helper= \App\Helpers\AppHelper::instance();
                $d_pid=$helper->fnGetUniqueID(16, 'draft_pipelinedeals', 'draft_pipelinedealid');
                DB::table('draft_pipelinedeals')->insert(
                          [
                          'draft_pipelinedealid' => $d_pid, 
                          'pipelinedealid' => $pipelinedealid,
                          'tenantid'=> Session('tenantid'),
                          'companyid' => session('companyid'),
                          'status'=>'New Request'
                          ]
                         );
                //Send Email

                try{
                    $session_companyid=session('companyid');

                    $TemplateCode= \App\Helpers\AppGlobal::$RequestToJoinDueDiligence_TemplateCode;
                    if(isset($TemplateCode))
                    {
                      $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                      if(isset($Template))
                      {
                        $TemplateMaster=DB::table('email_master_templates')->first();

                        if(isset($TemplateMaster))
                        {
                            $company_sender=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                            join companytypes as ct on ct.companytypeid=c.companytypeid
                            where companyid = '$session_companyid'"))[0];
  
                            $pipelinedeal_detail=DB::select(DB::raw("Select pd.companyid,d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                            join deals as d on d.dealid=pd.dealid
                            Where pd.pipelinedealid='$pipelinedealid'"))[0];
  
                            $companyid=$pipelinedeal_detail->companyid;
              
                            $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                            join companytypes as ct on ct.companytypeid=c.companytypeid
                            where companyid = '$companyid'"))[0];

                         $sessionuserobj=DB::select(DB::raw("Select userid,firstname from users where userid='".session('userid')."'"))[0];
                         
                           $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
              
                          $MessageBody=$Template->message;
                          $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                          $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                          $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
                          $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                          $MessageBody=str_replace("%%FIRSTNAME%%",$sessionuserobj->firstname,$MessageBody);
                          $MessageBody=str_replace("%%COMPANY%%",$company_sender->company,$MessageBody);
                          $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 

                          $profilelink=\App\Helpers\AppGlobal::$App_Domain.'/company/profile/view?company='.$company_sender->companyid.'&companytype='.$company_sender->companytype;
                          $logo='';
                        if( (isset($company_sender->profileimage) && !empty($company_sender->profileimage) ) && File::exists(public_path('/storage/company/profileimage/'.$company_sender->profileimage))==true)
                        {
                            $logo=\App\Helpers\AppGlobal::$App_Domain.'/storage/company/profileimage/'.$company_sender->profileimage;
                        }
                        else
                        {
                            // $logo=Avatar::create(ucfirst($company_sender->company))->toBase64();
                            $logo = \App\Helpers\AppGlobal::$App_Domain."/img/logo_desktop.png";
                        }
                          
                          $MessageBody=str_replace("%%PROFILE_LINK%%",$profilelink,$MessageBody);
                          $MessageBody=str_replace("%%LOGO%%",$logo,$MessageBody);

                          $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                          $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                          
                          $Message_with_master= $TemplateMaster->content; 
                          $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$Message_with_master);  
                          $Message_with_master=str_replace('%%EMAILCONTENT%%',$MessageBody,$Message_with_master);

                          $forgetpwdlink=\App\Helpers\AppGlobal::$App_Domain.'/forgotpassword?tid='.$tenantid;
                          $Message_with_master=str_replace("%%LOGIN_LINK%%",$loginlink,$Message_with_master);
                          $Message_with_master=str_replace("%%FORGETPWD_LINK%%",$forgetpwdlink,$Message_with_master);
                          $logo=session('tenant_logo'); $t_logo='';
                          if( (isset($logo) && !empty($logo) ) && File::exists(public_path('/storage/tenant/logoimage/'.$logo))==true)
                          {
                              $t_logo=\App\Helpers\AppGlobal::$App_Domain.'/storage/tenant/logoimage/'.$logo;
                          }
                          else
                          {
                              $t_logo=Avatar::create(ucfirst(session('tenant_firstname').' '.session('tenant_lastname')))->toBase64();
                          }
                          $Message_with_master=str_replace("%%EMAIL_LOGO_LINK%%",$t_logo,$Message_with_master);
                          $Message_with_master=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$Message_with_master);
                          $Message_with_master=str_replace("%%PRIVACYPOLICY_LINK%%",session('tenant_privacy_policy_link'),$Message_with_master);
                          $Message_with_master=str_replace("%%COMPANY_NAME%%",session('tenant_company'),$Message_with_master);
                          $Message_with_master=str_replace("%%YEAR%%",date('Y'),$Message_with_master);
                          $Message_with_master=str_replace("%%COMPANY_ADDRESS%%",$helper->getCompleteAddress('tenant',$tenantid),$Message_with_master);
        
                          $Message_with_master=$helper->getSocialLinks('tenant',$tenantid,$Message_with_master);
                          $Template->fromname=session('tenant_from_name');
                          $Template->fromemail=session('tenant_from_email');

                          $helper->SendEmail($Template,$receiver_email,$Message_with_master);
                        }

                          


                      }
                    }     
                 }
              catch(\Exception $e){
                // do task when error
                 dd($e);
              }
             //Email Sending Finished
              
             //For Activity History.......
             $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
              join companytypes as ct on ct.companytypeid=c.companytypeid
              where companyid = '$session_companyid'"))[0];
              if(isset($c_rec))
              {
               $actiontaken=\App\Helpers\AppGlobal::$DD_other_requested_to_join;
               $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
               $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
               $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
              }
             //End


                return response()->json(['message'=>'Success']); 
              }
              else
              {
                return response()->json(['message'=>'Failed']); 
              }
             
            

          }
          


}
