(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-load-detail/wui-load-detail"],{"03c4":function(t,n,e){"use strict";e.r(n);var u=e("23e0"),i=e("b7d7");for(var o in i)"default"!==o&&function(t){e.d(n,t,(function(){return i[t]}))}(o);var a,l=e("f0c5"),r=Object(l["a"])(i["default"],u["b"],u["c"],!1,null,null,null,!1,u["a"],a);n["default"]=r.exports},"23e0":function(t,n,e){"use strict";e.d(n,"b",(function(){return i})),e.d(n,"c",(function(){return o})),e.d(n,"a",(function(){return u}));var u={wuiLoading:function(){return Promise.all([e.e("common/vendor"),e.e("components/wui-loading/wui-loading")]).then(e.bind(null,"c32f"))},wuiEmpty:function(){return Promise.all([e.e("common/vendor"),e.e("components/wui-empty/wui-empty")]).then(e.bind(null,"d0ab"))}},i=function(){var t=this,n=t.$createElement,e=(t._self._c,t.loading?null:t.$util.empty(t.detail));t.$mp.data=Object.assign({},{$root:{g0:e}})},o=[]},"71ad":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var u={name:"wui-load-detail",props:{loading:{type:Boolean,default:!0},detail:{type:Object,default:function(){return{}}},title:{type:String,default:""},button:{type:String,default:""}},methods:{click:function(){this.$emit("click")}}};n.default=u},b7d7:function(t,n,e){"use strict";e.r(n);var u=e("71ad"),i=e.n(u);for(var o in u)"default"!==o&&function(t){e.d(n,t,(function(){return u[t]}))}(o);n["default"]=i.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-load-detail/wui-load-detail-create-component',
    {
        'components/wui-load-detail/wui-load-detail-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("03c4"))
        })
    },
    [['components/wui-load-detail/wui-load-detail-create-component']]
]);
