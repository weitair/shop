(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-login/wui-login"],{"2a6f":function(n,t,e){"use strict";e.d(t,"b",(function(){return u})),e.d(t,"c",(function(){return i})),e.d(t,"a",(function(){return o}));var o={wuiPopup:function(){return e.e("components/wui-popup/wui-popup").then(e.bind(null,"418e"))},wuiButton:function(){return e.e("components/wui-button/wui-button").then(e.bind(null,"6821"))}},u=function(){var n=this,t=n.$createElement;n._self._c},i=[]},6514:function(n,t,e){},b01c:function(n,t,e){"use strict";(function(n){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var o=u(e("f4df"));function u(n){return n&&n.__esModule?n:{default:n}}var i={name:"wui-login",props:{show:{type:Boolean,default:!1}},data:function(){return{loading:!1,redirect:void 0}},watch:{show:{handler:function(n){this.loginShow=n},immediate:!0}},methods:{close:function(){this.$emit("update:show",!1)},login:function(){var t=this;n.getUserProfile({desc:"您的资料用于完善会员信息",lang:"zh_CN",complete:function(e){"getUserProfile:ok"==e.errMsg&&o.default.set("userinfo",e),t.loading=!0,t.$store.dispatch("user/weappLogin").then((function(){var n=t.$util.getCurrentPage();n.onLoad(n.options),n.onShow()})).catch((function(t){n.navigateTo({url:"/pages/auth/register/weapp"})})).finally((function(){t.loading=!1,t.close()}))}})}}};t.default=i}).call(this,e("543d")["default"])},bd8c:function(n,t,e){"use strict";var o=e("6514"),u=e.n(o);u.a},ca82:function(n,t,e){"use strict";e.r(t);var o=e("b01c"),u=e.n(o);for(var i in o)"default"!==i&&function(n){e.d(t,n,(function(){return o[n]}))}(i);t["default"]=u.a},e297:function(n,t,e){"use strict";e.r(t);var o=e("2a6f"),u=e("ca82");for(var i in u)"default"!==i&&function(n){e.d(t,n,(function(){return u[n]}))}(i);e("bd8c");var a,r=e("f0c5"),c=Object(r["a"])(u["default"],o["b"],o["c"],!1,null,"58a8e69a",null,!1,o["a"],a);t["default"]=c.exports}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-login/wui-login-create-component',
    {
        'components/wui-login/wui-login-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("e297"))
        })
    },
    [['components/wui-login/wui-login-create-component']]
]);