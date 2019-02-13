<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usercompany;
use DB;
use View;
use App\Models\User;
use session;

class TeamController extends Controller {

    public function getteam() {


        $company = Usercompany::where('tenantid', Session('tenantid'))
                ->where('companyid', Session('companyid'))
                ->with(['user' => function($c) {
                $c->select('userid', 'firstname', 'lastname', 'profileimage');
            }])
                ->with(['company' => function($c1) {
                $c1->select('companyid', 'name', 'statusmessage', 'profileimage');
            }])
                ->get();




        return view('teams.teams')->with('company', $company);
    }

    public function gettable() {
        $searchhandle = $_POST['input'];


        $selectquery = "";
        if (isset($_POST['select'])) {
            $select = $_POST['select'];
            if ($select == "username") {

                $selectquery = " order by users.username asc";
            }
            if ($select == "Active") {
                $selectquery = " order by recordstatus asc";
            }
        }



        $searchcompany1 = "select *,users.profileimage as userprofileimage,company.profileimage as companyprofileimage from usercompanies,users,company,companytypes where usercompanies.tenantid = '" . Session('tenantid') . "' and usercompanies.companyid = '" . Session('companyid') . "' and (company.name like '%$searchhandle%' or users.firstname like '%$searchhandle%' or users.lastname like '%$searchhandle%' or users.username like '%$searchhandle%'  or usercompanies.recordstatus like '%$searchhandle%') and usercompanies.userid<>'" . Session('userid') . "' and usercompanies.userid=users.userid and usercompanies.companyid=company.companyid and companytypes.companytypeid=company.companytypeid  and usercompanies.recordstatus<>'Deleted' and usercompanies.recordstatus <> 'New-Request'" . $selectquery;
        $company = DB::select(DB::raw($searchcompany1));
        if(!empty($company[0])||isset($company[0]))
        {   
        $view = View::make('teams.teamsfilter')->with('company', $company)->render();
        }
        else
        {   
         $view='<tr><td colspan="6">'.trans('notfoundlang.teams').'</td></tr>';
        }
//echo $view;
        //echo 'asif';
        // echo  $searchcompany1;
        return response()->json(['view' => $view]);




//       $company= Usercompany::where('tenantid',Session('tenantid'))
//                          ->where('companyid',Session('companyid'))
//                            ->with(['user'=>function($c)use($searchhandle){
//                             $c->select('userid','firstname','lastname');
//                              $c->where('firstname','like','%'.$searchhandle.'%');
//                              $c->orwhere('lastname','like','%'.$searchhandle.'%');
//                              
//                          }])
//                          
//                          ->with(['company'=>function($c1)use($searchhandle){
//                              
//                              $c1->select('companyid','name','statusmessage');
////                              $c1->where('name','like','%'.$searchhandle.'%');
//                          }])
//                          ->get();                    
//   
//       $view="";
//      foreach($company as $company)
//      {
//          if($company!=Null )
//          {
//            
//             $normal='';             
//             if($company->userrole=='0'){$normal = 'Admin';}
//             if($company->userrole=='1'){$normal = 'Normal';}           
//               $status='';           
//             if($company->recordstatus=='2'){$status='green';}
//             if($company->recordstatus=='0'){$status='yellow';}
//             if($company->recordstatus=='1'){$status='blue';}
//             if($company->recordstatus=='3'){$status='brown';}
//             if($company->recordstatus=='4'){$status='red';}      
//             
//             $recordstatus='';
//           if($company->recordstatus=='2'){$recordstatus='Active';}
//           if($company->recordstatus=='0'){$recordstatus='Pending';}
//           if($company->recordstatus=='1'){$recordstatus='Invited';}
//           if($company->recordstatus=='3'){$recordstatus='Inactive';}
//           if($company->recordstatus=='4'){$recordstatus='Deleted';}
//             
//             $button="";
//             
//        if($company->userrole=='1'){
//                                  
//                               $button='<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary"  id="dropdownMenuButton1" type="button">View Profile</button>';
//
//                                  }
//        if($company->userrole=='0'){
//                                  
//                               $button='<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
//                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
//                                  <a class="dropdown-item" href="#">Action</a><a class="dropdown-item" href="#"> Another action</a><a class="dropdown-item" href="#"> Something else here</a>
//                                </div>';
//        }
//           
//           
//           
//             
//        $view=$view.'<tr>
//                 <td>
//                              <div class="user-with-avatar">
//                                <img alt="" src="img/avatar1.jpg"><span class="d-none d-xl-inline-block">'.$company->firstname." ".$company->lastname.'</span>
//                              </div>
//                            </td>
//                            <td>
//                              <img alt="" src="img/rianta-small.jpg" />                                
//                              </span><span>'.$company->name.'</span>
//                            </td>
//                            <td>
//                              <span>'.$company->statusmessage.'</span>
//                            </td>
//                            <td>
//                              <span>'.$normal.'</span>
//                            </td>
//                            <td class="text-center">
//                              <div class="status-pill '.$status.'" data-title=" '.$recordstatus.' " data-toggle="tooltip" data-original-title="" title=""></div>
//                            </td>
//                            
//                            <td class="text-right">
//                              <div class="btn-group mr-1 mb-1">
//                                  
//                                  '.$button.'
//                                
//                              </div>
//                            </td>                           
//                          </tr> ';
//              
//              
//          }
//      }
////        
////        
////        
////        
//        
//        
//            echo $view;  
        // echo $searchcompany1;                
    }

    public function getfilter() {
        $searchhandle = $_POST['input'];



        if ($searchhandle == 'username') {
            $searchcompany1 = "select *,users.profileimage as userprofileimage,company.profileimage as companyprofileimage from usercompanies,users,company,companytypes where usercompanies.tenantid = '" . Session('tenantid') . "' and usercompanies.companyid = '" . Session('companyid') . "' and usercompanies.userid=users.userid and usercompanies.companyid=company.companyid and companytypes.companytypeid=company.companytypeid  and usercompanies.recordstatus <> 'Deleted' and usercompanies.recordstatus <> 'New-Request' and usercompanies.userid<>'" . Session('userid') . "' order by users.firstname asc";

            $company = DB::select(DB::raw($searchcompany1));
        }

        if ($searchhandle == 'Active') {
            $searchcompany1 = "select *,users.profileimage as userprofileimage,company.profileimage as companyprofileimage from usercompanies,users,company,companytypes where usercompanies.tenantid = '" . Session('tenantid') . "' and usercompanies.companyid = '" . Session('companyid') . "' and usercompanies.userid=users.userid and usercompanies.companyid=company.companyid and companytypes.companytypeid=company.companytypeid and usercompanies.recordstatus <> 'Deleted' and usercompanies.recordstatus <> 'New-Request' and usercompanies.userid<>'" . Session('userid') . "' order by recordstatus asc";

            $company = DB::select(DB::raw($searchcompany1));
        }



     
        $view = View::make('teams.teamsfilter')->with('company', $company)->render();


        return response()->json(['view' => $view]);


        // echo $view;                
    }

    public function setstatus() {
        $updateid = $_POST['input'];
        $status = $_POST['title'];
        $prevdtatus = $_POST['currentstatus'];
        

        
        $searchcompany1 = "update usercompanies set recordstatus = '" . $status . "' where userid = '" . $updateid . "' and recordstatus = '" . $prevdtatus . "'";

        //echo $searchcompany1;
        $company = DB::statement($searchcompany1);
    }

    public function checkmail() {
        $email = $_POST['input'];
        $gotemail = "none";
        $searchcompany1 = "select * from users where email = '" . $email . "'";
        $company = DB::select(DB::raw($searchcompany1));
        if (isset($company[0]->email)) {
            $gotemail = $company[0]->email;
        }
        return response()->json(['gotemail' => $gotemail]);
    }

    public function usersaveupdate(Request $request) {


        $helper = \App\Helpers\AppHelper::instance();
        $userid = $helper->fnGetUniqueID(16, 'users', 'userid');
        $tenantid = Session('tenantid');
        $email = $request->email;
//        $username=$request->username;
        $firstname = $request->firstname;
        $lastname = $request->lastname;

        $searchcompany1 = "select * from users where email = '" . $email . "'";
        $company = DB::select(DB::raw($searchcompany1));
        $count = count($company);
        // if($count>0)
        // {
        //     $searchcompany2="update usercompanies set recordstatus = 'Invited'  where userid = '".$company[0]->userid."'";
        //     $company=DB::statement( $searchcompany2);
        // }
        if ($count == 0) {
            //  $searchcompany2="INSERT INTO `users` (tenantid,userid,username,email,firstname,lastname) values ('$tenantid','$userid','$username','$email','$firstname','$lastname')";

            $email = DB::table('users')->insert(
                    [
                        'tenantid' => $tenantid,
                        'userid' => $userid,
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'email' => $email,
                        'isadmin' => 0
                    ]
            );

            $saveusercompanies = DB::table('usercompanies')->insert(
                    [

                        'tenantid' => $tenantid,
                        'userid' => $userid,
                        'companyid' => Session('companyid'),
                        'recordstatus' => 'Invited',
                        'userrole' => 1
                    ]
            );
        }
        //$company=DB::statement( $searchcompany2); 
    }

    public function userinvite(Request $request) {

        $helper = \App\Helpers\AppHelper::instance();
        
        $tenantid = Session('tenantid');
        $userdata = $request->user_data;

        $details = explode("\n", str_replace("\r", "", $userdata));
        $users = array();
        foreach ($details as $key => $detail) {
            $user = explode(',', $detail);
            $users[$key]['firstname'] = $user[0];
            $users[$key]['lastname'] = $user[1];
            $users[$key]['email'] = $user[2];
        }

//        echo '<pre>';
//        print_r($users);
//        echo '</pre>';
//        exit;
        foreach ($users as $key => $data) {
            extract($data);
            $userid = $helper->fnGetUniqueID(16, 'users', 'userid');
            $searchcompany1 = "select * from users where email = '" . $email . "'";
            $company = DB::select(DB::raw($searchcompany1));
            $count = count($company);
            if ($count == 0) {
                $email = DB::table('users')->insert(
                        [
                            'tenantid' => $tenantid,
                            'userid' => $userid,
                            'firstname' => $firstname,
                            'lastname' => $lastname,
                            'email' => $email,
                            'isadmin' => 0
                        ]
                );
                $saveusercompanies = DB::table('usercompanies')->insert(
                        [

                            'tenantid' => $tenantid,
                            'userid' => $userid,
                            'companyid' => Session('companyid'),
                            'recordstatus' => 'Invited',
                            'userrole' => 1
                        ]
                );
            }
        }
        return redirect('teams');
    }
    
    
    public function deleteinvited(Request $request)
    {
       // $request->deleteinvited;
        
       //echo "Delete from usercompanies where userid in ('".str_replace(",", "','", $request->deleteinvited)."')"; 
       //echo "Delete from users where userid in ( '".str_replace(",", "','", $request->deleteinvited)."')";
        
       DB::delete("Delete from usercompanies where userid in ('".str_replace(",", "','", $request->deleteinvited)."')");
       DB::delete("Delete from users where userid in ('".str_replace(",", "','", $request->deleteinvited)."')");
       
        
        
    }

}
