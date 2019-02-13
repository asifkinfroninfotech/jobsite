@php
$view="";
$layout="";
if(isset($tid) && !empty($tid))
{
    
    // if($calledfrom=="admin")
    // {
    //   $view='adminview.layouts.app_layout';
    //   $layout='left_side_menu';
       
    // }
    // else if($calledfrom=="tenant")
    // {
       $view= 'tenants.layouts.app_layout';
       $layout='left_side_menu_tenant';
      
    // }
}
else
{
    $view= 'layouts.app_layout';
    $layout='left_side_menu_compact'; 
}

@endphp

@extends($view, ['layout' => $layout])
@section('content')

<div class="content-w portfolio-custom-vk">
   <!--
     START - Secondary Top Menu
     -->
     @if(isset($tid) && !empty($tid))
     @include('tenants.shared._top_menu_tenant')
     @else
     @include('shared._top_menu')
     @endif
 

   <div class="content-panel-toggler">
       <i class="os-icon os-icon-grid-squares-22"></i>
       <span>Sidebar</span>
   </div>

   <div class="content-i">
       <div class="content-box">

            @if((session('helpview')!=null))
            <div class="element-wrapper" id='helpform'>
      <div class="element-box">
                      <h5 class="form-header">
                             {!!trans('dd_template.help_title')!!}   
                          </h5>
                          <div class="form-desc">
                             {!!trans('dd_template.help_content')!!}
                          </div>
                          <div class="element-box-content example-content">
                                  <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'> {{trans('dd_template.help_btn_hide_caption')}}</button>
                          </div>
      </div>
  </div>
@endif
           <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">
                        {{trans('dd_template.template_heading')}}
                    </h6>

                    <div class="controls-above-table filter-row-top">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input class="form-control form-control-sm rounded bright" placeholder="{{trans('dd_template.template_search_placeholder')}}" type="text" id="txtTemplateSearch">
                                </form>
                            </div>
                        </div>
                    </div>

                        <!--START - Templates-->
                        <div class="projects-list element-box projects-list-vk" id="divTemplates">


                        </div>
                        <!--END - Templates-->

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header" id="header_modules">
                        {{trans('dd_template.modules_heading')}}
                    </h6>

                    <div class="controls-above-table filter-row-top">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input class="form-control form-control-sm rounded bright" placeholder="{{trans('dd_template.template_search_placeholder')}}" type="text" id="txtModuleSearch">
                                </form>
                            </div>
                        </div>
                    </div>

                        <!--START - Modules-->
                        <div class="projects-list element-box projects-list-vk" id="divModules">


                        </div>
                        <!--END - Modules-->

                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header" id="header_question">
                        {{trans('dd_template.question_heading')}}
                    </h6>

                    <div class="controls-above-table filter-row-top">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline justify-content-sm-end">
                                    <input class="form-control form-control-sm rounded bright" placeholder="{{trans('dd_template.template_search_placeholder')}}" type="text" id="txtQuestionSearch">
                                </form>
                            </div>
                        </div>
                    </div>

                        <!--START - Modules-->
                        <div class="projects-list element-box projects-list-vk" id="divQuestions">


                        </div>
                        <!--END - Modules-->

                </div>
            </div>
        </div>



       </div>
        
       <!-- Start Side Bar From Here-->
   </div>
</div>
<input type="hidden" id="templateid" value=""/>
<input type="hidden" id="moduleid" value=""/>
<input type="hidden" id="questionid" value=""/>
<input type="hidden" id="qtntemplate" value=""/>
<input type="hidden" id="tid" value="{{$tid}}"/>
      @endsection


    @section('scripts')

      <script type="text/javascript">
        $(document).ready(function(){ 
            fnget_Templates();
           
        });

        function fnget_Templates()
        {
            ajaxLoad('/get-dd-templates-data','divTemplates','Templates');
            
        }

        function fnget_Modules()
        {
            ajaxLoad('/get-dd-templates-data','divModules','Modules');
            
        }

        function fnget_Questions()
        {
            ajaxLoad('/get-dd-templates-data','divQuestions','Questions');
        }

        function ajaxLoad(route, divname,type) {
        debugger;
        var searchtext="";
        var templateid="";
        var moduleid="";
        var tid=$('#tid').val();
         switch(type)
         {
             case 'Templates':
             searchtext=$('#txtTemplateSearch').val();
             break;

             case 'Modules':
             searchtext=$('#txtModuleSearch').val();
             templateid=$('#templateid').val();

             break;

             case 'Questions':
             searchtext=$('#txtQuestionSearch').val();
             templateid=$('#templateid').val();
             moduleid=$('#moduleid').val();
             break;

         }

       
         
        route=route+'?searchtext='+searchtext+'&type='+type+'&templateid='+templateid+'&moduleid='+moduleid+'&tid='+tid;
  
        $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
                $("#" + divname).html('');
                $("#" + divname).html(data);

                if(type=='Templates')
                {
                    $('#editableTable').editableTableWidget();
                    $('#tbl_new').editableTableWidget();
                }
                 if(type=='Modules')
                {
                    $('#editableTableModules').editableTableWidget();
                    $('#tbl_module_new').editableTableWidget();
                }
                  if(type=='Questions')
                {
                    $('#editableTableQuestions').editableTableWidget();
                    $('#tbl_question_new').editableTableWidget();
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
    }

          var timer;
  $("#txtTemplateSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
        fnget_Templates();
      }, ms);
  });


  $("#txtModuleSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
        fnget_Modules();
    }, ms);
  });

    $("#txtQuestionSearch").keyup(function() {
    clearTimeout(timer);
    var ms = 2000; // milliseconds
    var val = this.value;
    timer = setTimeout(function() {
        fnget_Questions();
    }, ms);
  });


    function fnRejectInvite()
        {
         debugger;
          var type=$('#type').val();
          var pipelinedealid= $('#pipelinedealid').val();
          var companyid=$('#companyid').val();

          if(typeof companyid=='undefined' || typeof type=='undefined' || typeof pipelinedealid=='undefined')
          {
            return;
          }
          var route="/reject-invitation-tojoin-dd?companyid="+companyid+"&pipelinedealid="+pipelinedealid+"&type="+type;
          $.ajax({
            type: "GET",
            url: route,
            contentType: false,
            success: function (data) {
              
                if(data.message=='Success')
                {
                  $('#Reject_InvitationToJoinDD_Modal').modal('hide');
                  fngetDueDiligenceRequestsAndInvites();
                }
                else
                {
                }
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            }
        });
        }

      function createNewTemplate()
      {
       
       $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });
        
        var template=$('#new-template').text();
        var description=$('#new-description').text();
        var status=$('#mstatus_0').val();
        var tid=$('#tid').val();
        if(template.length == 0 || description.length == 0)
        {
          $('#errorbox-new-template').css('display','block');  
        }
        else
        {
         $('#errorbox-new-template').css('display','none');     
        var formdata = new FormData();
        formdata.append("template",template);
        formdata.append("description",description);
        formdata.append("status",status);
        formdata.append('tid',tid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/createnewtemplate',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
       debugger;
//       if(data.message=='Failed')
//       {
//          alert('Some Error happened during processing...'); 
//
//       }
//       else
//       {
       fnget_Templates();
       $('#new-template').val();
       $('#new-description').val();
       $('#mstatus_0').val();

//       }
              
            },
            error: function (err, result) {
//              $('#mupdate_close').prop("disabled",false);
//                alert("Error" + err.responseText);
            }
        });
        
    }
      }

       function createNewModules()
      {
       debugger;
       $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });
        
        var name=$('#module-name').text();
        var order=$('#module-order').text();
        var status=$('#modstatus').val();
        var templateid=$('#templateid').val();
        if(name.length == 0 || order.length == 0)
        {
          $('#errorbox-new-module').css('display','block');  
        }
        else
        {
         $('#errorbox-new-module').css('display','none');     
        var formdata = new FormData();
        formdata.append("name",name);
        formdata.append("order",order);
        formdata.append("status",status);
         formdata.append("template",templateid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/createnewmodules',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
       debugger;
//       if(data.message=='Failed')
//       {
//          alert('Some Error happened during processing...'); 
//
//       }
//       else
//       {
       fnget_Modules();
       $('#module-name').val();
       $('#module-order').val();
       $('#modstatus').val();

//       }
              
            },
            error: function (err, result) {
//              $('#mupdate_close').prop("disabled",false);
//                alert("Error" + err.responseText);
            }
        });
        
    }
      }





function gettemplatecheck()
{
    var checkbox = [];
    
    $(".form-control.tmplate:checked").each(function () {
     $('.form-control.tmplate').not(this).prop('checked', false);   
     checkbox.push($(this).attr("id").substring(4));
    });
   if(checkbox.length > 0)
   {
       
      checkbox=JSON.stringify( checkbox ); 
      $.get('/getmodules?checkedid='+checkbox,function(data){
          
          $('#divModules').html(data);
           $('#tbl_module_new').editableTableWidget();
      })
   }
   else
   {
       $('#divModules').html('');
   }
}

    
function selectchk(chkid)
{
   $('.form-control.tmplate').prop('checked', false); 
   $('#chk_'+chkid).prop('checked',true);
   $('#templateid').val(chkid);
   $('#qtntemplate').val(chkid);
   fnget_Modules();
   $('#divQuestions').html(''); 
   
    
}

function moduleselect(moduleid)
{
    debugger;
   $('.form-control.module').prop('checked', false); 
   $('#chkmodule_'+moduleid).prop('checked',true);
   $('#moduleid').val(moduleid);
   $('#templateid').val($('#qtntemplate').val());
   fnget_Questions();
    
}



function updatetemplate()
{
    var arr=[];
    var arrtemplate=[];
    var arrstatus=[];
    count=0;
    $("#editableTable tr").each(function() {
      if(count > 0)
      { arr.push(this.id);
        arrtemplate.push($('#template_'+this.id).text());
        arrstatus.push($('#tstatus_'+this.id).val());}
      count++;
   });
 if(arr.length > 0)
   {
       
      arr=JSON.stringify( arr ); 
      arrtemplate=JSON.stringify( arrtemplate );
      arrstatus=JSON.stringify( arrstatus );
      $.get('/updatetemplate?arr='+arr+'&arrtemplate='+arrtemplate+'&arrstatus='+arrstatus,function(data){
          
         fnget_Templates();
      })
   }
    
    
}




function updatemodules()
{
    debugger;
    var arr=[];
    var arrtemplate=[];
    var arrstatus=[];
    var arrorder=[];
    count=0;
    $("#editableTableModules tr").each(function() {
      if(count > 0)
      { arr.push(this.id);
        arrtemplate.push($('#module_'+this.id).text());
        arrstatus.push($('#modulestatus_'+this.id).val());
        arrorder.push($('#order_'+this.id).text());    
        }
      count++;
   });
 if(arr.length > 0)
   {
       
      arr=JSON.stringify( arr ); 
      arrtemplate=JSON.stringify( arrtemplate );
      arrstatus=JSON.stringify( arrstatus );
      arrorder=JSON.stringify( arrorder );
      $.get('/updatemodule?arr='+arr+'&arrtemplate='+arrtemplate+'&arrstatus='+arrstatus+'&arrorder='+arrorder,function(data){
          
         fnget_Modules();
      })
   }
    
    
}


function updatequestion()
{
    debugger;
    var arr=[];
    var arrtemplate=[];
    
    var arrorder=[];
    count=0;
    $("#editableTableQuestions tr").each(function() {
      if(count > 0)
      { arr.push(this.id);
        arrtemplate.push($('#question_'+this.id).text());
       
        arrorder.push($('#question-order_'+this.id).text());    
        }
      count++;
   });
 if(arr.length > 0)
   {
       
      arr=JSON.stringify( arr ); 
      arrtemplate=JSON.stringify( arrtemplate );
     
      arrorder=JSON.stringify( arrorder );
      $.get('/updatequestion?arr='+arr+'&arrtemplate='+arrtemplate+'&arrorder='+arrorder,function(data){
          
         fnget_Questions();
      })
   }
    
    
}



 function createNewQuestion()
      {
       debugger;
       $.ajaxSetup({
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
       });
        
        var name=$('#question-name').text();
        var order=$('#question-order').text();
       
        var templateid=$('#templateid').val();
        var moduleid=$('#moduleid').val();
        if(name.length == 0 || order.length == 0)
        {
          $('#errorbox-new-question').css('display','block');  
        }
        else
        {
         $('#errorbox-new-question').css('display','none');     
        var formdata = new FormData();
        formdata.append("name",name);
        formdata.append("order",order);
        
         formdata.append("template",templateid);
         formdata.append("module",moduleid);
        formdata.append("_token",'{{csrf_token()}}');

       $.ajax({
            url: '/createnewquestions',
            type: "POST",
            contentType: false,
            processData: false,
            data: formdata,
            cache: false,
            timeout: 100000,
            success: function (data) {
       debugger;
//       if(data.message=='Failed')
//       {
//          alert('Some Error happened during processing...'); 
//
//       }
//       else
//       {
       fnget_Questions();
       $('#question-name').val();
       $('#question-order').val();
       

//       }
              
            },
            error: function (err, result) {
//              $('#mupdate_close').prop("disabled",false);
//                alert("Error" + err.responseText);
            }
        });
        
    }
      }





      </script>

    @endsection