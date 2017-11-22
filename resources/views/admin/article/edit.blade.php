@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/prettify.css') }}" rel="stylesheet">
    <link href="{{ asset('css/wysiwyg.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.file-input.css') }}" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <style>
        .image-preview-input {
            position: relative;
            overflow: hidden;
            margin: 0px;
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }
        .image-preview-input input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
        .image-preview-input-title {
            margin-left:2px;
        }
    </style>

<div>

    <div style="margin: 2px;">
        <div>
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" onsubmit="beforeSubmit()" action="{{ url('admin/article/editDo') }}">
                        {{ csrf_field() }}
                        <input id="content" name="content" type="hidden" value="">
                        <input id="title_img" name="title_img" type="hidden" value="{{ $info->title_img }}">
                        <input type="hidden" name="id" value="{{ $info->id }}">

                        <div class="form-group">
                            <label for="pid" class="col-md-4 control-label">分类</label>

                            <div class="col-md-6">
                                {!! $cateAll !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lable_id" class="col-md-4 control-label">标签</label>

                            <div class="col-md-6">
                                <select name='lable_id' class='form-control'>
                                    @foreach ($lableList as $lable)
                                        <option value="{{ $lable->id }}" @if ($lable->id == $info->lable_id) selected @endif>
                                            {{ $lable->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">标题</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $info->title }}" required>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('title_img') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">缩略图</label>

                            <div class="col-md-6">

                                <p><input type="file" id="file1" name="picture" class="custom-file-input" /></p>
                                <button class="btn btn-success fileinput-button" id="upload_buttom" type="button">上传</button>
                                <p><img id="img1" src="{{ $info->title_img }}" /></p>

                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-md-4 control-label">描述</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" rows="3" name="description" required>{{ $info->description }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">内容</label>

                            <div class="col-md-12">

                                <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
                                    <div class="btn-group">
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                            <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
                                            <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
                                            <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
                                        </ul>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
                                        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
                                        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
                                        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
                                        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
                                        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
                                        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
                                        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
                                        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
                                        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
                                        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

                                    </div>

                                    <div class="btn-group">
                                        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn">
                                            <i class="icon-picture"></i></a>
                                        <input type="file" id="pictureInput" name="picture" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" action="{{ url('upload/img') }}" />
                                    </div>
                                    <div class="btn-group">
                                        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
                                        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
                                    </div>
                                    <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
                                </div>

                                <div id="editor" style="overflow:scroll; max-height:300px; min-height: 100px;">
                                    {!! $info->content !!}
                                </div>
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

<script src="{{ asset('js/ajaxfileupload.js') }}"></script>
<script src="{{ asset('js/bootstrap-wysiwyg.js') }}"></script>
<script src="{{ asset('js/jquery.hotkeys.js') }}"></script>
<script src="{{ asset('js/prettify.js') }}"></script>
<script src="{{ asset('js/bootstrap.file-input.js') }}"></script>

    <script>
        $(function(){
            function initToolbarBootstrapBindings() {
                var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
                        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                        'Times New Roman', 'Verdana'],
                    fontTarget = $('[title=Font]').siblings('.dropdown-menu');
                $.each(fonts, function (idx, fontName) {
                    fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
                });
                $('a[title]').tooltip({container:'body'});
                $('.dropdown-menu input').click(function() {return false;})
                    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
                    .keydown('esc', function () {this.value='';$(this).change();});

                $('[data-role=magic-overlay]').each(function () {
                    var overlay = $(this), target = $(overlay.data('target'));
                    overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
                });
                if ("onwebkitspeechchange"  in document.createElement("input")) {
                    var editorOffset = $('#editor').offset();
                    $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
                } else {
                    $('#voiceBtn').hide();
                }
            };
            function showErrorAlert (reason, detail) {
                var msg='';
                if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
                else {
                    console.log("error uploading file", reason, detail);
                }
                $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
                    '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
            };
            initToolbarBootstrapBindings();
            $('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
            window.prettyPrint && prettyPrint();
        });

        function beforeSubmit() {
            var editorHtml = $('#editor').html();
            $('#content').val(editorHtml);
        }

        $(function () {
            $("#upload_buttom").click(function () {
                ajaxFileUpload();
            })
        })
        function ajaxFileUpload() {
            $.ajaxFileUpload
            (
                {
                    url: "{{ url('upload/img') }}", //用于文件上传的服务器端请求地址
                    secureuri: false, //是否需要安全协议，一般设置为false
                    fileElementId: 'file1', //文件上传域的ID
                    dataType: 'json', //返回值类型 一般设置为json
                    data: {pathName : 'article_title'},
                    success: function (data, status)  //服务器成功响应处理函数
                    {
                        $("#img1").attr("src", data.imgsrc);
                        $("#title_img").val(data.imgsrc);
                    },
                    error: function (data, status, e)//服务器响应失败处理函数
                    {
                        alert(e);
                    }
                }
            )
            return false;
        }

    </script>

@endsection