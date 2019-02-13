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




@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
<div class="layout-w">

  <div class="content-w">

    @include('tenants.shared._top_menu_tenant')


    <div class="content-i">
      <div class="content-box">

        @if((session('helpview')!=null))
        <div class="element-wrapper" id='helpform'>
          <div class="element-box">
            <h5 class="form-header">
              {!!trans('tenant_page.help_title')!!}
            </h5>
            <div class="form-desc">
              {!!trans('tenant_page.help_content')!!}
            </div>
            <div class="element-box-content example-content">
              <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                {{trans('tenant_page.help_btn_hide_caption')}}</button>
            </div>
          </div>
        </div>
        @endif

        @if (Session::has('adminmsg'))
        <div id='alertadmin' class="alert alert-danger">{{ Session::get('adminmsg') }}</div>
        @endif



        <div class="element-wrapper">
          <h6 class="element-header">
            {{trans('tenant_page.page_title')}}
            <a class="mr-2 mb-2 btn btn-primary btn-sm btn-pluse" style="float:right;" href="/tenant/create-page">{{trans('tenant_page.create_page')}}</a>
          </h6>
          <div class="col-sm-12 col-md-12 bg-white">
            <div id="company_filter" class="wmnax company_filter">

              <label class="searchdflex" style="float:right;"><span>Search:</span><span><input type="search" class="form-control form-control-sm"
                    id="searchcompany" placeholder="" onkeyup=searchfunc();></span></label>


              <select class=" searchdflex form-control form-control-sm rounded bright" id="sort" onchange="sortme1(this.value);">
                <option selected="selected" value="">
                  Sort By
                </option>
                <option value="name">
                  Name
                </option>
                <option value="title">
                  Title
                </option>



              </select>



            </div>


          </div>

          <div id="pagetable">


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
  var search = "";

  var sort = "";



  function sortme1(sortval) {
    sort = sortval;
    getpagedata(1, search, sort);
  }






  var timer;

  function searchfunc() {
    search = $('#searchcompany').val();

    clearTimeout(timer);
    var ms = 3000; // milliseconds
    var val = this.value;
    timer = setTimeout(function () {
      debugger;
      getpagedata(1, search, sort);
    }, ms);



  }



  getpagedata(1, search, sort);


  function getpagedata(page) {
    $.get('/getpagedata?page=' + page + '&search=' + search + '&sort=' + sort, function (
      data) {
      $('#pagetable').html('');
      $('#pagetable').html(data);

      var cntrows = $('#pagetable tr').length - 1;
      $('#numberofbox').text((cntrows - 1));
      $('a').tooltip();

    })
  }


  $(document).on('click', '.pagination a', function (e) {
    debugger;
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    getpagedata(page, search, sort);
  });
</script>
@endsection