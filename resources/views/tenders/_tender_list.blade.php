@php
$helper=\App\Helpers\AppHelper::instance();
$symbol='';
if(isset($tender->symbol) && !empty($tender->symbol) )   
{
    $symbol=$tender->symbol;
}
else {
   $symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
}
@endphp
@foreach($lst_tenders as $tender)
<div class="project-box marbtm">
    <div class="project-head">
        <div class="project-title kinaracpital">
            <h5>
                {{ $tender->title}}
            </h5>
            <div class="label">

            </div>
        </div>
        <div class="project-users">

            <div class="avatar">
                <a href="/company/profile/view?{{'company='.$tender->companyid .'&companytype='.$tender->companytype}}">
                    @if( (isset($tender->profileimage) && !empty($tender->profileimage) ) &&
                    File::exists(public_path('/storage/company/profileimage/'.$tender->profileimage)))

                    <img alt="" src="/storage/company/profileimage/{{$tender->profileimage}}">
                    @else
                    <img alt="" src="{{ Avatar::create(strtoupper($tender->companyname)) }}">
                    @endif
                </a>
            </div>

        </div>
    </div>

    <div class="project-info">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <div class="row">

                        @if(isset($tender->approximate_budget) && $tender->approximate_budget>0)
                        <div class="col-sm-3">
                            <div class="el-tablo highlight">
                              <div class="label">
                                Approximate Budget
                              </div>
                              <div class="value">
                                  {{$symbol.$helper->nice_number($tender->approximate_budget)}}
                              </div>
                            </div>
                          </div>
                          @endif

                    <div class="col-sm-3">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <ul>
                                    @if(isset($tender->dealid) && !empty($tender->dealid))
                                    <li>
                                        <span> {{trans('my_tender.project_list_project_lbl')}}</span>
                                        <a href="/deals/view-deal?dealid={{$tender->dealid}}" target="_blank"><strong>{{$tender->projectname}}</strong></a>
                                    </li>
                                    @endif

                                    <li>
                                        <span>{{trans('my_tender.project_list_start_lbl')}}</span>
                                        <strong>{{date("M d, Y", strtotime($tender->startdate))}} </strong>
                                    </li>

                                    <li>
                                        <span>{{trans('my_tender.project_list_end_lbl')}}</span>
                                        <strong>{{date("M d, Y", strtotime($tender->enddate))}} </strong>
                                    </li>


                                </ul>

                            </div>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <ul>

                                    <li>
                                        <span>{{trans('my_tender.project_list_description_lbl')}}</span>
                                        @if(isset($tender->odes) && !empty($tender->odes))
                                        @if(strlen($tender->odes)>150)
                                        <strong> {!! $tender->description!!}...</strong>
                                        @else
                                        <strong> {!! $tender->description!!}</strong>

                                        @endif
                                        @endif
                                    </li>



                                </ul>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <div class="pt-btn">
                                    <a class="btn btn-success btn-sm" href="#">
                                        {{$tender->status}}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


        </div>

        <div class="my-profile-foldr clearfix">
            <div class="label">
                {{trans('my_tender.project_list_uploaded_docs_lbl')}}
            </div>

            <div class="project-users">
                {{trans('my_tender.project_list_tender_type_lbl')}}
            </div>


        </div>
        <div class="sds-cost-folder">
            <div class="row">
                <div class="col-md-6">
                    <ul>
@if( (isset($tender->file1) && !empty($tender->file1)) || (isset($tender->file2) && !empty($tender->file2)))
                        <li>
<strong><a href="/storage/tender/new/{{$tender->file1}}" target="_blank">{{$tender->file1}} </a></strong>
                        </li>
                        <li>
<strong><a href="/storage/tender/new/{{$tender->file2}}" target="_blank">{{$tender->file2}}</a></strong>
                        </li>
                        @else
<li>
    <strong>No documents found.</strong>
</li>

                        @endif
                    </ul>
                </div>

                <div class="col-md-6 text-right">

                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$tender->type}}</button>

                </div>
            </div>
        </div>


        <div class="form-buttons-w text-right my-portfolio-btm">
            <button class="view-tender btn btn-primary" type="button" onclick="opentender('{{$tender->tenderid}}','{{$tender->dealid}}');">{{trans('my_tender.project_list_view_btn_lbl')}}</button>
            <button class="close-tender btn btn-primary" type="button" onclick="closetender('{{$tender->tenderid}}');">{{trans('my_tender.project_list_close_btn_lbl')}}</button>
            {{-- <a class="vt_onclose_tender btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank" style="display:none;">{{trans('my_tender.project_list_view_btn_lbl')}}</a> --}}

            <div class="btn-group mr-1 mb-1" style="float:left;">

                <span>{{trans('my_tender.project_list_total_bid_count')}}&nbsp;</span>
                <strong>{{$tender->pcount}}</strong>

            </div>
        </div>
    </div>



</div>

</div>
@endforeach
