<style>


</style>
<div class="table-scroll-popup">
<table id="editableTable" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
    <thead>
       <tr>
          <th class="text-center"><input class="form-control" type="checkbox" id="chk_select_all"></th>
          <th>Module Name</th>
          <th>Module Status</th>
          <th>Display Order</th>
       </tr>
    </thead>
    <tbody>
            
        @foreach($lstmodules as $m)
    <tr id='{{$m->moduleid}}'>
         <td class="text-center uneditable">
         <input class="form-control" type="checkbox" id="chk_{{$m->moduleid}}">
         </td>
          <td tabindex="1" id="mname_{{$m->moduleid}}">{{$m->modulename}}</td>
    <td tabindex="1" class="text-center uneditable">
                 <select class="form-control" id="mstatus_{{$m->moduleid}}">
                @foreach($statusvalues['value'] as $s)
                    @if ($s== $m->modulestatus)
                         <option selected value='{{$s}}'>{{$s}}</option>
                    @else
                      <option value='{{$s}}'>{{$s}}</option>
                    @endif
                @endforeach

                 </select>
    </td>
   <td tabindex="1" id="mdisplayorder_{{$m->moduleid}}">{{$m->displayorder}}</td>
       </tr>
       @endforeach
       
       
 
    </tbody>
 </table>

</div>

 {{-- {{ $lstmodules->links('duediligence.process.process_pagination') }} --}}

{{-- <button type="button" class="btn btn-success">{{trans('duediligenceprocess.modulelist_modal_btnselectunselectall_caption')}}</button> --}}
<button class="btn btn-primary" type="button" id="btnDeleteModule" onclick="fnDeleteSelectedModules();"> {{trans('duediligenceprocess.modulelist_modal_btndelete_caption')}}</button>
<div class="alert alert-danger" role="alert" id="errorbox-delete" style="display:none;margin-top:10px;">
        {{trans('duediligenceprocess.modal_notchecked_module_delete')}}
</div>


 <table id="tbl_new" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
        <thead>
           <tr>
              <th>Module Name</th>
              <th>Module Status</th>
              <th>Display Order</th>
           </tr>
        </thead>
        <tbody>
        <tr id="0">
              <td tabindex="1" id="new-m"></td>
        <td tabindex="1" class="text-center uneditable">
                     <select class="form-control" id="mstatus_0">
                    @foreach($statusvalues['value'] as $s)
                        @if ($s== 'Active')
                             <option selected value='{{$s}}'>{{$s}}</option>
                        @else
                          <option value='{{$s}}'>{{$s}}</option>
                        @endif
                    @endforeach
                     </select>
        </td>
       <td tabindex="1" id="new-displayorder">0</td>
           </tr>
        </tbody>
     </table>

     <button type="button"  class="btn btn-success" onclick="fnAddNewModule();" >{{trans('duediligenceprocess.modulelist_modal_btnaddnew_caption')}}</button>
     <div class="alert alert-danger" role="alert" id="errorbox-new-module" style="display:none;margin-top:10px;">
            {{trans('duediligenceprocess.modal_onblank_module_name_error')}}
    </div>