(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-auth-login-wechat"],{"2a79":function(t,e,n){"use strict";n.r(e);var i=n("86b0"),r=n.n(i);for(var a in i)"default"!==a&&function(t){n.d(e,t,(function(){return i[t]}))}(a);e["default"]=r.a},"859f":function(t,e,n){"use strict";n.r(e);var i=n("d3da"),r=n("2a79");for(var a in r)"default"!==a&&function(t){n.d(e,t,(function(){return r[t]}))}(a);var o,c=n("f0c5"),u=Object(c["a"])(r["default"],i["b"],i["c"],!1,null,null,null,!1,i["a"],o);e["default"]=u.exports},"86b0":function(t,e,n){"use strict";n("ac1f"),n("5319"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i={data:function(){return{redirect:void 0}},watch:{$route:{handler:function(t){this.redirect=t.query&&t.query.redirect},immediate:!0}},onLoad:function(t){var e=this;this.$get("/auth/login/wechat/appid").then((function(t){var n=window.location.href,i=e.$util.getUrlParam("code");if(i)e.login(i);else{var r="https://open.weixin.qq.com/connect/oauth2/authorize?appid="+t.data+"&redirect_uri="+encodeURIComponent(n)+"&response_type=code&scope=snsapi_userinfo&state=state#wechat_redirect";window.location.href=r}}))},methods:{login:function(t){var e=this;this.$store.dispatch("user/wechatLogin",t).then((function(t){window.location.replace("/h5/#"+e.redirect)})).catch((function(){window.location.replace("/h5/#/pages/auth/login/index?redirect="+e.redirect)}))}}};e.default=i},d3da:function(t,e,n){"use strict";var i;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return a})),n.d(e,"a",(function(){return i}));var r=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div")},a=[]}}]);