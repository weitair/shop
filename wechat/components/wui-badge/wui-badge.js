(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-badge/wui-badge"],{"0944":function(t,e,n){},"326f":function(t,e,n){"use strict";var u=n("0944"),r=n.n(u);r.a},"5d74":function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var u={name:"wui-badge",props:{content:{type:[String,Number],default:""},dot:{type:Boolean,default:!1},max:{type:Number,default:0},color:{type:String,default:"#ee0a24"}},computed:{contentComputed:function(){if(this.max>0){var t=parseInt(this.content);if(t>this.max)return this.max+"+"}return this.content}}};e.default=u},"8e43":function(t,e,n){"use strict";n.r(e);var u=n("5d74"),r=n.n(u);for(var a in u)"default"!==a&&function(t){n.d(e,t,(function(){return u[t]}))}(a);e["default"]=r.a},e307:function(t,e,n){"use strict";n.r(e);var u=n("f6f7"),r=n("8e43");for(var a in r)"default"!==a&&function(t){n.d(e,t,(function(){return r[t]}))}(a);n("326f");var f,o=n("f0c5"),i=Object(o["a"])(r["default"],u["b"],u["c"],!1,null,"3510b76e",null,!1,u["a"],f);e["default"]=i.exports},f6f7:function(t,e,n){"use strict";var u;n.d(e,"b",(function(){return r})),n.d(e,"c",(function(){return a})),n.d(e,"a",(function(){return u}));var r=function(){var t=this,e=t.$createElement;t._self._c},a=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-badge/wui-badge-create-component',
    {
        'components/wui-badge/wui-badge-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("e307"))
        })
    },
    [['components/wui-badge/wui-badge-create-component']]
]);
