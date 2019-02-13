<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use session;
use View;
use Carbon\Carbon;
use DB;


class AjaxController extends Controller
{
    public function deleteDealRecord( Request $request )
    {
    	$response['status'] = false;
        $response['message'] = 'Delete Fail';

        $deal_ids = $request->input('deal_id');
        
        foreach ($deal_ids as $deal_id) {
          DB::table('deal')->where('id',$deal_id)->delete();
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
       

    public function getDocumentList()      // previously function name was documents
    {
      $response['status'] = false;
      $response['message'] = 'Delete Fail';
        $publicdocuments = DB::table('documents')
                            ->select('documents.*', DB::raw("DATE_FORMAT(documents.updated, '%d-%b-%Y') as updated") )
                            ->where('companyid', session('companyid'))
                            ->where('documentstatus', 'Public')
                            ->get() ;
        $privatedocuments = DB::table('documents')
                            ->select('documents.*', DB::raw("DATE_FORMAT(documents.updated, '%d-%b-%Y') as updated") )
                            ->where('companyid', session('companyid'))
                            ->where('documentstatus', 'Private')
                            ->get() ;
        
        $documents['public']=$publicdocuments;
        $documents['private']=$privatedocuments;
        return $documents;
      
    }



    public function getGalleryList()      // previously function name was documents
    {
      $response['status'] = false;
      $response['message'] = 'Delete Fail';
        $galleryimages = DB::table('gallery')
                            ->select('gallery.*', DB::raw("DATE_FORMAT(gallery.updated, '%d-%b-%Y') as updated") )
                            ->where('companyid', session('companyid'))
                            ->where('type', 'Image')
                            ->get() ;
        $galleryvideos = DB::table('gallery')
                            ->select('gallery.*', DB::raw("DATE_FORMAT(gallery.updated, '%d-%b-%Y') as updated") )
                            ->where('companyid', session('companyid'))
                            ->where('type', 'Video')
                            ->get() ;
        
        $documents['galleryimages']=$galleryimages;
        $documents['galleryvideos']=$galleryvideos;
        return $documents;
      
    }

    public function getDealDocumentList(Request $request)      // previously function name was documents
    {
      $response['status'] = false;
      $response['message'] = 'Delete Fail';
      $dealid=session('dealid');
        $publicdocuments = DB::table('deals_documents')
                            ->select('deals_documents.*', DB::raw("DATE_FORMAT(deals_documents.updated, '%d %b %Y') as updated") )
                            ->where('dealid',$dealid )//'vdPSzTyI3bM0lixr'
                            ->where('documentstatus', 'Public')
                            ->get() ;
        
        $privatedocuments = DB::table('deals_documents')
                            ->select('deals_documents.*', DB::raw("DATE_FORMAT(deals_documents.updated, '%d %b %Y') as updated") )
                            ->where('dealid',$dealid )//'vdPSzTyI3bM0lixr'
                            ->where('documentstatus', 'Private')
                            ->get() ;
        
        $documents['public']=$publicdocuments;
        $documents['private']=$privatedocuments;
         return $documents;
      
    }

    public function getPipelineDealDocumentList()      // previously function name was documents
    {
      $response['status'] = false;
      $response['message'] = 'Delete Fail';
      $pipelinedealid=session('pipelinedealid');

        $publicdocuments = DB::table('pipelinedeal_documents')
                            ->select('pipelinedeal_documents.*', DB::raw("DATE_FORMAT(pipelinedeal_documents.updated, '%d %b %Y') as updated") )
                            ->where('pipelinedealid',$pipelinedealid )//'vdPSzTyI3bM0lixr'
                            ->where('documentstatus', 'Public')
                            ->get() ;
        
        $privatedocuments = DB::table('pipelinedeal_documents')
                            ->select('pipelinedeal_documents.*', DB::raw("DATE_FORMAT(pipelinedeal_documents.updated, '%d %b %Y') as updated") )
                            ->where('pipelinedealid',$pipelinedealid )//'vdPSzTyI3bM0lixr'
                            ->where('documentstatus', 'Private')
                            ->get() ;
        
        $documents['public']=$publicdocuments;
        $documents['private']=$privatedocuments;
         return $documents;
      
    }

    public function getStateList( Request $request)
    {
       $states = DB::table("state")
                    ->select("name","stateid")
                    ->where("countryid", $request->country_id)
                    ->get();
        return $states;
    }



    public function opentemplatepage(Request $request)
    {
      $tid=$request->tid;
      $view=View::make('duediligence.templates.template',compact('tid'))->render();
      return $view;
    }

     public function getddTemplateData(Request $request)
     {
         $type=$request->type;
         $templateid=$request->templateid;
         $searchtext=$request->searchtext;
         $tid=$request->tid;

         $companyid=session('companyid');
         $tenantid=session('tenantid');

         switch ($type) {
           case 'Templates':
            $query=DB::table('dd_templates as t')
                       ->where('t.tenantid',$tenantid);

                       if(isset($tid) && !empty($tid))
                       {
                          $query->where('t.type','Tenant');
                       }
                       else
                       {
                        $query->where('t.companyid',$companyid);
                        $query->where('t.type','Company');
                       }

            if(isset($searchtext) && !empty($searchtext))
            {
                $query->where(function ($query) use ($searchtext)
                {
                   $query->Where('t.name','like', '%' . $searchtext . '%');
                });
            }
        
            $templates=$query->select('t.templateid','t.name as template','t.description','t.activestatus')->get();
            $statusvalues=array('value'=>array('Active','In-Active'));


            $view=View::make('duediligence.templates._template_list',compact('templates','statusvalues'))->render();
            return $view;
            
             break;
           
             case 'Modules':
                 $templateid=$request->templateid;
                 $query=DB::table('dd_template_modules as tm')
                       ->where('tm.tenantid',$tenantid)
                       ->where('tm.templateid',$templateid);
                       

            if(isset($searchtext) && !empty($searchtext))
            {
                $query->where(function ($query) use ($searchtext)
                {
                   $query->Where('tm.modulename','like', '%' . $searchtext . '%');
                });
            }
            $query->orderby('displayorder');
            $moduleslist=$query->get();
            $statusvalues=array('value'=>array('Active','In-Active'));


            $view=View::make('duediligence.templates._module_list',compact('moduleslist','statusvalues'))->render();
            return $view;
            
             break;

             case 'Questions':
                 $templateid=$request->templateid;
                 $moduleid=$request->moduleid;
                 $query=DB::table('dd_template_questions as q')
                       ->where('q.tenantid',$tenantid)
                       ->where('q.templateid',$templateid)
                       ->where('q.moduleid',$moduleid);  
                       

            if(isset($searchtext) && !empty($searchtext))
            {
                $query->where(function ($query) use ($searchtext)
                {
                   $query->Where('q.questiontext','like', '%' . $searchtext . '%');
                });
            }
            $query->orderby('displayorder');
            $questionlist=$query->get();
            $statusvalues=array('value'=>array('Active','In-Active'));


            $view=View::make('duediligence.templates._question_list',compact('questionlist','statusvalues'))->render();
            return $view;
            
             break;

         }
     }

     
     public function updatetemplate(Request $request)
     {
         $arr=json_decode($request->arr);
         $arrtemplate=json_decode($request->arrtemplate);
         $arrstatus=json_decode($request->arrstatus);
         $arrdescription=json_decode($request->arrdescription);
         
         for($i=0;$i<count($arr);$i++)
         {
             DB::table('dd_templates')
            ->where('templateid', $arr[$i])
            ->update(['name' => $arrtemplate[$i],'activestatus'=>$arrstatus[$i],'description'=>$arrdescription[$i]]);
         }
     }
     
       function createnewmodules(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        
        $tenantid=session('tenantid');
        $template=$request->template;
        
        $name=$request->name;
        $status=$request->status;
        $order=$request->order;
        $moduleid=$helper->fnGetUniqueID(16, 'dd_template_modules', 'moduleid');
        
        
         DB::table('dd_template_modules')->insert(
                  [
                  'templateid' => $template, 
                  'tenantid'=>$tenantid,
                  'modulename'=>$name,
                  'modulestatus' => $status,
                  'displayorder' => intval($order),
                  'moduleid'=>$moduleid    
                  
                  ]
                 );
        

        
        
       
        return response()->json(['moduleid'=>$moduleid]);  
        
        
        
    }
     
     public function updatemodule(Request $request)
     {
         $arr=json_decode($request->arr);
         $arrtemplate=json_decode($request->arrtemplate);
         $arrstatus=json_decode($request->arrstatus);
         $arrorder=json_decode($request->arrorder);
         
         for($i=0;$i<count($arr);$i++)
         {
             DB::table('dd_template_modules')
            ->where('moduleid', $arr[$i])
            ->update(['modulename' => $arrtemplate[$i],'modulestatus'=>$arrstatus[$i],'displayorder'=>$arrorder[$i]]);
         }
     }
     
       public function updatequestion(Request $request)
     {
         $arr=json_decode($request->arr);
         $arrtemplate=json_decode($request->arrtemplate);
         
         $arrorder=json_decode($request->arrorder);
         
         for($i=0;$i<count($arr);$i++)
         {
             DB::table('dd_template_questions')
            ->where('questionid', $arr[$i])
            ->update(['questiontext' => $arrtemplate[$i],'displayorder'=>$arrorder[$i]]);
         }
     }
     
     
     
      function createnewquestions(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        
        $tenantid=session('tenantid');
        $template=$request->template;
        $module=$request->module;
        
        $name=$request->name;
        
        $order=$request->order;
        $questionid=$helper->fnGetUniqueID(16, 'dd_template_questions', 'questionid');
        
        
         DB::table('dd_template_questions')->insert(
                  [
                  'templateid' => $template, 
                  'tenantid'=>$tenantid,
                  'moduleid'=>$module,    
                  'questionid'=>$questionid,    
                  'questiontext' => $name,
                  'displayorder' => intval($order)
                  ]
                 );
        

        
        
       
        
        
        
        
    }
     
     function createnewtemplate(Request $request)
    {
        $helper= \App\Helpers\AppHelper::instance();
        $companyid=session('companyid');
        $tenantid=session('tenantid');
        $tid=$request->tid;
        
        $template=$request->template;
        $description=$request->description;
        $status=$request->status;
        $templateid=$helper->fnGetUniqueID(16, 'dd_templates', 'templateid');
        
        if(isset($tid) && !empty($tid))
        {
            DB::table('dd_templates')->insert(
                [
                'templateid' => $templateid, 
                'tenantid'=>$tenantid,
                'name'=>$template,
                'description' => $description,
                'activestatus' => $status,
                'type'=>'Tenant'
                ]
               );
        }
        else
        {
            DB::table('dd_templates')->insert(
                [
                'templateid' => $templateid, 
                'tenantid'=>$tenantid,
                'name'=>$template,
                'description' => $description,
                'activestatus' => $status,
                'companyid'=>$companyid
                ]
               );
        }

        return response()->json(['templateid'=>$templateid]);  
  
    }

    public function ChangeLanguage(Request $request)
    {
       $userid=session('userid');
       $lang=$request->lang;

       DB::table('users')->where('tenantid',session('tenantid'))->where('userid',$userid)
                         ->update(['language'=>$lang]);

       app()->setLocale($lang);

        return redirect()->back();
    }


    public function getSectorEnterpriseChart(Request $request)
    {
        $tenantid=$request->tenantid;
         // Investor Type 'aba5f1'
         $tenant_condition="";
         $c_tenant_condition="";
         if(isset($tenantid) && !empty($tenantid))
         {
             $tenant_condition=" and tenantid="."'".$tenantid."'"; 
             $c_tenant_condition=" and c.tenantid="."'".$tenantid."'"; 
         }

                    //Data For No of Enterprises per sector
                    $result=DB::select(DB::raw("select s.sectorid,s.name as sector,count(*) as ecount from companysectors as cs
                    join sectors as s on s.sectorid=cs.sectorid
                    join company as c on c.companyid=cs.companyid
                    where c.companytypeid='5eab3b' $c_tenant_condition group by s.sectorid,s.name"));

                    // c.companytypeid='5eab3b'
                return response()->json($result);    
                  

    }

    // public function getSector_Investor_Chart(Request $request)
    // {
    //     $tenantid=$request->tenantid;
    //      // Investor Type 'aba5f1'
    //      $tenant_condition="";
    //      $c_tenant_condition="";
    //      if(isset($tenantid) && !empty($tenantid))
    //      {
    //          $tenant_condition=" and tenantid="."'".$tenantid."'"; 
    //          $c_tenant_condition=" and c.tenantid="."'".$tenantid."'"; 
    //      }

    //                 //Data For No of Enterprises per sector
    //                 $result=DB::select(DB::raw("select s.sectorid,s.name as sector,count(*) as ecount from companysectors as cs
    //                 join sectors as s on s.sectorid=cs.sectorid
    //                 join company as c on c.companyid=cs.companyid
    //                 where c.companytypeid='aba5f1' $c_tenant_condition group by cs.sectorid,s.name"));
    //             return response()->json($result);    
                  

    // }


    public function getSectorChart(Request $request)
    {
        $tenantid=$request->tenantid;
        $type=$request->type;
        $companytypeid="";
        
        if($type=="Investor")
        {
            $companytypeid="aba5f1";
        }
        else if($type=="ServiceProvider")
        {
            $companytypeid="b5aa1d";
        }
        else if($type=="Enterprise_Viewed")
        {
            $companytypeid="5eab3b";
        }
        // Investor Type 'aba5f1'
        $tenant_condition="";
        $c_tenant_condition="";
        if(isset($tenantid) && !empty($tenantid))
        {
            $tenant_condition=" and tenantid="."'".$tenantid."'"; 
            $c_tenant_condition=" and c.tenantid="."'".$tenantid."'"; 
        }

        if($type!="Enterprise_Viewed")
        {
                   $result=DB::select(DB::raw("select s.sectorid,s.name as sector,count(*) as ecount from companysectors as cs
                   join sectors as s on s.sectorid=cs.sectorid
                   join company as c on c.companyid=cs.companyid
                   where c.companytypeid='$companytypeid' $c_tenant_condition group by s.sectorid,s.name"));

                   return response()->json($result);   
        }
        else//Type=Enterprise_Viewed
        {
             $result=DB::select(DB::raw("select s.sectorid,s.name as sector,count(*) as ecount from companyvisitors as cv
             join companysectors as cs on cs.companyid=cv.companyid
             join sectors as s on s.sectorid=cs.sectorid
             join company as c on c.companyid=cs.companyid
             where c.companytypeid='$companytypeid' $c_tenant_condition group by s.sectorid,s.name"));

             return response()->json($result);   
        }


        // select investmentstructure,sum(totalinvestmentrequired) tvalue from deals where investmentstructure is not null group by investmentstructure
 
    }


    public function getPieChart(Request $request)
    {
        $tenantid=$request->tenantid;
        // Investor Type 'aba5f1'
        $tenant_condition="";
        $c_tenant_condition="";
        if(isset($tenantid) && !empty($tenantid))
        {
            $tenant_condition=" and tenantid="."'".$tenantid."'"; 
        }

        $result=DB::select(DB::raw("select investmentstructure,Round(sum(totalinvestmentrequired),2) as tvalue from deals 
        where investmentstructure is not null $tenant_condition group by investmentstructure"));

             return response()->json($result);   

    }

    public function getDoughnupChartData(Request $request)
    {
        $tenantid=$request->tenantid;
        // Investor Type 'aba5f1'
        $tenant_condition="";
        if(isset($tenantid) && !empty($tenantid))
        {
            $tenant_condition=" and tenantid="."'".$tenantid."'"; 
        }

        // $result=DB::select(DB::raw("select 'Underway' as type, Count(*) as score from pipelinedeals where pipelinedealstatus<>'completed'
        // Union 
        // select 'Completed' as type, Count(*) as score from pipelinedeals where pipelinedealstatus='completed'"));

        $result=DB::select(DB::raw("select pipelinedealstatus as type, Count(*) as score from pipelinedeals where pipelinedealstatus<>'' $tenant_condition group by pipelinedealstatus"));

        return response()->json($result);   

    }

}



