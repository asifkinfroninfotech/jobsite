@php
$helper=\App\Helpers\AppHelper::instance();
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();

@endphp



<div class="element-box">

    <div class="table-responsive">
        <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
            <thead>
                <tr>
                    <th class="image">Tenant</th>
                    <th class="image">{{trans('adminview.deal_table_company')}}</th>
                    <th>{{trans('adminview.deal_table_stage')}}</th>
                    {{-- <th>{{trans('adminview.deal_table_country')}}</th> --}}
                    {{-- <th>{{trans('adminview.deal_table_investmentstructure')}}</th> --}}
                    <th>{{trans('adminview.deal_table_totalinvestmentreqd')}}</th>
                    <th>{{trans('adminview.deal_table_purposeofinvestment')}}</th>
                    <th>{{trans('adminview.deal_table_projectname')}}</th>
                    <th>{{trans('adminview.deal_table_action')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th class="image">Tenant</th>
                    <th class="image">{{trans('adminview.deal_table_company')}}</th>

                    <th>{{trans('adminview.deal_table_stage')}}</th>
                    {{-- <th>{{trans('adminview.deal_table_country')}}</th> --}}
                    {{-- <th>{{trans('adminview.deal_table_investmentstructure')}}</th> --}}
                    <th>{{trans('adminview.deal_table_totalinvestmentreqd')}}</th>
                    <th>{{trans('adminview.deal_table_purposeofinvestment')}}</th>
                    <th>{{trans('adminview.deal_table_projectname')}}</th>
                    <th>{{trans('adminview.deal_table_action')}}</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($datas as $data)

                <tr>
                    <td>
                        <div class="user-with-avatar">
                            <a href="/tenant/profile/view?tenid={{$data->tenantid.'&calledfrom=admin'}}" target="_blank">
                                @if( (isset($data->tenantminilogo) && !empty($data->tenantminilogo) ) &&
                                File::exists(public_path('/storage/tenant/minilogoimage/'.$data->tenantminilogo)))
                                <img alt="" src="/storage/tenant/minilogoimage/{{$data->tenantminilogo}}" />
                                @else
                                <img alt="" src="{{ Avatar::create(ucfirst($data->tenantcompany))->toBase64() }}" />
                                @endif
                            </a>
                            <span>{{$data->tenantcompany}}</span>
                        </div>

                    </td>

                    {{-- <td><span>{{$data->company}}</span></td> --}}
                    <td>
                        <div class="user-with-avatar">
                            <a href="/company/profile/view?{{'company='.$data->companyid .'&companytype='.$data->companytype}}&calledfrom=admin"
                                target="_blank">
                                @if( (isset($data->companyprofileimage) && !empty($data->companyprofileimage) ) &&
                                File::exists(public_path('/storage/company/profileimage/'.$data->companyprofileimage)))
                                <img alt="" src="/storage/company/profileimage/{{$data->companyprofileimage}}" />

                                @else
                                <img alt="" src="{{ Avatar::create(ucfirst($data->company))->toBase64() }}" />
                                @endif
                            </a>
                            <span>{{$data->company}}</span>
                        </div>

                    </td>

                    <td><span>{{$data->investmentstage}}</span></td>
                    {{-- <td><span>{{$data->country}}</span></td> --}}
                    {{-- <td><span>{{$data->investmentstructure}}</span></td> --}}



                    <td><span>{{$data->symbol.$helper->nice_number($data->totalinvestmentrequired)}}</span></td>
                    <td><span>{{$data->purposeofinvestment}}</span></td>
                    <td><span>{{$data->projectname}}</span></td>




                    <td>




                        <div class="btn-group mr-1 mb-1 show">

                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.deal_action_btn_label')}}</button>
                            <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="/deals/view-deal?dealid={{$data->dealid}}&calledfrom=admin">{{trans('adminview.deal_view_btn_label')}}</a>
                                <a class="dropdown-item" href="/gotoadmin?companyid={{$data->companyid}}">{{trans('adminview.company_transfer_btn_label')}}</a></div>
                        </div>



                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $datas->links('adminview.dealtabledata.deal_pagination') }}