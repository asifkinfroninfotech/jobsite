<div class="table-scroll-popup">
    <table id="editableTable" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
        <thead>
           <tr>
              <th class="text-center"></th>
              <th>{{trans('dd_template.template_table_heading')}}</th>
              <th>{{trans('dd_template.status_table_heading')}}</th>
              <th>{{trans('dd_template.select_table_heading')}}</th>
           </tr>
        </thead>
        <tbody>
                
            @foreach($templates as $m)
        <tr id='{{$m->templateid}}'>
             <td class="text-center uneditable unhover">
             <input class="form-control tmplate" type="checkbox"  id="chk_{{$m->templateid}}" onclick="gettemplatecheck();" disabled >
             </td>
              <td tabindex="1" id="template_{{$m->templateid}}">{{$m->template}}</td>
        
              <td tabindex="1" class="text-center uneditable unhover">
                     <select class="form-control" id="tstatus_{{$m->templateid}}">
                    @foreach($statusvalues['value'] as $s)
                        @if ($s== $m->activestatus)
                          <option selected value='{{$s}}'>{{$s}}</option>
                        @else
                          <option value='{{$s}}'>{{$s}}</option>
                        @endif
                    @endforeach
    
                     </select>
        </td>
        
        <td tabindex="1" class="text-center uneditable unable-btn unhover">
            <button  class="btn btn-primary" type="button" id="btnSelectTemplate" onclick="selectchk('{{$m->templateid}}')"> {{trans('dd_template.template_select_btn_label')}}</button>
            
        </td>
           </tr>
           @endforeach
           
           
     
        </tbody>
     </table>
    
    </div>
    
    
    <button style="float:right;" class="btn btn-primary" type="button" id="btnDeleteTemplate" onclick="updatetemplate();"> {{trans('dd_template.template_save_btn_label')}}</button>
    <div class="alert alert-danger" role="alert" id="errorbox-delete" style="display:none;margin-top:10px;">
            {{trans('duediligenceprocess.modal_notchecked_module_delete')}}
    </div>
     <h6>
        {{trans('dd_template.template_heading_add_new')}}
    </h6>
    
    <table id="tbl_new" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
            <thead>
               <tr>
                  <th>{{trans('dd_template.template_label')}}</th>
                  <th>{{trans('dd_template.template_description_label')}}</th>
                  <th>{{trans('dd_template.template_status_label')}}</th>
               </tr>
            </thead>
            <tbody>
            <tr id="0">
             <td tabindex="1" id="new-template"></td>
             <td tabindex="1" id="new-description"></td>
             <td tabindex="1" class="text-center uneditable unhover">
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
               </tr>
            </tbody>
         </table>
   
         <button type="button" onclick="createNewTemplate();"  class="btn btn-success">{{trans('dd_template.template_create_btn')}}</button>
         <div class="alert alert-danger" role="alert" id="errorbox-new-template" style="display:none;margin-top:10px;">
          {{trans('dd_template.template_error')}}
        </div>