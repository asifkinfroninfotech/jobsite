@php
$CompanyProfileImagePath= \App\Helpers\AppGlobal::fnGet_CompanyProfileImagePath();
@endphp
<a><div class='data-format'>
   @if( (isset($companylist->profileimage) && !empty($companylist->profileimage) ) && File::exists(public_path($CompanyProfileImagePath.$companylist->profileimage)))     

                                                              
                                                              <img alt="" src="{{$CompanyProfileImagePath . $companylist->profileimage}}">
                                                              
                                                       @else
                                                              <img alt="" src="{{ Avatar::create(ucfirst($companylist->name))->toBase64() }}">  
                                                        @endif      

    
</div>
<div class='data'>
<h1>{{$companylist->name}}</h1><p>{{$companylist->statusmessage}}</p>

</div>


</a>
