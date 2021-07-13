(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/goods/category/components/LevelThree"],{1999:function(t,e,n){},"42d2":function(t,e,n){"use strict";var r;n.d(e,"b",(function(){return a})),n.d(e,"c",(function(){return u})),n.d(e,"a",(function(){return r}));var a=function(){var t=this,e=t.$createElement;t._self._c},u=[]},5887:function(t,e,n){"use strict";n.r(e);var r=n("c815"),a=n.n(r);for(var u in r)"default"!==u&&function(t){n.d(e,t,(function(){return r[t]}))}(u);e["default"]=a.a},"67d9":function(t,e,n){"use strict";n.r(e);var r=n("42d2"),a=n("5887");for(var u in a)"default"!==u&&function(t){n.d(e,t,(function(){return a[t]}))}(u);n("e552");var c,i=n("f0c5"),o=Object(i["a"])(a["default"],r["b"],r["c"],!1,null,"587c8c66",null,!1,r["a"],c);e["default"]=o.exports},c815:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var r={name:"GoodsCategoryLevelThree",props:{top:{type:Number,default:0},height:{type:Number,default:0},type:{type:[Number,String],default:1},parent:{type:[Number,String],default:0},data:{type:Array,default:function(){return[]}}},data:function(){return{category:[]}},watch:{parent:{handler:function(t){var e=this;this.data.forEach((function(n){n.id==t&&n.children&&(e.category=n.children)}))},immediate:!0}},methods:{redirect:function(t,e){this.$emit("redirect",t,e)}}};e.default=r},e552:function(t,e,n){"use strict";var r=n("1999"),a=n.n(r);a.a}}]);
;(global["webpackJsonp"] = global["webpackJsonp"] || []).push([
    'pages/goods/category/components/LevelThree-create-component',
    {
        'pages/goods/category/components/LevelThree-create-component':(function(module, exports, __webpack_require__){
            __webpack_require__('543d')['createComponent'](__webpack_require__("67d9"))
        })
    },
    [['pages/goods/category/components/LevelThree-create-component']]
]);
