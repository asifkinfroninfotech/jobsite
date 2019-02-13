<?php

namespace App;

use App\Member;
use DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Session;

class CompanyImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */


    public function model(array $row)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $tenantid = session('tenantid');
       
        

                if(filter_var($row['email'], FILTER_VALIDATE_EMAIL) !== false)
                {
                   //ASIF, Here You may do your coding to insert data in Company, Users, UserCompanies, companysectors etc.
                   $existing_check=DB::table('users as m')->where('m.email',$row['email'])->first();
                   if(!isset($existing_check) || empty($existing_check))//i.e Email is unique.
                   {
                    $company=$row['entityname'];
                    $firstname=$row['firstname'];
                    $lastname=$row['lastname'];
                    $email=$row['email'];
                    $phone=$row['phone'];
                    $country=$row['country'];
                    $companytype = $row['companytype'];
                    if(isset($country) && !empty($country))
                    {
                        $countrycode=DB::table('country')->where('name','=',$country)->first()->countryid;
                        $country=$countrycode;
                    }
                    if(isset($companytype) && !empty($companytype))
                    {
                        $companytypeid=DB::table('companytypes')->where('companytype','=',$companytype)->first()->companytypeid;
                       
                    }
                    

                    $city=$row['city'];
                    $jobtitle=$row['jobtitle'];
                    $website=$row['entitywebsite'];
                    $address=$row['address'];
                    $skype=$row['skype'];
                    $twitter=$row['twitter'];
                    $zip=$row['zip'];
                    $state=$row['state'];

                  //insertinto into the user.
                  $userid = $helper->fnGetUniqueID(16, 'users', 'userid');
                  $password = $helper->fnGetUniqueID(6, 'users', 'userpassword');
                  $insertintouser = DB::table('users')->insert([
                      'tenantid'=>$tenantid,
                      'userid'=>$userid,
                      'email'=>$email,
                      'userpassword'=>$password,
                      'password'=>bcrypt($password),
                      'activestatus'=>'active',
                      'isadmin'=>0,
                      'countryid'=>$country,
                      'city'=>$city,
                      'userposition'=>$jobtitle,
                      'telephone'=>$phone,
                      'address'=>$address,
                      'zip'=>$zip,
                      'skype'=>$skype,
                      'twitter'=>$twitter,
                      'firstname'=>$firstname,
                      'lastname'=>$lastname,

                  ]); 

                  //insertinto into the companies.
                  $companyid = $helper->fnGetUniqueID(16, 'company', 'companyid');
                  $currencyid = 'ed477d';
                  $insertintocompany = DB::table('company')->insert([
                      'tenantid'=>$tenantid,
                      'companyid'=>$companyid,
                      'email'=>$email,
                      'currencyid'=>$currencyid,
                      'companystatus'=>'Verified',
                      'activestatus'=>'Active',
                      'name'=>$company,
                      'city'=>$city,
                      'countryid'=>$country,
                      'telephone'=>$phone,
                      'address'=>$address,
                      'zip'=>$zip,
                      'skype'=>$skype,
                      'twitter'=>$twitter,
                      'website'=>$website,
                      'companytypeid'=>$companytypeid,
                  ]); 
                  //insert into usercompanies
                  $insertintousercompanies = DB::table('usercompanies')->insert([
                      'tenantid'=>$tenantid,
                      'userid'=>$userid,
                      'companyid'=>$companyid,
                      'recordstatus'=>'Active',
                      'userrole'=>'1',
                     
                  ]);
                     
                   }
                   else{
                    Session::push('emailerror', $row['email'].' already exist.');
                  }

                 
                }
                else {
                    Session::push('emailerror', $row['email'].' not valid.');
                }
                //session(['emailerror'=>$emailerror]);
                
               // print_r($duplicate_emails);
               // dd($row);
    }
}