(global["webpackJsonp"]=global["webpackJsonp"]||[]).push([["pages/mine/address/index"],{"2a59":function(t,e,i){"use strict";(function(t){Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n=r(i("5231")),o=r(i("f4df"));function r(t){return t&&t.__esModule?t:{default:t}}var u={data:function(){return{loading:!0,submitLoading:!1,removeLoading:!1,loadMore:!1,lastPage:1,wechat:!1,popup:!1,picker:!1,order:!1,tabs:[{title:"快递地址"},{title:"同城配送地址"}],list:null,region:[],label:["家","公司","学校","其他"],form:{contact:"",phone:"",province:"",city:"",district:"",detail:"",label:0,lon:"",lat:"",type:0,default:0},query:{page:1,type:0}}},computed:{province_city_district:function(){return this.region.length?this.region.join("/"):""}},onLoad:function(t){this.wechat=!0,this.order=t.order,this.query.type=this.order?t.type:this.query.type,this.getList()},onReachBottom:function(){!this.loadMore&&this.lastPage>this.query.page&&(this.loadMore=!0,this.query.page+=1,this.getList())},methods:{getList:function(){var t=this;this.$get("/member/address",this.query).then((function(e){var i=e.data;t.lastPage=i.last_page,t.list||(t.list=[]),t.list=t.list.concat(i.data)})).finally((function(){t.loading=!1,t.loadMore=!1}))},confirmDistrict:function(t){var e=t.province,i=t.city,n=t.area;this.form.province=e.label,this.form.city=i.label,this.form.district=n.label,this.region=[e.label,i.label,n.label]},selectLocation:function(){var e=this;t.chooseLocation({success:function(t){e.form.detail=t.name,e.form.lon=t.longitude+"",e.form.lat=t.latitude+""}})},selectAddress:function(){this.picker=!0},defaultChange:function(t){this.form.default=t.detail.value?1:0},wechatAddress:function(){var e=this;t.chooseAddress({success:function(t){"chooseAddress:ok"==t.errMsg&&(e.form.contact=t.userName,e.form.phone=t.telNumber,e.form.province=t.provinceName,e.form.city=t.cityName,e.form.district=t.countyName,e.form.detail=t.detailInfo,e.region=[e.form.province,e.form.city,e.form.district],e.submit())}})},add:function(){var t=this;this.reset(),this.submitLoading=!0,this.$get("/member/address/add",this.form).then((function(e){var i=e.data;t.form.phone=i.phone,t.popup=!0})).finally((function(){t.submitLoading=!1}))},edit:function(t){var e=this;this.reset(),this.$get("/member/address/detail",{id:t}).then((function(t){var i=t.data;e.form=i,e.region=[i.province,i.city,i.district],e.popup=!0})).finally((function(){e.submitLoading=!1}))},remove:function(){var e=this;t.showModal({title:"系统提示",content:"确定删除吗？",success:function(t){t.confirm&&(e.removeLoading=!0,e.$post("/member/address/remove",{id:e.form.id}).then((function(t){e.reset(),e.list=null,e.$util.toast("删除成功",!1,"success"),e.getList()})).finally((function(){e.removeLoading=!1})))}})},submit:function(){var t=this,e=this.query.type?"/member/address/save/local":"/member/address/save";if(!t.form.contact)return t.$util.toast("请输入收货人姓名"),!1;if(!n.default.phone(t.form.phone))return this.$util.toast("请输入正确的手机号码"),!1;if(0==t.query.type){if(!t.province_city_district)return t.$util.toast("请选择所在地区"),!1;if(!t.form.detail)return t.$util.toast("请输入详细地址"),!1}else if(!t.form.detail)return t.$util.toast("请选择收货地点"),!1;t.form.type=this.query.type,t.submitLoading=!0,t.$post(e,this.form).then((function(e){t.reset(),t.list=null,t.$util.toast("保存成功",!1,"success"),t.getList()})).finally((function(){t.submitLoading=!1}))},changeTabs:function(t){this.query.type=t,this.list=null,this.loadMore=!0,this.reset(),this.getList()},reset:function(){this.form={contact:"",phone:"",province:"",city:"",district:"",detail:"",label:0,lon:"",lat:"",type:0,default:0},this.query.page=1,this.region=[],this.popup=!1},select:function(e){this.order&&(o.default.set("address",e),t.navigateBack())}}};e.default=u}).call(this,i("543d")["default"])},"8a2c":function(t,e,i){"use strict";i.d(e,"b",(function(){return o})),i.d(e,"c",(function(){return r})),i.d(e,"a",(function(){return n}));var n={wuiTabs:function(){return i.e("components/wui-tabs/wui-tabs").then(i.bind(null,"7b31"))},wuiLoadLoginList:function(){return Promise.all([i.e("common/vendor"),i.e("components/wui-load-login-list/wui-load-login-list")]).then(i.bind(null,"3a27"))},wuiCell:function(){return i.e("components/wui-cell/wui-cell").then(i.bind(null,"d5e2"))},wuiTag:function(){return i.e("components/wui-tag/wui-tag").then(i.bind(null,"2dd1"))},wuiIcon:function(){return i.e("components/wui-icon/wui-icon").then(i.bind(null,"8901"))},wuiLoadingMore:function(){return i.e("components/wui-loading-more/wui-loading-more").then(i.bind(null,"90ab"))},wuiBottomAction:function(){return i.e("components/wui-bottom-action/wui-bottom-action").then(i.bind(null,"4892"))},wuiBottomActionButton:function(){return i.e("components/wui-bottom-action-button/wui-bottom-action-button").then(i.bind(null,"456c"))},wuiPicker:function(){return Promise.all([i.e("common/vendor"),i.e("components/wui-picker/wui-picker")]).then(i.bind(null,"b654"))},wuiPopup:function(){return i.e("components/wui-popup/wui-popup").then(i.bind(null,"418e"))},wuiField:function(){return i.e("components/wui-field/wui-field").then(i.bind(null,"b0fe"))}},o=function(){var t=this,e=t.$createElement;t._self._c;t._isMounted||(t.e0=function(e,i){var n=arguments[arguments.length-1].currentTarget.dataset,o=n.eventParams||n["event-params"];i=o.index;t.form.label=i})},r=[]},"8ba5":function(t,e,i){"use strict";i.r(e);var n=i("2a59"),o=i.n(n);for(var r in n)"default"!==r&&function(t){i.d(e,t,(function(){return n[t]}))}(r);e["default"]=o.a},"9ac3":function(t,e,i){"use strict";i.r(e);var n=i("8a2c"),o=i("8ba5");for(var r in o)"default"!==r&&function(t){i.d(e,t,(function(){return o[t]}))}(r);var u,a=i("f0c5"),s=Object(a["a"])(o["default"],n["b"],n["c"],!1,null,null,null,!1,n["a"],u);e["default"]=s.exports},be44:function(t,e,i){"use strict";(function(t){i("2490");n(i("66fd"));var e=n(i("9ac3"));function n(t){return t&&t.__esModule?t:{default:t}}t(e.default)}).call(this,i("543d")["createPage"])}},[["be44","common/runtime","common/vendor"]]]);