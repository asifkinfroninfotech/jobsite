@php
// $extends="";
// $view="";
// $layout="";
// if(isset($calledfrom) && !empty($calledfrom))
// {

// if($calledfrom=="admin")
// {
// $view='adminview.layouts.app_layout';
// $layout='left_side_menu';

// }
// else if($calledfrom=="tenant")
// {
// $view= 'tenants.layouts.app_layout';
// $layout='left_side_menu_tenant';

// }
// }
// else
// {
// $view= 'layouts.app_layout';
// $layout='left_side_menu_compact';
// }
$symbol='';
if(isset($tenderviewlist->symbol) && !empty($tenderviewlist->symbol) )   
{
    $symbol=$tenderviewlist->symbol;
}
else {
   $symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
}
@endphp

{{-- @extends($view, ['layout' => $layout]) --}}
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])

@section('content')

<?php 
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
?>

<div class="content-w portfolio-custom-vk">

    <!--  START - Secondary Top Menu  -->
    {{-- @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif --}}

    @include('shared._top_menu')
    <!--   END - Secondary Top Menu   -->



    <!-- -->

    <div class="content-panel-toggler">
        <i class="os-icon os-icon-grid-squares-22"></i>
        <span>Sidebar</span>
    </div>
    <!--START - Control panel above projects-->
    <div class="content-i control-panel">
        <div class="content-box-tb">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('view_tender.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('view_tender.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('view_tender.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
    <!--END - Control panel above projects-->

    <div class="content-i">
            <div class="content-box"><div class="row">

  <div class="col-sm-12">
        <div class="element-wrapper">
                <h6 class="element-header">
                     {{trans('view_tender.bidding_info_view_tender_info_lbl')}}
                    </h6>
                    <div class="element-box">
                            <div class="projects-list projects-list-vk investor-profile-view">
                            @if(isset($tenderviewlist->title))
                            <div class="row invst-pfl">
                                   <div class="col-sm-4">
                                   <a href="/company/profile/view?{{'company='.$tenderviewlist->companyid .'&companytype='.$tenderviewlist->companytype}}"> 
                                     @if($tenderviewlist->profileimage==null)
                                   <img alt="" src="{{ Avatar::create($tenderviewlist->company)->toBase64() }}" style="width: 50px;"/> 
                                      @else
                                      <img alt="" src="/storage/company/profileimage/{{$tenderviewlist->profileimage}}" style="width: 50px;"/>   
                                     @endif
                                       </a>
                                    <span>{{$tenderviewlist->company}}</span>
                                   </div>
                                   

                           <div class="col-sm-4">
                            <div class="label">{{trans('view_tender.bidding_info_view_tender_name_lbl')}}</div>
                             <h5>{{$tenderviewlist->title}}</h5>
                           </div>

                           <div class="col-sm-4">
                           <div class="label">{{trans('view_tender.bidding_info_view_tender_status_lbl')}}</div>
                                  <h5>{{$tenderviewlist->status}}</h5>
                                </div>
                           </div>
                            @endif 
                            
                            @if(isset($tenderviewlist->startdate) || isset($tenderviewlist->enddate) || isset($tenderviewlist->type))
                            <div class="row invst-pfl">
                             @if(isset($tenderviewlist->startdate))    
                           <div class="col-sm-4">
                           <div class="label">{{trans('view_tender.bidding_info_view_start_date_lbl')}}</div>
                             <h5>{{date('d M Y',strtotime($tenderviewlist->startdate))}}</h5>
                           </div>
                             @endif
                             @if(isset($tenderviewlist->enddate))   
                            <div class="col-sm-4">
<div class="label">{{trans('view_tender.bidding_info_view_end_date_lbl')}}</div>
                             <h5>{{date('d M Y',strtotime($tenderviewlist->enddate))}}</h5>
                           </div> 
                             @endif
                              @if(isset($tenderviewlist->type) && !empty($tenderviewlist->type))    
                           <div class="col-sm-4">
<div class="label">{{trans('view_tender.bidding_info_view_type_lbl')}}</div>
                             <h5>{{$tenderviewlist->type}}</h5>
                           </div>
                            @endif 
                           </div>
                            @endif 
                        </div>
                    </div>


        </div>


    <div class="element-wrapper">
            <h6 class="element-header">
                    Bid Detail ({{$proposaldata->company}})
                </h6>
    <div class="element-box">

            
        <div class="projects-list projects-list-vk investor-profile-view" id="singleproposalview">
               

           <div class="row invst-pfl">
         
                @if(isset($proposaldata->proposal_heading) && !empty($proposaldata->proposal_heading))    
                <div class="col-sm-6">
                    
<div class="label">{{trans('view_tender.bidding_info_view_proposal_heading')}}</div>
                  <h5>{{$proposaldata->proposal_heading}}</h5>
                </div>
                @endif 
                
                </div>     
                
                <div class="row invst-pfl">
                
                        @if(isset($proposaldata->quoteamount) && !empty($proposaldata->quoteamount))    
                        <div class="col-sm-4">
                            
<div class="label">{{trans('view_tender.bidding_info_view_quote_amount')}}</div>
                          <h5>{{$symbol.$proposaldata->quoteamount}}</h5>
                        </div>
                        @endif  

                        {{-- @if(isset($proposaldata->approximate_budget) && !empty($proposaldata->approximate_budget))    
                        <div class="col-sm-4">
                           
                        <div class="label">Approximate Budget</div>
                          <h5>{{$proposaldata->approximate_budget}}</h5>
                        </div>    
                        @endif  --}}

                        @if(isset($proposaldata->proposalstate) && !empty($proposaldata->proposalstate))     
                        <div class="col-sm-4">
                           
<div class="label">{{trans('view_tender.bidding_info_view_proposal_state')}}</div>
                          <h5>{{$proposaldata->proposalstate}}</h5>
                        </div>    
                        @endif  
                        
                        @if(isset($proposaldata->file1) && !empty($proposaldata->file1))    
                        <div class="col-sm-4">
<div class="label">{{trans('view_tender.bidding_info_file')}}</div>
                        <a href="/storage/tender/proposal/{{$proposaldata->file1}}" target="_blank">{{(isset($proposaldata->file1)&&!empty($proposaldata->file1))?$proposaldata->file1:''}}</a>
                        </div>    
                        @endif 
                        
                </div>

                  
                   
                 <div class="row invst-pfl">
                @if(isset($proposaldata->date_accepted) && !empty($proposaldata->date_accepted))    
                <div class="col-sm-4">
                   
<div class="label">{{trans('view_tender.bidding_info_date_accepted')}}</div>
                  <h5>{{date('d M Y',strtotime($proposaldata->date_accepted))}}</h5>
                </div>    
                @endif    
                @if(isset($proposaldata->people_involved) && !empty($proposaldata->people_involved))    
                <div class="col-sm-4">
                    
<div class="label">{{trans('view_tender.bidding_info_people_involved')}}</div>
                  <h5>{{$proposaldata->people_involved}}</h5>
                </div>
                @endif    
                 @if(isset($proposaldata->duration_to_complete) && !empty($proposaldata->duration_to_complete))    
                <div class="col-sm-4">
                   
<div class="label">{{trans('view_tender.duration_to_complete')}}</div>
                  <h5>{{$proposaldata->duration_to_complete}}</h5>
                </div>    
                @endif    
                
                </div>  

               
                {{-- <div class="row invst-pfl"> @if(isset($proposaldata->desired_time_frame) && !empty($proposaldata->desired_time_frame))    
                <div class="col-sm-4">
                   
                <div class="label">Desired Time Frame</div>
                  <h5>{{$proposaldata->desired_time_frame}}</h5>
                </div>    
                @endif 

                @if(isset($proposaldata->resource_requirements) && !empty($proposaldata->resource_requirements))    
                <div class="col-sm-4">
                   
                <div class="label">Resourece Requirements</div>
                  <h5>{{$proposaldata->resource_requirements}}</h5>
                </div>    
                @endif </div> --}}

               

                {{-- @if(isset($proposaldata->services_requested) && !empty($proposaldata->services_requested))    
                <div class="row invst-pfl">
                <div class="col-sm-12">
                <div class="label">Services Requested</div>
                  <p>{{$proposaldata->services_requested}}</p>
                </div>
                </div>   
                 @endif   --}}
                   
                @if(isset($proposaldata->short_description) && !empty($proposaldata->short_description))    
                <div class="row invst-pfl">
                <div class="col-sm-12">
<div class="label">{{trans('view_tender.bidding_info_short_description')}}</div>
                  <p>{{$proposaldata->short_description}}</p>
                </div>
                </div>   
                 @endif  

                 @if(isset($proposaldata->why_consider_you) && !empty($proposaldata->why_consider_you))  
                 <div class="row invst-pfl">  
                <div class="col-sm-12">
<div class="label">{{trans('view_tender.bidding_why_consider_you')}}</div>
                  <p>{{$proposaldata->why_consider_you}}</p>
                </div>
                </div>
                @endif 
            

                @if(isset($proposaldata->additional_info) && !empty($proposaldata->additional_info))  
                 <div class="row invst-pfl">
                 <div class="col-sm-12">
<div class="label">{{trans('view_tender.bidding_additional_info')}}</div>
                  <p>{{$proposaldata->additional_info}}</p>
                </div>    
                </div>   
                @endif   

                <div class="row invst-pfl">
                         @if(isset($proposaldata->is_submitted) && !empty($proposaldata->is_submitted))     
                        <div class="col-sm-4">
                           
<div class="label">{{trans('view_tender.bidding_proposal_submitted')}}</div>
                          <h5>{{($proposaldata->is_submitted==0)?'No':'Yes'}}</h5>
                        </div>    
                        @endif    
                        @if(isset($proposaldata->date_submitted) && !empty($proposaldata->date_submitted))    
                        <div class="col-sm-4">
                            
<div class="label">{{trans('view_tender.bidding_date_submitted')}}</div>
                          <h5>{{date('d M Y',strtotime($proposaldata->date_submitted))}}</h5>
                        </div>
                        @endif 
                        
                        </div>
                   
        </div>
    </div>
    </div>
  </div>
</div><!--------------------
              START - Color Scheme Toggler
              -------------------->
              <!--------------------
              END - Color Scheme Toggler
              --------------------><!--------------------
              START - Chat Popup Box
              -------------------->
              <!--------------------
              END - Chat Popup Box
              -------------------->
            </div>
            <!--------------------
            START - Sidebar
            -------------------->
           
            <!--------------------
            END - Sidebar
            -------------------->
          </div>
</div>





@endsection


@section('scripts')
<script type="text/javascript">
   
    
    

</script>

@endsection
