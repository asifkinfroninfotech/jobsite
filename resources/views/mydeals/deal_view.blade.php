@php
$helper=\App\Helpers\AppHelper::instance();
$extends="";
$view="";
$layout="";
if(isset($calledfrom) && !empty($calledfrom))
{

if($calledfrom=="admin")
{
$view='adminview.layouts.app_layout';
$layout='left_side_menu';

}
else if($calledfrom=="tenant")
{
$view= 'tenants.layouts.app_layout';
$layout='left_side_menu_tenant';

}
}
else
{
$view= 'layouts.app_layout';
$layout='left_side_menu_compact';
}

@endphp
@extends($view, ['layout' => $layout])

@section('content')
@php
$pf_collection = collect(json_decode($data['projectedfinancials'], true));
$session_companyid=session('companyid');
@endphp
<div class="content-w investor-profile-view" ng-app="myApp">

    @if(isset($calledfrom) && !empty($calledfrom))
    @if($calledfrom=="admin")
    @include('adminview.shared._top_menu')

    @elseif($calledfrom=="tenant")
    @include('tenants.shared._top_menu_tenant')
    @endif
    @else
    @include('shared._top_menu')
    @endif

    <div aria-labelledby="exampleModalLabel" class="modal fade" id="request_access_modal" role="dialog" tabindex="-1"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ex-modal-request">
                        Request Access Confirmation
                    </h5>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                            ×</span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h6>
                                        This action will send request to the parent of this deal. Do you want to
                                        continue?
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button" id="btnCloseModal">{{trans('duediligenceprocess.modulelist_modal_btncancel_caption')}}</button>
                    <button class="btn btn-primary" type="button" id="btnRequest_Access" onclick="fnGenerateAccessRequest();">{{trans('duediligenceprocess.btn_caption_yes')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content-i">



        <div class="content-box">
            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
                <div class="element-box">
                    <h5 class="form-header">
                        {!!trans('view_deal.help_title')!!}
                    </h5>
                    <div class="form-desc">
                        {!!$helper->GetHelpModifiedText(trans('view_deal.help_content'))!!}
                    </div>
                    <div class="element-box-content example-content">
                        <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                            {{trans('view_deal.help_btn_hide_caption')}}</button>
                    </div>
                </div>
            </div>
            @endif
            <div class="element-wrapper">

                <div class="user-profile">
                    @php
                    $cover_image='';
                    if(isset($data['deal_info']->coverimage) && !empty($data['deal_info']->coverimage))
                    {
                    $cover_image = asset('storage/deal/coverimage/'.$data['deal_info']->coverimage);
                    }
                    else {
                    $cover_image = asset('storage/company/coverimage/'.$data['deal_info']->c_coverimage);
                    }
                    @endphp
                    <div class="up-head-w" style="background-image:url({{ $cover_image }})">
                        {{-- <div class="up-social">
                            <a href="#">
                                <i class="os-icon os-icon-twitter"></i>
                            </a>
                            <a href="#">
                                <i class="os-icon os-icon-facebook"></i>
                            </a>
                        </div> --}}
                        <div class="up-main-info">
                            <h1 class="up-header">
                                {{$data['deal_info']->projectname}}
                            </h1>
                            <h5 class="up-sub-header">
                                {{trans('view_deal.deal_header')}}
                            </h5>

                        </div>
                        <svg class="decor" width="842px" height="219px" viewBox="0 0 842 219" preserveAspectRatio="xMaxYMax meet"
                            version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g transform="translate(-381.000000, -362.000000)" fill="#FFFFFF">
                                <path class="decor-path" d="M1223,362 L1223,581 L381,581 C868.912802,575.666667 1149.57947,502.666667 1223,362 Z"></path>
                            </g>
                        </svg>
                    </div>
                    <div class="up-controls">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="value-pair float-left">
                                    <div class="label">
                                        {{-- Country(S): --}}
                                        {{trans('view_deal.country_label')}}:
                                    </div>
                                    <div class="value">
                                        {{ $data['countries']['current_country']->name }}
                                    </div>
                                </div>

                                {{-- @php
                                $profile_image = asset('imagecache/company_logo/'.$data['deal_info']->profileimage);
                                @endphp
                                <div class="rianta-img float-right text-right">
                                    <img src="{{ $profile_image }}" class="img-responsive" />
                                </div> --}}
                                <div class="rianta-img float-right text-right">
                                    @if( (isset($data['deal_info']->profileimage) &&
                                    !empty($data['deal_info']->profileimage) ) &&
                                    File::exists(public_path('storage/deal/profileimage/'.$data['deal_info']->profileimage)))
                                    <img alt="{{$data['deal_info']->projectname}}" src="{{ asset('imagecache/company_logo/'.$data['deal_info']->profileimage) }}"
                                        class="img-responsive">
                                    @else
                                    <img alt="{{$data['deal_info']->projectname}}" src="{{ Avatar::create($data['deal_info']->projectname)->toBase64() }}"
                                        style="height:61px;" class="img-responsive">
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="up-contents">
                        <h5 class="element-header">
                            {{trans('view_deal.deal_caption')}}
                        </h5>
                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->projectname) && !empty($data['deal_info']->projectname))
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('view_deal.project_name_label')}}
                                </div>
                                <h5>{{$data['deal_info']->projectname}}</h5>
                            </div>
                            @endif

                            @if(isset($data['deal_info']->currencyid) && !empty($data['deal_info']->currencyid))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.currency_name_label')}}
                                </div>
                                <h5>
                                    @foreach($data['currency'] as $currency)
                                    @if($currency->currencyid==$data['deal_info']->currencyid)
                                    {{$currency->currencyname}}
                                    @endif
                                    @endforeach
                                </h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->proposedusesoffunds) &&
                            !empty($data['deal_info']->proposedusesoffunds))
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('view_deal.fund_use_label')}}
                                </div>
                                <h5>{{$data['deal_info']->proposedusesoffunds}}</h5>
                            </div>
                            @endif
                            @if(isset($data['deal_info']->investmentstage) &&
                            !empty($data['deal_info']->investmentstage))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.investment_stage_label')}}
                                </div>
                                <h5>
                                    @if(isset($data['investmentstages']))
                                    @foreach($data['investmentstages'] as $istage)
                                    @if($data['deal_info']->investmentstage == $istage->stagename)
                                    {{ $istage->stagename }}
                                    @endif
                                    @endforeach
                                    @endif


                                </h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->monthlyoperatingcost) &&
                            !empty($data['deal_info']->monthlyoperatingcost))
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('view_deal.monthly_operating_costs_label')}}
                                </div>
                                <h5>{{$data['deal_info']->symbol.number_format($data['deal_info']->monthlyoperatingcost,
                                    2, '.', ',')}}</h5>
                            </div>
                            @endif
                            @if(isset($data['deal_info']->totalinvestmentrequired) &&
                            !empty($data['deal_info']->totalinvestmentrequired))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.tot_invest_reqd_label')}}
                                </div>
                                <h5>{{$data['deal_info']->symbol.number_format($data['deal_info']->totalinvestmentrequired,
                                    2, '.', ',')}}</h5>
                            </div>
                            @endif
                        </div>
                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->premoneyvaluation) &&
                            !empty($data['deal_info']->premoneyvaluation))
                            <div class="col-sm-5 ">
                                <div class="label">
                                    {{trans('view_deal.pre_mon_valua_label')}}
                                </div>
                                <h5>{{$data['deal_info']->symbol.number_format($data['deal_info']->premoneyvaluation,
                                    2, '.', ',') }}</h5>

                            </div>
                            @endif

                            @if(isset($data['deal_info']->projectedirr) && !empty($data['deal_info']->projectedirr))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.projected_irr_label')}}
                                </div>
                                <h5>{{$data['deal_info']->symbol.number_format($data['deal_info']->projectedirr, 2,
                                    '.', ',')}}</h5>
                            </div>
                            @endif

                        </div>

                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->purposeofinvestment) &&
                            !empty($data['deal_info']->purposeofinvestment))
                            <div class="col-sm-5 ">
                                <div class="label">
                                    {{trans('view_deal.purp_req_invest_label')}}
                                </div>
                                <h5>
                                    @if(isset($data['purposeofrequestedinvestment']))
                                    @foreach($data['purposeofrequestedinvestment'] as $pori)
                                    @if($data['deal_info']->purposeofinvestment == $pori->fund)
                                    {{ $pori->fund }}
                                    @endif
                                    @endforeach
                                    @endif


                                </h5>

                            </div>
                            @endif

                            @if(isset($data['deal_info']->investmentstructure) &&
                            !empty($data['deal_info']->investmentstructure))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.invest_struct_label')}}
                                </div>
                                <h5>
                                    @if(isset($data['investmentstructures']))
                                    @foreach($data['investmentstructures'] as $istruct)
                                    @if($data['deal_info']->investmentstructure == $istruct->name)
                                    {{ $istruct->name }}
                                    @endif
                                    @endforeach
                                    @endif

                                </h5>
                            </div>
                            @endif

                        </div>

                        <div class="row invst-pfl">
                            @if(filled($data['sdg_selected']))
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('view_deal.sdg_label')}}
                                </div>

                                @foreach($data['sdg_master'] as $sdgmaster)
                                <?php $selected1="";?>
                                @foreach($data['sdg_selected'] as $selected)
                                @if($selected->sdgid == $sdgmaster->sdgid)
                                <h5>{{$sdgmaster->sdg}}</h5>
                                @break
                                @endif

                                @endforeach
                                @endforeach
                            </div>
                            @endif

                            @if(isset($data['deal_info']->loanterm_year) && !empty($data['deal_info']->loanterm_year))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.loan_terms_fits_best_label')}}
                                </div>
                                <h5>
                                    {{trans('view_deal.loan_terms_year').': '.$data['deal_info']->loanterm_year.'
                                    year'}}
                                </h5>
                                <h5>
                                    {{trans('view_deal.loan_terms_month').': '.$data['deal_info']->loanterm_month.'
                                    month'}}
                                </h5>

                            </div>
                            @endif

                        </div>


                    </div>

                    @if((isset($data['deal_info']->existinginvestors) && !empty($data['deal_info']->existinginvestors)
                    ) ||
                    (isset($data['deal_info']->additionaldetails) && !empty($data['deal_info']->additionaldetails) ))
                    <div class="up-contents investment-pdtop">
                        <h5 class="element-header">
                            {{trans('view_deal.other_financial_caption')}}
                        </h5>
                        <div class="row invst-pfl">
                            @if(isset($data['deal_info']->existinginvestors) &&
                            !empty($data['deal_info']->existinginvestors))
                            <div class="col-sm-5">
                                <div class="label">
                                    {{trans('view_deal.exist_prev_label')}}
                                </div>
                                <h5>{{$data['deal_info']->existinginvestors }}</h5>
                            </div>

                            @endif
                            @if(isset($data['deal_info']->additionaldetails) &&
                            !empty($data['deal_info']->additionaldetails))
                            <div class="col-sm-7">
                                <div class="label">
                                    {{trans('view_deal.additio_detail_label')}}
                                </div>
                                <h5>{{$data['deal_info']->additionaldetails}}</h5>
                            </div>
                            @endif
                        </div>
                    </div>

                    @endif

                    @if(filled($pf_collection))
                    <div class="up-contents investment-pdtop">
                        <h5 class="element-header">
                            {{trans('view_deal.proj_finan_caption')}}
                        </h5>

                        @for ($i = 2; $i < 6; $i++) @php $pf_row=$pf_collection->where('year_number', $i)->first();

                            @endphp
                            <div class="enterprise-sub-hd">
                                <strong>{{trans('view_deal.year_label')}} {{ $i }}</strong>
                            </div>

                            <div class="row invst-pfl">
                                <div class="col-sm-5">
                                    <div class="label">
                                        {{trans('view_deal.tot_reven_label')}}
                                    </div>
                                    <h5>{{$data['deal_info']->symbol.number_format($pf_row['totalrevenue'], 2, '.',
                                        ',')}} </h5>
                                </div>
                                <div class="col-sm-7">
                                    <div class="label">
                                        {{trans('view_deal.tot_operating_cost_label')}}
                                    </div>
                                    <h5>{{$data['deal_info']->symbol.number_format($pf_row['totalannualoperatingcost'],
                                        2, '.', ',')}} </h5>
                                </div>
                            </div>

                            <div class="row invst-pfl">
                                <div class="col-sm-5">
                                    <div class="label">
                                        {{trans('view_deal.ebitda_label')}}
                                    </div>
                                    <h5>{{$data['deal_info']->symbol.number_format($pf_row['ebitda'], 2, '.', ',')}}
                                    </h5>
                                </div>
                                <div class="col-sm-7">
                                    <div class="label">
                                        {{trans('view_deal.net_cash_label')}}
                                    </div>
                                    <h5>{{$data['deal_info']->symbol.number_format($pf_row['netcash'], 2, '.', ',')}}
                                    </h5>
                                </div>
                            </div>

                            @endfor
                    </div>

                    @endif


                </div>
            </div>
            @if(!isset($calledfrom) || empty($calledfrom))

            @if(($data['puplic_doc_count']>0 && $who_is_viewing=="Other") || ($data['private_doc_count']>0 &&
            $who_is_viewing=="Owner"))
            <div class="element-wrapper margin-top">
                <!--
                        START - documents table
                        -->
                <h5 class="element-header">
                    {{trans('my_deal.documents_title')}}
                </h5>

                @if($data['puplic_doc_count']>0 )
                <div class="element-box table-rit-section">
                    <h5 class="form-header">
                        {{trans('my_deal.documents_public_caption')}}
                    </h5>
                    <div class="form-desc">
                        {{trans('my_deal.documents_public_text')}}
                    </div>
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">

                            </div>
                            <div class="col-sm-12 col-lg-8 filter-moble">
                                <form class="form-inline justify-content-sm-end">
                                    <!-- <input id="public_document" onkeyup="publicDocuments()" class="form-control form-control-sm rounded bright" placeholder="Search" type="text"> -->
                                    <input ng-model='public_search.documentname' class="form-control form-control-sm rounded bright"
                                        placeholder="{{trans('my_deal.input_search_placeholder')}}" type="text">
                                    <select ng-model='sortByPublic' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('my_deal.select_sort_by')}}
                                        </option>
                                        <option value="documentname">{{trans('my_deal.select_file_name')}} </option>
                                        <option value="extention">{{trans('my_deal.select_type')}}</option>
                                        <option value="updated">{{trans('my_deal.select_date')}}</option>
                                    </select>
                                    <select ng-model='filterByExt' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('my_deal.select_filter')}}
                                        </option>
                                        <option value="txt">
                                            {{trans('my_deal.select_txt')}}
                                        </option>
                                        <option value="jpg">
                                            {{trans('my_deal.select_jpg')}}
                                        </option>
                                        <option value="png">
                                            {{trans('my_deal.select_png')}}
                                        </option>
                                        <option value="xls">
                                            {{trans('my_deal.select_xls')}}
                                        </option>
                                        <option value="xlsx">
                                            {{trans('my_deal.select_xlsx')}}
                                        </option>
                                        <option value="pdf">
                                            {{trans('my_deal.select_pdf')}}
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-heading-spce">
                        <form action="" method="POST">
                            {{CSRF_FIELD()}}

                            <table class="table table-lightborder" ng-controller="deal_document">
                                <input ng-model="dealid" type="hidden" value="{{$data['deal_info']->dealid}}">
                                <thead>
                                    <tr>
                                        <th class="name">
                                            {{trans('my_deal.table_filename')}}
                                        </th>
                                        <th class="type">
                                            {{trans('my_deal.table_filetype')}}
                                        </th>
                                        <th class="format">
                                            {{trans('my_deal.table_fileformat')}}
                                        </th>
                                        <th class="date">
                                            {{trans('my_deal.table_filedate')}}
                                        </th>
                                        <th class="action">
                                            {{trans('my_deal.table_fileaction')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="public_document_table">
                                    <tr ng-hide="!publicdoc.length" ng-repeat="public in publicdoc | filter:public_search | filter:filterByExt | orderBy: sortByPublic">
                                        @verbatim
                                        <td>{{ ::public.documentname }}</td>
                                        <td>{{ ::public.type }}</td>
                                        <td>{{ ::public.extention }}</td>
                                        <td>{{ ::public.updated }}</td>
                                        @endverbatim
                                        <td>
                                            <a href="/storage/deal/documents/public/@{{ public.documenttitle }}" target="_blank">
                                                <i class="os-icon os-icon-signs-11"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr ng-hide="publicdoc.length > 0">
                                        <td colspan="5">{{trans('eso_company_profile_view.documents_public_not_found')}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

                @endif

                @if($who_is_viewing=="Owner" && $data['private_doc_count']>0)
                <div class="element-box table-rit-section">
                    <h5 class="form-header">
                        {{trans('my_deal.documents_private_caption')}}
                    </h5>
                    <div class="form-desc">
                        {{trans('my_deal.documents_public_text')}}
                    </div>
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">

                                {{-- <a class="btn btn-sm btn-danger" href="#">Delete</a> --}}

                            </div>
                            <div class="col-sm-12 col-lg-8 filter-moble">
                                <form class="form-inline justify-content-sm-end">
                                    <input ng-model='private_search.documentname' class="form-control form-control-sm rounded bright"
                                        placeholder="Search" type="text">
                                    <select ng-model='sortByPrivate' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('my_deal.select_sort_by')}}
                                        </option>
                                        <option value="documentname">{{trans('my_deal.select_file_name')}} </option>
                                        <option value="extention">{{trans('my_deal.select_type')}}</option>
                                        <option value="updated">{{trans('my_deal.select_date')}}</option>
                                    </select>
                                    <select ng-model='privateFilterByExt' class="form-control form-control-sm rounded bright">
                                        <option selected="selected" value="">
                                            {{trans('my_deal.select_filter')}}
                                        </option>
                                        <option value="txt">
                                            {{trans('my_deal.select_txt')}}
                                        </option>
                                        <option value="jpg">
                                            {{trans('my_deal.select_jpg')}}
                                        </option>
                                        <option value="png">
                                            {{trans('my_deal.select_png')}}
                                        </option>
                                        <option value="xls">
                                            {{trans('my_deal.select_xls')}}
                                        </option>
                                        <option value="xlsx">
                                            {{trans('my_deal.select_xlsx')}}
                                        </option>
                                        <option value="pdf">
                                            {{trans('my_deal.select_pdf')}}
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive table-responsive-heading-spce">

                        <table class="table table-lightborder" ng-controller="deal_document">
                            <input ng-model="dealid" type="hidden" value="{{$data['deal_info']->dealid}}">
                            <thead>
                                <tr>
                                    <th class="name">
                                        {{trans('my_deal.table_filename')}}
                                    </th>
                                    <th class="type">
                                        {{trans('my_deal.table_filetype')}}
                                    </th>
                                    <th class="format">
                                        {{trans('my_deal.table_fileformat')}}
                                    </th>
                                    <th class="date">
                                        {{trans('my_deal.table_filedate')}}
                                    </th>
                                    <th class="action">
                                        {{trans('my_deal.table_fileaction')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="private_document_table">
                                <tr ng-hide="!privatedoc.length" ng-repeat="private in privatedoc | filter:private_search | filter:privateFilterByExt | orderBy: sortByPrivate">
                                    <td>@{{ private.documentname }}</td>
                                    <td>@{{ private.type }}</td>
                                    <td>@{{ private.extention }}</td>
                                    <td>@{{ private.updated }}</td>
                                    <td>
                                        <a href="/storage/deal/documents/private/@{{ private.documenttitle }}" target="_blank">
                                            <i class="os-icon os-icon-signs-11"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr ng-hide="privatedoc.length > 0">
                                    <td colspan="5">{{trans('eso_company_profile_view.documents_private_not_found')}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                @endif

            </div>

            @endif

            @endif


            <!--
                END - documents table 
                -->


            <!-- Start Due Diligence Area -->
            @if(isset($data['duediligence_parents']) && !empty($data['duediligence_parents']))
            <div class="element-wrapper margin-top">
                <h6 class="element-header">
                    Due Diligence
                </h6>

                <div class="element-box">
                    <div class="controls-above-table">

                    </div>
                    <div class="table-responsive table-responsive-heading-spce">
                        <table class="table table-lightborder">
                            <thead>
                                <tr>
                                    <th class="name">
                                        Company
                                    </th>
                                    <th class="name">
                                        Public Documents
                                    </th>
                                    <th class="type">
                                        Type
                                    </th>
                                    <th class="format">
                                        Started
                                    </th>
                                    <th class="format">
                                        Completed
                                    </th>
                                    @if(!isset($calledfrom) || empty($calledfrom))
                                    <th class="action text-center">
                                        Action
                                    </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['duediligence_parents'] as $am)
                                <tr>
                                    <td>
                                        <div class="user-with-avatar company-name-img">

                                            <a href="/company/profile/view?{{'company='.$am->companyid .'&companytype='.$am->companytype.'&calledfrom='.$calledfrom}}">
                                                @if (isset($am->profileimage) && !empty($am->profileimage))
                                                <img alt="" src="/storage/company/profileimage/{{$am->profileimage}}"
                                                    style="width: 50px;" />

                                                @else
                                                <img alt="" src="{{ Avatar::create($am->company)->toBase64() }}" style="width: 50px;" />
                                                @endif
                                            </a>
                                            <span class="d-none d-xl-inline-block">{{$am->company}}</span>
                                        </div>
                                    </td>
                                    <td>

                                        <div class="cell-document-list">
                                            @if(isset($data['pdeals_Public_Documents']) &&
                                            filled($data['pdeals_Public_Documents']))
                                            @foreach ($data['pdeals_Public_Documents'] as $pd)
                                            @if($pd->pipelinedealid==$am->pipelinedealid)
                                            <a href="/storage/pipelinedeal/documents/public/{{ $pd->documenttitle }}"
                                                target="_blank">
                                                {{$pd->documentname}}
                                            </a>
                                            <br />
                                            @endif
                                            @endforeach

                                            @endif

                                            @if(count($data['pdeals_Public_Documents'])<=0) No public docs found.
                                                @endif </div> </td> <td>
                                                {{$am->companytype}}
                                    </td>
                                    <td>
                                        {{date('M d,Y',strtotime($am->startdate)) }}
                                    </td>
                                    <td>
                                        @if(!empty($am->completeddate) && isset($am->completeddate))
                                        {{date('M d,Y',strtotime($am->completeddate)) }}
                                        @endif

                                    </td>
                                    @if(!isset($calledfrom) || empty($calledfrom))
                                    <td class="text-center">
                                        <div class="btn-group mr-1 mb-1">
                                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                                                data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('dd_dashboard.dd_btn_action')}}</button>
                                            <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu"
                                                x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                                <a class="dropdown-item" href="/company/profile/view?{{'company='.$am->companyid .'&companytype='.$am->companytype}}">{{trans('dd_dashboard.dd_view-profile')}}</a>
                                                @if($am->CanRequest=='Yes' &&
                                                $data['deal_info']->deal_active=='active')
                                                <a class="dropdown-item" href="#" onclick="fnOpenAccessConfirmationModal('{{$am->pipelinedealid}}');"
                                                    data-placement="top" data-toggle="tooltip" data-original-title="{{$helper->GetHelpModifiedText(trans('view_deal.help_request_access_text'))}}">Request
                                                    Access</a>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>

                                @endforeach

                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
            @endif
            <!-- End Of Due Diligence Area -->


            <!--
              START - Color Scheme Toggler
            -->
            <div class="floated-colors-btn second-floated-btn">
                <div class="os-toggler-w">
                    <div class="os-toggler-i">
                        <div class="os-toggler-pill"></div>
                    </div>
                </div>
                <span>Dark </span>
                <span>Colors</span>
            </div>
            <!--------------------
              END - Color Scheme Toggler
              -------------------->
            <!--------------------
              START - Chat Popup Box
              -------------------->
            <div class="floated-chat-btn">
                <i class="os-icon os-icon-mail-07"></i>
                <span>Demo Chat</span>
            </div>
            <div class="floated-chat-w">
                <div class="floated-chat-i">
                    <div class="chat-close">
                        <i class="os-icon os-icon-close"></i>
                    </div>
                    <div class="chat-head">
                        <div class="user-w with-status status-green">
                            <div class="user-avatar-w">
                                <div class="user-avatar">
                                    {{-- <img alt="" src="img/avatar1.jpg"> --}}
                                </div>
                            </div>
                            <div class="user-name">
                                <h6 class="user-title">
                                    John Mayers
                                </h6>
                                <div class="user-role">
                                    Account Manager
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-messages">
                        <div class="message">
                            <div class="message-content">
                                Hi, how can I help you?
                            </div>
                        </div>
                        <div class="date-break">
                            Mon 10:20am
                        </div>
                        <div class="message">
                            <div class="message-content">
                                Hi, my name is Mike, I will be happy to assist you
                            </div>
                        </div>
                        <div class="message self">
                            <div class="message-content">
                                Hi, I tried ordering this product and it keeps showing me error code.
                            </div>
                        </div>
                    </div>
                    <div class="chat-controls">
                        <input class="message-input" placeholder="Type your message here..." type="text">
                        <div class="chat-extra">
                            <a href="#">
                                <span class="extra-tooltip">Attach Document</span>
                                <i class="os-icon os-icon-documents-07"></i>
                            </a>
                            <a href="#">
                                <span class="extra-tooltip">Insert Photo</span>
                                <i class="os-icon os-icon-others-29"></i>
                            </a>
                            <a href="#">
                                <span class="extra-tooltip">Upload Video</span>
                                <i class="os-icon os-icon-ui-51"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!--------------------
              END - Chat Popup Box
              -------------------->
        </div>
        <!--------------------
            START - Sidebar
            -------------------->
        <div class="content-panel">
            <div class="content-panel-close">
                <i class="os-icon os-icon-close"></i>
            </div>
            {{-- <div class="element-wrapper">

            </div> --}}
            <!--------------------
               start - right section video
              -------------------->
            @if(!isset($calledfrom) || empty($calledfrom))
            @include('shared._deal_owner',compact('data'))
            @endif

            @if($data['deal_info']->video != null)
            <div class="video-rit">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('view_deal.video_label')}}
                    </h6>
                    <div class="element-box">
                        <div class="el-chart-w">
                            <a class="video-play" data-target="#onboardingWideFeaturesModal" data-toggle="modal">
                                <img src="{{ asset('img/video-test.jpg')}}" alt="Play Video" class="img-responsive" />
                            </a>
                            <div aria-hidden="true" class="onboarding-modal modal fade animated" id="onboardingWideFeaturesModal"
                                role="dialog" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-centered" role="document">
                                    <div class="modal-content text-center">
                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                            <span class="close-label">Skip Intro</span>
                                            <span class="os-icon os-icon-close"></span>
                                        </button>
                                        <div class="onboarding-side-by-side">
                                            @php
                                            $video_path = false;
                                            if($data['deal_info']->video != null) {
                                            $video_path = asset('storage/deal/video/'.$data['deal_info']->video);
                                            }
                                            @endphp
                                            <div class="onboarding-content with-full">
                                                @if($video_path)
                                                <iframe width="100%" height="400" src="{{asset($video_path)}}"
                                                    frameborder="0"></iframe>
                                                @else
                                                {{ "No Video Found, Please Upload Video !!!" }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            <!--------------------
              END - right section video
              -------------------->

        </div>
        <!--------------------
            END - Sidebar
            -------------------->
    </div>
</div>
<input type="hidden" id="dealid_hidden" value='{{$data['deal_info']->dealid}}' />
<input type="hidden" id="pipelinedealid" value='' />

@section('scripts')

<script>
    function fnOpenAccessConfirmationModal(pdid) {
        $('#pipelinedealid').val(pdid);
        $('#request_access_modal').modal('show');
    }

    function fnGenerateAccessRequest() {
        debugger;
        var dealid = $('#dealid_hidden').val();
        var pipelinedealid = $('#pipelinedealid').val();

        var route = "/generate-access-request?pipelinedealid=" + pipelinedealid + "&dealid=" + dealid;
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {

                if (data.message == 'Success') {
                    // $('#remove_company_modal').modal('hide'); 
                    $('#request_access_modal').modal('hide');
                    window.location.reload(true);
                } else {}
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });

    }

    function privateDocuments() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("private_document");
        table = document.getElementById("private_document_table");
        filter = input.value.toUpperCase();

        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function publicDocuments() {
        // Declare variables
        var input, filter, table, tr, td, i;
        input = document.getElementById("public_document");
        table = document.getElementById("public_document_table");
        filter = input.value.toUpperCase();

        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }


    function fnDeleteDocuments(mode) {
        debugger;
        var cnt = 0;
        if (mode == 'public') {
            $('#public_document_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });
        } else { //private case
            $('#private_document_table input:checkbox:checked').each(function () {
                debugger;
                var id = $(this).attr('value');
                cnt = cnt + 1;
            });

        }

        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            if (mode == 'public') {
                $('#public_document_delete_modal').modal('show');
            } else //Private Case....
            {
                $('#private_document_delete_modal').modal('show');
            }
        }
    }

    function fnDeleteSelectedDocuments(mode) {
        debugger;
        var documentlist = [];
        var cnt = 0;
        if (mode == 'public') {
            $('#public_document_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        } else { //private case
            $('#private_document_table input:checkbox:checked').each(function () {
                var id = $(this).attr('value');
                documentlist.push({
                    documentid: id
                });
                cnt = cnt + 1;
            });
        }


        if (cnt <= 0) {
            return;
        }

        if (cnt > 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formdata = new FormData();

            formdata.append("documentlist", JSON.stringify(documentlist));
            formdata.append("type", mode);
            formdata.append("_token", '{{csrf_token()}}');

            $.ajax({
                url: '/deal-delete-documents',
                type: "POST",
                contentType: false,
                processData: false,
                data: formdata,
                cache: false,
                timeout: 100000,
                success: function (data) {
                    if (mode == 'public') {
                        var $messageDiv = $('#del-message-box');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#public_document_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    } else { //case of private...
                        var $messageDiv = $('#del-message-box-private');
                        $messageDiv.show();
                        setTimeout(function () {
                            $messageDiv.hide();
                            $('#private_document_delete_modal').modal('hide');
                            window.location.reload(true);
                        }, 3000);
                    }


                },
                error: function (err, result) {
                    debugger;
                    alert("Error" + err.responseText);
                }
            });

        }
    }


    // function currencychange(currency)
    // {
    //     //alert(currency);
    //     $.get('/getsymbol?currency='+currency,function(data){
    //        $('.currency-symb').html(data); 
    //     });
    // }

    // $(document).ready(function() {
    // var currency=$('[name="currency"]').val();
    // $.get('/getsymbol?currency='+currency,function(data){
    //            $('.currency-symb').html(data); 
    //         });
    //        });

</script>





@endsection

@endsection
