(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/auth/register/index"],{"0d29":function(t,e,n){"use strict";n.r(e);var r=n("3c3a"),o=n("6c94");for(var i in o)"default"!==i&&function(t){n.d(e,t,(function(){return o[t]}))}(i);n("37f6");var u,c=n("f0c5"),a=Object(c["a"])(o["default"],r["b"],r["c"],!1,null,"637f8d5c",null,!1,r["a"],u);e["default"]=a.exports},"37f6":function(t,e,n){"use strict";var r=n("9902"),o=n.n(r);o.a},"3c3a":function(t,e,n){"use strict";n.d(e,"b",(function(){return o})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return r}));var r={wuiField:function(){return n.e("components/wui-field/wui-field").then(n.bind(null,"b0fe"))},wuiButton:function(){return n.e("components/wui-button/wui-button").then(n.bind(null,"6821"))}},o=function(){var t=this,e=t.$createElement;t._self._c;t._isMounted||(t.e0=function(e){return t.$router.replace("/pages/auth/login/index?redirect="+t.redirect)})},i=[]},6310:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r=i(n("5231")),o=n("2f62");function i(t){return t&&t.__esModule?t:{default:t}}function u(t,e){var n=Object.keys(t);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(t);e&&(r=r.filter((function(e){return Object.getOwnPropertyDescriptor(t,e).enumerable}))),n.push.apply(n,r)}return n}function c(t){for(var e=1;e<arguments.length;e++){var n=null!=arguments[e]?arguments[e]:{};e%2?u(Object(n),!0).forEach((function(e){a(t,e,n[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(n)):u(Object(n)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(n,e))}))}return t}function a(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}var f={data:function(){return{loading:!1,top:this.$navHeight+"px",countdown:!1,second:60,redirect:void 0,form:{phone:"",password:"",code:""}}},computed:c({},(0,o.mapGetters)("app",["title","logo"])),watch:{$route:{handler:function(t){this.redirect=t.query&&t.query.redirect},immediate:!0}},methods:{fetchCode:function(){var t=this,e=this;if(!r.default.phone(e.form.phone))return e.$util.toast("请输入正确的手机号"),!1;e.$util.showLoading(),e.$post("/auth/register/fetch/code",{phone:e.form.phone}).then((function(t){e.$util.toast(t.msg),e.countdown=!0,e.count()})).catch((function(e){t.$util.toast(e.msg)})).finally((function(){e.$util.hideLoading()}))},count:function(){var t=this,e=setInterval((function(){t.second-=1,0==t.second&&(t.second=60,t.countdown=!1,clearInterval(e))}),1e3)},submit:function(){var t=this;return r.default.phone(this.form.phone)?this.form.password?this.form.code?(this.loading=!0,this.form.channel=this.$util.isWechat()?0:2,void this.$store.dispatch("user/register",this.form).then((function(e){t.$router.replace(t.redirect||"/")})).catch((function(e){t.$util.toast(e.msg)})).finally((function(){t.loading=!1}))):(this.$util.toast("请输入验证码"),!1):(this.$util.toast("请输入密码"),!1):(this.$util.toast("请输入正确的手机号"),!1)}}};e.default=f},"6c94":function(t,e,n){"use strict";n.r(e);var r=n("6310"),o=n.n(r);for(var i in r)"default"!==i&&function(t){n.d(e,t,(function(){return r[t]}))}(i);e["default"]=o.a},9902:function(t,e,n){},b89e:function(t,e,n){"use strict";(function(t){n("2490");r(n("66fd"));var e=r(n("0d29"));function r(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,n("543d")["createPage"])}},[["b89e","common/runtime","common/vendor"]]]);