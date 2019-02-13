<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use session;
use App\Models\Pipelinedeal;
use App\Models\DdModule;
use App\Models\DdQuestion;
use App\Models\DdAnswer;
use App\Models\DdAnswersDocument;
use View;
use Carbon\Carbon;
use App\Pusher\Pusher;
use PDF;
use DB;
use File;

class DueDiligenceController extends Controller
{
       public function getDueDiligenceProcess(Request $request)
        {
            //Asif code
            $userid=session('userid');
            $tenantid=session('tenantid');
            $companyid=session('companyid');

            // $tid='';
            // $cid='';
            // if(isset($request->companyid) && !empty($request->companyid))
            // {
            //     $companyid=$request->companyid;
            //     $cid=$request->companyid;
            //     $userid=DB::select(DB::raw("Select userid from usercompanies where companyid='$cid' AND userrole=0"))[0]->userid;
            // }
            // if(isset($request->tenantid) && !empty($request->tenantid))
            // {
            //     $tenantid=$request->tenantid;
            //     $tid=$request->tenantid;
            // }


            $adminrole=-1;
            $results = DB::select( DB::raw("SELECT usercompanies.userrole FROM usercompanies WHERE usercompanies.userid = '$userid' and usercompanies.recordstatus='Active'") );
            $adminrole=$results[0]->userrole;
            
          
           
    
          $pipelinedealid=$request->pd;//'7545871e21fc11e8';
          

          if (isset($pipelinedealid) && !empty($pipelinedealid)) 
          {
            $is_parent=DB::select(DB::raw("SELECT (case when pipelinedealid='$pipelinedealid' then 'Yes' else 'No' end) as Is_Parent FROM `pipelinedeals` WHERE companyid='$companyid' and (pipelinedealid='$pipelinedealid' or parentpipelinedealid='$pipelinedealid') and tenantid='$tenantid'"));
           $modules=DdModule::where('pipelinedealid',$pipelinedealid)->where('modulestatus','!=','Deleted')->with('pipelinedeal')->with('dd_question')->orderby('displayorder')
           ->get();

           $companydata=DB::table('company')
           ->where('companyid',$companyid)
           ->select('company.name')
           ->first();

   
           return view('duediligence.process.duediligence_process',compact('modules','companydata','pipelinedealid','adminrole','is_parent'));
           }
        
        }

        public function getDueDiligenceDashboard(Request $request)
        {
            
            $calledfrom=$request->calledfrom;
            
            $companyid=session('companyid');
            $tenantid=session('tenantid');
            $tid='';
            $cid='';
            if(isset($request->companyid) && !empty($request->companyid))
            {
                $companyid=$request->companyid;
                $cid=$request->companyid;
            }
            if(isset($request->tenantid) && !empty($request->tenantid))
            {
                $tenantid=$request->tenantid;
                $tid=$request->tenantid;
            }


            $pipelinedealid=$request->pd;

            
            
            if (isset($pipelinedealid) && !empty($pipelinedealid)) 
            {
                $is_parent=DB::select(DB::raw("SELECT (case when pipelinedealid='$pipelinedealid' then 'Yes' else 'No' end) as Is_Parent FROM `pipelinedeals` WHERE companyid='$companyid' and (pipelinedealid='$pipelinedealid' or parentpipelinedealid='$pipelinedealid') and tenantid='$tenantid'"));

                $pipelinedeal_info=DB::select(DB::raw("select d.dealid,d.projectname,pd.pipelinedealid,pd.pipelinedealstatus,pd.startdate,pd.completeddate,c.name as dealcompany,c.statusmessage,d.totalinvestmentrequired,d.totalviews,d.investmentstage,d.updated as created,cn.name as country,cu.symbol from pipelinedeals as pd
                JOIN deals as d on d.dealid=pd.dealid
                JOIN company as c on c.companyid=d.companyid
                LEFT join country as cn on cn.countryid=c.countryid
                LEFT JOIN currency as cu on cu.currencyid=d.currencyid
                where pd.pipelinedealid='$pipelinedealid' and pd.tenantid='$tenantid'"));

                // $pd_progress=DB::select(DB::raw("SELECT 
                // (select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid')) as TotalTasks, 
                
                // (select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid') and questionstatus='Pending') as PendingTasks,
                
                //  CAST((((select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid') and userid IS NOT NULL )/(select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid')))*100) AS SIGNED) as AssignedPercent,
                 
                //  CAST((((select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid') and userid IS NOT NULL and questionstatus='Completed')/(select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid')))*100) AS SIGNED) as CompletedPercent, (select count(*) from dd_questions where moduleid in (select moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted' and tenantid='$tenantid') and questionstatus='Pending' and userid IS NOT NULL) as InprogressTasks"));

                 $pd_progress=DB::select(DB::raw("SELECT pd.pipelinedealid,
                 (select Count(*) from dd_questions where pipelinedealid=pd.pipelinedealid) as tquestions ,
                 (select Count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and questionstatus='Completed') as completedquestions, 
                 (select count(*) from dd_questions where pipelinedealid=pd.pipelinedealid and questionstatus='Pending' and userid is not null)  as progress 
                 FROM pipelinedeals as pd where pd.pipelinedealid ='$pipelinedealid'"));

                $dealid=$pipelinedeal_info[0]->dealid;

                $deals_sdgs=DB::table('deal_sdgs as ds')
                ->join('sdg_master as m','m.sdgid','ds.sdgid') 
                ->where('ds.dealid', $dealid)
                ->select('ds.dealid','m.sdg')
                ->get();

                $involved_Companies=DB::select(DB::raw("
                SELECT companyid,'Parent' as type FROM `pipelinedeals` WHERE 
                pipelinedealid='$pipelinedealid' AND IsPermissionDenied=0
                UNION 
                SELECT companyid,'Associates' as type FROM `pipelinedeals` WHERE 
                parentpipelinedealid='$pipelinedealid'  AND IsPermissionDenied=0
                UNION
                Select companyid,'Owner' as type from deals where dealid=(select dealid from pipelinedeals where pipelinedealid='$pipelinedealid') 
                UNION
                Select companyid,status as type from draft_pipelinedeals where pipelinedealid='$pipelinedealid'
                "));

               $cids="";
               foreach ($involved_Companies as $key => $value) {

                if ($cids=="")
                {
                 $cids=$value->companyid;
                }
                else
                {
                 $cids=$cids.",". $value->companyid;
                }
            }

             $involved_companies_with_admin_users=DB::table('usercompanies as uc')
             ->join('users as u','u.userid','uc.userid')
             ->join('company as c','c.companyid','uc.companyid')
             ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
             ->whereIn('uc.companyid', explode(',', $cids))
             ->where('uc.recordstatus','Active')
             ->where('uc.userrole',0)
             ->select('uc.userid','u.firstname','u.lastname','c.companyid','c.profileimage','c.name as company','ct.companytype','c.name as type','uc.userrole as sorttype')
             ->get();

             $all_users=DB::table('usercompanies as uc')
             ->join('users as u','u.userid','uc.userid')
             ->whereIn('uc.companyid', explode(',', $cids))
             ->where('uc.recordstatus','Active')
             ->select('uc.userid','u.firstname','u.lastname','u.profileimage')
             ->get();

             foreach ($involved_companies_with_admin_users as $k => $icwau) {
                foreach ($involved_Companies as $key => $value) {

if($icwau->companyid==$value->companyid)
{
    $icwau->type=$value->type;
    if($value->type=='Owner')
    {
        $icwau->sorttype=0;
    }
    else if($value->type=='Parent')
    {
        $icwau->sorttype=1;
    }
    else if($value->type=='Associates')
    {
        $icwau->sorttype=2;
    }
    else if ($value->type=='Invited')
    {
        $icwau->sorttype=3;
    }
    else if ($value->type=='New Request')
    {
        $icwau->sorttype=4;
    }
}
                }
             }

             $involved_companies_with_admin_users=collect($involved_companies_with_admin_users)->sortBy('sorttype')->toArray();


             $pdealposition=DB::select(DB::raw("SELECT (SELECT count(*) from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted') as Modules, (SELECT Count(*) from dd_questions where moduleid in (SELECT moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted') and questionstatus='Pending') as Pending, (SELECT Count(*) from dd_questions where moduleid in (SELECT moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted') and questionstatus='Completed') as Completed,Cast(((SELECT Count(*) from dd_questions where moduleid in (SELECT moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted') and questionstatus='Completed')/(SELECT Count(*) from dd_questions where moduleid in (SELECT moduleid from dd_modules where pipelinedealid='$pipelinedealid' and modulestatus<>'Deleted'))*100) AS SIGNED) as completedpercentage"));  
             $assignments=DB::select(DB::raw("SELECT m.moduleid,m.modulename, (select count(*) from dd_questions where moduleid=m.moduleid) as TotalTasks, (select count(*) from dd_questions where moduleid=m.moduleid and questionstatus='Pending') as PendingTasks 
             ,CAST((((select count(*) from dd_questions where moduleid=m.moduleid and userid IS NOT NULL )/(select count(*) from dd_questions where moduleid=m.moduleid))*100) AS SIGNED) as AssignedPercent
             ,CAST((((select count(*) from dd_questions where moduleid=m.moduleid and userid IS NOT NULL and questionstatus='Completed')/(select count(*) from dd_questions where moduleid=m.moduleid))*100) AS SIGNED) as CompletedPercent
             FROM dd_modules as m where m.pipelinedealid='$pipelinedealid' and m.modulestatus<>'Deleted' and m.tenantid='$tenantid' ORDER BY TotalTasks DESC LIMIT 5"));

        $helper= \App\Helpers\AppHelper::instance();
        $All_Associated_company=$helper->get_All_Associated_Companies("'".$pipelinedealid."'");
        // if(isset($All_Associated_company) && !empty($All_Associated_company))
        // {
        //  $All_Associated_company=json_encode($All_Associated_company);
        // }  

        $pipelinedealobj=DB::table('pipelinedeals')->where('tenantid',$tenantid)->where('pipelinedealid',$pipelinedealid)->first();
        // $templates=DB::table('dd_templates')->where('tenantid',$tenantid)->where('type','Tenant')->get();
        // ->where('companyid',$pipelinedealobj->companyid)
        $t1=DB::table('dd_templates')->where('tenantid',$tenantid)->where('type','Tenant');
        $templates=DB::table('dd_templates')->where('tenantid',$tenantid)
        ->where('type','Company')
        ->where('companyid',$companyid)
        ->union($t1)->get();
        // $templates=$t1->union($t2)->get();




        $dd_status=DB::table('dd_status')->get();
             
             
             return view('duediligence.dashboard.dashboard',compact('pipelinedealid','involved_companies_with_admin_users','pdealposition','assignments','pipelinedeal_info','deals_sdgs','pd_progress','all_users','is_parent','All_Associated_company','pipelinedealobj','templates','calledfrom','cid','tid','dd_status'));


            }




            
        }



        public function getModuleQuestions(Request $request)
        {
            
            $userid=session('userid');
            $companyid=session('companyid');
            $pipelinedealid=$request->pipelinedealid;
            $tenantid=session('tenantid');
            // $adminrole=-1;
            // $results = DB::select( DB::raw("SELECT usercompanies.userrole FROM usercompanies WHERE usercompanies.userid = '$userid' and usercompanies.recordstatus='Active'") );
            // $adminrole=$results[0]->userrole;
            $is_parent=DB::select(DB::raw("SELECT (case when pipelinedealid='$pipelinedealid' then 'Yes' else 'No' end) as Is_Parent FROM `pipelinedeals` WHERE companyid='$companyid' and (pipelinedealid='$pipelinedealid' or parentpipelinedealid='$pipelinedealid') and tenantid='$tenantid'"));
            
            $moduleid=$request->moduleid;//Input::get('moduleid');
            $questions=DdQuestion::where('moduleid',$moduleid)
            ->with(['user' => function($c)
                    {
                    $c->select('userid','firstname','lastname','profileimage');
                    }])
                ->get();

            $view=View::make('duediligence.process._support_ticket')->with('data',$questions)->with('is_parent',$is_parent)->render();

            return $view;
            //view('investor._support_ticket',compact('questions'));
        }


        public function getQuestionAnswers(Request $request)
        {
          $questionid=$request->questionid;
          $pipelinedealid=$request->pipelinedealid;
          $tenantid=session('tenantid');
          $companyid=session('companyid');

          $is_parent=DB::select(DB::raw("SELECT (case when pipelinedealid='$pipelinedealid' then 'Yes' else 'No' end) as Is_Parent FROM `pipelinedeals` WHERE companyid='$companyid' and (pipelinedealid='$pipelinedealid' or parentpipelinedealid='$pipelinedealid') and tenantid='$tenantid'"));
          $questiontext=DdQuestion::where('questionid',$questionid)->first();
          $answers=DdAnswer::where('questionid',$questionid)->where('answerstatus','!=','Deleted')
                    ->with('dd_question')
                    ->with('dd_answers_documents')
                    ->with(['user' => function($c)
                    {
                    $c->select('userid','firstname','lastname','profileimage');
                    }])
                    ->orderBy('updated', 'desc')->orderBy('updated', 'desc')
                ->get();
          
          $view=View::make('duediligence.process._diligence_process_previous_reply')->with('data',$answers)->with('is_parent',$is_parent)->with('questiontext',$questiontext)->render();

            return $view;
        }


        public function postNewAnswer(Request $request)
        {
          $helper=\App\Helpers\AppHelper::instance();

           $currentquestion = DdQuestion::where('questionid',$request->input('questionid'))
           ->first();

        //    if($currentquestion!=null)
        //    {
        //       $currentquestion->updated =Carbon::now();
        //       $currentquestion->questionstatus='Completed';
        //       $currentquestion->save();
        //    }

           $answer=new DdAnswer();
           $answer->tenantid=Session('tenantid');
           $answer->answerid=$helper->fnGetUniqueID('16','dd_answers','answerid');
           /*'78g7iko67ncxumdj';*/
           $answer->userid=Session('userid');
           $answer->answertext=$request->input('message');
           $answer->answerstatus='Active';
           $answer->displayorder=$helper->fnMaxDisplayOrder('dd_answers','displayorder');
           $answer->questionid=$request->input('questionid');
           $answer->save();

           $pipelinedealid=$request->pipelinedealid;
           $userid=session('userid');
           $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
           if(isset($user_obj))
           {
            $actiontaken=\App\Helpers\AppGlobal::$DD_question_answered;
            $name=$user_obj->firstname.' '.$user_obj->lastname;  
            $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
            $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
            $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
           }

          foreach ($request->files as $file) 
          {

               try {
                 $extension = $file->getClientOriginalExtension();

                   $mime = $file->getClientMimeType();
                   $fn_originalname = $file->getClientOriginalName();
                  /* $fn_without_ext = pathinfo($filename_with_ext, PATHINFO_FILENAME);*/
                   
                   $document_application_name=$helper->fnGetUniqueID('16','dd_answers_documents','document_application_name');
                   $document_application_name = $document_application_name.'.'.$extension;
                   $file->move('img/pipeline_message_documents', $document_application_name);
                  
                  $answer_document=new DdAnswersDocument();
                  $answer_document->documentid=$helper->fnGetUniqueID('16','dd_answers_documents','documentid');
                  $answer_document->answerid=$answer->answerid;
                  $answer_document->documentname=$fn_originalname;
                  $answer_document->document_application_name=$document_application_name;
                  $answer_document->documenttype=$extension;
                  $answer_document->userid=Session('userid');
                  $answer_document->tenantid=Session('tenantid');
                  $answer_document->documentstatus='Active';
                  $answer_document->displayorder=$helper->fnMaxDisplayOrder('dd_answers_documents','displayorder');
                  $answer_document->save();

               } catch (Exception $e) {
                 
               }
            }


       

            return response()->json(['Success'=>true]);

        }


        public function searchQuestions(Request $request)
        {
             $moduleid=$request->moduleid;
             $searchtext=$request->searchtext;

            $questions=DdQuestion::where('moduleid',$moduleid)
            ->Where('questiontext', 'like', '%' . $searchtext . '%')
            ->orWhere('questionstatus','like', '%' . $searchtext . '%')
            ->with(['user' => function($c)
                    {
                    $c->select('userid','firstname','lastname','profileimage');
                    }])
                ->get();


            $view=View::make('duediligence.process._support_ticket')->with('data',$questions)->render();

            return $view;


        }

       public function test()
       {
         $helper= \App\Helpers\AppHelper::instance();
         $userid=Session('userid');
         $tenantid=Session('tenantid');
         $pipelinedealid='7545871e21fc11e8';
         $groupid='hf41vhickypqac1o';
                   $totalmessagecount=DB::select(DB::raw("SELECT COUNT(*) as cnt FROM `pipelinedeal_messages` as m
inner join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from pipelinedeal_message_recipients as mr
    inner join pipelinedeal_message_groups as g on g.groupid=mr.groupid
    where g.groupid='$groupid' and g.pipelinedealid='$pipelinedealid'
) and m.tenantid='$tenantid'"));

        dd($totalmessagecount);
       }


        public function getDealMessaging(Request $request)
        {

            $user_companyid=Session('companyid');
            $tenantid=Session('tenantid');
            $companydata=DB::table('company')
                             ->where('companyid',$user_companyid)
                             ->select('company.name')
                             ->first();
            $userid=Session('userid');
            $companyid="'".Session('companyid')."'";
            $pipelinedealid=$request->pd;//'7545871e21fc11e8';

            $enterprise=DB::select(DB::raw("select companyid from deals where dealid=
              (select dealid from pipelinedeals where pipelinedealid='$pipelinedealid')"));


            $enterprisecompany="'".$enterprise[0]->companyid."'";

            $involvedcompanies=$companyid.',' .$enterprisecompany;

            $involved_Companies=DB::select(DB::raw("
            SELECT companyid,'Parent' as type FROM `pipelinedeals` WHERE 
            pipelinedealid='$pipelinedealid' AND IsPermissionDenied=0
            UNION 
            SELECT companyid,'Associates' as type FROM `pipelinedeals` WHERE 
            parentpipelinedealid='$pipelinedealid'  AND IsPermissionDenied=0
            UNION
            Select companyid,'Owner' as type from deals where dealid=(select dealid from pipelinedeals where pipelinedealid='$pipelinedealid') 
            "));

           $cids="";
           foreach ($involved_Companies as $key => $value) {

            if ($cids=="")
            {
             $cids="'".$value->companyid."'";
            }
            else
            {
             $cids=$cids.","."'".$value->companyid."'";
            }
        }


      $involvedusers=DB::select(DB::raw("select u.userid,u.firstname,u.lastname,u.profileimage,
( 
 SELECT m.created FROM pipelinedeal_message_recipients as mr 
 join pipelinedeal_messages as m on m.messageid = mr.messageid 
 join pipelinedeal_message_groups as g on g.groupid=mr.groupid   
 WHERE g.grouptype='Individual' AND ((mr.userid = uc.userid and m.userid = '$userid') 
 or (mr.userid = '$userid' and m.userid = uc.userid)) 
    ORDER By m.created DESC
   LIMIT 1 
) 
 as lastmessagetime ,
 ( 
 SELECT mr.groupid FROM pipelinedeal_message_recipients as mr
 join pipelinedeal_messages as m on mr.messageid = m.messageid 
 join pipelinedeal_message_groups as g on g.groupid=mr.groupid
 WHERE g.grouptype='Individual' AND  ((mr.userid = uc.userid and m.userid = '$userid') 
 or (mr.userid = '$userid' and m.userid = uc.userid)) 
    ORDER By m.created DESC
   LIMIT 1 
) 
 as groupid
,c.name as company
from usercompanies as uc 
inner join users as u on u.userid=uc.userid
left join company as c on c.companyid=uc.companyid
where uc.companyid in ($cids) and uc.userid<>'$userid' and uc.tenantid='$tenantid' and uc.recordstatus='Active'") );  


  
   $generalgroupdetail=DB::select(DB::raw("Select g.groupid,g.groupname,
     ( 
 SELECT m.created FROM pipelinedeal_message_recipients as mr 
 join pipelinedeal_messages as m on m.messageid = mr.messageid 
WHERE mr.groupid=g.groupid
ORDER By m.created DESC
   LIMIT 1 
) 
 as lastmessagetime,c.name as company,c.profileimage
  from pipelinedeal_message_groups as g
 inner join pipelinedeals as pd on pd.pipelinedealid=g.pipelinedealid 
 inner join company as c on c.companyid=pd.companyid
 where g.pipelinedealid='$pipelinedealid' and g.tenantid='$tenantid' and g.grouptype='General'"));
               
                            
return view('duediligence.messaging.pipelinedeal_messaging',compact('companydata','involvedusers','pipelinedealid','generalgroupdetail'));
        }

       /*Used to get all the conversation from a particular group.....*/  
        public function getmessageconversation(Request $request)
        {
              $groupid=$request->groupid;
              $pipelinedealid=$request->pipelinedealid;
              $tenantid=Session('tenantid');

              $messagedisplaycount=\App\Helpers\AppGlobal::fnGet_NumberOfMessageToDisplay();

//Retrieving the total count of records......
    $totalmessagecountfromdb=DB::select(DB::raw("SELECT COUNT(*) as cnt FROM `pipelinedeal_messages` as m
inner join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from pipelinedeal_message_recipients as mr
    inner join pipelinedeal_message_groups as g on g.groupid=mr.groupid
    where g.groupid='$groupid' and g.pipelinedealid='$pipelinedealid'
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
    (SELECT m.userid,u.firstname,u.lastname,u.profileimage,m.messagebody,m.created,m.messageid FROM `pipelinedeal_messages` as m
inner join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from pipelinedeal_message_recipients as mr
    inner join pipelinedeal_message_groups as g on g.groupid=mr.groupid
    where g.groupid='$groupid' and g.pipelinedealid='$pipelinedealid'
) and m.tenantid='$tenantid' order by m.created DESC LIMIT $messagedisplaycount) as sub Order by created asc"));
                  
   $view=View::make('duediligence.messaging._chat_messages',compact('data',
    'totalmessagecount','messagedisplaycount','display_loadmore','groupid'))->render();     

      return $view;         
        }



       //Used To Get Data for LOAD MORE CHATs................
        public function loadMoreDealMessages(Request $request)
        {
            $groupid=$request->groupid;
            $pipelinedealid=$request->pipelinedealid;
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
    (SELECT m.userid,u.firstname,u.lastname,u.profileimage,m.messagebody,m.created,m.messageid FROM `pipelinedeal_messages` as m
inner join users as u on u.userid=m.userid
WHERE m.messageid in (
    select DISTINCT messageid from pipelinedeal_message_recipients as mr
    inner join pipelinedeal_message_groups as g on g.groupid=mr.groupid
    where g.groupid='$groupid' and g.pipelinedealid='$pipelinedealid'
) and m.tenantid='$tenantid' and m.created<'$firstrecentdate' order by m.created DESC LIMIT $messagedisplaycount) as sub Order by created asc"));


            $view=View::make('duediligence.messaging._chat_messages',compact('data',
    'totalmessagecount','messagedisplaycount','display_loadmore','groupid'))->render();     

      return $view;  


        }


        /*Used to Post New Messages posted by Users for a particular Pipeline Deal*/
       
        public function postpipelinedealnewmessage(Request $request)
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
                  $tenantid=Session('tenantid');

                  $receiverid=$request->input('userid');//trim($_POST['userid']);
                  $messagetext=$request->input('message');//trim($_POST['message']);
                  $pipelinedealid=$request->input('pipelinedealid');//trim($_POST['pipelinedealid']);
                  $groupid=$request->input('groupid');
        try
        {
            
            if(isset($groupid) && !empty($groupid))
            {
                $groupid=$groupid;//trim($_POST['groupid']);
                
            }
            else
            {

              $groupid=$helper->fnGetUniqueID(16, 'pipelinedeal_message_groups', 'groupid');

                DB::table('pipelinedeal_message_groups')->insert(
                  [
                  'groupid' => $groupid, 
                  'pipelinedealid' => $pipelinedealid,
                  'tenantid'=> Session('tenantid'),
                  'groupname' => $userid .'-'.$receiverid,
                  'activestatus'=>'Active',
                  'grouptype' => 'Individual'
                  ]
                 );

                 DB::table('pipelinedeal_message_usergroups')->insert(
                  [
                  'usergroupid' => $helper->fnGetUniqueID(16, 'pipelinedeal_message_usergroups', 'usergroupid'), 
                  'pipelinedealid' => $pipelinedealid,
                  'tenantid'=> Session('tenantid'),
                  'groupid' => $groupid,
                  'userid' => $userid,
                  'activestatus'=>'Active'
                  ]
                 );
                
              
                 DB::table('pipelinedeal_message_usergroups')->insert(
                  [
                  'usergroupid' => $helper->fnGetUniqueID(16, 'pipelinedeal_message_usergroups', 'usergroupid'), 
                  'pipelinedealid' => $pipelinedealid,
                  'tenantid'=> Session('tenantid'),
                  'groupid' => $groupid,
                  'userid' => $receiverid,
                  'activestatus'=>'Active'
                  ]
                 );
              
            }
            
            $newmessageid=$helper->fnGetUniqueID(16, 'pipelinedeal_messages', 'messageid');
            /*Create a New Message Now*/
            DB::table('pipelinedeal_messages')->insert(
                  [
                  'pipelinedealid' => $pipelinedealid,
                  'messageid' => $newmessageid,
                  'tenantid'=> Session('tenantid'),
                  'userid' => $userid,
                  'subject' => '',
                  'messagebody' => $messagetext,
                  'activestatus'=>'Active'
                  ]
                 );
            
            
          $groupdetail=DB::table('pipelinedeal_message_groups')
                         ->where('groupid',$groupid)
                         ->first(); 
            
             if($groupdetail->grouptype=='General')
             {
                 $companyid="'".Session('companyid')."'";
                 
                 $enterprise=DB::select(DB::raw("select companyid from deals where dealid=
              (select dealid from pipelinedeals where pipelinedealid='$pipelinedealid')"));
                
                 $enterprisecompany="'".$enterprise[0]->companyid."'";
                 $involvedcompanies=$companyid.',' .$enterprisecompany;
                 
                 $generalgroupusers=DB::select(DB::raw("select uc.userid
                 from usercompanies as uc 
                 where uc.companyid in ($involvedcompanies) and uc.userid<>'$userid' 
                 and uc.tenantid='$tenantid'") );  

                $data=[];
                 foreach ($generalgroupusers as $key => $receiver) 
                 {
                  array_push($data,array('recipientid' => $helper->fnGetUniqueID(16,
                    'pipelinedeal_message_recipients', 'recipientid'),
                    'tenantid' => Session('tenantid'),
                    'userid' => $receiver->userid,
                    'messageid' => $newmessageid,
                    'groupid' => $groupid,
                    'messagestatus' => 'Unread'
                  ));
                 }
                  
/*                foreach ($generalgroupusers as $key) {
                    array_push($data,array('recipientid' => $helper->fnGetUniqueID(16,
                    'pipelinedeal_message_recipients', 'recipientid'),
                    'tenantid' => Session('tenantid'),
                    'userid' => $key->userid,
                    'messageid' => $newmessageid,
                    'groupid' => $groupid,
                    'messagestatus' => 'Unread'
                  ));
                 }*/

                /* array_push($data,array('recipientid' => $helper->fnGetUniqueID(16,
                    'pipelinedeal_message_recipients', 'recipientid'),
                    'tenantid' => Session('tenantid'),
                    'userid' => 'asdfg2323asddsai',
                    'messageid' => $newmessageid,
                    'groupid' => $groupid,
                    'messagestatus' => 'Unread'
                  ));
               
                array_push($data,array('recipientid' => $helper->fnGetUniqueID(16,
                    'pipelinedeal_message_recipients', 'recipientid'),
                    'tenantid' => Session('tenantid'),
                    'userid' => 'asdfg2323asddsaw',
                    'messageid' => $newmessageid,
                    'groupid' => $groupid,
                    'messagestatus' => 'Unread'
                  ));

              array_push($data,array('recipientid' => $helper->fnGetUniqueID(16,
                    'pipelinedeal_message_recipients', 'recipientid'),
                    'tenantid' => Session('tenantid'),
                    'userid' => '8A33CA305E4A64B7',
                    'messageid' => $newmessageid,
                    'groupid' => $groupid,
                    'messagestatus' => 'Unread'
                  ));*/
         DB::table('pipelinedeal_message_recipients')->insert($data); // Query Builder approach



/*                 
                 foreach ($generalgroupusers as $key => $receiver) 
                 {
                  DB::table('pipelinedeal_message_recipients')->insert(
                  [
                  'recipientid' => $helper->fnGetUniqueID(16, 'pipelinedeal_message_recipients', 'recipientid'),
                  'tenantid'=> Session('tenantid'),
                  'userid' => $receiver->userid,
                  'messageid' => $newmessageid,
                  'groupid' => $groupid,
                  'messagestatus' => 'Unread'
                  ]
                 );
                 }*/


             }
             else if($groupdetail->grouptype=='Individual')
             {
                  
                  DB::table('pipelinedeal_message_recipients')->insert(
                  [
                  'recipientid' => $helper->fnGetUniqueID(16, 'pipelinedeal_message_recipients', 'recipientid'),
                  'tenantid'=> Session('tenantid'),
                  'userid' => $receiverid,
                  'messageid' => $newmessageid,
                  'groupid' => $groupid,
                  'messagestatus' => 'Unread'
                  ]
                 );
             }          
            
           
            
        //pusher-code
         $pushdata['message'] = $groupid;
         $pushdata['grouptype']=$groupdetail->grouptype;
         $pushdata['senderid']=$userid;
         $pushdata['receiverid']=$receiverid;
        
         $pusher->trigger('my-channel', 'my-event', $pushdata);
            
        //pusher 
            
           return response()->json(['groupid'=>$groupid]);  
        } 
        catch (Exception $ex) {
                return response()->json(['groupid'=>'error']);
        }
        }

        // This method is used to delete a particular message by messageid
        public function deletepipelinedealmessage(Request $request)
        {
           try
           {
            $helper= \App\Helpers\AppHelper::instance();
            $userid=Session('userid');
            $tenantid=Session('tenantid');

            $messageid=$request->input('messageid');

            DB::table('pipelinedeal_message_recipients')->where('messageid', $messageid)->where('tenantid',$tenantid)->delete();
            DB::table('pipelinedeal_messages')->where('messageid', $messageid)->where('tenantid',$tenantid)->delete();

            return response()->json(['message'=>'Success']);  
            }
            catch(Exception $ex)
            {
                return response()->json(['message'=>'Failed']); 
            }

        }

        public function updatepipelinedealmessage(Request $request)
        {
            try
            {
             $helper= \App\Helpers\AppHelper::instance();
             $userid=Session('userid');
             $tenantid=Session('tenantid');
 
             $messageid=$request->input('messageid');
             $message=$request->input('message');
 
             DB::table('pipelinedeal_messages')
            ->where('messageid', $messageid)->where('tenantid',$tenantid)
            ->update(['messagebody' => $message]);
 
             return response()->json(['message'=>'Success']);  
             }
             catch(Exception $ex)
             {
                 return response()->json(['message'=>'Failed']); 
             }
        }

        public function getpipelinedealusersbysearch(Request $request)
        {
            $user_companyid=Session('companyid');
            $tenantid=Session('tenantid');
            $userid=Session('userid');
            $companyid="'".Session('companyid')."'";
            $pipelinedealid=$request->pipelinedealid;
            $searchtext=$request->searchtext;

            $enterprise=DB::select(DB::raw("select companyid from deals where dealid=
              (select dealid from pipelinedeals where pipelinedealid='$pipelinedealid')"));


            $enterprisecompany="'".$enterprise[0]->companyid."'";

            $involvedcompanies=$companyid.',' .$enterprisecompany;
            

            $involvedusers=DB::select(DB::raw("select u.userid,u.firstname,u.lastname,u.profileimage,
            ( 
             SELECT m.created FROM pipelinedeal_message_recipients as mr 
             join pipelinedeal_messages as m on m.messageid = mr.messageid 
             join pipelinedeal_message_groups as g on g.groupid=mr.groupid   
             WHERE g.grouptype='Individual' AND ((mr.userid = uc.userid and m.userid = '$userid') 
             or (mr.userid = '$userid' and m.userid = uc.userid)) 
                ORDER By m.created DESC
               LIMIT 1 
            ) 
             as lastmessagetime ,
             ( 
             SELECT mr.groupid FROM pipelinedeal_message_recipients as mr
             join pipelinedeal_messages as m on mr.messageid = m.messageid 
             join pipelinedeal_message_groups as g on g.groupid=mr.groupid
             WHERE g.grouptype='Individual' AND  ((mr.userid = uc.userid and m.userid = '$userid') 
             or (mr.userid = '$userid' and m.userid = uc.userid)) 
                ORDER By m.created DESC
               LIMIT 1 
            ) 
             as groupid
            ,c.name as company
            from usercompanies as uc 
            inner join users as u on u.userid=uc.userid
            left join company as c on c.companyid=uc.companyid
            where uc.companyid in ($involvedcompanies) and uc.userid<>'$userid' and uc.tenantid='$tenantid' and (u.firstname like '%$searchtext%' or u.lastname like '%$searchtext%' or c.name like '%$searchtext%') ") );  
            
            
              
               $generalgroupdetail=DB::select(DB::raw("Select g.groupid,g.groupname,
                 ( 
             SELECT m.created FROM pipelinedeal_message_recipients as mr 
             join pipelinedeal_messages as m on m.messageid = mr.messageid 
            WHERE mr.groupid=g.groupid
            ORDER By m.created DESC
               LIMIT 1 
            ) 
             as lastmessagetime,c.name as company,c.profileimage
              from pipelinedeal_message_groups as g
             inner join pipelinedeals as pd on pd.pipelinedealid=g.pipelinedealid 
             inner join company as c on c.companyid=pd.companyid
             where g.pipelinedealid='$pipelinedealid' and g.tenantid='$tenantid' and g.grouptype='General'"));


           $view=View::make('duediligence.messaging._pipelinedeal_users',compact('involvedusers','generalgroupdetail'))->render();

           return $view;
        }


        public function getmodulestoedit(Request $request)
        {
            $tenantid=Session('tenantid');
            $userid=Session('userid');
            $pipelinedealid=$request->pipelinedealid;
         
            $modulepagesize= \App\Helpers\AppGlobal::fnGet_ModulePageSize();

            $lstmodules=DDModule::where('tenantid',$tenantid)
                        ->where('pipelinedealid',$pipelinedealid)
                        ->where('modulestatus','!=','Deleted')
                        ->orderBy('displayorder')
                        ->get();
                        // ->paginate($modulepagesize);

            $statusvalues=array('value'=>array('Active','In-Active'));

            $view=View::make('duediligence.process._module_list',compact('lstmodules','statusvalues'))->render();
            return $view;
        }


        public function updatemodules(Request $request)
        {
            $tenantid=Session('tenantid');
            // $now = new \DateTime();
            $modules=json_decode($request->modulelist, true);
                foreach ($modules as $value => $key ) {
                    DB::table('dd_modules')
                    ->where('moduleid', $key['moduleid'])->where('tenantid',$tenantid)
                    ->update(['modulename' => $key['name'], 'modulestatus' => $key['modulestatus'],'displayorder' => $key['displayorder']]);
                }

                return response()->json(['message'=>'Success']); 

           
        }
        public function createnewmodule(Request $request)
        {
            $pipelinedealid=$request->pipelinedealid;
            $helper= \App\Helpers\AppHelper::instance();
            DB::table('dd_modules')->insert(
                [
                'moduleid' => $helper->fnGetUniqueID(16, 'dd_modules', 'moduleid'), 
                'pipelinedealid' => $pipelinedealid,
                'tenantid'=> Session('tenantid'),
                'modulename' => $request->name,
                'modulestatus'=>$request->status,
                'displayorder' => $request->displayorder
                ]
               );

           return response()->json(['message'=>'Success']); 

           
        }

        public function deletemodules(Request $request)
        {
            $tenantid=Session('tenantid');
            $ids = $request->ids;
            DB::table("dd_modules")->whereIn('moduleid',explode(",",$ids))->where('tenantid',$tenantid)->update(['modulestatus' => 'Deleted']);
            return response()->json(['message'=>'Success']); 
        }

        public function createquestion(Request $request)
        {
            $userid=Session('userid');
            //need to take userid to null.
            $moduleid=$request->moduleid;
            $question=$request->questiontext;
            $pipelinedealid=$request->pipelinedealid;

            if( (isset($moduleid) && !empty($moduleid) )  &&  (isset($question) && !empty($question)) )
            {
                $helper= \App\Helpers\AppHelper::instance();
                DB::table('dd_questions')->insert(
                    [
                    'questionid' => $helper->fnGetUniqueID(16, 'dd_questions', 'questionid'), 
                    'pipelinedealid' => $pipelinedealid,
                    'moduleid' => $moduleid,
                    'tenantid'=> Session('tenantid'),
                    'questiontext' => $question,
//                    'userid'=>'',
                    'questionstatus' => 'Pending',
                    'displayorder' => $helper->fnMaxDisplayOrderByWhere('dd_questions','displayorder','moduleid',$moduleid)
                    ]
                   );

                   $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
                   if(isset($user_obj))
                   {
                    $actiontaken=\App\Helpers\AppGlobal::$DD_question_added;
                    $name=$user_obj->firstname.' '.$user_obj->lastname;  
                    $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
                    $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
                    $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
                   }



                   return response()->json(['message'=>'Success']); 
            }

        }

        public function updatepreviousreply(Request $request)
        {
            $userid=Session('userid');
            $answerid=$request->answerid;
            $prevreply=$request->editedreplytext;
            $now = new \DateTime();
            if( (isset($answerid) && !empty($answerid) )  &&  (isset($prevreply) && !empty($prevreply)) )
            {
                DB::table('dd_answers')->where('answerid',$answerid)->where('tenantid',Session('tenantid'))->update(['answertext' => $prevreply,'userid'=>$userid,'updated'=>$now]);
                return response()->json(['message'=>'Success']); 
            }
        }


        public function deletepreviousreply(Request $request)
        {
            $userid=Session('userid');
            $answerid=$request->answerid;
            $now = new \DateTime();
            if(isset($answerid) && !empty($answerid))
            {
                DB::table('dd_answers')->where('answerid',$answerid)->where('tenantid',Session('tenantid'))->update(['answerstatus' => 'Deleted','updated'=>$now]);
                return response()->json(['message'=>'Success']); 
            }
        }
      public function geteditquestion(Request $request)
      {
          $id=$request->id;
          $results = DB::select( DB::raw("SELECT questiontext FROM dd_questions WHERE questionid = '$id'") );
          return response()->json(['question'=>$results[0]->questiontext]);
          
      }
      public function savequestion(Request $request)
      {
       
        $editid=$request->editid;
        $questiontext=$request->editedquestion;
//        $sql="UPDATE dd_questions SET questiontext = '$questiontext' where questionid = '$editid'";
//        echo $sql;
        DB::statement("UPDATE dd_questions SET questiontext = '$questiontext' where questionid = '$editid'");
      }
      public function deleteselectedquestion(Request $request)
      {
          $delid=$request->delid;
          $results = DB::select( DB::raw("SELECT answerid FROM dd_answers WHERE questionid = '$delid'") );
          
          if(isset($results[0]->answerid) || !empty($results[0]->answerid))
          {
              $answerid=$results[0]->answerid;
          DB::statement("DELETE from dd_answers_documents where answerid = '$answerid'");
          DB::statement("DELETE from dd_answers where questionid = '$delid'");
          }
          DB::statement("DELETE from dd_questions where questionid = '$delid'");
      }
      public function assignedusers(Request $request)
      {
          $pipelinedealid=$request->pd;
          $companyid=session('companyid');
          
          
          
          $involved_Companies=DB::select(DB::raw("
                SELECT companyid,'Parent' as type FROM `pipelinedeals` WHERE 
                pipelinedealid='$pipelinedealid'
                UNION 
                SELECT companyid,'Associates' as type FROM `pipelinedeals` WHERE 
                parentpipelinedealid='$pipelinedealid' 
                "));
                // Union 
                // Select '$companyid'

               $cids="";
               foreach ($involved_Companies as $key => $value) {

                if ($cids=="")
                {
                 $cids=$value->companyid;
                }
                else
                {
                 $cids=$cids.",". $value->companyid;
                }
            }

             $all_users=DB::table('usercompanies as uc')
             ->join('users as u','u.userid','uc.userid')
             ->whereIn('uc.companyid', explode(',', $cids))
             ->where('uc.recordstatus','Active')
             ->select('uc.userid','u.firstname','u.lastname','u.profileimage')
             ->get();
             
             $userids="";
               foreach ($all_users as $key => $value) {

                if ($userids=="")
                {
                 $userids=$value->userid;
                }
                else
                {
                 $userids=$userids.",". $value->userid;
                }
            }
             $extrausers=DB::table('usercompanies as uc')
             ->join('users as u','u.userid','uc.userid')
             ->whereNotIn('uc.userid', explode(',', $userids))
             ->where('uc.recordstatus','Active')
             ->where('uc.companyid',$companyid)        
             ->select('uc.userid','u.firstname','u.lastname','u.profileimage')
             ->get();
             
            // $extrausers=DB::select(DB::raw("select users.userid,users.firstname,users.lastname,users.profileimage from usercompanies,users where users.userid=usercompanies.userid and companyid='$companyid'"));
          
             $view=View::make('duediligence.process._assign_users',compact('all_users','extrausers'))->render();
             return $view;
             
          
      }
      
      public function saveassignusers(Request $request)
      {
          $questionid=$request->questionid;
          $users=$request->users;
          $pipelinedealid=$request->pipelinedealid;
          $helper= \App\Helpers\AppHelper::instance();
//          $sql="update dd_questions set userid='$users' where questionid = '$questionid'";
//          echo $sql;
          DB::statement("update dd_questions set userid='$users' where questionid = '$questionid'");

          $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$users'"))[0];
          if(isset($user_obj))
          {
            $actiontaken=\App\Helpers\AppGlobal::$DD_question_assigned;
            $name=$user_obj->firstname.' '.$user_obj->lastname;  
            $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
            $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
            $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
          }


      }
      
      public function getsubmit(Request $request)
      {
        //   $makedisable="disable";
          $makedisable = "pending";

          $questionid=$request->questionid;
        //   $userid=session('userid');
        //   $query="SELECT userid FROM dd_questions WHERE questionid = '$questionid'";
        //   $results = DB::select( DB::raw("SELECT userid FROM dd_questions WHERE questionid = '$questionid'") );
        //   if(isset($results[0]->userid) && !empty($results[0]->userid))
        //   {
        //      if($results[0]->userid==$userid)
        //      {
        //          $makedisable="enable";
        //      }
        //   }
        //   return $makedisable;

$results_new = DB::select(DB::raw("SELECT questionstatus FROM dd_questions WHERE questionid = '$questionid'"));
if (isset($results_new[0]->questionstatus) && !empty($results_new[0]->questionstatus)) {

        $makedisable = $results_new[0]->questionstatus;

}

return $makedisable;



          
      }

      public function updatequestionstatus(Request $request)
      {
          $result = "Success";

          $questionid = $request->questionid;

          $status=$request->qstatus;

          DB::update("Update dd_questions set questionstatus='$status', updated=CURRENT_TIMESTAMP where questionid='$questionid'");


          return $result;
      }
      
      
      
    public function downloadPDF(Request $request)
    {
              
      $pd=$request->pd;
      $tenantid=session('tenantid');
      
    //   $getmodulenameonly=array();
    //   $getmoduleid=array();
    //   $selectquery="select dd_questions.questionid,dd_questions.questiontext,users.firstname,users.lastname,dd_modules.modulename,dd_modules.moduleid from dd_questions join users on dd_questions.userid = users.userid join dd_modules on dd_questions.moduleid=dd_modules.moduleid where dd_questions.pipelinedealid = '$pd' and dd_modules.modulestatus = 'Active' and dd_questions.tenantid='$tenantid' order by dd_questions.displayorder";
    //   $selectanswerquery="select dd_answers.answerid,dd_answers.questionid,dd_answers.answertext,users.firstname,users.lastname from dd_answers  join users on dd_answers.userid = users.userid where dd_answers.answerstatus = 'Active' and dd_answers.tenantid='$tenantid' order by displayorder";
    //   $results = DB::select( DB::raw($selectquery));
    //   $resultansqry = DB::select( DB::raw($selectanswerquery));
    //   foreach($results as $result)
    //   {
    //       $getmodulenameonly[]=$result->modulename;
    //       $getmoduleid[]=$result->moduleid;
    //   }

    //  $getmodulenameonly=array_unique($getmodulenameonly);
    //  $getmoduleid= array_unique($getmoduleid);
         
    //   $pdf = PDF::loadView('duediligence.pdf.pdf',compact('getmodulenameonly','getmoduleid','results','resultansqry'));
    //   return $pdf->download('Modules'.'-pd('.$pd.')-dated-'.date('Y_m_d_H:i:s').'.pdf');

    $UniqueModules=DB::table('dd_questions as q')->where('q.tenantid',$tenantid)
                   ->join('dd_modules as m','m.moduleid','q.moduleid')
                   ->where('q.questionstatus','Completed')
                   ->where('q.pipelinedealid',$pd)
                   ->select('m.moduleid','m.modulename')
                   ->groupBy('m.moduleid','m.modulename')
                   ->get();

    $Questions=DB::table('dd_questions as q')->where('q.tenantid',$tenantid)
                   ->join('users as u','u.userid','q.userid')
                   ->where('q.questionstatus','Completed')
                   ->where('q.pipelinedealid',$pd)
                   ->select('q.questionid','q.questiontext','u.firstname','u.lastname','q.moduleid')
                   ->get();
      
                   $qids='';
                   foreach ($Questions as $key => $value) {
          
                    if ($qids=="")
                    {
                        $qids=$value->questionid;
                    }
                    else
                    {
                        $qids=$qids.",". $value->questionid;
                    }
                }

    $Answers=DB::table('dd_answers as a')->where('a.tenantid',$tenantid)
                   ->join('users as u','u.userid','a.userid')
                   ->whereIn('a.questionid',explode(',',$qids))
                   ->select('a.answerid','a.questionid','a.answertext','u.firstname','u.lastname')
                   ->get();

     $pdf = PDF::loadView('duediligence.pdf.pdf',compact('UniqueModules','Questions','Answers'));
     return $pdf->download('Modules'.'-pd('.$pd.')-dated-'.date('Y_m_d_H:i:s').'.pdf');
     
    }
      
    
              public function downloadPDFold(Request $request)
    {
              
      $pd=$request->pd;
      $tenantid=session('tenantid');
      
      $getmodulenameonly=array();
      $getmoduleid=array();
      $selectquery="select dd_questions.questionid,dd_questions.questiontext,users.firstname,users.lastname,dd_modules.modulename,dd_modules.moduleid from dd_questions join users on dd_questions.userid = users.userid join dd_modules on dd_questions.moduleid=dd_modules.moduleid where dd_questions.pipelinedealid = '$pd' and dd_modules.modulestatus = 'Active' and dd_questions.tenantid='$tenantid' order by dd_questions.displayorder";
      $selectanswerquery="select dd_answers.answerid,dd_answers.questionid,dd_answers.answertext,users.firstname,users.lastname from dd_answers  join users on dd_answers.userid = users.userid where dd_answers.answerstatus = 'Active' and dd_answers.tenantid='$tenantid' order by displayorder";
      $results = DB::select( DB::raw($selectquery));
      $resultansqry = DB::select( DB::raw($selectanswerquery));
      $selectmodulequery="select distinct dd_modules.moduleid,dd_modules.modulename from dd_modules where modulestatus='Active' and tenantid='$tenantid' and pipelinedealid = '$pd' order by displayorder"; 
      $resultmodulequery= DB::select( DB::raw($selectmodulequery));
      foreach($results as $result)
      {
          $getmodulenameonly[]=$result->modulename;
          $getmoduleid[]=$result->moduleid;
      }
     $getmodulenameonly=array_unique($getmodulenameonly);
     $getmoduleid= array_unique($getmoduleid);
       //return view('duediligence.pdf.pdf')->with($getmodulenameonly);
//      $pdf = PDF::loadView('duediligence.pdf.pdf');
//      return $pdf->download('invoice.pdf');
      
      $pdf = PDF::loadView('duediligence.pdf.pdf');
      return $pdf->download('hdtuto.pdf');
     
    }

    //Used to open document area.....of particular pipelinedeal
    public function getpipelinedealdocuments(Request $request)
    {
        $pipelinedealid=$request->pd;//"BvDYWFansviNyYKK";//
        session()->put('pipelinedealid', $pipelinedealid);
        // $pipelinedeal_info = DB::table('pipelinedeals as d')->where('d.pipelinedealid',$pipelinedealid)
        //  ->select('d.pipelinedealid')
        // ->first();

        // $data = [ 
        //     'pipelinedeal_info' => $pipelinedeal_info,
           
        //  ];  
        $tenantid=session('tenantid');
        $companyid=session('companyid');
        $is_parent=DB::select(DB::raw("SELECT (case when pipelinedealid='$pipelinedealid' then 'Yes' else 'No' end) as Is_Parent FROM `pipelinedeals` WHERE companyid='$companyid' and (pipelinedealid='$pipelinedealid' or parentpipelinedealid='$pipelinedealid') and tenantid='$tenantid'"));
        return view('duediligence.documents.pipeline_documents',compact('pipelinedealid','is_parent'));
    }


    public function documentUpdate( Request $request) {
        $helper= \App\Helpers\AppHelper::instance();
         if( $request->hasFile('file') )
         {
                if( $request->input('public_documents') || $request->input('private_documents') ) {
                   $response['status'] = 0 ; 
                   $pipelinedealid=$request->input('pipelinedealid');               
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

                   $document_application_name=$helper->fnGetUniqueID('16','pipelinedeal_documents','documentid');
                   $document_application_name = $document_application_name.'.'.$extension;


                    if($documentstatus=='Public')
                    {
                      $public_document->move('storage/pipelinedeal/documents/public', $document_application_name);
                    }
                    else{
                      $public_document->move('storage/pipelinedeal/documents/private', $document_application_name);
                    }

                        DB::table('pipelinedeal_documents')
                             ->insert([
                                       'userid' => session('userid'),
                                       'documentid' => $helper->fnGetUniqueID('16','pipelinedeal_documents','documentid'),
                                       'documentname' => $filename_without_ext,
                                       'documenttitle' => $document_application_name,
                                       'documentdescription' => $document_application_name,
                                       'extention' => $extension,
                                       'type' => $filetype,
                                       'pipelinedealid' => $pipelinedealid,
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
                DB::table('pipelinedeal_documents')->where('documentid',$document_id)->delete();
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
                $file_name = DB::table('pipelinedeal_documents')->select('documenttitle')->where('documentid', $id)->first()->documenttitle; 
                $file_path = public_path('storage/pipelinedeal/documents/public/'.$file_name);
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
            $file_path ='storage/pipelinedeal/documents/'.$type.'/';

            foreach ($documents as $value => $key ) 
            {
                  try
                  {
                    $file_name = DB::table('pipelinedeal_documents')->select('documenttitle')->where('documentid', $key['documentid'])->first()->documenttitle; 
                    if($file_name!=null)
                    {
                      $file =$file_path . $file_name;  
                      if(file_exists(public_path($file_path.$file_name))){
                        unlink(public_path($file_path.$file_name));
                      }
                      // File::delete($file_path);
                      DB::table('pipelinedeal_documents')->where('documentid',$key['documentid'])->delete();
                    }
                  }
                  catch(Exception $e) {
                    // report($e);
                  }
                }

                return response()->json(['message'=>'Success']); 
          }


          public function getcompanylist(Request $request)
          {
            $searchtext=$request->searchtext;
            $sortby=$request->sortby;

            $userid=Session('userid');
            $companyid=Session('companyid');

   
              $query = DB::table('company as c')
                ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
                ->where('c.companystatus','Verified')
                ->where('c.activestatus','Active');
              
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
                      case 'company':
                      $query->orderBy('c.name');
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
          
    

              $view=View::make('duediligence.dashboard._company_list',compact('company'))->render();
                     
              return $view;
          }



    public function checkinvitingmember(Request $request)
    {
        $session_companyid=session('companyid');

        $pipelinedealid=$request->pipelinedealid;
        $companyid=$request->companyid;
        $tenantid=session('tenantid');
        $involved_Companies=DB::select(DB::raw("
        SELECT companyid,'Parent' as type FROM `pipelinedeals` WHERE 
        pipelinedealid='$pipelinedealid'
        UNION 
        SELECT companyid,'Associates' as type FROM `pipelinedeals` WHERE 
        parentpipelinedealid='$pipelinedealid'
        UNION
        SELECT companyid,'Owner' as type FROM `deals` WHERE 
        dealid=(select dealid from pipelinedeals where pipelinedealid='$pipelinedealid')
        UNION
        SELECT companyid,'Invited' as type from draft_pipelinedeals where pipelinedealid='$pipelinedealid' and status='Invited'
        "));

       $cids="";
       foreach ($involved_Companies as $key => $value) {
           if($value->companyid==$companyid)
           {
            $cids="found";
            break;
           }
    }

    if($cids=="")
    {
        $helper= \App\Helpers\AppHelper::instance();
        $d_pid=$helper->fnGetUniqueID(16, 'draft_pipelinedeals', 'draft_pipelinedealid');
        $tenantid=session('tenantid');
        DB::table('draft_pipelinedeals')->insert(
                  [
                  'draft_pipelinedealid' => $d_pid, 
                  'pipelinedealid' => $pipelinedealid,
                  'tenantid'=> Session('tenantid'),
                  'companyid' => $companyid,
                  'status'=>'Invited'
                  ]
                 );


                 try{
                    $TemplateCode= \App\Helpers\AppGlobal::$GotInvitationToJoinDueDiligence_TemplateCode;
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

                            $sessionuserobj=DB::select(DB::raw("Select userid,firstname from users where userid='".session('userid')."'"))[0];
              
                            $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                            join companytypes as ct on ct.companytypeid=c.companytypeid
                            where companyid = '$companyid'"))[0];
              
                            $pipelinedeal_detail=DB::select(DB::raw("Select d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                            join deals as d on d.dealid=pd.dealid
                            Where pd.pipelinedealid='$pipelinedealid'
                            "))[0];
              
                            $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
              
                          $MessageBody=$Template->message;
                          $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                          $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                          $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
                          $MessageBody=str_replace("%%FIRSTNAME%%",$sessionuserobj->firstname,$MessageBody);

                          $profilelink=\App\Helpers\AppGlobal::$App_Domain.'/company/profile/view?company='.$company_sender->companyid.'&companytype='.$company_sender->companytype;
                          $logo='';
                        if( (isset($company_sender->profileimage) && !empty($company_sender->profileimage) ) && File::exists(public_path('/storage/company/profileimage/'.$company_sender->profileimage))==true)
                        {
                            $logo=\App\Helpers\AppGlobal::$App_Domain.'/storage/company/profileimage/'.$company_sender->profileimage;
                        }
                        else
                        {
                            // $logo=Avatar::create(ucfirst($company_sender->company))->toBase64();
                            $logo= \App\Helpers\AppGlobal::$App_Domain."/img/logo_desktop.png";
                        }
                          
                          $MessageBody=str_replace("%%PROFILE_LINK%%",$profilelink,$MessageBody);
                          $MessageBody=str_replace("%%LOGO%%",$logo,$MessageBody);
                          $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
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
                 //dd($e);
              }

              $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
              join companytypes as ct on ct.companytypeid=c.companytypeid
              where companyid = '$companyid'"))[0];
              if(isset($c_rec))
              {
               $actiontaken=\App\Helpers\AppGlobal::$DD_invited_to_join;
               $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
               $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
               $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
              }

 

        return response()->json(['message'=>'Success']); 
    }
    else
    {
        return response()->json(['message'=>'Failed']); 
    }


     


    }

    public function removeassociatedcompany(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $companyid=$request->companyid;
        $type=$request->type;
        $session_companyid=session('companyid');
        $helper= \App\Helpers\AppHelper::instance();
        $tenantid=session('tenantid');
        if($type=='Invited' || $type=='New Request')
        {
            DB::table('draft_pipelinedeals')
            ->where('pipelinedealid', $pipelinedealid)
            ->where('tenantid',session('tenantid'))
            ->where('companyid',$companyid)
            ->where('status',$type)
            ->delete();
        }
        else if($type=='Associates')
        {

            DB::delete("Delete from pipelinedeal_pipelinefolders where pipelinedealid=(Select pipelinedealid from pipelinedeals where parentpipelinedealid='$pipelinedealid' and companyid='$companyid')");
            DB::delete("Delete from pipelinedeals where parentpipelinedealid='$pipelinedealid' and companyid='$companyid'");

            // DB::table('pipelinedeals')
            // ->where('parentpipelinedealid',$pipelinedealid)
            // ->where('tenantid',Session('tenantid'))
            // ->where('companyid',$companyid)
            // ->delete();
           
        }

                    //Send Email To Receiver Friend.
                    try{
                            $TemplateCode="";
                            if($type=='Invited')
                            {
                                $TemplateCode= \App\Helpers\AppGlobal::$InvitationCancelledToJoinDueDiligence_TemplateCode;
                            }
                            else if($type=='New Request')
                            {
                                $TemplateCode= \App\Helpers\AppGlobal::$RequestRejectedToJoinDueDiligence_TemplateCode;
                            }
                            else{
                                //case of Already Associated company.
                                $TemplateCode= \App\Helpers\AppGlobal::$RemovedFromDueDiligence_TemplateCode;
                            }
                            
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

                                        $sessionuserobj=DB::select(DB::raw("Select userid,firstname from users where userid='".session('userid')."'"))[0];
                          
                                        $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                                        join companytypes as ct on ct.companytypeid=c.companytypeid
                                        where companyid = '$companyid'"))[0];
                          
                                        $pipelinedeal_detail=DB::select(DB::raw("Select d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                                        join deals as d on d.dealid=pd.dealid
                                        Where pd.pipelinedealid='$pipelinedealid'
                                        "))[0];
                          
                                        $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
                          
                                      $MessageBody=$Template->message;
                                      $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                                      $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                                      $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
                                      $MessageBody=str_replace("%%FIRSTNAME%%",$sessionuserobj->firstname,$MessageBody);
                                      $MessageBody=str_replace("%%COMPANY%%",$company_receiver->company,$MessageBody);
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
                                        $logo= \App\Helpers\AppGlobal::$App_Domain."/img/logo_desktop.png";
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
                        // dd($e);
                        }
            
            
                    //End of sending Email Code.

                    if($type=='New Request' || $type=='Associates')
                    {
                    //For Activity History.......
                     $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                     join companytypes as ct on ct.companytypeid=c.companytypeid
                     where companyid = '$companyid'"))[0];
                     if(isset($c_rec))
                     {

                      $actiontaken=$type=='New Request'?\App\Helpers\AppGlobal::$DD_others_request_to_join_rejected:\App\Helpers\AppGlobal::$DD_company_removed_from_dd;
                      $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
                      $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
                      $userid=session('userid');
                      $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
                      if(isset($user_obj))
                      {
                        $name=$user_obj->firstname.' '.$user_obj->lastname;  
                        $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
                        $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
                      }
                      $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
                     }
                    //End
                    }

        return response()->json(['message'=>'Success']); 
    }


    public function rejectinvitation(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $companyid=$request->companyid;
        $type=$request->type;
        $session_companyid=session('companyid');
        $helper= \App\Helpers\AppHelper::instance();
        $tenantid=session('tenantid');
        DB::table('draft_pipelinedeals')
            ->where('pipelinedealid', $pipelinedealid)
            ->where('tenantid',session('tenantid'))
            ->where('companyid',$session_companyid)
            ->where('status',$type)
            ->delete();
    
                    //Send Email To Receiver Friend.
                    try{
                      //Invition Rejected to JOIN DUE DILIGENCE.
                      $TemplateCode= \App\Helpers\AppGlobal::$InvitationRejected_TemplateCode;

                            
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
                          
                                        $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                                        join companytypes as ct on ct.companytypeid=c.companytypeid
                                        where companyid = '$companyid'"))[0];
                          
                                        $pipelinedeal_detail=DB::select(DB::raw("Select d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                                        join deals as d on d.dealid=pd.dealid
                                        Where pd.pipelinedealid='$pipelinedealid'
                                        "))[0];
                          
                                        $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
                          
                                      $MessageBody=$Template->message;
                                      $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                                      $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                                      $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
                                      $MessageBody=str_replace("%%PLATFORMNAME%%",session('platformname'),$MessageBody);
                                      $loginlink=\App\Helpers\AppGlobal::$App_Domain.'/login?tid='.$tenantid;
                                     $MessageBody=str_replace("%%LOGIN_LINK%%",$loginlink,$MessageBody);
                                     $MessageBody= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$MessageBody); 
                                                                                      
                                      $Message_with_master= $TemplateMaster->content; 
                                      $Message_with_master= str_replace("%%DOMAIN%%",\App\Helpers\AppGlobal::$App_Domain,$Message_with_master);  

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
                                        //   $t_logo=Avatar::create(ucfirst(session('tenant_firstname').' '.session('tenant_lastname')))->toBase64();
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
                        }
                        catch(\Exception $e){
                        // do task when error
                        dd($e);
                        }


             //For Activity History.......
             $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
             join companytypes as ct on ct.companytypeid=c.companytypeid
             where companyid = '$session_companyid'"))[0];
             if(isset($c_rec))
             {
              $actiontaken=\App\Helpers\AppGlobal::$DD_rejected_invitation_to_join;
              $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
              $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
              $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
             }
            //End
            
            
                    //End of sending Email Code.

        return response()->json(['message'=>'Success']); 
    }

    public function acceptNewCompanyRequest(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $companyid=$request->companyid;
        $type=$request->type;
        $tenantid=session('tenantid');
        $accepting_companyid=session('companyid');
        $helper= \App\Helpers\AppHelper::instance();

        $companyfolder=DB::table('pipelinefolders')
        ->where('companyid',$companyid)
        ->where('tenantid',session('tenantid'))
        ->where('foldername','Default')
        ->first();
       $folderid='';
        if(isset($companyfolder)==false)
        {
           $newfolderid=$helper->fnGetUniqueID(16, 'pipelinefolders', 'folderid');
           DB::table('pipelinefolders')->insert(
             [
             'folderid' => $newfolderid,
             'tenantid'=> Session('tenantid'),
             'companyid' => $companyid,
             'foldername'=>'Default'
             ]
            );

            $folderid=$newfolderid;
        }
        else
        {
            $folderid=$companyfolder->folderid;
        }

      
        $dealidobject=DB::table('pipelinedeals')
        ->where('pipelinedealid',$pipelinedealid)
        ->where('tenantid',session('tenantid'))
        ->first();
 
         $dealid=$dealidobject->dealid;

         $d_pid=$helper->fnGetUniqueID(16, 'pipelinedeals', 'pipelinedealid');
        DB::table('pipelinedeals')->insert(
          [
          'pipelinedealid' => $d_pid,
          'parentpipelinedealid' => $pipelinedealid,
          'tenantid'=> Session('tenantid'),
          'dealid' => $dealid,
          'companyid' => $companyid,
          'pipelinedealstatus'=>'Due Diligence New'
          ]
         );

         

         DB::table('pipelinedeal_pipelinefolders')->insert(
            [
            'pipelinedealid' => $d_pid,
            'folderid' => $folderid,
            'tenantid'=> Session('tenantid')
            ]
           );

        DB::table('draft_pipelinedeals')
        ->where('pipelinedealid', $pipelinedealid)
        ->where('tenantid',session('tenantid'))
        ->where('companyid',$companyid)
        ->where('status',$type)
        ->delete();

                     //For Activity History.......
                     $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                     join companytypes as ct on ct.companytypeid=c.companytypeid
                     where companyid = '$companyid'"))[0];
                     if(isset($c_rec))
                     {
                      $actiontaken=\App\Helpers\AppGlobal::$DD_others_request_to_join_accepted;
                      $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
                      $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
                      $userid=session('userid');
                      $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
                      if(isset($user_obj))
                      {
                        $name=$user_obj->firstname.' '.$user_obj->lastname;  
                        $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
                        $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
                      }
                      $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
                     }
                    //End

                            //Send Email 
                            try{
                                //Request to JOIN DUE DILIGENCE has been accepted.
                                $TemplateCode= \App\Helpers\AppGlobal::$RequestAcceptedToJoinDueDiligence_TemplateCode;
          
                                      
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
                                                  where companyid = '$accepting_companyid'"))[0];
                                    
                                                  $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                                                  join companytypes as ct on ct.companytypeid=c.companytypeid
                                                  where companyid = '$companyid'"))[0];
                                    
                                                  $pipelinedeal_detail=DB::select(DB::raw("Select d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                                                  join deals as d on d.dealid=pd.dealid
                                                  Where pd.pipelinedealid='$pipelinedealid'
                                                  "))[0];
                                    
                                                  $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
                                    
                                                $MessageBody=$Template->message;
                                                $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                                                $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                                                $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
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
                                                    //  $t_logo=Avatar::create(ucfirst(session('tenant_firstname').' '.session('tenant_lastname')))->toBase64();
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
                                  }
                                  catch(\Exception $e){
                                  // do task when error
                                  dd($e);
                                  }
                               //End of sending Email Code.


        return response()->json(['message'=>'Success']); 
    }


    public function accept_invitationtojoin_dd(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $companyid=$request->companyid;
        $type=$request->type;
        $tenantid=session('tenantid');

        $accepting_companyid=session('companyid');
  
        $helper= \App\Helpers\AppHelper::instance();

        $companyfolder=DB::table('pipelinefolders')
        ->where('companyid',$accepting_companyid)
        ->where('tenantid',session('tenantid'))
        ->where('foldername','Default')
        ->first();
       $folderid='';
        if(isset($companyfolder)==false)
        {
           $newfolderid=$helper->fnGetUniqueID(16, 'pipelinefolders', 'folderid');
           DB::table('pipelinefolders')->insert(
             [
             'folderid' => $newfolderid,
             'tenantid'=> Session('tenantid'),
             'companyid' => $accepting_companyid,
             'foldername'=>'Default'
             ]
            );

            $folderid=$newfolderid;
        }
        else
        {
            $folderid=$companyfolder->folderid;
        }


       
        $dealidobject=DB::table('pipelinedeals')
        ->where('pipelinedealid',$pipelinedealid)
        ->where('tenantid',session('tenantid'))
        ->first();
 
         $dealid=$dealidobject->dealid;

         $d_pid=$helper->fnGetUniqueID(16, 'pipelinedeals', 'pipelinedealid');
        DB::table('pipelinedeals')->insert(
          [
          'pipelinedealid' => $d_pid,
          'parentpipelinedealid' => $pipelinedealid,
          'tenantid'=> Session('tenantid'),
          'dealid' => $dealid,
          'companyid' => $accepting_companyid,
          'pipelinedealstatus'=>'Due Diligence New'
          ]
         );

         

         DB::table('pipelinedeal_pipelinefolders')->insert(
            [
            'pipelinedealid' => $d_pid,
            'folderid' => $folderid,
            'tenantid'=> Session('tenantid')
            ]
           );

        DB::table('draft_pipelinedeals')
        ->where('pipelinedealid', $pipelinedealid)
        ->where('tenantid',session('tenantid'))
        ->where('companyid',$accepting_companyid)
        ->where('status',$type)
        ->delete();


                     //For Activity History.......
                     $c_rec=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                     join companytypes as ct on ct.companytypeid=c.companytypeid
                     where companyid = '$accepting_companyid'"))[0];
                     if(isset($c_rec))
                     {
                      $actiontaken=\App\Helpers\AppGlobal::$DD_accepted_invitation_to_join;
                      $companyname_with_link="<a href='/company/profile/view?company=$c_rec->companyid&companytype=$c_rec->companytype' target='_blank'>$c_rec->company</a>";
                      $actiontaken=str_replace('%%COMPANY%%',$companyname_with_link,$actiontaken);
                      $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
                     }
                    //End

                            //Send Email To Receiver Friend.
                            try{
                                //Invition Rejected to JOIN DUE DILIGENCE.
                                $TemplateCode= \App\Helpers\AppGlobal::$InvitationAcceptedToJoinDueDiligence_TemplateCode;
          
                                      
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
                                                  where companyid = '$accepting_companyid'"))[0];
                                    
                                                  $company_receiver=DB::select(DB::raw("SELECT c.companyid,c.name as company,c.profileimage,c.email,ct.companytype from company as c
                                                  join companytypes as ct on ct.companytypeid=c.companytypeid
                                                  where companyid = '$companyid'"))[0];
                                    
                                                  $pipelinedeal_detail=DB::select(DB::raw("Select d.dealid,d.projectname,pd.pipelinedealstatus,pd.startdate from pipelinedeals as pd
                                                  join deals as d on d.dealid=pd.dealid
                                                  Where pd.pipelinedealid='$pipelinedealid'
                                                  "))[0];
                                    
                                                  $receiver_email=$helper->GetCompanyAdminUserEmail($companyid);//$company_receiver->email;
                                    
                                                $MessageBody=$Template->message;
                                                $MessageBody=str_replace("%%RECEIVER%%",$company_receiver->company,$MessageBody);
                                                $MessageBody=str_replace("%%SENDER%%",$company_sender->company,$MessageBody);
                                                $MessageBody=str_replace("%%DEAL_NAME%%",$pipelinedeal_detail->projectname,$MessageBody);
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
                                                    //  $t_logo=Avatar::create(ucfirst(session('tenant_firstname').' '.session('tenant_lastname')))->toBase64();
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
                                  }
                                  catch(\Exception $e){
                                  // do task when error
                                  dd($e);
                                  }
                               //End of sending Email Code.



        return response()->json(['message'=>'Success']); 
    }


   /*  
   This function is used to get all pending invites to join DD AND all pending requests 
   */
    public function getduediligenceinvitesandrequests(Request $request)
    {
        $companyid=session('companyid');
        
        // $query=DB::table('draft_pipelinedeals as dp')
        // ->join('pipelinedeals as pd','pd.pipelinedealid','dp.pipelinedealid')
        // ->join('deals as d','d.dealid','pd.dealid')
        // ->join('company as c','c.companyid','dp.companyid')
        // ->join()
        $searchtext=$request->searchtext;
        $sortby=$request->sortby;

        $searchcondition="";
        $sortbydata="";

        if(isset($searchtext) && !empty($searchtext))
        {
         $searchcondition=" AND (c.name like '%$searchtext%' OR d.projectname like '%$searchtext%')";
        }

        $RequestsOnMyAndOthersDDs=DB::select(DB::raw("SELECT dp.draft_pipelinedealid,pd.pipelinedealid,d.dealid,c.companyid,c.name as company,
        c.profileimage,ct.companytype,d.projectname,d.profileimage as dealprofileimage,dp.status as RequestType,'Your Company' as Parent 
        from draft_pipelinedeals as dp 
        JOIN pipelinedeals as pd on pd.pipelinedealid=dp.pipelinedealid 
        JOIN deals as d on d.dealid=pd.dealid Join company as c on c.companyid=dp.companyid 
        Join companytypes as ct on ct.companytypeid=c.companytypeid 
        where dp.pipelinedealid in (select pipelinedealid from pipelinedeals where companyid='$companyid') AND dp.status='New Request' $searchcondition
        UNION
        SELECT dp.draft_pipelinedealid,pd.pipelinedealid,d.dealid,c.companyid,c.name as company,
        c.profileimage,ct.companytype,d.projectname,d.profileimage as dealprofileimage,dp.status as RequestType,'Other Company' as Parent 
        from draft_pipelinedeals as dp 
        JOIN pipelinedeals as pd on pd.pipelinedealid=dp.pipelinedealid 
        JOIN deals as d on d.dealid=pd.dealid Join company as c on c.companyid=pd.companyid 
        Join companytypes as ct on ct.companytypeid=c.companytypeid 
        where dp.pipelinedealid in (select pipelinedealid from pipelinedeals where companyid<>'$companyid') and dp.companyid='$companyid' AND dp.status='Invited' $searchcondition
        "));

      
    $view=View::make('Pending_Requests.dd_requests',compact('RequestsOnMyAndOthersDDs'))->render();
     return $view;

        
    }


    public function ChangeDDTemplate(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $templateid=$request->templateid;
        $tenantid=session('tenantid');
        $helper= \App\Helpers\AppHelper::instance();
        //Delete answer docs
        DB::delete("Delete from dd_answers_documents where answerid in (select answerid from dd_answers where questionid in (select questionid from dd_questions where pipelinedealid='$pipelinedealid' and tenantid='$tenantid') and tenantid='$tenantid')  and tenantid='$tenantid'");
        //Delete answers
        DB::delete("Delete from dd_answers where questionid in (select questionid from dd_questions where pipelinedealid='$pipelinedealid'  and tenantid='$tenantid') and tenantid='$tenantid'");
        //Delete questions
        DB::delete("Delete from dd_questions where pipelinedealid='$pipelinedealid' and tenantid='$tenantid'");
        //Delete modules
        DB::delete("Delete from dd_modules where pipelinedealid='$pipelinedealid' and tenantid='$tenantid'");


        // DB::insert("Insert into dd_modules(moduleid,pipelinedealid,tenantid,modulename,modulestatus,displayorder)
        // SELECT moduleid,'$pipelinedealid','$tenantid',modulename,modulestatus,displayorder from dd_template_modules where templateid='$templateid'
        // ");

        // DB::insert("Insert into dd_questions(questionid,moduleid,pipelinedealid,tenantid,questiontext,questionstatus,displayorder)
        // SELECT questionid,moduleid,'$pipelinedealid','$tenantid',questiontext,'Pending',displayorder from dd_template_questions where templateid='$templateid'
        // ");

        $TemplateModules=DB::select(DB::raw("SELECT moduleid,modulename,modulestatus,displayorder from dd_template_modules where templateid='$templateid'"));
        foreach($TemplateModules as $key => $module)
        {
           $new_moduleid=$helper->fnGetUniqueID(16, 'dd_modules', 'moduleid');
           DB::table('dd_modules')->insert(
            [
            'moduleid' => $new_moduleid, 
            'pipelinedealid' => $pipelinedealid,
            'tenantid'=> Session('tenantid'),
            'modulename' => $module->modulename,
            'modulestatus'=>$module->modulestatus,
            'displayorder' => $module->displayorder
            ]
           );
           
           $TemplateQuestions=DB::select(DB::raw("SELECT questionid,moduleid,tenantid,questiontext,'Pending' as questionstatus,displayorder from dd_template_questions where templateid='$templateid' and moduleid='$module->moduleid'"));
           foreach($TemplateQuestions as $key => $question)
           {
            $new_questionid=$helper->fnGetUniqueID(16, 'dd_questions', 'questionid');
            DB::table('dd_questions')->insert(
             [
             'questionid' => $new_questionid,   
             'moduleid' => $new_moduleid, 
             'pipelinedealid' => $pipelinedealid,
             'tenantid'=> Session('tenantid'),
             'questiontext' => $question->questiontext,
             'questionstatus'=>$question->questionstatus,
             'displayorder' => $question->displayorder
             ]
            );
           }

        }


       
        DB::update("Update pipelinedeals set templateid='$templateid' where pipelinedealid='$pipelinedealid'");

        $templateobj=DB::table('dd_templates')->where('tenantid',$tenantid)->where('templateid',$templateid)->first();

        if(isset($templateobj))
        {
            $actiontaken=\App\Helpers\AppGlobal::$DD_template_changed;
            $actiontaken=str_replace('%%DD_TEMPLATE%%',$templateobj->name,$actiontaken);
            $userid=session('userid');
            $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
                      if(isset($user_obj))
                      {
                        $name=$user_obj->firstname.' '.$user_obj->lastname;  
                        $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
                        $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
                      }
            $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);
        }



        return response()->json(['message'=>'Success']); 

    }
    
    public function ChangeDDStatus(Request $request)
    {
        $pipelinedealid=$request->pipelinedealid;
        $ddstatus=$request->ddstatus;
        $tenantid=session('tenantid');
        $helper= \App\Helpers\AppHelper::instance();
        if(isset($pipelinedealid) && isset($ddstatus))
        {
            DB::update("Update pipelinedeals set pipelinedealstatus='$ddstatus' where pipelinedealid='$pipelinedealid'");

            $actiontaken=\App\Helpers\AppGlobal::$DD_status_updated;
            $actiontaken=str_replace('%%DD_STATUS%%',$ddstatus,$actiontaken);
            $userid=session('userid');
            $user_obj=DB::select(DB::raw("select userid,firstname,lastname from users where userid='$userid'"))[0];
                      if(isset($user_obj))
                      {
                        $name=$user_obj->firstname.' '.$user_obj->lastname;  
                        $username_with_link="<a href='/user/profile/view?user=$user_obj->userid' target='_blank'>$name</a>";
                        $actiontaken=str_replace('%%USER%%',$username_with_link,$actiontaken);
                      }

            $helper->AddRecentActivity($pipelinedealid,'DD',$actiontaken);

            return response()->json(['message'=>'Success']); 
        }
        else
        {
            return response()->json(['message'=>'Failed']); 
        }
    }

    public function Get_DD_Activities(Request $request)
    {
        $duration=$request->duration;
        $pipelinedealid=$request->pipelinedealid;
        $query=DB::table('recent_activities')
               ->where('tenantid',session('tenantid'))
               ->where('type','DD')
               ->where('entityid',$pipelinedealid);

               switch($duration)
               {
                   case "Today":
                   $query=$query->whereRaw('Date(datetime) = CURDATE()');
                   break;
                   case "7 Days":
                   $query=$query->whereRaw('Date(datetime) >= (DATE(NOW()) + INTERVAL -7 DAY)');
                   break;
                   case "14 Days":
                   $query=$query->whereRaw('Date(datetime) >= (DATE(NOW()) + INTERVAL -14 DAY)');
                   break;
                   case "Last Month":
                   $query=$query->whereRaw('YEAR(datetime) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)');
                   $query=$query->whereRaw('MONTH(datetime)=MONTH(CURRENT_DATE - INTERVAL 1 MONTH)');
                   break;
               }

               $activities=$query->select('activityid','action','datetime',DB::raw('Date(datetime) as onlydate'))->OrderBy('datetime','DESC')->get();

               $unique_activities=$activities->unique('onlydate');
        
               $view=View::make('duediligence.dashboard._dd_activities')->with('activities',$activities)->with('unique_activities',$unique_activities)->render();

               return $view;

    }
    
      
      
      
}
