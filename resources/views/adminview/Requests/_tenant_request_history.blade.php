@php
$helper=\App\Helpers\AppHelper::instance();
$loggedinuserid=Session('userid');
$UserProfileImagePath= \App\Helpers\AppGlobal::fnGet_UserProfileImagePath();
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp

<div class="element-box-tp">
    <div class="table-responsive">
        <table class="table table-padded network-rows">
            <thead>
                <tr>
                    <th>
                        Tenant
                    </th>
                    <th>
                        Company
                    </th>
                    <th>
                        Email
                    </th>
                    <th class="text-center">
                        Status
                    </th>
                    <th class="text-center">
                        Date (Verified/Declined)
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($tenants as $tenant)

                <tr id='{{$tenant->tenantid}}'>
                    <td>
                        <div class="user-with-avatar">
                            @if($tenant->status=='Verified')
                            <a href="/tenant/profile/view?tenid={{$tenant->tenantid.'&calledfrom=admin'}}" target="_blank">
                                @if( (isset($tenant->minilogoimage) && !empty($tenant->minilogoimage) ) &&
                                File::exists(public_path('/storage/tenant/minilogoimage/'.$tenant->minilogoimage))==true)
                                <img alt="" src="/storage/tenant/minilogoimage/{{$tenant->minilogoimage}}" />
                                @else
                                <img alt="" src="{{ Avatar::create(ucfirst($tenant->name))->toBase64() }}" />
                                @endif
                            </a>
                            @else
                            @if( (isset($tenant->minilogoimage) && !empty($tenant->minilogoimage) ) &&
                            File::exists(public_path('/storage/tenant/minilogoimage/'.$tenant->minilogoimage))==true)
                            <img alt="" src="/storage/tenant/minilogoimage/{{$tenant->minilogoimage}}" />
                            @else
                            <img alt="" src="{{ Avatar::create(ucfirst($tenant->name))->toBase64() }}" />
                            @endif
                            @endif

                            <span>{{$tenant->name}}</span>
                        </div>

                    </td>
                    <td>
                        {{$tenant->companytype}}
                    </td>
                    <td>
                        {{$tenant->email}}
                    </td>
                    <td class="text-center">
                        @if($tenant->status=='Verified')
                        <a class="btn btn-success btn-sm" href="#" data-original-title="" title="">{{$tenant->status}}</a>
                        @else
                        <a class="btn btn-primary btn-sm" href="#" data-original-title="" title="">{{$tenant->status}}</a>
                        @endif

                    </td>
                    <td class="text-center">
                        {{date('M d,Y',strtotime($tenant->datetime)) }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
