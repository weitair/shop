@extends('install::layouts.master')

@section('content')
    <style>
        .center {
            padding: 0px !important;
        }
        .top {
            height: 50%;
            background: #2589FF;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .bottom {
            height: 50%;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .title {
            color: #fff;
            padding: 20px;
            font-weight: 600;
            font-size: 20px;
        }
        .intro {
            color: #fff;
            font-size: 14px;
        }
    </style>
    <div id="app">
        <main class="el-main">
            <div class="center">
                <div class="top">
                    <i class="el-icon-success" style="font-size: 60px; color: #fff;"></i>
                    <div class="title">恭喜您，已成功安装微态尔商城</div>
                    <div class="intro">建议您先删除系统中的安装模块后再使用</div>
                </div>
                <div class="bottom">
                    <el-button type="primary" size="medium" @click="admin">
                        进入系统后台
                    </el-button>
                </div>
            </div>
        </main>
    </div>
    <script>
        new Vue({
            el: '#app',
            methods: {
                admin () {
                    window.location.href="/"
                }
            }
        })
    </script>
@endsection
