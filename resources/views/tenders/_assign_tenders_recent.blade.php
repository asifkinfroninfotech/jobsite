<?php
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();

?>
@foreach($gettenantcompany as $tendercompany)

<tr>
                              <td>

                                  <div class="user-with-avatar  ">
                                     
                                   @if($tendercompany->profileimage==null)
                                       <img alt="" src="{{ Avatar::create(ucfirst($tendercompany->name))->toBase64() }}">   
                                @else
                                       <img alt="" src="{{$UserProfileImagePath . $tendercompany->profileimage}}">
                                 @endif                     
                                          
                                   <span class="d-none d-xl-inline-block">{{$tendercompany->name}}</span>
                               
                                
                              </div>
                            </td>
                            <td>
                             <div class="user-with-avatar">
                                  <input type="checkbox" class='selectuser' value="{{$tendercompany->companyid}}" onclick='assigncount();' />

                             </div>
                            </td>
                          
                            
                                                    
                          </tr> 
                          
      @endforeach                    
                          
       
     
      
      
      
      
                            