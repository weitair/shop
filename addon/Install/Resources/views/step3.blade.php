@extends('install::layouts.master')

@section('content')
    <div id="app">
        <main class="el-main">
            <div class="center">
                <div class="steps">
                    <el-steps :active="3" align-center>
                        <el-step title="许可协议"></el-step>
                        <el-step title="环境检测"></el-step>
                        <el-step title="数据存储"></el-step>
                        <el-step title="管理员设置"></el-step>
                        <el-step title="安装完成"></el-step>
                    </el-steps>
                </div>
                <div class="content">
                    <el-form :model="form" :rules="rules" ref="form" size="medium" label-width="100px">
                        <div class="sub-title">MySql设置</div>
                        <div style="padding-top: 10px">
                            <el-form-item label="数据库编码">
                                utf8mb4
                            </el-form-item>
                            <el-form-item label="数据库主机" prop="dbhost" style="width: 60%">
                                <el-input v-model="form.dbhost" placeholder="请输入主机名或IP地址"></el-input>
                            </el-form-item>
                            <el-form-item label="数据库端口" prop="dbport" style="width: 60%">
                                <el-input v-model="form.dbport" placeholder="请输入数据库端口"></el-input>
                            </el-form-item>
                            <el-form-item label="数据库名称" prop="dbname" style="width: 60%">
                                <el-input v-model="form.dbname" placeholder="请输入数据库名称"></el-input>
                            </el-form-item>
                            <el-form-item label="用户名" prop="dbuser" style="width: 60%">
                                <el-input v-model="form.dbuser" placeholder="请输入数据库用户名(通常为：root)"></el-input>
                            </el-form-item>
                            <el-form-item label="密码" prop="dbpassword" style="width: 60%">
                                <el-input v-model="form.dbpassword" placeholder="请输入数据库用户密码"></el-input>
                            </el-form-item>
                            <el-form-item>
                                <el-button :loading="testLoading" size="mini" @click="test">测试连接</el-button>
                            </el-form-item>
                        </div>

                        <div class="sub-title">Redis设置</div>
                        <div style="padding-top: 10px">
                            <el-form-item label="Redis主机" prop="redishost" style="width: 60%">
                                <el-input v-model="form.redishost" placeholder="请输入Redis主机名或IP地址"></el-input>
                            </el-form-item>
                            <el-form-item label="Redis端口" prop="redisport" style="width: 60%">
                                <el-input v-model="form.redisport" placeholder="请输入Redis端口"></el-input>
                            </el-form-item>
                            <el-form-item label="Redis密码" prop="redispassword" style="width: 60%">
                                <el-input v-model="form.redispassword" placeholder="没有密码请留空"></el-input>
                            </el-form-item>
                        </div>
                    </el-form>
                </div>
                <div class="footer">
                    <el-button size="medium" @click="before">上一步</el-button>
                    <el-button :loading="loading" type="primary" size="medium" :disabled="disabled" @click="next">
                        下一步
                    </el-button>
                </div>
            </div>
        </main>
    </div>
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    loading: false,
                    testLoading: false,
                    form: {
                        dbhost: '127.0.0.1',
                        dbport: '3306',
                        dbname: 'weitair_shop',
                        dbuser: '',
                        dbpassword: '',
                        redishost: '127.0.0.1',
                        redisport: '6379',
                        redispassword: '',
                    },
                    rules: {
                        dbhost: [{ required: true, message: '请输入主机名或IP地址', trigger: 'blur' }],
                        dbport: [{ required: true, message: '请输入数据库端口', trigger: 'blur' }],
                        dbname: [{ required: true, message: '请输入数据库名称', trigger: 'blur' }],
                        dbuser: [{ required: true, message: '请输入数据库用户名', trigger: 'blur' }],
                        dbpassword: [{ required: true, message: '请输入数据库用户密码', trigger: 'blur' }],
                        redishost: [{ required: true, message: '请输入Redis主机名或IP地址', trigger: 'blur' }],
                        redisport: [{ required: true, message: '请输入Redis端口', trigger: 'blur' }],
                    }
                }
            },
            computed: {
                disabled () {
                    if (this.form.dbhost && this.form.dbport && this.form.dbname && this.form.dbuser && this.form.dbpassword
                    && this.form.redishost && this.form.redisport) {
                        return false
                    }
                    return true
                }
            },
            methods: {
                test () {
                    this.$refs.form.validate((valid) => {
                        if (valid) {
                            this.testLoading = true
                            axios.post('{{ url('/install/test') }}', this.form)
                                .then(res => {
                                    if (!res.data.code) {
                                        ELEMENT.Message.success("数据库连接成功")
                                    } else {
                                        ELEMENT.Message.error("数据库连接失败，请检查配置参数")
                                    }
                                })
                                .finally(() => {
                                    this.testLoading = false
                                });
                        }
                    })
                },
                before () {
                    window.location.href="/install/step2"
                },
                next () {
                    this.$refs.form.validate((valid) => {
                        if (valid) {
                            this.loading = true
                            axios.post('{{ url('/install/test') }}', this.form)
                                .then(res => {
                                    if (!res.data.code) {
                                        localStorage.setItem('storage', JSON.stringify(this.form))
                                        window.location.href="/install/step4"
                                    } else {
                                        ELEMENT.Message.error("数据库连接失败，请检查配置参数")
                                    }
                                })
                                .finally(() => {
                                    this.loading = false
                                });
                        }
                    })
                }
            }
        })
    </script>
@endsection
