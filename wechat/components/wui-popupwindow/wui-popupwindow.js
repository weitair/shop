(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-popupwindow/wui-popupwindow"],{"0cdb":function(n,t,e){"use strict";e.r(t);var u=e("4970"),o=e.n(u);for(var i in u)"default"!==i&&function(n){e.d(t,n,(function(){return u[n]}))}(i);t["default"]=o.a},2289:function(n,t,e){"use strict";e.r(t);var u=e("9b8b"),o=e("0cdb");for(var i in o)"default"!==i&&function(n){e.d(t,n,(function(){return o[n]}))}(i);e("f452");var c,a=e("f0c5"),r=Object(a["a"])(o["default"],u["b"],u["c"],!1,null,"5f7d041e",null,!1,u["a"],c);t["default"]=r.exports},4970:function(n,t,e){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var u={name:"wui-popupwindow",props:{show:{type:Boolean,default:!1},image:{type:String,default:""},closeOverlay:{type:Boolean,default:!0}},methods:{click:function(){this.$emit("click")},close:function(){this.$emit("update:show",!1)},clickOverlay:function(){this.closeOverlay&&this.$emit("update:show",!1)}}};t.default=u},"78fd":function(n,t,e){},"9b8b":function(n,t,e){"use strict";e.d(t,"b",(function(){return o})),e.d(t,"c",(function(){return i})),e.d(t,"a",(function(){return u}));var u={wuiIcon:function(){return e.e("components/wui-icon/wui-icon").then(e.bind(null,"8901"))}},o=function(){var n=this,t=n.$createElement;n._self._c},i=[]},f452:function(n,t,e){"use strict";var u=e("78fd"),o=e.n(u);o.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-popupwindow/wui-popupwindow-create-component',
    {
        'components/wui-popupwindow/wui-popupwindow-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("2289"))
        })
    },
    [['components/wui-popupwindow/wui-popupwindow-create-component']]
]);
