(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-diy-goods/wui-diy-goods"],{"12a5":function(n,t,e){},"15a4":function(n,t,e){"use strict";var u=e("12a5"),o=e.n(u);o.a},"6f9e":function(n,t,e){"use strict";e.r(t);var u=e("8213"),o=e.n(u);for(var a in u)"default"!==a&&function(n){e.d(t,n,(function(){return u[n]}))}(a);t["default"]=o.a},8213:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u={name:"wui-diy-goods",props:{index:{type:Number,default:0},params:{type:Object,default:function(){return{}}}},data:function(){return{active:0}},computed:{tabs:function(){var n=[];return this.params.result.forEach((function(t){n.push({title:t.group_name})})),n}},methods:{changeTab:function(n){this.active=n}}};t.default=u},b9ce:function(n,t,e){"use strict";e.r(t);var u=e("e393"),o=e("6f9e");for(var a in o)"default"!==a&&function(n){e.d(t,n,(function(){return o[n]}))}(a);e("15a4");var i,r=e("f0c5"),c=Object(r["a"])(o["default"],u["b"],u["c"],!1,null,"15abf73c",null,!1,u["a"],i);t["default"]=c.exports},e393:function(n,t,e){"use strict";e.d(t,"b",(function(){return o})),e.d(t,"c",(function(){return a})),e.d(t,"a",(function(){return u}));var u={wuiTabs:function(){return e.e("components/wui-tabs/wui-tabs").then(e.bind(null,"7b31"))},wuiGoods:function(){return Promise.all([e.e("common/vendor"),e.e("components/wui-goods/wui-goods")]).then(e.bind(null,"465d"))}},o=function(){var n=this,t=n.$createElement;n._self._c},a=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-diy-goods/wui-diy-goods-create-component',
    {
        'components/wui-diy-goods/wui-diy-goods-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("b9ce"))
        })
    },
    [['components/wui-diy-goods/wui-diy-goods-create-component']]
]);
