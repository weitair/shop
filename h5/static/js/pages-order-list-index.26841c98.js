(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-order-list-index"],{"0ce4":function(t,e,i){"use strict";var a=i("9049"),n=i.n(a);n.a},3598:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,".u-sticky[data-v-3facf1ea]{z-index:999}",""]),t.exports=e},"35e7":function(t,e,i){"use strict";i.r(e);var a=i("c9ef"),n=i("eb66");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("7d54");var o,l=i("f0c5"),r=Object(l["a"])(n["default"],a["b"],a["c"],!1,null,"6166338a",null,!1,a["a"],o);e["default"]=r.exports},"3a27":function(t,e,i){"use strict";i.r(e);var a=i("8116"),n=i("d211");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);var o,l=i("f0c5"),r=Object(l["a"])(n["default"],a["b"],a["c"],!1,null,null,null,!1,a["a"],o);e["default"]=r.exports},4522:function(t,e,i){var a=i("9959");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("6883d217",a,!0,{sourceMap:!1,shadowMode:!1})},5423:function(t,e,i){"use strict";i("a9e3"),i("ac1f"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={name:"wui-tabs",props:{value:{type:[Number,String],default:0},list:{type:Array,default:function(){return[]}},index:{type:Number,default:970},type:{type:String,default:"line"},ellipsis:{type:Boolean,default:!0},scroll:{type:Boolean,default:!1},sticky:{type:Boolean,default:!1},custom:{type:Boolean,default:!1}},data:function(){return{current:0,offsetTop:0,lineStyle:{}}},computed:{typeClass:function(){return"circle"==this.type?"tags-tab-style-1":"rect"==this.type?"tags-tab-style-2":"tags-tab-style"}},watch:{value:{handler:function(t){this.current=t},immediate:!0}},created:function(){this.custom&&(this.$util.isWechat()||(this.offsetTop=88))},mounted:function(){},methods:{tabsChange:function(t,e){t!=this.current&&this.$emit("change",t,e)},setLine:function(){this.$nextTick((function(){var t=this,e=0;if("line"==this.type){var i=uni.createSelectorQuery().in(this);i.selectAll("#title").boundingClientRect((function(i){var a=i[t.current].left,n=i[t.current].width;e=a+n/2,t.lineStyle={width:"40px",transform:"translateX("+e+"px) translateX(-50%)",transitionDuration:"0.3s"}})).exec()}}))}}};e.default=a},"6a4b":function(t,e,i){"use strict";i.r(e);var a=i("5423"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},"6e40":function(t,e,i){"use strict";i.r(e);var a=i("83be"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},"6fdc":function(t,e,i){"use strict";i.r(e);var a=i("a584"),n=i("6e40");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("0ce4");var o,l=i("f0c5"),r=Object(l["a"])(n["default"],a["b"],a["c"],!1,null,"3facf1ea",null,!1,a["a"],o);e["default"]=r.exports},"74fd":function(t,e,i){"use strict";var a=i("4522"),n=i.n(a);n.a},"7b31":function(t,e,i){"use strict";i.r(e);var a=i("81fb"),n=i("6a4b");for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);i("74fd");var o,l=i("f0c5"),r=Object(l["a"])(n["default"],a["b"],a["c"],!1,null,"1594870c",null,!1,a["a"],o);e["default"]=r.exports},"7d54":function(t,e,i){"use strict";var a=i("c261"),n=i.n(a);n.a},8116:function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var a={wuiEmpty:i("d0ab").default,wuiLoading:i("c32f").default,wuiLogin:i("e297").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[t._t("login_static"),t.login?i("v-uni-view",[t.loading?i("wui-loading"):i("v-uni-view",[t._t("list_static"),null===t.list||t.list.length?t._t("default"):i("wui-empty",{attrs:{title:t.title,button:t.button},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.handleClick.apply(void 0,arguments)}}})],2)],1):i("wui-empty",{attrs:{title:t.NOT_LOGIN,button:t.LOGIN},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.loginShow=!0}}}),i("wui-login",{attrs:{show:t.loginShow},on:{"update:show":function(e){arguments[0]=e=t.$handleEvent(e),t.loginShow=e}}})],2)},s=[]},"81fb":function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var a={wuiSticky:i("6fdc").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"showcase-tag-list-top"},[i("v-uni-view",{staticClass:"tabs tabs--line",class:[t.typeClass]},[i("wui-sticky",{attrs:{enable:t.sticky,"offset-top":t.offsetTop}},[i("v-uni-view",{staticClass:"tabs__wrap",class:{"tabs__wrap--scrollable":t.scroll}},[i("v-uni-view",{staticClass:"tabs__nav tabs__nav--line",class:{"tabs__nav--complete":t.scroll},attrs:{role:"tablist"}},t._l(t.list,(function(e,a){return i("v-uni-view",{key:a,staticClass:"tab",class:{"tab--active":t.current==a},attrs:{id:"title"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.tabsChange(a,e.value)}}},[i("v-uni-view",{staticClass:"tab__text",class:{"tab__text--ellipsis":t.ellipsis}},[t._v(t._s(e.title))]),t.current==a&&"line"==t.type?i("v-uni-view",{staticClass:"tab__text-line"}):t._e()],1)})),1)],1)],1)],1)],1)},s=[]},"83be":function(t,e,i){"use strict";i("a9e3"),i("d3b7"),i("ac1f"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a={name:"wui-sticky",props:{offsetTop:{type:[Number,String],default:0},index:{type:[Number,String],default:""},enable:{type:Boolean,default:!0},h5NavHeight:{type:[Number,String],default:0},bgColor:{type:String,default:"#ffffff"},zIndex:{type:[Number,String],default:""}},data:function(){return{fixed:!1,height:"auto",stickyTop:0,elClass:this.$util.guid(),left:0,width:"auto"}},watch:{offsetTop:function(t){this.initObserver()},enable:function(t){0==t?(this.fixed=!1,this.disconnectObserver("contentObserver")):this.initObserver()}},computed:{uZIndex:function(){return this.zIndex?this.zIndex:970}},mounted:function(){this.initObserver()},methods:{getRect:function(t){var e=this;return new Promise((function(i){uni.createSelectorQuery().in(e)["select"](t).boundingClientRect((function(t){i(t)})).exec()}))},initObserver:function(){var t=this;this.enable&&(this.stickyTop=0!=this.offsetTop?uni.upx2px(this.offsetTop-4)+this.h5NavHeight:this.h5NavHeight,this.disconnectObserver("contentObserver"),this.getRect("."+this.elClass).then((function(e){t.height=e.height,t.left=e.left,t.width=e.width,t.$nextTick((function(){t.observeContent()}))})))},observeContent:function(){var t=this;this.disconnectObserver("contentObserver");var e=this.createIntersectionObserver({thresholds:[.95,.98,1]});e.relativeToViewport({top:-this.stickyTop}),e.observe("."+this.elClass,(function(e){t.enable&&t.setFixed(e.boundingClientRect.top)})),this.contentObserver=e},setFixed:function(t){var e=t<this.stickyTop;e?this.$emit("fixed",this.index):this.fixed&&this.$emit("unfixed",this.index),this.fixed=e},disconnectObserver:function(t){var e=this[t];e&&e.disconnect()}},beforeDestroy:function(){this.disconnectObserver("contentObserver")}};e.default=a},9049:function(t,e,i){var a=i("3598");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("9eac5f52",a,!0,{sourceMap:!1,shadowMode:!1})},9959:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,'.tab[data-v-1594870c]{position:relative;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-flex:1;-webkit-flex:1;flex:1;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;box-sizing:border-box;padding:0 4px;color:#646566;font-size:14px;line-height:20px;cursor:pointer}.tabs--line .tabs__wrap[data-v-1594870c]{height:44px}.tab--active[data-v-1594870c]{color:#323233;font-weight:500}.tab--disabled[data-v-1594870c]{color:#c8c9cc;cursor:not-allowed}.tab__text--ellipsis[data-v-1594870c]{display:-webkit-box;overflow:hidden;-webkit-line-clamp:1;-webkit-box-orient:vertical}.tab__text-line[data-v-1594870c]{position:absolute;bottom:0;width:40px;border-bottom:2px solid #ee0a24}.tab__text-wrapper[data-v-1594870c]{position:relative}.tabs[data-v-1594870c]{position:relative}.tabs__wrap[data-v-1594870c]{overflow:hidden}.tabs__wrap--page-top[data-v-1594870c]{position:fixed}.tabs__wrap--content-bottom[data-v-1594870c]{top:auto;bottom:0}.tabs__wrap--scrollable .tab[data-v-1594870c]{-webkit-box-flex:1;-webkit-flex:1 0 auto;flex:1 0 auto;padding:0 12px}.tabs__wrap--scrollable .tabs__nav[data-v-1594870c]{overflow-x:auto;overflow-y:hidden;-webkit-overflow-scrolling:touch}.tabs__wrap--scrollable .tabs__nav[data-v-1594870c]::-webkit-scrollbar{display:none}.tabs__nav[data-v-1594870c]{position:relative;display:-webkit-box;display:-webkit-flex;display:flex;background-color:#fff;-webkit-user-select:none;user-select:none}.tabs__nav--line[data-v-1594870c]{box-sizing:initial;height:100%;padding-bottom:15px}.tabs__nav--complete[data-v-1594870c]{padding-right:8px;padding-left:8px}.tabs__nav--card[data-v-1594870c]{box-sizing:border-box;height:30px;margin:0 16px;border:1px solid #ee0a24;border-radius:2px}.tabs__nav--card .tab[data-v-1594870c]{color:#ee0a24;border-right:1px solid #ee0a24}.tabs__nav--card .tab[data-v-1594870c]:last-child{border-right:none}.tabs__nav--card .tab.tab--active[data-v-1594870c]{color:#fff;background-color:#ee0a24}.tabs__nav--card .tab--disabled[data-v-1594870c]{color:#c8c9cc}.tabs__line[data-v-1594870c]{position:absolute;bottom:15px;left:0;z-index:1;width:40px;height:2px;background-color:#ee0a24;border-radius:3px}.tabs__track[data-v-1594870c]{position:relative;display:-webkit-box;display:-webkit-flex;display:flex;width:100%;height:100%;will-change:left}.tabs__content--animated[data-v-1594870c]{overflow:hidden}.tags-list__no-more[data-v-1594870c]{color:#969799;font-size:13px;line-height:60px;text-align:center}.tags-list__loading[data-v-1594870c]{min-height:80px;line-height:80px;vertical-align:middle;text-align:center}.tags-list__loading .loading[data-v-1594870c]{width:20px;height:20px;display:inline-block}.tags-tab-style-1 .tabs__line[data-v-1594870c]{display:none}.tags-tab-style-1 .tab--active .tab__text[data-v-1594870c]{color:#fff;height:28px;box-sizing:border-box;line-height:15px;background:#f44;padding:6px 12px;border-radius:32px}.showcase-tag-list-top .tags-tab-style-2 .tab[data-v-1594870c]{padding:0 8px!important;height:44px;line-height:44px}.showcase-tag-list-top .tags-tab-style-2 .tab--active[data-v-1594870c]{color:#fff;overflow:visible}.showcase-tag-list-top .tags-tab-style-2 .tab--active .tab__text[data-v-1594870c]{color:#fff}.showcase-tag-list-top .tags-tab-style-2 .tab--active[data-v-1594870c]:after{border-color:#f44}.showcase-tag-list-top .tags-tab-style-2 .tab .tab__text[data-v-1594870c]{height:44px;display:block;overflow:hidden}.showcase-tag-list-top .tags-tab-style-2 .tabs__line[data-v-1594870c]{display:none}.showcase-tag-list-top .tags-tab-style-2 .tabs__nav[data-v-1594870c]{background-color:initial}.showcase-tag-list-top .tags-tab-style-2 .tabs__wrap[data-v-1594870c]:after{border-width:0}.tags-tab-style-2 .tab[data-v-1594870c]{background-color:#fff}.tags-tab-style-2 .tab--active[data-v-1594870c]{color:#fff;background-color:#f44}.showcase-tag-list-top [class*="hairline"][data-v-1594870c]:after{border:none}.showcase-tag-list-top .tab--active[data-v-1594870c]{color:#323233;font-weight:700}.showcase-tag-list-top > .tabs[data-v-1594870c]{line-height:40px;color:#969799;font-size:16px;box-shadow:0 2px 4px rgba(0,0,0,.06)}.showcase-tag-list-top > .tabs .tab[data-v-1594870c]{padding:0 16px}.showcase-tag-list-top > .tabs > .tabs__wrap[data-v-1594870c]{box-shadow:0 2px 12px rgba(100,101,102,.12);z-index:100}.tags-tab-transition .tabs__wrap[data-v-1594870c]{-webkit-transition:top .3s linear;transition:top .3s linear}.showcase-tag-list-top[data-v-1594870c]{background:#fff}',""]),t.exports=e},a584:function(t,e,i){"use strict";var a;i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"u-sticky-wrap",class:[t.elClass],style:{height:t.fixed?t.height+"px":"auto",backgroundColor:t.bgColor}},[i("v-uni-view",{staticClass:"u-sticky",style:{position:t.fixed?"fixed":"static",top:t.stickyTop+"px",left:t.left+"px",width:"auto"==t.width?"auto":t.width+"px",zIndex:t.uZIndex}},[t._t("default")],2)],1)],1)},s=[]},c261:function(t,e,i){var a=i("c4c3");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var n=i("4f06").default;n("e9348148",a,!0,{sourceMap:!1,shadowMode:!1})},c4c3:function(t,e,i){var a=i("24fb");e=a(!1),e.push([t.i,".container[data-v-6166338a]{padding-bottom:0}.fixed[data-v-6166338a]{position:fixed;top:0;left:0;width:100%}.footer-button[data-v-6166338a]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end}.footer-button .item[data-v-6166338a]{margin-right:10px}",""]),t.exports=e},c9ef:function(t,e,i){"use strict";i.d(e,"b",(function(){return n})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return a}));var a={wuiLoadLoginList:i("3a27").default,wuiTabs:i("7b31").default,wuiCard:i("8ac1").default,wuiGoodsCard:i("215a").default,wuiButton:i("6821").default,wuiLoadingMore:i("90ab").default},n=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"container"},[i("wui-load-login-list",{attrs:{loading:t.loading,list:t.list,title:t.ORDER_LIST_NOT_FIND,button:"?????????"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.redirect("/pages/goods/list/index")}},scopedSlots:t._u([{key:"list_static",fn:function(){return[i("v-uni-view",{staticClass:"fixed",staticStyle:{"z-index":"999"}},[i("wui-tabs",{attrs:{list:t.tabs,scroll:!0},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.changeStatus.apply(void 0,arguments)}},model:{value:t.active,callback:function(e){t.active=e},expression:"active"}})],1),i("v-uni-view",{staticStyle:{"min-height":"44px"}})]},proxy:!0}])},[t._l(t.list,(function(e,a){return i("wui-card",{key:a,attrs:{full:!1,shape:"round"},scopedSlots:t._u([{key:"title",fn:function(){return[i("v-uni-view",{staticStyle:{"font-size":"12px","font-weight":"normal"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.detail(e.id)}}},[t._v("????????????"+t._s(e.order_sn))])]},proxy:!0},{key:"right",fn:function(){return[i("v-uni-view",{staticStyle:{color:"#fa8c35"}},[t._v(t._s(e.order_status_text))])]},proxy:!0},{key:"content",fn:function(){return t._l(e.goods,(function(e,a){return i("wui-goods-card",{key:a,attrs:{params:e,border:!1},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.detail.apply(void 0,arguments)}},scopedSlots:t._u([{key:"subtitle",fn:function(){return[i("v-uni-view",[t._v(t._s(e.sku_name))])]},proxy:!0},{key:"bottom",fn:function(){return[i("v-uni-view",[t._v("x "+t._s(e.quantity))])]},proxy:!0}],null,!0)})}))},proxy:!0},{key:"footer",fn:function(){return[i("v-uni-view",{staticClass:"footer-button"},[1==e.order_status&&2==e.logistics_method?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0,type:"error"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.redirect("/pages/order/verify/index?id="+e.id)}}},[t._v("?????????")])],1):t._e(),3==e.order_status&&0==e.comment_status?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.redirect("/pages/order/comment/index?id="+e.id)}}},[t._v("????????????")])],1):t._e(),3==e.order_status||4==e.order_status?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.handleRemove(e.id)}}},[t._v("????????????")])],1):t._e(),2==e.order_status?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.handleReceive(e.id)}}},[t._v("????????????")])],1):t._e(),0==e.order_status?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.handleClose(e.id)}}},[t._v("????????????")])],1):t._e(),0==e.order_status?i("v-uni-view",{staticClass:"item"},[i("wui-button",{attrs:{size:"small",shape:"circle",plain:!0,type:"error"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.handlePayment(e.id)}}},[t._v("????????????")])],1):t._e()],1)]},proxy:!0}],null,!0)})})),i("wui-loading-more",{attrs:{page:t.query.page,"last-page":t.lastPage,loading:t.loadMore},on:{"update:loading":function(e){arguments[0]=e=t.$handleEvent(e),t.loadMore=e}}})],2)],1)},s=[]},ce00:function(t,e,i){"use strict";var a=i("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("5530")),s=i("2f62"),o={name:"wui-load-login-list",props:{loading:{type:Boolean,default:!1},list:{default:null},title:{type:String,default:""},button:{type:String,default:""},image:{type:String,default:""}},data:function(){return{loginShow:!1}},computed:(0,n.default)({},(0,s.mapGetters)("user",["login"])),methods:{handleClick:function(){this.$emit("click")}}};e.default=o},d211:function(t,e,i){"use strict";i.r(e);var a=i("ce00"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},eb66:function(t,e,i){"use strict";i.r(e);var a=i("fcc7"),n=i.n(a);for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);e["default"]=n.a},fcc7:function(t,e,i){"use strict";var a=i("4ea4");i("99af"),i("4160"),i("a434"),i("d3b7"),i("e25e"),i("159b"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=a(i("91e8")),s={data:function(){return{loading:!0,list:null,active:0,tabs:[{title:"??????",value:-1},{title:"?????????",value:0},{title:"?????????",value:1},{title:"?????????",value:2},{title:"?????????",value:3}],goods:[],loadMore:!1,lastPage:1,query:{page:1,status:-1}}},onLoad:function(t){t.status&&(this.query.status=t.status),this.active=parseInt(this.query.status)+1},onShow:function(){this.loadMore=!0,this.reset(),this.getList()},onReachBottom:function(){!this.loadMore&&this.lastPage>this.query.page&&(this.loadMore=!0,this.query.page+=1,this.getList())},methods:{getList:function(){var t=this;this.$get("/order",this.query).then((function(e){var i=e.data;t.lastPage=i.last_page,t.total=i.total,t.list||(t.list=[]),t.list=t.list.concat(i.data)})).finally((function(){t.loading=!1,t.loadMore=!1}))},reset:function(){this.query.page=1,this.list=null},changeStatus:function(t,e){this.active=t,this.query.status=e,this.query.page=1,this.list=null,this.loadMore=!0,this.getList()},handleRemove:function(t){var e=this;uni.showModal({title:"????????????",content:"????????????????????????",success:function(i){i.confirm&&e.$post("/order/remove",{id:t},!0).then((function(i){e.$util.toast("???????????????",(function(){e.list.forEach((function(i,a){i.id==t&&(e.list.splice(a,1),e.list=JSON.parse(JSON.stringify(e.list)))}))}))})).finally((function(){}))}})},handleReceive:function(t){var e=this;uni.showModal({title:"????????????",content:"??????????????????",success:function(i){i.confirm&&e.$post("/order/receive",{id:t},!0).then((function(i){e.$util.toast("??????????????????",(function(){e.list.forEach((function(i){i.id==t&&(i.order_status=3,e.list=JSON.parse(JSON.stringify(e.list)))}))}),"success")})).finally((function(){}))}})},handleClose:function(t){var e=this;uni.showModal({title:"????????????",content:"????????????????????????",success:function(i){i.confirm&&e.$post("/order/close",{id:t},!0).then((function(i){e.$util.toast("???????????????",(function(){e.list.forEach((function(i){i.id==t&&(i.order_status=4,e.list=JSON.parse(JSON.stringify(e.list)))}))}))})).finally((function(){}))}})},handlePayment:function(t){var e=this,i=this;i.$post("/order/payment",{id:t},!0).then((function(e){var a=e.data;n.default.switch(a).then((function(e){i.$util.toast("????????????",(function(){i.list.forEach((function(e){e.id==t&&(e.order_status=1,i.list=JSON.parse(JSON.stringify(i.list)))}))}),"success")})).catch((function(t){i.$util.toast("????????????????????????")}))})).catch((function(t){e.$util.toast(t.msg)})).finally((function(){}))},redirect:function(t){this.$util.redirect(t)},detail:function(t){this.$util.redirect("/pages/order/detail/index?id="+t)}}};e.default=s}}]);