(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages_app/article/detail/index"],{"3a9f":function(n,t,e){},"4ccb":function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var a={data:function(){return{loading:!0,detail:{}}},onLoad:function(n){var t=this;this.$get("/article/detail",{id:n.id}).then((function(n){var e=n.data;t.detail=e})).finally((function(){t.loading=!1}))}};t.default=a},7570:function(n,t,e){"use strict";(function(n){e("2490");a(e("66fd"));var t=a(e("8c61"));function a(n){return n&&n.__esModule?n:{default:n}}n(t.default)}).call(this,e("543d")["createPage"])},7691:function(n,t,e){"use strict";var a=e("3a9f"),u=e.n(a);u.a},"793b":function(n,t,e){"use strict";e.r(t);var a=e("4ccb"),u=e.n(a);for(var i in a)"default"!==i&&function(n){e.d(t,n,(function(){return a[n]}))}(i);t["default"]=u.a},"8c61":function(n,t,e){"use strict";e.r(t);var a=e("bcea"),u=e("793b");for(var i in u)"default"!==i&&function(n){e.d(t,n,(function(){return u[n]}))}(i);e("7691");var c,o=e("f0c5"),r=Object(o["a"])(u["default"],a["b"],a["c"],!1,null,"5f6137b4",null,!1,a["a"],c);t["default"]=r.exports},bcea:function(n,t,e){"use strict";e.d(t,"b",(function(){return u})),e.d(t,"c",(function(){return i})),e.d(t,"a",(function(){return a}));var a={wuiLoadDetail:function(){return e.e("components/wui-load-detail/wui-load-detail").then(e.bind(null,"03c4"))},uParse:function(){return Promise.all([e.e("common/vendor"),e.e("components/u-parse/u-parse")]).then(e.bind(null,"db8c"))}},u=function(){var n=this,t=n.$createElement;n._self._c},i=[]}},[["7570","common/runtime","common/vendor"]]]);