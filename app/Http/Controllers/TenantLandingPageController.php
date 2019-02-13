<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Avatar;
use View;


class TenantLandingPageController extends Controller
{
    public function tenantview(Request $request)
    {
        $tenantid=$request->tid;

        if(isset($tenantid)==false && empty($tenantid)==true)
        {
          return view('tenants.pre_register_error');
        }

        $helper= \App\Helpers\AppHelper::instance();
        $helper->SetTenant_PrimaryLanguage($tenantid);
        
        $gettenant=DB::table('tenants')
                     ->where('tenantid','=',$tenantid) 
                     
                     ->first();
        
        
        
        
        $gettenantslider=DB::table('tenants_landingpage_slides')
                       ->where('tenantid','=',$tenantid)
                       ->get();
        
        $gettenantlandingpage=DB::table('tenants_landingpage')
                        ->where('tenantid','=',$tenantid)
                        ->get();
        
        
        
        $gettenantblock=DB::table('tenants_landingpage_blocks')
                        ->where('tenantid','=',$tenantid)
                        ->get();
        
        $gettenanttestimonial=DB::table('tenants_landingpage_testimonials')
                        ->where('tenantid','=',$tenantid)
                        ->get();
        $gettenantfaq=Db::table('tenants_landingpage_faqs')
                        ->where('tenantid','=',$tenantid)
                        ->get();
        
        return view('tenants.tenant_landing_view', compact('gettenantslider','gettenantblock','gettenantlandingpage','gettenanttestimonial','gettenantfaq','gettenant'));
        
        
    }
}
