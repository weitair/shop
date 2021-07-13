@extends('install::layouts.master')

@section('content')
    <style>
        .content {
            border: none;
        }
        .error {
            color: #F56C6C;
        }
    </style>

    <div id="app">
        <main class="el-main">
            <div class="center">
                <div class="steps">
                    <el-steps :active="2" align-center>
                        <el-step title="许可协议"></el-step>
                        <el-step title="环境检测"></el-step>
                        <el-step title="数据存储"></el-step>
                        <el-step title="管理员设置"></el-step>
                        <el-step title="安装完成"></el-step>
                    </el-steps>
                </div>
                <div class="content">
                    <div class="sub-title">基本信息</div>
                    <el-table :data="base" :show-header="false">
                        <el-table-column width="150">
                            <template slot-scope="scope">
                                <span style="font-weight: 600">@{{ scope.row.name }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column prop="value"></el-table-column>
                    </el-table>
                    <div class="sub-title">环境检测</div>
                    <el-table :data="check" :show-header="false">
                        <el-table-column width="150">
                            <template slot-scope="scope">
                                <span style="font-weight: 600">@{{ scope.row.name }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column>
                            <template slot-scope="scope">
                                <div style="text-align: right">
                                    <span v-if="scope.row.value">通过</span>
                                    <span v-else class="error">@{{ scope.row.intro }}</span>
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>
                    <div class="sub-title">目录权限</div>
                    <el-table :data="dir" :show-header="false">
                        <el-table-column prop="name" width="150">
                            <template slot-scope="scope">
                                <span style="font-weight: 600">@{{ scope.row.name }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column>
                            <template slot-scope="scope">
                                <div style="text-align: right">
                                    <span v-if="scope.row.value">通过</span>
                                    <span v-else class="error">@{{ scope.row.intro }}</span>
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
                <div class="footer">
                    <el-button size="medium" @click="before">上一步</el-button>
                    <el-button type="primary" size="medium" :disabled="!pass" @click="next">下一步</el-button>
                </div>
            </div>
        </main>
    </div>
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    base: [],
                    check: [],
                    dir: [],
                    pass: false,
                    disabled: true
                }
            },
            mounted () {
                axios.get('{{ url('/install/detect') }}')
                    .then(res => {
                        if (!res.data.code) {
                            const { base, check, dir, pass} = res.data.data
                            this.base = base
                            this.check = check
                            this.dir = dir
                            this.pass = pass
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            methods: {
                before () {
                    window.location.href="/install"
                },
                next () {
                    window.location.href="/install/step3"
                }
            }
        })
    </script>
@endsection
