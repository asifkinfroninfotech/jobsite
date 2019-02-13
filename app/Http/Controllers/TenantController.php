<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Validation;
use DB;
use View;
use Session;
//use session;
use Validator;
use App\Models\Pipelinedeal;
use App\Models\DdModule;
use App\Models\DdQuestion;
use App\Models\Tenant;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;
use File;
use Carbon\Carbon;
use Laravel\Cashier\Subscription;




class TenantController extends Controller
{
   
    
    public function logininformation(Request $request)
    {
        
       $planid=$request->pid; 
       $plans=DB::select( DB::raw("select * from plans where planid = '".$planid."' "));
       if(count($plans) > 0  && $plans[0]->plandstatus=="Active")
       {
           //JUGAD, To hide Asif's bebkufi.
           $invalidts=DB::table('tenants')->whereNull('cardnumber')->get();
           $tids='';
           foreach($invalidts as $t)
           {
               if($tids=="")
               {
                $tids="'".$t->tenantid."'";
               }
               else
               {
                $tids= $tids.','. "'".$t->tenantid."'";
               }
           }
           if($tids!="")
           {
            DB::Delete(DB::raw("Delete from users where tenantid in ($tids) and is_tenant=1"));
            DB::Delete(DB::raw("Delete from tenants where tenantid in ($tids)"));
           }

           //
          
         $country=DB::select( DB::raw("select countryid,name from country"));
         session(['tenant_primary_color'=>'']);
         session(['tenant_secondary_color'=>'']);
           
         return view('tenants.tenant_login_info')->with('country',$country)->with('plans',$plans);
        
       
       }
       else
       {
           return view('tenants.login');
       }
        
    }
    
    
   
    
    
    
    public function savelogininformation(Request $request)
    {
        
        $email=$request->email;
        $getemail=DB::select( DB::raw("select email from users where email = '".$email."'"));
      if(!isset($getemail))
        {
           return response()->json(['tenantid'=>0,'save'=>1]);
        }
        if(isset($getemail))
        {
            if(count($getemail)==0)
            {
                return response()->json(['tenantid'=>0,'save'=>1]);
                
            }
            if(count($getemail)>0)
            {
                return response()->json(['email'=>"email already exist",'save'=>0]); 
            }
        }
        
    
        
    }
    
   
     public function getstates(Request $request)
    {
       $countryid=$request->countryid;
       $getstate=DB::select( DB::raw("select * from state where countryid = '".$countryid."'"));
       
       $view=View::make('tenants.tenant_create_states')->with('data',$getstate)->render();
       //return $view;
       
       return response()->json(['states'=>'getstate','view'=>$view]);
        
    }
    
    
     public function getcity(Request $request)
    {
       $stateid=$request->stateid;
       $getstate=DB::select( DB::raw("select * from city where stateid = '".$stateid."'"));
       $getcity=1;        
       $view=View::make('tenants.tenant_create_states')->with('data',$getstate)->with('option',$getcity)->render();
       //return $view;
       
       return response()->json(['states'=>'getcity','view'=>$view,'stateid'=>$stateid]);
        
    }
    
    
    
    
     public function companyprofilesave(Request $request)
    {
            // $tenantid=$request->talenthidden;
            // $companyname=$request->companyname;
            // $companytelephone=$request->companytelephone;
            // $companyaddress=$request->companyaddress;
            // $companycity=$request->companycity;
            // $companypostcode=$request->companypostcode;
            // $companycountry=$request->companycountry;
            // $companystate=$request->companystate;

            // $returnValue = DB::table('tenants')
            // ->where('tenantid', '=', $tenantid )
            // ->update([
            //    'company' => $companyname,
            //    'phone' => $companytelephone,
            //    'address1'=>$companyaddress,
            //    'city' => $companycity,
            //    'postcode' => $companypostcode,
            //    'country' => $companycountry,
            //    'state' => $companystate,
               
            //  ]);
            
            $tenantid='';
        return response()->json(['tenantid'=>$tenantid,'save'=>1]);
        
        
    }
    
    
    public function cardsave(Request $request)
    {
         //New Code
           $helper= \App\Helpers\AppHelper::instance();
           $tenantid=$helper->fnGetUniqueID(6, 'tenants', 'tenantid');
           $userid=$helper->fnGetUniqueID(16, 'users', 'userid');

           $firstname=$request->firstname;
           $lastname=$request->lastname;
           $email=$request->email;
           $password=$request->password;
           $platform=$request->platform;

           //company related fields
           $companyname=$request->companyname;
           $companytelephone=$request->companytelephone;
           $companyaddress=$request->companyaddress;
           $companycity=$request->companycity;
           $companypostcode=$request->companypostcode;
        //    $companycountry=$request->companycountry;
        //    $companystate=$request->companystate;
           $companycountry=$request->companycountrynew;
           $companystate=$request->companystatenew;
           
           $emailsave= DB::table('tenants')->insert(
                 [
                 'tenantid' => $tenantid, 
                 'firstname' => $firstname,
                 'lastname'=> $lastname,
                 'email' => $email,
                 'password' => $password,
                 'userid'=>$userid,
                 'company' => $companyname,
                 'phone' => $companytelephone,
                 'address1'=>$companyaddress,
                 'city' => $companycity,
                 'postcode' => $companypostcode,
                 'country' => $companycountry,
                 'state' => $companystate, 
                 'tenantactive' =>1,
                 'platformname'=>$platform   
                 ]
                );
           $usersave=DB::table('users')->insert(
           [
               'userid'=>$userid,
               'password'=>bcrypt($password),
               'userpassword'=>$password,
               'tenantid'=>$tenantid,
               'email'=>$email,
               'firstname'=>$firstname,
               'lastname'=>$lastname,
               'isadmin'=>0,
               'is_tenant'=>1,
           
           ]
           );

       


       //    $tenantid=$request->talenthiddenid3;
          session(['tenantid'=>$tenantid]);


        //End of New Code

           $planid=$request->planid;
           $planval="";
           if(isset($planid))
           {
               if($planid=="e44af5cd68e4f6c8")
               {
                   $planval="plan_DOM7VlYtcg2ZKS";
               }
                if($planid=="e44af5cd68e4f6c9")
               {
                   $planval="plan_DOM6xvkxNjwpD6";
               }
           }
           
           
           $cardname=$request->cardname;
           $cardnumber=$request->cardnumber;
           $cardexpiry=$request->cardexpiry;
           $cardcode=$request->cardcode;
         
          
          if($planid=="e44af5cd68e4f6c7")
          {
           $returnValue = DB::table('tenants')
           ->where('tenantid', '=', $tenantid )
           ->update([
             'cardname' => $cardname,
             'cardnumber' => $cardnumber,
             'expiry' => $cardexpiry, 
             'cvv' => $cardcode,
             'planid'=>$planid, 
             'trial_ends_at'=>now()->addDays(90),  
              
            ]);
          }
           
         
           
           
      if($planid=="e44af5cd68e4f6c8" || $planid=="e44af5cd68e4f6c9")  
      {
           
    try{      
           
          \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
           $response = \Stripe\Token::create(array(
                      "card" => array(
                          "number"    => $cardnumber,
                          "exp_month" => str_before($cardexpiry, '/'),
                          "exp_year"  => str_after($cardexpiry, '/'),
                          "cvc"       => $cardcode,
                          "name"      => $cardname
                      )
                  ));
                //$response_array = $response->__toArray(true);
          $stripeToken = $response['id'];
          $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
          if($tenant->newSubscription($planval, $planval)->create($stripeToken))
          {
             $stripeid=DB::table('subscriptions')
             ->where('tenant_tenantid', '=', $tenantid )
             ->select('stripe_id')->first()->stripe_id;
             $subscriptionresponse= \Stripe\Subscription::retrieve($stripeid);
             $nextrenewdate=$subscriptionresponse->current_period_end;
             $updated = DB::table('subscriptions')
           ->where('stripe_id', $stripeid)
           ->update([
               'renews_at' => Carbon::createFromTimestamp($nextrenewdate),
           ]);
              
          }
    }
    
      
      
 // Network problem, perhaps try again.
//        } 
         catch (\Stripe\Error\ApiConnection $e) {
            
             $tenantid=session('tenantid');
             DB::table('users')->where('tenantid', $tenantid)->where('is_tenant',1)->delete();
             DB::table('tenants')->where('tenantid', $tenantid)->delete();
            return "Network problem, perhaps try again.";
     }
            catch (\Stripe\Error\InvalidRequest $e) {
                
//              $tenantid=session('tenantid');
DB::table('users')->where('tenantid', $tenantid)->where('is_tenant',1)->delete();
DB::table('tenants')->where('tenantid', $tenantid)->delete();
                
            return 'You screwed up in your programming. Shouldnt happen!';
} 
       
            catch (\Stripe\Error\Api $e) {
            DB::table('users')->where('tenantid', $tenantid)->where('is_tenant',1)->delete();
             DB::table('tenants')->where('tenantid', $tenantid)->delete(); 
             return "Stripe's servers are down!";
           } catch (\Stripe\Error\Card $e) {
             $tenantid=session('tenantid');
             DB::table('users')->where('tenantid', $tenantid)->where('is_tenant',1)->delete();
             DB::table('tenants')->where('tenantid', $tenantid)->delete();   
               
            return "Card was declined.";
        }
        
        $returnValue = DB::table('tenants')
           ->where('tenantid', '=', $tenantid )
           ->update([
             'cardname' => $cardname,
             'cardnumber' => $cardnumber,
             'expiry' => $cardexpiry, 
             'cvv' => $cardcode,
             'planid'=>$planid,  
              
            ]);
        
      }


                     //Sending Tenant Welcome Email
                     $TemplateCode= \App\Helpers\AppGlobal::$Welcome_Tenant_TemplateCode;
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
              
                            $helper->SendEmail($Template,$email,$Message_with_master);
                          }
                        }
              
              
                     }
              
                     //End of Welcome Email
              
              
                      
                      return response()->json(['tenantid'=>$tenantid,'save'=>1]); 
    
          
          
//            
//          $tenant=Tenant::where('tenantid', '=', $tenantid)->first();   
//           
//           
//          $customer = \Stripe\Customer::create(array(
//           "email" => $tenant->email,
//           "source" => $stripeToken->id,
//          ));
//
//           
//           
//          $plandetails= \Stripe\Subscription::create(array(
//          "customer" => $customer->id,
//          "items" => array(
//          array(
//          "plan" => "plan_DOM7VlYtcg2ZKS",
//          ),
//          )
//          ));
         
//            
//            
//  echo $plandetails->id;
//  echo $plandetails->items->name;
//  echo $plandetails->items->quantity;
//  echo $plandetails->plan->trial_end;
 //print_r($plandetails->plan);
 
//  DB::table('subscriptions')->insert(
//                  [
//                  'stripe_id' => $plandetails->id , 
//                  'stripe_plan'=> $plandetails->items->data->name ,
//                  'quantity' => $plandetails->items->data->quantity,
//                  'trial_ends_at'=>$plandetails->plan->trial_end,
//                  'trial_ends_at'=>$plandetails->plan->trial_end,   
//                  
//                  ]
//                 );
 
 
           
//            \Stripe\Subscription::create(array(
//            "customer" => "cus_Cm3DPQD307iLih",
//            "items" => array(
//           array(
//            "plan" => "plan_ChyOVdEWtNEQcx",
//            ),
//           )
//         ));
           
           
//            try{
//            
//           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
//           $tenant->newSubscription('main', 'plan_DKJBD4iypm71iL')->create($stripeToken);
//           
//           
//           
//           // $tenant->subscription('plan_DKJBD4iypm71iL')->create($stripeToken);
////            catch (\Stripe\Error\ApiConnection $e) {
////            // Network problem, perhaps try again.
//        } 
//         catch (\Stripe\Error\InvalidRequest $e) {
//         echo 'You screwed up in your programming. Shouldnt happen!';
//         $body = $e->getJsonBody();
//  $err  = $body['error'];
//
//  print('Status is:' . $e->getHttpStatus() . "\n");
//  print('Type is:' . $err['type'] . "\n");
//  print('Code is:' . $err['code'] . "\n");
//  // param is '' in this case
//  print('Param is:' . $err['param'] . "\n");
//  print('Message is:' . $err['message'] . "\n");
//         
//         
//        } 
       
//        catch (\Stripe\Error\Api $e) {
//    // Stripe's servers are down!
//        } catch (\Stripe\Error\Card $e) {
//    // Card was declined.
//        }
           
           
           
       //return response()->json(['tenantid'=>$tenantid,'save'=>1]);
       
       
   }
    
    
    
    
    public function payandconfirm(Request $request)
    {
        $tenantid=$request->tenantid;
        if(isset($tenantid))
        {
        Session::set('tenantid', $tenantid);
        }
         $tenants=DB::select( DB::raw("select tenants.firstname,tenants.lastname,tenants.username,tenants.email as tenantemail,tenants.password,tenants.cardname,tenants.cardnumber,tenants.expiry,tenants.cvv,company.name,company.email as companyemail,company.telephone,company.address,company.city,company.zip,company.countryid,company.stateid from tenants,company where tenants.tenantid=company.tenantid  and tenants.tenantid = '".$tenantid."'"));
         $count=count($tenants);
         if($count==0)
         {
             return response()->json(['button'=>0,'states'=>'button']);
         }
         if($count > 0 && (empty($tenants->firstname) || empty($tenants->lastname) || empty($tenants->username) || empty($tenants->tenantemail) || empty($tenants->password) || empty($tenants->cardname) || empty($tenants->cardnumber) || empty($tenants->expiry) || empty($tenants->cvv) || empty($tenants->name) || empty($tenants->companyemail) || empty($tenants->telephone) || empty($tenants->address) || empty($tenants->city) || empty($tenants->zip) || empty($tenants->countryid) || empty($tenants->stateid)))
         {
              return response()->json(['button'=>0,'states'=>'button']);
         }
         if($count > 0 && (!empty($tenants->firstname) && !empty($tenants->lastname) && !empty($tenants->username) && !empty($tenants->tenantemail) && !empty($tenants->password) && !empty($tenants->cardname) && !empty($tenants->cardnumber) && !empty($tenants->expiry) && !empty($tenants->cvv) && !empty($tenants->name) && !empty($tenants->companyemail) && !empty($tenants->telephone) && !empty($tenants->address) && !empty($tenants->city) && !empty($tenants->zip) && !empty($tenants->countryid) && !empty($tenants->stateid)))
         {
              return response()->json(['button'=>1,'states'=>'button']);
         }
    }
    
    
    public function paymentsuccess(Request $request)
    {
        $price=$request->price;
        //return response()->json(['price'=>$price,'states'=>'payment']);
        
        
        //return view('tenants.tenant_payment_success')->with('data',$payment);
        
        
        return view('tenants.tenant_payment_success');
        
        
    }
    
    public function paymentfailure(Request $request)
    {
        //return response()->json(['price'=>$price,'states'=>'payment']);
       //return view('tenants.tenant_payment_fail')->with('data',$payment);
   
        return view('tenants.tenant_payment_fail');
        
    }
    
    public function tenantlogin()
    {
        $tenantid = session('tenantid');
        if(isset($tenantid)==false)
        {
            return redirect()->route('logout');
        }
         $tenant1=DB::table('tenants')->where('tenantid',$tenantid)->first();      
         $tenant=DB::select( DB::raw("select *,state.name as statename,country.name as countryname,state.name as statename,city.name as cityname from tenants,country,state,city where tenants.tenantid = '".$tenantid."' and tenants.country=country.countryid and tenants.state=state.stateid and tenants.city=city.id"));
        
        //  $count=count($tenant);

     
        
          return view('tenants.tenant_dashboard',compact('tenant','tenant1'));
   
        
    }
    
    public function tenant_profile_view(Request $request)
    {

        $calledfrom=$request->calledfrom;
        
        if(isset($request->tenid) && !empty($request->tenid))
        {
          $tenantid = $request->tenid;  
        }
        else
        {
          $tenantid = session('tenantid');
        }

        if(isset($tenantid)==false)
        {
            return redirect()->route('logout');
        }

        //  $tenant=DB::select( DB::raw("select *,state.name as statename,country.name as countryname,state.name as statename,city.name as cityname from tenants,country,state,city where tenants.tenantid = '".$tenantid."' and tenants.country=country.countryid and tenants.state=state.stateid and tenants.city=city.id"));
        
         $tenant=DB::select( DB::raw("select *,state.name as statename,country.name as countryname,state.name as statename,city.name as cityname from tenants left join country on tenants.country=country.countryid left join state on tenants.state=state.stateid left join city on tenants.city=city.id where tenants.tenantid = '".$tenantid."'"));
         $count=count($tenant);
     
        
          return view('tenants.tenant_view',compact('tenant','calledfrom'));
        
    }


    public function company()
    {
     
        $tenantid=session('tenantid');
        $companytypes=DB::table('companytypes as ct')
           ->select('ct.companytype')->get();                    
        
                  
           $company=DB::table('company as c') 
           ->leftjoin('country as cn', 'cn.countryid', '=', 'c.countryid')
           ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
           ->leftjoin('tenants as t','c.tenantid','t.tenantid')         
           ->where('c.tenantid',$tenantid)
           ->where('c.companystatus','Verified')
           ->select('c.tenantid','c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype','t.firstname as tenantfirstname','t.lastname as tenantlastname','t.company as tenantcompany','t.logo as tenantprofileimage','c.activestatus')->get();
 
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
         
         
        
        
        return view('tenants.admin_related_pages.company',compact('company','companytypes'));
    }
       
    
    public function deal()
    {
        $tenantid=session('tenantid');
      $query = DB::table('deals as d')
       ->leftjoin('company as c','c.companyid','d.companyid') 
       ->leftjoin('country as cn','cn.countryid','c.countryid')
       ->leftjoin('users as us','us.userid','d.userid')
        ->leftjoin('currency as cur','d.currencyid','cur.currencyid')
        ->where('d.tenantid', $tenantid);
      
      $data = $query->select('c.name as company','c.statusmessage','d.investmentstage','d.updated','cn.name as country','d.totalviews','d.totalinvestmentrequired','d.dealid','d.investmentstructure','d.purposeofinvestment','d.projectname','us.profileimage','us.firstname','us.lastname','cur.symbol')->get();
  
    
      
      
           
           
        return view('tenants.admin_related_pages.deal',compact('data'));
    }
          
    
    public function user()
    {
       $status='Active';
       $status=$status.','.'Inactive';

        $tenantid=session('tenantid');
           $users=DB::table('users as us') 
              ->join('usercompanies as uc', 'uc.userid', '=', 'us.userid')
              ->join('company as c','uc.companyid','c.companyid')
              ->join('companytypes as ct','ct.companytypeid','c.companytypeid') 
              ->leftjoin('country as cn','c.countryid','cn.countryid')
              ->where('us.tenantid',$tenantid)
              ->wherein('uc.recordstatus',explode(',', $status))
              ->select('us.userid','us.profileimage as userprofileimage','us.firstname','us.lastname','c.profileimage','c.name','c.companyid','ct.companytype','us.userposition','uc.userrole','uc.recordstatus as Status')
              ->get();
             
             
              return view('tenants.admin_related_pages.user',compact('users'));
    }
        
    
    public function duediligence()
    {
        $tenantid=session('tenantid');
        $pipelinedeal=DB::table('pipelinedeals as pd')
                ->leftjoin('deals as dl', 'pd.dealid', 'dl.dealid')
                ->leftjoin('company as c','pd.companyid','c.companyid')
                ->leftjoin('country as cn','c.countryid','cn.countryid')
                ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
                ->leftjoin('currency as cur','dl.currencyid','cur.currencyid')
                ->whereNull('pd.parentpipelinedealid')
                ->where('pd.tenantid',$tenantid)
                ->select('pd.tenantid','pd.pipelinedealid','pd.parentpipelinedealid','c.companyid','c.name as companyname','c.profileimage as companyprofileimage','dl.projectname','dl.investmentstage','dl.totalinvestmentrequired','cn.name as country','dl.dealid','pd.pipelinedealstatus','cur.symbol','ct.companytype')->get();
        return view('tenants.admin_related_pages.duediligence',compact('pipelinedeal'));
    }
    
    
    
   public function uploadtenantlogoimage()
   {
    $tenantid = session('tenantid');
    $uploadDir = 'img';
    if (!empty($_FILES)) {
    $tmpFile = $_FILES['file']['tmp_name'];
    $filename = $uploadDir.'/tenants/'. $_FILES['file']['name'];
    if(move_uploaded_file($tmpFile,$filename))
    {
        $returnValue=DB::table('tenants')
            ->where('tenantid', '=', $tenantid )
            ->update([
              'logo' => $_FILES['file']['name']
              
               
             ]);
        
    }
    }
       
       
       
   }
   
   public function uploadtenantcoverimage()
   {
      
       
    $tenantid = session('tenantid');
    $uploadDir = 'img';
    if (!empty($_FILES)) {
    $tmpFile = $_FILES['file']['tmp_name'];
    $filename = $uploadDir.'/tenants/'. $_FILES['file']['name'];
    if(move_uploaded_file($tmpFile,$filename))
    {
        $returnValue=DB::table('tenants')
            ->where('tenantid', '=', $tenantid )
            ->update([
              'cover' => $_FILES['file']['name']
              
               
             ]);
        
    }
    }
       
       
       
       
       
       
   }
   
   
   public function savetenantinfo(Request $request)
   {
    // 'primarycolor' => 'required',
    // 'secondarycolor' => 'required',
    // 'primarycolor.required' => trans('tenant_complete_profile.primary_color_validation'),
    // 'secondarycolor.required' => trans('tenant_complete_profile.secondary_color_validation'),
       $validator = Validator::make($request->all(), [
        'about' => 'required',
        'terms' => 'required',
        'from_name'=>'required',   
        'from_email'=>'required',
        'contact_us_link'=>'required',
        'privacy_policy_link'=>'required'   
    ],[
    			'about.required' => trans('tenant_complete_profile.about_validation'),
    			'terms.required' => trans('tenant_complete_profile.terms_validation'),
                        'from_name.required'=>trans('tenant_complete_profile.from_name_validation'),  
                        'from_email.required'=>trans('tenant_complete_profile.from_email_validation'),
                        'contact_us_link.required'=>trans('tenant_complete_profile.contact_us_validation'),
                        'privacy_policy_link.required'=>trans('tenant_complete_profile.privacy_policy_validation')
               
      ]);
       
       if ($validator->fails()) {
        return redirect('/tenant/profilecomplete')
                    ->withErrors($validator)
                    ->withInput();
       }
       
        $tenantid = session('tenantid');
        $returnValue=DB::table('tenants')
            ->where('tenantid', '=', $tenantid )
            ->update([
              'primarycolor' => $request->primarycolor,
              'secondarycolor' => $request->secondarycolor,
              'about' => $request->about,
              'term' => $request->terms,
              'from_name'=>$request->from_name,
              'from_email'=>$request->from_email,
              'contact_us_link'=>$request->contact_us_link,
              'privacy_policy_link'=>$request->privacy_policy_link,  
              ]);
        
        
        //code for saving primarylanguages and secondarylanguages
        if(isset($request->primarylogin))
        {
        $getprimarylanguage=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','1');
        
        if(!isset($getprimarylanguage))
        {
           
        }
        else
        {
            $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','1')->delete();
            
        }
        for($i=0;$i<count($request->primarylogin);$i++) 
           {
            $primarylanguage=DB::table('tenant_languages')->insert([
                'tenantid'=>$tenantid,
                'language'=>$request->primarylogin[$i],
                'is_primary'=>1
            ]);
           }
        
        }
        
        if(isset($request->secondarylogin))
        {
        $getsecondarylanguage=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','0');
        
        if(!isset($getsecondarylanguage))
        {
           
        }
        else
        {
            $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','0')->delete();
            
        }
        for($i=0;$i<count($request->secondarylogin);$i++) 
           {
            $primarylanguage=DB::table('tenant_languages')->insert([
                'tenantid'=>$tenantid,
                'language'=>$request->secondarylogin[$i],
                'is_primary'=>0
            ]);
           }
        
        }
        
        
        
        
        
        $gettenantdetails=DB::table('tenants')->where('tenantid','=',$tenantid)->first();
        if(!empty($gettenantdetails->about)&& !empty($gettenantdetails->term) && !empty($gettenantdetails->from_name) && !empty($gettenantdetails->from_email)&& !empty($gettenantdetails->contact_us_link) && !empty($gettenantdetails->privacy_policy_link))
        {
          DB::table('tenants')->where('tenantid', '=', $tenantid)->update([
           'is_profilecompleted'=>1,   
          ]);
           return redirect('/tenant_profile_confirmation');
        }
        else
        {
          return redirect('/tenant/profilecomplete');  
        }
        
       // return redirect()->back()->with('message', 'Data updated successfully');
      
       
   }
    
    public function tenantprofileconfirmation()
    {
        $tenantid=session('tenantid');
        $tenantdetails=DB::table('tenants')->where('tenantid','=',$tenantid)->first();
        return view('tenants.tenant_profile_confirmation',compact('tenantdetails')); 
    }
    
   //Asif code for email checking pre register
    public function checemailpreregister(Request $request)
    {
        $email=$request->email;
        $tenantid=$request->tenantid;
        if(isset($email))
        {
        $results = DB::select( DB::raw("SELECT count(*) as countreq FROM users WHERE email = '$email'") );
        }
        if(isset($results) || !empty($results))
        {
        return $results[0]->countreq;
        }
        else
        {
            return 0;
        }
       
    }
    
    public function checklandingpage(Request $request)
    {
        $checkpage=DB::select( DB::raw("SELECT count(*) as tenantcount FROM tenants_landingpage WHERE tenantid = '$request->tenantid'") );
        if($checkpage > 0)
        {
          $page='0';  
        }
        if($checkpage == 0)
        {
            $page='1';
        }
        
        return $page;
        
    }
   
    public function newlandingpage()
    {
    //    $tenant_landing_logo = DB::table('tenants_landingpage')
    //                  ->select('logo','telephone','address','open_hours','block_section_heading','heading_2','text','button_text','heading_link','facebook','twitter','linkedin')
    //                  ->where('tenantid', '=', session('tenantid'))
    //                  ->first();

    $tenant_landing_logo = DB::table('tenants_landingpage')
                     ->select('logo','telephone','address','open_hours','block_section_heading','section_heading','section_text','section_button_text','section_button_link','facebook','twitter','linkedin','testimonial','faq')
                     ->where('tenantid', '=', session('tenantid'))
                     ->first();
       
       
 
        
        return view('tenants.tenant_new_landing_page',compact('tenant_landing_logo'));  
    }
    
    public function tenantLogoUpdate(Request $request)
    {
        
        if( $request->input('profile_image')) {
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
              $document_application_name=$helper->fnGetUniqueID('5','tenants_landingpage','logo');
              $document_application_name = $document_application_name.'.'.$extension;
               
              $filename = $uploadDir.'/tenant/logoimage/'. $document_application_name;
               if(move_uploaded_file($tmpFile,$filename))
               {
             $response['status']=1;
             
           $filename = $file->getFilename().'.'.$extension;;
           
             //$column = $request->input('cover_image') ? 'coverimage' : 'profileimage' ;
               }
             }
            
          $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get();   
             
             
          if($response['status']) {
              if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 'logo' => $document_application_name ]); 
              }
              
              if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               ['landingpageid' => $landing_page_id, 
                'tenantid' => $tenantid,
                 'logo'=> $document_application_name ]
           );
              }
             
              return response()->json(['success'=>true]);
            }
            
            
            
            
           
            return redirect()->back()->with($response);
        }
    }
    public function tenantprofileUpdate(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $telephone = $request->telephone;
        $facebooklink = $request->facebook;
        $linkedinlink = $request->linkedin;
        $twitterlink = $request->twitter;
        $address= $request->address;
        $city= $request->city;
        $postcode = $request->zip;
        $country = $request->country;
        $state = $request->state;
        $openhour = $request->openhour;

        // $headinglink1 = $request->first_heading_link;
        // $headinglink2 = $request->second_heading_link;
        $block_section_heading = $request->block_section_heading;
        $section_heading = $request->section_heading;
        $section_text = $request->section_text;
        $section_button_text = $request->section_button_text;
        $section_button_link = $request->section_button_link;
        
        $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get(); 
        if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               ['telephone' => $telephone, 
                'address' => $address,
                'open_hours'=> $openhour,
                'block_section_heading' => $block_section_heading,
                'section_heading' => $section_heading,
                'section_text' => $section_text,
                'section_button_text' => $section_button_text,
                'section_button_link' => $section_button_link,
                'facebook' => $facebooklink,  
                'twitter' => $twitterlink,
                'linkedin' => $linkedinlink,
                'landingpageid' => $landing_page_id,
                'tenantid' => $tenantid   
                ]
                );
              }
              
           if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 'telephone' => $telephone, 
                'address' => $address,
                'open_hours'=> $openhour,
                'block_section_heading' => $block_section_heading,
                'section_heading' => $section_heading,
                'section_text' => $section_text,
                'section_button_text' => $section_button_text,
                'section_button_link' => $section_button_link,
                'facebook' => $facebooklink,  
                'twitter' => $twitterlink,
                'linkedin' => $linkedinlink, 
                    ]); 
              }   
         return redirect()->to('/edit-landing-page');      
        
    }
    
    
    //new method
    
     public function tenantBlockHeadingUpdate(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $telephone = $request->telephone;
        $facebooklink = $request->facebook;
        $linkedinlink = $request->linkedin;
        $twitterlink = $request->twitter;
        $address= $request->address;
        $city= $request->city;
        $postcode = $request->zip;
        $country = $request->country;
        $state = $request->state;
        $openhour = $request->openhour;

        // $headinglink1 = $request->first_heading_link;
        // $headinglink2 = $request->second_heading_link;
        $block_section_heading = $request->block_section_heading;
        $section_heading = $request->section_heading;
        $section_text = $request->section_text;
        $section_button_text = $request->section_button_text;
        $section_button_link = $request->section_button_link;
        
        $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get(); 
        if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               [
                'block_section_heading' => $block_section_heading,

                'landingpageid' => $landing_page_id,
                'tenantid' => $tenantid   
                ]
                );
              }
              
           if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 
                'block_section_heading' => $block_section_heading,
               
                    ]); 
              }   
         return redirect()->to('/edit-landing-page');      
        
    }
    
   //updating about us 
     public function tenantAboutUs(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $telephone = $request->telephone;
        $facebooklink = $request->facebook;
        $linkedinlink = $request->linkedin;
        $twitterlink = $request->twitter;
        $address= $request->address;
        $city= $request->city;
        $postcode = $request->zip;
        $country = $request->country;
        $state = $request->state;
        $openhour = $request->openhour;

        // $headinglink1 = $request->first_heading_link;
        // $headinglink2 = $request->second_heading_link;
        $block_section_heading = $request->block_section_heading;
        $section_heading = $request->section_heading;
        
        $section_text = $request->ckeditor1;
        $section_button_text = $request->section_button_text;
        $section_button_link = $request->section_button_link;
        
        $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get(); 
        if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               [
                'section_heading' => $section_heading,
                'section_text' => $section_text,
                'section_button_text' => $section_button_text,
                'section_button_link' => $section_button_link,

                'landingpageid' => $landing_page_id,
                'tenantid' => $tenantid   
                ]
                );
              }
              
           if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 
                'section_heading' => $section_heading,
                'section_text' => $section_text,
                'section_button_text' => $section_button_text,
                'section_button_link' => $section_button_link,
               
                    ]); 
              }   
         return redirect()->to('/edit-landing-page');      
        
    }
    
    
    
    
  //  
    
    
    //updating about us 
     public function tenantTestimonial(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
//        $telephone = $request->telephone;
//        $facebooklink = $request->facebook;
//        $linkedinlink = $request->linkedin;
//        $twitterlink = $request->twitter;
//        $address= $request->address;
//        $city= $request->city;
//        $postcode = $request->zip;
//        $country = $request->country;
//        $state = $request->state;
//        $openhour = $request->openhour;
//
//        // $headinglink1 = $request->first_heading_link;
//        // $headinglink2 = $request->second_heading_link;
//        $block_section_heading = $request->block_section_heading;
//        $section_heading = $request->section_heading;
//        $section_text = $request->section_text;
//        $section_button_text = $request->section_button_text;
//        $section_button_link = $request->section_button_link;
        
        $testimonial=$request->testimonial;
        $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get(); 
        if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               [
                'testimonial' => $testimonial,
                

                'landingpageid' => $landing_page_id,
                'tenantid' => $tenantid   
                ]
                );
              }
              
           if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 
                'testimonial' => $testimonial,
               
               
                    ]); 
              }   
         return redirect()->to('/edit-landing-page');      
        
    }
    
    
    
    
  //  
    
    
    
    
 //updating about us 
     public function tenantFaq(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
//        $telephone = $request->telephone;
//        $facebooklink = $request->facebook;
//        $linkedinlink = $request->linkedin;
//        $twitterlink = $request->twitter;
//        $address= $request->address;
//        $city= $request->city;
//        $postcode = $request->zip;
//        $country = $request->country;
//        $state = $request->state;
//        $openhour = $request->openhour;
//
//        // $headinglink1 = $request->first_heading_link;
//        // $headinglink2 = $request->second_heading_link;
//        $block_section_heading = $request->block_section_heading;
//        $section_heading = $request->section_heading;
//        $section_text = $request->section_text;
//        $section_button_text = $request->section_button_text;
//        $section_button_link = $request->section_button_link;
        
        $faq=$request->faq;
        
        $users = DB::table('tenants_landingpage')
                     ->select(DB::raw('count(*) as tenantcount'))
                     ->where('tenantid', '=', session('tenantid'))
                     ->get(); 
        if($users[0]->tenantcount == 0)
              {
               $landing_page_id=$helper->fnGetUniqueID('6','tenants_landingpage','landingpageid');
               $tenantid=session('tenantid');
                DB::table('tenants_landingpage')->insert(
               [
                'faq' => $faq,
               
                'landingpageid' => $landing_page_id,
                'tenantid' => $tenantid   
                ]
                );
              }
              
           if($users[0]->tenantcount > 0)
              {
                DB::table('tenants_landingpage')
                     ->where('tenantid',session('tenantid'))
                     ->update([ 
                'faq' => $faq,
                
               
                    ]); 
              }   
         return redirect()->to('/edit-landing-page');      
        
    }
    
    
    
    
  //     
    
    
    
    
    
    public function blockheader(Request $request)
    {
        $block_header = DB::table('tenants_landingpage_blocks')
                     ->select('title','description','link','blockid','blockimage')
                     ->where('tenantid', '=', $request->tenantid)
                     ->get(); 
        
         $view=View::make('tenants._landing_page_block')->with('data',$block_header)->render();
//         //$view=View::make('tenants._landing_page_block')->render();
         return response()->json(['view'=>$view]);
       // return $request->tenantid;
    }
    
    public function faq(Request $request)
    {
        $block_header = DB::table('tenants_landingpage_faqs')
                     ->select('question','answer','faqid')
                     ->where('tenantid', '=', $request->tenantid)
                     ->get(); 
        
         $view=View::make('tenants._faq_block')->with('data',$block_header)->render();
//         //$view=View::make('tenants._landing_page_block')->render();
         return response()->json(['view'=>$view]);
       // return $request->tenantid;
    }
    
    public function slides(Request $request)
    {
        $block_header = DB::table('tenants_landingpage_slides')
                     ->select('slideid','title','description','button_text','button_link','image')
                     ->where('tenantid', '=', $request->tenantid)
                     ->get(); 
        
         $view=View::make('tenants._slides_block')->with('data',$block_header)->render();
//         //$view=View::make('tenants._landing_page_block')->render();
         return response()->json(['view'=>$view]);
       // return $request->tenantid;
    }
    
       public function testimonial(Request $request)
    {
        $block_header = DB::table('tenants_landingpage_testimonials')
                     ->select('name','companyandrank','image','description_text','testimonialid')
                     ->where('tenantid', '=', $request->tenantid)
                     ->get(); 
        
         $view=View::make('tenants._testimonials_block')->with('data',$block_header)->render();
//         //$view=View::make('tenants._landing_page_block')->render();
         return response()->json(['view'=>$view]);
       // return $request->tenantid;
    } 
    
       public function search(Request $request)
    {
           $res="";
            $searchtext=$request->search;
             $tenantid=$request->tenantid; 
           $sortby=$request->sort;
           if($request->searching == 'blockheader')
           {
             
          $block_header = DB::table('tenants_landingpage_blocks');
          $block_header->where(function ($query) use ($tenantid) {
                  $query->where('tenantid', '=', $tenantid); 
             });
             
             if(isset($searchtext) && !empty($searchtext))
   {
             $block_header->where(function ($query ) use ($searchtext)
             {
         
         $query->where('title','like','%'.$searchtext.'%')
                     ->orwhere('description','like','%'.$searchtext.'%')
                     ->orwhere('link','like','%'.$searchtext.'%');
         
         
        
             });
   }
   
   
   if(isset($sortby) && !empty($sortby))
       {
           switch ($sortby) {
               case 'title':
               $block_header->orderBy('title');
                   break;
               
               case 'description':
               $block_header->orderBy('description');
                   break;
               
               case 'link':
               $block_header->orderBy('link');
                   break;
               
               default:
                   
                   break;
           }
           
       }
   
             
             
       $block_header = $block_header->select('title','description','link','blockid')->get();   
               
          
          
        
         $view=View::make('tenants._landing_page_block')->with('data',$block_header)->render();

         $res = response()->json(['view'=>$view]);
      
           }
           
           if($request->searching == 'faq')
           {
             
          $block_header = DB::table('tenants_landingpage_faqs');
          $block_header->where(function ($query) use ($tenantid) {
                  $query->where('tenantid', '=', $tenantid); 
             });
             
             if(isset($searchtext) && !empty($searchtext))
   {
             $block_header->where(function ($query ) use ($searchtext)
             {
         
         $query->where('question','like','%'.$searchtext.'%')
                     ->orwhere('answer','like','%'.$searchtext.'%');
                     
         
         
        
             });
   }
   
   
   if(isset($sortby) && !empty($sortby))
       {
           switch ($sortby) {
               case 'question':
               $block_header->orderBy('question');
                   break;
               
               case 'answer':
               $block_header->orderBy('answer');
                   break;
               
               
               
               default:
                   
                   break;
           }
           
       }
   
             
             
       $block_header = $block_header->select('question','answer','faqid')->get();   
               
          
          
        
         $view=View::make('tenants._faq_block')->with('data',$block_header)->render();

         $res = response()->json(['view'=>$view]);
      
           }
           
             if($request->searching == 'slide')
           {
             
          $block_header = DB::table('tenants_landingpage_slides');
          $block_header->where(function ($query) use ($tenantid) {
                  $query->where('tenantid', '=', $tenantid); 
             });
             
             if(isset($searchtext) && !empty($searchtext))
   {
             $block_header->where(function ($query ) use ($searchtext)
             {
         
         $query->where('title','like','%'.$searchtext.'%')
                     ->orwhere('description','like','%'.$searchtext.'%')
                     ->orwhere('button_text','like','%'.$searchtext.'%');
                     
         
         
        
             });
   }
   
   
   if(isset($sortby) && !empty($sortby))
       {
           switch ($sortby) {
               case 'title':
               $block_header->orderBy('title');
                   break;
               
               case 'description':
               $block_header->orderBy('description');
                   break;
               
               case 'button_text':
               $block_header->orderBy('button_text');
                   break;
               
               
               
               default:
                   
                   break;
           }
           
       }
   
             
             
       $block_header = $block_header->select('title','description','button_text','button_link','image','slideid')->get();   
               
          
          
        
         $view=View::make('tenants._slides_block')->with('data',$block_header)->render();

         $res = response()->json(['view'=>$view]);
      
           }
           
             if($request->searching == 'testimonial')
           {
             
          $block_header = DB::table('tenants_landingpage_testimonials');
          $block_header->where(function ($query) use ($tenantid) {
                  $query->where('tenantid', '=', $tenantid); 
             });
             
             if(isset($searchtext) && !empty($searchtext))
   {
             $block_header->where(function ($query ) use ($searchtext)
             {
         
         $query->where('name','like','%'.$searchtext.'%')
                     ->orwhere('companyandrank','like','%'.$searchtext.'%')
                     ->orwhere('description_text','like','%'.$searchtext.'%');
                     
         
         
        
             });
   }
   
   
   if(isset($sortby) && !empty($sortby))
       {
           switch ($sortby) {
               case 'name':
               $block_header->orderBy('name');
                   break;
               
               case 'companyandrank':
               $block_header->orderBy('companyandrank');
                   break;
               
               case 'description_text':
               $block_header->orderBy('description_text');
                   break;
               
               
               
               default:
                   
                   break;
           }
           
       }
   
             
             
       $block_header = $block_header->select('name','companyandrank','description_text','image','testimonialid')->get();   
               
          
          
        
         $view=View::make('tenants._testimonials_block')->with('data',$block_header)->render();

         $res = response()->json(['view'=>$view]);
      
           }
           
           return $res;
       
    } 
    
    public function commonform(Request $request)
    {
        $filter=$request->filter;
        $view=View::make('tenants._create_new')->with('data',$filter)->render();
        $res = response()->json(['view'=>$view]);
        return $res;
    }
    
     public function commonupdateform(Request $request)
    {
        $filter=$request->filter;
        $id=$request->updateid;
        
        if($filter=="block_header")
        {
        $formdata=DB::table('tenants_landingpage_blocks')->where('blockid', $id)->select('blockid','title','description','link')->first();
        $view=View::make('tenants._create_update')->with('data',$filter)->with('formdata',$formdata)->render();
        $res = response()->json(['view'=>$view]);
        return $res;
        }
        
        if($filter=="faq")
        {
        $formdata=DB::table('tenants_landingpage_faqs')->where('faqid', $id)->select('faqid','question','answer')->first();
        $view=View::make('tenants._create_update')->with('data',$filter)->with('formdata',$formdata)->render();
        
        $res = response()->json(['view'=>$view]);
        return $res;
        }
        if($filter=="slide")
        {
        $formdata=DB::table('tenants_landingpage_slides')->where('slideid', $id)->select('slideid','title','description','button_text','button_link','image')->first();
        $view=View::make('tenants._create_update')->with('data',$filter)->with('formdata',$formdata)->render();
        $res = response()->json(['view'=>$view]);
        return $res;
        }
        if($filter=="testimonial")
        {
        $formdata=DB::table('tenants_landingpage_testimonials')->where('testimonialid', $id)->select('testimonialid','name','companyandrank','image','description_text')->first();
        $view=View::make('tenants._create_update')->with('data',$filter)->with('formdata',$formdata)->render();
        $res = response()->json(['view'=>$view]);
        return $res;
        }
      
        
    }
    
    
    public function savepopupform(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        
        $tenantid=session('tenantid');
        
        $getview = $request->getview;
        if($getview=='block')
        {
        $blockid=$helper->fnGetUniqueID('16','tenants_landingpage_blocks','blockid');
        $title = $request->title;
        $description = $request->description;
        $link =$request->link;
        
        $file = $request->file('uploadFiles');
        
        $name="";
        if(isset( $file) && !empty($file))
        {
            $name = $file->getClientOriginalName();
           
            $file->move(public_path().'/storage/tenant/block/', $name);
          
              
            
        }       
        
        if(isset($title) && !empty($title) && isset($description) && !empty($description) && isset($link) && !empty($link))
        {
             DB::table('tenants_landingpage_blocks')->insert(
               ['title' => $title, 
                'description' => $description,
                'link'=> $link,
                'tenantid' => $tenantid,
                'blockid' => $blockid, 
                'blockimage'=>$name,   
                ]
                );
        }
    }
    
        if($getview=='faq')
        {
        $question = $request->question;
        $answer = $request->answer;
        $faqid=$helper->fnGetUniqueID('16','tenants_landingpage_faqs','faqid');
        if(isset($question) && !empty($question) && isset($answer) && !empty($answer))
        {
             DB::table('tenants_landingpage_faqs')->insert(
               ['question' => $question, 
                'answer' => $answer,
                'tenantid' => $tenantid,
                'faqid' => $faqid,   
                ]
                );
        }
    }       
    
    
    }
    public function saveslide(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $tenantid=session('tenantid');
        $slideid=$helper->fnGetUniqueID('16','tenants_landingpage_slides','slideid');
        $title=$request->title;
        $description=$request->description;
        $buttontext=$request->buttontext;
        $buttonlink=$request->buttonlink;
        //fileupload
        $target_dir = "storage/tenant/slides/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $filename=$_FILES["fileToUpload"]["name"];
        //
        if(isset($title) && !empty($title))
        {
             DB::table('tenants_landingpage_slides')->insert(
               ['title' => $title, 
                'description' => $description,
                'tenantid' => $tenantid,
                'slideid' => $slideid, 
                'button_text'=> $buttontext,
                'button_link'=> $buttonlink,
                'image'=>$filename,   
                ]
                );
        }
        return redirect('/edit-landing-page?goto=slide');
        
    }
    
     public function slideupdate(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        //$tenantid=session('tenantid');
        $slideid=$request->slideid;
        $title=$request->title;
        $description=$request->description;
        $buttontext=$request->buttontext;
        $buttonlink=$request->buttonlink;
        //fileupload
        $target_dir = "storage/tenant/slides/";
        
        if(isset($_FILES["fileToUpload"]["name"]) && !empty($_FILES["fileToUpload"]["name"]))
        {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
        $filename=$_FILES["fileToUpload"]["name"];
        
        DB::table('tenants_landingpage_slides')
            ->where('slideid', '=', $slideid )
            ->update([
              'title' => $title, 
                'description' => $description,
              
                'slideid' => $slideid, 
                'button_text'=> $buttontext,
                'button_link'=> $buttonlink,
                'image'=>$filename,
               
             ]);
        
        }
        else
        {
        //
        
           DB::table('tenants_landingpage_slides')
            ->where('slideid', '=', $slideid )
            ->update([
              'title' => $title, 
                'description' => $description,
             
                'slideid' => $slideid, 
                'button_text'=> $buttontext,
                'button_link'=> $buttonlink,
                
               
             ]);
            
            
            
             
        
        }
        return redirect('/edit-landing-page?goto=slide');
        
    }
    
     public function savetestimonial(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $tenantid=session('tenantid');
        $testid=$helper->fnGetUniqueID('16','tenants_landingpage_testimonials','testimonialid');
        $name=$request->name;
        $description=$request->description;
        $companyank=$request->companyrank;
        
        //fileupload
        $target_dir = "storage/tenant/testimonials/";
        $target_file = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
        move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file);
        $filename1=$_FILES["fileToUpload1"]["name"];
        //
        if(isset($name) && !empty($name) && isset($description) && !empty($description)&& isset($companyank) && !empty($companyank))
        {
            
            
             DB::table('tenants_landingpage_testimonials')->insert(
               ['name' => $name, 
                'description_text' => $description,
                'tenantid' => $tenantid,
                'testimonialid' => $testid, 
                'companyandrank'=> $companyank,
                
                'image'=>$filename1,   
                ]
                );
        }
        return redirect('/edit-landing-page?goto=testimonial');
        
    }
    
    
     public function testimonialupdate(Request $request)
    {
       
        $testid=$request->testimonialid;
        $name=$request->name;
        $description=$request->description;
        $companyank=$request->companyrank;
        
        //fileupload
        $target_dir = "storage/tenant/testimonials/";
        $target_file = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
        if(isset($_FILES["fileToUpload1"]["name"]) && !empty($_FILES["fileToUpload1"]["name"]))
        {   
        move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file);
        $filename1=$_FILES["fileToUpload1"]["name"];
        
        DB::table('tenants_landingpage_testimonials')
            ->where('testimonialid', '=', $testid )
            ->update([
              'name' => $name, 
                'description_text' => $description,
               
               
                'companyandrank'=> $companyank,
                
                'image'=>$filename1, 
                
               
             ]);
        
        
        //
        }
        else
        {
        
            
            
              DB::table('tenants_landingpage_testimonials')
            ->where('testimonialid', '=', $testid )
            ->update([
              'name' => $name, 
                'description_text' => $description,
               
               
                'companyandrank'=> $companyank,
                
               
                
               
             ]);
        
        }
        
        return redirect('/edit-landing-page?goto=testimonial');
        
    }
    
    
    
    public function updatepopupform(Request $request)
    {
       
       
        if($request->getview=="block")
        {
            $title=$request->title;
            $description=$request->description;
            $link=$request->link;
            $updateid=$request->update;
            
            $file = $request->file('uploadFiles');
        
            $name="";
            if(isset( $file) && !empty($file))
            {
            $name = $file->getClientOriginalName();
           
            $file->move(public_path().'/storage/tenant/block/', $name);
          
              
            
           }  
            
            
             if(isset( $file) && !empty($file))
             {
            DB::table('tenants_landingpage_blocks')
            ->where('blockid', '=', $updateid )
            ->update([
              'title' => $title, 
                'description' => $description,
               
               
                'link'=> $link,
                'blockimage'=>$name,
                
               
                
               
             ]);
             }
          if(!isset( $file) || empty($file))
             {
            DB::table('tenants_landingpage_blocks')
            ->where('blockid', '=', $updateid )
            ->update([
              'title' => $title, 
                'description' => $description,
               
               
                'link'=> $link,
              
                
               
                
               
             ]);
             }
            
           
        }
        
        if($request->getview=="faq")
        {
            $question=$request->question;
            $answer=$request->answer;
           
            $updateid=$request->update;
            
            DB::table('tenants_landingpage_faqs')
            ->where('faqid', '=', $updateid )
            ->update([
              'question' => $question, 
                'answer' => $answer,
               
               
              
                
               
                
               
             ]);
            
            
        }
        
        
        
    }
    
    
    
    
    
    
    
    public function deletetenantlayout(Request $request)
    {
        
        if($request->type=="block")
        {
        $delid=$request->delid;
        DB::table('tenants_landingpage_blocks')->where('blockid', $delid)->delete();
        }
         if($request->type=="slide")
        {
        $delid=$request->delid;
        DB::table('tenants_landingpage_slides')->where('slideid', $delid)->delete();
        }
         if($request->type=="faq")
        {
        $delid=$request->delid;
        DB::table('tenants_landingpage_faqs')->where('faqid', $delid)->delete();
        }
         if($request->type=="testimonial")
        {
        $delid=$request->delid;
        DB::table('tenants_landingpage_testimonials')->where('testimonialid', $delid)->delete();
        }
        
        
    }


    public function getTenantProfileCompleteness()
    {
       return 50;
    }
    public function getTenantDashboardData($tenantid)
    {
          $companycompleteprofile=$this->getTenantProfileCompleteness();
          $pipelinedeals_New=pipelinedeal::with('dd_modules')
                     ->where('tenantid',session('tenantid'))
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
                     ->orderby('updated','desc')
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
   
  
                    $pipelinefolders=DB::table('pipelinefolders')->where('tenantid', session('tenantid'))->get();   
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
                    
                   
                  
                //   $enterprise_company_id =  DB::table('companytypes')
                //                     ->select('companytypeid')
                //                     ->where('companytype', 'Enterprises')
                //                     ->first()->companytypeid;                                   
  
                //   $companies = DB::table('pipelinedeals')
                //                     ->select('dealid','companyid')
                //                     ->where('companyid', '!=' ,session('companyid'))
                //                     ->get()->toArray(); 
  
                  
                //   foreach ($companies as $company) {
                //      foreach ($sector_ids as $sector_id) {
                //          foreach ($sector_id as $sectorid) {
                //          $compid = DB::table('companysectors')
                //                                 ->select('companyid')
                //                                 ->where('companyid',$company->companyid)
                //                                 ->where('sectorid',$sectorid)
                //                                 ->first();
                //          if($compid != null) {
                //         $final_company = DB::table('company')
                //                         ->select('companyid')
                //                         ->where('companyid', $compid->companyid )
                //                         ->where('companytypeid', $enterprise_company_id )
                //                         ->first(); 
                //             if($final_company != null) {
                //             $final_deals[] = DB::table('deals')
                //                               ->select('dealid','proposedusesoffunds')
                //                               ->where('companyid',$final_company->companyid)
                //                               ->first();   
                //             }                     
                //         }
                                                         
                //       }
                    
                //     }
  
                //   }
                   
                  $data = [ 
                             'completepercentage'=>$companycompleteprofile,
                             'pipelinedeals' => $pipelinedeals_New,
                             'deals_sdgs'=>$deals_sdgs,
                             'pipelinefolders'=>$pipelinefolders,
                             'All_Associated_company'=>$All_Associated_company,
                             'parent_pipelinedeal_data'=>$parent_pipelinedeal_data,
                             'modulequestionstatus'=>$modulequestionstatus
                          ]; 
                  
                  
                  
                  return $data;
    
    }
    
    
    public function tenant_profile_edit()
    {
        $tenantid=session('tenantid');  
        $tenant=DB::table('tenants as t')
                ->join('users as u','u.userid','t.userid')
                ->where('t.tenantid',$tenantid)
               
                ->select('t.tenantid','t.company','t.firstname','t.lastname','u.email','t.phone','t.mobile','t.address1','t.address2','t.city','t.state','t.country','t.postcode','t.logo','t.cover','t.profileimage','t.username','u.userpassword as password','t.companyemail','t.address1 as address','t.cardnumber','t.cardname','t.cvv','t.expiry','t.postcode','t.country','t.city','t.state','t.minilogo','t.from_name','t.from_email','t.contact_us_link','t.privacy_policy_link','t.primarycolor','t.secondarycolor','t.platformname')
                ->first();
        
         $country=DB::select( DB::raw("select countryid,name from country"));
         $selectcountry=DB::table('country')
                     ->where('countryid',$tenant->country)->select('name as countryname')->first();
         $selectstate=DB::table('state')
                     ->where('stateid',$tenant->state)->select('name as statename')->first();
         $selectcity=DB::table('city')
                   ->where('id',$tenant->city)->select('name as cityname')->first();
        
         $tenantcolors=DB::table('tenant_color_table')->get();
         
         $primarylanguagetodisplay = DB::table('ltm_translations')
        ->groupBy('locale')
        ->select('locale')
        ->get();
        
         
         
        
        $secondarylanguagetodisplay = DB::table('ltm_translations')
        ->groupBy('locale')
        ->select('locale')
        ->get();
         
         $primaryinput=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=',1)->get();
         $secondaryinput=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=',0)->get();
        
        return view('tenants.tenant_edit', compact('tenant','country','selectcountry','selectstate','selectcity','tenantcolors','primarylanguagetodisplay','secondarylanguagetodisplay','primaryinput','secondaryinput'));
         
         
//        return view('tenants.tenant_edit', compact('tenant','country','selectcountry','selectstate','selectcity'));
        
    }
    public function update_tenant(Request $request)
    {
        $tenantid=session('tenantid');

        $tobj=DB::table('tenants')->where('tenantid',$tenantid)->first();
        $userid=$tobj->userid;
		
		$primarycolor=$request->primary_combo;
        $secondarycolor=$request->secondary_combo;
        if(!isset($primarycolor) || $primarycolor=="")
        $primarycolor="";

        if(!isset($secondarycolor) || $secondarycolor=="")
        $secondarycolor="";
        // 'username'=>$request->username,
        if(isset($tenantid) && isset($userid))
        {
            DB::table('tenants')
            ->where('tenantid',$tenantid)        
            ->update([
                'firstname'=>$request->firstname,
                'lastname'=>$request->lastname,
                'email'=>$request->email,
                'password'=>$request->password,
                'primarycolor'=>$primarycolor,
                'secondarycolor'=>$secondarycolor,
                'platformname'=>$request->platform,
                ]);  
                
                DB::table('users')
                  ->where('tenantid',$tenantid)
                  ->where('userid',$userid)
                  ->where('is_tenant',1)
                  ->update([
                      'email'=>$request->email,
                      'userpassword'=>$request->password,
                      'password'=>bcrypt($request->password),
                  ]);
				  
				  session(['tenant_primary_color'=>$primarycolor]);
                  session(['tenant_secondary_color'=>$secondarycolor]);
    
        }
        
       


       return  redirect()->back();
        
    }
    
     public function update_tenant_company(Request $request)
    {
        $tenantid=session('tenantid');
        
       DB::table('tenants')
        ->where('tenantid',$tenantid)        
        ->update([
            'company'=>$request->companyname,
            'phone'=>$request->telephone,
            'address1'=>$request->address,
            'city'=>$request->companycity,
            'companyemail'=>$request->companyemail,
            'postcode'=>$request->companypostcode,
            'state'=>$request->companystate,
//            'postcode'=>$request->companypostcode,
//            'cardname'=>$request->cardname,
//            'cardnumber'=>$request->cardnumber,
//            'expiry'=>$request->cardexpiry,
//            'cvv'=>$request->cardcode,
            'country'=>$request->companycountry,
          
            ]);        
       return  redirect()->back();
        
    }
    
    
      public function update_tenant_card(Request $request)
    {
        $tenantid=session('tenantid');
        try
        {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $response = \Stripe\Token::create(array(
                       "card" => array(
                           "number"    => $request->cardnumber,
                           "exp_month" => str_before($request->cardexpiry, '/'),
                           "exp_year"  => str_after($request->cardexpiry, '/'),
                           "cvc"       => $request->cardcode,
                           "name"      => $request->cardname
                       )
                   ));
                 //$response_array = $response->__toArray(true);
           $stripeToken = $response['id'];
           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           $tenant->updateCard($stripeToken);
        }
        catch(\Stripe\Error\ApiConnection $e)
        {
           return back()->with("status", "Api connection error"); 
        }
        catch(\Stripe\Error\Card $e) {
           return back()->with("status", "card information not valid");     
        }
       
        DB::table('tenants')
        ->where('tenantid',$tenantid)        
        ->update([
            'cardname'=>$request->cardname,
            'cardnumber'=>$request->cardnumber,
            'expiry'=>$request->cardexpiry,
            'cvv'=>$request->cardcode,
         ]);
        return back()->with("status", "card information saved successfully");
     
    
        
       
         
       
//       return  redirect()->back();
        
    }
    
    
    
    public function savelogoimage(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $response['status'] = 0 ; 
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $original_filename = $file->getClientOriginalName();
        $filename = $file->getFilename().'.'.$extension;
        $document_application_name=$helper->fnGetUniqueID('5','tenants','logo');
        $document_application_name = $document_application_name.'.'.$extension;
        $uploadDir = 'storage';
        $tmpFile = $_FILES['file']['tmp_name']; 
        $filename = $uploadDir.'/tenant/logoimage/'. $document_application_name;
        if(move_uploaded_file($tmpFile,$filename))
        {
        $response['status']=1;
        $filename = $file->getFilename().'.'.$extension;;
        }
        if($response['status']) {
        DB::table('tenants')
       ->where('tenantid',session('tenantid'))
       ->update(['logo' => $document_application_name ]); 
                      
       return response()->json(['success'=>true]);
        }
                   
       return redirect()->back()->with($response);
    }


    public function saveminilogoimage(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $response['status'] = 0 ; 
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $original_filename = $file->getClientOriginalName();
        $filename = $file->getFilename().'.'.$extension;
        $document_application_name=$helper->fnGetUniqueID('5','tenants','minilogo');
        $document_application_name = $document_application_name.'.'.$extension;
        $uploadDir = 'storage';
        $tmpFile = $_FILES['file']['tmp_name']; 
        $filename = $uploadDir.'/tenant/minilogoimage/'. $document_application_name;
        if(move_uploaded_file($tmpFile,$filename))
        {
        $response['status']=1;
        $filename = $file->getFilename().'.'.$extension;;
        }
        if($response['status']) {
        DB::table('tenants')
       ->where('tenantid',session('tenantid'))
       ->update(['minilogo' => $document_application_name ]); 
                      
       return response()->json(['success'=>true]);
       return redirect()->back()->with($response);
        }
                   
       return redirect()->back()->with($response);
    }
    
    
      public function savecoverimage(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $response['status'] = 0 ; 
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $original_filename = $file->getClientOriginalName();
        $filename = $file->getFilename().'.'.$extension;
        $document_application_name=$helper->fnGetUniqueID('5','tenants','cover');
        $document_application_name = $document_application_name.'.'.$extension;
        $uploadDir = 'storage';
        $tmpFile = $_FILES['file']['tmp_name']; 
        $filename = $uploadDir.'/tenant/coverimage/'. $document_application_name;
        if(move_uploaded_file($tmpFile,$filename))
        {
        $response['status']=1;
        $filename = $file->getFilename().'.'.$extension;;
        }
        if($response['status']) {
        DB::table('tenants')
       ->where('tenantid',session('tenantid'))
       ->update(['cover' => $document_application_name ]); 
                      
       return response()->json(['success'=>true]);
        }
                   
       return redirect()->back()->with($response);
    }
    
    
     public function saveprofileimage(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $response['status'] = 0 ; 
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $original_filename = $file->getClientOriginalName();
        $filename = $file->getFilename().'.'.$extension;
        $document_application_name=$helper->fnGetUniqueID('5','tenants','profileimage');
        $document_application_name = $document_application_name.'.'.$extension;
        $uploadDir = 'storage';
        $tmpFile = $_FILES['file']['tmp_name']; 
        $filename = $uploadDir.'/tenant/profileimage/'. $document_application_name;
        if(move_uploaded_file($tmpFile,$filename))
        {
        $response['status']=1;
        $filename = $file->getFilename().'.'.$extension;;
        }
        if($response['status']) {
        DB::table('tenants')
       ->where('tenantid',session('tenantid'))
       ->update(['profileimage' => $document_application_name ]); 
                      
       return response()->json(['success'=>true]);
        }
                   
       return redirect()->back()->with($response);
    }


    public function openrequestpage()
    {
        return view('tenants.Requests.requests');
    }


    public function get_company_requests(Request $request)
    {
        $searchtext=$request->searchtext;
        $sortby=$request->sortby;

        $userid=Session('userid');
        $companyid=Session('companyid');


          $query = DB::table('company as c')
            ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
            ->where('c.companystatus','Unverified')
            ->Where('c.tenantid',session('tenantid'));
          
          if(isset($searchtext) && !empty($searchtext))
          {
           $query->where(function ($query ) use ($searchtext)
                    {
                     $query->Where('c.name','like', '%' . $searchtext . '%')
                      ->orWhere('c.statusmessage','like', '%' . $searchtext . '%');
                      
                    });
          }

          if(isset($sortby) && !empty($sortby))
          {
              switch ($sortby) {
                  case 'name':
                  $query->orderBy('c.name');
                      break;
                      case 'type':
                      $query->orderBy('ct.companytype');
                          break;
                  default:
                      
                      break;
              }
              
          }
     
          $company=$query->select('c.companyid','c.name as companyname','c.profileimage','c.impactinfo_info as sectors','numbertodate as scount','ct.companytype')->get();

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
      


          $view=View::make('tenants.Requests._company_list',compact('company'))->render();
                 
          return $view;
    }


    public function get_company_previous_requests(Request $request)
    {
        $searchtext=$request->searchtext;
        $sortby=$request->sortby;

        $userid=Session('userid');
        $companyid=Session('companyid');


          $query = DB::table('request_history as c')
          ->leftjoin('company as oc','oc.companyid','c.entityid')
            ->where('c.type','Company')
            ->Where('c.tenantid',session('tenantid'));
          
          if(isset($searchtext) && !empty($searchtext))
          {
           $query->where(function ($query ) use ($searchtext)
                    {
                     $query->Where('c.name','like', '%' . $searchtext . '%')
                      ->orWhere('c.email','like', '%' . $searchtext . '%');
                      
                    });
          }

          if(isset($sortby) && !empty($sortby))
          {
              switch ($sortby) {
                  case 'name':
                  $query->orderBy('c.name');
                      break;
                      case 'type':
                      $query->orderBy('c.companytype');
                          break;
                  default:
                      
                      break;
              }
              
          }
     
          $company=$query->select('c.entityid as companyid','c.name as companyname','oc.profileimage','c.email as email','c.companytype','c.status','c.datetime')->get();
          $view=View::make('tenants.Requests._company_request_history',compact('company'))->render();
                
          return $view;
    }


    public function Verify_Decline_Company_Requests(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $type=$request->type;
        $companyid=$request->companyid;
        $tenantid=session('tenantid');

        if(!isset($type) || !isset($companyid))
        {
            return response()->json(['message'=>'Failed']); 
        }
        $TemplateCode='';
        $companytype='';
        $companyname='';
        $company=DB::table('company as c')
                     ->join('companytypes as ct','ct.companytypeid','c.companytypeid')
                     ->where('c.companyid',$companyid)
                     ->select('ct.companytype','c.name')
                     ->first();

                     if(isset($company))
                     {
                        $companytype=$company->companytype;
                        $companyname=$company->name;
                     }

                     $company_email=$helper->GetCompanyAdminUserEmail($companyid);

        if($type=='Verify')
        {
           DB::update(DB::raw("Update company set companystatus='Verified',activestatus='Active' where companyid='$companyid'"));
           DB::update(DB::raw("Update usercompanies set recordstatus='Active' where companyid='$companyid' AND userrole=0"));
           DB::table('pipelinefolders')->insert(
             [
               'folderid'=>$helper->fnGetUniqueID(16, 'pipelinefolders', 'folderid') ,
               'companyid'=>$companyid,
               'tenantid'=>$tenantid,
               'foldername'=>'Default'
             ]);


             DB::table('request_history')->insert(
                [
                  'requestid'=>$helper->fnGetUniqueID(16, 'request_history', 'requestid') ,
                  'type'=>'Company',
                  'tenantid'=>$tenantid,
                  'entityid'=>$companyid,
                  'name'=>$companyname,
                  'companytype'=>$companytype,
                  'sectors'=>'',
                  'status'=>'Verified',
                  'email'=>$company_email
                ]);


           $TemplateCode=\App\Helpers\AppGlobal::$Company_Request_Accepted_TemplateCode;
        //    return response()->json(['message'=>'Success']); 
        }
        else if($type=='Decline')
        {
            $userid=DB::select(DB::raw("Select userid from usercompanies where companyid='$companyid' AND userrole=0"))[0]->userid;

            DB::table('request_history')->insert(
                [
                  'requestid'=>$helper->fnGetUniqueID(16, 'request_history', 'requestid') ,
                  'type'=>'Company',
                  'tenantid'=>$tenantid,
                  'entityid'=>$companyid,
                  'name'=>$companyname,
                  'companytype'=>$companytype,
                  'sectors'=>'',
                  'status'=>'Declined',
                  'email'=>$company_email
                ]);

            if(isset($userid) && !empty($userid))
            {
            DB::delete(DB::raw("Delete from usercompanies where companyid='$companyid' AND userrole=0"));
            DB::delete(DB::raw("Delete from companysectors where companyid='$companyid'"));
            DB::delete(DB::raw("Delete from users where userid='$userid'"));
            DB::delete(DB::raw("Delete from companyvisitors where companyid='$companyid'"));
            DB::delete(DB::raw("Delete from company where companyid='$companyid'"));
            $TemplateCode=\App\Helpers\AppGlobal::$Company_Request_Rejected_TemplateCode;
            // return response()->json(['message'=>'Success']); 
            }
            else
            {
                return response()->json(['message'=>'Failed']); 
            }
        }

        //Sending Email To Company Admin

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
               $MessageBody= str_replace("%%COMPANYTYPE%%",$companytype,$MessageBody); 

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
               
               if(isset($company_email))
               {
                 $helper->SendEmail($Template,$company_email,$Message_with_master);
               }
              
             }
           }


        }

        //End Of Sending Email Code....

        return response()->json(['message'=>'Success']);
    }
    
    public function viewaccount()
    {
       $tenantid=session('tenantid');
       $invoices="";
      
//       if(isset($tenantid) && !empty($tenantid))
//       {
//       $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
////       if($tenant->invoices()!=null)
////       //$invoices = $tenant->invoices();
////       
//      }  
       $tenantdetails=DB::table('tenants')
                      ->where('tenantid',$tenantid)
                      ->leftjoin('plans','plans.planid','tenants.planid')
                      ->select('username','cardnumber','email','firstname','lastname','password','planperiod','tenants.planid')
                      ->first();
       
       if($tenantdetails->planid!='e44af5cd68e4f6c7' && $tenantdetails->planid!=null)
       {
           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           $invoices = $tenant->invoices();
       }
       
       $cardnumber=(($tenantdetails->cardnumber));
       $cardnumberstr="";
       for($i=strlen($cardnumber)-2;$i<strlen($cardnumber);$i++)
       {
           $cardnumberstr=$cardnumberstr.$cardnumber[$i];
       }
       if($cardnumber==0)
       {
           $cardnumber="";
           $cardnumberstr="";
           
       }
       if(isset($tenantdetails->password) && !empty($tenantdetails->password))
       {
           $passwordlen=strlen($tenantdetails->password);
       }
        return view('tenants.account')->with('tenantdetails',$tenantdetails)->with('cardnumber',$cardnumberstr)->with('password',$passwordlen)->with('invoices',$invoices);
        
    }
    

    public function generatinginvoice(Request $request)
    {
        $tenantid=session('tenantid');
        $planname=DB::table('tenants')->leftjoin('plans','plans.planid','tenants.planid')->where('tenantid','=',$tenantid)->select('plans.plandname')->first();
        $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
        $invoiceId=$request->invoiceid;
        return $tenant->downloadInvoice($invoiceId, [
        'vendor'  => $tenant->company,
        'product' => $planname->plandname,
    ]);
        
        
    }
    public function changeplan(Request $request)
    {
     
     $planid="";
     $stripeplan="";
    
     if(isset($request->plan))
     {
         
         if($request->plan=="trial")
         {
             $tenantid=session('tenantid');
             $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
             $tenant->trial_ends_at = now()->addDays(90);
         
             DB::table('tenants')->where('tenantid','=',$tenantid)->update([
             'planid'=>'e44af5cd68e4f6c7',
             'trial_ends_at' => now()->addDays(90),    
             
         ]); 
         }
        
         if($request->plan=="Quarterly")
         {
         $stripeplan="plan_DOM7VlYtcg2ZKS";
         $tenantid=session('tenantid');
         $planid='e44af5cd68e4f6c8';
         
         DB::table('tenants')->where('tenantid','=',$tenantid)->update([
             'planid'=>$planid,
             
         ]); 
         $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
         \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
         if(empty($tenant->stripe_id))
         {
             $response = \Stripe\Token::create(array(
                       "card" => array(
                           "number"    => $tenant->cardnumber,
                           "exp_month" => str_before($tenant->expiry, '/'),
                           "exp_year"  => str_after($tenant->expiry, '/'),
                           "cvc"       => $tenant->cvv,
                           "name"      => $tenant->cardname
                       )
                   ));
                 //$response_array = $response->__toArray(true);
           $stripeToken = $response['id'];
           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           $tenant->newSubscription($stripeplan, $stripeplan)->create($stripeToken);
             
         }
         else
         {
            \Stripe\Subscription::create(array(
           "customer" => $tenant->stripe_id,
           "items" => array(
            array(
            "plan" => $stripeplan,
             ),
          )
         ));  
         }
          
         
         }
         if($request->plan=="Yearly")
         {
             $stripeplan="plan_DOM6xvkxNjwpD6";
             $tenantid=session('tenantid');
              $planid='e44af5cd68e4f6c9';
              DB::table('tenants')->where('tenantid','=',$tenantid)->update([
             'planid'=>$planid,
             
         ]); 
             
         $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
          if(empty($tenant->stripe_id))
         {
             $response = \Stripe\Token::create(array(
                       "card" => array(
                           "number"    => $tenant->cardnumber,
                           "exp_month" => str_before($tenant->expiry, '/'),
                           "exp_year"  => str_after($tenant->expiry, '/'),
                           "cvc"       => $tenant->cvv,
                           "name"      => $tenant->cardname
                       )
                   ));
                 //$response_array = $response->__toArray(true);
           $stripeToken = $response['id'];
           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           $tenant->newSubscription($stripeplan, $stripeplan)->create($stripeToken);
             
         }
           
           
           
else{
           \Stripe\Subscription::create(array(
  "customer" => $tenant->stripe_id,
  "items" => array(
    array(
      "plan" => $stripeplan,
    ),
  )
));
}          
              
         }
       

       
     }
        
    }
    
    public function profilecomplete(Request $request)
    {
        $tenantid=session('tenantid');
        if(isset($tenantid))
        {
        $tenant_languages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->first();
        }
        
        $primarylanguagetodisplay = DB::table('ltm_translations')
        ->groupBy('locale')
        ->select('locale')
        ->get();
        
        
        $secondarylanguagetodisplay = DB::table('ltm_translations')
        ->groupBy('locale')
        ->select('locale')
        ->get();
        
        
        $colortable=DB::table("tenant_color_table")->get(); 
        
        $tenantdetails=DB::table('tenants')->where('tenantid','=',$tenantid)->first();
        
        
        return view('tenants.profile_setup')->with('colortable',$colortable)->with('tenantdetails',$tenantdetails)->with('primarylanguagetodisplay',$primarylanguagetodisplay)->with('secondarylanguagetodisplay',$secondarylanguagetodisplay);
    }

    public function invoice(Request $request)
    {
          $tenantid=session('tenantid');
       $invoices="";
      
//       if(isset($tenantid) && !empty($tenantid))
//       {
//       $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
////       if($tenant->invoices()!=null)
////       //$invoices = $tenant->invoices();
////       
//      }  
       $tenantdetails=DB::table('tenants')
                      ->where('tenantid',$tenantid)
                      ->leftjoin('plans','plans.planid','tenants.planid')
                      ->select('username','cardnumber','email','firstname','lastname','password','planperiod','tenants.planid')
                      ->first();
       
       if($tenantdetails->planid!='e44af5cd68e4f6c7' && $tenantdetails->planid!=null)
       {
           $tenant=Tenant::where('tenantid', '=', $tenantid)->first();
           $invoices = $tenant->invoices();
       }
       
       
        return view('tenants.invoice')->with('invoices',$invoices);
        
        
        
    }
    
    public function paymentmethod(Request $request)
    {
        $tenantid=session('tenantid');
        $tenant="";
        if(isset($tenantid))
        {
        $tenant=DB::table('tenants')->where('tenantid',$tenantid)->first();
        }
        return view('tenants.payment_method')->with('tenant',$tenant);
    }
    
    public function subscriptionmethod(Request $request)
    {
          $tenantid=session('tenantid');
          
         
          $subscriptions="";
          $tenantplatformname="";
          if(isset($tenantid) && !empty($tenantid))
          {
              $subscriptions=DB::table('subscriptions as s')->where('s.tenant_tenantid','=',$tenantid)->where('s.subscription_active','=',1)->leftjoin('tenants as t','t.tenantid','s.tenant_tenantid')->leftjoin('users as u','u.userid','t.userid')->leftjoin('plans as p','p.stripeplanid','s.stripe_plan')->select('t.firstname as firstname','t.lastname as lastname','u.email as email','p.plandname as planname','p.planperiod as planperiod','s.trial_ends_at','s.renews_at','t.tenantid as tenantid')->get();
              //$tenantplatformname=DB::table('tenants')->where('tenantid','=',$tenantid)->select('platformname')->first()->platformname;
          }
          
          return view('tenants.subscription')->with('subscriptions',$subscriptions);
    }
    public function cancelmethod()
    {
        return view('tenants.accountcancellation');
    }
    public function cancelaccount(Request $request)
    {
        $tenantid=session('tenantid');
        $tenant=Tenant::where('tenantid','=',$tenantid)->first();
        
        $tenantcancel=0;
        if(isset($tenantid) && !empty($tenantid))
        {
         $subscription=DB::table('subscriptions')->where('tenant_tenantid','=',$tenantid)->first();
                  
         if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)){
              \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
              $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
              if($sub->cancel())
              {
              DB::table('subscriptions')->where('stripe_id','=',$subscription->stripe_id)->delete();
              
               
              $tenantcancel = 1;  
              }
              
         }
       
            
        }
        if($tenantcancel == 1)
        {
          
            
          return "Subscription removed successfully";   
        }
        else
        {
          return "Cannot find subscription";
        }
    }


    public function rechargemethod()
    {
        return view('tenants.accountrecharge');
    }
    
     public function rechargeaccount(Request $request)
    {
        $tenantid=session('tenantid');
        $tenant=Tenant::where('tenantid','=',$tenantid)->first();
        
        $tenantcancel=0;
        if(isset($tenantid) && !empty($tenantid))
        {
         $subscription=DB::table('subscriptions')->where('tenant_tenantid','=',$tenantid)->first();
                  
         if(isset($subscription->stripe_id) && !empty($subscription->stripe_id)){
              \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
             
              $sub = \Stripe\Subscription::retrieve($subscription->stripe_id);
              if($sub->save())
              {
              DB::table('subscriptions')->where('stripe_id','=',$subscription->stripe_id)->update([
                  'subscription_active'=>1,
              ]);
              
               
              $tenantcancel = 1;  
              }
              
         }
       
            
        }
        if($tenantcancel == 1)
        {
          
            
          return "Subscription recharged successfully";   
        }
        else
        {
          return "Cannot find subscription";
        }
    }


    public function update_tenant_email_settings(Request $request)
    {
        $tenantid=session('tenantid');
        $fromname=$request->from_name;
            $fromemail=$request->from_email;
            $contactuslink=$request->contact_us_link;
            $privacypolicylink=$request->privacy_policy_link;
            
         DB::table('tenants')
        ->where('tenantid',$tenantid)        
        ->update([
            'from_name'=>$fromname,
            'from_email'=>$fromemail,
            'contact_us_link'=>$contactuslink,
            'privacy_policy_link'=>$privacypolicylink,
            
          
            ]);        
       return  redirect()->back();
            
            
             
    }


    public function update_languages(Request $request)
    {
        $tenantid=session('tenantid');
          //code for saving primarylanguages and secondarylanguages
      
        $getprimarylanguage=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','1');
        
        if(!isset($getprimarylanguage))
        {
           
        }
        else
        {
            $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','1')->delete();
            
        }
       if(isset($request->primarylogin))
       {
        for($i=0;$i<count($request->primarylogin);$i++) 
           {
            $primarylanguage=DB::table('tenant_languages')->insert([
                'tenantid'=>$tenantid,
                'language'=>$request->primarylogin[$i],
                'is_primary'=>1
            ]);
           }
        
       }
       else
       {
          $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','1')->delete(); 
       }
        
      
        $getsecondarylanguage=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','0');
        
        if(!isset($getsecondarylanguage))
        {
           
        }
        else
        {
            $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','0')->delete();
            
        }
        if(isset($request->secondarylogin))
       {
        for($i=0;$i<count($request->secondarylogin);$i++) 
           {
            $primarylanguage=DB::table('tenant_languages')->insert([
                'tenantid'=>$tenantid,
                'language'=>$request->secondarylogin[$i],
                'is_primary'=>0
            ]);
           }
        
       }
       else
       {
           $deleteprimarylanguages=DB::table('tenant_languages')->where('tenantid','=',$tenantid)->where('is_primary','=','0')->delete();
       }
        
      return redirect('/tenant/profile/edit');  
    }


    public function getsecondaryvalues(Request $request)
    {
        $buildsecondary="";
       
        if(isset($request->multi))
        {
          $secondarylink=array($request->multi); 
          
          
            
        if ((strpos($request->multi, ',') !== false))
        {
         $secondarylink= explode(',',$request->multi);
         
        }          
        
       
         
        
        $getsecondary=DB::table('ltm_translations')
                
                ->groupBy('locale')
                ->whereNotIn('locale',$secondarylink)
                ->select('locale')
                ->get();
      
        
        foreach($getsecondary as $getsecondar)
        {
            $buildsecondary=$buildsecondary."<option value=".$getsecondar->locale.">".$getsecondar->locale."</option>";
        }
        
        
      
        
        }
        else
        {
          $getsecondary=DB::table('ltm_translations')
                
                ->groupBy('locale')
               
                ->select('locale')
                ->get();
      
        
        foreach($getsecondary as $getsecondar)
        {
            $buildsecondary=$buildsecondary."<option value=".$getsecondar->locale.">".$getsecondar->locale."</option>";
        }   
        }
        
        
       echo $buildsecondary; 
    }
    
    
    public function thankyoupage(Request $request)
    {
        $tenantid=$request->tid;
        $tenantdetails='';
        if(isset($tenantid) && !empty($tenantid))
        {
            $tenantdetails=DB::table('tenants')->where('tenantid','=',$tenantid)->first();
            session(['tenant_primary_color'=>$tenantdetails->primarycolor]);
            session(['tenant_secondary_color'=>$tenantdetails->secondarycolor]);
        }
        else
        {
            session(['tenant_primary_color'=>'']);
            session(['tenant_secondary_color'=>'']);
        }
        

        
        //fetching the welcome notes
        $TemplateCode= \App\Helpers\AppGlobal::$Welcome_Tenant_TemplateCode;
        if(isset($request->newtemplatecode) && !empty($request->newtemplatecode))
        {
          $TemplateCode=$request->newtemplatecode;  
        
        }
        
        if($TemplateCode!="NTMR")
        {
        $welcomenotes=DB::table('email_templates')->where('code','=',$TemplateCode)->first()->message;  
        $welcomenotes=str_replace("%%PLATFORMNAME%%",session('platformname'),$welcomenotes);
        }
        else
        {
          $welcomenotes="<p><b>Your new team member request is in process for approval</b></p>";   
        }


       
        return view('tenants.thank_you',compact('tenantdetails','welcomenotes'));
       
    }




    public function savemultiplecompanyinvite(Request $request)
    {
     for($i=0;$i<count($request->multiarray);$i++)
     {
         $str="";
         $countcheckmail=0;
         $checkemail=DB::table('users')->where('email','=',$request->multiarray[$i][3])->get(); 
         if(isset($checkemail))
         {
         $countcheckmail=count($checkemail);
         }
         if($countcheckmail == 0)
         {
          $firstname=$request->multiarray[$i][0];
          $lastname=$request->multiarray[$i][1];
          $companyname=$request->multiarray[$i][2];
          $companyemail=$request->multiarray[$i][3];
             
         $qry=DB::table('company_invite')->insert([
           'firstname'=>$firstname,
           'lastname'=>$lastname,
           'companyname'=>$companyname,
           'companyemail'=>$companyemail,  
         ]);
          
          $TemplateCode= \App\Helpers\AppGlobal::$CompanyInvite_Request_TemplateCode;
          
             
           $tenantid=session('tenantid');
           if(isset($TemplateCode))
           {
            
             $TemplateMaster=DB::table('email_master_templates')->first();
              if(isset($TemplateMaster))
              {
                $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
              
                if(isset($Template))
                {
                  $MessageBody=$Template->message;
                  
                  $MessageBody=str_replace("%%RECEIVER%%",$firstname.' '.$lastname,$MessageBody);
                  $MessageBody=str_replace("%%SENDER_EMAIL%%",$companyemail,$MessageBody);
                  $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                  $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                  $prelink=\App\Helpers\AppGlobal::$App_Domain.'/pre-register?tid='.$tenantid;
                  $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                  $MessageBody=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$MessageBody);
                  $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
                   

                  $Message_with_master= $TemplateMaster->content; 
                  
                  $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$Message_with_master);
                  $Message_with_master=str_replace('%%EMAILCONTENT%%',$MessageBody,$Message_with_master);

                  $forgetpwdlink=\App\Helpers\AppGlobal::$App_Domain.'/forgotpassword?tid='.$tenantid;
                  $Message_with_master=str_replace("%%LOGIN_LINK%%",$loginlink,$Message_with_master);
                  $Message_with_master=str_replace("%%PRELINK%%",$prelink,$Message_with_master);
                  $Message_with_master=str_replace("%%FORGETPWD_LINK%%",$forgetpwdlink,$Message_with_master);
                  
                  $logo=session('tenant_logo'); $t_logo='';
                  if( (isset($logo) && !empty($logo) ) && File::exists(public_path('/storage/tenant/logoimage/'.$logo))==true)
                  {
                      $t_logo=\App\Helpers\AppGlobal::$App_Domain.'/storage/tenant/logoimage/'.$logo;
                  }
                  else
                  {
                      $t_logo=\App\Helpers\AppGlobal::$App_Domain."/img/logo_desktop.png";
                  }
                  $Message_with_master=str_replace("%%EMAIL_LOGO_LINK%%",$t_logo,$Message_with_master);
                
                  $Message_with_master=str_replace("%%CONTACTUS_LINK%%",session('tenant_contact_us_link'),$Message_with_master);
                  $Message_with_master=str_replace("%%PRIVACYPOLICY_LINK%%",session('tenant_privacy_policy_link'),$Message_with_master);
                  $Message_with_master=str_replace("%%COMPANY_NAME%%",session('tenant_company'),$Message_with_master);
                  $Message_with_master=str_replace("%%YEAR%%",date('Y'),$Message_with_master);
                  
                  $helper= \App\Helpers\AppHelper::instance();
                  
                  
                  $Message_with_master=str_replace("%%COMPANY_ADDRESS%%",$helper->getCompleteAddress('tenant',$tenantid),$Message_with_master);
                 
                  $Message_with_master=$helper->getSocialLinks('tenant',$tenantid,$Message_with_master);
                  
                  $Template->fromname=session('tenant_from_name');
                  $Template->fromemail=session('tenant_from_email');
                 
//                  $company_email=DB::select(DB::raw("select email from company where companyid='$companyid'"))[0]->email;
                  $company_email=$companyemail;
                 
                  //$company_email="khanasifphp@gmail.com";
                
                  $helper->SendEmail($Template,$company_email,$Message_with_master);
                //   if($helper->SendEmail($Template,$company_email,$Message_with_master))
                //   {
                //        $str=$str.$companyemail." sent successfully<br/>";
                //   }
                }
              }
           }
            $str=$str."Invitation to company ".$companyemail." has been successfully sent.<br/>";
         }
         else
         {
             $str=$str."Company/User with email '".$request->multiarray[$i][3]."' already exists.<br/>";
         }
         echo $str;
     }
 
    }


     //for page related coding.


      public function pages()
      {
       return view('tenants.pages.page');
      }


      public function getpagedata(Request $request)
{

 $search=$request->search;
 $types=$request->types;
 $getpagesize = 10;
 $tid=session('tenantid');

 $query = DB::table('pages as p')
 ->where('tenantid',$tid);
 


  if(isset($search) && !empty($search))
  {
     $query->where('p.name','like', '%' . $search . '%');
     
    
  
  }

  if(isset($request->sort) && !empty($request->sort))
  {
switch ($request->sort) {
  case 'name':
  $query->orderBy('p.name');
      break;
  case 'title':
  $query->orderBy('p.title');
  break;
  
  
}

}


$datas = $query->select('p.pageid','p.name','p.title','p.activestatus','p.createddate','p.slug','p.tenantid')->paginate($getpagesize);
 


$view=View::make('tenants.pages.pagedata',compact('datas'))->render();
return $view;

}


   public function createpage()
   {
    return view('tenants.pages.createpage');





   }

   public function edittenant(Request $request)
   {
       $page="edit";
       $pid=$request->pid;
       $tenantid=session('tenantid');

       $getpage = DB::table('pages')
       ->where('pageid',$pid)
       ->where('tenantid',$tenantid)
       ->first();
       
       return view('tenants.pages.createpage',compact('page','getpage'));
   }


   public function createupdatepage(Request $request)
   {  
       
    
     $helper= \App\Helpers\AppHelper::instance();
     $pageidnew =  $helper->fnGetUniqueID(16, 'pages', 'pageid'); 
     $pagename = $request->pagename;
     $title = $request->title;
     $metatitle = $request->metatitle;
     $metadescription = $request->metadescription;
     $description = $request->description;
     $slug = $request->slug;
     $content = $request->ckeditor1;
     $pageid = $request->pageid;
     $tenantid = session('tenantid');

     if(isset($pageid) && !empty($pageid))
     {

        $checkslug = DB::table('pages')->where('slug', $slug)->where('pageid','<>',$pageid)->where('tenantid','=',$tenantid)->get();

        if(isset($checkslug) && !empty($checkslug) && count($checkslug) > 0)
        {
          return redirect()->back()->with('slugerror', 'Slug already exists')->withInput(); 
          
        }
        else {
          DB::table('pages')->
          where('pageid',$pageid)
          ->update([
             
              'name'=>$pagename,
              'title'=>$title,
              'meta_title'=>$metatitle,
              'meta_description'=>$metadescription,
              'description'=>$description,
              'slug'=>$slug,
              'content'=>$content,
    
    
          ]);
          return redirect('/tenant/pages');
        }




     }
     else
     {

      $checkslug = DB::table('pages')->where('slug', $slug)->where('tenantid',$tenantid)->get();

      if(isset($checkslug) && !empty($checkslug) && count($checkslug) > 0)
      {
        return redirect()->back()->with('slugerror', 'Slug already exists')->withInput(); 
        
      }
      else {
        DB::table('pages')->insert([
            'pageid'=>$pageidnew,
            'tenantid'=>$tenantid,
            'name'=>$pagename,
            'title'=>$title,
            'meta_title'=>$metatitle,
            'meta_description'=>$metadescription,
            'description'=>$description,
            'slug'=>$slug,
            'content'=>$content,
  
  
        ]);
        return redirect('/tenant/pages');
      }
      
     
     }

   }



   public function savepagebannerimage(Request $request)
   {
       $helper= \App\Helpers\AppHelper::instance();
       $pageid=$request->bannerpageid;
       $response['status'] = 0 ; 
       $file = $request->file('file');
       $extension = $file->getClientOriginalExtension();
       $mime = $file->getClientMimeType();
       $original_filename = $file->getClientOriginalName();
       $filename = $file->getFilename().'.'.$extension;
       $document_application_name=$helper->fnGetUniqueID('5','pages','banner');
       $document_application_name = $document_application_name.'.'.$extension;
       $uploadDir = 'storage';
       $tmpFile = $_FILES['file']['tmp_name']; 
       $filename = $uploadDir.'/tenant/banner/'. $document_application_name;
       if(move_uploaded_file($tmpFile,$filename))
       {
       $response['status']=1;
       $filename = $file->getFilename().'.'.$extension;;
       }
       if($response['status']) {
       DB::table('pages')
      ->where('tenantid',session('tenantid'))
      ->where('pageid',$pageid)
      ->update(['banner' => $document_application_name ]); 
                     
      return response()->json(['success'=>true]);
       }
                  
      return redirect()->back()->with($response);
   }

   public function deletepage(Request $request)
   {
       $pageid = $request->tid;
       $tenantid = session('tenantid');
       DB::table('pages')->where('pageid',$pageid)->where('tenantid',$tenantid)->delete();
       return redirect('/tenant/pages');
   } 


   public function showpage(Request $request)
   {
       $tenantid = $request->tid;
       $pagename = $request->page;
       
       $getpage = DB::table('pages')->where('tenantid',$tenantid)->where('slug',$pagename)->first();
       if(isset($getpage) && !empty($getpage))
       {
       echo $getpage->name;
       }
       else
       {

       }


   }
    
    
}
