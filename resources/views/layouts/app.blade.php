<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->

    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-treeview.css') }}" rel="stylesheet">
    <style>
        .left{
            margin-left:0px;
            position: absolute;
            box-sizing: border-box;
            width: 200px;
            height: 100%;
        }
        .right{
            box-sizing: border-box;
            float: left;
            box-sizing: border-box;
            padding-left: 200px;
            clear: both;
            min-width: 100%;
            min-height: 500px;
        }
    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-2.1.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/bootstrap-treeview.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @auth
                        <li><a href="{{ url('admin/user/index') }}">管理员列表</a></li>
                        <li><a href="#">角色列表</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                文章相关 <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li >
                                    <a href="{{ url('admin/article/index') }}">
                                        文章列表
                                    </a>
                                </li>
                                <li >
                                    <a href="{{ url('admin/articleCategary/index') }}">
                                        文章分类
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row-fluid">
                @auth
                <div id="left" class="left">
                    <div id="tree"></div>
                </div>
                @endauth
                <div id="right" class="tab-content right">
                    <ol class="breadcrumb">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Library</a></li>
                        <li class="active">Data</li>
                    </ol>

                    @if (Session::get('message'))
                        @component('alert')
                            @slot('status')
                                {{ Session::get('message.alert_style') }}
                            @endslot
                            {{ Session::get('message.alert_msg') }}
                        @endcomponent
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>

    </div>

    <script>
        var defaultData = [
            {
                text: 'Parent 1',
                href: '#parent1',
                tags: ['4'],
                nodes: [
                    {
                        text: 'Child 1',
                        href: '#child1',
                        tags: ['2'],
                        nodes: [
                            {
                                text: 'Grandchild 1',
                                href: '#grandchild1',
                                tags: ['0']
                            },
                            {
                                text: 'Grandchild 2',
                                href: '#grandchild2',
                                tags: ['0']
                            }
                        ]
                    },
                    {
                        text: 'Child 2',
                        href: '#child2',
                        tags: ['0']
                    }
                ]
            },
            {
                text: 'Parent 2',
                href: '#parent2',
                tags: ['0']
            },
            {
                text: 'Parent 3',
                href: '#parent3',
                tags: ['0']
            },
            {
                text: 'Parent 4',
                href: '#parent4',
                tags: ['0']
            },
            {
                text: 'Parent 5',
                href: '#parent5'  ,
                tags: ['0']
            }
        ];

        $('#tree').treeview({
            data: defaultData
        });
    </script>
</body>
</html>
