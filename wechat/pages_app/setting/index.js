(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages_app/setting/index"],{"1ae5":function(n,t,e){"use strict";var u=e("8e71"),i=e.n(u);i.a},"2cfd":function(n,t,e){"use strict";e.r(t);var u=e("d1f2"),i=e("84d9");for(var o in i)"default"!==o&&function(n){e.d(t,n,(function(){return i[n]}))}(o);e("1ae5");var c,r=e("f0c5"),a=Object(r["a"])(i["default"],u["b"],u["c"],!1,null,"97e946fc",null,!1,u["a"],c);t["default"]=a.exports},"84d9":function(n,t,e){"use strict";e.r(t);var u=e("ded1"),i=e.n(u);for(var o in u)"default"!==o&&function(n){e.d(t,n,(function(){return u[n]}))}(o);t["default"]=i.a},"8be5":function(n,t,e){"use strict";(function(n){e("2490");u(e("66fd"));var t=u(e("2cfd"));function u(n){return n&&n.__esModule?n:{default:n}}n(t.default)}).call(this,e("543d")["createPage"])},"8e71":function(n,t,e){},d1f2:function(n,t,e){"use strict";e.d(t,"b",(function(){return i})),e.d(t,"c",(function(){return o})),e.d(t,"a",(function(){return u}));var u={wuiLoadLogin:function(){return Promise.all([e.e("common/vendor"),e.e("components/wui-load-login/wui-load-login")]).then(e.bind(null,"1989"))},wuiCell:function(){return e.e("components/wui-cell/wui-cell").then(e.bind(null,"d5e2"))},wuiButton:function(){return e.e("components/wui-button/wui-button").then(e.bind(null,"6821"))}},i=function(){var n=this,t=n.$createElement;n._self._c},o=[]},ded1:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u={data:function(){return{loading:!0,detail:{}}},onShow:function(){var n=this;this.$get("/member").then((function(t){n.detail=t.data})).finally((function(){n.loading=!1}))},methods:{redirect:function(n){this.$util.redirect(n)}}};t.default=u}},[["8be5","common/runtime","common/vendor"]]]);