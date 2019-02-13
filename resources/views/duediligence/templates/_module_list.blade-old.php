<div class="table-scroll-popup">
    <table id="editableTableModules" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
        <thead>
           <tr>
              <th class="text-center"></th>
              <th>{{trans('dd_template.modulename_table')}}</th>
              <th>{{trans('dd_template.moduleorder_table')}}</th>
              <th>{{trans('dd_template.modulestatus_table')}}</th>
              <th>{{trans('dd_template.moduleselect_table')}}</th>
           </tr>
        </thead>
        <tbody>
                
            @foreach($moduleslist as $m)
        <tr id='{{$m->moduleid}}'>
             <td class="text-center uneditable unhover">
             <input class="form-control module" type="checkbox" id="chkmodule_{{$m->moduleid}}" disabled>
             </td>
              <td tabindex="1" id="module_{{$m->moduleid}}">{{$m->modulename}}</td>
              <td tabindex="1" id="order_{{$m->moduleid}}">{{$m->displayorder}}</td>
        
              <td tabindex="1" class="text-center uneditable unhover">
                     <select class="form-control" id="modulestatus_{{$m->moduleid}}">
                    @foreach($statusvalues['value'] as $s)
                        @if ($s== $m->modulestatus)
                          <option selected value='{{$s}}'>{{$s}}</option>
                        @else
                          <option value='{{$s}}'>{{$s}}</option>
                        @endif
                    @endforeach
    
                     </select>
        </td>
        <td tabindex="1" class="text-center uneditable unable-btn unhover">
            <button  class="btn btn-primary" type="button" id="btnSelectModules" onclick="moduleselect('{{$m->moduleid}}')">{{trans('dd_template.moduleselect_table_btn')}}</button>
            
        </td>
           </tr>
           @endforeach
           
           
     
        </tbody>
     </table>
    
    </div>
    
    
    <button style="float:right;" class="btn btn-primary" type="button" id="btnDeleteTemplate" onclick="updatemodules();"> {{trans('dd_template.module_save_btn')}}</button>
    <div class="alert alert-danger" role="alert" id="errorbox-delete" style="display:none;margin-top:10px;">
            {{trans('dd_template.template_error')}}
    </div>
       <h6 >
                        Add New Module
                    </h6>
    <table id="tbl_module_new" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
            <thead>
               <tr>
                  <th>{{trans('dd_template.module_name_label')}}</th>
                  <th>{{trans('dd_template.module_order_label')}}</th>
                  <th>{{trans('dd_template.module_status_label')}}</th>
               </tr>
            </thead>
            <tbody>
            <tr id="0">
             <td tabindex="1" id="module-name"></td>
             <td tabindex="1" id="module-order"></td>
             <td tabindex="1" class="text-center uneditable unhover">
                         <select class="form-control" id="modstatus">
                        @foreach($statusvalues['value'] as $s)
                            @if ($s== 'Active')
                                 <option selected value='{{$s}}'>{{$s}}</option>
                            @else
                              <option value='{{$s}}'>{{$s}}</option>
                            @endif
                        @endforeach
                         </select>
            </td>
               </tr>
            </tbody>
         </table>
   
         <button type="button" onclick="createNewModules();"  class="btn btn-success">{{trans('dd_template.btn_module_create')}}</button>
         <div class="alert alert-danger" role="alert" id="errorbox-new-module" style="display:none;margin-top:10px;">
                {{trans('dd_template.template_error')}}
        </div>