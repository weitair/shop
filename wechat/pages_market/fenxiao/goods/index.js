(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages_market/fenxiao/goods/index"],{4449:function(t,e,n){"use strict";(function(t){n("2490");i(n("66fd"));var e=i(n("475e"));function i(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,n("543d")["createPage"])},"44e9":function(t,e,n){},"475e":function(t,e,n){"use strict";n.r(e);var i=n("a386"),o=n("8590");for(var r in o)"default"!==r&&function(t){n.d(e,t,(function(){return o[t]}))}(r);n("8d1e");var a,u=n("f0c5"),s=Object(u["a"])(o["default"],i["b"],i["c"],!1,null,"f1498650",null,!1,i["a"],a);e["default"]=s.exports},8590:function(t,e,n){"use strict";n.r(e);var i=n("f8e7"),o=n.n(i);for(var r in i)"default"!==r&&function(t){n.d(e,t,(function(){return i[t]}))}(r);e["default"]=o.a},"8d1e":function(t,e,n){"use strict";var i=n("44e9"),o=n.n(i);o.a},a386:function(t,e,n){"use strict";n.d(e,"b",(function(){return o})),n.d(e,"c",(function(){return r})),n.d(e,"a",(function(){return i}));var i={wuiLoadLoginList:function(){return Promise.all([n.e("common/vendor"),n.e("components/wui-load-login-list/wui-load-login-list")]).then(n.bind(null,"3a27"))},wuiSearch:function(){return n.e("components/wui-search/wui-search").then(n.bind(null,"4ac0"))},wuiGoodsCard:function(){return n.e("components/wui-goods-card/wui-goods-card").then(n.bind(null,"215a"))},wuiTag:function(){return n.e("components/wui-tag/wui-tag").then(n.bind(null,"2dd1"))},wuiLoadingMore:function(){return n.e("components/wui-loading-more/wui-loading-more").then(n.bind(null,"90ab"))},wuiTabbar:function(){return n.e("components/wui-tabbar/wui-tabbar").then(n.bind(null,"3e6e"))},wuiTabbarItem:function(){return n.e("components/wui-tabbar-item/wui-tabbar-item").then(n.bind(null,"9e2b"))}},o=function(){var t=this,e=t.$createElement;t._self._c},r=[]},f8e7:function(t,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var i=o(n("3ee1"));function o(t){return t&&t.__esModule?t:{default:t}}var r={data:function(){return{siteinfo:i.default,tabbar:[{name:"人员",icon:"personnel",active:!1,path:"/pages_market/fenxiao/index/index"},{name:"商品",icon:"goods",active:!0,path:""},{name:"奖励",icon:"money",active:!1,path:"/pages_market/fenxiao/reward/index"},{name:"我的",icon:"mine",active:!1,path:"/pages_market/fenxiao/mine/index"}],layout:"small",shape:"circle",loading:!0,loadMore:!1,lastPage:1,list:null,query:{page:1,keyword:"",order_type:0,order_sort:"asc"}}},onReachBottom:function(){!this.loadMore&&this.lastPage>this.query.page&&(this.loadMore=!0,this.query.page+=1,this.getList())},onLoad:function(t){this.$util.isLogin()&&this.getList()},methods:{getList:function(){var t=this;this.$get("/fenxiao/goods",this.query).then((function(e){var n=e.data;t.list||(t.list=[]),t.list=t.list.concat(n.data),t.lastPage=n.last_page})).finally((function(){t.loading=!1,t.loadMore=!1}))},changeView:function(){this.layout="small"==this.layout?"list":"small",this.shape="small"==this.layout?"circle":"rect"},search:function(t){this.query.keyword=t,this.queryInit(),this.getList()},defaultOrder:function(){0!=this.query.order_type&&(this.query.order_type=0,this.queryInit(),this.getList())},saleOrder:function(){1!=this.query.order_type&&(this.query.order_type=1,this.query.order_sort="desc",this.queryInit(),this.getList())},priceOrder:function(){this.query.order_type=2,"asc"==this.query.order_sort?this.query.order_sort="desc":this.query.order_sort="asc",this.queryInit(),this.getList()},queryInit:function(){this.loadMore=!0,this.list=null,this.query.page=1},click:function(t){this.$util.redirect("/pages/goods/detail/index?id=".concat(t))}}};e.default=r}},[["4449","common/runtime","common/vendor"]]]);