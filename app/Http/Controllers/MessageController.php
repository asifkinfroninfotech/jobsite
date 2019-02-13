<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\MessageRecipient;
use App\Models\Company;
use App\Models\User;
use App\Models\Group;
use App\Models\Usergroup;
use Auth;
use DB;
use View;
use App\Pusher\Pusher;

class MessageController extends Controller
{
/*    public function getmessage()
    {
        
        
        $company= Message::where('tenantid',Session('tenantid'))
                          ->where('userid',Session('userid'))
                          ->with(['message_recipients'=>function($c2){
                              
                              $c2->select('userid','messageid');
                              $c2->with(['user'=>function($c3){$c3->select('userid','firstname','lastname');
                              $c3->with(['usercompany'=>function($c4){$c4->select('userid','companyid');
                               $c4->with(['company'=>function($c5){$c5->select('companyid','name');}]);
                              
                              }]);
                             
                              }]);

                              
                          }]) 

                          
                          ->get();
                          
                          
         

        dd($company);
    }*/


    public function getUserRecentFriends()
    {

/*SELECT distinct groupid FROM message_recipients join messages on message_recipients.messageid = messages.messageid WHERE message_recipients.userid = '$userid' and messages.userid = '$loggedinuserid' or message_recipients.userid = '$loggedinuserid' and messages.userid = '$userid'
      */

$userid=Session('userid');
$companyid=Session('companyid');










      $recentfriends=DB::select( DB::raw("SELECT fr.friendid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.friendid
   LIMIT 1
 ) as company
 FROM `friends` as fr 
 left join users as fu on fu.userid=fr.friendid
  
where fr.userid='$userid' and recordtype='friend'") );
      
      
     
      
      
      
      
      
      
      
      
      $recentfriendteams=DB::select( DB::raw("SELECT fr.userid as friendid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.userid
   LIMIT 1
 ) as company
 FROM usercompanies as fr
 left join users as fu on fu.userid=fr.userid
  
where fr.companyid = '".$companyid."' and fr.userid != '".$userid."' and fr.recordstatus = 'Active'") );      
      
      
      
   $recentfriends=array_unique(array_merge($recentfriends,$recentfriendteams), SORT_REGULAR); 
      
     $totalfriendcount=0;
$totalfriendcount=count($recentfriends); 
      
      
      
      
       
      
      
//dd($recentfriends);
      return view('companymessaging.companymessagingtest',compact('recentfriends','totalfriendcount'));
    }
    
    
    public function getmessageasif(Request $request)
    {
        
        
        $groupid=$request->groupid;

     
      $tenantid=Session('tenantid');
      
      
      $messagedisplaycount=\App\Helpers\AppGlobal::fnGet_NumberOfMessageToDisplay();
      
      
      
      $totalmessagecountfromdb=DB::select(DB::raw("SELECT COUNT(*) as cnt FROM `messages` as m
 join message_recipients as mr on m.messageid =mr.messageid join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from message_recipients as mr
    
    where mr.groupid='$groupid' 
) and m.tenantid='$tenantid'"));
      
      
      
      
      
      
      $totalmessagecount=$totalmessagecountfromdb[0]->cnt;
    $display_loadmore=0;
    if($totalmessagecount<=$messagedisplaycount)
    {
         $display_loadmore=0;
    }
    else
    {
      $display_loadmore=1;
    }

    
    //Fetching Actual Chat Messages.........
  $data=DB::select(DB::raw("SELECT * FROM
    (SELECT m.userid,u.firstname,u.lastname,u.profileimage,m.messagebody,m.created,m.messageid FROM `messages` as m
 join message_recipients as mr on m.messageid =mr.messageid join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from message_recipients as mr
   
    where mr.groupid='$groupid' 
) and m.tenantid='$tenantid' order by m.created DESC LIMIT $messagedisplaycount) as sub Order by created asc"));
                  
   $view=View::make('companymessaging._chat_messages_new',compact('data',
    'totalmessagecount','messagedisplaycount','display_loadmore'))->render();     

      return $view; 
        
        
        
        
        
        
        
        
        
        
        
        
        
        
 //old code for reference       
        
        
//      $groupid=$request->groupid;
///*       $groupid=trim($_POST['recipientid']);*/
//
///*        $chatmessages= MessageRecipient::where('groupid',$recipientid)
//                                  ->where('tenantid',Session('tenantid'))
//                                  ->with(['message'=>function($c1){
//                                  $c1->select('userid','messagebody','messageid','created');
//                                  $c1->with(['user'=>function($c3){$c3->select('userid','firstname','lastname','profileimage');}]);
//                                  }])
//                                  ->with(['user'=>function($c2){
//                                      $c2->select('userid','firstname','lastname','profileimage');
//                                  }])
//                ->get();*/
//
//
//      $chatmessages=DB::table('messages')
//                            ->join('message_recipients','messages.messageid','message_recipients.messageid')
//                            ->join('users','users.userid','messages.userid')
//                            ->where('message_recipients.groupid',$groupid)
//                            ->where('messages.tenantid',Session('tenantid'))
//                            ->select('messages.userid','users.firstname','users.lastname','users.profileimage','messages.messagebody','messages.created')
//                            ->orderBy('created')
//                            ->get();
//
//                               
//                          
//  $view=View::make('companymessaging._chat_messages')->with('data',$chatmessages)->render();     
//
//      return $view;         
                       
/*                        foreach($company as $company)
                        {
                        
                        echo '<div class="chat-message">
                                    <div class="chat-message-content-w">
                                      <div class="chat-message-content">
                                        '.$company->message->messagebody.'
                                      </div>
                                    </div>
                                    <div class="chat-message-avatar">
                                      <img alt="" src="img/avatar3.jpg">
                                    </div>
                                    <div class="chat-message-date">
                                      '.$company->message->created.' 
                                    </div>
                                    <div class="edit-dlt">
                                      <i class="os-icon os-icon-edit-1"></i>
                                      <i class="os-icon os-icon-ui-15"></i>
                                    </div>
                                  </div>';
 
                        }  */                         
                                  
                         
    }
    public function getgroupid()
    {
//        $userid=trim($_POST['userid']);
//        $loggedinuserid=Session('userid');
//  
//        $matchThese = ['message_recipients.userid' => $userid, 'messages.userid' => $loggedinuserid];
//
//// if you need another group of wheres as an alternative:
//$orThose = ['messages.userid' => $loggedinuserid,'message_recipients.userid' => $userid];
////        
////        
//        $group=DB::table('message_recipients')
//                   ->join('messages','messages.messageid','message_recipients.messageid')
//                   ->where($matchThese) 
//                   ->orwhere($orThose)
//                   ->select('message_recipients.groupid')
//                   ->first();
        
        
          $userid=trim($_POST['userid']);
          $loggedinuserid=Session('userid');
          $results = DB::select( DB::raw("SELECT distinct groupid FROM message_recipients join messages on message_recipients.messageid = messages.messageid WHERE message_recipients.userid = '$userid' and messages.userid = '$loggedinuserid' or message_recipients.userid = '$loggedinuserid' and messages.userid = '$userid' ") );
        
        
        
        return response()->json(['groupid'=>$results[0]->groupid]);
    }
    
    public function postnewmessage()
    {
        
        //my pusher code
        
      $cluster=env('PUSHER_APP_CLUSTER',null);
      $key=env('PUSHER_APP_KEY',null);
      $id=env('PUSHER_APP_ID',null);
      $appsecret=env('PUSHER_APP_SECRET',null);  
        
        $options = array(
    'cluster' => $cluster,
    'encrypted' => true
  );
  $pusher = new Pusher(
    $key,
    $appsecret,
    $id,
    $options
  );
  
  //my pusher code
        
        
        $helper= \App\Helpers\AppHelper::instance();
        $userid=Session('userid');
        $receiverid=trim($_POST['userid']);
        $messagetext=trim($_POST['message']);
        $groupid='';
        try{
            
            if(isset($_POST['groupid']) && !empty($_POST['groupid']))
            {
                $groupid=trim($_POST['groupid']);
                
            }
            else
            {
                $groupid=$helper->fnGetUniqueID(16, 'groups', 'groupid');
                  DB::table('groups')->insert(
                  [
                  'groupid' => $groupid , 
                  
                  'tenantid'=> Session('tenantid'),
                  'groupname' => $userid .'-'.$receiverid,
                  'activestatus'=>1,
                  
                  ]
                 );
                
                
               
                  
                  DB::table('usergroups')->insert(
                  [
                  'usergroupid'=>$helper->fnGetUniqueID(16, 'usergroups', 'usergroupid'),
                  'tenantid'=> Session('tenantid'),
                  'groupid' => $groupid , 
                  'userid' => $userid,
                  'activestatus'=>1,
                  
                  ]
                 );
                
                
                  
                  
                  
                
                DB::table('usergroups')->insert(
                  [
                  'usergroupid'=>$helper->fnGetUniqueID(16, 'usergroups', 'usergroupid'),
                  'tenantid'=> Session('tenantid'),
                  'groupid' => $groupid , 
                  'userid' => $receiverid,
                  'activestatus'=>1,
                  
                  ]
                 );
                
                
                
                
            }
            
            $message=new Message();
            $message->messageid=$helper->fnGetUniqueID(16, 'messages', 'messageid');
            
            $message->tenantid=Session('tenantid');
           
            $message->userid=$userid;
             
            $message->subject='';
            $message->messagebody=$messagetext;
            $message->activestatus=1;
            
            $message->save();
            
            
            
            
            $messagerecipient=new MessageRecipient();
            $messagerecipient->recipientid=$helper->fnGetUniqueID(16, 'message_recipients', 'recipientid');
            $messagerecipient->tenantid=Session('tenantid');
            $messagerecipient->userid=$receiverid;
            $messagerecipient->messageid= $message->messageid;
            $messagerecipient->messagestatus=0;
            $messagerecipient->groupid=$groupid;
            $messagerecipient->save();
            
            
             //My pusher code 
       /*   $helper=\App\Helpers\AppHelper::instance();
          
          $data['groupid']=$groupid;
         $data['getuserid']=json_encode($helper->getaltuseridfromgroupid('usergroups', $groupid));*/
//            

         $pushdata['message'] = $groupid;
         $pushdata['senderid']=$userid;
         $pushdata['receiverid']=$receiverid;
         $pusher->trigger('my-channel', 'my-event', $pushdata);

        /* ,'getuserid'=>$data['getuserid']*/
            return response()->json(['groupid'=>$groupid]); 
        } 
        catch (Exception $ex) {
                return response()->json(['groupid'=>'error']);
        }
   
    }
    
    
     //Used To Get Data for LOAD MORE CHATs................
        public function loadMoreMessages(Request $request)
        {
            
          
            
            
            
            $groupid=$request->groupid;
           
            $tenantid=Session('tenantid');
            $messagedisplaycount=\App\Helpers\AppGlobal::fnGet_NumberOfMessageToDisplay();
            $alreadyloaded=$request->alreadyloaded;
            $totalmessagecount=$request->totalmessagecount;
            $firstrecentdate=$request->firstrecentdate;

    $display_loadmore=0;
    if($totalmessagecount<=($messagedisplaycount+$alreadyloaded))
    {
         $display_loadmore=0;
    }
    else
    {
      $display_loadmore=1;
    }

            //Fetching Another Set of Chat Messages.........
  $data=DB::select(DB::raw("SELECT * FROM
    (SELECT m.userid,u.firstname,u.lastname,u.profileimage,m.messagebody,m.created FROM `messages` as m
inner join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from message_recipients as mr
    
    where mr.groupid='$groupid' 
) and m.tenantid='$tenantid' and m.created<'$firstrecentdate' order by m.created DESC LIMIT $messagedisplaycount) as sub Order by created asc"));


  
  
 
            $view=View::make('companymessaging._chat_messages_new',compact('data',
    'totalmessagecount','messagedisplaycount','display_loadmore'))->render();     

      return $view;  


        }
    //getusers
         public function getcompanyusersbysearch(Request $request)
        {
            $user_companyid=Session('companyid');
            $tenantid=Session('tenantid');
            $userid=Session('userid');
            $companyid="'".Session('companyid')."'";
            $searchtext=$request->searchtext;
            
       
            
            
            
            
$involvedusers=DB::select( DB::raw("SELECT fr.friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.friendid
   LIMIT 1
 ) as company
 FROM `friends` as fr 
 left join users as fu on fu.userid=fr.friendid 
 inner join usercompanies as uc  on fu.userid=uc.userid
left join company as c on c.companyid=uc.companyid
 where 
 fr.userid='$userid' and uc.tenantid='$tenantid' and (fu.firstname like '%$searchtext%' or fu.lastname like '%$searchtext%' or c.name like '%$searchtext%')") );
  

      
      
      $involvedusersteams=DB::select( DB::raw("SELECT fr.userid as friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.userid
   LIMIT 1
 ) as company
 FROM usercompanies as fr
 left join company as c on c.companyid=fr.companyid
 left join users as fu on fu.userid=fr.userid
  
where fr.companyid = ".$companyid." and fr.userid != '".$userid."' and fr.recordstatus = 'Active' and fr.tenantid='$tenantid' and (fu.firstname like '%$searchtext%' or fu.lastname like '%$searchtext%' or c.name like '%$searchtext%')") );      
      
      
    
      //echo $involvedusers;
      
   $involvedusers=array_unique(array_merge($involvedusers,$involvedusersteams), SORT_REGULAR);





            
     
            $view=View::make('companymessaging.searched_users',compact('involvedusers'))->render();

           return $view;
        }
        
        
        public function getcompanyusersbycheck(Request $request)
        {
            $user_companyid=Session('companyid');
            $tenantid=Session('tenantid');
            $userid=Session('userid');
            $companyid="'".Session('companyid')."'";
            $array=$request->myarray;
            
   $array="'".$array."'";
if(strstr($array, ','))
{
$array= str_replace(",", "','", $array);
}          
            
 $checksureprev="SELECT fr.friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.friendid
   LIMIT 1
 ) as company
 FROM `friends` as fr 
 left join users as fu on fu.userid=fr.friendid 
 where 
 fr.userid='$userid'";           
    
 
       $checksureprevteams=DB::select( DB::raw("SELECT fr.userid as friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.userid
   LIMIT 1
 ) as company
 FROM usercompanies as fr
 left join company as c on c.companyid=fr.companyid
 left join users as fu on fu.userid=fr.userid
  
where fr.companyid = ".$companyid." and fr.userid != '".$userid."' and fr.recordstatus = 'Active' and fr.tenantid='$tenantid'") );      
      
      
    
      //echo $involvedusers;
      
  
 
 
 
 
 
 
            
     
$checksure="SELECT fr.friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.friendid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.friendid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.friendid
   LIMIT 1
 ) as company
 FROM `friends` as fr 
 left join users as fu on fu.userid=fr.friendid 
 where 
 fr.userid='$userid' and fr.friendid in ($array)";

       $checksureteams=DB::select( DB::raw("SELECT fr.userid as friendid,fu.userid,fu.firstname,fu.lastname,fu.profileimage, 
( 
 SELECT messages.created FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT message_recipients.groupid FROM message_recipients 
 join messages on message_recipients.messageid = messages.messageid 
 WHERE (message_recipients.userid = fr.userid and messages.userid = '$userid') 
 or (message_recipients.userid = '$userid' and messages.userid = fr.userid) 
    ORDER By messages.created DESC
   LIMIT 1 
) 
 as groupid,
 (select name from company as c
  inner join usercompanies as uc on uc.companyid=c.companyid
  where uc.userid=fr.userid
   LIMIT 1
 ) as company
 FROM usercompanies as fr
 left join company as c on c.companyid=fr.companyid
 left join users as fu on fu.userid=fr.userid
  
where fr.companyid = ".$companyid." and fr.userid != '".$userid."' and fr.recordstatus = 'Active' and fr.tenantid='$tenantid' and fr.userid in ($array)") );  





$involvedusers=DB::select( DB::raw($checksure) );
$involvedusers=array_unique(array_merge($involvedusers,$checksureteams), SORT_REGULAR);





$involvedusers1=DB::select( DB::raw($checksureprev) );
$involvedusers1=array_unique(array_merge($involvedusers1,$checksureprevteams), SORT_REGULAR);






     




$view=View::make('companymessaging.searched_users_checked',compact('involvedusers','involvedusers1'))->render();

           return $view;
        }
        
        
        
        
    public function deletecompanymessage(Request $request)
    {
        try
           {
            $helper= \App\Helpers\AppHelper::instance();
            $userid=Session('userid');
            $tenantid=Session('tenantid');

            $messageid=$request->input('messageid');

            DB::table('message_recipients')->where('messageid', $messageid)->where('tenantid',$tenantid)->delete();
            DB::table('messages')->where('messageid', $messageid)->where('tenantid',$tenantid)->delete();

            return response()->json(['message'=>'Success']);  
            }
            catch(Exception $ex)
            {
                return response()->json(['message'=>'Failed']); 
            }
        
        
    }
    
    
       public function updatecompanymessage(Request $request)
        {
            try
            {
             $helper= \App\Helpers\AppHelper::instance();
             $userid=Session('userid');
             $tenantid=Session('tenantid');
 
             $messageid=$request->input('messageid');
             $message=$request->input('message');
 
             DB::table('messages')
            ->where('messageid', $messageid)->where('tenantid',$tenantid)
            ->update(['messagebody' => $message]);
 
             return response()->json(['message'=>'Success']);  
             }
             catch(Exception $ex)
             {
                 return response()->json(['message'=>'Failed']); 
             }
        }
    
        
       public function readmessage(Request $request)
       {
        
           $readuserid=$request->readuserid;
           $ariginaluser=session('userid');
           $companyid=session('companyid');
           $getmessagesusers=DB::select(DB::raw("select messages.messageid from messages,message_recipients where messages.userid in (select friendid from friends where userid = '".$ariginaluser."' ) and message_recipients.userid='".$ariginaluser."' and messages.messageid = message_recipients.messageid and messages.userid='".$readuserid."' "));
           
           if(!isset($getmessagesusers) || empty($getmessagesusers))
           {
           $getmessagesusers1=DB::select(DB::raw("select messages.messageid from messages,message_recipients where messages.userid in (select userid from usercompanies where companyid = '".$companyid."' and userid !='".$ariginaluser."') and message_recipients.userid='".$ariginaluser."' and messages.messageid = message_recipients.messageid and messages.userid='".$readuserid."' "));
           $getmessagesusers=$getmessagesusers1;
           
           }
           //$query="select messages.messageid from messages,message_recipients where messages.userid in (select friendid from friends where userid = '".$ariginaluser."' ) and message_recipients.userid='".$ariginaluser."' and messages.messageid = message_recipients.messageid and messages.userid='".$readuserid."' ";
           foreach($getmessagesusers as $readinguser)
           {
           
                 $messageid = $readinguser->messageid;
                 
                 if(isset($messageid) && !empty($messageid))
           {
          
           $updateme=DB::table('message_recipients')
             
            ->where('messageid', '=', $messageid )       
            ->update([
              'messagestatus'=>'1',
                
               
                
               
             ]);

                 
                
                 
               }
          
           
          
           
       }
       
       //$getmessagescount=DB::select(DB::raw("select count(distinct messages.userid) as count123 from messages,message_recipients where messages.userid in (select friendid from friends where userid = '".$ariginaluser."' ) and message_recipients.userid='".$ariginaluser."' and messages.messageid = message_recipients.messageid and message_recipients.messagestatus = 0"));
       
     $getmessagescount= DB::select(DB::raw("select count(distinct messages.userid) as count123 from messages,message_recipients where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".Session('userid')."') and message_recipients.userid='".Session('userid')."' and message_recipients.messagestatus = '0'")); 
       //echo "select count(distinct messages.userid) as count123 from messages,message_recipients where messages.userid in (select friendid from friends where userid = '".$ariginaluser."' ) and message_recipients.userid='".$ariginaluser."' and messages.messageid = message_recipients.messageid and message_recipients.messagestatus = 0";
       
      
      $getmessagesusers=DB::select(DB::raw("select distinct profileimage,firstname,lastname,users.userid from messages,message_recipients,users where messages.messageid=message_recipients.messageid and messages.userid in (select messages.userid from messages,message_recipients where messages.messageid=message_recipients.messageid and message_recipients.userid='".$ariginaluser."') and message_recipients.userid='".$ariginaluser."' and messages.userid = users.userid and message_recipients.messagestatus = '0'"));
      $view=View::make('companymessaging._show_count_users')->with('getmessagesusers', $getmessagesusers)->render();
       //return $view;
       
       return response()->json(['count'=>$getmessagescount[0]->count123,'view'=>$view]);
       
       
       //return $query;
       
       }
    
}



