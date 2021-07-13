@extends('install::layouts.master')

@section('content')
    <div id="app">
        <main class="el-main">
            <div class="center">
                <div class="steps">
                    <el-steps :active="4" align-center>
                        <el-step title="许可协议"></el-step>
                        <el-step title="环境检测"></el-step>
                        <el-step title="数据存储"></el-step>
                        <el-step title="管理员设置"></el-step>
                        <el-step title="安装完成"></el-step>
                    </el-steps>
                </div>
                <div class="content">
                    <el-form :model="form" :rules="rules" ref="form" size="medium" label-width="100px">
						<div class="sub-title">管理员账号设置</div>
                        <div style="padding-top: 10px">
                            <el-form-item label="用户名" prop="username" style="width: 60%">
								<el-input v-model="form.username" placeholder="请输入管理员用户名"></el-input>
							</el-form-item>
							<el-form-item label="密码" prop="password" style="width: 60%">
								<el-input type="password" v-model="form.password" placeholder="请输入管理员密码"></el-input>
							</el-form-item>
							<el-form-item label="确认密码" prop="password2" style="width: 60%">
								<el-input type="password" v-model="form.password2" placeholder="请再次输入管理员密码"></el-input>
							</el-form-item>
                        </div>
                    </el-form>
                </div>
                <div class="footer">
                    <el-button size="medium" @click="before">上一步</el-button>
                    <el-button type="primary" size="medium" :disabled="disabled" :loading="loading" @click="check">
                        @{{ loading ? '安装中，请稍候...' : '开始安装' }}
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
                    form: {
                        username: '',
                        password: '',
                        password2: '',
                    },
                    rules: {
                        username: [{ required: true, message: '请输入管理员用户名', trigger: 'blur' }],
                        password: [{ required: true, message: '请输入管理员密码', trigger: 'blur' }],
                        password2: [{
                            required: true, trigger: 'blur', validator: (rule, value, callback) => {
                                if (this.form.password != value) {
                                    callback(new Error('两次输入的密码不一致'))
                                } else {
                                    callback()
                                }
                            }
                        }]
                    }
                }
            },
            computed: {
                disabled () {
                    if (this.form.username && this.form.password && this.form.password2
                        && this.form.password == this.form.password2) {
                        return false
                    }
                    return true
                }
            },
            methods: {
                install (form) {
                    form.username = this.form.username
                    form.password = this.form.password

                    axios.post('{{ url('/install/submit') }}', form)
                        .then(res => {
                            if (!res.data.code) {
                                window.location.href="/install/step5"
                            } else {
                                ELEMENT.Message.error(res.data.msg || '未知错误')
                            }
                        })
                        .finally(() => {
                            this.loading = false
                        });
                },
                check () {
                    this.$refs.form.validate((valid) => {
                        if (valid) {
                            this.loading = true
                            const form = JSON.parse(localStorage.getItem('storage'))
                            axios.post('{{ url('/install/check') }}', form)
                                .then(res => {
                                    if (!res.data.code) {
                                        this.install(form)
                                    } else {
                                        ELEMENT.MessageBox.confirm(
                                            '已存在同名的数据库，继续安装将会清空当前数据库，是否继续安装?',
                                            '警告'
                                        ).then(() => {
                                            this.install(form)
                                        }).catch(() => {
                                            this.loading = false
                                        });
                                    }
                                })
                                .finally(() => {});
                        }
                    })
                },
                before () {
                    window.location.href="/install/step3"
                }
            }
        })
    </script>
@endsection
