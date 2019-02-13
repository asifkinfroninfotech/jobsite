<meta name="csrf-token" content="{{ csrf_token() }}"> 
@extends('layouts.tenant_layout')

                @section('content')
               
                
                <div class="all-wrapper menu-side login-information">
      <div class="auth-box-w">
        <div class="logo-w">
          <a href="index.html"><img alt="" src="img/logo_desktop.png"></a>
        </div>
         <!-- START - login info content area -->
                     <div class="col-sm-12 col-md-12">
                      <div class="element-wrapper">
                        <div class="login-info-hd text-center">
                            <h5 class="element-inner-header">
                               <span>{{trans('tenant_login_info.package_name_lbl')}}:</span>
                          {{$plans[0]->plandname}}
                              </h5> 
                              <p>{{$plans[0]->plandescription}} 
                               </p>                        
                        </div>
                          <form id="formValidate">
                            
                            <div class="steps-w">
                              <div class="step-triggers">
                                <a id="steptrigger1" class="step-trigger active" href="#stepContent1">{{trans('tenant_login_info.login_information_tab')}}</a>
                                <a id="steptrigger2" class="step-trigger" href="#stepContent2">{{trans('tenant_login_info.company_profile_tab')}}</a>
                                <a id="steptrigger3" class="step-trigger" href="#stepContent3">{{trans('tenant_login_info.payment_tab')}}</a>
                                {{-- <a id="steptrigger1" class="step-trigger active" href="#">Login Information</a>
                                <a id="steptrigger2" class="step-trigger" href="#">Company Profile</a>
                                <a id="steptrigger3" class="step-trigger" href="#">Payment</a> --}}

                              </div>
                              <div class="step-contents">                          
                                <div class="step-content active" id="stepContent1">                                   
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_login_info.label_first_name')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.first_name_error')}}"
                                          placeholder="{{trans('tenant_login_info.first_name_placeholder')}}" required="required" type="Name" name='firstname'>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_login_info.label_last_name')}}*</label>
<!--                                        <input class="form-control" data-error="Your Name is invalid" placeholder="Name"
                                          required="required" data-minlength="12" type="text">-->
                                        
                                        <input class="form-control" data-error="{{trans('tenant_login_info.last_name_error')}}" placeholder="{{trans('tenant_login_info.last_name_placeholder')}}" name='lastname'
                                         required="required" type="text">
                                        
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_login_info.label_platform')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.platform_error')}}"
                                          placeholder="{{trans('tenant_login_info.platform_placeholder')}}" required="required" type="text" name='platform' id='platform'>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_login_info.label_email_address')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.email_error')}}" placeholder="{{trans('tenant_login_info.email_placeholder')}}"
                                          required="required" data-minlength="6" type="text" name='email'>
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_login_info.label_password')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.password_error')}}" required="required"  
                                        placeholder="{{trans('tenant_login_info.password_placeholder')}}" type="password" name='password' id="password1"> 
                                        <p class="charst-sert">Minimum of 6 characters</p>                                  
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_login_info.label_confirm_password')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.confirm_password_error')}}" required="required"  
                                        placeholder="{{trans('tenant_login_info.confirm_password_placeholder')}}" type="password" id="password2"> 
                                       
                                      </div>
                                    </div>

                                      {{-- <label id="emailnotification"></label> --}}
                                  </div>  
                                  
                                  <div class="alert alert-danger" id="emailnotification" style="display:none;">

                                    </div>

                                  <div class="form-buttons-w text-right">                                    
<!--                                    <a class="btn btn-primary step-trigger-btn" href="#stepContent2" onclick='logininformationsave();'> Next</a>-->
                                  <a id="btntrigger1" class="btn btn-primary step-trigger-btn"  href="#stepContent2"  onclick='logininformationsave();'>{{trans('tenant_login_info.login_next_btn')}}</a>
                                  </div>
      
      
                                </div>
                                <div class="step-content financial-section-tab" id="stepContent2">                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                          <div class="form-group">
                                              <input type='hidden' id='talenthiddenid' name="talenthidden" value="">
                                            <label for=""> {{trans('tenant_login_info.company_name_label')}}*</label>
                                            <input class="form-control" placeholder="{{trans('tenant_login_info.company_placeholder')}}"
                                              data-error="{{trans('tenant_login_info.company_error')}}" required="required" type="text" name="companyname">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                          </div>
                                        </div>
                                      </div>
                                  <div class="row">
<!--                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for=""> Email Address</label>
                                            <input class="form-control" data-error="Your Email Address is invalid" placeholder="Email"
                                              required="required" data-minlength="12" type="text" name="companyemail">
                                            <div class="help-block form-text with-errors form-control-feedback"></div>
                                          </div>
                                    </div>-->
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for=""> {{trans('tenant_login_info.telehone_name_label')}}</label>
                                            <input class="form-control"  placeholder="{{trans('tenant_login_info.telephone_placeholder')}}"
                                              type="text" name="companytelephone">
                                            {{-- <div class="help-block form-text with-errors form-control-feedback"></div> --}}
                                          </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">  
                                        <div class="form-group">
                                            {{-- data-error="{{trans('tenant_login_info.address_error')}}"
                                            required="required" --}}
                                              <label for="">{{trans('tenant_login_info.address_name_label')}}</label>
                                              <input class="form-control"  placeholder="{{trans('tenant_login_info.address_placeholder')}}" 
                                              type="text" name="companyaddress">
                                              {{-- <div class="help-block form-text with-errors form-control-feedback"></div> --}}
                                          </div>
                                      </div>
                                  </div>
                                  <div class="row">
                                      {{-- data-error="{{trans('tenant_login_info.city_error')}}" required="required" --}}
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label for=""> {{trans('tenant_login_info.city_name_label')}}</label>
                                         <input class="form-control"  placeholder="{{trans('tenant_login_info.city_placeholder')}}"
                                          type="text" name="companycity">
                                         {{-- <div class="help-block form-text with-errors form-control-feedback"></div> --}}
                                         </div>
                                      </div>
                                      <div class="col-sm-6">
                                        <div class="form-group">
                                          <label for=""> {{trans('tenant_login_info.postcode_name_label')}}*</label>
                                          <input class="form-control" data-error="{{trans('tenant_login_info.postcode_error')}}" 
                                          required="required" placeholder="{{trans('tenant_login_info.postcode_placeholder')}}" type="text" name="companypostcode">
                                          <div class="help-block form-text with-errors form-control-feedback"></div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label for=""> {{trans('tenant_login_info.country_label')}}*</label>
                                            <select class="form-control" data-error="{{trans('tenant_login_info.country_error')}}" 
                                            required="required" onchange="selectstate(this.value);" name="companycountry">
                                                <option value="">
                                                  Select Country
                                                </option>
                                                
                                                @foreach($country as $country)
                                                <option value="{{$country->countryid}}">{{$country->name}}</option>
                                                
                                                @endforeach
                                              </select>
                                              <input type="hidden" name="companycountrynew" id="companycountrynew" value=""/>
                                              <div class="help-block form-text with-errors form-control-feedback"></div>
                                          </div>
                                        </div>
                                        <div class="col-sm-6">
                                          <div class="form-group">
                                            <label for="">{{trans('tenant_login_info.state_label')}}*</label>
                                         
                                            <select class="form-control" data-error="{{trans('tenant_login_info.state_error')}}" 
                                            required="required" placeholder="{{trans('tenant_login_info.state_placeholder')}}" name="companystate" id="companystate" onchange="selectcity(this.value);">
                                          
                                          </select>
                                          <input type="hidden" name="companystatenew" id="companystatenew" value=""/>
                                          <div class="help-block form-text with-errors form-control-feedback"></div>
                                          </div>
                                        </div>
                                    </div> 
                                    <div class="alert alert-danger" id="stp2_error" style="display:none;">

                                    </div>
                                    <div class="form-buttons-w text-right">                                    
                                     <a class="btn btn-primary step-trigger-btn" href="#stepContent1"> {{trans('tenant_login_info.previous_btn_caption')}}</a>
                                      <a id="steptrigger2btn" class="btn btn-primary step-trigger-btn" href="#stepContent2" onclick="sendcompanyprofileinfo();"> {{trans('tenant_login_info.next_btn_caption')}}</a>
                                  </div>
                                     <label id="companyprofilenotification"></label>
                                </div>
                                
                                <div class="step-content" id="stepContent3">                                  
                                  <div class="row payment-card-img">
                                      <div class="col-sm-12">
                                        <div class="form-group">
                                          <label for=""> {{trans('tenant_login_info.label_we_accept')}}</label>
                                          <img src="/img/payment-img.jpg" />
                                        </div>
                                      </div>                                   
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_login_info.label_card_name')}}*</label>
                                        <input type="hidden" name="talenthiddenid3" id="talenthiddenid3" value="">
                                        <input class="form-control" data-error="{{trans('tenant_login_info.label_card_name')}}"
                                          placeholder="{{trans('tenant_login_info.card_name_placeholder')}}" required="required" type="Name" name="cardname">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>                                   
                                  </div>
                                  <div class="row">
                                      <div class="col-sm-12">
                                      <div class="form-group">
                                        <label for=""> {{trans('tenant_login_info.label_card_number')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.card_error')}}"
                                          placeholder="{{trans('tenant_login_info.card_number_placeholder')}}" required="required" type="Name" name="cardnumber">
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>  
                                  </div>
                                  <div class="row">
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_login_info.card_expiry_label')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.card_expiry_error')}}" required="required"  
                                        placeholder="{{trans('tenant_login_info.card_expiry_placeholder')}}" type="text" name="cardexpiry"> 
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                    </div>
                                    <div class="col-sm-6">
                                      <div class="form-group">
                                        <label for="">{{trans('tenant_login_info.card_code_label')}}*</label>
                                        <input class="form-control" data-error="{{trans('tenant_login_info.card_code_error')}}" required="required"  
                                        placeholder="{{trans('tenant_login_info.card_code_placeholder')}}" type="text" name="cardcode"> 
                                        <div class="help-block form-text with-errors form-control-feedback"></div>
                                      </div>
                                        <input type="hidden" name="planid" value="{{$_GET['pid']}}">
                                    </div>
                                  </div> 
                                  <div class="form-buttons-w text-right" id="btndash">
<!--                                    <button id="saveme" onclick="cardinfosave();" class="btn btn-primary" type="submit"> Save</button>-->
                                    <a class="btn btn-primary step-trigger-btn" href="#stepContent2"> {{trans('tenant_login_info.card_previous_btn_caption')}}</a>
                                    <button id="saveme"  class="btn btn-primary" type="submit"> {{trans('tenant_login_info.card_save_btn_caption')}}</button>
                                    
                                    
                                    {{-- <a id="confirmpay" onclick="payment();" class="btn btn-primary step-trigger-btn" href="#">Confirm & Pay</a> --}}
                                  </div>
                                    <label id="cardmessage"></label>
                                </div> 
      
                              </div>
                            </div>
                          </form>                        
                      </div>                      
                    </div>
                          <!-- END - login info content area -->
        
      </div>
      <p class="copy-right text-center">
          &copy; Copyright {{date('Y')}} {{\App\Helpers\AppGlobal::$Artha_Company_Name}}. All rights reseved.
        </p>
    </div>
                
                @endsection


                @section('scripts')
                <script>
                function logininformationsave()
                {
                  var firstname = $("[name='firstname']").val();
                  var lastname = $("[name='lastname']").val();
                  var email = $("[name='email']").val();
                  var platform = $("#platform").val();
                  var password = $("#password1").val();
                  var password1 = $("#password2").val();
                  
                 var formdata=decodeURIComponent($('#stepContent1 input').serialize());
                 
                 //alert(formdata);
                 
                 
                 $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                          });
                       
                       
                  if(firstname.length==0 || lastname.length==0 || platform.length==0|| email.length == 0 ||  password.length == 0 || password1.length == 0)     
                  {
                      $('#emailnotification').html('{{trans('tenant_login_info.login_information_all_data')}}');
                      $('#emailnotification').show();
                      $("#btntrigger1").attr("href", "#stepContent1");
                       $( "#saveme" ).prop( "disabled", true );
                     
                  }
                  
                 else if(firstname.length>0 && platform.length>0 && lastname.length>0 && email.length > 0  && password.length > 0 && password1.length > 0 && password!=password1)     
                  {
                      $('#emailnotification').html('{{trans('tenant_login_info.login_information_password_match')}}');
                      $('#emailnotification').show();
                      $("#btntrigger1").attr("href", "#stepContent1");
                       $( "#saveme" ).prop( "disabled", true );
                     
                  }
                  
                  else if(firstname.length>0 && platform.length>0 && lastname.length>0 && email.length > 0 && password.length > 0 && password1.length > 0 && password==password1)     
                  {
                   var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                   if(!(emailReg.test(email)))
                   {
                      $('#emailnotification').html('{{trans('tenant_login_info.login_informtion_not_valid_email')}}');
                      $('#emailnotification').show();
                      $("#btntrigger1").attr("href", "#stepContent1");
                     
                       $( "#saveme" ).prop( "disabled", true );
                      
                       
                   }
                    else
                    {
                   $('#emailnotification').hide();  
                   $('.step-content').removeClass( "active" );
                   $('#stepContent2').addClass( "active" );
                   
                   $.ajax({
                   url: '/logininformation',
                   type: "POST",
                   data: formdata,
                   cache: false,
                   timeout: 100000,
                   success: function (data) {
               
                   if(data.save==0)
                   {
                       $('#emailnotification').html('{{trans('tenant_login_info.login_information_email_exist')}}');
                       $('#emailnotification').show();
                       $( ".step-trigger" ).removeClass( "complete active" );
                       $("#steptrigger1").addClass('complete active');
                       $('.step-content').removeClass( "active" );
                       $('#stepContent1').addClass( "active" );
                       $( "#saveme" ).prop( "disabled", true );
                   }
                    if(data.save==1)
                   {
                       
                       $('#emailnotification').hide();

                        // $( ".step-trigger" ).removeClass( "complete active" );
                       $("#steptrigger2").addClass('complete active');

                      //  $("#btntrigger1").attr("href", "#stepContent2");
                      //  $("#btntrigger1").attr("href", "#stepContent2");
//                       $( ".step-trigger" ).removeClass( "complete active" );
//                       $("#steptrigger1").addClass('complete active');
                       $('.step-content').removeClass( "active" );
                       $('#stepContent2').addClass( "active" );
                       $( "#saveme" ).prop( "disabled", false );
                   }
               
               
//              if(data.save==1)
//              {
//                
//           
//                  $( ".step-trigger" ).removeClass( "active" );
//                  $("#steptrigger2").addClass('complete active');
//                  $('.step-content').removeClass( "active" );
//                  $('#stepContent2').addClass( "active" );
//                
//                $('#emailnotification').html('');
//                $('#emailnotification').hide();
//                $('#btntrigger1').attr('onclick','');
//                
//              }
//              if(data.save==0)
//              {
//                  $('#emailnotification').html('Email already exists');
//                  $('#emailnotification').show();
//                  $( ".step-trigger" ).removeClass( "complete active" );
//                  $("#steptrigger1").addClass('complete active');
//                  $('.step-content').removeClass( "active" );
//                  $('#stepContent1').addClass( "active" );
//              }
              
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });      
                      
                      
                      
                      
                      
            }    
                      
                      
                      
                  }
                  
                else
                  {
                   
                   
                   
                   }
 
                }
                
                
                
                function sendcompanyprofileinfo()
                {
                  debugger;
                  var companyname = $("[name='companyname']").val();
                  
                  var companytelephone = $("[name='companytelephone']").val();
                  var companyaddress = $("[name='companyaddress']").val();
                  var companycity = $("[name='companycity']").val();

                  var companypostcode = $("[name='companypostcode']").val();
                  var companycountry = $("[name='companycountry']").val();
                  var companystate = $("[name='companystate']").val();
                  
                  var formdata=decodeURIComponent($('#stepContent2 input').serialize());
                
                 
                 $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                          });
                       
                          // companytelephone.length == 0 || companyaddress.length == 0 || companycity.length == 0 ||
                  if(companyname.length==0 ||  companypostcode.length == 0 || companycountry.length == 0 || companystate.length == 0)     
                  {
                    $('#stp2_error').html('{{trans('tenant_login_info.stp2_error')}}');
                    $('#stp2_error').show();
                    $("#steptrigger2btn").attr("href", "#stepContent2");
                  }
                  
               
                else
                  {
                    $('#stp2_error').hide();
                   $.ajax({
                   url: '/companyprofilesave',
                   type: "POST",
                   data: formdata+"&companycountry="+companycountry+"&companystate="+companystate,
                   cache: false,
                   timeout: 100000,
                   success: function (data) {

              if(data.save==1)
              {
                
           // alert(data.tenantid);
            // $("#steptrigger2btn").attr('onclick','');;
           // $('#talenthiddenid').val(data.tenantid); 
            // $('#talenthiddenid3').val(data.tenantid); 
            $("#steptrigger2btn").attr("href", "#stepContent3");
                
                  $( ".step-trigger" ).removeClass( "active" );
                  $("#steptrigger3").addClass('complete active');
                  $('.step-content').removeClass( "active" );
                  $('#stepContent3').addClass( "active" );
                
                $('#companyprofilenotification').text('');
                
              }
              if(data.save==0)
              {
                  $('#companyprofilenotification').text('Email already exists');
                  $( ".step-trigger" ).removeClass( "complete active" );
                  $("#steptrigger2").addClass('complete active');
                  $('.step-content').removeClass( "active" );
                  $('#stepContent2').addClass( "active" );
              }
              
            },
            error: function (err, result) {
              debugger;
                alert("Error" + err.responseText);
            }
        });      
                   }    
                  
    
    
  
    
    
    
   
                   
                   
                }
                
                
                
                
                
                
                
                
                function selectstate(state)
                {
                 var url='/getstate?countryid='+state;
                 $('#companycountrynew').val(state);
                 ajaxLoad(url);
                 
                 setTimeout(function() {
                   var city=$("#companystate option:selected").val();
                   selectcity(city);
                  }, 2000);

                 
                 
                 
                }
                
                
                
               
                
                
                
                
                
                function selectcity(city)
                {
                  $('#companystatenew').val(city);
                    
                  var url='/getcity?stateid='+city;
                  ajaxLoad(url);  
                }
                
                
                
                
                function ajaxLoad(filename) {
                    
             
                  
        $.ajax({
            type: "GET",
            url: filename,
           contentType: false,
           
            success: function (data) {
                
                
                
                
            if(data.states=='getstate')  
            {
            $('#companystate').html("");
            $('#companystate').html(data.view);
            }
            if(data.states=='getcity')  
            {
                
               
                
                
           $('#companycity').html("");
            $('#companycity').html(data.view);
            }
            if(data.states=='button')
            {
                if(data.button==0)
                {
                    $('#confirmpay').addClass("disabled");
                }
                if(data.button==1)
                {
                    $('#confirmpay').removeClass("disabled");
                }
            }
            if(data.states=='payment')
            {
                //alert(data.price);
            }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
      }
                
                
         
        
        $('#formValidate').on('submit',function (e) {
           
           
           
           if($('#saveme').hasClass( "btn btn-primary disabled" ))
           {
          //  $('#cardmessage').text("Please check all input fields");
           }
           else
           {
             
            var cardname = $("[name='cardname']").val();
            var cardnumber = $("[name='cardnumber']").val();
            var cardexpiry = $("[name='cardexpiry']").val();
            var cardcode = $("[name='cardcode']").val();
           
                debugger;  
                  var formdata=decodeURIComponent($('#formvalidate input').serialize());
                 
                 //alert(formdata);
                 
                 
                 $.ajaxSetup({
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                          });
                       
                       
                  if(cardname.length==0 || cardnumber.length==0 || cardexpiry.length == 0 || cardcode.length == 0 )     
                  {
                      // $('#cardmessage').text('All data must not be empty');
                      //$("#steptrigger2btn").attr("href", "#stepContent2")
                  }
                  else
                  {
                    $('#saveme').prop('disabled', true);
                   $.ajax({
                   url: '/cardsave',
                   type: "POST",
                   data: formdata,
                   cache: false,
                   timeout: 100000,
                   success: function (data) {
                       

              if(data.save==1)
              {
                var tenantid=data.tenantid;
                // $('#btngodash').remove();  
                // $('#btndash').append('<a id="btngodash"  class="btn btn-primary" href="/tenant/dashboard">Go to my dashboard</a>');
                // $('#cardmessage').text('Details saved successfully');
                // $('#confirmpay').removeClass("disabled");
                window.location.href = "/thankyoupage";
              }
             else
             {
                 alert(data);
                 $('#saveme').prop('disabled', false);
             }
              
            },
            error: function (err, result) {
              debugger;
              $('#saveme').prop('disabled', false);
                // alert("Error" + err.responseText);

            }
        });      
                   }    
                  
        
           }
          e.preventDefault();
       });
         
         
                
           
           
           //checking tenantid
            $( document ).ready(function() {
            // tenantid=$('#talenthiddenid3').val();   
            // var url='/payandconfirm?tenantid='+tenantid;
            // ajaxLoad(url); 
             });
            
            
          function payment()
          {
              
               
             var productid = "as12345";
             var producttitle="Telivision";
             var productdescription="A 16 inch plasma tv";
             var productprice="12000";
             
             //var formdata=decodeURIComponent($('#stepContent2 input').serialize());
            
             if(productid.length==0 || producttitle.length==0 || productdescription.length == 0 || productprice.length == 0)     
                     {
                    //  $('#companyprofilenotification').text('All data must not be empty');
                     //$("#steptrigger2btn").attr("href", "#stepContent2")
                     }
                  
            else
                     {
                     
                      var paymentsuccess='getpaymentsuccess';
                      
                      var paymentfailure='getpaymentfailure';
                      
                      //var url=paymentsuccess+'?price=2000';
                      
                      var url=paymentsuccess+'?price=2000';
                      
                      window.location.href=url;
                      //ajaxLoad(url); 
                  
                  
                  
                     }    
                  
    
    
  
    
    

              
              
              
              
              
              
              
              
              
              
              
          }
                
                
                </script>
                
                
                
                @endsection
                
                
                
                


