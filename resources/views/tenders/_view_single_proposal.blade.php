@php
$helper=\App\Helpers\AppHelper::instance();
$symbol='';
if(isset($proposaldata->symbol) && !empty($proposaldata->symbol) )
{
$symbol=$proposaldata->symbol;
}
else {
$symbol=\App\Helpers\AppGlobal::$Default_Currency_Symbol;
}
@endphp


<h6 class="element-header">
{{trans('my_tender.bid_detail_proposal_heading_caption')}} ({{$proposaldata->company}})
</h6>

<div class="project-box marbtm">


    <div class="modal-body" id="tenderedit">

        <div class="row invst-pfl">

            @if(isset($proposaldata->proposal_heading) && !empty($proposaldata->proposal_heading))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_detail_proposal_heading')}}</div>
                <h5>{{$proposaldata->proposal_heading}}</h5>
            </div>
            @endif

            @if(isset($proposaldata->desired_time_frame) && !empty($proposaldata->desired_time_frame))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_detail_desired_time_frame')}}</div>
                <h5>{{$proposaldata->desired_time_frame}}</h5>
            </div>
            @endif




        </div>



        <div class="row invst-pfl">

            @if(isset($proposaldata->quoteamount) && $proposaldata->quoteamount>0)
            <div class="col-sm-4">
                <div class="label">{{trans('my_tender.popup_bid_quote_amount')}}</div>
                <h5>{{$symbol.$proposaldata->quoteamount}}</h5>
            </div>
            @endif


            @if(isset($proposaldata->proposalstate) && !empty($proposaldata->proposalstate))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_detail_proposal_state')}}</div>
                <h5>{{$proposaldata->proposalstate}}</h5>
            </div>
            @endif



            @if(isset($proposaldata->file1) && !empty($proposaldata->file1))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_file_uploaded')}}</div>
                <a href="/storage/tender/proposal/{{$proposaldata->file1}}" target="_blank">{{$proposaldata->file1}}</a>
            </div>
            @endif



        </div>



        <div class="row invst-pfl">
            @if(isset($proposaldata->date_accepted) && !empty($proposaldata->date_accepted))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_date_accepted')}}</div>
                <h5>{{date('d M Y',strtotime($proposaldata->date_accepted))}}</h5>
            </div>
            @endif
            @if(isset($proposaldata->people_involved) && !empty($proposaldata->people_involved))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_people_involved')}}</div>
                <h5>{{$proposaldata->people_involved}}</h5>
            </div>
            @endif
            @if(isset($proposaldata->duration_to_complete) && !empty($proposaldata->duration_to_complete))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_duration_to_complete')}}</div>
                <h5>{{$proposaldata->duration_to_complete}}</h5>
            </div>
            @endif

        </div>


        <div class="row invst-pfl">

            @if(isset($proposaldata->short_description) && !empty($proposaldata->short_description))
            <div class="col-sm-12">

                <div class="label">{{trans('my_tender.popup_bid_short_description')}}</div>
                <p>{{$proposaldata->short_description}}</p>
            </div>
            @endif
            @if(isset($proposaldata->why_consider_you) && !empty($proposaldata->why_consider_you))
            <div class="col-sm-12">

                <div class="label">{{trans('my_tender.popup_bid_why_consider_you')}}</div>
                <p>{{$proposaldata->why_consider_you}}</p>
            </div>
            @endif

        </div>

        <div class="row invst-pfl">
            @if(isset($proposaldata->additional_info) && !empty($proposaldata->additional_info))
            <div class="col-sm-12">

                <div class="label">{{trans('my_tender.popup_bid_additional_info')}}</div>
                <p>{{$proposaldata->additional_info}}</p>
            </div>
            @endif


        </div>

        @if(isset($proposaldata->is_submitted) && !empty($proposaldata->is_submitted))
        <div class="row invst-pfl">
            
            <div class="col-sm-4">
                <div class="label">{{trans('my_tender.popup_bid_proposal_submitted')}}</div>
                <h5>{{($proposaldata->is_submitted==0)?'No':'Yes'}}</h5>
            </div>
           
            @if(isset($proposaldata->date_submitted) && !empty($proposaldata->date_submitted))
            <div class="col-sm-4">

                <div class="label">{{trans('my_tender.popup_bid_date_submitted')}}</div>
                <h5>{{date('d M Y',strtotime($proposaldata->date_submitted))}}</h5>
            </div>
            @endif
        </div>
        @endif








    </div>
