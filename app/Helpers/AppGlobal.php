<?php
namespace App\Helpers;

class AppGlobal
{

  public static $Artha_Logo="%%DOMAIN%%/img/email_template_images/artha-logo.png";
  public static $Artha_Contact_Us_Link="http://bememorable.co.uk/";
  public static $Artha_Privacy_Policy_Link="http://bememorable.co.uk/";
  public static $Artha_Company_Name="Artha";
  public static $Artha_Company_Address="United House North Road, Islington London, N7 9DP United Kingdom";
  public static $Artha_Company_Address_ForPDF="United House North Road, <br/>Islington London, <br/>N7 9DP United Kingdom";
  public static $Artha_From_Name="Artha";
  public static $Artha_From_Email="artha@bememorable.co.uk";
  public static $Artha_Twitter="artha@";
  public static $Artha_Facebook="";
  public static $Artha_Linkedin="artha@linkedin";
  public static $Artha_Phone="+44 20 7607 6417";
  public static $Artha_Terms_Condition="Should be paid as soon as received, otherwise a 5% penalty fee is applied ";
  public static $Default_Currency_Code='GBP';
  public static $Default_Currency_Symbol='£';


  public static $twitter_td='<td width="42" align="center"><a href="%%twitter_link%%" style="display: inline-block;"><img alt="" src="%%DOMAIN%%/img/email_template_images/twitter.png" width="28" height="28"></a></td>';
  public static $facebook_td='<td width="38" align="center"><a href="%%facebook_link%%" style="display: inline-block;"><img alt="" src="%%DOMAIN%%/img/email_template_images/facebook.png" width="28" height="28"></a></td>';
  public static $linkedin_td='<td width="34" align="center"><a href="%%linkedin_link%%" style="display: inline-block;"><img alt="" src="%%DOMAIN%%/img/email_template_images/linkedin.png" width="28" height="28"></a></td>';

 public static $MessageEditHours=1;
 public static $MessageDeleteHours=8;
 public static $DisplayMessageCount=500;
 public static $UserProfileImagePath='/storage/user/profileimage/';
 public static $CompanyProfileImagePath='/storage/company/profileimage/';
 public static $DealProfileImagePath='/storage/deal/profileimage/';
 public static $ModulePageSize=2;
 public static $AnswerDocumentPath='/img/pipeline_message_documents/';
 public static $TenantLogoPath='/storage/tenant/logoimage/';
 public static $TenantMiniLogoPath='/storage/tenant/minilogoimage/';
 public static $NetworkPageSize=10;
 public static $MyDealsPageSize=3;
 public static $tenantId='5a1370';


//Email Template Codes Starts
 public static $NewTeamMemberRequest_TemplateCode='NTMR';
 public static $NewFriendRequest_TemplateCode='NFR';
 public static $RequestToJoinDueDiligence_TemplateCode='RTJDD';
 public static $GotInvitationToJoinDueDiligence_TemplateCode='GITJDD';
 public static $TeamMemberRequestAccepted_TemplateCode='TMRA';
 public static $TeamMemberRequestDeclined_TemplateCode='TMRD';
 public static $FriendRequestAccepted_TemplateCode='FRA';
 public static $FriendRequestDeclined_TemplateCode='FRD';

 public static $RequestAcceptedToJoinDueDiligence_TemplateCode='RATJDD';
 public static $RequestRejectedToJoinDueDiligence_TemplateCode='RRTJDD';
 
 public static $InvitationAcceptedToJoinDueDiligence_TemplateCode='IATJDD';
 public static $InvitationRejected_TemplateCode='IR';
 public static $RemovedFromDueDiligence_TemplateCode='RFDD';
 public static $Switch_User_TemplateCode='FPT';

 public static $Welcome_Investor_TemplateCode='WNTI';
 public static $Welcome_Enterprise_TemplateCode='WNTE';
 public static $Welcome_ESOs_TemplateCode='WNTESO';
 public static $Welcome_Third_Party_TemplateCode='WNTTP';

 public static $Welcome_Tenant_TemplateCode='WNTT';

 public static $Tenant_Request_Accepted_ToJoin_Artha_TemplateCode='TRATJAP';
 public static $Tenant_Request_Rejected_ToJoin_Artha_TemplateCode='TRRTJAP';

 public static $Company_Request_Accepted_TemplateCode='NCRA';
 public static $Company_Request_Rejected_TemplateCode='NCRR';

  //My code recent
  public static $CompanyInvite_Request_TemplateCode='NCI';
  public static $TeammemberInvite_Request_TemplateCode='NTI';

  // public static $NewBid_TemplateCode='NBA';
  public static $Bid_Accepted_By_Tender_Owner_TemplateCode='BABTO';
  public static $Bid_Rejected_By_Tender_Owner_TemplateCode='BRBTO';
  public static $Send_Invite_To_Bid_TemplateCode='SITB';
  public static $Send_Final_Bid_Submit_TemplateCode='SFBS';



 
 public static $InvitationCancelledToJoinDueDiligence_TemplateCode='ICTJDD';

 public static $TwitterHandle='https://twitter.com/login/?username_or_email=';
 public static $SkypeHandler='';
 public static $App_Domain='http://phplaravel-86523-494242.cloudwaysapps.com';
 
 //Email Template Codes Ends

 //DD Action Related Global Variables
 public static $DD_deal_Added='A deal is added.';
 public static $DD_started='User %%USER%% has started the Due Diligence.';
 public static $DD_template_changed='User %%USER%% has changed DD template to %%DD_TEMPLATE%%.';
 public static $DD_status_updated='User %%USER%% has updated dd status to %%DD_STATUS%%.';

 public static $DD_question_added='User %%USER%% added a question.';
 public static $DD_question_assigned='User %%USER%% has been assigned a question.';
 public static $DD_question_answered='User %%USER%% has replied on an assigned question.';

 public static $DD_invited_to_join='Company %%COMPANY%% has been invited to join this due diligence.';
 public static $DD_other_requested_to_join='Company %%COMPANY%% has requested to join this due diligence.';

 public static $DD_accepted_invitation_to_join='Company %%COMPANY%% has accepted the invitation to join this due diligence.';
 public static $DD_rejected_invitation_to_join='Company %%COMPANY%% has rejected the invitation to join this due diligence.';

 public static $DD_others_request_to_join_accepted='User %%USER%% has granted access to company %%COMPANY%% for this due diligence.';
 public static $DD_others_request_to_join_rejected='User %%USER%% has rejected the request of company %%COMPANY%% to join due diligence.';

 public static $DD_company_removed_from_dd='User %%USER%% has removed the associated company %%COMPANY%% from the due diligence.';
 //ENd of DD Action Related Variables

 //Switch User Path
 


    public static function fnGet_MessageEditHour()
    {

     return self::$MessageEditHours;
    }

    public static function fnGet_MessageDeleteHour()
    {
     return self::$MessageDeleteHours;
    }

    public static function fnGet_NumberOfMessageToDisplay()
    {
     return self::$DisplayMessageCount;
    }

    public static function fnGet_UserProfileImagePath()
    {
      return self::$UserProfileImagePath;
    }

    public static function fnGet_CompanyProfileImagePath()
    {
      return self::$CompanyProfileImagePath;
    }

    public static function fnGet_ModulePageSize()
    {
      return self::$ModulePageSize;
    }

    public static function fnGet_AnswerDocumentPath()
    {
      return self::$AnswerDocumentPath;
    }

    public static function fnGet_NetworkPageSize()
    {
      return self::$NetworkPageSize;
    }

    public static function fnGet_MyDealsPageSize()
    {
      return self::$MyDealsPageSize;
    }
        public static function fnGet_tenantId()
    {
      return self::$tenantId;
    }


}


