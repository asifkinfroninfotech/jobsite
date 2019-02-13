@php
$helper=\App\Helpers\AppHelper::instance();
$symbol='';
if(isset($tenderviewlist->symbol) && !empty($tenderviewlist->symbol) )
{
$symbol=$tenderviewlist->symbol;
}
else {
$symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
}
@endphp

                    <h6 class="element-header">
                        {{trans('my_tender.popup_view_tender_details_title')}}
                        @if($tenderviewlist->status=='Open')
                        <span style='float:right;'><button class="btn btn-primary" type="button"  id="editme" onclick="edittender('{{$tenderviewlist->tenderid}}');" >{{trans('my_tender.popup_edit_btn_caption')}}</button></span>
                        @endif
                    </h6>
                    <div class="project-box marbtm">

                       
                   <div class="modal-body" id="tenderedit">
                      @if(isset($tenderviewlist->title) || isset($tenderviewlist->company))
                     <div class="row invst-pfl">
                      

                     <div class="col-sm-4">
                 
                   <a href="/company/profile/view?{{'company='.$tenderviewlist->companyid .'&companytype='.$tenderviewlist->companytype}}">
                    @if( (isset($tenderviewlist->profileimage) && !empty($tenderviewlist->profileimage) ) &&
                    File::exists(public_path('/storage/company/profileimage/'.$tenderviewlist->profileimage)))

                    <img alt="" src="/storage/company/profileimage/{{$tenderviewlist->profileimage}}" style="width:37px;">
                    @else
                    <img alt="" src="{{ Avatar::create(strtoupper($tenderviewlist->company)) }}" style="width:37px;">
                    @endif
                    </a>
                    <span>{{$tenderviewlist->company}}</span>
                    
                    </div>      
 
                         
                         
                     @if(isset($tenderviewlist->title))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_tender_name_lbl')}}</div>
                      <h5>{{$tenderviewlist->title}}</h5>
                    </div>
                    @endif
                    
                    @if(isset($tenderviewlist->desired_time_frame))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_desired_time_frame')}}</div>
                      <h5>{{$tenderviewlist->desired_time_frame}}</h5>
                    </div>
                    @endif
                    
                    </div>
                     @endif 
                     
                     @if(isset($tenderviewlist->startdate) || isset($tenderviewlist->enddate) || isset($tenderviewlist->approximate_budget))
                     <div class="row invst-pfl">
                      @if(isset($tenderviewlist->startdate))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_start_date_lbl')}}</div>
                      <h5>{{date('d M Y',strtotime($tenderviewlist->startdate))}}</h5>
                    </div>
                      @endif
                      @if(isset($tenderviewlist->enddate))   
                     <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_end_date_lbl')}}</div>
                      <h5>{{date('d M Y',strtotime($tenderviewlist->enddate))}}</h5>
                    </div> 
                      @endif
                       @if(isset($tenderviewlist->type) && !empty($tenderviewlist->type))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_type_lbl')}}</div>
                      <h5>{{$tenderviewlist->type}}</h5>
                    </div>
                     @endif 
                      
                      
                    
                    </div>
                     @endif 


                     <div class="row invst-pfl">
                     @if(isset($tenderviewlist->file1))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_document1_lbl')}}</div>
                    <a href="/storage/tender/new/{{$tenderviewlist->file1}}" target="_blank">{{$tenderviewlist->file1}}</a>
                    </div>
                     @endif   
                      @if(isset($tenderviewlist->file2))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_document2_lbl')}}</div>
                      <a href="/storage/tender/new{{$tenderviewlist->file2}}" target="_blank">{{$tenderviewlist->file2}}</a>
                    </div>
                     @endif  
                     @if(isset($tenderviewlist->approximate_budget))    
                    <div class="col-sm-4">
                    <div class="label">{{trans('my_tender.popup_view_approximate_budget_lbl')}}</div>
                      <h5>{{$symbol.$tenderviewlist->approximate_budget}}</h5>
                    </div>
                     @endif  
                    </div>
                     

                     @if(isset($tenderviewlist->description) && !empty($tenderviewlist->description))
                     <div class="row invst-pfl">
                     <div class="col-sm-12">
                    <div class="label">{{trans('my_tender.popup_view_description_lbl')}}</div>
                    <p>{!!$tenderviewlist->description!!}</p>
                    </div>
                     </div>
                     @endif 
       
                     @if(isset($deallist))
                     <div class="row invst-pfl">
                       
                      @if(isset($deallist))  
                     <div class="col-sm-7">
                    <div class="label">Deals</div>
                      <h5>{{$tenderviewlist->type}}</h5>
                    </div>    
                     @endif
                      
                    
                    </div>
                     @endif 

                     
                     
                     
                     
                      @if(isset($tenderviewlist->resource_requirements))
                     <div class="row invst-pfl">
                       
                       
                     <div class="col-sm-12">
                    <div class="label">{{trans('my_tender.popup_view_resource_requirements_lbl')}}</div>
                      <p>{{$tenderviewlist->resource_requirements}}</p>
                    </div>  
                    
                      
                    
                    </div>
                     @endif 
                     
                     
                     
                  @if(isset($tenderviewlist->services_requested))
                     <div class="row invst-pfl">
                       
                       
                     <div class="col-sm-12">
                    <div class="label">{{trans('my_tender.popup_view_services_requested_lbl')}}</div>
                      <p>{{$tenderviewlist->services_requested}}</p>
                    </div>  
                    
                      
                    
                    </div>
                     @endif    
                     
                     
                     
                     
                     
     
                     
                     
                     
                     
                     
                            
                           <input type="hidden" name="tendertype" id="tendertype" value="">
                            
                        
                   
                    

                    
                  </div>
                </div>
                    {{-- 
                 </div>
                    
                    </div> --}}

     