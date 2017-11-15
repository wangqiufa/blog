@extends('layouts.app')

@section('content')

<div>

    <div style="margin: 2px;">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('admin/articleCategary/editDo') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $info->id }}">

                        <div class="form-group">
                            <label for="pid" class="col-md-4 control-label">上级分类</label>

                            <div class="col-md-6">
                                {!! $cateAll !!}
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">分类名称</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ $info->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort" class="col-md-4 control-label">排序</label>

                            <div class="col-md-6">
                                <input id="sort" type="text" class="form-control" name="sort" value="{{ $info->sort }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    修 改
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection