<?php 
$helper=\App\Helpers\AppHelper::instance();
 $loggedinuserid=Session('userid');
//  $collectionsdg = collect(json_decode($deals_sdgs, true));
 ?>
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show-pop-up" role="dialog"
    tabindex="-1" id="common-pop-up">
    <div class="modal-dialog">
        <div class="modal-content" id="si_content">

        </div>
    </div>
</div>

@php
$parent_collection=collect(json_decode($deals_dd_parents, true));
@endphp

@foreach($data as $d)
@php
$parent_avl_count=$parent_collection->where('dealid',$d->dealid)->count();
@endphp
<div class="project-box mar-one-rem">
    <div class="project-head">
        <div class="project-title kinaracpital">
            <h5>
                {{$d->company}}
            </h5>
            <div class="label">
                {{$d->statusmessage}}
            </div>
        </div>
        <div class="btn-group mr-1 mb-1">
            <span><button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{strtoupper($d->deal_active)}}</button>
            </span>
        </div>
    </div>
    <div class="project-info">
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="el-tablo highlight">
                            <div class="label">
                                Investment Required
                            </div>
                            <div class="value">
                                ${{$helper->nice_number($d->totalinvestmentrequired)}}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        <span>Project:</span>
                                        <strong>{{$d->projectname}} </strong>
                                    </li>
                                    @if(isset($d->investmentstage) && !empty($d->investmentstage))
                                    <li>
                                        <span>Stage:</span>
                                        <strong>{{$d->investmentstage}} </strong>
                                    </li>
                                    @endif
                                    <li>
                                        <span>Date of Created:</span>
                                        <strong>{{date('M d,Y',strtotime($d->updated)) }} </strong>
                                    </li>
                                    <li>
                                        <span>Country:</span>
                                        <strong>{{$d->country}} </strong>
                                    </li>
                                    <li>
                                        <span>Total Views:</span>
                                        <strong>{{$d->totalviews}}</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 mr-rit-auto">
                <?php 
                                         $sdg_available=0;
                                        // $containedsdgs=$collectionsdg::where('dealid','$d->dealid')->get();
                                        // print_r($containedsdgs); 
                                         ?>
                <div class="text-right">

                    {{-- @if(count($sdgs)>0) --}}
                    <div class="project-users sdg">
                        SDG (S)
                    </div>
                    {{-- <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Peace,
                        Justice & Strong Institutions</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Affordable &
                        Clean Energy</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Climate Action</button>
                    --}}

                    @if(filled($deals_sdgs))
                    @foreach($deals_sdgs as $sdg)
                    @if($sdg->dealid==$d->dealid)
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button">{{$sdg->sdg}}</button>
                    @php
                    $sdg_available=1;
                    @endphp
                    @endif
                    @endforeach

                    @endif
                    @if($sdg_available==0)
                    No SDG (S) found.
                    @endif

                    {{-- @endif --}}
                </div>
            </div>
        </div>
        <div class="row form-buttons-w interbtn">
            {{-- <div class="col-lg-6 col-md-12">
                <div class="form-buttons-w text-left my-portfolio-btm">
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence Underway</a>
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence History</a>
                </div>
            </div> --}}
            {{-- <style>
                .avatar-circle{float: left;  margin: 0 4px;   width: 35px;
                                            border-radius: 35px; box-shadow: 0px 0px 0px 5px #fff;
                                            display: inline-block; overflow: hidden;height: 35px; border: 1px solid rgba(0, 0, 0, 0.05);                                            
                                             position: relative; vertical-align: middle;}
                                             .project-usersvk { display: flex; align-items: center;}
                                             .avatar-circle a { position: absolute;left: 0;top: 0; bottom: 0;margin: auto;display: table;}
                                             .project-usersvk p {display: inline-block;margin: 0 10px 0 0;} 
                                            .user-lft-wrap{display: inline-block}  
                                        </style>
            --}}

            <div class="col-lg-6">
                <div class="project-users project-usersvk">
                    @if($parent_avl_count>0)
                    <p>DD In Progress: <a href="/deals/view-deal?dealid={{$d->dealid}}">{{$parent_avl_count}} </a></p>
                    {{-- <div class="user-lft-wrap">
                        @foreach($deals_dd_parents as $p)
                        @if($p->dealid==$d->dealid)
                        <div class="avatar avatar-circle">

                            <a href="/deals/view-deal?dealid={{$p->dealid}}">
                                @if( (isset($p->profileimage) && !empty($p->profileimage) ) &&
                                File::exists(public_path('storage/company/profileimage/'.$p->profileimage)))
                                <img alt="" src="storage\company\profileimage\{{$p->profileimage}}" />
                                @else
                                <img alt="" src="{{ Avatar::create($p->company)->toBase64() }}" />
                                @endif
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div> --}}
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-right my-portfolio-btm">
                    <a class="btn btn-yellow-custom step-trigger-btn" href="/deals/view-deal?dealid={{$d->dealid}}"
                        data-placement="top" data-toggle="tooltip" data-original-title="{{$helper->GetHelpModifiedText(trans('dealpipeline.view_deal'))}}"
                        target="_blank">View Deal</a>
                    @if($d->deal_active=='active')
                    <a class="btn btn-primary step-trigger-btn" href="javascript:void(0);" onclick="fnShowInterestModal('{{$d->dealid}}');"
                        data-target=".show-pop-up" data-toggle="modal">Add To My Portfolio</a>
                    @endif



                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- <div class="project-box">
    <div class="project-head">
        <div class="project-title kinaracpital">
            <h5>
                Kinara Capital
            </h5>
            <div class="label">
                Financial Services
            </div>
        </div>
    </div>
    <div class="project-info">
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="el-tablo highlight">
                            <div class="label">
                                Investment Required
                            </div>
                            <div class="value">
                                $12m
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        <span> Round:</span>
                                        <strong>One </strong>
                                    </li>
                                    <li>
                                        <span>Start:</span>
                                        <strong>Early Growth </strong>
                                    </li>
                                    <li>
                                        <span>Date of Created:</span>
                                        <strong>July 30, 2012 </strong>
                                    </li>
                                    <li>
                                        <span>Country:</span>
                                        <strong>United Kindom </strong>
                                    </li>
                                    <li>
                                        <span>Total Views:</span>
                                        <strong>115</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 mr-rit-auto">
                <div class="text-right">
                    <div class="project-users sdg">
                        SDG (S)
                    </div>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Peace, Justice
                        & Strong Institutions</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Affordable &
                        Clean Energy</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Climate Action</button>
                </div>
            </div>
        </div>
        <div class="row interbtn">
            <div class="col-lg-6 col-md-12">
                <div class="form-buttons-w text-left my-portfolio-btm">
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence Underway</a>
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence History</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-buttons-w text-right my-portfolio-btm">
                    <a class="btn btn-primary step-trigger-btn" href="#"> Connect</a>
                    <a class="btn btn-yellow-custom step-trigger-btn" href="#"> Show Interest </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="project-box mar-one-rem">
    <div class="project-head">
        <div class="project-title kinaracpital">
            <h5>
                Kinara Capital
            </h5>
            <div class="label">
                Financial Services
            </div>
        </div>
    </div>
    <div class="project-info">
        <div class="row align-items-center">
            <div class="col-sm-12 col-lg-6">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="el-tablo highlight">
                            <div class="label">
                                Investment Required
                            </div>
                            <div class="value">
                                $12m
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="el-tablo estimated-time profile-tile highlight">
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        <span> Round:</span>
                                        <strong>One </strong>
                                    </li>
                                    <li>
                                        <span>Start:</span>
                                        <strong>Early Growth </strong>
                                    </li>
                                    <li>
                                        <span>Date of Created:</span>
                                        <strong>July 30, 2012 </strong>
                                    </li>
                                    <li>
                                        <span>Country:</span>
                                        <strong>United Kindom </strong>
                                    </li>
                                    <li>
                                        <span>Total Views:</span>
                                        <strong>115</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 mr-rit-auto">
                <div class="text-right">
                    <div class="project-users sdg">
                        SDG (S)
                    </div>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Peace, Justice
                        & Strong Institutions</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Affordable &
                        Clean Energy</button>
                    <button class="mr-2 mb-2 btn btn-outline-primary btn-sm btn-rounded" type="button"> Climate Action</button>
                </div>
            </div>
        </div>
        <div class="row interbtn">
            <div class="col-lg-6 col-md-12">
                <div class="form-buttons-w text-left my-portfolio-btm">
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence Underway</a>
                    <a class="btn step-trigger-btn gray-btn" href="#"> Due Diligence History</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-buttons-w text-right my-portfolio-btm">
                    <a class="btn btn-primary step-trigger-btn" href="#"> Connect</a>
                    <a class="btn btn-yellow-custom step-trigger-btn" href="#"> Show Interest </a>
                </div>
            </div>
        </div>
    </div>
</div> --}}



<!--START - next pagers-->
{{ $data->links('pagination') }}
{{--
<div class="controls-below-table controls-pagination-cnt row">

    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="table-records-info">
            Showing records 1 - 5
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="table-records-pages align-rit">
            <ul>
                <li>
                    <a href="#">Previous</a>
                </li>
                <li>
                    <a class="current" href="#">1</a>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li>
                <li>
                    <a href="#">Next</a>
                </li>
            </ul>
        </div>
    </div>
</div>
--}}
<!--END - next pagers-->
