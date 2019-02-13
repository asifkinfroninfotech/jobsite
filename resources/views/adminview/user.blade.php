<meta name="csrf-token" content="{{ csrf_token() }}">
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

    <!--Asif popup -->

    <div aria-labelledby="exampleModalLabel" class="modal fade show" id="invitedeletemodal" role="dialog" tabindex="-1"
      style="display: none; padding-right: 17px;">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              Delete Confirmation
            </h5>
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <form class="ng-pristine ng-valid">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <h6>
                      This will delete the invited users. Do you want to continue?
                    </h6>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="alert alert-success" role="alert" id="del-message-box" style="display:none;">
            Selected documents deleted succussfully.
          </div>
          <div class="modal-footer">
            <input type="hidden" id="deleteinvitedid" value="">

            <button class="btn btn-secondary" data-dismiss="modal" type="button" id="mdel_close">No</button>
            <button class="btn btn-primary" type="button" onclick="fnDeleteSelectedinvited();" id="btn_del_yes">Yes</button>
          </div>

        </div>
      </div>
    </div>

    <!-- popup end-->


    @include('adminview.shared._top_menu')

    <div class="content-i" id="companyandtableviewarea">
      <div class="content-box">
        <div class="element-wrapper">
          <h6 class="element-header">
            {{trans('adminview.user_title')}}
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
                <option value="username">
                  User Name
                </option>
                <option value="companyname">
                  Company Name
                </option>
                <option value="companytype">
                  Company Type
                </option>

              </select>



            </div>


          </div>


          <div id="usertable">


          </div>



        </div>

      </div>
    </div>
  </div>
</div>





@endsection


@section('scripts')

<script>
  $(document).ready(function () {
    table = $('#dataTable1');
    table.DataTable().destroy();

    table.DataTable({
      "order": [
        [0, "asc"]
      ]
    });

    $('.table-rm-style th').removeAttr('style');
  });
  $(window).on('load resize scroll', function (e) {
    $('.table-rm-style th').removeAttr('style');
    $('.table-rm-style').parent('.col-sm-12').addClass('table-responsive');
  });
</script>
<script>
  function inactive($userid, $currentstats) {
    //  var csrf_token = $('meta[name="csrf-token"]').attr('content');
    //  var v_token = encodeURIComponent(csrf_token);
    postvalue($userid, 'Brown', 'Inactive', $currentstats);


  }

  function active($userid, $currentstats) {
    postvalue($userid, 'green', 'Active', $currentstats);

  }



  function postvalue($userid, colour, title, $currentstatus) {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var v_token = '{{csrf_token()}}';
    $.post('/teams/status', {
      input: $userid,
      title: title,
      currentstatus: $currentstatus,
      _token: v_token
    }, function (data) {
      window.location.reload();
    });
  }

  function deleteinvitedpop($userid) {
    $('#deleteinvitedid').val($userid);
    $('#invitedeletemodal').modal('toggle');

  }

  function fnDeleteSelectedinvited() {


    debugger;
    var deleteselected = $('#deleteinvitedid').val();

    if (deleteselected.length > 0) {

      $.get('teams/deleteinvited?deleteinvited=' + deleteselected, function (data) {


        //$('#ajaxsearch').html(data.view); 
        //alert(data);
        //console.log(data);
        $('#invitedeletemodal').modal('hide');

        window.location.reload();


      });

    }


  }

  function makeuserview(userid) {
    $.get('/makeuserview?userid=' + userid, function (data) {
      $('#companyandtableviewarea').html(data.view);
    });

  }




  var search = "";
  var types = "";
  var sort = "";



  function sortme1(sortval) {
    sort = sortval;
    getuserdata(1, search, types, sort);
  }






  var timer;

  function searchfunc() {
    search = $('#searchcompany').val();

    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function () {
      debugger;
      getuserdata(1, search, types, sort);
    }, ms);



  }




  getuserdata(1, search, types, sort);


  function getuserdata(page) {
    $.get('/getuserdata?page=' + page + '&search=' + search + '&types=' + types + '&sort=' + sort, function (
      data) {
      $('#usertable').html('');
      $('#usertable').html(data);

      var cntrows = $('#usertable tr').length - 1;
      $('#numberofbox').text((cntrows - 1));
      $('a').tooltip();

    })
  }


  $(document).on('click', '.pagination a', function (e) {
    debugger;
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getuserdata(page, search, types, sort);
  });
</script>
@endsection