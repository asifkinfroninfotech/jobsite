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
$view= 'tenants.layouts.app_layout';
$layout='left_side_menu_tenant';
}



@endphp

@extends($view, ['layout' => $layout])

@section('content')

<div class="content-w investor-profile-view">
  @if(isset($calledfrom) && !empty($calledfrom))
  @if($calledfrom=="admin")
  @include('adminview.shared._top_menu')

  @elseif($calledfrom=="tenant")
  @include('tenants.shared._top_menu_tenant')
  @endif
  @else
  @include('tenants.shared._top_menu_tenant')
  @endif
  <div class="content-i">
    <div class="content-box">
      @if((session('helpview')!=null))
      <div class="element-wrapper" id='helpform'>
        <div class="element-box">
          <h5 class="form-header">
            {!!trans('tenant_view.help_title')!!}
          </h5>
          <div class="form-desc">


            {!!$helper->GetHelpModifiedText(trans('tenant_view.help_content'))!!}
          </div>
          <div class="element-box-content example-content">
            <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
              {{trans('tenant_view.help_btn_hide_caption')}}</button>
          </div>
        </div>
      </div>
      @endif

      <div class="row">
        <div class="col-sm-12">
          <div class="element-wrapper">
            <h6 class="element-header">
              Tenant
            </h6>
          </div>
        </div>
      </div>

      <!--Tenant Dashboard-->


      <div class="element-wrapper">
        <div class="user-profile">
          @php

          $cover_image="";
          if(isset($tenant[0]->cover))
          {
          $cover_image = asset('storage/tenant/coverimage/'.$tenant[0]->cover);
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
                {{-- Arta Venture --}}
                {{isset($tenant[0]->company)?$tenant[0]->company:''}}
              </h1>
              <!--                    <h5 class="up-sub-header">
                      {{-- Investor --}}
                      {{trans('investor_company_profile_view.general_role')}}
                    </h5>-->
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
                    {{trans('tenant_dashboard.country_label')}}:
                  </div>
                  <div class="value">
                    {{ isset($tenant[0]->countryname)?$tenant[0]->countryname:"" }}
                  </div>
                </div>
                {{-- @php
                $profile_image = asset('storage/company/profileimage/'.$tenant[0]->profileimage);
                @endphp
                <div class="rianta-img float-right text-right">
                  <img src="{{ $profile_image }}" class="img-responsive" />
                </div> --}}
                <div class="rianta-img float-right text-right">
                  @if( (isset($tenant[0]->logo) && !empty($tenant[0]->logo) ) &&
                  File::exists(public_path('/storage/tenant/logoimage/'.$tenant[0]->logo)))
                  <img src="{{ asset('storage/tenant/logoimage/'.$tenant[0]->logo) }}" class="img-responsive">
                  @else
                  @if(isset($tenant[0]->firstname) || isset($tenant[0]->lastname))
                  <img src="{{ Avatar::create(ucfirst($tenant[0]->company))->toBase64() }}" style="width:183px;height:61px;"
                    class="img-responsive">
                  @endif
                  @endif
                </div>
              </div>

            </div>
          </div>

          <div class="up-contents">
            <h5 class="element-header">
              {{trans('tenant_dashboard.tenant_information_heading')}}
            </h5>
            <div class="row invst-pfl">
              <div class="col-sm-5">
                <div class="label">
                  {{trans('tenant_dashboard.tenant_name_label')}}
                </div>
                @if(isset($tenant[0]->firstname) || isset($tenant[0]->lastname))
                <h5>{{$tenant[0]->firstname.' '.$tenant[0]->lastname}}</h5>
                @endif
              </div>
              {{-- @if(isset($tenant[0]->username) && !empty($tenant[0]->username))
              <div class="col-sm-7">
                <div class="label">
                  {{trans('tenant_dashboard.username_label')}}
                </div>
                <h5>{{isset($tenant[0]->username)?$tenant[0]->username:""}}</h5>
              </div>
              @endif --}}
            </div>
            @if(isset($tenant[0]->email) && !empty($tenant[0]->email))
            <div class="row invst-pfl">
              <div class="col-sm-5">
                <div class="label">
                  {{trans('tenant_dashboard.tenant_email_label')}}
                </div>
                <h5>{{isset($tenant[0]->email)?$tenant[0]->email:""}}</h5>
              </div>

            </div>
            @endif

          </div>



          <div class="up-contents">
            <h5 class="element-header">
              {{ trans('tenant_dashboard.company_information_heading')}}
            </h5>
            <div class="row invst-pfl">

              @if(isset($tenant[0]->company) && !empty($tenant[0]->company))
              <div class="col-sm-5">
                <div class="label">
                  {{ trans('tenant_dashboard.company_label')}}
                </div>
                <h5>{{isset($tenant[0]->company)?$tenant[0]->company:""}}</h5>
              </div>
              @endif
              {{-- @if(isset($tenant[0]->companyemail) && !empty($tenant[0]->companyemail))
              <div class="col-sm-7">
                <div class="label">
                  {{ trans('tenant_dashboard.email_label')}}
                </div>
                <h5>{{isset($tenant[0]->companyemail)?$tenant[0]->companyemail:""}}</h5>
              </div>
              @endif --}}
            </div>
            <div class="row invst-pfl">
              @if(isset($tenant[0]->phone) && !empty($tenant[0]->phone))
              <div class="col-sm-5">
                <div class="label">
                  {{ trans('tenant_dashboard.telephone_label')}}
                </div>
                <h5>{{isset($tenant[0]->phone)?$tenant[0]->phone:""}}</h5>
              </div>
              @endif
              @if(isset($tenant[0]->address1) && !empty($tenant[0]->address1))
              <div class="col-sm-7">
                <div class="label">
                  {{ trans('tenant_dashboard.address_label')}}
                </div>
                <h5>{{isset($tenant[0]->address1)?$tenant[0]->address1:""}}</h5>
              </div>
              @endif
            </div>
            <div class="row invst-pfl">
              @if(isset($tenant[0]->city) && !empty($tenant[0]->city))
              <div class="col-sm-5">
                <div class="label">
                  {{ trans('tenant_dashboard.city_label')}}
                </div>
                <h5>{{isset($tenant[0]->city)?$tenant[0]->city:""}}</h5>
              </div>
              @endif
              @if(isset($tenant[0]->statename) && !empty($tenant[0]->statename))
              <div class="col-sm-7">
                <div class="label">
                  {{ trans('tenant_dashboard.state_label')}}
                </div>
                <h5>{{isset($tenant[0]->statename)?$tenant[0]->statename:""}}</h5>
              </div>
              @endif
            </div>

            <div class="row invst-pfl">
              @if(isset($tenant[0]->postcode) && !empty($tenant[0]->postcode))
              <div class="col-sm-5">
                <div class="label">
                  {{ trans('tenant_dashboard.zip_label')}}
                </div>
                <h5>{{isset($tenant[0]->postcode)?$tenant[0]->postcode:""}}</h5>
              </div>
              @endif
              @if(isset($tenant[0]->countryname) && !empty($tenant[0]->countryname))
              <div class="col-sm-7">
                <div class="label">
                  {{ trans('tenant_dashboard.country_label')}}
                </div>
                <h5>{{isset($tenant[0]->countryname)?$tenant[0]->countryname:""}}</h5>
              </div>
              @endif


            </div>

          </div>




        </div>
      </div>





    </div>

  </div>
</div>

<script>





</script>



@endsection

@section('scripts')

@endsection