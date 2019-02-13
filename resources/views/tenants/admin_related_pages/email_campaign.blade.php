@section('content')
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
<div class="layout-w">

    <div class="content-w">

        <!--Asif popup -->

        <div aria-labelledby="exampleModalLabel" class="modal fade" id="new_tender_process" role="dialog" tabindex="-1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{trans('tenant_email.popup_send_email_title')}}
                        </h5>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">
                                ×</span></button>
                    </div>
                    <form id="sendtenantemail" method="post" action="/sendtenantemail" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="modal-body" id="div_new_tender">




                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal" type="button" id="tenants_close"
                                onclick="">{{trans('my_tender.popup_cancel_btn_lbl')}}</button>
                            <button class="btn btn-primary" id="sendemailbtn" onclick="sendemail();">Send email</button>
                        </div>
                        <div class="alert alert-danger" style="display:none;">Data Saved Successfully</div>
                    </form>
                </div>
            </div>
        </div>

        <!-- popup end-->

        @include('tenants.shared._top_menu_tenant')

        <div class="content-i">
            <div class="content-box">
                @if((session('helpview')!=null))
                <div class="element-wrapper" id='helpform'>
                    <div class="element-box">
                        <h5 class="form-header">
                            {{trans('tenant_email.help_title')}}
                        </h5>
                        <div class="form-desc">
                            {{trans('tenant_email.help_content')}}
                        </div>
                        <div class="element-box-content example-content">
                            <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                                {{trans('tenant_email.help_btn_hide_caption')}}</button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('tenant_email.email_title')}}

                        <!--                <button class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse" data-toggle="modal" data-target="#new_tender_process" style="float:right;" onclick="multitype();">Send Email </button>-->
                        <button class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse" style="float:right;" onclick="writeEmail();">{{trans('tenant_email.send_email_btn')}}</button>

                    </h6>
                    <div class="element-box" id="write-email">
                        <!--                  <h5 class="form-header">
                    Powerful Datatables
                  </h5>
                  <div class="form-desc">
                    DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.. <a href="https://www.datatables.net/" target="_blank">Learn More about DataTables</a>
                  </div>-->
                        <div class="table-responsive" id="tableemail">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th style="display:none;"></th>
                                        <th>{{trans('tenant_email.table_name_title')}}</th>
                                        <th>{{trans('tenant_email.table_subject_title')}}</th>
                                        <th>{{trans('tenant_email.table_message_title')}}</th>
                                        <th>{{trans('tenant_email.table_date_title')}}</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th style="display:none;"></th>
                                        <th>{{trans('tenant_email.table_name_title')}}</th>
                                        <th>{{trans('tenant_email.table_subject_title')}}</th>
                                        <th>{{trans('tenant_email.table_message_title')}}</th>
                                        <th>{{trans('tenant_email.table_date_title')}}</th>

                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($getemailcampaignandcompanies as $getemailcampaignandcompanies)

                                    <tr>
                                        <td style="display:none;"></td>
                                        <td>{{$getemailcampaignandcompanies->emailcampaignname}}</td>
                                        <td>{{$getemailcampaignandcompanies->emailcampaignsubject}}</td>
                                        <td> {{substr($getemailcampaignandcompanies->emailcampaignmessage,0,18)."..."}}</td>
                                        <td>{{
                                            \Carbon\Carbon::parse($getemailcampaignandcompanies->creteddate)->format('d-M-Y')}}</td>

                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>



                        <form id="email-message-form" method="post" action="/sendtenantemail" enctype="multipart/form-data"
                            style="display: none;">
                            {{csrf_field()}}

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">{{trans('tenant_email.form_name_title')}}</label>


                                        <input type='text' class="form-control" id='emailcampaignname' name='emailcampaignname'>

                                    </div>

                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">{{trans('tenant_email.form_subject_title')}}</label>

                                        <input type="text" class="form-control" id='emailcampaignsubject' name='emailcampaignsubject'>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">

                                    <div class="form-group ">
                                        <label for="">{{trans('tenant_email.form_from_name_title')}}</label>
                                        <input type="text" class="form-control" name="from_name" id="from_name" value="{{old('from_name')}}" />

                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="">{{trans('tenant_email.form_from_email_title')}}</label>
                                        <input type="text" class="form-control" name="from_email" id="from_email" value="{{old('from_email')}}" />

                                    </div>

                                </div>



                            </div>




                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>{{trans('tenant_email.form_message_title')}}</label>
                                        <textarea class="form-control" rows="3" name="ckeditor1" id="ckeditorEmail">{{ old('emailcampaignmessage') }} </textarea>




                                    </div>
                                </div>

                            </div>


                            <br />
                            <br />
                            <div class="row invst-pfl">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <legend><span>{{trans('tenant_email.form_select_user_or_select_company')}}</span></legend>
                                    </div>
                                </div>
                            </div>





                            {{-- <div class="row ">
                                <div class="col-sm-12"> --}}

                                    {{-- <div class="form-group">
                                        <label>{{trans('tenant_email.form_select_user_or_select_company')}}</label>
                                    </div> --}}
                                    {{-- <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="form-check">
                                                <label class="form-check-label"><input checked="" class="form-check-input"
                                                        name="user" type="radio" value="usertype">{{trans('tenant_email.form_input_user_type')}}</label>
                                            </div>
                                            <div class="form-group">
                                                <select multiple class="form-control select2" name="companytype[]" id="companymultipletype">
                                                    @foreach($getcompanytypes as $companytype)
                                                    <option value="{{$companytype->companytypeid}}">{{$companytype->companytype}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-check">
                                                <label class="form-check-label"><input class="form-check-input" name="user"
                                                        type="radio" value="companies">{{trans('tenant_email.form_input_company_type')}}</label>
                                            </div>
                                            <div class="form-group">
                                                <select multiple class="form-control select2" name="companies[]" id="multicompanies">
                                                    <option value="">Please select</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}

                                    {{-- </div>

                            </div> --}}


                            <div class="row invst-pfl">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label"><input checked="" class="form-check-input"
                                                    name="user" type="radio" value="usertype">{{trans('tenant_email.form_input_user_type')}}</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select multiple class="form-control select2" name="companytype[]" id="companymultipletype">
                                            @foreach($getcompanytypes as $companytype)
                                            <option value="{{$companytype->companytypeid}}">{{$companytype->companytype}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row invst-pfl">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label"><input class="form-check-input" name="user"
                                                    type="radio" value="companies">{{trans('tenant_email.form_input_company_type')}}</label>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select multiple class="form-control select2" name="companies[]" id="multicompanies"
                                            type="search">
                                            <option value="">Please select</option>

                                        </select>
                                    </div>
                                </div>

                            </div>


                            <legend><strong><span></span></strong></legend>


                            <div class="row invst-pfl">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>{{trans('tenant_email.form_send_email_to_companies_or_to_admin')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row invst-pfl">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label"><input checked="" class="form-check-input"
                                                    name="usertype" type="radio" value="usertype">Admins Only</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <label class="form-check-label"><input class="form-check-input" name="usertype"
                                                    type="radio" value="companies">Every Active User</label>
                                        </div>
                                    </div>
                                </div>



                            </div>




                            <div id="emailmessageerr" class="alert alert-danger" style="display:none;">

                                <p>{{trans('tenant_email.form_error_caption')}}</p>

                            </div>

                            <div id="emailmessageerrforselected" class="alert alert-danger" style="display:none;">

                                <p>{{trans('tenant_email.form_errmessage_select_companies_or_user_type')}}</p>

                            </div>


                            <div class="form-buttons-w text-right">




                                <button id="sendemailbtn" class="btn btn-primary" onclick="firstcheckvalidationthanopen()">{{trans('tenant_email.send_btn_caption')}}
                                </button>


                            </div>


                        </form>






                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





@endsection


@section('scripts')

<script>
    //function multitype()
    //{
    //  
    // 
    // $.get('/selectemailtemplate',function(data){
    //     
    //     
    ////     $('.select2-search__field').css('width','12em'); 
    //     
    //     $('#div_new_tender').html(data.view);
    //     $('#companymultipletype').select2();
    //     
    // });
    // 
    // 
    //}

    $('#companymultipletype').select2();

    var companytypearr = [];
    var st = "";
    var timer;




    //function multicompanytypes()
    //{
    //    companytypearr=$('#companymultipletype').val();
    //    sendtofilterforcompanydata(st,companytypearr);
    //}


    function searchcomp() {

        clearTimeout(timer);
        var ms = 3000;
        timer = setTimeout(function () {
            st = $('#searchcompanies').val();
            var companytypearr1 = companytypearr;
            sendtofilterforcompanydata(st, companytypearr1);
        });


    }





    function sendtofilterforcompanydata(st, companytypearr1) {
        debugger;
        companytypearr1 = JSON.stringify(companytypearr1);

        $.get('/fetchcompanydata-ec?filter=' + st + "&companytypes=" + companytypearr1, function (data) {

            $('#multicompanies').empty();
            $('#multicompanies').select2({
                data: $.parseJSON(data)
            });
        });

    }
    var formsubmitted = 0;








    function sendemail() {
        if ($('#multicompanies').val().length == 0) {

            $("#sendtenantemail").submit(function (e) {
                e.preventDefault();
            });



            $('#emailmessagepop').css('display', 'block');
            var explode = function () {
                $('#emailmessagepop').css('display', 'none');
            };
            setTimeout(explode, 2000);
        }

        if ($('#multicompanies').val().length > 0) {
            if (formsubmitted == 0) {
                $("#sendtenantemail").submit(function (e) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    var formdata = new FormData();

                    var emailcampaignname = $('#emailcampaignname').val();
                    var emailcampaignsubject = $('#emailcampaignsubject').val();
                    var emailcampaignmessage = $('#ckeditorEmail').val();
                    var from_name = $('#from_name').val();
                    var from_email = $('#from_email').val();
                    formdata.append("emailcampaignname", emailcampaignname);
                    formdata.append("emailcampaignsubject", emailcampaignsubject);
                    formdata.append("emailcampaignmessage", emailcampaignmessage);
                    formdata.append("from_name", from_name);
                    formdata.append("from_email", from_email);


                    var other_data = $('#sendtenantemail').serializeArray();
                    $.each(other_data, function (key, input) {
                        formdata.append(input.name, input.value);
                    });
                    formdata.append("_token", '{{csrf_token()}}');
                    $.ajax({
                        url: '/ajaxsendemail',
                        type: "POST",
                        contentType: false,
                        processData: false,
                        data: formdata,
                        cache: false,
                        timeout: 100000,
                        success: function (data) {

                            //               alert(data);
                            location.reload();
                        },

                        error: function (err, result) {

                            alert("Error" + err.responseText);
                        }
                    });

                    e.preventDefault();
                });
            }
            formsubmitted++;

        }


    }


    function writeEmail() {

        $('#email-message-form').show();
        $('input.select2-search__field').css('width', '100%');
        $('span.select2.select2-container.select2-container--default').css('width', '100%');








        $('#tableemail').hide();
        //   
    }

    var formsubmitted = 0;

    function firstcheckvalidationthanopen() {
        $("#email-message-form").submit(function (e) {
            e.preventDefault();
        });

        var name = $('#emailcampaignname').val();
        var subject = $('#emailcampaignsubject').val();
        var message = $('#ckeditorEmail').val();
        var fromname = $('#from_name').val();
        var fromemail = $('#from_email').val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var emailtest = regex.test(fromemail);



        if (name.length == 0 || subject.length == 0 || message.length == 0 || fromname.length == 0 || fromemail.length ==
            0 || emailtest == false) {
            $('#emailmessageerr').css('display', 'block');
            var explode = function () {
                $('#emailmessageerr').css('display', 'none');
            };
            setTimeout(explode, 2000);
        }


        if (name.length > 0 && subject.length > 0 && message.length > 0 && emailtest > 0 && emailtest == true) {

            var companymultipletype = $('#companymultipletype').val();
            var companies = $('#multicompanies').val();

            if (companymultipletype.length == 0 || companies.length == 0) {
                $('#emailmessageerrforselected').css('display', 'block');
                var explode = function () {
                    $('#emailmessageerrforselected').css('display', 'none');
                };
                setTimeout(explode, 2000);
            }

            if (companymultipletype.length > 0 || companies.length > 0) {
                $('#emailmessageerrforselected').css('display', 'none');
                if (formsubmitted == 0) {
                    $("#email-message-form").submit(function (e) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var formdata = new FormData();

                        //      var emailcampaignname=$('#emailcampaignname').val();
                        //      var emailcampaignsubject=$('#emailcampaignsubject').val();
                        //      var emailcampaignmessage=$('#ckeditorEmail').val();
                        //      var from_name=$('#from_name').val();
                        //      var from_email=$('#from_email').val();
                        //      formdata.append("emailcampaignname", emailcampaignname); 
                        //      formdata.append("emailcampaignsubject", emailcampaignsubject);
                        //      formdata.append("emailcampaignmessage", emailcampaignmessage);
                        //      formdata.append("from_name", from_name);
                        //      formdata.append("from_email", from_email);


                        var other_data = $('#email-message-form').serializeArray();
                        $.each(other_data, function (key, input) {
                            formdata.append(input.name, input.value);
                        });
                        formdata.append("_token", '{{csrf_token()}}');
                        $('#sendemailbtn').prop('disabled', true);
                        $.ajax({
                            url: '/ajaxsendemail',
                            type: "POST",
                            contentType: false,
                            processData: false,
                            data: formdata,
                            cache: false,
                            timeout: 100000,
                            success: function (data) {


                                location.reload();
                            },

                            error: function (err, result) {
                                $('#sendemailbtn').prop('disabled', false);
                                alert("Error" + err.responseText);
                            }
                        });

                        e.preventDefault();
                    });
                }
                formsubmitted++;
            }



            //    $('#new_tender_process').modal('show');
            //    multitype();
        }
    }





    $('#multicompanies').prop('disabled', true);

    $("input[name='user']").click(function () {

        var usercompanycombo = $('input[name="user"]:checked').val();

        if (usercompanycombo == "usertype") {
            $('#multicompanies').prop('disabled', true);
            $('#companymultipletype').prop('disabled', false);
        }
        if (usercompanycombo == "companies") {
            $('#companymultipletype').prop('disabled', true);
            $('#multicompanies').prop('disabled', false);
        }


    });





    debugger;
    //    $('#multicompanies').select2({
    //                    ajax: {
    //                        url: function (params) {
    //                         clearTimeout(timer);
    //                         var ms = 3000;
    //                         timer = setTimeout(function () {
    //                          var st = params.term;
    //                          var companytypearr1=companytypearr;
    //                          alert(companytypearr1);
    //                          if (typeof st != 'undefined' && $.trim(st) != '') {
    //                         sendtofilterforcompanydata(st,companytypearr1);
    //                      }else
    //                      {
    //                         $('#multicompanies').empty(); 
    //                      }
    //                         
    //                          }, ms);
    //                            
    //                          }
    //                    }
    //                });


    //    var delay = (function(){
    //  var timer = 0;
    //  return function(callback, ms){
    //    clearTimeout (timer);
    //    timer = setTimeout(callback, ms);
    //  };
    //})();


    //    $(document).on('keyup', '.select2-search__field', function (e) { 
    //        
    //        
    //    var hiddenInputSelector = this,
    //    select2 = $(hiddenInputSelector).data('select2'),
    //    searchInput = select2.search;
    //    
    //       
    //      
    //        alert(searchInput);
    //    
    //    delay(function(){
    //      
    //      
    //         $('#multicompanies').select2({
    //         
    //         ajax: {
    //                        url: function (params) {
    //                        
    //                        
    //                          var st = params.term;
    //                          companytypearr1="";
    //                          if (typeof st != 'undefined' && $.trim(st) != '') {
    //                         sendtofilterforcompanydata(st,companytypearr1);
    //                      }else
    //                      {
    //                         $('#multicompanies').empty(); 
    //                      }
    //                  }
    //              }
    //          });  
    //      
    //      
    //      
    //    }, 2000 );
    //    
    //    
    ////    timer = setTimeout(function () {
    //
    ////     $('#multicompanies').select2({
    ////         
    ////         ajax: {
    ////                        url: function (params) {
    ////                        
    ////                        
    ////                          var st = params.term;
    ////                          companytypearr1="";
    ////                          if (typeof st != 'undefined' && $.trim(st) != '') {
    ////                         sendtofilterforcompanydata(st,companytypearr1);
    ////                      }else
    ////                      {
    ////                         $('#multicompanies').empty(); 
    ////                      }
    ////                  }
    ////              }
    ////          });
    //         
    //     
    ////    },ms);
    //    
    //    });   

    // var companytypearr = "";
    // sendtofilterforcompanydata(st, companytypearr);



    function sendtofilterforcompanydata(st, companytypearr1) {
        debugger;
        companytypearr1 = JSON.stringify(companytypearr1);

        $.get('/fetchcompanydata-ec?filter=' + st + "&companytypes=" + companytypearr1, function (data) {

            $('#multicompanies').empty();
            $('#multicompanies').select2({
                data: $.parseJSON(data)
            });
        });

    }

    sendtofilterforcompanydata('', '');
</script>
@endsection