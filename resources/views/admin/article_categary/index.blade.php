@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/bootstrap-table.css') }}" rel="stylesheet">

<div>
    <div style="margin: 2px;">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">

                    <table
                            data-toggle="table"
                            data-search="true"
                            data-toolbar="#toolbar"
                            data-striped="true">
                        <thead>
                            <tr>
                                <th>名称</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $info)
                                <tr>
                                    <td>{{ $info->name }}</td>
                                    <td>
                                        <div class="btn-toolbar" role="toolbar">
                                            <a type="button" class="btn btn-default" href="#" data-href="{{ url("admin/articleCategary/delete/$info->id") }}" data-toggle="modal" data-target="#confirm-delete">删除</a>
                                            <a type="button" class="btn btn-default" href="{{ url("admin/articleCategary/edit/$info->id") }}">修改</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

</div>

    <div class="btn-toolbar" role="toolbar" id="toolbar">
        <a type="button" class="btn btn-default" href="{{ url('admin/articleCategary/add') }}">添加</a>
    </div>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                请确认
            </div>
            <div class="modal-body">
                确认删除该记录吗？
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a class="btn btn-danger btn-ok">删除记录</a>
            </div>
        </div>
    </div>
</div>

    <script src="{{ asset('js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('js/bootstrap-table-zh-CN.js') }}"></script>
    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>
@endsection