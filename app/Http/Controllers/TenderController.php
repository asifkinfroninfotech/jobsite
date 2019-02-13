<?php
namespace App\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use session;
use View;

class TenderController extends Controller
{

    public function tenders(Request $request)
    {
        $calledfrom = $request->calledfrom;

        $companyid = session('companyid');
        $tenantid = session('tenantid');
        $userid = session('userid');
        //     $tid='';
        //     $cid='';
        //     if(isset($request->companyid) && !empty($request->companyid))
        //     {
        //         $companyid=$request->companyid;
        //         $cid=$request->companyid;
        //     }
        //     if(isset($request->tenantid) && !empty($request->tenantid))
        //     {
        //         $tenantid=$request->tenantid;
        //         $tid=$request->tenantid;
        //     }

        //     //$pipelinedealid=$request->pd;
        //     $tenderlists="";

        //     $tenderlists=DB::table('tp_tenders as t')
        //             ->where('t.tenantid',$tenantid)
        //             ->where('t.status','Open')
        //             ->leftjoin('deals as d','t.dealid','d.dealid')
        //             ->get();
        $deallist = "";
        $deallist = DB::table('deals as ds')
            ->where('ds.tenantid', $tenantid)
            ->where('ds.userid', $userid)
            ->leftjoin('company as c', 'c.companyid', 'ds.companyid')
            ->distinct()
            ->get();

        //    $dealcompany="";
        //    foreach ($deallist as $key => $value) {

        //         if ($dealcompany=="")
        //         {
        //          $dealcompany=$value->companyid;
        //         }
        //         else
        //         {
        //          $dealcompany=$dealcompany.",". $value->companyid;
        //         }
        //     }
        //    $involved_companies="";
        //    $involved_companies=DB::table('usercompanies as uc')
        //      ->join('users as u','u.userid','uc.userid')
        //      ->join('company as c','c.companyid','uc.companyid')
        //      ->leftjoin('companytypes as ct','ct.companytypeid','c.companytypeid')
        //      ->whereIn('uc.companyid', explode(',', $dealcompany))
        //      ->where('uc.recordstatus','Active')
        //      ->where('uc.userrole',0)
        //      ->select('uc.userid','u.firstname','u.lastname','c.companyid','c.profileimage','c.name as companyname','ct.companytype','c.name as type','uc.userrole as sorttype')
        //      ->get();

        return view('tenders.tender', compact('deallist'));

    }

    public function getTenderList(Request $request)
    {
        $companyid = session('companyid');
        $tenantid = session('tenantid');
        $userid = session('userid');

        $type = $request->type;
        $searchtext = $request->searchtext;
        $sortby = $request->sortby;
        $fdate = $request->fdate;
        $tdate = $request->tdate;

        $tendertypes = $request->tendertypes;

        $query = DB::table('tp_tenders as t')
            ->leftjoin('deals as d', 't.dealid', 'd.dealid')
            ->leftjoin('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('t.tenantid', $tenantid)
            ->where('t.companyid', $companyid)
            ->where('t.status', $type);

        if (isset($tendertypes) && !empty($tendertypes)) {
            $query->whereIn('t.type', explode(',', $tendertypes));
        }

        if ((isset($fdate) && !empty($fdate)) && (isset($tdate) && !empty($tdate))) {
            $fdate = date('Y-m-d', strtotime($fdate));
            $tdate = date('Y-m-d', strtotime($tdate));
            $query->where(function ($query) use ($fdate, $tdate) {
                $query->wheredate('t.startdate', '>=', $fdate)
                    ->wheredate('t.enddate', '<=', $tdate);
            });
            // $query->wheredate(DB::raw("t.startdate >= '$fdate' AND t.enddate <= '$tdate'"));

            // $query->wheredate('t.startdate','>=',$fdate);
            // $query->wheredate('t.enddate','>=',$tdate);

        }

        if (isset($searchtext) && !empty($searchtext)) {
            $query->where(function ($query) use ($searchtext) {
                $query->Where('c.name', 'like', '%' . $searchtext . '%')
                    ->orWhere('t.title', 'like', '%' . $searchtext . '%')
                    ->orWhere('d.projectname', 'like', '%' . $searchtext . '%');

            });
        }

        if (isset($sortby) && !empty($sortby)) {
            switch ($sortby) {
                case 'Name':
                    $query->orderBy('t.title');
                    break;
                case 'StartDate':
                    $query->orderBy('t.startdate');
                    break;
                case 'EndDate':
                    $query->orderBy('t.enddate');
                    break;
                default:

                    break;
            }

        }

        $lst_tenders = $query->select('t.tenderid', 'cn.symbol', 't.approximate_budget', 'c.companyid', 'c.name as companyname', 'c.profileimage', 'ct.companytype', 't.title', 't.startdate', 't.enddate', 't.type', DB::raw('LEFT(t.description , 150) as description'), 't.description as odes', 't.file1', 't.file2', 'd.dealid', 'd.projectname', 't.status', DB::raw('(Select Count(*) from tender_proposals where tenderid=t.tenderid) as pcount'))->get();
        $view = View::make('tenders._tender_list', compact('lst_tenders'))->render();

        return $view;

    }

    public function savenewtender(Request $request)
    {
        $mydeals = $request->mydeals;
        $tendername = $request->tender_name;
        $startdate = $request->start_date;
        $enddate = $request->end_date;
        $description = $request->description;
        $combo = $request->pri_pub_compbo;
        $helper = \App\Helpers\AppHelper::instance();
        $tenderid = $helper->fnGetUniqueID(16, 'tp_tenders', 'tenderid');
        $tenantid = session('tenantid');
        //  $deallist=$request->deallist;
        $file = $request->file('import_file');
        $file1 = $request->file('import_file1');

        $startdate = date('Y-m-d', strtotime($startdate));
        $enddate = date('Y-m-d', strtotime($enddate));

        $services_requested = $request->services_requested;
        $desired_time_frame = $request->desired_time_frame;
        $resource_requirements = $request->resource_requirements;
        $approx_budget = $request->approx_budget;

        if (isset($tendername) && !empty($tendername) && isset($startdate) && !empty($startdate) && isset($enddate) && !empty($enddate) && isset($combo) && !empty($combo)) {
            $tendersave = DB::table('tp_tenders')->insert([
                'tenantid' => $tenantid,
                'tenderid' => $tenderid,
                'companyid' => session('companyid'),
                'title' => $tendername,
                'startdate' => $startdate,
                'enddate' => $enddate,
                'description' => $description,
                'type' => $combo,

            ]);

            if (isset($mydeals) && !empty($mydeals)) {
                // for($list=0;$list<count($mydeals);$list++)
                // {
                $dealupdate = DB::table('tp_tenders')
                    ->where('tenderid', $tenderid)
                    ->update([
                        'dealid' => $mydeals[0],
                    ]);

                // }
            }

            if (isset($file) && !empty($file)) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/storage/tender/new/', $name);
                $uploaddocument1 = DB::table('tp_tenders')
                    ->where('tenderid', $tenderid)
                    ->update([
                        'file1' => $name,
                    ]);
            }

            if (isset($file1) && !empty($file1)) {
                $name1 = $file1->getClientOriginalName();
                $file1->move(public_path() . '/storage/tender/new/', $name1);
                $uploaddocument1 = DB::table('tp_tenders')
                    ->where('tenderid', $tenderid)
                    ->update([
                        'file2' => $name1,
                    ]);
            }

            if (isset($services_requested) && !empty($services_requested) && isset($desired_time_frame) && !empty($desired_time_frame) && isset($resource_requirements) && !empty($resource_requirements)) {
                $newupdate = DB::table('tp_tenders')
                    ->where('tenderid', $tenderid)
                    ->update([
                        'resource_requirements' => $resource_requirements,
                        'services_requested' => $services_requested,
                        'desired_time_frame' => $desired_time_frame,

                    ]);

            }

            if (isset($approx_budget) && !empty($approx_budget)) {
                $approxbudget = DB::table('tp_tenders')
                    ->where('tenderid', $tenderid)
                    ->update([
                        'approximate_budget' => $approx_budget,
                    ]);
            }

            return redirect()->back();
        }
    }

    public function tenderview(Request $request)
    {
        $tenderid = $request->tenderid;
        $tenantid = session('tenantid');
        $companyid = session('companyid');
        $tenderview = DB::table('tp_tenders')
            ->where('tenderid', $tenderid)
            ->leftjoin('deals', 'deals.dealid', 'tp_tenders.dealid')
            ->first();

        $userid = session('userid');
        $deallist = DB::table('deals as ds')
            ->where('ds.tenantid', $tenantid)
            ->where('ds.userid', $userid)
            ->leftjoin('company as c', 'c.companyid', 'ds.companyid')
            ->distinct()
            ->get();

        $proposals = "";
        $proposals = DB::table('tender_proposals as t')
            ->where('t.tenderid', $tenderid)
        // ->where('t.proposalstate','Accepted')
            ->leftjoin('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('tp_tenders as tp', 'tp.tenderid', 't.tenderid')
            ->leftjoin('deals as d', 'd.dealid', 't.dealid')
            ->select('*', 't.file1 as proposalfile')
            ->get();

        $symbol = DB::table('company as c')->leftjoin('currency as cy', 'cy.currencyid', 'c.currencyid')->where('c.companyid', $companyid)->select('cy.symbol')->first()->symbol;

        $view = View::make('tenders._view_tender')->with('tenderview', $tenderview)->with('deallist', $deallist)->with('symbol', $symbol)->render();
        $view1 = View::make('tenders.proposals')->with('proposals', $proposals)->render();
//         return $view;
        return response()->json(['view1' => $view, 'view2' => $view1, 'tenderid' => $tenderid]);
    }

    public function edittender(Request $request)
    {

        $tenderid = $request->tenderid;

        $tendername = $request->tendername;
        $startdate = date('Y-m-d', strtotime($request->startdate));
        $enddate = date('Y-m-d', strtotime($request->enddate));
        $description = $request->description;
        $combo = $request->privatepublic;
        $deallistview = $request->deallist;
        $file = $request->file('file1');
        $file1 = $request->file('file2');
        $services_requested = $request->services_requested;
        $desired_time_frame = $request->desired_time_frame;
        $approximate_budget = $request->approx_budget;
        $resource_requirements = $request->resource_requirements;

        $update = DB::table('tp_tenders')->where('tenderid', $tenderid)
            ->update([
                'title' => $tendername,
                'startdate' => $startdate,
                'enddate' => $enddate,
                'description' => $description,
                'type' => $combo,
                'services_requested' => $services_requested,
                'approximate_budget' => $approximate_budget,
                'resource_requirements' => $resource_requirements,
                'desired_time_frame' => $desired_time_frame,

            ]);

        if (isset($deallistview) && !empty($deallistview)) {

            $updatedeal = DB::table('tp_tenders')
                ->where('tenderid', $tenderid)
                ->update(
                    [
                        'dealid' => $deallistview,
                    ]
                );

        }
        if (isset($file) && !empty($file)) {
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/storage/tender/new/', $name);

            $updatedeal = DB::table('tp_tenders')
                ->where('tenderid', $tenderid)
                ->update(
                    [
                        'file1' => $name,
                    ]
                );

        }
        if (isset($file1) && !empty($file1)) {
            $name1 = $file1->getClientOriginalName();
            $file1->move(public_path() . '/storage/tender/new/', $name1);
            $updatedeal = DB::table('tp_tenders')
                ->where('tenderid', $tenderid)
                ->update(
                    [
                        'file2' => $name1,
                    ]
                );

        }
        $tenderviewlist = DB::table('tp_tenders as t')
            ->join('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('tenderid', $tenderid)
            ->select('t.*', 'c.companyid', 'c.name as company', 'ct.companytype', 'c.profileimage', 'cn.symbol')
            ->first();
        $type = $tenderviewlist->type;
        $status = $tenderviewlist->status;

        $view = View::make('tenders._view_tender_list')->with('tenderviewlist', $tenderviewlist)->render();

        return response()->json(['view' => $view, 'type' => $type, 'status' => $status]);

//       return redirect()->back();
    }

    public function fetchthirdpartyusers(Request $request)
    {
//        $pipelinedealid=$request->pipelinedealid;
        $tenantid = session('tenantid');
        //Left for future use.
        $usertype = session('usertype');
        $selectcompanytype = "";
        $selectcompanytype = DB::table('companytypes')->where('companytype', $usertype)->first()->companytypeid;
        $gettenantcompany = DB::table('company')
            ->where('tenantid', $tenantid)
            ->where('companytypeid', '<>', $selectcompanytype)
            ->get();
        $view = View::make('tenders._assign_tenders')->with('gettenantcompany', $gettenantcompany)->render();
        return $view;
    }

    public function sendthirdparty(Request $request)
    {
        $checkbox = json_decode($request->checkboxarr);

        $helper = \App\Helpers\AppHelper::instance();
        $tenantid = session('tenantid');
        $tenderid = $request->tenderid;
        $dealid = $request->dealid;

        for ($i = 0; $i < count($checkbox); $i++) {
            $proposalid = $helper->fnGetUniqueID(16, 'tender_proposals', 'proposalid');
            $insertnewthirdparty = DB::table('tender_proposals')->insert([
                'proposalid' => $proposalid,
                'dealid' => $dealid,
                'companyid' => $checkbox[$i],
                'tenderid' => $tenderid,
                'proposalstate' => 'Accepted',
                'date_accepted' => date("Y-m-d"),
            ]);

            //for selecting the companyname

            $company_receiver = DB::table('company')->where('companyid', $checkbox[$i])->first();
            $tender_info = DB::table('tp_tenders as t')
                ->leftjoin('company as c', 'c.companyid', 't.companyid')
                ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
                ->where('tenderid', $tenderid)
                ->select('c.companyid', 'c.name as company', 'ct.companytype', 't.title as tendername', 't.tenderid')
                ->first();

            //for sending emails
            $TemplateCode = \App\Helpers\AppGlobal::$Send_Invite_To_Bid_TemplateCode;
            if (isset($TemplateCode)) {
                $TemplateMaster = DB::table('email_master_templates')->first();
                if (isset($TemplateMaster)) {
                    $Template = DB::table('email_templates')->where('code', $TemplateCode)->first();
                    if (isset($Template)) {
                        $MessageBody = $Template->message;
                        $UserName = $helper->GetCompanyAdminUserName($checkbox[$i]);
                        $MessageBody = str_replace("%%PLATFORMNAME%%", session('platformname'), $MessageBody);
                        $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
                        $MessageBody = str_replace("%%LOGIN_LINK%%", $loginlink, $MessageBody);
                        $MessageBody = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $MessageBody);
                        $MessageBody = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $MessageBody);

                        $tenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=at';
                        $MessageBody = str_replace("%%TENDER_LINK%%", $tenderlink, $MessageBody);
                        $MessageBody = str_replace("%%TENDER_NAME%%", $tender_info->tendername, $MessageBody);

                        $companylink = \App\Helpers\AppGlobal::$App_Domain . '/company/profile/view?company=' . $tender_info->companyid . '&companytype=' . $tender_info->companytype;
                        $MessageBody = str_replace("%%COMPANY_LINK%%", $companylink, $MessageBody);
                        $MessageBody = str_replace("%%COMPANY%%", $tender_info->company, $MessageBody);

                        $acceptedTenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=at';
                        $MessageBody = str_replace("%%ACCEPTED_TENDER_LINK%%", $acceptedTenderlink, $MessageBody);

                        $Message_with_master = $TemplateMaster->content;
                        $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
                        $Message_with_master = str_replace('%%EMAILCONTENT%%', $MessageBody, $Message_with_master);

                        $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
                        $Message_with_master = str_replace("%%LOGIN_LINK%%", $loginlink, $Message_with_master);
                        $Message_with_master = str_replace("%%FORGETPWD_LINK%%", $forgetpwdlink, $Message_with_master);
                        $logo = session('tenant_logo');
                        $t_logo = '';
                        if ((isset($logo) && !empty($logo)) && File::exists(public_path('/storage/tenant/logoimage/' . $logo)) == true) {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                        } else {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . "/img/logo_desktop.png";
                        }
                        $Message_with_master = str_replace("%%EMAIL_LOGO_LINK%%", $t_logo, $Message_with_master);
                        $Message_with_master = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%PRIVACYPOLICY_LINK%%", session('tenant_privacy_policy_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_NAME%%", session('tenant_company'), $Message_with_master);
                        $Message_with_master = str_replace("%%YEAR%%", date('Y'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_ADDRESS%%", $helper->getCompleteAddress('tenant', $tenantid), $Message_with_master);

                        $Message_with_master = $helper->getSocialLinks('tenant', $tenantid, $Message_with_master);
                        $Template->fromname = session('tenant_from_name');
                        $Template->fromemail = session('tenant_from_email');
                        $company_email = $helper->GetCompanyAdminUserEmail($checkbox[$i]);
                        if (isset($company_email)) {
                            $helper->SendEmail($Template, $company_email, $Message_with_master);
                        }

                    }
                }

            }

        }

        $proposals = "";
        $proposals = DB::table('tender_proposals as t')
            ->where('t.tenderid', $tenderid)
        // ->where('t.proposalstate','Accepted')
            ->leftjoin('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('tp_tenders as tp', 'tp.tenderid', 't.tenderid')
            ->leftjoin('deals as d', 'd.dealid', 't.dealid')
            ->select('*', 't.file1 as proposalfile')
            ->get();

        $view = View::make('tenders.proposals')->with('proposals', $proposals)->render();
        return $view;

    }

    public function saveproposaldocs(Request $request)
    {
        $proposalid = $request->proposalid;
        $tenderid = $request->tenderid;
//        $file = $request->file('import_proposal');

        $file = $request->file('uploadFiles');

        if (isset($file) && !empty($file)) {
            $name = $file->getClientOriginalName();

            $file->move(public_path() . '/storage/proposal/', $name);

            $updateproposal = DB::table('tender_proposals')
                ->where('proposalid', $proposalid)
                ->update(
                    [
                        'file1' => $name,
                    ]
                );

        }

        $proposals = "";
        $proposals = DB::table('tender_proposals as t')
            ->where('t.tenderid', $tenderid)
            ->where('t.proposalstate', 'Bid Accepted')
            ->leftjoin('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('tp_tenders as tp', 'tp.tenderid', 't.tenderid')
            ->leftjoin('deals as d', 'd.dealid', 't.dealid')
            ->select('*', 't.file1 as proposalfile')
            ->get();

        $view = View::make('tenders.proposals')->with('proposals', $proposals)->render();
        return $view;

    }

    public function closetender(Request $request)
    {
        $helper = \App\Helpers\AppHelper::instance();
        $tenderid = $request->tender;
        $tenantid = session('tenantid');
        if (isset($tenderid) && !empty($tenderid)) {
            DB::table('tp_tenders')
                ->where('tenderid', $tenderid)
                ->update([
                    'status' => 'Closed',
                ]);

            $getproposallist = "";
            $getproposallist = DB::Table('tender_proposals')
                ->where('tenderid', $tenderid)
                ->get();
            if (isset($getproposallist) && !empty($getproposallist)) {

                $getrejectedlist = DB::table('tender_proposals')
                    ->where('tenderid', $tenderid)
                    ->where('proposalstate', '<>', 'Bid Accepted')
                    ->select('proposalid')
                    ->get();

                foreach ($getrejectedlist as $reject) {

                    $tender_info = DB::table('tender_proposals as tp')
                        ->leftjoin('tp_tenders as t', 't.tenderid', 'tp.tenderid')
                        ->leftjoin('company as c', 'c.companyid', 'tp.companyid')
                        ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
                        ->where('tp.proposalid', $reject->proposalid)
                        ->select('c.companyid', 'c.name as company', 'ct.companytype', 't.title as tendername', 't.tenderid')
                        ->first();

                    //for sending emails
                    $TemplateCode = \App\Helpers\AppGlobal::$Bid_Rejected_By_Tender_Owner_TemplateCode;
                    if (isset($TemplateCode)) {
                        $TemplateMaster = DB::table('email_master_templates')->first();
                        if (isset($TemplateMaster)) {
                            $Template = DB::table('email_templates')->where('code', $TemplateCode)->first();
                            if (isset($Template)) {
                                $MessageBody = $Template->message;
//                  $UserName=$helper->GetCompanyAdminUserName($checkbox[$i]);
                                $MessageBody = str_replace("%%PLATFORMNAME%%", session('platformname'), $MessageBody);
                                $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
                                $MessageBody = str_replace("%%LOGIN_LINK%%", $loginlink, $MessageBody);
                                $MessageBody = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $MessageBody);
                                $MessageBody = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $MessageBody);

                                $tenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=ba';
                                $MessageBody = str_replace("%%TENDER_LINK%%", $tenderlink, $MessageBody);
                                $MessageBody = str_replace("%%TENDER_NAME%%", $tender_info->tendername, $MessageBody);

                                $companylink = \App\Helpers\AppGlobal::$App_Domain . '/company/profile/view?company=' . $tender_info->companyid . '&companytype=' . $tender_info->companytype;
                                $MessageBody = str_replace("%%COMPANY_LINK%%", $companylink, $MessageBody);
                                $MessageBody = str_replace("%%COMPANY%%", $tender_info->company, $MessageBody);

                                $rejectedTenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=br';
                                $MessageBody = str_replace("%%REJECTED_TENDER_LINK%%", $rejectedTenderlink, $MessageBody);

                                $Message_with_master = $TemplateMaster->content;
                                $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
                                $Message_with_master = str_replace('%%EMAILCONTENT%%', $MessageBody, $Message_with_master);

                                $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
                                $Message_with_master = str_replace("%%LOGIN_LINK%%", $loginlink, $Message_with_master);
                                $Message_with_master = str_replace("%%FORGETPWD_LINK%%", $forgetpwdlink, $Message_with_master);
                                $logo = session('tenant_logo');
                                $t_logo = '';
                                if ((isset($logo) && !empty($logo)) && File::exists(public_path('/storage/tenant/logoimage/' . $logo)) == true) {
                                    $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                                } else {
                                    $t_logo = \App\Helpers\AppGlobal::$App_Domain . "/img/logo_desktop.png";
                                }
                                $Message_with_master = str_replace("%%EMAIL_LOGO_LINK%%", $t_logo, $Message_with_master);
                                $Message_with_master = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $Message_with_master);
                                $Message_with_master = str_replace("%%PRIVACYPOLICY_LINK%%", session('tenant_privacy_policy_link'), $Message_with_master);
                                $Message_with_master = str_replace("%%COMPANY_NAME%%", session('tenant_company'), $Message_with_master);
                                $Message_with_master = str_replace("%%YEAR%%", date('Y'), $Message_with_master);
                                $Message_with_master = str_replace("%%COMPANY_ADDRESS%%", $helper->getCompleteAddress('tenant', $tenantid), $Message_with_master);

                                $Message_with_master = $helper->getSocialLinks('tenant', $tenantid, $Message_with_master);
                                $Template->fromname = session('tenant_from_name');
                                $Template->fromemail = session('tenant_from_email');
                                $company_email = $helper->GetCompanyAdminUserEmail($tender_info->companyid);
                                if (isset($company_email)) {
                                    $helper->SendEmail($Template, $company_email, $Message_with_master);
                                }

                            }
                        }

                    }

                }

                DB::table('tender_proposals')
                    ->where('tenderid', $tenderid)
                    ->where('proposalstate', '<>', 'Bid Accepted')
                    ->update([
                        'proposalstate' => 'Bid Rejected',
                    ]);

            }
        }
    }

    public function close(Request $request)
    {
        $calledfrom = $request->calledfrom;

        $companyid = session('companyid');
        $tenantid = session('tenantid');
        $userid = session('userid');
        $tid = '';
        $cid = '';
        if (isset($request->companyid) && !empty($request->companyid)) {
            $companyid = $request->companyid;
            $cid = $request->companyid;
        }
        if (isset($request->tenantid) && !empty($request->tenantid)) {
            $tenantid = $request->tenantid;
            $tid = $request->tenantid;
        }

        //$pipelinedealid=$request->pd;
        $tenderlists = "";

        $tenderlists = DB::table('tp_tenders as t')
            ->where('t.tenantid', $tenantid)
            ->where('t.status', 'Closed')
            ->leftjoin('deals as d', 't.dealid', 'd.dealid')
            ->get();
        $deallist = "";

        $deallist = DB::table('deals as ds')
            ->where('ds.tenantid', $tenantid)
            ->where('ds.userid', $userid)
            ->leftjoin('company as c', 'c.companyid', 'ds.companyid')
            ->distinct()
            ->get();

        $dealcompany = "";
        foreach ($deallist as $key => $value) {

            if ($dealcompany == "") {
                $dealcompany = $value->companyid;
            } else {
                $dealcompany = $dealcompany . "," . $value->companyid;
            }
        }
        $involved_companies = "";
        $involved_companies = DB::table('usercompanies as uc')
            ->join('users as u', 'u.userid', 'uc.userid')
            ->join('company as c', 'c.companyid', 'uc.companyid')
            ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->whereIn('uc.companyid', explode(',', $dealcompany))
            ->where('uc.recordstatus', 'Active')
            ->where('uc.userrole', 0)
            ->select('uc.userid', 'u.firstname', 'u.lastname', 'c.companyid', 'c.profileimage', 'c.name as companyname', 'ct.companytype', 'c.name as type', 'uc.userrole as sorttype')
            ->get();

        return view('tenders.closedtender', compact('calledfrom', 'cid', 'tid', 'tenderlists', 'deallist', 'involved_companies'));

    }

    public function GetTenderNewForm()
    {
        $companyid = session('companyid');

        $symbol = DB::table('company as c')->leftjoin('currency as cy', 'cy.currencyid', 'c.currencyid')->where('c.companyid', $companyid)->select('cy.symbol')->first()->symbol;

        if(!isset($symbol) || empty($symbol))
        {
           $symbol = \App\Helpers\AppGlobal::$Default_Currency_Symbol;
        }

        $view = View::make('tenders._new_tender')->with('symbol', $symbol)->render();
        return $view;

    }

    public function GetDealsForTenderForm(Request $request)
    {
        $filter = trim($request->q);
        // $filter = $request->filter;
        $tenantid = session('tenantid');

        $query = DB::table('deals as d')->where('d.tenantid', $tenantid);
        if (isset($filter) && !empty($filter)) {
            $query->where(function ($query) use ($filter) {
                $query->where('d.projectname', 'like', '%' . $filter . '%');

            });
        }

        $result = $query->select('d.dealid as id', 'd.projectname as text')->get();

        return json_encode($result);

    }

    public function gettenderviewfromtenderid(Request $request)
    {
        $tenderid = $request->tenderid;
        $tenderviewlist = DB::table('tp_tenders as t')
            ->join('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('tenderid', $tenderid)
            ->select('t.*', 'c.companyid', 'c.name as company', 'ct.companytype', 'c.profileimage', 'cn.symbol')
            ->first();
        $type = $tenderviewlist->type;
        $status = $tenderviewlist->status;
        // $companyid=session('companyid');
        // $getcompanydetails=DB::table('company')
        //         ->where('company.companyid',$companyid)
        //         ->leftjoin('companytypes','company.companytypeid','companytypes.companytypeid')
        //         ->select('companyid','name as company','profileimage','companytypes.companytype')
        //         ->first();
        // $symbol=DB::table('company as c')->leftjoin('currency as cy','cy.currencyid','c.currencyid')->where('c.companyid',$companyid)->select('cy.symbol')->first()->symbol;
        // $view=View::make('tenders._view_tender_list')->with('tenderviewlist',$tenderviewlist)->with('symbol',$symbol)->with('getcompanydetails',$getcompanydetails)->render();

        $view = View::make('tenders._view_tender_list')->with('tenderviewlist', $tenderviewlist)->render();

        return response()->json(['view' => $view, 'type' => $type, 'status' => $status]);

    }
    public function getcompanieslist(Request $request)
    {
        $tenantid = session('tenantid');
        $searchtem = $request->search;
        $gettenantcompany = DB::table('company')
            ->where('tenantid', $tenantid)
            ->where('companytypeid', '=', 'b5aa1d')
            ->where('name', 'like', "%s%")
            ->first();
        $results = [];
        foreach ($gettenantcompany as $tenantcompany) {
            $results = array('id' => $gettenantcompany->companyid, 'text' => $gettenantcompany->name);
        }

        return response()->json(['items' => $results]);

    }

    public function singleproposalview(Request $request)
    {
        $proposalid = $request->proposalid;

        $proposaldata = DB::table('tender_proposals as tp')
            ->leftjoin('company as c', 'c.companyid', 'tp.companyid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('proposalid', $proposalid)
            ->select('c.name as company', 'cn.symbol', 'tp.*')
            ->first();
        $view = View::make('tenders._view_single_proposal')->with('proposaldata', $proposaldata)->render();
        return $view;

    }

    public function fetchcompanydata(Request $request)
    {
        $filter = $request->filter;
        $select = $request->selectoption;
        $tenantid = session('tenantid');
        $tenderid = $request->tenderid;
        $companyid = session('companyid');
        $usertype = session('usertype');
        $usertypecode = DB::table('companytypes')->where('companytype', $usertype)->select('companytypeid')->first()->companytypeid;

        $proposaltable = "";
        $companyids = "";
        $proposaltable = DB::table('tender_proposals as tp')
            ->where('tenderid', $tenderid)
            ->orWhere(function ($query) {
                $query->where('proposalstate', '=', 'Accepted')
                    ->where('proposalstate', '=', 'Bid Accepted');
            })
            ->get();
        if (isset($proposaltable) && !empty($proposaltable) && count($proposaltable) > 0) {
            foreach ($proposaltable as $key => $value) {
                if ($companyids == "") {
                    $companyids = $value->companyid;
                } else {
                    $companyids = $companyids . "," . $value->companyid;
                }
            }
        }

        $query = DB::table('company as c')->where('tenantid', $tenantid)->where('companytypeid', '<>', $usertypecode);
        if (isset($filter) && !empty($filter)) {
            $query->where(function ($query) use ($filter) {
                $query->where('c.name', 'like', '%' . $filter . '%');

            });
        }
        if (isset($select) && !empty($select)) {

            $query->where(function ($query) use ($select) {
                $query->where('c.companytypeid', '=', $select);

            });
        }

        if (isset($companyids) && !empty($companyids)) {
            $query->wherenotIn('c.companyid', explode(',', $companyids));
        }

        $getcompanydata = $query->get();

        $result = [];
        $row = [];
        $cont = 0;
        foreach ($getcompanydata as $companydata) {
            $row[$cont] = array('id' => $companydata->companyid, 'text' => $companydata->name);
            $result[$cont] = $row[$cont];
            $cont++;
        }

        return json_encode($result);

    }

    //Extra
    //

    //Latest changes 9192018 5:11

    public function acceptbid(Request $request)
    {
        $tenantid = session('tenantid');
        $helper = \App\Helpers\AppHelper::instance();
        $proposalid = $request->proposalid;
        if (isset($proposalid) && !empty($proposalid)) {
            $accept = DB::table('tender_proposals')
                ->where('proposalid', $proposalid)
                ->update([
                    'proposalstate' => 'Bid Accepted',
                ]);

            $tender_info = DB::table('tender_proposals as tp')
                ->leftjoin('tp_tenders as t', 't.tenderid', 'tp.tenderid')
                ->leftjoin('company as c', 'c.companyid', 'tp.companyid')
                ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
                ->where('tp.proposalid', $proposalid)
                ->select('c.companyid', 'c.name as company', 'ct.companytype', 't.title as tendername', 't.tenderid')
                ->first();

            //for sending emails
            $TemplateCode = \App\Helpers\AppGlobal::$Bid_Accepted_By_Tender_Owner_TemplateCode;
            if (isset($TemplateCode)) {
                $TemplateMaster = DB::table('email_master_templates')->first();
                if (isset($TemplateMaster)) {
                    $Template = DB::table('email_templates')->where('code', $TemplateCode)->first();
                    if (isset($Template)) {
                        $MessageBody = $Template->message;

                        $MessageBody = str_replace("%%PLATFORMNAME%%", session('platformname'), $MessageBody);
                        $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
                        $MessageBody = str_replace("%%LOGIN_LINK%%", $loginlink, $MessageBody);
                        $MessageBody = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $MessageBody);
                        $MessageBody = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $MessageBody);

                        $tenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=ba';
                        $MessageBody = str_replace("%%TENDER_LINK%%", $tenderlink, $MessageBody);
                        $MessageBody = str_replace("%%TENDER_NAME%%", $tender_info->tendername, $MessageBody);

                        $companylink = \App\Helpers\AppGlobal::$App_Domain . '/company/profile/view?company=' . $tender_info->companyid . '&companytype=' . $tender_info->companytype;
                        $MessageBody = str_replace("%%COMPANY_LINK%%", $companylink, $MessageBody);
                        $MessageBody = str_replace("%%COMPANY%%", $tender_info->company, $MessageBody);

                        $acceptedTenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=ba';
                        $MessageBody = str_replace("%%ACCEPTED_TENDER_LINK%%", $acceptedTenderlink, $MessageBody);

                        $Message_with_master = $TemplateMaster->content;
                        $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
                        $Message_with_master = str_replace('%%EMAILCONTENT%%', $MessageBody, $Message_with_master);

                        $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
                        $Message_with_master = str_replace("%%LOGIN_LINK%%", $loginlink, $Message_with_master);
                        $Message_with_master = str_replace("%%FORGETPWD_LINK%%", $forgetpwdlink, $Message_with_master);
                        $logo = session('tenant_logo');
                        $t_logo = '';
                        if ((isset($logo) && !empty($logo)) && File::exists(public_path('/storage/tenant/logoimage/' . $logo)) == true) {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                        } else {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . "/img/logo_desktop.png";
                        }
                        $Message_with_master = str_replace("%%EMAIL_LOGO_LINK%%", $t_logo, $Message_with_master);
                        $Message_with_master = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%PRIVACYPOLICY_LINK%%", session('tenant_privacy_policy_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_NAME%%", session('tenant_company'), $Message_with_master);
                        $Message_with_master = str_replace("%%YEAR%%", date('Y'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_ADDRESS%%", $helper->getCompleteAddress('tenant', $tenantid), $Message_with_master);

                        $Message_with_master = $helper->getSocialLinks('tenant', $tenantid, $Message_with_master);
                        $Template->fromname = session('tenant_from_name');
                        $Template->fromemail = session('tenant_from_email');
                        $company_email = $helper->GetCompanyAdminUserEmail($tender_info->companyid);
                        if (isset($company_email)) {
                            $helper->SendEmail($Template, $company_email, $Message_with_master);
                        }

                    }
                }

            }

        }
        $getproposal = "";

        $getproposal = DB::Table('tender_proposals')
            ->where('proposalid', $proposalid)
            ->first();
        $tenderid = "";
        $dealid = "";
        if (isset($getproposal->tenderid)) {
            $tenderid = $getproposal->tenderid;

        }
        if (isset($getproposal->dealid)) {
            $dealid = $getproposal->dealid;
        }
        return response()->json(['tenderid' => $tenderid, 'dealid' => $dealid]);

//      $proposals="";
        //      $proposals=DB::table('tender_proposals as t')
        //                ->where('t.proposalid',$proposalid)
        //                ->where('t.proposalstate','Accepted')
        //                ->leftjoin('company as c','c.companyid','t.companyid')
        //                ->leftjoin('tp_tenders as tp','tp.tenderid','t.tenderid')
        //                ->leftjoin('deals as d','d.dealid','t.dealid')
        //                ->select('*','t.file1 as proposalfile')
        //                ->get();
        //
        //
        //         $view1=View::make('tenders.proposals')->with('proposals',$proposals)->render();
        //
        //      return $view1;

    }
    public function rejectbid(Request $request)
    {
        $tenantid = session('tenantid');
        $helper = \App\Helpers\AppHelper::instance();
        $proposalid = $request->proposalid;
        if (isset($proposalid) && !empty($proposalid)) {
            $reject = DB::table('tender_proposals')
                ->where('proposalid', $proposalid)
                ->update([
                    'proposalstate' => 'Bid Rejected'
                ]);

            $tender_info = DB::table('tender_proposals as tp')
                ->leftjoin('tp_tenders as t', 't.tenderid', 'tp.tenderid')
                ->leftjoin('company as c', 'c.companyid', 'tp.companyid')
                ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
                ->where('proposalid', $proposalid)
                ->select('c.companyid', 'c.name as company', 'ct.companytype', 't.title as tendername', 't.tenderid')
                ->first();

            //for sending emails
            $TemplateCode = \App\Helpers\AppGlobal::$Bid_Rejected_By_Tender_Owner_TemplateCode;
            if (isset($TemplateCode)) {
                $TemplateMaster = DB::table('email_master_templates')->first();
                if (isset($TemplateMaster)) {
                    $Template = DB::table('email_templates')->where('code', $TemplateCode)->first();
                    if (isset($Template)) {
                        $MessageBody = $Template->message;
//                  $UserName=$helper->GetCompanyAdminUserName($checkbox[$i]);
                        $MessageBody = str_replace("%%PLATFORMNAME%%", session('platformname'), $MessageBody);
                        $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
                        $MessageBody = str_replace("%%LOGIN_LINK%%", $loginlink, $MessageBody);
                        $MessageBody = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $MessageBody);
                        $MessageBody = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $MessageBody);

                        $tenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=ba';
                        $MessageBody = str_replace("%%TENDER_LINK%%", $tenderlink, $MessageBody);
                        $MessageBody = str_replace("%%TENDER_NAME%%", $tender_info->tendername, $MessageBody);

                        $companylink = \App\Helpers\AppGlobal::$App_Domain . '/company/profile/view?company=' . $tender_info->companyid . '&companytype=' . $tender_info->companytype;
                        $MessageBody = str_replace("%%COMPANY_LINK%%", $companylink, $MessageBody);
                        $MessageBody = str_replace("%%COMPANY%%", $tender_info->company, $MessageBody);

                        $rejectedTenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=br';
                        $MessageBody = str_replace("%%REJECTED_TENDER_LINK%%", $rejectedTenderlink, $MessageBody);

                        $Message_with_master = $TemplateMaster->content;
                        $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
                        $Message_with_master = str_replace('%%EMAILCONTENT%%', $MessageBody, $Message_with_master);

                        $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
                        $Message_with_master = str_replace("%%LOGIN_LINK%%", $loginlink, $Message_with_master);
                        $Message_with_master = str_replace("%%FORGETPWD_LINK%%", $forgetpwdlink, $Message_with_master);
                        $logo = session('tenant_logo');
                        $t_logo = '';
                        if ((isset($logo) && !empty($logo)) && File::exists(public_path('/storage/tenant/logoimage/' . $logo)) == true) {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                        } else {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . "/img/logo_desktop.png";
                        }
                        $Message_with_master = str_replace("%%EMAIL_LOGO_LINK%%", $t_logo, $Message_with_master);
                        $Message_with_master = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%PRIVACYPOLICY_LINK%%", session('tenant_privacy_policy_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_NAME%%", session('tenant_company'), $Message_with_master);
                        $Message_with_master = str_replace("%%YEAR%%", date('Y'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_ADDRESS%%", $helper->getCompleteAddress('tenant', $tenantid), $Message_with_master);

                        $Message_with_master = $helper->getSocialLinks('tenant', $tenantid, $Message_with_master);
                        $Template->fromname = session('tenant_from_name');
                        $Template->fromemail = session('tenant_from_email');
                        $company_email = $helper->GetCompanyAdminUserEmail($tender_info->companyid);
                        if (isset($company_email)) {
                            $helper->SendEmail($Template, $company_email, $Message_with_master);
                        }

                    }
                }

            }

        }
        $getproposal = "";

        $getproposal = DB::Table('tender_proposals')
            ->where('proposalid', $proposalid)
            ->first();
        $tenderid = "";
        $dealid = "";
        if (isset($getproposal->tenderid)) {
            $tenderid = $getproposal->tenderid;

        }
        if (isset($getproposal->dealid)) {
            $dealid = $getproposal->dealid;
        }
        return response()->json(['tenderid' => $tenderid, 'dealid' => $dealid]);

    }

    //End Of Extra

    public function ViewOtherTenders(Request $request)
    {
        $tc = $request->tc;
        return view('tenders.view_tenders.view_tenders', compact('tc'));
    }

    public function GetOtherCompanies_Tenders(Request $request)
    {
        $companyid = session('companyid');
        $tenantid = session('tenantid');
        $userid = session('userid');

        $searchtext = $request->searchtext;
        $sortby = $request->sortby;
        $fdate = $request->fromdate;
        $tdate = $request->todate;

        $activetabpage = $request->activetab;

        $query = DB::table('tp_tenders as t')
            ->leftjoin('deals as d', 't.dealid', 'd.dealid')
            ->leftjoin('company as c', 'c.companyid', 't.companyid')
            ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('t.tenantid', $tenantid)
            ->where('t.companyid', '<>', $companyid);

        $query->leftjoin('tender_proposals as tp', function ($join) use ($companyid) {
            $join->on('tp.tenderid', '=', 't.tenderid');
            $join->where('tp.companyid', '=', $companyid);
        });

        switch ($activetabpage) {
            case "open tenders":
                $query->where('t.type', 'Public');
                $query->where('t.status', 'Open');
                $query->whereNull('tp.proposalid');

                break;

            case "accepted tenders":

                $query->where('t.status', 'Open');
                $query->where('tp.proposalstate', 'Accepted');
                break;

            case "bid submitted":
                $query->where('t.status', 'Open');
                $query->where('tp.proposalstate', 'Submitted');
                break;

            case "bid accepted":
                $query->where('tp.proposalstate', 'Bid Accepted');
                break;

            case "bid rejected":
                $query->where('tp.proposalstate', 'Bid Rejected');
                break;

        }

        if ((isset($fdate) && !empty($fdate)) && (isset($tdate) && !empty($tdate))) {
            $fdate = date('Y-m-d', strtotime($fdate));
            $tdate = date('Y-m-d', strtotime($tdate));
            $query->where(function ($query) use ($fdate, $tdate) {
                $query->wheredate('t.startdate', '>=', $fdate)
                    ->wheredate('t.enddate', '<=', $tdate);
            });
        }

        if (isset($searchtext) && !empty($searchtext)) {
            $query->where(function ($query) use ($searchtext) {
                $query->Where('c.name', 'like', '%' . $searchtext . '%')
                    ->orWhere('t.title', 'like', '%' . $searchtext . '%')
                    ->orWhere('d.projectname', 'like', '%' . $searchtext . '%');

            });
        }

        if (isset($sortby) && !empty($sortby)) {
            switch ($sortby) {
                case 'Name':
                    $query->orderBy('t.title');
                    break;
                case 'StartDate':
                    $query->orderBy('t.startdate');
                    break;
                case 'EndDate':
                    $query->orderBy('t.enddate');
                    break;
                default:

                    break;
            }

        }

        $pagesize = 5;

        $lst_tenders = $query->select('tp.proposalid', 't.tenderid', 't.approximate_budget', 'cn.symbol', 'c.companyid', 'c.name as companyname', 'c.profileimage', 'ct.companytype', 't.title', 't.startdate', 't.enddate', 't.type', DB::raw('LEFT(t.description , 150) as description'), 't.description as odes', 't.file1', 't.file2', 'd.dealid', 'd.projectname', 't.status', DB::raw('(Select Count(*) from tender_proposals where tenderid=t.tenderid) as pcount'))->paginate($pagesize);

        if (isset($lst_tenders[0])) {
            $view = View::make('tenders.view_tenders._tender_list', compact('lst_tenders', 'activetabpage'))->render();
            return $view;
        } else {
            $view = '<div class="project-box mar-one-rem"><div class="project-info">' . trans('view_tender.not_found_tender_message') . '</div></div>';
            echo $view;
        }

    }

    public function ViewSingleTender(Request $request)
    {
        $tenderid = $request->tid;
        $tenderviewlist = DB::table('tp_tenders as t')
            ->join('company as c', 'c.companyid', 't.companyid')
            ->join('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('tenderid', $tenderid)
            ->select('c.name as company', 'c.profileimage', 'ct.companytype', 'cn.symbol', 't.*')
            ->first();
        $type = $tenderviewlist->type;

        $view = View::make('tenders.view_tenders.single_tender_view')->with('tenderviewlist', $tenderviewlist)->render();

        return $view;
    }

    public function AcceptTender(Request $request)
    {
        $tenderid = $request->tid;
        $companyid = session('companyid');
        $helper = \App\Helpers\AppHelper::instance();

        $t_obj = DB::table('tp_tenders')->where('tenderid', $tenderid)->first();
        $dealid = '';
        if (isset($t_obj)) {
            $dealid = $t_obj->dealid;
        }

        $proposalid = $helper->fnGetUniqueID(16, 'tender_proposals', 'proposalid');
        DB::table('tender_proposals')->insert([
            'proposalid' => $proposalid,
            'dealid' => $dealid,
            'companyid' => $companyid,
            'tenderid' => $tenderid,
            'proposalstate' => 'Accepted',
        ]);

        DB::update(DB::raw("Update tender_proposals set date_accepted=UTC_TIMESTAMP where proposalid='$proposalid'"));

        return response()->json(['message' => 'Y']);

    }

    public function tender_bidding_page(Request $request)
    {
        $tenderid = $request->tid;
        $companyid = session('companyid');
        $tender_proposals = DB::table('tender_proposals as tp')
            ->join('company as c', 'c.companyid', 'tp.companyid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('tp.tenderid', $tenderid)
            ->where('tp.companyid', $companyid)
            ->select('cn.symbol', 'tp.*')
            ->first();

        $view1 = View::make('tenders.view_tenders.bidding_info')->with('tender_proposals', $tender_proposals)->render();
        return $view1;

    }

    public function tender_bidding_view(Request $request)
    {
        $proposalid = $request->pid;

        $proposaldata = DB::table('tender_proposals as tp')
            ->join('company as c', 'c.companyid', 'tp.companyid')
            ->where('tp.proposalid', $proposalid)
            ->select('c.name as company', 'tp.*')
            ->first();

        $tenderviewlist = DB::table('tp_tenders as t')
            ->join('company as c', 'c.companyid', 't.companyid')
            ->join('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
            ->leftjoin('currency as cn', 'cn.currencyid', 'c.currencyid')
            ->where('tenderid', $proposaldata->tenderid)
            ->select('c.name as company', 'c.profileimage', 'ct.companytype', 'cn.symbol', 't.*')
            ->first();

        $view = View::make('tenders.view_tenders.bidding_info_view')->with('proposaldata', $proposaldata)->with('tenderviewlist', $tenderviewlist)->render();
        return $view;
    }

    public function biddinginfosave(Request $request)
    {
        //   print_r($request->all());

        $proposalid = $request->proposalid;
        $companyid = $request->companyid;
        $proposalheading = $request->proposalheading;
        //   $desiredtrimeframe=$request->desiredtimeframe;
        //   $resourcerequirement=$request->resourcerequirement;
        //   $approximatebudget=$request->approximatebudget;
        $quotemount = $request->quoteamount;
        //   $servicerequested=$request->servicerequested;
        $peopleinvolved = $request->peopleinvolved;
        $durationtocomplete = $request->durationtocomplete;
        $whyconsideryou = $request->whyconsideryou;
        $shortdescription = $request->shortdescription;
        $additionalinfo = $request->additionalinfo;

        $saveproposal = DB::table('tender_proposals')->where('proposalid', $proposalid)
            ->where('companyid', $companyid)
            ->update([
                'proposal_heading' => $proposalheading,
                //  'desired_time_frame'=>$desiredtrimeframe,
                //  'resource_requirements'=>$resourcerequirement,
                //  'approximate_budget'=>$approximatebudget,
                'quoteamount' => $quotemount,
                //  'services_requested'=>$servicerequested,
                'people_involved' => $peopleinvolved,
                'duration_to_complete' => $durationtocomplete,
                'why_consider_you' => $whyconsideryou,
                'short_description' => $shortdescription,
                'additional_info' => $additionalinfo,
            ]);

        $file = $request->file('import_file');

        if (isset($file) && !empty($file)) {

            $name = $file->getClientOriginalName();
            $fileName = str_random(7);
            $extension = $file->getClientOriginalExtension();
            $filename = $fileName . "." . $extension;

            $file->move(public_path() . '/storage/tender/proposal/', $filename);
            $uploaddocument1 = DB::table('tender_proposals')
                ->where('proposalid', $proposalid)
                ->update([
                    'file1' => $filename,
                ]);
        }

        return back();

    }

    public function CheckBidReadyForSubmit(Request $request)
    {
        $pid = $request->pid;
        if (isset($pid) && !empty($pid)) {
            $p_obj = DB::table('tender_proposals')->where('proposalid', $pid)->first();
            if (isset($p_obj) && !empty($p_obj)) {
                if (!isset($p_obj->quoteamount) || $p_obj->quoteamount <= 0 || !isset($p_obj->people_involved) || !isset($p_obj->duration_to_complete) || !isset($p_obj->short_description) || !isset($p_obj->why_consider_you) || !isset($p_obj->additional_info) || !isset($p_obj->proposal_heading) || !isset($p_obj->file1)) {
                    return response()->json(['message' => 'No']);
                } else {
                    return response()->json(['message' => 'Yes']);
                }
            } else {
                return response()->json(['message' => 'No']);
            }
        } else {
            return response()->json(['message' => 'No']);
        }
    }

    public function FinalSubmitBid(Request $request)
    {
        $tenantid = session('tenantid');
        $helper = \App\Helpers\AppHelper::instance();
        $pid = $request->pid;
        $company_sender = session('companyid');
        if (isset($pid) && !empty($pid)) {
            DB::update(DB::raw("Update tender_proposals set proposalstate='Submitted', is_submitted=1,date_submitted=UTC_TIMESTAMP where proposalid='$pid'"));

            $tender_info = DB::table('tender_proposals as tp')
                ->leftjoin('tp_tenders as t', 't.tenderid', 'tp.tenderid')
                ->leftjoin('company as c', 'c.companyid', 't.companyid')
                ->leftjoin('companytypes as ct', 'ct.companytypeid', 'c.companytypeid')
                ->where('tp.proposalid', $pid)
                ->select('c.companyid', 'c.name as company', 'ct.companytype', 't.title as tendername', 't.tenderid')
                ->first();

            //for sending emails
            $TemplateCode = \App\Helpers\AppGlobal::$Send_Final_Bid_Submit_TemplateCode;
            if (isset($TemplateCode)) {
                $TemplateMaster = DB::table('email_master_templates')->first();
                if (isset($TemplateMaster)) {
                    $Template = DB::table('email_templates')->where('code', $TemplateCode)->first();
                    if (isset($Template)) {
                        $MessageBody = $Template->message;

                        $MessageBody = str_replace("%%PLATFORMNAME%%", session('platformname'), $MessageBody);
                        $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
                        $MessageBody = str_replace("%%LOGIN_LINK%%", $loginlink, $MessageBody);
                        $MessageBody = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $MessageBody);
                        $MessageBody = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $MessageBody);

                        $tenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=bs';
                        $MessageBody = str_replace("%%TENDER_LINK%%", $tenderlink, $MessageBody);

                        $MessageBody = str_replace("%%TENDER_NAME%%", $tender_info->tendername, $MessageBody);

                        $MessageBody = str_replace("%%MY_TENDER_LINK%%", $tenderlink, $MessageBody);

                        $MessageBody = str_replace("%%BID_LINK%%", $tenderlink, $MessageBody);

                        $companylink = \App\Helpers\AppGlobal::$App_Domain . '/company/profile/view?company=' . $tender_info->companyid . '&companytype=' . $tender_info->companytype;
                        $MessageBody = str_replace("%%COMPANY_LINK%%", $companylink, $MessageBody);
                        $MessageBody = str_replace("%%COMPANY%%", $tender_info->company, $MessageBody);

                        $acceptedTenderlink = \App\Helpers\AppGlobal::$App_Domain . '/view-other-tenders?tc=ba';
                        $MessageBody = str_replace("%%ACCEPTED_TENDER_LINK%%", $acceptedTenderlink, $MessageBody);

                        $Message_with_master = $TemplateMaster->content;
                        $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
                        $Message_with_master = str_replace('%%EMAILCONTENT%%', $MessageBody, $Message_with_master);

                        $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
                        $Message_with_master = str_replace("%%LOGIN_LINK%%", $loginlink, $Message_with_master);
                        $Message_with_master = str_replace("%%FORGETPWD_LINK%%", $forgetpwdlink, $Message_with_master);
                        $logo = session('tenant_logo');
                        $t_logo = '';
                        if ((isset($logo) && !empty($logo)) && File::exists(public_path('/storage/tenant/logoimage/' . $logo)) == true) {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . '/storage/tenant/logoimage/' . $logo;
                        } else {
                            $t_logo = \App\Helpers\AppGlobal::$App_Domain . "/img/logo_desktop.png";
                        }
                        $Message_with_master = str_replace("%%EMAIL_LOGO_LINK%%", $t_logo, $Message_with_master);
                        $Message_with_master = str_replace("%%CONTACTUS_LINK%%", session('tenant_contact_us_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%PRIVACYPOLICY_LINK%%", session('tenant_privacy_policy_link'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_NAME%%", session('tenant_company'), $Message_with_master);
                        $Message_with_master = str_replace("%%YEAR%%", date('Y'), $Message_with_master);
                        $Message_with_master = str_replace("%%COMPANY_ADDRESS%%", $helper->getCompleteAddress('tenant', $tenantid), $Message_with_master);

                        $Message_with_master = $helper->getSocialLinks('tenant', $tenantid, $Message_with_master);
                        $Template->fromname = session('tenant_from_name');
                        $Template->fromemail = session('tenant_from_email');
                        $company_email = $helper->GetCompanyAdminUserEmail($tender_info->companyid);
                        if (isset($company_email)) {
                            $helper->SendEmail($Template, $company_email, $Message_with_master);
                        }

                    }
                }

            }

            return response()->json(['message' => 'Yes']);
        } else {
            return response()->json(['message' => 'No']);
        }
    }

}
