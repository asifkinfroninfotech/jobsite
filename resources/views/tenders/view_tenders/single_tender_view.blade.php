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
@extends('layouts.app_layout', ['layout' => 'left_side_menu_compact'])
@section('content')
<div class="content-w portfolio-custom-vk">
        <!--
          START - Secondary Top Menu
          -->
          @include('shared._top_menu')  
        <!--
            END - Secondary Top Menu
            -->

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
                                                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('view_tender.help_btn_hide_caption')}}</button>
                                                </div>
                            </div>
                        </div>
              @endif
              
              
          </div>
        </div>
        <!--END - Control panel above projects-->

        <div class="content-i">
          <div class="content-box project-list project-list-vk investor-profile-view">
            <!--
              start - View Tender
             -->
            <div class="row">
              <div class="col-sm-12">
                <div class="element-wrapper">

                           <h6 class="element-header">
{{trans('view_tender.single_tender_tender_details_caption')}}
                                 
                            </h6>
                            <div class="project-box marbtm">
                              
                           <div class="element-box" id="viewtender">

                            @if(isset($tenderviewlist->title))
                             <div class="row invst-pfl">
                                    <div class="col-sm-4">
                                    {{-- <div class="label">Company</div> --}}
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
<div class="label">{{trans('view_tender.single_tender_tender_name')}}</div>
                              <h5>{{$tenderviewlist->title}}</h5>
                            </div>

                            <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_desired_time_frame')}}</div>
                                  <h5>{{$tenderviewlist->desired_time_frame}}</h5>
                                </div>
                            
                            </div>
                             @endif 
                             
                             @if(isset($tenderviewlist->startdate) || isset($tenderviewlist->enddate) || isset($tenderviewlist->approximate_budget))
                             <div class="row invst-pfl">

                                @if(isset($tenderviewlist->approximate_budget) && $tenderviewlist->approximate_budget>0 )  
                                <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_approc_budget')}}</div>
                                      <h5>{{$symbol.$tenderviewlist->approximate_budget}}</h5>
                                    </div>
                                    @endif

                              @if(isset($tenderviewlist->startdate))    
                            <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_start_date')}}</div>
                              <h5>{{date('d M Y',strtotime($tenderviewlist->startdate))}}</h5>
                            </div>
                              @endif
                              @if(isset($tenderviewlist->enddate))   
                             <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_end_date')}}</div>
                              <h5>{{date('d M Y',strtotime($tenderviewlist->enddate))}}</h5>
                            </div> 
                              @endif

                            </div>
                             @endif 
        
        
                            <div class="row invst-pfl">
                                @if(isset($tenderviewlist->type) && !empty($tenderviewlist->type))    
                                <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_type')}}</div>
                                  <h5>{{$tenderviewlist->type}}</h5>
                                </div>
                                 @endif 
                             @if(isset($tenderviewlist->file1))    
                            <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_file_one')}}</div>
                            <a href="/storage/tender/new/{{$tenderviewlist->file1}}" target="_blank">{{$tenderviewlist->file1}}</a>
                            </div>
                             @endif   
                              @if(isset($tenderviewlist->file2))    
                            <div class="col-sm-4">
<div class="label">{{trans('view_tender.single_tender_file_two')}}</div>
                              <a href="/storage/tender/new{{$tenderviewlist->file2}}" target="_blank">{{$tenderviewlist->file2}}</a>
                            </div>
                             @endif  
                            </div>

                             @if(isset($tenderviewlist->description) && !empty($tenderviewlist->description))
                             <div class="row invst-pfl">
                              <div class="col-sm-12">
<div class="label">{{trans('view_tender.single_tender_description')}}</div>
                              <p>{!!$tenderviewlist->description!!}</p>
                            </div>
                            </div>
                             @endif 

                             @if(isset($tenderviewlist->services_requested) && !empty($tenderviewlist->services_requested))
                             <div class="row invst-pfl">
                              <div class="col-sm-12">
<div class="label">{{trans('view_tender.single_tender_tender_request')}}</div>
                              <p>{!!$tenderviewlist->services_requested!!}</p>
                            </div>
                            </div>
                             @endif 

                             @if(isset($tenderviewlist->resource_requirements) && !empty($tenderviewlist->resource_requirements))
                             <div class="row invst-pfl">
                              <div class="col-sm-12">
<div class="label">{{trans('view_tender.single_tender_estimation_resource_requirements')}}</div>
                              <p>{!!$tenderviewlist->resource_requirements!!}</p>
                            </div>
                            </div>
                             @endif 
               
                             @if(isset($deallist))
                             <div class="row invst-pfl">
                               
                              @if(isset($deallist))  
                             <div class="col-sm-7">
<div class="label">{{trans('view_tender.single_tender_deals')}}</div>
                              <h5>{{$tenderviewlist->type}}</h5>
                            </div>    
                             @endif
                              
                            
                            </div>
                             @endif 
        
                          </div>
                        </div>
        
             


                </div>
              </div>
            </div>
            <!--
              END - My Portfolio 
              -->

          </div>
          <!--
            START - Sidebar
            -->

          <!--
            END - Sidebar
            -->
        </div>
      </div>

      @endsection


