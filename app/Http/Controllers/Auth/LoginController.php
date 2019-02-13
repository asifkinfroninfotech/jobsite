<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use view;
use Session;
use DB;
use Auth;
use App\Models\User;
use Redirect;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers{
     login as protected parent_login;   
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        //change to make is online 0
        $tenantid=session('tenantid');

           session()->flush();
           $user = Auth::user();
           if($user)
           {
           $user->is_online=0;
           $user->save();
           }

           Auth::guard('web')->logout();
           if(isset($tenantid) && !empty($tenantid))
           {
            return redirect('/login?tid='.$tenantid);
           }
           else
           {
            return redirect('/login');
           }
          
    }

    //overriding auth.failed
     protected function sendFailedLoginResponse(Request $request)
    {

        if ( ! User::where('email', $request->email)->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => trans('login.emailnotfound'),
                ]);
        }

        if ( ! User::where('email', $request->email)->where('password', bcrypt($request->password))->first() ) {
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'password' => trans('login.passwordnotvalid'),
                   
                    
                ]);
        }

    }
    //
    

   
    public function Login(Request $request) 
    {

     


    session(['helpview'=>'1']);   

    $messages = [
    'password.min' => trans('login.passwordlen'),
    'email.email' => trans('login.emailnotvalid'),
    ];
        $this->validate($request, [
           'email' => 'required|email',
           'password' => 'required|min:6'
    	],$messages);
      
        $email=$request->email;
        $password=$request->password;
        $tenantid=$request->tenantid;

        $remember = $request->remember;

        // $activeuser='';
        // if(isset($tenantid) && !empty($tenantid))
        // {
        //     $activeuser=DB::table('users')->Join('usercompanies', 'users.userid', '=', 'usercompanies.userid')
        //     ->select('*')
        //     ->where('users.email', '=', $email)
        //     ->where('users.tenantid',$tenantid)
        //     ->first();
        // }
        // else{
        //     $activeuser=DB::table('users')->Join('usercompanies', 'users.userid', '=', 'usercompanies.userid')
        //     ->select('*')
        //     ->where('users.email', '=', $email)
        //     ->first();
        // }

        //            $au_count=-1;
        //            if(isset($activeuser) && !empty($activeuser))
        //            {
        //              $au_count=1;
        //            }

        // $results = DB::select( DB::raw("SELECT tenantid,tenantactive,firstname,lastname,company,platformname FROM tenants WHERE tenants.email = '$email' and tenants.password = '$password'") );
        // if(count($results) > 0)
        // {
        //     if($results[0]->tenantactive==1)
        //     {
        //     session(['tenantid'=>$results[0]->tenantid]);
        //     session(['platformname'=>$results[0]->platformname]);
        //     session(['tenant_firstname'=>$results[0]->firstname]);
        //     session(['tenant_lastname'=>$results[0]->lastname]);
        //     session(['tenant_company'=>$results[0]->company]);
        //     return redirect('/tenant/dashboard');
        //     }
        //     else
        //     {
        //         Session::flash('activemessage', trans('login.not_active'));
        //             return Redirect::back(); 
        //     }
            
        // }
        // else
        // {

        //     if($au_count<0)//if -1
        //     {
        //         $loggingusers=DB::table('users')->where('users.email', '=', $email)->first();
        //         if(isset($loggingusers) && !empty($loggingusers) && $loggingusers->isadmin==1)
        //         {
        //             return $this->parent_login($request);
        //         }
        //         else
        //         {
        //             Session::flash('activemessage', trans('login.not_active'));
        //             return Redirect::back(); 
        //         }
               
        //     }
        //     else
        //     {

        //         if($au_count>0)
        //         {
        //             if($activeuser->recordstatus=="Active" )
        //             {   
        //              return $this->parent_login($request);
        //             }
        //             else
        //             {
        //                 Session::flash('activemessage', trans('login.not_active'));
        //                 return Redirect::back(); 
        //             }
        //         }
        //         else
        //         {
        //             Session::flash('activemessage', trans('login.not_active'));
        //             return Redirect::back(); 
        //         }
        //     }
       
        // }

       //Temporary Test 
    //    $userlist=DB::table('users')->get();
    //    $userids='';
    //    foreach($userlist as $user)    
    //    {
    //        if($userids=='') 
    //        {
    //         $userids="'".$user->userid."'";
    //        }
    //        else
    //        {
    //         $userids=$userids.','.$user->userid;
    //        }
    //    }   
       //Test Code End



        //NEW CODE ON LOG IN
        $logginguser=DB::table('users')
        ->where('users.email', '=', $email)
        ->where('users.userpassword','=',$password)
        ->first();
        if(isset($logginguser) && !empty($logginguser))
        {
            if($logginguser->is_tenant==0)//i.e. User is either SUPER ADMIN Or Normal User.
            {
                 if($logginguser->isadmin==1)//SUPER ADMIN
                 {
                    session(['tenantid' => $logginguser->tenantid]);
                    session(['userid'=> $logginguser->userid]);
                    return $this->parent_login($request);
                 }
                 else//Normal User
                 {
                     if($logginguser->activestatus=="active")
                     {
                        $UserStatus=DB::table('usercompanies as uc')
                        ->join('company as c','c.companyid','uc.companyid')
                        ->join('companytypes as ct','ct.companytypeid','=','c.companytypeid') 
                        ->where('uc.userid',$logginguser->userid)
                        ->select('ct.companytype','uc.userrole','uc.userid','uc.recordstatus','c.companystatus','c.activestatus','uc.companyid')
                        ->first();
                        if($UserStatus->recordstatus=='Active' && $UserStatus->companystatus=='Verified' && $UserStatus->activestatus=='Active')
                        {
                            $tenantobj=DB::table('tenants')->where('tenantid',$logginguser->tenantid)->first();
                            session(['companyid' => $UserStatus->companyid]);
                            session(['tenantid' => $logginguser->tenantid]);
                            session(['userrole'=> $UserStatus->userrole]);
                            session(['userid'=> $logginguser->userid]);
                            session(['usertype'=> $UserStatus->companytype]);
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
                            return $this->parent_login($request);

                        }
                        else
                        {
                            //not_verified Or In-Active
                            if($UserStatus->companystatus=='Unverified' || $UserStatus->activestatus=='In-Active')
                            {
                                Session::flash('activemessage', trans('login.not_verified_company'));
                                return Redirect::back(); 
                            }
                            else
                            {
                                Session::flash('activemessage', trans('login.not_verified_message'));
                                return Redirect::back(); 
                            }
                        }
                     }
                     else
                     {
                        Session::flash('activemessage', trans('login.not_active'));
                        return Redirect::back(); 
                     }
                 }
            }
            else//The user is TENANT.
            {
                 $t_obj=DB::table('tenants as t')->where('t.userid',$logginguser->userid)->first();
                 if(isset($t_obj) && !empty($t_obj))
                 {
                     if($t_obj->tenantactive==1)
                     {
                         if($t_obj->tenantstatus=='Verified')
                         {
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
                            //return $this->parent_login($request);
                            Auth::loginUsingId([$logginguser->userid]);
                            return redirect()->intended('/');
                         }
                         else
                         {
                            Session::flash('activemessage', trans('login.not_verified_tenant'));
                            return Redirect::back(); 
                         }


                     }
                     else
                     {
                        Session::flash('activemessage', trans('login.not_active'));
                        return Redirect::back(); 
                     }

                 }
                 else
                 {
                    Session::flash('activemessage', trans('login.notfound_user_message'));
                    return Redirect::back(); 
                 }
            }
            
        }
        else
        {
            Session::flash('activemessage', trans('login.notfound_user_message'));
            return Redirect::back(); 
        }


        //END OF CODE
        
    }

    public function forgotpassword()
    {
        
        return view('auth.forgotpassword');
        
    }

    public function postforgetpassword(Request $request)
    {
     $messages = [
    
    'email.email' => trans('login.emailnotvalid'),
    ];
        $this->validate($request, [
           'email' => 'required|email'
           
    	],$messages);
        
        
       $username=$request->email;
       $checkusercount=0;
       $checkusername='';
       if(isset($username) && !empty($username))
       {
          $checkusername =DB::table('users')->where('email',$username)->first();
  
       }
       if(!isset($checkusername) || empty($checkusername))
       {
           return redirect('/forgotpassword')->with('emailstatus','Username does not exists in the system.');
       }
       else
       {
        //    $random = sprintf('%08d', mt_rand(0,99999999));
        //    echo $random;
        //    $password = bcrypt($random);
        //    DB::table('users')->where('email',$username)->update([
               
        //        'password'=>$password
               
        //    ]);
        try{
            $TemplateCode= \App\Helpers\AppGlobal::$Switch_User_TemplateCode;
            if(isset($TemplateCode))
            {

              $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
              if(isset($Template))
              {
                $TemplateMaster=DB::table('email_master_templates')->first();

                if(isset($TemplateMaster))
                {
                    $autologinlink=\App\Helpers\AppGlobal::$App_Domain.'/gotouser?userid='.$checkusername->userid;
                  $MessageBody=$Template->message;
                  $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
                  $MessageBody=str_replace("%%USERID%%",$checkusername->userid,$MessageBody);
                   $MessageBody=str_replace("%%AUTO_LOGIN_LINK%%",$autologinlink,$MessageBody);

                  $receiver_email=$checkusername->email;

                  $Message_with_master= $TemplateMaster->content; 
                  $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$Message_with_master);   
                  $Message_with_master=str_replace('%%EMAILCONTENT%%',$MessageBody,$Message_with_master);
                  $helper= \App\Helpers\AppHelper::instance();
                  $helper->SendEmail($Template,$receiver_email,$Message_with_master);
                }
              }
            }     
        }
      catch(\Exception $e){
        // do task when error
         //dd($e);
      }
           return redirect('/forgotpassword')->with('emailstatus','An email has been sent to you for auto log in.');
           
       }
    }
    
    
//    public function showLoginForm()
//    {
//    return view('tenants.tenant_payment_success');
//    }



}