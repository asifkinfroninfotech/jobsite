<div class="element-box">

    <div class="table-responsive">
        <table width="100%" class="table table-striped table-lightfont">
            <thead>
                <tr>

                    <th>{{trans('tenant_page.table_name')}}</th>
                    <th>{{trans('tenant_page.table_title')}}</th>
                    <th>{{trans('tenant_page.table_activestatus')}}</th>
                    <th>{{trans('tenant_page.table_createddate')}}</th>
                    <th>{{trans('tenant_page.table_pagelink')}}</th>
                    <th>{{trans('tenant_page.table_action')}}</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>{{trans('tenant_page.table_name')}}</th>
                    <th>{{trans('tenant_page.table_title')}}</th>
                    <th>{{trans('tenant_page.table_activestatus')}}</th>
                    <th>{{trans('tenant_page.table_createddate')}}</th>
                    <th>{{trans('tenant_page.table_pagelink')}}</th>
                    <th>{{trans('tenant_page.table_action')}}</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach($datas as $data)

                @php

                $pagelink = \App\Helpers\AppGlobal::$App_Domain . '/tp/'.$data->slug.'/?tid='.$data->tenantid;
                @endphp

                <tr>




                    <td><span>{{$data->name}}</span></td>
                    <td><span>{{$data->title}}</span></td>
                    <td><span>{{$data->activestatus}}</span></td>
                    <td><span>{{date('d-M-Y',strtotime($data->createddate))}}</span></td>
                    <td><a href="{{$pagelink}}"><span>{{trans('tenant_page.table_pagelink')}}</span></a></td>





                    <td>




                        <div class="btn-group mr-1 mb-1 show">

                            <button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle"
                                data-toggle="dropdown" id="dropdownMenuButton1" type="button">{{trans('tenant_page.table_action')}}</button>
                            <div aria-labelledby="dropdownMenuButton1" class="dropdown-menu" x-placement="bottom-start"
                                style="position: absolute; transform: translate3d(0px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <a class="dropdown-item" href="/tenant/edit_tenant?pid={{$data->pageid}}">{{trans('tenant_page.table_page_edit')}}</a>
                                <a class="dropdown-item" href="/tenant/deletepage?tid={{$data->pageid}}">{{trans('tenant_page.table_page_delete')}}</a></div>
                        </div>



                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{ $datas->links('tenants.pages.page_pagination') }}