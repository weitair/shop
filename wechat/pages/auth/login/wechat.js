(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/auth/login/wechat"],{"2a79":function(t,e,n){"use strict";n.r(e);var i=n("9144"),r=n.n(i);for(var o in i)"default"!==o&&function(t){n.d(e,t,(function(){return i[t]}))}(o);e["default"]=r.a},6326:function(t,e,n){"use strict";(function(t){n("2490");i(n("66fd"));var e=i(n("859f"));function i(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,n("543d")["createPage"])},"859f":function(t,e,n){"use strict";n.r(e);var i=n("d3da"),r=n("2a79");for(var o in r)"default"!==o&&function(t){n.d(e,t,(function(){return r[t]}))}(o);var a,c=n("f0c5"),u=Object(c["a"])(r["default"],i["b"],i["c"],!1,null,null,null,!1,i["a"],a);e["default"]=u.exports},9144:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i={data:function(){return{redirect:void 0}},watch:{$route:{handler:function(t){this.redirect=t.query&&t.query.redirect},immediate:!0}},onLoad:function(t){var e=this;this.$get("/auth/login/wechat/appid").then((function(t){var n=window.location.href,i=e.$util.getUrlParam("code");if(i)e.login(i);else{var r="https://open.weixin.qq.com/connect/oauth2/authorize?appid="+t.data+"&redirect_uri="+encodeURIComponent(n)+"&response_type=code&scope=snsapi_userinfo&state=state#wechat_redirect";window.location.href=r}}))},methods:{login:function(t){var e=this;this.$store.dispatch("user/wechatLogin",t).then((function(t){window.location.replace("/h5/#"+e.redirect)})).catch((function(){window.location.replace("/h5/#/pages/auth/login/index?redirect="+e.redirect)}))}}};e.default=i},d3da:function(t,e,n){"use strict";var i;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return o})),n.d(e,"a",(function(){return i}));var r=function(){var t=this,e=t.$createElement;t._self._c},o=[]}},[["6326","common/runtime","common/vendor"]]]);