<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
//use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use session;
use View;
use File;

class NetworkController extends Controller
{
      /*
        $company_types = DB::table('companytypes')->get();
        $countries = DB::table('country')->get();
        $company_sectors = DB::table('sectors')->get(); */

      
       public function network(Request $request)
        {
        
        $selectedcompanytype=DB::table('company')
              ->where('companyid',session('companyid'))
              ->select('company.companytypeid')->first();  
           
           
        $company_types = DB::table('companytypes')->get();
        $countries = DB::table('country')->get();
        $company_sectors = DB::table('sectors')->get();

        if($request->input('network_search')) {
            
            if($request->input('country') && empty($request->input('sector')) ) {
               $countryids = $request->input('country');

               foreach ($countryids as $countryid) {
                 $companies[] = DB::table('company')->where('countryid', $countryid)->get();
                 foreach ($companies as $company) {
                     foreach ($company as $companytype) {
                       $companytypes = DB::table('companytypes')->where('companytypeid', $companytype->companytypeid)->get()->toArray();
                       $final_companies[$companytypes[0]->companytype][$companytype->name] = DB::table('companysectors')
                        ->join('sectors', 'companysectors.sectorid', '=', 'sectors.sectorid')
                        ->select('name')
                        ->where('companyid', $companytype->companyid )
                        ->get()->toArray();
                       }
                }
              } 
            } elseif($request->input('country') && $request->input('sector') ) {
                $sectorids = $request->input('sector');
                foreach ($sectorids as $sectorid) {
                  $companyid_from_sectors[] = DB::table('companysectors')
                                ->select('companyid')
                                ->where('sectorid', $sectorid)->get()->unique()->implode('companyid',',');

                  
                  $countryids = $request->input('country');
                 foreach ($countryids as $countryid) {
                   $company = DB::table('company')->where('countryid', $countryid)
                                                  ->whereIn('companyid',$companyid_from_sectors)
                                                  ->first();
                   if(!empty($company)) {
                   $companytypes = DB::table('companytypes')->where('companytypeid', $company->companytypeid)->first();
                   $final_companies[$companytypes->companytype][$company->name]= DB::table('companysectors')
                        ->join('sectors', 'companysectors.sectorid', '=', 'sectors.sectorid')
                        ->select('name')
                        ->where('companyid', $company->companyid )
                        ->get()->toArray();
                  }      

                 } 
              }   
              
            } elseif( $request->input('sector') ) {
              $sectorids = $request->input('sector');
                foreach ($sectorids as $sectorid) {
                  $companysectors = DB::table('sectors')
                                  ->join('companysectors', 'companysectors.sectorid','sectors.sectorid')
                                  ->where('sectors.sectorid', $sectorid)->get();
                  foreach ($companysectors as $company_sectors) {
                    $companies = DB::table('company')->where('companyid', $company_sectors->companyid)->first();
                    $entity_type = DB::table('companytypes')->where('companytypeid', $companies->companytypeid)->first()->companytype;
                    $sector = collect(['name' => $company_sectors->name]) ;
                    $networks[$entity_type][$companies->name][] = $sector; 
                            
                  }
              } 
              dd($networks);
              return view('network/network', compact('networks','countries','company_sectors', 'companies' ));
                 
         } elseif( $request->input('status') ) {
               $status = $request->input('status');
        }
            
        } else { 
        
          foreach ($company_types as $companytype) {
           $companies = DB::table('company')->where('companytypeid', $companytype->companytypeid )->paginate(10);
            
            foreach ($companies as $company) {
              if( !empty($company) ) {
              $networks[$companytype->companytype][$company->name][] = DB::table('companysectors')
                        ->join('sectors', 'companysectors.sectorid', '=', 'sectors.sectorid')
                        ->select('name')
                        ->where('companyid', $company->companyid )
                        ->get();
              }         
            }

        }
        
      } 
      //dd($networks);
      
      
       
//       $company=DB::table('company') 
//               ->join('country', 'country.countryid', '=', 'company.countryid')
//               ->where('company.tenantid', '=', Session('tenantid'))
//               ->where('country.activestatus', '=', '1')
//               ->select('*', 'company.name as companyname')
//               ->paginate('3');
//        dd($company);
        
        
              
      
      
      
      return view('network/network', compact('networks','countries','company_sectors', 'companies','selectedcompanytype'));

      
      
       
      
      
      
      
      } 
      
      
      public function getnetworkdata()
      {
        //$company=DB::select( DB::raw($searchcompany1));
      
        
//        $company=DB::table('company') 
//               ->join('country', 'country.countryid', '=', 'company.countryid')
//               ->join('companysectors', 'companysectors.companyid', '=', 'company.companyid') 
//              
//               ->where('company.tenantid', '=', Session('tenantid'))
//               ->where('country.activestatus', '=', '1')
//               ->select('*', 'company.name as companyname','companysectors.sectorid as sectorid1')
//              
//               ->paginate('3');
//        
//        
//        
//       
//         $view=View::make('network.networkfilter',compact('company'))->render();
//          
//          
//         return response()->json(['view'=>$view]);
      }
      
      public function getfilterdata(Request $request)
      {
      $usercompany=$request->usercompany;        
       if($usercompany=="company")
       {
        $NetworkPageSize= \App\Helpers\AppGlobal::fnGet_NetworkPageSize();
        $query=DB::table('company as c') 
               ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
               ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
               ->where('c.tenantid', '=', Session('tenantid'));
              
               
               
          if(isset($request->companycategory) || !empty($request->companycategory))
          {
              $query->Where('c.companytypeid', '=', $request->companycategory );
          }
          if(isset($request->selected) || !empty($request->selected))
          {
               $query->whereIn('c.countryid', array($request->selected));
          }

          $sectorids=$request->sector;


          if(isset($sectorids) && !empty($sectorids))
          {
            $query->whereIn('c.companyid', function($q1) use($sectorids) 
              { 
                  $q1->select('companyid')->from('companysectors')->whereIn('sectorid', explode(',', $sectorids));
               }
          );
          }

        $searchtext=$request->search;
        if(isset($searchtext) && !empty($searchtext))
        {
  
          $query->where('c.name','like', '%' . $searchtext . '%');
           
        }

        if(isset($request->sortme) && !empty($request->sortme))
        {
            switch ($request->sortme) {
                case 'name':
                $query->orderBy('c.name');
                    break;
            }
            
        }
        
        
          
          $company=$query->select('c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype')->paginate($NetworkPageSize);

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
      

          if(isset($data) && !empty($data))
                  {
          $view=View::make('network.networkfiltercompany',compact('company'))->render();

                  }
                  else
                  {
                      $view='<div class="element-box-tp"><div class="table-responsive"><table class="table table-padded network-rows"><tbody><tr><td>'.trans('notfoundlang.network').'</td></tr></tbody></table></div></div>';
                  }
          //$view=View::make('network.networkfilter',compact('company'))->render();
       
                  return $view;
                  }
                  
       if($usercompany=="users")
       {
        $getcompanyid=session('companyid');
        $getuser=session('userid');
        $NetworkPageSize= \App\Helpers\AppGlobal::fnGet_NetworkPageSize();
        $companycategory=$request->companycategory;

                //getting friend of userid
                $getfriend=DB::table('friends as f')
                ->where('f.userid','=',$getuser)
                ->select('userid','friendid','recordtype')        
                ->get(); 
                       
                
                $query="";

        if($companycategory=="contact")
        {
          //getting only friend of userid
                          $getfriendnew=DB::table('friends as f')
                          ->where('f.userid','=',$getuser)
                          ->where('f.recordtype','friend')
                          ->select('userid','friendid','recordtype')        
                          ->get();   
          $friend_ids="";
          foreach ($getfriendnew as $value) 
          {
             if($friend_ids=="")
             {
               $friend_ids=$value->friendid;
             }
             else
             {
              $friend_ids=$friend_ids.','.$value->friendid;
             }
          }
          $query=DB::table('company as c') 
          ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
          ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
          ->leftjoin('usercompanies as uc','c.companyid','uc.companyid')
          ->leftjoin('users as us','us.userid','uc.userid')
          ->where('uc.recordstatus', '=', 'Active')
          ->where('uc.userid','!=',session('userid'))
          ->where('c.tenantid', '=', Session('tenantid'))
          ->whereIn('us.userid',explode(',', $friend_ids));
        }
        else
        {

        $query=DB::table('company as c') 
               ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
               ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
               ->leftjoin('usercompanies as uc','c.companyid','uc.companyid')
               ->leftjoin('users as us','us.userid','uc.userid')
               ->where('uc.recordstatus', '=', 'Active')
               ->where('uc.userid','!=',session('userid'))
               ->where('c.tenantid', '=', Session('tenantid'));
              
              
          if(isset($request->companycategory) || !empty($request->companycategory))
          {
              $query->Where('c.companytypeid', '=', $request->companycategory );
          }
        }
        

          if(isset($request->selected) || !empty($request->selected))
          {
               $query->whereIn('c.countryid', array($request->selected));
          }

          $sectorids=$request->sector;


          if(isset($sectorids) && !empty($sectorids))
          {
            $query->whereIn('c.companyid', function($q1) use($sectorids) 
              { 
                  $q1->select('companyid')->from('companysectors')->whereIn('sectorid', explode(',', $sectorids));
               }
          );
          }

        $searchtext=$request->search;
        if(isset($searchtext) && !empty($searchtext))
        {
                $query->where(function ($query ) use ($searchtext)
                {
                 $query->Where('us.email','like', '%' . $searchtext . '%')
                  ->orWhere('us.userposition','like', '%' . $searchtext . '%')
                  ->orWhere('c.name','like', '%' . $searchtext . '%');
                  
                });
           
        }

        if(isset($request->sortme) && !empty($request->sortme))
        {
            switch ($request->sortme) {
                case 'name':
                $query->orderBy('c.name');
                    break;
            }
            
        }
        
        
          
          $company=$query->select('c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype','us.email','us.userid','us.userposition')->paginate($NetworkPageSize);

          
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
      

          if(isset($data) && !empty($data))
                  {
          $view=View::make('network.networkfilteruser',compact('company','getcompanyid','getfriend'))->render();

                  }
                  else
                  {
                      $view='<div class="element-box-tp"><div class="table-responsive"><table class="table table-padded network-rows"><tbody><tr><td>'.trans('notfoundlang.network').'</td></tr></tbody></table></div></div>';
                  }
          //$view=View::make('network.networkfilter',compact('company'))->render();
       
                  return $view;
                  }           
                  
                  
         
      }
         
      function senderfriend(Request $request)
      {
          $tenantid=session('tenantid');
          $senderid = $request->sender;
          $friendid = $request->friend;
          $reciever_recordtype='receiver';
          $sender_recordtype='sender';

          $userid=session('userid');
          
            $send= DB::table('friends')->insert(
                  [
                  'tenantid' => $tenantid, 
                  'userid' => $senderid,
                  'friendid'=> $friendid,
                  'recordtype' => $sender_recordtype,
                 
                  ]
                 );
            
            $recieve= DB::table('friends')->insert(
                  [
                  'tenantid' => $tenantid, 
                  'userid' => $friendid,
                  'friendid'=> $senderid,
                  'recordtype' => $reciever_recordtype,
                 
                  ]
                 );
            

                         //Send Email
            $helper= \App\Helpers\AppHelper::instance();
            $TemplateCode= \App\Helpers\AppGlobal::$NewFriendRequest_TemplateCode;
            if(isset($TemplateCode))
            {
                $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                if(isset($Template))
                {
                    $TemplateMaster=DB::table('email_master_templates')->first();
                    if(isset($TemplateMaster))
                    {
                        $user_receiver=DB::select(DB::raw("SELECT * from users as u where u.userid='$friendid' and u.tenantid='$tenantid'"))[0];

                        $receiver_email=$user_receiver->email;
                        $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                          $MessageBody=$Template->message;
                          $MessageBody=str_replace("%%RECEIVER%%",$user_receiver->firstname.' '.$user_receiver->lastname,$MessageBody);
                          $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                          $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
                                                   
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
                              // $t_logo=Avatar::create(ucfirst(session('tenant_firstname').' '.session('tenant_lastname')))->toBase64();
                              $t_logo= \App\Helpers\AppGlobal::$App_Domain."/img/logo_desktop.png";
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

            //Email Code
         
           return $friendid;
            
          
      }
      
      
      
      
      
      
        
}
