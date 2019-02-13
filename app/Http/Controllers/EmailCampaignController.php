<?php
namespace App\Http\Controllers;

use DB;
use File;
use Illuminate\Http\Request;
use session;
use View;

class EmailCampaignController extends Controller
{
    public function selectemailtemplate(Request $request)
    {
        $getcompanytypes = DB::table('companytypes')
            ->get();

        $getemailcampaignandcompanies = DB::table('email_campaign as e')
            ->leftjoin('email_campaign_companies as ec', 'e.emailcampaignid', 'ec.emailcampaignid')
            ->leftjoin('company as c', 'c.companyid', 'ec.companyid')
            ->leftjoin('users as u', 'u.userid', 'ec.userid')
            ->leftjoin('companytypes as ct', 'c.companytypeid', 'ct.companytypeid')
            ->where('e.tenantid', session('tenantid'))

            ->select('c.companyid', 'e.emailcampaignid', 'e.emailcampaignname', 'e.emailcampaignsubject', 'e.emailcampaignmessage', 'e.emailcampaignstatus', 'e.creteddate', 'c.profileimage as companyimage', 'e.fromname', 'e.fromemail', 'c.name as company', 'ct.companytype', 'u.userid', 'u.firstname', 'u.lastname', 'u.profileimage as userprofileimage', 'u.email as useremail')
            ->get();

        $view = View::make('tenants._new_email_template')->with('getcompanytypes', $getcompanytypes)->with('getemailcampaignandcompanies', $getemailcampaignandcompanies)->render();

        return response()->json(['view' => $view]);

    }

    public function getcompanylist_ec(Request $request)
    {
        $filter = $request->filter;
        $companytypes = json_decode($request->companytypes);

        $query = DB::table('company');
        if (isset($filter) && !empty($filter)) {
            $query = $query->where('name', 'like', '%' . $filter . '%');
        }
        if (isset($companytypes) && !empty($companytypes)) {
            $query = $query->whereIn('companytypeid', $companytypes);
        }

        $query = $query->where('tenantid', session('tenantid'));

        $result = $query->select('companyid as id', 'name as text')->get();
        return json_encode($result);

    }

    public function ajaxsendemail(Request $request)
    {

        $emailcampaignname = $request->emailcampaignname;
        $emailcampaignsubject = $request->emailcampaignsubject;
        $emailcampaignmessage = $request->ckeditor1;
        $fromname = $request->from_name;
        $fromemail = $request->from_email;
        $tenantid = session('tenantid');
        $helper = \App\Helpers\AppHelper::instance();

        $user = $request->user; //companies or usertype
        $companies = $request->companies;

        $companytype = $request->companytype;

        $usertype = $request->usertype; //compnaies or usertype

        $all_companies = "";
        $emailcampaignid = $helper->fnGetUniqueID(16, 'email_campaign', 'emailcampaignid');
        if (isset($emailcampaignname) && !empty($emailcampaignname) && isset($emailcampaignsubject) && !empty($emailcampaignsubject) && isset($emailcampaignmessage) && !empty($emailcampaignmessage) && isset($fromname) && !empty($fromname) && isset($fromemail) && !empty($fromemail)) {

            DB::table('email_campaign')
                ->insert([
                    'emailcampaignname' => $emailcampaignname,
                    'emailcampaignid' => $emailcampaignid,
                    'emailcampaignsubject' => $emailcampaignsubject,
                    'emailcampaignmessage' => $emailcampaignmessage,
                    'emailcampaignstatus' => 'sent',
                    'fromname' => $fromname,
                    'fromemail' => $fromemail,
                    'tenantid' => $tenantid,
                ]);

        }

        if (isset($user) && !empty($user)) {

            if ($user == "companies") {
               //When User has selected Companies directly instead of Company Type.
                if (isset($usertype) && !empty($usertype)) {

                    if ($usertype == "companies") {
                       //case of Send Email To Every Active User
                        if (isset($companies) && !empty($companies)) {

                            foreach ($companies as $company) {
                                $all_companies = DB::table('usercompanies as uc')
                                    ->leftjoin('users as u', 'u.userid', 'uc.userid')
                                    ->where('uc.companyid', $company)
                                    ->where('uc.tenantid', $tenantid)
                                    ->where('uc.recordstatus','Active')
                                    ->get();

                                foreach ($all_companies as $allcompany) {
                                    $emailcampaigncompanyid = $helper->fnGetUniqueID(16, 'email_campaign_companies', 'emailcampaigncompanyid');
                                    DB::table('email_campaign_companies')
                                        ->insert([
                                            'emailcampaigncompanyid' => $emailcampaigncompanyid,
                                            'emailcampaignid' => $emailcampaignid,
                                            'emailid' => $allcompany->email,
                                            'status' => 'sent',
                                            'companyid' => $company,
                                            'userid' => $allcompany->userid,
                                            'tenantid' => $tenantid,
                                        ]);

                                    $this->simpleEmail($allcompany->email, $emailcampaignsubject, $emailcampaignmessage, $fromname, $fromemail);
                                }
                            }

                        }

                    } else if ($usertype == "usertype") {
                         //Case of Sending Email To Only ADMIN.
                        if (isset($companies) && !empty($companies)) {

                            foreach ($companies as $company) {
                                $company_email = $helper->GetCompanyAdminUserEmail($company);
                                $user_id = $helper->GetCompanyAdminUserId($company);

                                $emailcampaigncompanyid = $helper->fnGetUniqueID(16, 'email_campaign_companies', 'emailcampaigncompanyid');
                                DB::table('email_campaign_companies')
                                    ->insert([
                                        'emailcampaigncompanyid' => $emailcampaigncompanyid,
                                        'emailcampaignid' => $emailcampaignid,
                                        'emailid' => $company_email,
                                        'status' => 'sent',
                                        'companyid' => $company,
                                        'userid' => $user_id,
                                        'tenantid' => $tenantid,
                                    ]);

                                $this->simpleEmail($company_email, $emailcampaignsubject, $emailcampaignmessage, $fromname, $fromemail);

                            }
                        }
                    }
                }

            }
            else if ($user == "usertype") {
//When User has Company Types instead of direct companies.

                $companies = DB::table('company')
                    ->whereIn('companytypeid', $companytype)
                    ->where('tenantid',$tenantid)
                    ->select('companyid')
                    ->get();

                if (isset($usertype) && !empty($usertype)) {

                    if ($usertype == "companies") {
//case of Send Email To Every Active User

                        if (isset($companies) && !empty($companies)) {

                            foreach ($companies as $company) {
                                $all_companies = DB::table('usercompanies as uc')
                                    ->leftjoin('users as u', 'u.userid', 'uc.userid')
                                    ->where('uc.companyid', $company->companyid)
                                    ->where('uc.tenantid',$tenantid)
                                    ->where('uc.recordstatus','Active')
                                    ->get();
                                foreach ($all_companies as $allcompany) {
                                    $emailcampaigncompanyid = $helper->fnGetUniqueID(16, 'email_campaign_companies', 'emailcampaigncompanyid');
                                    DB::table('email_campaign_companies')
                                        ->insert([
                                            'emailcampaigncompanyid' => $emailcampaigncompanyid,
                                            'emailcampaignid' => $emailcampaignid,
                                            'emailid' => $allcompany->email,
                                            'status' => 'sent',
                                            'companyid' => $company->companyid,
                                            'userid' => $allcompany->userid,
                                            'tenantid' => $tenantid,
                                        ]);

                                    $this->simpleEmail($allcompany->email, $emailcampaignsubject, $emailcampaignmessage, $fromname, $fromemail);
                                }
                            }

                        }

                    } else if ($usertype == "usertype") {
//Case of Sending Email To Only ADMIN.

                        if (isset($companies) && !empty($companies)) {

                            foreach ($companies as $company) {
                                $company_email = $helper->GetCompanyAdminUserEmail($company->companyid);
                                $user_id = $helper->GetCompanyAdminUserId($company->companyid);

                                $emailcampaigncompanyid = $helper->fnGetUniqueID(16, 'email_campaign_companies', 'emailcampaigncompanyid');
                                DB::table('email_campaign_companies')
                                    ->insert([
                                        'emailcampaigncompanyid' => $emailcampaigncompanyid,
                                        'emailcampaignid' => $emailcampaignid,
                                        'emailid' => $company_email,
                                        'status' => 'sent',
                                        'companyid' => $company->companyid,
                                        'userid' => $user_id,
                                        'tenantid' => $tenantid,
                                    ]);

                                $this->simpleEmail($company_email, $emailcampaignsubject, $emailcampaignmessage, $fromname, $fromemail);

                            }
                        }
                    }
                }

            }

        }

    }

    public function simpleEmail($to1, $subject1, $message1, $fromname1, $fromemail1)
    {
        $helper = \App\Helpers\AppHelper::instance();

        $tenantid = session('tenantid');

        $TemplateMaster = DB::table('email_master_templates')->first();
        $Message_with_master = $TemplateMaster->content;
        $Message_with_master = str_replace("%%DOMAIN%%", \App\Helpers\AppGlobal::$App_Domain, $Message_with_master);
//                  $Message_with_master=str_replace('%%EMAILCONTENT%%',$MessageBody,$Message_with_master);

        $Message_with_master = str_replace('%%EMAILCONTENT%%', $message1, $Message_with_master);

        $forgetpwdlink = \App\Helpers\AppGlobal::$App_Domain . '/forgotpassword?tid=' . $tenantid;
        $loginlink = \App\Helpers\AppGlobal::$App_Domain . '/login?tid=' . $tenantid;
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
        $Template = (object) array();
        $Template->fromname = $fromname1;
        $Template->fromemail = $fromemail1;
        $Template->subject = $subject1;
        $company_email = $to1;
        if (isset($company_email)) {
            $helper->SendEmail($Template, $company_email, $Message_with_master);
        }

    }

    public function email_campaign()
    {

        $getcompanytypes = DB::table('companytypes')
            ->get();

//        $getemailcampaignandcompanies = DB::table('email_campaign as e')
        //            ->leftjoin('email_campaign_companies as ec', 'e.emailcampaignid', 'ec.emailcampaignid')
        //            ->leftjoin('company as c', 'c.companyid', 'ec.companyid')
        //            ->leftjoin('users as u', 'u.userid', 'ec.userid')
        //            ->leftjoin('companytypes as ct', 'c.companytypeid', 'ct.companytypeid')
        //
        //            ->select('c.companyid', 'e.emailcampaignid', 'e.emailcampaignname', 'e.emailcampaignsubject', 'e.emailcampaignmessage', 'e.emailcampaignstatus', 'e.creteddate', 'c.profileimage as companyimage', 'e.fromname', 'e.fromemail', 'c.name as company', 'ct.companytype', 'u.userid', 'u.firstname', 'u.lastname', 'u.profileimage as userprofileimage', 'u.email as useremail')
        //            ->get();

        $getemailcampaignandcompanies = DB::table('email_campaign as ec')
            ->get();

        return view('tenants.admin_related_pages.email_campaign', compact('getemailcampaignandcompanies', 'getcompanytypes'));
    }

}
