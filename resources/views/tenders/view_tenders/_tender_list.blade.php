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

<img alt="{{$tender->companyname}}" src="/storage/company/profileimage/{{$tender->profileimage}}">
                    @else
<img alt="{{$tender->companyname}}" src="{{ Avatar::create(strtoupper($tender->companyname)) }}">
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
                                {{trans('view_tender.list_approx_budget')}}
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
                                        <span> {{trans('view_tender.list_project_lbl')}}</span>
                                        <a href="/deals/view-deal?dealid={{$tender->dealid}}" target="_blank"><strong>{{$tender->projectname}}</strong></a>
                                    </li>
                                    @endif
                                    <li>
                                        <span>{{trans('view_tender.list_start_lbl')}}</span>
                                        <strong>{{date("M d, Y", strtotime($tender->startdate))}} </strong>
                                    </li>
                                    <li>
                                        <span>{{trans('view_tender.list_end_lbl')}}</span>
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
                                        <span>{{trans('view_tender.list_description_lbl')}}</span>
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
                {{trans('view_tender.list_uploaded_documents')}}
            </div>

            <div class="project-users">
                {{trans('view_tender.list_tender_type')}}
            </div>


        </div>
        <div class="sds-cost-folder">
            <div class="row">
                <div class="col-md-6">
                    <ul>
@if( (isset($tender->file1) && !empty($tender->file1)) || (isset($tender->file2) && !empty($tender->file2)))
                        <li>
<strong><a href="/storage/tender/new/{{$tender->file1}}" target="_blank">{{$tender->file1}}</a></strong>
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
            @switch($activetabpage)
            @case('open tenders')
<a class="btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank">{{trans('view_tender.view_tender')}}</a>
            {{-- <button class="btn btn-primary" type="button" onclick="fnViewTender('{{$tender->tenderid}}');">View
                Tender</button> --}}
            <button class="btn btn-primary" type="button" data-target="#tender_accept_confirmation_modal" data-toggle="modal"
onclick="fnOpenConfirmationToAcceptTender('{{$tender->tenderid}}');">{{trans('view_tender.accept_btn_caption')}}</button>
            @break
            @case('accepted tenders')
            <a class="btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank">{{trans('view_tender.view_tender')}}</a>
            <a class="btn btn-primary" href="/tender/bidding?tid={{$tender->tenderid}}">{{trans('view_tender.accepted_tender_view_edit_bid')}}</a>
            @break
            @case('bid submitted')
<a class="btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank">{{trans('view_tender.view_tender')}}</a>
<a class="btn btn-primary" href="/tender/bidding/view?pid={{$tender->proposalid}}" target="_blank">{{trans('view_tender.view_bid')}}</a>

            @break
            @case('bid accepted')
<a class="btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank">{{trans('view_tender.view_tender')}}</a>
<a class="btn btn-primary" href="/tender/bidding/view?pid={{$tender->proposalid}}" target="_blank">{{trans('view_tender.view_bid')}}</a>
            @break
            @case('bid rejected')
<a class="btn btn-primary" href="/view-single-tender?tid={{$tender->tenderid}}" target="_blank">{{trans('view_tender.view_tender')}}</a>
            <a class="btn btn-primary" href="/tender/bidding/view?pid={{$tender->proposalid}}" target="_blank">{{trans('view_tender.view_bid')}}</a>
            @break

            @default

            @endswitch


            <div class="btn-group mr-1 mb-1" style="float:left;">

                <span>{{trans('view_tender.list_total_bid_count')}}&nbsp;</span>
                <strong>{{$tender->pcount}}</strong>

            </div>
        </div>
    </div>



</div>

</div>
@endforeach
