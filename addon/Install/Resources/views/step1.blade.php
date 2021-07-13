@extends('install::layouts.master')

@section('content')
    <div id="app">
        <main class="el-main">
            <div class="center">
                <div class="steps">
                    <el-steps :active="1" align-center>
                        <el-step title="许可协议"></el-step>
                        <el-step title="环境检测"></el-step>
                        <el-step title="数据存储"></el-step>
                        <el-step title="管理员设置"></el-step>
                        <el-step title="安装完成"></el-step>
                    </el-steps>
                </div>
                <div class="content">
                    <strong>©2018 贵州微态尔科技有限公司 版权所有</strong>
                    <p>
                        感谢您选择微态尔商城系统（以下简称微态尔商城），微态尔商城是由贵州微态尔科技有限公司（以下简称微态尔科技）设计并研发的一款软件产品。
                        微态尔科技一直以来秉承“以工匠精神打磨产品，让产品为客户创造价值”为目标。
                    </p>
                    <p>
                        微态尔商城基于 PHP(Laravel) + MySQL + Redis技术开发，全部源码开放。
                        为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：
                    </p>
                    <p>
                        <strong>一、本授权协议适用且仅适用于微态尔商城任何版本，微态尔科技官方对本授权协议的最终解释权。</strong>
                    </p>
                    <p>
                        <strong>二、协议许可的权利 </strong>
                        <ol>
                            <li>非授权用户允许商用，严禁去除微态尔商城相关的版权信息。</li>
                            <li>请尊重微态尔商城开发人员劳动成果，严禁使用本系统转卖、销售或二次开发后转卖、销售等商业行为。</li>
                            <li>任何企业和个人不允许对程序代码以任何形式任何目的再发布。</li>
                            <li>您拥有使用本软件构建的网站全部内容所有权，并独立承担与这些内容的相关法律义务。</li>
                            <li>获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持内容，自购买时刻起，
                                在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。
                                商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
                        </ol>
                    </p>
                    <p>
                        <strong>三、协议规定的约束和限制 </strong>
                        <ol>
                            <li>未获商业授权之前，允许您对微态尔商城应用于商业用途，但严禁去除微态尔商城任何相关的版权信息。</li>
                            <li>未经官方许可，不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
                            <li>未经官方许可，禁止在微态尔商城的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
                            <li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。</li>
                        </ol>
                    </p>
                    <p>
                        <strong>四、有限担保和免责声明 </strong>
                        <ol>
                            <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
                            <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，
                                我们不承诺对免费用户提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
                            <li>电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。
                                您一旦开始确认本协议并安装微态尔商城，即被视为完全理解并接受本协议的各项条款，
                                在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，
                                将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</li>
                        </ol>
                    </p>
                </div>
                <div class="footer">
                    <el-checkbox v-model="checked" style="margin-right: 10px;" @change="checkbox">我已经阅读并同意此协议</el-checkbox>
                    <el-button type="primary" size="medium" :disabled="disabled" @click="next">下一步</el-button>
                </div>
            </div>
        </main>
    </div>
    <script>
        new Vue({
            el: '#app',
            data () {
                return {
                    checked: false,
                    disabled: true
                }
            },
            methods: {
                checkbox (value) {
                    this.disabled = !value
                },
                next () {
                    window.location.href="/install/step2"
                }
            }
        })
    </script>
@endsection
