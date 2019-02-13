@section('content')
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
                            {!!trans('tenant_import.help_title')!!}
                        </h5>
                        <div class="form-desc">
                            {!!trans('tenant_import.help_content')!!}
                        </div>
                        <div class="element-box-content example-content">
                            <button class="mr-2 mb-2 btn btn-link" type="button" onclick='hidehelp();'>
                                {{trans('tenant_import.help_btn_hide_caption')}}</button>
                        </div>
                    </div>
                </div>
                @endif
                <div class="element-wrapper">
                    <h6 class="element-header">
                        Import Companies
                    </h6>
                    <div class="element-box-tp">
                        <div class="">

                            <form style="display: flex; justify-content: space-between; align-items: center;  border: 1px solid #ddd;
                                    padding: 0 9px 0 0;"
                                action="{{ url('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}



                                <div style="padding: 10px;">


                                    <input type="file" name="import_file" />
                                </div>

                                <button class="btn btn-primary">Import File</button>

                            </form>

                            <div class="btn-wrapper" style="   padding: 60px 0px;">
                                <a class="btn btn-primary" href="/exceltemplate/template.xls">Download Template</a>



                            </div>
                        </div>
                        <br />
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                        @if (Session::has('emailexist'))
                        <div class="alert alert-danger">

                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>



                            @foreach(session('emailexist') as $sess)
                            <li>{{$sess}}</li>
                            @endforeach
                        </div>
                        @endif




                        @if (Session::has('success'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                            <p>{{ Session::get('success') }}</p>
                        </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>





@endsection


@section('scripts')

<script>





</script>
@endsection