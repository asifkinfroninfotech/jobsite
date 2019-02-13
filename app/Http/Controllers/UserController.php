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


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    $user = Auth::user();
    $userid=$user->userid;
    $tenantid=$user->tenantid;
    $isadmin=$user->isadmin;
    //App::setLocale($locale);
   

    if($isadmin==false && $user->is_tenant==false)
    {
       // $request->session()->put('session_age', $age);
       $locale=$user->language;
       if(isset($locale) && !empty($locale) )
       {
         app()->setLocale($locale);
       }
       else
       {
         $helper= \App\Helpers\AppHelper::instance();
         $helper->SetTenant_PrimaryLanguage($tenantid);
       }

    $usertype= DB::table('users')
    ->join('usercompanies', 'users.userid', '=', 'usercompanies.userid')
    ->join('company', 'usercompanies.companyid', '=', 'company.companyid')
    ->join('companytypes','companytypes.companytypeid','=','company.companytypeid') 
    ->select('companytypes.companytype','company.name','company.companyid', 'usercompanies.userrole')
    ->where('users.userid','=',$userid)
    ->first();

// dd($usertype);
$companyid=$usertype->companyid;
$companytype=$usertype->companytype;
$company=$usertype->name;    


$tenantobj=DB::table('tenants')->where('tenantid',$tenantid)->first();
session(['companyname'=> $company]);
session(['companyid' => $companyid]);
session(['tenantid' => $tenantid]);
session(['userrole'=> $usertype->userrole]);
session(['userid'=> $userid]);
session(['usertype'=> $companytype]);
session(['dealid'=> '']);
session(['platformname'=>$tenantobj->platformname]);
session(['tenant_firstname'=>$tenantobj->firstname]);
session(['tenant_lastname'=>$tenantobj->lastname]);
session(['tenant_company'=>$tenantobj->company]);
session(['tenant_logo'=>$tenantobj->logo]);
session(['tenant_from_name'=>$tenantobj->from_name]);
session(['tenant_from_email'=>$tenantobj->from_email]);
session(['tenant_contact_us_link'=>$tenantobj->contact_us_link]);
session(['tenant_privacy_policy_link'=>$tenantobj->privacy_policy_link]);

session(['tenant_primary_color'=>$tenantobj->primarycolor]);
session(['tenant_secondary_color'=>$tenantobj->secondarycolor]);

            switch ($companytype) {
                case 'Investors':
                $data=$this->getDashboardData($userid,$companytype,$usertype->companyid,$companyid,$tenantid);
                return view('investor.dashboard',compact('data'));
                break;

                case 'Enterprises':
                     
                     $data=$this->getDashboardData($userid,$companytype,$usertype->companyid,$companyid,$tenantid);
                     return view('enterprise.dashboard', compact('data')); 
                break;
                case 'ESOs':
                
                    
                    $data=$this->getDashboardData($userid,$companytype,$usertype->companyid,$companyid,$tenantid);
                    return view('eso.dashboard',compact('data')); 
                break;
                case 'Service Providers':
                    $data=$this->getDashboardData($userid,$companytype,$usertype->companyid,$companyid,$tenantid);
                    return view('service_provider.dashboard', compact('data')); 
                break;
                     
                // break;
                
                default:
                    # code...
                    break;
            }
    }
    else if($isadmin==true)
    {
      session(['tenantid' => $tenantid]);
      session(['userid'=> $userid]);
      // return redirect()->route('/admin/dashboard');
      return redirect('/admin/dashboard');
    }
    else if($user->is_tenant==true)
    {
      $t_obj=DB::table('tenants as t')->where('t.userid',$user->userid)->first();
            session(['tenantid'=>$t_obj->tenantid]);
            session(['platformname'=>$t_obj->platformname]);
            session(['tenant_firstname'=>$t_obj->firstname]);
            session(['tenant_lastname'=>$t_obj->lastname]);
            session(['tenant_company'=>$t_obj->company]);
            session(['tenant_logo'=>$t_obj->logo]);
            session(['tenant_from_name'=>$t_obj->from_name]);
            session(['tenant_from_email'=>$t_obj->from_email]);
            session(['tenant_contact_us_link'=>$t_obj->contact_us_link]);
            session(['tenant_privacy_policy_link'=>$t_obj->privacy_policy_link]);

            session(['tenant_primary_color'=>$t_obj->primarycolor]);
            session(['tenant_secondary_color'=>$t_obj->secondarycolor]);

            $helper= \App\Helpers\AppHelper::instance();
            $helper->SetTenant_PrimaryLanguage($t_obj->tenantid);

            if($t_obj->is_profilecompleted==0)//Profile not completed, Send To Complete Profile First.
            {
                return redirect('/tenant/profilecomplete');
            }
            else
            {
              return redirect('/tenant/dashboard');
            }
    }

    }

    

//    private function getDashboardData($userid,$usertype,$companyid)
//    {
//
//         $visitor_count_today=DB::table('companyvisitors')
//                                  ->where('companyvisitors.companyid',$companyid)
//                                  ->where('companyvisitors.visitdate',date('Y-m-d'))
//                                  ->select('companyvisitors.visitorcount')
//                                  ->first();
//
//                                  dd($visitor_count_today);
//
//
//    }


    /* 
     * User Profile View method
     * Developed By Wasim Mirza Dated:15-March-2018
    */

    public function userprofileView(Request $request) {

      $calledfrom=$request->calledfrom; 
      $companyid=session('companyid');

      // if(isset($request->companyid) && !empty($request->companyid))
      // {
      //   $companyid=$request->companyid;
      // }

                //Code for friend  
                $getfriend=DB::table('friends as f')
                ->where('f.userid','=',session('userid'))
                ->select('userid','friendid','recordtype')        
                ->get(); 
                  //

        $user=$request->user;
        if(isset($user) && !empty($user))
        {
            $user_info = DB::table('users')->where('userid', $user)->first();
            DB::update(DB::raw("Update users set totalviews=totalviews+1 where userid='$user'"));
            $companyid=DB::table('usercompanies as uc')->where('uc.userid',$user)->first()->companyid;
        }
        else
        {
           $user_info = DB::table('users')->where('userid', session('userid'))->first(); 
        }
        
        // $user_info = DB::table('users')->where('userid', session('userid'))->first();
        $members = DB::table('usercompanies')
        ->select('userid')
        ->where('userid', '!=' , $user_info->userid )
        ->where('companyid', $companyid)
        ->where('recordstatus','=','Active')
        ->get();
        
        $team_members=array();
        foreach ($members as $member) {
          $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
        }
        $data = [
                  'user_info' => $user_info,
                  'team_member' => $team_members,
                  'friends'=> $getfriend
        ];
        
        return view('investor.user_profile_view', compact('data','calledfrom'));
    }

    /* 
     * User Profile Edit method
     * Developed By Wasim Mirza Dated:15-March-2018
    */ 
        
    public function userProfileEdit( Request $request) {

                      //Code for friend  
                      $getfriend=DB::table('friends as f')
                      ->where('f.userid','=',session('userid'))
                      ->select('userid','friendid','recordtype')        
                      ->get(); 
                        //
      
         $user = Auth::user();
         $userid=$user->userid;

         $friend_count=DB::select(DB::raw("Select COUNT(*) as fcount from friends where userid='$userid' and recordtype='friend'"))[0];

         $friend_requests=DB::table('friends')
                   ->leftjoin('users', 'users.userid', 'friends.friendid')
                   ->leftjoin('usercompanies', 'users.userid', '=', 'usercompanies.userid')
                   ->leftjoin('company', 'usercompanies.companyid', '=', 'company.companyid')
                   ->leftjoin('companytypes','companytypes.companytypeid','=','company.companytypeid') 
                   ->where('friends.userid',$userid) 
                   ->where('friends.recordtype','receiver')
                   ->where('friends.tenantid',session('tenantid'))
                   ->select('users.firstname as user_firstname','users.lastname as user_lastname','users.profileimage','companytypes.companytype','company.name as companyname','company.companyid','friends.friendid','friends.recordtype')  
                   ->get();
        
        $user_info = DB::table('users')->where('userid', session('userid'))->first();
        $members = DB::table('usercompanies')
                               ->select('userid')
                               ->where('userid', '!=' , session('userid') )
                               ->where('companyid', session('companyid'))
                               ->where('recordstatus','=','Active')
                               ->get();
        
         $team_members=array();                      
        foreach ($members as $member) {
          $team_members[] = DB::table('users')->where('userid', $member->userid )->get();
        }      

        $data = [
                  'user_info' => $user_info,
                  'team_member' => $team_members,
                  'friend_requests'=> $friend_requests,
                  'friends'=> $getfriend
        ];
        
        return view('investor.user_profile_edit', compact('data','friend_count'));
    }

    /* 
     * User Profile Update method
     * Developed By Wasim Mirza Dated:15-March-2018
     */  
    
    public function userProfileUpdate( Request $request) {
        // User general info     
        if($request->has('user_info')) {
    
           $data = [ 
                  'email' => $request->input('email'),
                  'userpassword'=> $request->input('password'),
                  'password' => bcrypt($request->input('password')),
                  'firstname' => $request->input('first_name'),
                  'lastname' => $request->input('last_name'),
                  'userposition' => $request->input('position'),
                  'telephone' => $request->input('telephone'),
                  'mobile' => $request->input('mobile'), 
                  'skype' => $request->input('skype'),
                  'twitter' => $request->input('twitter'),
                  'personalbackground' => $request->input('personalbackground'),
                  
            ];
             
            
            DB::table('users')->where('userid', session('userid'))->update($data);
            return redirect()->back();            

        } elseif( $request->hasFile('file') && $request->input('profile_image') ) { 
                  // Functionality to update user profile image
                   $helper= \App\Helpers\AppHelper::instance();
                   $response['status'] = 0 ;                
                   $file = $request->file('file');
                   $extension = $file->getClientOriginalExtension();
                   $mime = $file->getClientMimeType();
                   $original_filename = $file->getClientOriginalName();
                   $filename = $file->getFilename().'.'.$extension;
                   $document_application_name=$helper->fnGetUniqueID('5','users','profileimage');
                   $document_application_name = $document_application_name.'.'.$extension;
                   
                   //$response['status'] = Storage::disk('user_profileimage')->put( $filename,file_get_contents($file),'private');
                   $uploadDir = 'storage';
                    $tmpFile = $_FILES['file']['tmp_name']; 
                    $filename = $uploadDir.'/user/profileimage/'. $document_application_name;
                    if(move_uploaded_file($tmpFile,$filename))
                    {
                    $response['status']=1;
                    $filename = $file->getFilename().'.'.$extension;;
                    }
                   
                   
                   
                   if($response['status']) {
                        DB::table('users')
                             ->where('userid',session('userid'))
                             ->update(['profileimage' => $document_application_name ]); 
                      
                      return response()->json(['success'=>true]);
                    }
                   
                   return redirect()->back()->with($response);  

        } elseif( $request->hasFile('file') && $request->input('cover_image') ) { 
                   // Functionality to update user Cover image
                   $helper= \App\Helpers\AppHelper::instance();
                   $response['status'] = 0 ;                
                   $file = $request->file('file');
                   $extension = $file->getClientOriginalExtension();
                   $mime = $file->getClientMimeType();
                   $original_filename = $file->getClientOriginalName();
                   $filename = $file->getFilename().'.'.$extension;
                   
                   $document_application_name=$helper->fnGetUniqueID('5','users','coverimage');
                   $document_application_name = $document_application_name.'.'.$extension;
                   
                   
                    $uploadDir = 'storage';
                    $tmpFile = $_FILES['file']['tmp_name']; 
                    $filename = $uploadDir.'/user/coverimage/'. $document_application_name;
                    if(move_uploaded_file($tmpFile,$filename))
                    {
                    $response['status']=1;
                    $filename = $file->getFilename().'.'.$extension;;
                    }
                   
                   //$response['status'] = Storage::disk('user_coverimage')->put( $filename,file_get_contents($file),'private');
                    // $response['status'] = $file->move('storage/user/coverimage', $document_application_name);
                   if($response['status']) {
                        DB::table('users')
                             ->where('userid',session('userid'))
                             ->update(['coverimage' => $document_application_name ]); 
                      
                      return response()->json(['success'=>true]);
                    }
                   
                   return redirect()->back()->with($response);  
        }

        return view('investor.user_profile_edit', compact('data'));
    }


          public function getDueDiligenceProcess()
        {
          $companyid=session('companyid');

          $modules=DdModule::with('pipelinedeal')->with('dd_question')
                             ->get();

                            
          return view('investor.duediligence_process',compact('modules'));
        }


        public function getModuleQuestions(Request $request)
        {

            $moduleid=$request->moduleid;//Input::get('moduleid');
            $questions=DdQuestion::where('moduleid',$moduleid)
            ->with(['user' => function($c)
                    {
                    $c->select('userid','firstname','lastname','profileimage');
                    }])
                ->get();

            $view=View::make('investor._support_ticket')->with('data',$questions);

            return $view;
            //view('investor._support_ticket',compact('questions'));
        }


        public function getQuestionAnswers(Request $request)
        {
          $questionid=$request->questionid;

            $view=View::make('investor._diligence_process_previous_reply');

            return $view;
        }

        public function updateuserstatusmessage(Request $request)
        {
           $statusmessage=$request->statusmessage;
           $userid=session('userid');
           $now = new \DateTime();
           if( (isset($statusmessage) && !empty($statusmessage) )  &&  (isset($userid) && !empty($userid)) )
           {
               DB::table('users')->where('userid',$userid)->where('tenantid',Session('tenantid'))->update(['statusmessage' => $statusmessage]);
               return response()->json(['message'=>'Success']); 
           }


        }


        public function getcompanycompleteprofilefunction()
        {
         $qcompanyid = session('companyid');
         $qcompanytype=session('usertype');
         $quserid=Session('userid');
         if ($qcompanytype == 'Investors' ) 
         {
         $companyinformationcount=0;    
         $companyinformationtotalcount=0;    
         $company_information = DB::table('company')->leftjoin('companyvideos', 'company.companyid', 'companyvideos.companyid')->where('company.companyid', $qcompanyid)->first();
         //Total company information count calculated
         {
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->name) && isset($company_information->name)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->email) && isset($company_information->email)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->telephone) && isset($company_information->telephone)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->website) && isset($company_information->website)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->skype) && isset($company_information->skype)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->twitter) && isset($company_information->twitter)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->address) && isset($company_information->address)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->city) && isset($company_information->city)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->zip) && isset($company_information->zip)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->countryid) && isset($company_information->countryid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->stateid) && isset($company_information->stateid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->profileimage) && isset($company_information->profileimage)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->coverimage) && isset($company_information->coverimage)) 
         {
           $companyinformationcount+=1;  
         }
         
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->videotitle) && isset($company_information->videotitle)) 
         {
           $companyinformationcount+=1;  
         }
         
          
         }
         //investment and interests type data
         {
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->yearsinvolved) && isset($company_information->yearsinvolved)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->numbertodate) && isset($company_information->numbertodate)) 
         {
           $companyinformationcount+=1;  
         }  
          $companyinformationtotalcount+=1;
           if(!empty($company_information->preferedinvestmentaveragesize) && isset($company_information->preferedinvestmentaveragesize)) 
         {
           $companyinformationcount+=1;  
         }    
            $companyinformationtotalcount+=1;
           if(!empty($company_information->fundsundermanagement) && isset($company_information->fundsundermanagement)) 
         {
           $companyinformationcount+=1;  
         }  
           $companyinformationtotalcount+=1;
           if(!empty($company_information->levelofinvolvement) && isset($company_information->levelofinvolvement)) 
         {
           $companyinformationcount+=1;  
         }  
          $companyinformationtotalcount+=1;
           if(!empty($company_information->numberofemployees) && isset($company_information->numberofemployees)) 
         {
           $companyinformationcount+=1;  
         }  
           $companyinformationtotalcount+=1;
           if(!empty($company_information->isonbehalfofinstitution) && isset($company_information->isonbehalfofinstitution)) 
         {
           $companyinformationcount+=1;  
         } 
          $companyinformationtotalcount+=1;
           if(!empty($company_information->taxidnumber) && isset($company_information->taxidnumber)) 
         {
           $companyinformationcount+=1;  
         }
         //return $companyinformationcount.' '.$companyinformationtotalcount;
         
         
        //  $companyinformationtotalcount+=1;
        //    if(!empty($company_information->taxidnumber) && isset($company_information->taxidnumber)) 
        //  {
        //    $companyinformationcount+=1;  
        //  } 
          $sectors = DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray();
         $companyinformationtotalcount+=1;
           if(!empty($sectors) && isset($sectors)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->mission) && isset($company_information->mission)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->outcomes) && isset($company_information->outcomes)) 
         {
           $companyinformationcount+=1;  
         } 
         $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
           
        $companyinformationtotalcount+=2;
           if(!empty( $documents) && isset($documents)) 
         {
           $private=0;
           $public=0;
           foreach($documents as $document)
           {
              if($document->documentstatus=="Private")
              {
                 $private+=1; 
              }
              if($document->documentstatus=="Public")
              {
                 $public+=1; 
              }
           }
           if($private > 0)
           {
              $companyinformationcount+=1 ;
           }
           if($public > 0)
           {
               $companyinformationcount+=1;
           }
           
         } 
         
         
         
         }
        
         
        return number_format((float)(($companyinformationcount/$companyinformationtotalcount)*100), 0, '.', '');
       
        //return $companyinformationcount.' '.$companyinformationtotalcount;  
         }
        
         if ($qcompanytype == 'ESOs' ) 
        {
         $companyinformationcount=0;    
         $companyinformationtotalcount=0;    
         $company_information = DB::table('company')->leftjoin('companyvideos', 'company.companyid', 'companyvideos.companyid')->where('company.companyid', $qcompanyid)->first();
         $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();
         //dd($company_information);
          //Total company information count calculated
         {
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->name) && isset($company_information->name)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->statusmessage) && isset($company_information->statusmessage)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->numberofemployees) && isset($company_information->numberofemployees)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->taxidnumber) && isset($company_information->taxidnumber)) 
         {
           $companyinformationcount+=1;  
         } 
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->twitter) && isset($company_information->twitter)) 
         {
           $companyinformationcount+=1;  
         }
         
        $companyinformationtotalcount+=1;  
         if(!empty($company_information->email) && isset($company_information->email)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->telephone) && isset($company_information->telephone)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->website) && isset($company_information->website)) 
         {
           $companyinformationcount+=1;  
         }
         
           $companyinformationtotalcount+=1;  
         if(!empty($company_information->address) && isset($company_information->address)) 
         {
           $companyinformationcount+=1;  
         }
         
                 $companyinformationtotalcount+=1;  
         if(!empty($company_information->city) && isset($company_information->city)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->zip) && isset($company_information->zip)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->countryid) && isset($company_information->countryid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->stateid) && isset($company_information->stateid)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->profileimage) && isset($company_information->profileimage)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->coverimage) && isset($company_information->coverimage)) 
         {
           $companyinformationcount+=1;  
         }
         
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->videotitle) && isset($company_information->videotitle)) 
         {
           $companyinformationcount+=1;  
         }        
        
         }
         //Service Offering and Interests
         {
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->teamsizeid) && isset($company_information->teamsizeid)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($sector_id) && isset($sector_id)) 
         {
           $companyinformationcount+=1;  
         }  
         
          $companyinformationtotalcount+=1;
           if(!empty($company_information->noofenterprisesupported) && isset($company_information->noofenterprisesupported)) 
         {
           $companyinformationcount+=1;  
         }    
            $companyinformationtotalcount+=1;
           if(!empty($company_information->aboutus) && isset($company_information->aboutus)) 
         {
           $companyinformationcount+=1;  
         }  
           $companyinformationtotalcount+=1;
           if(!empty($company_information->affiliations) && isset($company_information->affiliations)) 
         {
           $companyinformationcount+=1;  
         }  
          
         $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
           
        $companyinformationtotalcount+=2;
           if(!empty( $documents) && isset($documents)) 
         {
           $private=0;
           $public=0;
           foreach($documents as $document)
           {
              if($document->documentstatus=="Private")
              {
                 $private+=1; 
              }
              if($document->documentstatus=="Public")
              {
                 $public+=1; 
              }
           }
           if($private > 0)
           {
              $companyinformationcount+=1 ;
           }
           if($public > 0)
           {
               $companyinformationcount+=1;
           }
           
         } 
         
         
         
         }
        
         
        
         return number_format((float)(($companyinformationcount/$companyinformationtotalcount)*100), 0, '.', '');
          
         }
         
         
         if ($qcompanytype == 'Enterprises' ) 
        {
         $companyinformationcount=0;    
         $companyinformationtotalcount=0;    
         $company_information = DB::table('company')->leftjoin('companyvideos', 'company.companyid', 'companyvideos.companyid')->where('company.companyid', $qcompanyid)->first();
        //dd($company_information); 
        //Total company information count calculated
         {
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->name) && isset($company_information->name)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->email) && isset($company_information->email)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->telephone) && isset($company_information->telephone)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->website) && isset($company_information->website)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->skype) && isset($company_information->skype)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->twitter) && isset($company_information->twitter)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->address) && isset($company_information->address)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->city) && isset($company_information->city)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->zip) && isset($company_information->zip)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->countryid) && isset($company_information->countryid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->stateid) && isset($company_information->stateid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->profileimage) && isset($company_information->profileimage)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->coverimage) && isset($company_information->coverimage)) 
         {
           $companyinformationcount+=1;  
         }
         
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->videotitle) && isset($company_information->videotitle)) 
         {
           $companyinformationcount+=1;  
         }
         
         
         }
         //Business Profile
         {
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->foundedyear) && isset($company_information->foundedyear)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->preferedcurrencyid) && isset($company_information->preferedcurrencyid)) 
         {
           $companyinformationcount+=1;  
         } 
         
         $selected_entity =  DB::table('company')
                                                  ->select('accountingcompanytype')
                                                  ->where('companyid', session('companyid'))
                                                  ->first();  
         
         
         
          $companyinformationtotalcount+=1;
           if(!empty( $selected_entity) && isset( $selected_entity) )
         {
           $companyinformationcount+=1;  
         } 
         
         $sectors = DB::table('companysectors')
                                                   ->select('sectorid')
                                                   ->where('companyid', session('companyid') )
                                                   ->get()->toArray();
         $companyinformationtotalcount+=1;
           if(!empty($sectors) && isset($sectors)) 
         {
           $companyinformationcount+=1;  
         } 
         
         
         
         
         
            $companyinformationtotalcount+=1;
           if(!empty($company_information->referredbyid) && isset($company_information->referredbyid)) 
         {
           $companyinformationcount+=1;  
         } 
         
         
           $companyinformationtotalcount+=1;
           if(!empty($company_information->businesssummary) && isset($company_information->businesssummary)) 
         {
           $companyinformationcount+=1;  
         }  
         
         
          $companyinformationtotalcount+=1;
           if(!empty($company_information->onelinepitch) && isset($company_information->onelinepitch)) 
         {
           $companyinformationcount+=1;  
         } 
         
           $companyinformationtotalcount+=1;
           if(!empty($company_information->salesstrategy) && isset($company_information->salesstrategy)) 
         {
           $companyinformationcount+=1;  
         } 
          $companyinformationtotalcount+=1;
           if(!empty($company_information->competativeadvantage) && isset($company_information->competativeadvantage)) 
         {
           $companyinformationcount+=1;  
         } 
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->existingpatents) && isset($company_information->existingpatents)) 
         {
           $companyinformationcount+=1;  
         } 
          
         $companyinformationtotalcount+=1;
           if(!empty($company_information->recognition) && isset($company_information->recognition)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->hearaboutartha) && isset($company_information->hearaboutartha)) 
         {
           $companyinformationcount+=1;  
         } 
         //Past financials
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_informationdate) && isset($company_information->financialinfo_informationdate)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_currentassets) && isset($company_information->financialinfo_currentassets)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_totalassets) && isset($company_information->financialinfo_totalassets)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_currentliabilities) && isset($company_information->financialinfo_currentliabilities)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_totalliabilities) && isset($company_information->financialinfo_totalliabilities)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_totalliabilities) && isset($company_information->financialinfo_totalliabilities)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_totalequity) && isset($company_information->financialinfo_totalequity)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_netcash) && isset($company_information->financialinfo_netcash)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_ebitda) && isset($company_information->financialinfo_ebitda)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;
           if(!empty($company_information->financialinfo_auditedfinancialstatement) && isset($company_information->financialinfo_auditedfinancialstatement)) 
         {
           $companyinformationcount+=1;  
         }
         
         //Impact Information
         $companyinformationtotalcount+=1;
           if(!empty($company_information->impactinfo_info) && isset($company_information->impactinfo_info)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->impactinfo_socialbenefitimpact) && isset($company_information->impactinfo_socialbenefitimpact)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->impactinfo_environmentbenefitimpact) && isset($company_information->impactinfo_environmentbenefitimpact)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->impactinfo_specificbeneficiaries) && isset($company_information->impactinfo_specificbeneficiaries)) 
         {
           $companyinformationcount+=1;  
         }
         
         
         $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
           
        $companyinformationtotalcount+=2;
           if(!empty( $documents) && isset($documents)) 
         {
           $private=0;
           $public=0;
           foreach($documents as $document)
           {
              if($document->documentstatus=="Private")
              {
                 $private+=1; 
              }
              if($document->documentstatus=="Public")
              {
                 $public+=1; 
              }
           }
           if($private > 0)
           {
              $companyinformationcount+=1 ;
           }
           if($public > 0)
           {
               $companyinformationcount+=1;
           }
           
         } 
         
         
         
         }
        
         
         
         return number_format((float)(($companyinformationcount/$companyinformationtotalcount)*100), 0, '.', '');
       
          
         }
         else
        {
         $companyinformationcount=0;    
         $companyinformationtotalcount=0;    
         $company_information = DB::table('company')->leftjoin('companyvideos', 'company.companyid', 'companyvideos.companyid')->where('company.companyid', $qcompanyid)->first();
         //dd($company_information);
         $sector_id = DB::table('companysectors')
                     ->select('sectorid')
                     ->where('companyid', $qcompanyid )
                     ->get();
         //dd($company_information);
          //Total company information count calculated
         {
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->name) && isset($company_information->name)) 
         {
           $companyinformationcount+=1;  
         }
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->statusmessage) && isset($company_information->statusmessage)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->numberofemployees) && isset($company_information->numberofemployees)) 
         {
           $companyinformationcount+=1;  
         }
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->taxidnumber) && isset($company_information->taxidnumber)) 
         {
           $companyinformationcount+=1;  
         } 
         
         $companyinformationtotalcount+=1;
           if(!empty($company_information->yearsinvolved) && isset($company_information->yearsinvolved)) 
         {
           $companyinformationcount+=1;  
         } 
         $companyinformationtotalcount+=1;  
         if(!empty($company_information->email) && isset($company_information->email)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->telephone) && isset($company_information->telephone)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->website) && isset($company_information->website)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->twitter) && isset($company_information->twitter)) 
         {
           $companyinformationcount+=1;  
         }
         
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->skype) && isset($company_information->skype)) 
         {
           $companyinformationcount+=1;  
         }
         
        
           $companyinformationtotalcount+=1;  
         if(!empty($company_information->address) && isset($company_information->address)) 
         {
           $companyinformationcount+=1;  
         }
         
                 $companyinformationtotalcount+=1;  
         if(!empty($company_information->city) && isset($company_information->city)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->zip) && isset($company_information->zip)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->countryid) && isset($company_information->countryid)) 
         {
           $companyinformationcount+=1;  
         }
         
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->stateid) && isset($company_information->stateid)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->profileimage) && isset($company_information->profileimage)) 
         {
           $companyinformationcount+=1;  
         }
         
          $companyinformationtotalcount+=1;  
         if(!empty($company_information->coverimage) && isset($company_information->coverimage)) 
         {
           $companyinformationcount+=1;  
         }
         
            $companyinformationtotalcount+=1;  
         if(!empty($company_information->videotitle) && isset($company_information->videotitle)) 
         {
           $companyinformationcount+=1;  
         }        
        
         }
         //Service Offering and Interests
         {
             
         //core_competencies intentianlly left    
             
             
      
         $companyinformationtotalcount+=1;
           if(!empty($sector_id) && isset($sector_id)) 
         {
           $companyinformationcount+=1;  
         }  
         
             
            $companyinformationtotalcount+=1;
           if(!empty($company_information->aboutus) && isset($company_information->aboutus)) 
         {
           $companyinformationcount+=1;  
         }  
           $companyinformationtotalcount+=1;
           if(!empty($company_information->affiliations) && isset($company_information->affiliations)) 
         {
           $companyinformationcount+=1;  
         }  
          $companyinformationtotalcount+=1;
           if(!empty($company_information->previousclients) && isset($company_information->previousclients)) 
         {
           $companyinformationcount+=1;  
         }
          $companyinformationtotalcount+=1;
           if(!empty($company_information->pastclients) && isset($company_information->pastclients)) 
         {
           $companyinformationcount+=1;  
         }
         
          
         $documents = DB::table('documents')
                            ->where('companyid', session('companyid'))
                            ->get();
           
        $companyinformationtotalcount+=2;
           if(!empty( $documents) && isset($documents)) 
         {
           $private=0;
           $public=0;
           foreach($documents as $document)
           {
              if($document->documentstatus=="Private")
              {
                 $private+=1; 
              }
              if($document->documentstatus=="Public")
              {
                 $public+=1; 
              }
           }
           if($private > 0)
           {
              $companyinformationcount+=1 ;
           }
           if($public > 0)
           {
               $companyinformationcount+=1;
           }
           
         } 
         
         
         
         }
        
         
         return number_format((float)(($companyinformationcount/$companyinformationtotalcount)*100), 0, '.', '');
         
       
          
         }
         //return $companyinformationcount.' '.$companyinformationtotalcount;
         
         //return number_format((float)(($companyinformationcount/$companyinformationtotalcount)*100), 0, '.', '');
         
         }
        



// - Starts (harshita) - //

    public function invite(Request $request) {
        $userId = $request->get('inviteid');
        $userdata = DB::table('users')->where('userid', $userId)->first();
        $whereArr = array(
            'userid' => $userId,
            'recordstatus' => 'Invited',
        );
        $user_company = DB::table('usercompanies')->where($whereArr)->first();

        if (empty($user_company)) {
            return redirect('/login');
        }
        $companyId = $user_company->companyid;
        $companydata = DB::table('company')->where('companyid', $companyId)->first();

        return view('tenants.inviteregister', compact('companydata', 'userdata'));
    }

    public function inviteregister(Request $request) {

        $data = [
            'userpassword' => $request->input('password'),
            'password' => bcrypt($request->input('password')),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'username' => $request->input('username'),
        ];

        $whereArr = array(
            'userid' => $request->input('userid'),
            'companyid' => $request->input('companyid')
        );

        DB::table('users')->where('userid', $request->input('userid'))->update($data);
        DB::table('usercompanies')->where($whereArr)->update(array('recordstatus' => 'Active'));


        return redirect('/login');
    }

    public function preRegister(Request $request) {

      $companyname="";
      if(isset($_GET['companyname']))
      {
          $companyname=$_GET['companyname'];
      }
        $tenantid = $request->tid;
        if(isset($tenantid)==false && empty($tenantid)==true)
        {
          return view('tenants.pre_register_error');
        }
        
        $helper = \App\Helpers\AppHelper::instance();
        $helper->SetTenant_PrimaryLanguage($tenantid);
        $tenant=DB::table('tenants')->where('tenantid',$tenantid)->first();
        if(isset($tenant)==false && empty($tenant)==true)
        {
          return view('tenants.pre_register_error');
        }

        if($tenant->tenantstatus=='Unverified')
        {
          $errormessage='Tenant is still in verification process.';
          return view('tenants.pre_register_error',compact('errormessage'));
        }

        session(['platformname'=>$tenant->platformname]);
        session(['tenant_firstname'=>$tenant->firstname]);
        session(['tenant_lastname'=>$tenant->lastname]);
        session(['tenant_company'=>$tenant->company]);
        session(['tenant_logo'=>$tenant->logo]);
        session(['tenant_from_name'=>$tenant->from_name]);
        session(['tenant_from_email'=>$tenant->from_email]);
        session(['tenant_contact_us_link'=>$tenant->contact_us_link]);
        session(['tenant_privacy_policy_link'=>$tenant->privacy_policy_link]);
         
        session(['tenant_primary_color'=>$tenant->primarycolor]);
        session(['tenant_secondary_color'=>$tenant->secondarycolor]);

        $whereArr = array(
            'companystatus' => 'Verified',
            'tenantid' => $tenantid
        );
        $countries = DB::table('country')->select('name', 'countryid')->get()->toArray();
        $company_list = DB::table('company')->where($whereArr)->select('name', 'companyid', 'profileimage', 'statusmessage', 'companytypeid')->get();
        $company_sectors = DB::table('sectors')->select('name', 'sectorid')->get()->toArray();

        $users_list = DB::table('users')->where('tenantid', $tenantid)->select('userid', 'firstname', 'lastname')->get()->toArray();

        $company_type_list = DB::table('companytypes')->where('companytype', '!=', 'Tenants')->select('companytype', 'companytypeid')->get()->toArray();

        foreach ($company_list as $key => $company) {
            if ((isset($company->profileimage) && !empty($company->profileimage) ) && File::exists(public_path('storage/company/profileimage/' . $company->profileimage))) {
                $image_src = asset('imagecache/company_logo/' . $company->profileimage);
            } else {
                $avatar = new Avatar();
                $image_src = $avatar->create($company->name)->toBase64();
            }
            $company_list[$key]->image = $image_src;
        }
        return view('tenants.pre_register', compact('heading', 'users_list', 'company_list', 'company_sectors', 'company_type_list', 'countries','tenant','companyname'));
    }

    public function savepreregister(Request $request) {
      $newtemplatecode="";
      $helper = \App\Helpers\AppHelper::instance();
      $tenantid = $request->tenantid;
      // $tenantid = \App\Helpers\AppGlobal::fnGet_tenantId();
//        echo '<pre>';
//        print_r($request->all());
//        echo '</pre>';
//        exit;

      $inputs = $request->all();
      extract($inputs);
      $tenantid = $inputs['tenantid'];

      $Is_AttachingToExistingCompany='Yes';
      $userrole=1;
      
          if (!isset($inputs['companyid'])) {
              $companyid = $helper->fnGetUniqueID(16, 'company', 'companyid');
              $company = DB::table('company')->insert(
                      [
                          'tenantid' => $tenantid,
                          'companyid' => $companyid,
                          'name' => $companyname,
                          'email' => $company_email,
                          'telephone' => $company_telephone,
                          'address' => $address,
                          'city' => $city,
                          'zip' => $zip,
                          'countryid' => $country,
                          'referredbyid' => $referredbyid,
                          'stateid' => $state,
                          'businesssummary' => $businesssummary,
                          'taxidnumber' => $taxidnumber,
                          'website' => $website,
                          'onelinepitch' => $onelinepitch,
                          'companytypeid' => $companytype,
                          'companystatus' => 'Unverified',
                          'currencyid' => 'ed477d',
                          'activestatus' => 'In-Active'
                      ]
              );

              if (!empty($specializedsectors) && is_array($specializedsectors)) {
                  foreach ($specializedsectors as $key => $sectorid) {
                      $company_sector = DB::table('companysectors')->insert(
                              [
                                  'tenantid' => $tenantid,
                                  'companyid' => $companyid,
                                  'sectorid' => $sectorid,
                                  'companysectorid' => $helper->fnGetUniqueID('16', 'companysectors', 'companysectorid')
                              ]
                      );
                  }
              }

              $Is_AttachingToExistingCompany='No';
              $userrole=0;
          }
          // 'username' => $username,
          $userid = $helper->fnGetUniqueID(16, 'users', 'userid');
          $user = DB::table('users')->insert(
                  [
                      'tenantid' => $tenantid,
                      'userid' => $userid,
                      'firstname' => $firstname,
                      'lastname' => $lastname,
                      'email' => $email,
                      'telephone' => $telephone,
                      'userposition' => $userposition,
                      'userpassword' => $password,
                      'activestatus' => 'active',
                      'password' => bcrypt($password),
                      'isadmin' => 0
                  ]
          );
//        $userid = $user->userid;

          $saveusercompanies = DB::table('usercompanies')->insert(
                  [

                      'tenantid' => $tenantid,
                      'userid' => $userid,
                      'companyid' => $companyid,
                      'recordstatus' => 'New-Request',
                      'userrole' => $userrole
                  ]
          );

          //Send Email [New Team Member Request]
        if($Is_AttachingToExistingCompany=='Yes')
        {
           $TemplateCode= \App\Helpers\AppGlobal::$NewTeamMemberRequest_TemplateCode;
           if(isset($TemplateCode))
           {
            $newtemplatecode=$TemplateCode;
             $TemplateMaster=DB::table('email_master_templates')->first();
              if(isset($TemplateMaster))
              {
                $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                if(isset($Template))
                {
                  $MessageBody=$Template->message;
                  $MessageBody=str_replace("%%SENDER%%",$firstname.' '.$lastname,$MessageBody);
                  $MessageBody=str_replace("%%SENDER_EMAIL%%",$email,$MessageBody);
                  $MessageBody=str_replace("%%RECEIVER%%",$companyname,$MessageBody);
                  $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                  $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                  $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                  $MessageBody=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$MessageBody);
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
                      // $t_logo=$helper->GetAvatarByName(session('tenant_firstname'),session('tenant_lastname'));   
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
                  $company_email=$helper->GetCompanyAdminUserEmail($companyid);
                  if(isset($company_email))
                  {
                    $helper->SendEmail($Template,$company_email,$Message_with_master);
                  }
                 
                }
              }


           }

        }
          //End of Sending Email.....


       //Send Email [New Company Welcome Email]
        if($Is_AttachingToExistingCompany=='No')
        {
           $TemplateCode= '';
           switch($companytype)
           {
             case "5eab3b"://Enterprises
             $TemplateCode= \App\Helpers\AppGlobal::$Welcome_Enterprise_TemplateCode;
             break;
             case "aba5f1"://Investors
             $TemplateCode= \App\Helpers\AppGlobal::$Welcome_Investor_TemplateCode;
             break;
             case "6c2b42"://ESOs
             $TemplateCode= \App\Helpers\AppGlobal::$Welcome_ESOs_TemplateCode;
             break;
             case "b5aa1d"://Service Providers/Third Party
             $TemplateCode= \App\Helpers\AppGlobal::$Welcome_Third_Party_TemplateCode;
             break;
           }
           $newtemplatecode=$TemplateCode;
           if(isset($TemplateCode) && !empty($TemplateCode))
           {
             $TemplateMaster=DB::table('email_master_templates')->first();
              if(isset($TemplateMaster))
              {
                $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                if(isset($Template))
                {
                  $MessageBody=$Template->message;
                  $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                  $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                  $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                  $MessageBody=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$MessageBody);
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
                    // $t_logo=$helper->GetAvatarByName(session('tenant_firstname'),session('tenant_lastname'));   
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
                  $company_email=$helper->GetCompanyAdminUserEmail($companyid);
                  if(isset($company_email))
                  {
                    $helper->SendEmail($Template,$company_email,$Message_with_master);
                  }
                }
              }


           }

        }
          //End of Sending Email.....
          return redirect('/thankyoupage?tid='.$tenantid.'&newtemplatecode='.$newtemplatecode); 
          // return redirect('/login?tid='.$tenantid);
  }

    // - Ends (harshita) - //
    
    //- asifteammember -//
    function teammembersearch(Request $request)
    {
        //getting friend list
          $getfriend=DB::table('friends as f')
          ->where('f.userid','=',session('userid'))
          ->select('userid','friendid','recordtype')        
          ->get(); 
        //
        
        
        $search=$request->searchstring;
        $qcompanyid=$request->company;
        $user=$request->user;
        if((!isset($qcompanyid) || empty($qcompanyid) ))
        {
        $qcompanyid = session('companyid');   
        }
       
        if(isset($user) && !empty($user))
        {
        $user_info = DB::table('users')->where('userid', $user)->first();
        }
        else
        {
        $user_info = DB::table('users')->where('userid', session('userid'))->first(); 
        }
        
         $members = DB::table('usercompanies')
          ->select('userid')
          ->where('userid', '!=' , $user_info->userid )
          ->where('companyid', $qcompanyid)
          ->where('recordstatus','=','Active')
          ->get();
     
         $team_members=array();
          foreach ($members as $member) {
            $team_members[] = DB::table('users')
                    ->where('userid', $member->userid )
                    ->where(DB::raw('concat(firstname," ",lastname)'),'like', '%' . $search . '%')
                    ->get();
          }
          //print_r($team_members[1][0]->firstname);
          $view='<div class="user-w"><div class="user-name">'.trans('notfoundlang.team-member').'</div></div>';
          for($i=0;$i<count($team_members);$i++)
          {
          if(isset($team_members[$i][0]) || !empty($team_members[$i][0]))
          {
          $view=View::make('shared._teammemberfiltering',compact('team_members','getfriend','qcompanyid'))->render();
          //break;
          }
          
          }
          return $view;
          
        
        
    }


  
  //
 //- asifcommondashboard -//
  
 public function getDashboardData($userid,$companytype,$usertypecompanyid,$companyid,$tid)
  {
     
                 $var1="SELECT (case when pd.parentpipelinedealid is null then pd.pipelinedealid else pd.parentpipelinedealid end) as pipelinedealid,d.projectname,(select count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and userid='$userid') as TotalQuestion,(select count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and userid='$userid' and questionstatus='Pending') as PendingQuestion  from pipelinedeals as pd 
                JOIN deals as d on d.dealid=pd.dealid
                where pd.companyid='$companyid' and pd.pipelinedealstatus='Due Diligence In Progress' and pd.IsPermissionDenied=0 and
                (select count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and userid='$userid')>0";
                 

                $duediligence_assignments=DB::select(DB::raw($var1));
     
     
                 $visitor_count_today=DB::table('companyvisitors') 
                          ->where('companyvisitors.companyid',$usertypecompanyid)
                          ->where('companyvisitors.visitdate',date('Y-m-d'))
                          ->where('companyvisitors.tenantid',session('tenantid'))
                          ->select('companyvisitors.visitorcount')
                          ->first();


                $friend_requests=DB::table('friends')
                   ->leftjoin('users', 'users.userid', 'friends.friendid')
                   ->leftjoin('usercompanies', 'users.userid', '=', 'usercompanies.userid')
                   ->leftjoin('company', 'usercompanies.companyid', '=', 'company.companyid')
                   ->leftjoin('companytypes','companytypes.companytypeid','=','company.companytypeid') 
                   ->where('friends.userid',$userid) 
                   ->where('friends.recordtype','receiver')
                   ->where('friends.tenantid',session('tenantid'))
                   ->select('users.firstname as user_firstname','users.lastname as user_lastname','users.profileimage','companytypes.companytype','company.name as companyname','company.companyid','friends.friendid','friends.recordtype')  
                   ->get(); 

                
                $usertype=DB::table('usercompanies')
                       ->where('tenantid',session('tenantid'))
                       ->where('userid',$userid)
                       ->select('userrole as usertype')    
                       ->get();
                
                $companycompleteprofile=$this->getcompanycompleteprofilefunction();
                
                
                
                
                
                $total_deals = DB::table('deals')
                                  ->where('companyid', session('companyid') )
                                  ->count();
                $deal_investment_count = DB::table('deals')
                                  ->where('companyid', session('companyid') )
                                  ->sum('totalinvestmentrequired');                  
                
                







                                  // ->whereNot('pipelinedealstatus','Due Diligence New')
$pipelinedeals_New=pipelinedeal::with('dd_modules')
                   ->where('companyid',session('companyid'))
                   ->with(['company' => function($c){
                    $c->select('companyid','name','statusmessage')
                    ->with(['usercompany' => function($uc){
                    $uc->select('userid','recordstatus','companyid')
                      ->with('user');
                   }]);


                   }])

                  ->with(['deal' => function($c){
                    $c->select('dealid','currencyid','proposedusesoffunds','investmentstage','totalinvestmentrequired','companyid','projectname','updated','totalviews')
                    ->with(['company' => function($u){
                      $u->select('companyid','name','statusmessage')
                      ->with(['usercompany' => function($uc){
                         $uc->select('userid','recordstatus','companyid')
                            ->with('user');
                   }]);
                    }]);
                   }])
                     
                   ->limit(3)
                   ->get();
      
      
      
//asif code
                   
                  $dealids="";
         
          foreach ($pipelinedeals_New as $key => $value) {
      
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
                      foreach ($pipelinedeals_New as $key => $value) {
                  
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
                      
                      
                      $country=DB::table('country as cn')
                                          ->join('company as c1','c1.countryid','cn.countryid')
                                          ->join('deals as d','c1.companyid','d.companyid')
                                          ->whereIn('c1.companyid', explode(',', $companyids))
                                          ->where('cn.activestatus','1')
                                          ->select('d.dealid','cn.name')
                                          ->get();
                      
                      // $deal_company_users=DB::table('usercompanies as uc')
                      //                     ->join('deals as d','uc.companyid','d.companyid')
                      //                     ->join('users as u','u.userid','uc.userid')
                      //                     ->whereIn('uc.companyid', explode(',', $companyids))
                      //                     ->where('uc.recordstatus','Active')
                      //                     ->select('d.dealid','uc.companyid','uc.userid','u.firstname','u.lastname','u.profileimage')
                      //                     ->get();
                                          
                      
                      // $loggedin_company_users=DB::table('usercompanies as uc')
                      //                     ->join('users as u','u.userid','uc.userid')
                      //                     ->where('uc.companyid', session('companyid'))
                      //                     ->where('uc.recordstatus','Active')
                      //                     ->select('uc.companyid','uc.userid','u.firstname','u.lastname','u.profileimage')
                      //                     ->get();
                
                    $modulequestionstatus="" ;
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
                     //asif-code

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
                  

                   /* 
                 * Recommended Bussiness and Live Pitch starts
                 * Developed By Wasim Mirza Dated:12-March-2018
                 */
                
                $sector_ids = DB::table('companysectors')
                                  ->select('sectorid')
                                  ->where('companyid',session('companyid'))
                                  ->get();  
                
          $recommendedvideo=array();
          $recommendedbusiness=array();
          
          if($sector_ids->isNotEmpty()) {
              foreach ($sector_ids as $sectorid) {
                    $recommendedvideo[] =  DB::table('companysectors')
                          ->where('companysectors.sectorid','=',$sectorid->sectorid )
                          ->where('companysectors.companyid','<>',session('companyid') )
                          ->leftjoin('company','company.companyid','companysectors.companyid') 
                          ->join('deals','deals.companyid','companysectors.companyid')
                          ->where('companysectors.tenantid',$tid)
                          ->where('company.tenantid',$tid)
                          ->where('deals.video','<>',"" )  
                          ->orderByRaw('RAND()')->take(1) 
                          ->select('deals.dealid','deals.video','company.name','company.profileimage','deals.projectname')  
                          ->get();
                    
                    $recommendedbusiness[] =  DB::table('companysectors')
                          ->where('companysectors.sectorid','=',$sectorid->sectorid )
                          ->where('companysectors.companyid','<>',session('companyid') )
                          ->leftjoin('company','company.companyid','companysectors.companyid')
                          ->leftjoin('companytypes as ct','ct.companytypeid','company.companytypeid')  
                          ->where('companysectors.tenantid',$tid)
                          ->where('company.tenantid',$tid)
                          // ->join('deals','deals.companyid','companysectors.companyid')
                          ->orderByRaw('RAND()')->take(4)  
                          ->select('company.companyid','company.name','company.profileimage','company.statusmessage','ct.companytype')  
                          ->get();
              }
          }
          
                 //dd($recommendedvideo[0]);
          
         
          
          
                
                
                
                $enterprise_company_id =  DB::table('companytypes')
                                  ->select('companytypeid')
                                  ->where('companytype', 'Enterprises')
                                  ->first()->companytypeid;                                   

                $companies = DB::table('pipelinedeals')
                                  ->select('dealid','companyid')
                                  ->where('companyid', '!=' ,session('companyid'))
                                  ->get()->toArray(); 

                
                foreach ($companies as $company) {
                   foreach ($sector_ids as $sector_id) {
                       foreach ($sector_id as $sectorid) {
                       $compid = DB::table('companysectors')
                                              ->select('companyid')
                                              ->where('companyid',$company->companyid)
                                              ->where('sectorid',$sectorid)
                                              ->first();
                       if($compid != null) {
                      $final_company = DB::table('company')
                                      ->select('companyid')
                                      ->where('companyid', $compid->companyid )
                                      ->where('companytypeid', $enterprise_company_id )
                                      ->first(); 
                          if($final_company != null) {
                          $final_deals[] = DB::table('deals')
                                            ->select('dealid','proposedusesoffunds')
                                            ->where('companyid',$final_company->companyid)
                                            ->first();   
                          }                     
                      }
                                                       
                    }
                  
                  }

                }
                 

               
                /* 
                 * Profile Completeness  starts
                 * Developed By Wasim Mirza Dated:12-March-2018
                 */
              
                $profile_completeness = DB::table('users')
                                         ->where('userid', $userid)
                                         ->first();
                $maximumPoints  = 580;
                $point = 0;
                foreach ($profile_completeness as $profile) {
                   if($profile != '') {
                      $point+=20;        
                   }
                }
                $point = $point-160;
                     
                    
                
                $profile_completeness =(int) (($point / $maximumPoints) * 100) ;

                
               
              // if(isset($modulequestionstatus) || !empty($modulequestionstatus))
              //   {
              //       $data=array('modulequestionstatus'=>$modulequestionstatus);
              //   }
                $data = [ 
                           'visitor_count_today' => $visitor_count_today,
                           'friend_requests' => $friend_requests,
                           'total_deals' => $total_deals,
                           'deal_investment_count' => $deal_investment_count,
                           'profile_completeness' => $profile_completeness,
                           'pipelinedeals' => $pipelinedeals_New,
                           'usertype'=> $usertype,
                           'completepercentage'=>$companycompleteprofile,
                           'recommendedbusiness'=>$recommendedbusiness,
                           'recommendedvideo'=>$recommendedvideo,
                           'deals_sdgs'=>$deals_sdgs,
                          //  'deal_company_users'=>$deal_company_users,
                          //  'loggedin_company_users'=>$loggedin_company_users,
                           
                           'pipelinefolders'=>$pipelinefolders,
                           'country'=>$country,
                           'duediligence_assignments'=>$duediligence_assignments,
                           'All_Associated_company'=>$All_Associated_company,
                           'parent_pipelinedeal_data'=>$parent_pipelinedeal_data,
                           'modulequestionstatus'=>$modulequestionstatus
                        ]; 
                
                
                
                return $data;
  
  }
  
 
  public function getallpendingrequests()
  {
    $userid=session('userid');
    $companyid=session('companyid');
    $tenantid=session('tenantid');
    $checkAdmin=DB::table('usercompanies as uc')
                ->where('uc.companyid',$companyid)
                ->where('uc.userid',$userid)
                ->where('uc.tenantid',$tenantid)
                ->select('uc.userid','uc.userrole')
                ->first(); 

    $Is_AdminUser="No";
    if($checkAdmin->userrole=="0")
    {
      $Is_AdminUser="Yes";
    }

    $view=View::make('Pending_Requests.requests',compact('Is_AdminUser'))->render();
     return $view;
  }

  public function getfriendrequests(Request $request)
  {

    $userid=session('userid');
    $searchtext=$request->searchtext;
    $sortby=$request->sortby;

    //$friend_requests

    $query=DB::table('friends as f')
    ->leftjoin('users as u', 'u.userid', 'f.friendid')
    ->leftjoin('usercompanies as uc', 'u.userid', '=', 'uc.userid')
    ->leftjoin('company as c', 'uc.companyid', '=', 'c.companyid')
    ->leftjoin('companytypes as ct','ct.companytypeid','=','c.companytypeid') 
    ->where('f.userid',$userid) 
    ->where('f.recordtype','receiver')
    ->where('f.tenantid',session('tenantid'));
    // ->select('u.firstname','u.lastname','u.profileimage','ct.companytype','c.name as company','c.companyid','f.friendid','f.recordtype','u.is_online','c.profileimage as company_profileimage','u.userposition','u.email')  
    // ->get();

    if(isset($searchtext) && !empty($searchtext))
    {
     $query->where(function ($query ) use ($searchtext)
              {
               $query->where('u.firstname', 'like', '%' . $searchtext . '%')
                ->orwhere('u.lastname', 'like', '%' . $searchtext . '%')
                ->orWhere('c.name','like', '%' . $searchtext . '%')
                ->orWhere('u.userposition','like', '%' . $searchtext . '%');
              });
    }
            // ->orderBy('updated', 'desc');
            if(isset($sortby) && !empty($sortby))
            {
                switch ($sortby) {
                  case 'firstname':
                  $query->orderBy('u.firstname');
                  break;
                  case 'username':
                  $query->orderBy('u.email');
                      break;
                    case 'name':
                    $query->orderBy('c.name');
                        break;
        

                    
                    default:
                        
                        break;
                }
                
            }

            $friend_requests = $query->select('u.firstname','u.lastname','u.profileimage','ct.companytype','c.name as company','c.companyid','f.friendid','f.recordtype','u.is_online','c.profileimage as company_profileimage','u.userposition','u.email')  
                               ->get(); 

    $view=View::make('Pending_Requests.friendlist',compact('friend_requests'))->render();
     return $view;


  }
  
   public function getnewteammemberrequests(Request $request)
   {
      $userid=session('userid');
      $searchtext=$request->searchtext;
      $sortby=$request->sortby;
      $companyid=session('companyid');

      $query=DB::table('usercompanies as uc')
      ->leftjoin('users as u', 'u.userid', 'uc.userid')
      ->leftjoin('company as c', 'uc.companyid', '=', 'c.companyid')
      ->leftjoin('companytypes as ct','ct.companytypeid','=','c.companytypeid') 
      ->where('uc.companyid',$companyid) 
      ->where('uc.recordstatus','New-Request')
      ->where('uc.tenantid',session('tenantid'));
  
      if(isset($searchtext) && !empty($searchtext))
      {
       $query->where(function ($query ) use ($searchtext)
                {
                 $query->where('u.firstname', 'like', '%' . $searchtext . '%')
                  ->orwhere('u.lastname', 'like', '%' . $searchtext . '%')
                  ->orWhere('c.name','like', '%' . $searchtext . '%')
                  ->orWhere('u.userposition','like', '%' . $searchtext . '%');
                });
      }

             if(isset($sortby) && !empty($sortby))
              {
                  switch ($sortby) {
                    case 'name':
                    $query->orderBy('u.firstname');
                    break;
                    case 'username':
                    $query->orderBy('u.email');
                        break;
                  }
                  
              }
  
              $team_member_requests = $query->select('uc.userid','u.firstname','u.lastname','u.profileimage','ct.companytype','c.name as company','c.companyid','c.profileimage as company_profileimage','u.userposition','u.email')  
                                 ->get(); 
  
      $view=View::make('Pending_Requests._new_team_member_requests',compact('team_member_requests'))->render();
       return $view;

   }

   public function AcceptRejectTeamMemberRequest(Request $request)
   {
    $userid=$request->userid;
    $mode=$request->mode;
    $companyid=session('companyid');
    $tenantid=session('tenantid');
    $helper= \App\Helpers\AppHelper::instance();

    $user_receiver=DB::select(DB::raw("Select * from users where userid='$userid' and tenantid='$tenantid'"))[0];
    if(isset($userid) && isset($mode))
    {
      switch($mode)
      {
        case 'Accept':
          DB::update("Update usercompanies set recordstatus='Active' where userid='$userid' and companyid='$companyid' and tenantid='$tenantid'");
          DB::update("Update users set activestatus='active' where userid='$userid' and tenantid='$tenantid'");
        break;

        case 'Decline':
          DB::delete("delete from usercompanies where userid='$userid' and companyid='$companyid' and tenantid='$tenantid'");
          DB::delete("delete from users where userid='$userid' and tenantid='$tenantid'");
            break;
      }

                                    //Send Email
                                    try{
                                      $TemplateCode="";
                                      if($mode=="Accept")
                                      {
                                      //New Team Member Request has been Accepted.
                                      $TemplateCode= \App\Helpers\AppGlobal::$TeamMemberRequestAccepted_TemplateCode;
                                      }
                                      else
                                      {
                                     //New Team Member Request has been Rejected/Declined.
                                      $TemplateCode= \App\Helpers\AppGlobal::$TeamMemberRequestDeclined_TemplateCode;
                                      }

                                           
                                                if(isset($TemplateCode))
                                                {
                                                  $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                                                  if(isset($Template))
                                                  {
                                                    $TemplateMaster=DB::table('email_master_templates')->where('tenantid',$tenantid)->first();
                                                    if(isset($TemplateMaster))
                                                    {
                                         
                                                                                                  
                                                      $receiver_email=$user_receiver->email;
                                          
                                                      $MessageBody=$Template->message;
                                                      $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                                                      $MessageBody=str_replace("%%RECEIVER%%",$user_receiver->firstname,$MessageBody);
                                                      $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                                                      $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                                                      $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
                                                      $MessageBody=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$MessageBody);
                                                               
                                                      $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$TemplateMaster->content);  
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
                            
                            
                                    //End of sending Email Code.

                                    return response()->json(['success'=>true]);
    }
    else
    {
      return response()->json(['success'=>false]);
    }

   }

   public function hideform()
   {
       session()->forget('helpview');
       
   }
   public function showform()
   {
       
    session(['helpview'=>'1']);   
     
   }
    
}
