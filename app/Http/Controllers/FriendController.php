<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use DB;
use File;
class FriendController extends Controller
{
    public function deleterequest()
    {
        $userid=session('userid'); 
        // Friend::where('friendid',$_POST['delid'])->delete(); 
        $friendid=$_POST['delid'];
        $tenantid=session('tenantid');

        DB::delete("Delete from friends where userid='$userid' and friendid='$friendid' and recordtype='receiver'");
        DB::delete("Delete from friends where userid='$friendid' and friendid='$userid' and recordtype='sender'");
    
     
        $helper= \App\Helpers\AppHelper::instance();
        //Send Email
        $TemplateCode= \App\Helpers\AppGlobal::$FriendRequestDeclined_TemplateCode;
        if(isset($TemplateCode))
        {
            $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
            if(isset($Template))
            {
                $TemplateMaster=DB::table('email_master_templates')->first();
                if(isset($TemplateMaster))
                {
                    $user_sender=DB::select(DB::raw("SELECT * from users as u where u.userid='$userid' and tenantid='$tenantid'"))[0];
                    $user_receiver=DB::select(DB::raw("SELECT * from users as u where u.userid='$friendid' and tenantid='$tenantid'"))[0];

                     $receiver_email=$user_receiver->email;
          
                      $MessageBody=$Template->message;
                      $MessageBody=str_replace("%%RECEIVER%%",$user_receiver->firstname.' '.$user_receiver->lastname,$MessageBody);
                      $MessageBody=str_replace("%%SENDER%%",$user_sender->firstname.' '.$user_sender->lastname,$MessageBody);
                      $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                      $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                      $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
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


        
                       
    }
    
    public function friendrequest()
    {
       $userid=session('userid'); 
       $tenantid=session('tenantid'); 

       

       Friend::where('friendid',$_POST['friendid'])
            ->where('userid',$userid)
            ->where('recordtype','receiver')
            ->update(['recordtype' => "friend"]);
       
       Friend::where('userid',$_POST['friendid'])
            ->where('friendid',$userid)
            ->where('recordtype','sender')
            ->update(['recordtype' => "friend"]);

            $friendid=$_POST['friendid'];

            $helper= \App\Helpers\AppHelper::instance();

            //Send Email
            $TemplateCode= \App\Helpers\AppGlobal::$FriendRequestAccepted_TemplateCode;
            if(isset($TemplateCode))
            {
                $Template=DB::table('email_templates')->where('code',$TemplateCode)->first();
                if(isset($Template))
                {
                    $TemplateMaster=DB::table('email_master_templates')->first();
                    if(isset($TemplateMaster))
                    {
                        $user_sender=DB::select(DB::raw("SELECT * from users as u where u.userid='$userid' and tenantid='$tenantid'"))[0];
                        $user_receiver=DB::select(DB::raw("SELECT * from users as u where u.userid='$friendid' and tenantid='$tenantid'"))[0];

                        $receiver_email=$user_receiver->email;
              
                          $MessageBody=$Template->message;
                          $MessageBody=str_replace("%%RECEIVER%%",$user_receiver->firstname.' '.$user_receiver->lastname,$MessageBody);
                          $MessageBody=str_replace("%%SENDER%%",$user_sender->firstname.' '.$user_sender->lastname,$MessageBody);
                          $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                          $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                          $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
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
    }
    
}
