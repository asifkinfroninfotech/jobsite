<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
  
    public function getvisitorcount(Request $request)
    {
        $label=array();
        $values=array();
        $comcompanyid=session('companyid');
      switch($request->days)
      {
          case 7:
              $totalcount=0;
              $label=array();
              $values=array();
              $lastdate = date('Y-m-d');
              $firstdate = date('Y-m-d', strtotime('-7 days'));
             // $selectcount=DB::select(DB::raw("Select visitdate,visitorcount  from  companyvisitors where visitdate >= '$firstdate' and  visitdate <='$lastdate' and companyid =  '$comcompanyid'"));
              $totalcount1=DB::select(DB::raw("Select sum(visitorcount) as totalvisitorcount  from  companyvisitors where visitdate >= '$firstdate' and  visitdate <='$lastdate' and companyid =  '$comcompanyid' group by companyid"));
             if(isset($totalcount1[0]->totalvisitorcount))
             {
             $totalcount=$totalcount1[0]->totalvisitorcount;
                 
             }
              for($j=6;$j>=0;$j--)
             {
             
              $label[6-$j]=date('d', strtotime('-'.$j.' days'));
              $currentdate=date('Y-m-d', strtotime('-'.$j.' days'));
              $selectcount1=DB::select(DB::raw("Select visitorcount  from  companyvisitors where visitdate = '$currentdate' and companyid ='$comcompanyid'"));
              if(!empty($selectcount1[0]->visitorcount) || isset($selectcount11[0]->visitorcount))
              {
                  $values[6-$j]=$selectcount1[0]->visitorcount;
                 
              }
             else
             {
                 $values[6-$j]=0;
             }
             
           
       }
       $labelandvalues=array('label'=>$label,'values'=>$values, 'totalcount'=>$totalcount);
          
            break;
            
            case 14:
                $totalcount=0;
                $label=array();
                $values=array();
              $lastdate = date('Y-m-d');
              $firstdate = date('Y-m-d', strtotime('-14 days'));
              $totalcount1=DB::select(DB::raw("Select sum(visitorcount) as totalvisitorcount  from  companyvisitors where visitdate >= '$firstdate' and  visitdate <='$lastdate' and companyid =  '$comcompanyid' group by companyid"));
             if(isset($totalcount1[0]->totalvisitorcount))
             {
             $totalcount=$totalcount1[0]->totalvisitorcount;
                 
             }
             for($j=13;$j>=0;$j--)
             {
             $label[13-$j]=date('d', strtotime('-'.$j.' days'));
             $currentdate=date('Y-m-d', strtotime('-'.$j.' days'));
              $selectcount1=DB::select(DB::raw("Select visitorcount  from  companyvisitors where visitdate = '$currentdate' and companyid ='$comcompanyid'"));
              if(!empty($selectcount1[0]->visitorcount) || isset($selectcount11[0]->visitorcount))
              {
                  $values[13-$j]=$selectcount1[0]->visitorcount;
                 
              }
             else
             {
                 $values[13-$j]=0;
             }
             }
             
            
            break;
            
            case 'lastmonth':
                $label=array();
                $values=array();
                $totalcount = 0;
                $selectcount=0;
             $lastdate=date("d",strtotime("-1 second",strtotime(date("Y-m-1"))));  
             $lastdate1 = date('Y-m-d', strtotime("-1 second",strtotime(date("Y-m-1"))));
             $firstdate = date('Y-m-1', strtotime("-1 second",strtotime(date("Y-m-1"))));
             $totalcount1=DB::select(DB::raw("Select sum(visitorcount) as totalvisitorcount  from  companyvisitors where visitdate >= '$firstdate' and  visitdate <='$lastdate1' and companyid =  '$comcompanyid' group by companyid"));
             if(isset($totalcount1[0]->totalvisitorcount))
             {
             $totalcount=$totalcount1[0]->totalvisitorcount;
                 
             }
             for($j=$lastdate;$j>0;$j--)
             {
             $label[$lastdate-$j]=date('d', strtotime('-'.$j.' days'));
             $currentdate=date('d', strtotime('-'.$j.' days'));
             $currentdate1 = date('Y-m-'.$currentdate, strtotime("-1 second",strtotime(date("Y-m-1"))));
             $selectcount1=DB::select(DB::raw("Select visitorcount  from  companyvisitors where visitdate = '$currentdate1' and companyid ='$comcompanyid'"));
             
              if(!empty($selectcount1[0]->visitorcount) || isset($selectcount1[0]->visitorcount))
              {
                  $values[$lastdate-$j]=$selectcount1[0]->visitorcount;
                 
              }
             else
             {
                 $values[$lastdate-$j]=0;
             }
             
             
             }
            break;
          
            case 'today':
                $label=array();
                $values=array();
                $totalcount = 0;
             $today=date('Y-m-d');
             
             $selectcount=DB::select(DB::raw("Select visitorcount,visitdate  from  companyvisitors where visitdate = '$today' and companyid = '$comcompanyid'"));
             if(!empty($selectcount[0]->visitdate)&&isset($selectcount[0]->visitdate))
             {
             $values[0]=$selectcount[0]->visitorcount;
             }
             else
             {
             $values[0]=0;
             }
             $label[0]=date('d', strtotime($today));
             $totalcount=$values[0];
              
            break;
          
            
      }
        $labelandvalues=array('label'=>$label,'values'=>$values, 'totalcount'=>$totalcount);
        echo json_encode($labelandvalues);
        
    }
    
    
}
