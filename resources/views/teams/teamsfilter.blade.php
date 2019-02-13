<?php

function setarray($userid,$currentstatus)
{
$helper=\App\Helpers\AppHelper::instance();
$viewstring=$helper->GetHelpModifiedText(trans('teams.view_profile'));   
//$viewstring="asif";
$array=array(
    
    'View'=>'<a class="dropdown-item" data-placement="top" data-toggle="tooltip" data-original-title="'.$viewstring.'"   href="user/profile/view?user='.$userid.'" onclick=view("'.$userid.'","'.$currentstatus.'");>View profile</a>',
    'Active'=>'<a class="dropdown-item" href="#" onclick=active("'.$userid.'","'.$currentstatus.'");>Make Active</a>',
    'Inactive'=>'<a class="dropdown-item" href="#" onclick=inactive("'.$userid.'","'.$currentstatus.'");>Make Inactive</a>',
    'Delete'=>'<a class="dropdown-item" href="#" onclick=deleteinvitedpop("'.$userid.'","'.$currentstatus.'");>Delete Invited</a>',
    'activatestatus'=>'<a class="dropdown-item" href="#" onclick=active("'.$userid.'","'.$currentstatus.'");>Activate User</a>',
    'deactivatestatus'=>'<a class="dropdown-item" href="#" onclick=inactive("'.$userid.'","'.$currentstatus.'");>Deactivate User</a>',
  );
return $array;
}


?>



<?php

      foreach($company as $company)
      {
          if($company!=Null )
          {
            
             $normal='';             
             if($company->userrole=='0'){$normal = 'Admin';}
             if($company->userrole=='1'){$normal = 'Normal';}           
               $status='';           
             if($company->recordstatus=='Active'){$status='green';}
             if($company->recordstatus=='Pending'){$status='yellow';}
             if($company->recordstatus=='Invited'){$status='blue';}
             if($company->recordstatus=='Inactive'){$status='red';}
             if($company->recordstatus=='Deleted'){$status='brown';}
             if($company->recordstatus=='New-Request'){$status='yellow';}
             
             $recordstatus='';
           if($company->recordstatus=='Active'){$recordstatus='Active';}
           if($company->recordstatus=='Pending'){$recordstatus='Pending';}
           if($company->recordstatus=='Invited'){$recordstatus='Invited';}
           if($company->recordstatus=='Inactive'){$recordstatus='Inactive';}
           if($company->recordstatus=='Deleted'){$recordstatus='Deleted';}
           if($company->recordstatus=='New-Request'){$recordstatus='New-Request';}  
             $button="";
             
             $buttonanchor="";
             $userid=$company->userid;
             $array= setarray($userid,$recordstatus);
             foreach($array as $key=>$value)
             {
//                 if($key!=$company->recordstatus)
//                 {
//                     $buttonanchor.=$value;
//                 }
                 
                 
                     if($recordstatus=="Invited")
                     {
                         if($key!="View" && $key!="Active" && $key!="Inactive" && $key!="activatestatus" && $key!="deactivatestatus")
                         {
                             $buttonanchor.=$value;
                         }
                     }
                     if($recordstatus=="New-Request")
                     {
                         if($key!="Active" && $key!="Inactive" && $key!="Delete")
                         {
                             $buttonanchor.=$value;
                         }
                     }
                     
                     
                     if($recordstatus=="Active")
                     {
                         if($key!="Active" && $key!="Delete" && $key!="activatestatus" && $key!="deactivatestatus")
                         {
                             $buttonanchor.=$value;
                         }
                        
                     }
                      if($recordstatus=="Inactive" && $key!="Delete" && $key!="activatestatus" && $key!="deactivatestatus")
                     {
                         if($key!="Inactive")
                         {
                             $buttonanchor.=$value;
                         }
                     }
                     
//                     else
//                     {
//                     $buttonanchor.=$value;
//                     }    
                 
                 
                 
             }
             
             
        if(Session('userrole')=='1'){
                                  
                               $button='<button onclick="location.href=user/profile/view?user='.$userid.'" aria-expanded="false" aria-haspopup="true" class="btn btn-primary"  id="dropdownMenuButton1" type="button">View Profile</button>';

                                  }
        if(Session('userrole')=='0'){
                                  
                               $button='<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button" >Action</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  '.
                                     $buttonanchor  
                                .'</div>';
        }
        if($recordstatus=="Invited"){
                                  
                               //$button="<input class='invited' id='".$userid."' style='float:left' type='checkbox' />";
                                $button='<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button" >Action</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  '.
                                     $buttonanchor  
                                .'</div>';
        }  
        if($recordstatus=="New-Request"){
                                  
                               //$button="<input class='invited' id='".$userid."' style='float:left' type='checkbox' />";
                                $button='<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button" >Action</button>
                                <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                  '.
                                     $buttonanchor  
                                .'</div>';
        }    
        
        
        
        ?>




<tr>
                 <td>
<!--                              <div class="user-with-avatar">-->
                                  <div class="user-with-avatar  {{($company->is_online == 1)?'with-status status-green':''}}">
                                @if($recordstatus=="Invited")
                                 <a href="#">
                                  <?php if(empty($company->userprofileimage)){?>
                                    
                                    <img alt="" src="<?php echo Avatar::create(strtoupper($company->firstname)." ".strtoupper($company->lastname))->toBase64();?>">
                                  <?php }else {?>
                                 <img alt="" src="<?php echo '/storage/user/profileimage/'.$company->userprofileimage;?>">
                                  <?php }?>
                                  <span class="d-none d-xl-inline-block"><?php echo $company->firstname." ".$company->lastname; ?></span>
                                 </a>
                                @else
                                <a href="user/profile/view?user=<?php echo $company->userid;?>">
                                  <?php if(empty($company->userprofileimage)){?>
                                    
                                    <img alt="" src="<?php echo Avatar::create(strtoupper($company->firstname)." ".strtoupper($company->lastname))->toBase64()?>">
                                  <?php }else {?>
                                 <img alt="" src="<?php echo '/storage/user/profileimage/'.$company->userprofileimage;?>">
                                  <?php }?>
                                  <span class="d-none d-xl-inline-block"><?php echo $company->firstname." ".$company->lastname; ?></span>
                                 </a>
                                @endif

                              </div>
                            </td>
                            <td>
                             <div class="user-with-avatar company-name-img">
                                  <a href="company/profile/view?company=<?php echo $company->companyid;?>&user=<?php echo $company->userid;?>&companytype=<?php echo $company->companytype;?>">
                              <?php if(empty($company->companyprofileimage)){?>
                                  
                                <img alt="" src="<?php echo Avatar::create(strtoupper($company->name))->toBase64()?>">
                                <?php }else {?>
                                <img alt="" src="<?php echo '/storage/company/profileimage/'.$company->companyprofileimage;?>">
                                <?php }?>
                              
                              </span><span><?php echo $company->name;?></span>
                            </a>
                             </div>
                            </td>
                            <td>
                              <span><?php echo $company->userposition;?></span>
                            </td>
                            <td>
                              <span><?php echo $normal; ?></span>
                            </td>
                            <td class="text-center" id="status<?php echo $company->userid;?>">
                              <div class="status-pill <?php echo $status;?>" data-title="<?php echo $recordstatus;?>" data-toggle="tooltip" data-original-title="" title=""></div>
                            </td>
                            
                            <td class="text-right">
                              <div class="btn-group mr-1 mb-1">
                                  
                                  <?php echo $button;?>
                                
                              </div>
                            </td>                           
                          </tr> 
                          
                          
        
      <?php }}?> 
        