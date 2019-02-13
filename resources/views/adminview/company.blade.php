@section('content')


<style>

  .bg-white .wmnax{
border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding-bottom: 10px;
    padding-top: 15px;
    /* padding: 1.5rem 2rem; */
    width: 97%;
    margin: 0 auto;
}


.wrapper_filter_search{

background: #ffffff;
    width: 100%;
}


.searchdflex{


    display: flex;
    /* flex: 1; */
    /* flex-basis: 10%; */
    justify-content: SPACE-BETWEEN;
    align-items: center;
    width: 20%;
}


</style>



@extends('adminview.layouts.app_layout', ['layout' => 'left_side_menu'])
<div class="layout-w">

  <div class="content-w">

    @include('adminview.shared._top_menu')

    <div class="content-i" id="companyandtableviewarea">
      <div class="content-box">


        @if (Session::has('adminmsg'))
        <div id='alertadmin' class="alert alert-danger">{{ Session::get('adminmsg') }}</div>
        @endif
        <div class="os-tabs-w">
          <div class="os-tabs-controls tab">
            <ul class="nav nav-tabs upper">
              <li class="nav-item">
                <a aria-expanded="false" class="nav-link active" data-toggle="tab" onclick="searchtypes('')" href="#">
                  {{trans('adminview.company_all_select')}} </a>
              </li>

              <li class="nav-item">
                <!-- <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('investor')" href="#">
                  {{trans('adminview.company_investors_select')}} </a> -->

                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('aba5f1')" href="#">
                  {{trans('adminview.company_investors_select')}} </a>

              </li>
              <li class="nav-item">
                <!-- <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('enterprise')" href="#">
                  {{trans('adminview.company_enterprise_select')}} </a> -->

                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('5eab3b')" href="#">
                  {{trans('adminview.company_enterprise_select')}} </a>

              </li>
              <li class="nav-item">
                <!-- <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('service providers')"
                  href="#">{{trans('adminview.company_serviceproviders_select')}}</a> -->

                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('b5aa1d')" href="#">{{trans('adminview.company_serviceproviders_select')}}</a>

              </li>
              <li class="nav-item">
                <!-- <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('eso')" href="#">
                  {{trans('adminview.company_eso_select')}}</a> -->

                <a aria-expanded="false" class="nav-link" data-toggle="tab" onclick="searchtypes('6c2b42')" href="#">{{trans('adminview.company_eso_select')}}</a>


              </li>


            </ul>
          </div>
        </div>

        <div class="element-wrapper">
          <h6 class="element-header">
            {{trans('adminview.company_title')}}
          </h6>
          <div class="col-sm-12 col-md-12 bg-white">
            <div id="company_filter" class="wmnax company_filter">

              <label class="searchdflex" style="float:right;"><span>Search:</span><span><input type="search" class="form-control form-control-sm"
                    id="searchcompany" placeholder="" onkeyup=searchfunc();></span></label>


              <select class=" searchdflex form-control form-control-sm rounded bright" id="sort" onchange="sortme1(this.value);">
                <option selected="selected" value="">
                  Sort By
                </option>
                <option value="tenant">
                  Tenant
                </option>
                <option value="companyname">
                  Company Name
                </option>
                <option value="companytype">
                  Company Type
                </option>
                <!-- <option value="sector">
                                    Sector
                                </option> -->
              </select>
            </div>


          </div>






          <div id="companytable">


          </div>





        </div>
        <!--------------------
              START - Color Scheme Toggler
              -------------------->
        <div class="floated-colors-btn second-floated-btn">
          <div class="os-toggler-w">
            <div class="os-toggler-i">
              <div class="os-toggler-pill"></div>
            </div>
          </div>
          <span>Dark </span><span>Colors</span>
        </div>
        <!--------------------
              END - Color Scheme Toggler
              -------------------->
        <!--------------------
              START - Chat Popup Box
              -------------------->
        <div class="floated-chat-btn">
          <i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
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
                    <img alt="" src="img/avatar1.jpg">
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
                <a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a
                  href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a
                  href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
              </div>
            </div>
          </div>
        </div>
        <!--------------------
              END - Chat Popup Box
              -------------------->
      </div>
    </div>
  </div>
</div>





@endsection


@section('scripts')

<script>
  $("#alertadmin").fadeTo(2000, 500).slideUp(500, function () {
    $("#success-alert").slideUp(500);
  });

  // function searchtypes(searchfactor) {
  //   //$('div.dataTables_filter input').val(searchfactor);
  //   $('#dataTable1').DataTable().search(searchfactor).draw();


  // }

  var search = "";
  var types = "";
  var sort = "";



  function sortme1(sortval) {
    sort = sortval;
    getcompanydata(1, search, types, sort);
  }

  function searchtypes(searchfactor) {
    //$('div.dataTables_filter input').val(searchfactor);
    types = searchfactor;
    getcompanydata(1, search, types, sort);

  }





  //created company view



  function companyactive(companyid) {
    $.get('/makecompanyactive?companyid=' + companyid, function (data) {
      location.reload();
    });


  }

  function companyinactive(companyid) {
    $.get('/makecompanyinactive?companyid=' + companyid, function (data) {
      location.reload();
    });

  }





  // $('#searchcompany').keyup(function () {
  //   count = 0;
  //   setTimeout(function () {
  //     if (count == 0) {
  //       search = $('#searchcompany').val();
  //       alert(search);
  //       count++;
  //     }
  //   }, 2000);


  // });

  var timer;

  function searchfunc() {
    search = $('#searchcompany').val();

    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function () {
      debugger;
      getcompanydata(1, search, types, sort);
    }, ms);



  }





  getcompanydata(1, search, types, sort);


  function getcompanydata(page, search, types, sort) {
    $.get('/getcompanydata?page=' + page + '&search=' + search + '&types=' + types + '&sort=' + sort, function (
      data) {
      $('#companytable').html('');
      $('#companytable').html(data);

      var cntrows = $('#companytable tr').length - 1;
      $('#numberofbox').text((cntrows - 1));
      $('a').tooltip();

    })
  }


  $(document).on('click', '.pagination a', function (e) {
    debugger;
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getcompanydata(page, search, types, sort);
  });
</script>
@endsection