<?php
namespace App\Helpers;
use Carbon\Carbon;
use Cache;
use DB;
use Auth;
use session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;

class AppHelper
{
   public $profileimage="";
   public $firstname="";
   public $lastname="";
   public $userposition="";
   public $url="";
   public $messages="";
   public $getmessagesusers="";
   public $companyname="";
   public $importarray=[];

   
   public function GetAvatarByName($fname,$lname)
   {
    // $avatarname="";
    //    if(isset($fname))
    //    {
    //        $fname=ucfirst($fname);
    //        $avatarname=$fname;
    //    }
    //    if(isset($lname))
    //    {
    //        $lname=ucfirst($lname);
    //        $avatarname=$avatarname.' '.$lname;
    //    }
    //     return Avatar::create($avatarname)->toBase64();
   }

   public function fnGetUniqueID($charlength,$tablename,$columnname)
    {
   /* $random_bytes = mcrypt_create_iv($charlength, MCRYPT_DEV_URANDOM);*/
    $string = $this->getToken($charlength);
   
    $result= mysqli_query($this->getConnectionString(), "select $columnname from $tablename where $columnname = '$string'");
    $numrows= mysqli_num_rows($result);
    if($numrows == 0)
    {
    return $string; 
    }
    if($numrows > 0)
    {
    $string1 = functiongetuniqueid($charlength, $tablename, $columnname);
    return $string1;
    }
    }

    public function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).'t';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).'b';
        elseif ($n > 1000000) return round(($n/1000000), 2).'m';
        elseif ($n > 1000) return round(($n/1000), 2).'k';

        return number_format($n);
    }

    
    public function fnMaxDisplayOrder($tablename,$columnname)
    {
     try {
      $result= mysqli_query($this->getConnectionString(), "select Max($columnname) as max from $tablename") or die ('error getting data from database');

     $row = mysqli_fetch_array( $result );
     $largestNumber = $row['max']+1;

      return $largestNumber;
     } catch (Exception $e) {
         return 0+1;
     }

    }

    public function fnMaxDisplayOrderByWhere($tablename,$columnname,$wherecolumn1,$wherevalue1)
    {
     try {
      $result= mysqli_query($this->getConnectionString(), "select Max($columnname) as max from $tablename where $wherecolumn1= '$wherevalue1'") or die ('error getting data from database');

     $row = mysqli_fetch_array( $result );
     $largestNumber = $row['max']+1;

      return $largestNumber;
     } catch (Exception $e) {
         return 0+1;
     }

    }

    public function getaltuseridfromgroupid($tablename,$groupid)
    {
         try {
       $result= mysqli_query($this->getConnectionString(), "select userid from $tablename where groupid= '$groupid'") or die ('error getting data from database');
     $userid=array();
     $count=0;
     while($row = mysqli_fetch_array( $result ))
     {
     $userid[$count]=$row['userid'];
     $count++;
     }
      return $userid;
     } catch (Exception $e) {
         return 0+1;
     }
    }

    public function getConnectionString()
    {
        try{
            $conn= mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'),getenv('DB_PASSWORD')
            ,getenv('DB_DATABASE'));
    
              return $conn;
        }
        catch(\Exception $e)
        {
            dd($e);
        }

    }

    public function getToken($length)
    {
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) 
    {
        $token .= $codeAlphabet[random_int(0, $max-1)];
    }

    return $token;
    }


    public function dateconv($date)
    {
    $date = strtotime($date);
    $date1="";
    $date2=date('Y-m-d', $date);
    $currentdate=date("Y-m-d");
    if($currentdate==$date2)
    {
      
        $date1="Today  ".date('h:ia',$date);
    }
    $prevoiusday=date('Y-m-d', strtotime('-1 day'));
    if($prevoiusday==$date2)
    {
        
        $date1="Yesterday  ".date('h:ia',$date);
    }
    $tommorrow=date('Y-m-d', strtotime('+1 day'));
    if($tommorrow==$date2)
    {
        
        $date1="Tommorrow  ".date('h:ia',$date);
    }
    if($date2!=$currentdate && $date2!=$prevoiusday && $date2!=$tommorrow)
    {
        
      $date1=date('M dS, Y', $date)." ".date('h:ia', $date);
    }
    
       
    return trim($date1); 
    
    
    }

    public function dateconv_with_at($date)
    {
    $date = strtotime($date);
    $date1="";
    $date2=date('Y-m-d', $date);
    $currentdate=date("Y-m-d");
    if($currentdate==$date2)
    {
      
        $date1="Today at ".date('h:ia',$date);
    }
    $prevoiusday=date('Y-m-d', strtotime('-1 day'));
    if($prevoiusday==$date2)
    {
        
        $date1="Yesterday at ".date('h:ia',$date);
    }
    $tommorrow=date('Y-m-d', strtotime('+1 day'));
    if($tommorrow==$date2)
    {
        
        $date1="Tommorrow at ".date('h:ia',$date);
    }
    if($date2!=$currentdate && $date2!=$prevoiusday && $date2!=$tommorrow)
    {
        
      $date1=date('M dS, Y', $date)." at ".date('h:ia', $date);
    }
    
       
    return trim($date1); 
    
    
    }


    


     public static function instance()
     {
         return new AppHelper();
     }


     public function GetDifferenceBetweenTwoDate($todate,$fromdate,$returntype)
     {

       $to = Carbon::createFromFormat('Y-m-d H:i:s', $todate);
       $from = Carbon::createFromFormat('Y-m-d H:i:s', $fromdate);
       $diff_in_hours = $to->diffInHours($from);

            /*switch ($returntype) {
              case 'hours':
                

                break;

              case 'days':
                # code...
                break;
              
              default:
                # code...
                break;
            }*/

            return $diff_in_hours;
     }

     public function headerlogics()
     {
         
         if(Auth::check())
          {
              $userid=session('userid');
       if(isset($userid) && !empty($userid))
        {
        $getuserdetails=DB::select(DB::raw("select firstname,lastname,profileimage,userposition from users where userid = '".$userid."'"));
        $this->profileimage=$getuserdetails[0]->profileimage;
        $this->firstname=$getuserdetails[0]->firstname;
        $this->lastname=$getuserdetails[0]->lastname;
        $this->userposition=$getuserdetails[0]->userposition;
        $this->messagescount=count(DB::select(DB::raw("select distinct(messages.userid) from messages,message_recipients where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".$userid."') and message_recipients.userid='".$userid."' and message_recipients.messagestatus = '0' ")));
        $this->getmessagesusers=DB::select(DB::raw("select distinct profileimage,firstname,lastname,users.userid,users.userposition from messages,message_recipients,users where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".$userid."') and message_recipients.userid='".$userid."' and messages.userid = users.userid and message_recipients.messagestatus = '0'"));
  
        $this->url="login";
        }
        else
        {
        $this->profileimage=Auth::user()->profileimage;
        $this->firstname=Auth::user()->firstname;
        $this->lastname=Auth::user()->lastname;
        $this->userposition=Auth::user()->userposition;
        $this->url="login";
        //earlier code
        //$this->messagescount=count(DB::select(DB::raw("select * from messages,message_recipients where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."'")));
        //
        //new code
       
         $this->messagescount=count(DB::select(DB::raw("select distinct(messages.userid) from messages,message_recipients where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."' and message_recipients.messagestatus = '0'")));
         
         
         
        //
        $this->getmessagesusers=DB::select(DB::raw("select distinct profileimage,firstname,lastname,users.userid,users.userposition from messages,message_recipients,users where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."' and messages.userid = users.userid and message_recipients.messagestatus = '0'"));
        $updateonlinestatus=DB::statement("UPDATE users SET is_online = '1' where userid = '".Session('userid')."'");
        }
       
        }
       else
        {
        $this->url="logout";
        }
      }


      public function gettenant_header()
      {
          $tenantid=session('tenantid');
          $tenant="";
          if(isset($tenantid))
          {
          $tenant=DB::table('tenants')->where('tenantid',$tenantid)->first();
          
          }
          return $tenant;
      }

      public function get_All_Associated_Companies($parentpipelinedealids)
      {
        $tenantid=session('tenantid');
        $all='';
        if(isset($parentpipelinedealids) && !empty($parentpipelinedealids) )
        {
            $all=DB::select(DB::raw("SELECT pd.pipelinedealid,(case when pd.parentpipelinedealid is null then pd.pipelinedealid else pd.parentpipelinedealid END) as parentpipelinedealid,pd.companyid,c.name as company,c.profileimage,ct.companytype FROM `pipelinedeals` as pd
            JOIN company as c on c.companyid=pd.companyid
            JOIN companytypes as ct on ct.companytypeid=c.companytypeid
            WHERE (pd.pipelinedealid in ($parentpipelinedealids) Or pd.parentpipelinedealid in ($parentpipelinedealids)) AND IsPermissionDenied=0 and pd.tenantid='$tenantid'"));
        }
   
        return $all;
      }

      public function companymessagingandconnect($getcompanyid,$userid,$friendlist)
      {
        $connect="messaging";
        $originalcompany=session('companyid');
        if(!empty($getcompanyid))
        {
        if($originalcompany != $getcompanyid)
        {
        foreach($friendlist as $friendlist)
        {
         if($userid==$friendlist->friendid)
         {
             if($friendlist->recordtype=="friend")
             {$connect="messaging";}
             if($friendlist->recordtype=="sender")
             {$connect="approval";}
             break;
         }
         else
         {
             $connect="connect";
         }
        
            
        } 
     
        }
        
        }
        return $connect;
    }

    public function get_language_related_data()
    {
        $loggedinuser=DB::table('users')->where('tenantid',session('tenantid'))->where('userid',session('userid'))->first();
        
        // $languagetodisplay = DB::table('ltm_translations')
        //         ->groupBy('locale')
        //         ->where('locale', '!=',  $loggedinuser->language)
        //         ->select('locale')
        //         ->get();

                $languagetodisplay = DB::table('tenant_languages')
                ->where('tenantid',session('tenantid'))
                ->select('language as locale')
                ->get();

                $data = [
                    'loggedinuser' => $loggedinuser,
                    'languagetodisplay' => $languagetodisplay
                ];   
// dd($data['loggedinuser']->language);
                return  $data; 
    }

    public function SetTenant_PrimaryLanguage($tenantid)
    {
        $langobj=DB::select(DB::raw("Select language from tenant_languages where tenantid='$tenantid' AND is_primary=1"));
        // dd($langobj);
        if(isset($langobj) && !empty($langobj))
        {
            app()->setLocale($langobj[0]->language);
        }
        
    }

        //Asif-code for implementing active class on url
        public function checkurl($types)
        {
            $addclassactive="";
            $url=$_SERVER['REQUEST_URI'];
            
            if($url=="/admincompany" && $types=='company')
            {
                $addclassactive="admin-active";
            }
            else if($url=="/adminuser" && $types=='user')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/admindeal" && $types=='deal')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/adminduediligence" && $types=='dd')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/admintenant" && $types=='tenant')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/admin/requests" && $types=='requests')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/admin/dashboard" && $types=='dashboard')
            {
               $addclassactive="admin-active"  ;
            }
            else
            {
               $addclassactive="";
            }
          return $addclassactive;
            
        }
        //Asif-code for implementing active class url on tenant
        public function checktenanturl($types)
        {
            $addclassactive="";
            $url=$_SERVER['REQUEST_URI'];
            
            if($url=="/tenant/dashboard" && $types=='dashboard')
            {
                $addclassactive="admin-active";
            }
            else if($url=="/tenant/company" && $types=='company')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/tenant/user" && $types=='user')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/tenant/deal" && $types=='deals')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/tenant/duediligence" && $types=='duediligence')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/tenant/requests" && $types=='requests')
            {
               $addclassactive="admin-active"  ;
            }
            else if($url=="/tenant/account/subscription" && $types=='subscription')
            {
               $addclassactive="admin-active" ;
            }
            else if($url=="/tenant/emails" && $types=='emails')
            {
               $addclassactive="admin-active" ;
            }
            else
            {
               $addclassactive="";
            }
          return $addclassactive;
            
        }

        public function getTenantDetails()
        {
            $tenantobj='';
            $tenantid= '';
            if(isset($_GET['tid']))
            {
                $tenantid= $_GET['tid'];
            }
            if(isset($tenantid) && !empty($tenantid))
            {
               $tenantobj=DB::table('tenants')->where('tenantid',$tenantid)->first();
            }
          return $tenantobj;
        }

        public function getSessionTenantDetails()
        {
            $tenantobj='';
            $tenantid= session('tenantid');
            if(isset($tenantid) && !empty($tenantid))
            {
               $tenantobj=DB::table('tenants')->where('tenantid',$tenantid)->first();
            }
          return $tenantobj;
        }

        public function GetHelpModifiedText($originaltext)
        {
           $key1="%%PLATFORMNAME%%";
           $key2="%%INVESTORNAME%%";
           $platformname=session('platformname');
           $investorname=session('tenant_company');
           $changetext=str_replace($key1,$platformname,$originaltext);
           $changetext=str_replace($key2,$investorname,$changetext);
           return $changetext;
         }


    public function SendEmail($Template,$ToEmail,$Message)
    {
         try 
        {
              Mail::send('emails.common_email', ['html_mail_content' => $Message], function ($message) use ($Template,$ToEmail) {
                $message->from($Template->fromemail, $Template->fromname);
                $message->sender($Template->fromemail, $Template->fromname);
                $message->to($ToEmail, $name=null);
                $message->subject($Template->subject);
                $message->priority(3);
            });
        } 
        catch (Exception $e) 
        {
            print_r($e);
        }
    }


    //Common Method To Record Recent Activity Performed By the Users.
    public function AddRecentActivity($entityid,$type,$actiontaken)
    {
        try 
        {
        $userid=session('userid');
        $tenantid=session('tenantid');
        $activityid=$this->fnGetUniqueID(16, 'recent_activities', 'activityid');   
        DB::table('recent_activities')->insert(
            [
             'activityid'=>$activityid,
             'tenantid'=> $tenantid,
             'userid' => $userid,
             'entityid' => $entityid,
             'action' => $actiontaken,
             'type' => $type
            ]
           );
        } 
        catch (Exception $e) 
        {

        }
    }


    public function getCompleteAddress($type,$id)
    {
        $c_address='';
        switch($type)
        {
            case "tenant":
            $tenantobj=DB::table('tenants as t')
            ->leftjoin('country as c','c.countryid','t.country')
            ->where('t.tenantid',$id)
            ->select('t.address1','t.address2','t.city','t.state','c.name as country','t.postcode')
            ->first();
            if(isset($tenantobj))
            {
                if(isset($tenantobj->address1) && !empty($tenantobj->address1))
                {
                    $c_address=$tenantobj->address1;
                }
                if(isset($tenantobj->address2) && !empty($tenantobj->address2))
                {
                    $c_address=$c_address.', '.$tenantobj->address2;
                }
                if(isset($tenantobj->city) && !empty($tenantobj->city))
                {
                    $c_address=$c_address.', '.$tenantobj->city;
                }
                if(isset($tenantobj->state) && !empty($tenantobj->state))
                {
                    $c_address=$c_address.', '.$tenantobj->state;
                }
                if(isset($tenantobj->country) && !empty($tenantobj->country))
                {
                    $c_address=$c_address.', '.$tenantobj->country;
                }
                if(isset($tenantobj->postcode) && !empty($tenantobj->postcode))
                {
                    $c_address=$c_address.' '.$tenantobj->postcode;
                }
            
            }
            break;


        }

        return $c_address;
    }

    public function getSocialLinks($type,$id,$contents)
    {
        $Message_with_master=$contents;


       if($type=='tenant')
       {
        $tenant_extra=DB::table('tenants as t')
        ->leftjoin('tenants_landingpage as tl','t.tenantid','tl.tenantid')
        ->where('t.tenantid',$id)
        ->select('tl.twitter','tl.facebook','tl.linkedin')
        ->first();
        if(isset($tenant_extra))
        {
          //For Twitter
             if(isset($tenant_extra->twitter) && !empty($tenant_extra->twitter))
             {
               $t_td=\App\Helpers\AppGlobal::$twitter_td;
               $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
               $t_td=str_replace("%%twitter_link%%","https://twitter.com/".$tenant_extra->twitter,$t_td);
               $Message_with_master=str_replace("%%twitter_td%%",$t_td,$Message_with_master);

             }
             else
             {
              $Message_with_master=str_replace("%%twitter_td%%",'',$Message_with_master);
             }
             //For Facebook
                                             if(isset($tenant_extra->facebook) && !empty($tenant_extra->facebook))
                                               {
                                                // '<td width="38" align="center"><a href="%%facebook_link%%" style="display: inline-block;"><img alt="" src="%%DOMAIN%%/img/email_template_images/facebook.png" width="28" height="28"></a></td>';
                                                 $t_td=\App\Helpers\AppGlobal::$facebook_td;
                                                 $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
                                                 $t_td=str_replace("%%facebook_link%%","https://www.facebook.com/".$tenant_extra->facebook,$t_td);
                                                 $Message_with_master=str_replace("%%facebook_td%%",$t_td,$Message_with_master);
          
                                               }
                                               else
                                               {
                                                $Message_with_master=str_replace("%%facebook_td%%",'',$Message_with_master);
                                               }

                                            //For Linked In Link
                                             if(isset($tenant_extra->linkedin) && !empty($tenant_extra->linkedin))
                                             {
                                              // '<td width="34" align="center"><a href="%%linkedin_link%%" style="display: inline-block;"><img alt="" src="%%DOMAIN%%/img/email_template_images/linkedin.png" width="28" height="28"></a></td>';
                                               $t_td=\App\Helpers\AppGlobal::$linkedin_td;
                                               $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
                                               $t_td=str_replace("%%linkedin_link%%","http://www.linkedin.com/in/".$tenant_extra->linkedin,$t_td);
                                               $Message_with_master=str_replace("%%linkedin_td%%",$t_td,$Message_with_master);
        
                                             }
                                             else
                                             {
                                              $Message_with_master=str_replace("%%linkedin_td%%",'',$Message_with_master);
                                             }
        }
        else
        {
          $Message_with_master=str_replace("%%twitter_td%%",'',$Message_with_master);
          $Message_with_master=str_replace("%%facebook_td%%",'',$Message_with_master);
          $Message_with_master=str_replace("%%linkedin_td%%",'',$Message_with_master);
        }
       }
       else if($type=='email_to_tenant')
       {
            $twitter=\App\Helpers\AppGlobal::$Artha_Twitter;
            $facebook=\App\Helpers\AppGlobal::$Artha_Facebook;
            $linkedin=\App\Helpers\AppGlobal::$Artha_Linkedin;

            if(isset($twitter) && !empty($twitter))
            {
                $t_td=\App\Helpers\AppGlobal::$twitter_td;
                $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
                $t_td=str_replace("%%twitter_link%%","https://twitter.com/".$twitter,$t_td);
                $Message_with_master=str_replace("%%twitter_td%%",$t_td,$Message_with_master);
            }
            else
            {
                $Message_with_master=str_replace("%%twitter_td%%",'',$Message_with_master);
            }

            if(isset($facebook) && !empty($facebook))
            {
                $t_td=\App\Helpers\AppGlobal::$facebook_td;
                $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
                $t_td=str_replace("%%facebook_link%%","https://www.facebook.com/".$facebook,$t_td);
                $Message_with_master=str_replace("%%facebook_td%%",$t_td,$Message_with_master);
            }
            else
            {
                $Message_with_master=str_replace("%%facebook_td%%",'',$Message_with_master);
            }

            if(isset($linkedin) && !empty($linkedin))
            {
                $t_td=\App\Helpers\AppGlobal::$linkedin_td;
                $t_td=str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$t_td);
                $t_td=str_replace("%%linkedin_link%%","http://www.linkedin.com/in/".$linkedin,$t_td);
                $Message_with_master=str_replace("%%linkedin_td%%",$t_td,$Message_with_master);
            }
            else
            {
                $Message_with_master=str_replace("%%linkedin_td%%",'',$Message_with_master);
            }
       }


        return $Message_with_master;
    }

        //Common Method To Get data of Admin User of a Company....
        public function GetCompanyAdminUserEmail($companyid)
        {
            try 
            {
            $email="";
            
            $userdata=DB::table('users as u')
                      ->join('usercompanies as uc','uc.userid','u.userid')
                      ->where('uc.companyid',$companyid)
                      ->where('uc.userrole',0)
                      ->select('u.userid','u.email')->first();


                      if(isset($userdata) && !empty($userdata))
                      {
                          $email=$userdata->email;
                      }

            return $email;
            } 
            catch (Exception $e) 
            {
    
            }
        }

               //Common method to get the Admin name of company...
        
               public function GetCompanyAdminUserName($companyid)
               {
                   try 
                   {
                   $username="";
                   
                   $userdata=DB::table('users as u')
                             ->join('usercompanies as uc','uc.userid','u.userid')
                             ->where('uc.companyid',$companyid)
                             ->where('uc.userrole',0)
                             ->select('u.userid','u.firstname','u.lastname')->first();
       
       
                             if(isset($userdata) && !empty($userdata))
                             {
                                 $username=$userdata->firstname.' '.$userdata->lastname;
                             }
       
                   return $username;
                   } 
                   catch (Exception $e) 
                   {
           
                   }
               }

              //Common method to get the Admin id of company...
              public function GetCompanyAdminUserId($companyid)
               {
                   try 
                   {
                   $username="";
                   
                   $userdata=DB::table('users as u')
                             ->join('usercompanies as uc','uc.userid','u.userid')
                             ->where('uc.companyid',$companyid)
                             ->where('uc.userrole',0)
                             ->select('u.userid','u.firstname','u.lastname')->first();
       
       
                             if(isset($userdata) && !empty($userdata))
                             {
                                 $username=$userdata->userid;
                             }
       
                   return $username;
                   } 
                   catch (Exception $e) 
                   {
           
                   }
               }


        public function InsertDefault_DD_Template($tenantid)
        {
            if(isset($tenantid) && !empty($tenantid))
            {
                $templateid=$this->fnGetUniqueID(16, 'dd_templates', 'templateid');
                         DB::table('dd_templates')->insert(
                                  [
                                  'templateid' => $templateid, 
                                  'tenantid'=>$tenantid,
                                  'name'=>'Tenant Default',
                                  'description' => 'Tenant Default',
                                  'activestatus' => 'Active',
                                  'type'=>'Tenant'
                                  ]
                                 );


                 $lstTmpModules=DB::table('modules_temp')->get();
                 $lstTmpQuestions=DB::table('questions_temp')->get();
                 $collection_Questions = collect(json_decode($lstTmpQuestions, true));
                 foreach ($lstTmpModules as $key => $m) 
                 {
                    $moduleid=$this->fnGetUniqueID(16, 'dd_template_modules', 'moduleid');
                    DB::table('dd_template_modules')->insert(
                        [
                        'templateid' => $templateid, 
                        'tenantid'=>$tenantid,
                        'modulename'=>$m->name,
                        'modulestatus' => 'Active',
                        'displayorder' => $m->displayorder,
                        'moduleid'=>$moduleid    
                        ]
                       );
                       //For Question Insertion
                       $m_questions = $collection_Questions->where('moduleid', $m->moduleid);
                       if($m_questions!=null)
                       {
                            foreach($m_questions as $q)
                            {
                                $questionid=$this->fnGetUniqueID(16, 'dd_template_questions', 'questionid');
               
                                DB::table('dd_template_questions')->insert(
                                         [
                                         'templateid' => $templateid, 
                                         'tenantid'=>$tenantid,
                                         'moduleid'=>$moduleid,    
                                         'questionid'=>$questionid,    
                                         'questiontext' => $q['question'],
                                         'displayorder' => $q['displayorder']
                                         ]
                                        );
                            }

                       }

                 }                
            }
        }


        public function GetSummaryData_Dashboard($tenantid)
        {
            $d1=new DashboardSummaryData();
            $d1->InterestShown=0;
            // Investor Type 'aba5f1'
            $tenant_condition="";
            $c_tenant_condition="";
            if(isset($tenantid) && !empty($tenantid))
            {
                $tenant_condition=" and tenantid="."'".$tenantid."'"; 
                $c_tenant_condition=" and c.tenantid="."'".$tenantid."'"; 
            }
            $is=DB::select(DB::raw("Select Count(companyid) as ishown from pipelinedeals where companyid in (Select companyid from company where companytypeid='aba5f1' $tenant_condition) $tenant_condition"));
            if(isset($is) && !empty($is))
            {
                $d1->InterestShown=$is[0]->ishown;
            } 
            
            $d1->InvestorAssetsUnderManagement=0;
            $ium=DB::select(DB::raw("select COALESCE(sum(f.value),0) as tfund from company as c join fundsundermanagement as f on f.fund=c.fundsundermanagement where c.companytypeid='aba5f1' $c_tenant_condition"));
            if(isset($ium) && !empty($ium))
            {
                $d1->InvestorAssetsUnderManagement=$ium[0]->tfund;
            } 

            $d1->New_PreRegistrations=0;
            $pre=DB::select(DB::raw("select count(*) pre from company where companystatus='Unverified' $tenant_condition"));
            if(isset($pre) && !empty($pre))
            {
                $d1->New_PreRegistrations=$pre[0]->pre;
            } 

            $d1->Noof_Views_Pipeline=0;
            $pview=DB::select(DB::raw("select COALESCE(sum(totalviews),0) as tview from deals where dealid in (select distinct dealid from pipelinedeals where pipelinedealid<>'' $tenant_condition) $tenant_condition"));
            if(isset($pview) && !empty($pview))
            {
                $d1->Noof_Views_Pipeline=$pview[0]->tview;
            } 


            $d1->Noof_Views_NewEnterprises=0;
            $visit_c=DB::select(DB::raw("select COALESCE(SUM(visitorcount),0) as cnt from companyvisitors where companyid in (select companyid from company where companytypeid='5eab3b' AND updated>=(CURDATE() - INTERVAL 10 DAY) $tenant_condition) $tenant_condition"));
            if(isset($visit_c) && !empty($visit_c))
            {
                $d1->Noof_Views_NewEnterprises=$visit_c[0]->cnt;
            } 

            $d1->Incomplete_Profiles=0;
            $isprofil_c=DB::select(DB::raw("select Count(*) as cnt from company where is_profilecompleted=0 $tenant_condition"));
            if(isset($isprofil_c) && !empty($isprofil_c))
            {
                $d1->Incomplete_Profiles=$isprofil_c[0]->cnt;
            } 

            $d1->New_Entity_Connections=0;
            $newfriend_c=DB::select(DB::raw("select count(*) as cnt from friends where recordtype='sender' $tenant_condition"));
            if(isset($newfriend_c) && !empty($newfriend_c))
            {
                $d1->New_Entity_Connections=$newfriend_c[0]->cnt;
            } 
            
            return $d1;
        }

}