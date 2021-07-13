(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["components/wui-icon/wui-icon"],{"01e0":function(t,n,e){"use strict";e.r(n);var i=e("341f8"),u=e.n(i);for(var c in i)"default"!==c&&function(t){e.d(n,t,(function(){return i[t]}))}(c);n["default"]=u.a},"341f8":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i={name:"wui-icon",props:{name:{type:String,default:""},size:{type:[Number,String],default:36},color:{type:String,default:""},customStyle:{type:Object,default:function(){return{}}}},computed:{image:function(){return this.name.indexOf("/")>=0}},methods:{click:function(){this.$emit("click")}}};n.default=i},3732:function(t,n,e){"use strict";var i=e("825d"),u=e.n(i);u.a},"825d":function(t,n,e){},8901:function(t,n,e){"use strict";e.r(n);var i=e("f6dd"),u=e("01e0");for(var c in u)"default"!==c&&function(t){e.d(n,t,(function(){return u[t]}))}(c);e("3732");var a,o=e("f0c5"),r=Object(o["a"])(u["default"],i["b"],i["c"],!1,null,"7e4d06fa",null,!1,i["a"],a);n["default"]=r.exports},f6dd:function(t,n,e){"use strict";var i;e.d(n,"b",(function(){return u})),e.d(n,"c",(function(){return c})),e.d(n,"a",(function(){return i}));var u=function(){var t=this,n=t.$createElement,e=(t._self._c,t.image?null:t.__get_style([{fontSize:t.$util.addUnit(t.size),color:t.color},t.customStyle])),i=t.image?t.$util.addUnit(t.size):null,u=t.image?t.$util.addUnit(t.size):null;t.$mp.data=Object.assign({},{$root:{s0:e,g0:i,g1:u}})},c=[]}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'components/wui-icon/wui-icon-create-component',
    {
        'components/wui-icon/wui-icon-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("8901"))
        })
    },
    [['components/wui-icon/wui-icon-create-component']]
]);
