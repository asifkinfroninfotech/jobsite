<div class="element-box">




    <div class="table-responsive">
        <table id="datatablecompany" width="100%" class="table table-striped table-lightfont">
            <thead>
                <tr>
                    <th>{{trans('adminview.company_table_tenant_id')}}</th>
                    <th>{{trans('adminview.company_table_company_name')}}</th>
                    <th>{{trans('adminview.company_table_company_type')}}</th>
                    <th>{{trans('adminview.company_table_sector')}}</th>
                    <th>Status</th>
                    <th>{{trans('adminview.company_table_action')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>{{trans('adminview.company_table_tenant_id')}}</th>
                    <th>{{trans('adminview.company_table_company_name')}}</th>
                    <th>{{trans('adminview.company_table_company_type')}}</th>
                    <th>{{trans('adminview.company_table_sector')}}</th>
                    <th>Status</th>
                    <th>{{trans('adminview.company_table_action')}}</th>
                </tr>
            </tfoot>
            <tbody id="getcompanydata">



                @foreach($company as $company1)
                <tr>


                    <td>
                        <div class="user-with-avatar  ">
                            <a href="/tenant/profile/view?tenid={{$company1->tenantid.'&calledfrom=admin'}}" target="_blank">
                                @if( (isset($company1->tenantminilogo) && !empty($company1->tenantminilogo) ) &&
                                File::exists(public_path('/storage/tenant/minilogoimage/'.$company1->tenantminilogo)))
                                <img alt="" src="/storage/tenant/minilogoimage/{{$company1->tenantminilogo}}" />
                                @else
                                <img alt="" src="{{ Avatar::create(ucfirst($company1->tenantcompany))->toBase64() }}" />
                                @endif
                            </a>
                            <span>{{$company1->tenantcompany}}</span>
                        </div>

                    </td>




                    <td>
                        <div class="user-with-avatar  ">
                            <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype.'&calledfrom=admin'}}"
                                target="_blank">
                                @if( (isset($company1->profileimage) && !empty($company1->profileimage) ) &&
                                File::exists(public_path('/storage/company/profileimage/'.$company1->profileimage)))
                                <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" />


                                @else
                                <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" />
                                @endif
                            </a>
                            <span>{{$company1->companyname}}</span>
                        </div>

                    </td>
                    <td><span>{{$company1->companytype}}</span></td>
                    <td>
                        <span>{{$company1->sectors}}
                            @if($company1->scount>1)
                            <span class="smaller lighter">more</span>
                            @endif
                        </span>
                    </td>
                    <td>{{$company1->activestatus}}</td>
                    <td>

                        <!--                      <a class="btn btn-success btn-sm" href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype}}"  target=”_blank”>View</a>-->


                        <div class="btn-group mr-1 mb-1 show">

                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('adminview.company_action_btn_label')}}</button>
                            <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="/company/profile/view?company={{$company1->companyid}}&companytype={{$company1->companytype}}&calledfrom=admin">{{trans('adminview.company_view_btn_label')}}</a>
                                @if($company1->activestatus=="Active")
                                <a class="dropdown-item" onclick="companyinactive('{{$company1->companyid}}');" href="#">Make
                                    Inactive</a>
                                @elseif($company1->activestatus=="In-Active")
                                <a class="dropdown-item" onclick="companyactive('{{$company1->companyid}}');" href="#">Make
                                    Active</a>
                                @endif
                                <a class="dropdown-item" href="/gotoadmin?companyid={{$company1->companyid}}">{{trans('adminview.company_transfer_btn_label')}}</a></div>



                        </div>



                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

{{ $company->links('adminview.companytabledata.company_pagination') }}