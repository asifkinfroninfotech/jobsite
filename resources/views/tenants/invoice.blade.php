@section('content')
@extends('tenants.layouts.app_layout', ['layout' => 'left_side_menu_tenant'])
<div class="layout-w">
    <div class="content-w portfolio-custom-vk">
        @include('tenants.shared._top_menu_tenant')


        <div class="content-i control-panel">
            <div class="content-box">

                <div class="os-tabs-w">
                    <div class="os-tabs-controls">
                        <ul class="nav nav-tabs upper">
                            <li class="nav-item">
                                <a aria-expanded="false" class="nav-link" href="/tenant/account/subscription">Subscription</a>
                            </li>
                            <li class="nav-item">
                                <a aria-expanded="false" class="nav-link" href="/tenant/account/paymentmethod">Payment
                                    Method</a>
                            </li>
                            <li class="nav-item">
                                <a aria-expanded="false" class="nav-link active" href="/tenant/account/invoice">
                                    Invoice</a>
                            </li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>



        <style>
            .inv-vh {
                height: 58vh;
            }

        </style>


        <div class="content-i">
            <div class="content-box inv-vh">
                <div class="element-wrapper">
                    <div class="element-box">
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Amount</th>


                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Invoice Number</th>
                                        <th>Invoice Date</th>
                                        <th>Amount</th>

                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if(isset($invoices) && !empty($invoices) && count($invoices)>0)
                                    @foreach($invoices as $invoice)

                                    <tr>
                                        <td>
                                            <!-- <span><a href="/tenant/invoice/?invoiceid={{ $invoice->id }}">{{ $invoice->number }}</a></span> -->


                                            <span>{{ $invoice->number }}</span>

                                        </td>

                                        <td>
                                            <span>{{ $invoice->date()->toFormattedDateString() }}</span>

                                        </td>
                                        <td>
                                            <span>{{ $invoice->total() }}</span>

                                        </td>



                                    </tr>

                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

{{-- @section('scripts')
<script>
    var current = $('input[name=optionsRadios]:checked').val();

    function update(plan) {

        if (current != plan) {
            debugger;
            $.get('/changeplan?plan=' + plan, function (data) {

                location.reload();
            });

        }
    }

</script>

@endsection --}}
