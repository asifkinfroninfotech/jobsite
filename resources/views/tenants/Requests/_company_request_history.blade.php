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
                        Company Name
                    </th>
                    <th>
                        Type
                    </th>
                    <th>
                        User Email
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

                @foreach($company as $company1)

                <tr id='{{$company1->companyid}}'>
                    <td>
                        @if($company1->status=='Verified')
                        <a href="/company/profile/view?{{'company='.$company1->companyid .'&companytype='.$company1->companytype.'&calledfrom=tenant'}}">
                            @if((isset($company1->profileimage) && !empty($company1->profileimage) ) &&
                            File::exists(public_path('/storage/company/profileimage/'.$company1->profileimage)))
                            <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" style="width: 50px;" />

                            @else
                            <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" style="width: 50px;" />
                            @endif
                        </a>
                        @else
                        @if((isset($company1->profileimage) && !empty($company1->profileimage) ) &&
                        File::exists(public_path('/storage/company/profileimage/'.$company1->profileimage)))
                        <img alt="" src="/storage/company/profileimage/{{$company1->profileimage}}" style="width: 50px;" />
                        @else
                        <img alt="" src="{{ Avatar::create($company1->companyname)->toBase64() }}" style="width: 50px;" />
                        @endif
                        @endif
                        <span>{{$company1->companyname}}</span>
                    </td>
                    <td>
                        {{$company1->companytype}}
                    </td>
                    <td>
                        {{$company1->email}}
                    </td>
                    <td class="text-center">
                        @if($company1->status=='Verified')
                        <a class="btn btn-success btn-sm" href="#" data-original-title="" title="">{{$company1->status}}</a>
                        @else
                        <a class="btn btn-primary btn-sm" href="#" data-original-title="" title="">{{$company1->status}}</a>
                        @endif

                    </td>
                    <td class="text-center">
                        {{date('M d,Y',strtotime($company1->datetime)) }}
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
