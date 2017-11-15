@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/bootstrap-table.css') }}" rel="stylesheet">

<div>
    <div style="margin: 2px;">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>


                        <form id="formSearch" class="form-horizontal" method="get" action="{{ url('admin/article/index') }}">
                            <div class="form-group" style="margin-top:15px">
                                <label class="control-label col-sm-1" for="cate_id">分类</label>
                                <div class="col-sm-3">
                                    {!! $cateAll !!}
                                </div>
                                <label class="control-label col-sm-1" for="title">标题</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $seachParams['title'] }}">
                                </div>
                                <div class="col-sm-4" style="text-align:left;">
                                    <button type="submit" style="margin-left:50px" id="btn_query" class="btn btn-primary">查询</button>
                                </div>
                            </div>
                        </form>


                <div class="panel-body">

                    <table
                            data-toggle="table"
                            data-toolbar="#toolbar"
                            data-striped="true">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>标题</th>
                                <th>分类</th>
                                <th>标签</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $info)
                                <tr>
                                    <td>{{ $info->id }}</td>
                                    <td>{{ $info->title }}</td>
                                    <td>{{ $info->cate_id }}</td>
                                    <td>{{ $info->lable_id }}</td>
                                    <td>{{ $info->created_at }}</td>
                                    <td>
                                        <div class="btn-toolbar" role="toolbar">
                                            <a type="button" class="btn btn-default" href="#" data-href="{{ url("admin/article/delete/$info->id") }}" data-toggle="modal" data-target="#confirm-delete">删除</a>
                                            <a type="button" class="btn btn-default" href="{{ url("admin/article/edit/$info->id") }}">修改</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li>
                                <a href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li>
                                <a href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>

</div>

    <div class="btn-toolbar" role="toolbar" id="toolbar">
        <a type="button" class="btn btn-default" href="{{ url('admin/article/add') }}">添加</a>
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