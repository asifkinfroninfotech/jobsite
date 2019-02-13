<div id="tablemodulediv">
    <div class="table-scroll-popup" style="max-height: 100%;">
        <table id="editableTableModules" class="table table-editable table-edit-custom-wdt table-striped table-lightfont"
            style="cursor: pointer;">
            <thead>
                <tr>
                    <th class="text-center" width="80"></th>
                    <th width="250">{{trans('dd_template.modulename_table')}}</th>
                    <th width="130">{{trans('dd_template.moduleorder_table')}}</th>
                    <th width="150">{{trans('dd_template.modulestatus_table')}}</th>
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
                        <button class="btn btn-primary" type="button" id="btnSelectModules" onclick="moduleselect('{{$m->moduleid}}')">{{trans('dd_template.moduleselect_table_btn')}}</button>

                    </td>
                </tr>
                @endforeach



            </tbody>
        </table>

    </div>

    <div class="btn-addnw-row mt-4 mb-4">
        <button style="float:right;" class="btn btn-primary" type="button" id="btnDeleteTemplate" onclick="updatemodules();">
            {{trans('dd_template.module_save_btn')}}</button>
        <div class="alert alert-danger" role="alert" id="errorbox-delete" style="display:none;margin-top:10px;">
            {{trans('dd_template.template_error')}}
        </div>



    </div>
</div>

<div id="tbl_new_module" style="display:none;">
    <h6>
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

    <button type="button" onclick="createNewModules();" class="btn btn-success">{{trans('dd_template.template_save_btn')}}</button>
    <button type="button" onclick="cancelbtn('modules');" class="btn btn-success">{{trans('dd_template.template_cancel_btn')}}</button>
    <div class="alert alert-danger" role="alert" id="errorbox-new-module" style="display:none;margin-top:10px;">
        {{trans('dd_template.module_error')}}
    </div>
</div>
