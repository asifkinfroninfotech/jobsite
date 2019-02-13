<div id="divquestiontemplate">
    <div class="table-scroll-popup" style="max-height: 100%;">
        <table id="editableTableQuestions" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
            <thead>
                <tr>
                    {{-- <th class="text-center"></th> --}}
                    <th width="150">{{trans('dd_template.table_question_name')}}</th>
                    <th width="500">{{trans('dd_template.table_question_order')}}</th>
                    <!--              <th>Select{{trans('dd_template.table_question_name')}}</th>-->
                </tr>
            </thead>
            <tbody>

                @foreach($questionlist as $q)
                <tr id='{{$q->questionid}}'>
                    {{-- <td class="text-center uneditable">
                        <input class="form-control module" type="checkbox" id="chkquestion_{{$q->questionid}}" disabled>
                    </td> --}}
                    <td tabindex="1" id="question_{{$q->questionid}}" style="width:75%;">{{$q->questiontext}}</td>
                    <td tabindex="1" id="question-order_{{$q->questionid}}">{{$q->displayorder}}</td>
                </tr>
                @endforeach



            </tbody>
        </table>

    </div>

    <div class="btn-addnw-row mt-4 mb-4">
        <button style="float:right;" class="btn btn-primary" type="button" id="btnDeleteTemplate" onclick="updatequestion();">
            {{trans('dd_template.question_btn_save')}}</button>
        <div class="alert alert-danger" role="alert" id="errorbox-delete" style="display:none;margin-top:10px;">
            {{trans('duediligenceprocess.modal_notchecked_module_delete')}}
        </div>




    </div>
</div>

<div id="div_question_new" style="display:none;">
    <h6>
        {{trans('dd_template.add_new_question_heading')}}
    </h6>

    <table id="tbl_question_new" class="table table-editable table-striped table-lightfont" style="cursor: pointer;">
        <thead>
            <tr>
                <th width="150">{{trans('dd_template.question_name_label')}}</th>
                <th width="500">{{trans('dd_template.order_label')}}</th>

            </tr>
        </thead>
        <tbody>
            <tr id="0">
                <td tabindex="1" id="question-name" style="width:75%;"></td>
                <td tabindex="1" id="question-order"></td>
                <td tabindex="1" class="text-center uneditable unhover">
                    <select class="form-control" id="mstatus_0" style="visibility: hidden;">
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

    <button type="button" onclick="createNewQuestion();" class="btn btn-success">{{trans('dd_template.question_create')}}</button>
    <button type="button" onclick="cancelbtn('questions');" class="btn btn-success">{{trans('dd_template.template_cancel_btn')}}</button>
    <div class="alert alert-danger" role="alert" id="errorbox-new-question" style="display:none;margin-top:10px;">
        {{trans('dd_template.question_error')}}
    </div>
</div>
