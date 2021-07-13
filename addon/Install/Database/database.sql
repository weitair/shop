DROP TABLE IF EXISTS `weitair_account`;
CREATE TABLE `weitair_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '登录密码',
  `realname` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别(0：未知、1：男、2：女 )',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `lock_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `disable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '禁用(0：否、1：是)',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'Token',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台账号';

-- ----------------------------
-- Records of weitair_account
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_account_login
-- ----------------------------
DROP TABLE IF EXISTS `weitair_account_login`;
CREATE TABLE `weitair_account_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联账号ID',
  `user_agent` text NOT NULL COMMENT '用户代理',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端IP地址',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态（0：失败、1：成功）',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='后台管理员日志';

-- ----------------------------
-- Records of weitair_account_login
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_addon
-- ----------------------------
DROP TABLE IF EXISTS `weitair_addon`;
CREATE TABLE `weitair_addon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '插件名称',
  `intro` varchar(128) NOT NULL DEFAULT '' COMMENT '插件介绍',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `key` varchar(128) NOT NULL DEFAULT '' COMMENT '插件Key(唯一标识，不可重复)',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '插件类型(0：营销插件、1：客群维护、2：配套工具)',
  `install` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '安装状态(0：未安装，1：已安装)',
  `app_path` varchar(255) NOT NULL DEFAULT '' COMMENT '全端链接',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `KEY` (`key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='插件表';

-- ----------------------------
-- Records of weitair_addon
-- ----------------------------
INSERT INTO `weitair_addon` VALUES ('1', '优惠卷', '管理优惠卷、向客户发放优惠卷', 'el-icon-ali-ticket_fill', 'Coupon', '1', '0', '/pages_market/coupon/index/index', '1', '0', '2021-07-10 01:30:26', '2021-07-11 23:36:12', null);
INSERT INTO `weitair_addon` VALUES ('2', '分销', '基于社交管理的分销、利益分成', 'el-icon-ali-yunyingguanli_fuwufenzuguanli', 'Fenxiao', '1', '0', '/pages_market/fenxiao/index/index', '2', '0', '2021-07-10 01:31:14', '2021-07-11 23:36:14', null);
INSERT INTO `weitair_addon` VALUES ('3', '包邮', '满额满件包邮商品', 'el-icon-ali-deliver_fill', 'Freeship', '1', '0', '', '3', '0', '2021-07-10 01:32:19', '2021-07-11 23:36:15', null);
INSERT INTO `weitair_addon` VALUES ('4', '新人奖励', '新用户注册获得奖励', 'el-icon-ali-friendaddfill', 'Newcomer', '2', '0', '', '4', '0', '2021-07-10 01:34:14', '2021-07-11 23:36:16', null);
INSERT INTO `weitair_addon` VALUES ('5', '邀新奖励', '邀请新用户，邀请者获得奖励', 'el-icon-ali-group_fill', 'Invite', '2', '0', '', '5', '0', '2021-07-10 01:34:53', '2021-07-11 23:36:17', null);
INSERT INTO `weitair_addon` VALUES ('6', '签到奖励', '客户签到打卡，获取奖励', 'el-icon-ali-writefill', 'Checkin', '2', '0', '/pages_market/checkin/index', '6', '0', '2021-07-10 01:35:43', '2021-07-11 23:36:18', null);
INSERT INTO `weitair_addon` VALUES ('7', '文章内容', '官方新闻、文章内容', 'el-icon-ali-wenzhang', 'Article', '3', '0', '/pages_app/article/list/index', '7', '0', '2021-07-10 01:36:32', '2021-07-11 23:36:19', null);
INSERT INTO `weitair_addon` VALUES ('8', '弹窗广告', '消费者进入商城，用弹窗的形式将广告内容展现给用户', 'el-icon-ali-picfill', 'Popupwindow', '3', '0', '', '8', '0', '2021-07-10 01:38:20', '2021-07-11 23:36:20', null);
INSERT INTO `weitair_addon` VALUES ('9', '小票打印', '小票打印机设置', 'el-icon-ali-lishidanju-xiaopiao', 'Reciept', '3', '0', '', '9', '0', '2021-07-10 01:39:21', '2021-07-11 23:36:22', null);

-- ----------------------------
-- Table structure for weitair_assets
-- ----------------------------
DROP TABLE IF EXISTS `weitair_assets`;
CREATE TABLE `weitair_assets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组ID',
  `account_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '素材名称',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '类型(10：图片、视频)',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `upload_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='素材';

-- ----------------------------
-- Records of weitair_assets
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_assets_group
-- ----------------------------
DROP TABLE IF EXISTS `weitair_assets_group`;
CREATE TABLE `weitair_assets_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `group_name` varchar(64) NOT NULL DEFAULT '' COMMENT '分组名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='素材分组';

-- ----------------------------
-- Records of weitair_assets_group
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_cart
-- ----------------------------
DROP TABLE IF EXISTS `weitair_cart`;
CREATE TABLE `weitair_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品SKU',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品SKU名称',
  `image` varchar(512) NOT NULL DEFAULT '' COMMENT '封面图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品价格',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `goods_sku_id` (`goods_sku_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `user_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='购物车';

-- ----------------------------
-- Records of weitair_cart
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_express
-- ----------------------------
DROP TABLE IF EXISTS `weitair_express`;
CREATE TABLE `weitair_express` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `company` varchar(32) NOT NULL DEFAULT '' COMMENT '物流公司',
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '物流公司代码',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='快递公司';

-- ----------------------------
-- Records of weitair_express
-- ----------------------------
INSERT INTO `weitair_express` VALUES ('1', '顺丰速运', 'shunfeng', '101', '0', '2019-11-05 02:52:13', '2021-04-21 02:53:45', null);
INSERT INTO `weitair_express` VALUES ('2', '邮政国内', 'yzguonei', '102', '0', '2019-11-05 02:52:43', '2021-04-21 02:53:46', null);
INSERT INTO `weitair_express` VALUES ('3', '圆通速递', 'yuantong', '103', '0', '2019-11-05 02:55:20', '2021-04-21 02:53:47', null);
INSERT INTO `weitair_express` VALUES ('4', '申通快递', 'shentong', '104', '0', '2019-11-05 02:55:39', '2021-04-21 02:53:47', null);
INSERT INTO `weitair_express` VALUES ('5', '韵达快递', 'yunda', '105', '0', '2019-11-05 02:55:50', '2021-04-21 02:53:48', null);
INSERT INTO `weitair_express` VALUES ('6', '百世快递', 'huitongkuaidi', '106', '0', '2019-11-05 02:56:00', '2021-04-21 02:53:49', null);
INSERT INTO `weitair_express` VALUES ('7', '中通快递', 'zhongtong', '107', '0', '2019-11-05 02:56:13', '2021-04-21 02:53:50', null);
INSERT INTO `weitair_express` VALUES ('8', '天天快递', 'tiantian', '108', '0', '2019-11-05 02:56:27', '2021-04-21 02:53:51', null);
INSERT INTO `weitair_express` VALUES ('9', '宅急送', 'zhaijisong', '109', '0', '2019-11-05 02:56:38', '2021-04-21 02:53:53', null);

-- ----------------------------
-- Table structure for weitair_feedback
-- ----------------------------
DROP TABLE IF EXISTS `weitair_feedback`;
CREATE TABLE `weitair_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反馈分类',
  `contact` varchar(64) NOT NULL DEFAULT '' COMMENT '联系方式',
  `content` varchar(255) NOT NULL COMMENT '反馈内容',
  `feedback_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反馈时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户反馈';

-- ----------------------------
-- Records of weitair_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_feedback_category
-- ----------------------------
DROP TABLE IF EXISTS `weitair_feedback_category`;
CREATE TABLE `weitair_feedback_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序(越小越靠前)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='反馈分类';

-- ----------------------------
-- Records of weitair_feedback_category
-- ----------------------------
INSERT INTO `weitair_feedback_category` VALUES ('1', '产品质量问题', '1', '0', '2019-11-16 03:27:13', '2021-07-06 06:55:04', null);
INSERT INTO `weitair_feedback_category` VALUES ('2', '故障反馈', '2', '0', '2019-11-17 23:46:09', '2021-07-06 06:55:07', null);
INSERT INTO `weitair_feedback_category` VALUES ('3', '其他问题', '4', '0', '2019-11-17 23:51:11', '2021-05-21 05:32:21', null);

-- ----------------------------
-- Table structure for weitair_goods
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods`;
CREATE TABLE `weitair_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_sn` varchar(128) NOT NULL DEFAULT '' COMMENT '商品编号',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `subtitle` varchar(128) NOT NULL DEFAULT '' COMMENT '副标题',
  `unit` varchar(32) NOT NULL DEFAULT '' COMMENT '单位',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `video` varchar(255) NOT NULL DEFAULT '' COMMENT '视频',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售价',
  `line_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '划线价(单位：分)',
  `min_quantity` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '起购数量',
  `quota_quantity` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '限购数量(0：不限购)',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总库存',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际销量',
  `sales_init` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `sku_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '规格类型(0：单规格、1：多规格)',
  `sales_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上架时间',
  `logistics_unite` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否统一运费(0：否、1：是)',
  `logistics_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '统一运费',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递运费模板ID',
  `content` text NOT NULL COMMENT '商品详细',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `fenxiao_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分销状态(0：关闭、1：开启)',
  `fenxiao_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分销类型(0：全局分销、1：独立分销)',
  `fenxiao_scale` tinyint(3) unsigned NOT NULL DEFAULT '100' COMMENT '分润比例',
  `fenxiao_pack` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '礼包(0：否、1：是)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_sn` (`goods_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品';

-- ----------------------------
-- Records of weitair_goods
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_category
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_category`;
CREATE TABLE `weitair_goods_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `banner` varchar(255) NOT NULL DEFAULT '' COMMENT '横幅',
  `redirect_site` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序(越小越靠前)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '层级',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分类';

-- ----------------------------
-- Records of weitair_goods_category
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_category_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_category_pivot`;
CREATE TABLE `weitair_goods_category_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类ID',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分类层级',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分类中间表';

-- ----------------------------
-- Records of weitair_goods_category_pivot
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_favorite
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_favorite`;
CREATE TABLE `weitair_goods_favorite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品收藏';

-- ----------------------------
-- Records of weitair_goods_favorite
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_group
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_group`;
CREATE TABLE `weitair_goods_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分组名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分组';

-- ----------------------------
-- Records of weitair_goods_group
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_group_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_group_pivot`;
CREATE TABLE `weitair_goods_group_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品分组中间表';

-- ----------------------------
-- Records of weitair_goods_group_pivot
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_history
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_history`;
CREATE TABLE `weitair_goods_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view_total` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '浏览次数',
  `view_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品浏览历史';

-- ----------------------------
-- Records of weitair_goods_history
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_images
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_images`;
CREATE TABLE `weitair_goods_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品图片';

-- ----------------------------
-- Records of weitair_goods_images
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_sku
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_sku`;
CREATE TABLE `weitair_goods_sku` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `sku_sn` varchar(20) NOT NULL DEFAULT '' COMMENT 'sku_id',
  `sku_code` varchar(255) NOT NULL DEFAULT '' COMMENT 'sku编号',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT 'sku名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '价格(单位：分)',
  `line_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '划线价',
  `cost_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成本价(单位：分)',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '重量(单位：克)',
  `volume` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '体积(立方米)',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku_id` (`sku_sn`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品SKU';

-- ----------------------------
-- Records of weitair_goods_sku
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_sku_value
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_sku_value`;
CREATE TABLE `weitair_goods_sku_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'SKU_ID',
  `spec_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID',
  `spec_value_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格值ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品SKU值';

-- ----------------------------
-- Records of weitair_goods_sku_value
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_support
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_support`;
CREATE TABLE `weitair_goods_support` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `support_name` varchar(32) NOT NULL DEFAULT '' COMMENT '支持名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='支持模板';

-- ----------------------------
-- Records of weitair_goods_support
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_goods_support_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_support_pivot`;
CREATE TABLE `weitair_goods_support_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `support_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支持ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品支持中间表';

-- ----------------------------
-- Records of weitair_goods_support_pivot
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_growth
-- ----------------------------
DROP TABLE IF EXISTS `weitair_growth`;
CREATE TABLE `weitair_growth` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `growth` smallint(10) NOT NULL DEFAULT '0' COMMENT '成长值',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型(0：收入、1：支出)',
  `intro` varchar(64) NOT NULL DEFAULT '' COMMENT '备注',
  `change_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='成长值记录';

-- ----------------------------
-- Records of weitair_growth
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_jobs
-- ----------------------------
DROP TABLE IF EXISTS `weitair_jobs`;
CREATE TABLE `weitair_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weitair_jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of weitair_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_jobs_failed
-- ----------------------------
DROP TABLE IF EXISTS `weitair_jobs_failed`;
CREATE TABLE `weitair_jobs_failed` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of weitair_jobs_failed
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_link
-- ----------------------------
DROP TABLE IF EXISTS `weitair_link`;
CREATE TABLE `weitair_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '分组名称',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型(0：分组、1：链接)',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'KEY',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '链接地址',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COMMENT='链接';

-- ----------------------------
-- Records of weitair_link
-- ----------------------------
INSERT INTO `weitair_link` VALUES ('1', '0', '商品信息', '0', '', '5', '', '0', '2021-01-09 18:53:52', '2021-07-12 09:56:14', null);
INSERT INTO `weitair_link` VALUES ('2', '0', '基础链接', '0', '', '4', '', '0', '2021-04-08 01:06:33', '2021-07-12 09:56:08', null);
INSERT INTO `weitair_link` VALUES ('3', '2', '主页', '1', '', '1', '/pages/index/index', '0', '2021-04-08 01:58:58', '2021-05-19 00:27:16', null);
INSERT INTO `weitair_link` VALUES ('4', '2', '购物车', '1', '', '2', '/pages/cart/index', '0', '2021-04-08 02:03:05', '2021-05-19 00:29:45', null);
INSERT INTO `weitair_link` VALUES ('5', '9', '个人中心', '1', '', '1', '/pages/mine/index/index', '0', '2021-04-08 02:04:15', '2021-05-19 00:30:45', null);
INSERT INTO `weitair_link` VALUES ('6', '9', '我的订单', '1', '', '2', '/pages/order/list/index', '0', '2021-04-08 02:07:37', '2021-05-19 00:30:46', null);
INSERT INTO `weitair_link` VALUES ('9', '0', '个人中心', '0', '', '6', '', '0', '2021-04-08 02:12:18', '2021-07-12 09:56:20', null);
INSERT INTO `weitair_link` VALUES ('10', '9', '我的优惠卷', '1', '', '3', '/pages_market/coupon/mine/index', '0', '2021-04-08 02:14:18', '2021-05-19 00:30:47', null);
INSERT INTO `weitair_link` VALUES ('11', '9', '历史足迹', '1', '', '4', '/pages/mine/history/index', '0', '2021-04-08 02:15:44', '2021-07-08 23:46:09', null);
INSERT INTO `weitair_link` VALUES ('12', '9', '我的收藏', '1', '', '5', '/pages/mine/favorite/index', '0', '2021-04-08 02:16:05', '2021-05-19 00:30:49', null);
INSERT INTO `weitair_link` VALUES ('13', '9', '收货地址', '1', '', '6', '/pages/mine/address/index', '0', '2021-04-08 02:16:38', '2021-05-19 00:30:50', null);
INSERT INTO `weitair_link` VALUES ('14', '9', '我的发票', '1', '', '7', '/pages/mine/invoice/index', '0', '2021-04-08 02:16:57', '2021-05-19 00:30:51', null);
INSERT INTO `weitair_link` VALUES ('15', '9', '个人资料', '1', '', '8', '/pages/mine/profile/index/index', '0', '2021-04-08 02:17:17', '2021-05-19 00:30:51', null);
INSERT INTO `weitair_link` VALUES ('17', '2', '应用设置', '1', '', '3', '/pages_app/setting/index', '0', '2021-04-08 02:19:50', '2021-05-19 00:30:10', null);
INSERT INTO `weitair_link` VALUES ('18', '2', '关于我们', '1', '', '4', '/pages_app/about/index', '0', '2021-04-08 02:20:13', '2021-05-19 00:30:11', null);
INSERT INTO `weitair_link` VALUES ('19', '2', '用户反馈', '1', '', '5', '/pages_app/feedback/index', '0', '2021-04-08 02:20:38', '2021-05-19 00:30:13', null);
INSERT INTO `weitair_link` VALUES ('20', '1', '全部商品', '1', '', '1', '/pages/goods/list/index', '0', '2021-04-08 02:23:01', '2021-05-19 00:30:16', null);
INSERT INTO `weitair_link` VALUES ('21', '1', '商品详细', '1', 'goods', '2', '/pages/goods/detail/index', '0', '2021-04-08 02:26:15', '2021-05-19 00:30:17', null);
INSERT INTO `weitair_link` VALUES ('22', '0', '微页面', '1', 'page', '1', '/pages_app/page/index', '0', '2021-04-08 02:28:24', '2021-07-12 09:54:46', null);
INSERT INTO `weitair_link` VALUES ('23', '0', '自定义链接', '1', 'custom', '2', '', '0', '2021-04-08 02:29:10', '2021-07-12 09:55:24', null);
INSERT INTO `weitair_link` VALUES ('24', '0', '小程序路径', '1', 'wxapp', '3', '', '0', '2021-04-08 02:29:25', '2021-07-12 09:55:29', null);
INSERT INTO `weitair_link` VALUES ('25', '1', '全部分类', '1', '', '3', '/pages/goods/category/index', '0', '2021-04-21 12:30:51', '2021-05-19 00:30:23', null);
INSERT INTO `weitair_link` VALUES ('26', '1', '分类详细', '1', 'category', '4', '/pages/goods/list/index', '0', '2021-04-28 09:41:53', '2021-05-19 00:30:25', null);

-- ----------------------------
-- Table structure for weitair_member
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member`;
CREATE TABLE `weitair_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `level_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级ID',
  `invite_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '邀请人ID',
  `fenxiao_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级分销商ID',
  `fenxiao` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否分销商(0：否、1：是)',
  `unionid` varchar(64) NOT NULL DEFAULT '' COMMENT 'unionid',
  `realname` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT '密码',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别(0：未知、1：男、2：女 )',
  `birthday` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `country` varchar(128) NOT NULL DEFAULT '' COMMENT '国家',
  `province` varchar(128) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(128) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(128) NOT NULL DEFAULT '' COMMENT '区/县',
  `avatar` varchar(512) NOT NULL DEFAULT '' COMMENT '头像',
  `point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分余额',
  `growth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成长值',
  `balance` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户余额',
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '渠道(0：公众号、1：小程序、2：H5)',
  `scene` varchar(255) NOT NULL DEFAULT '' COMMENT '场景',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录的时间',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '最后登录的IP',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户';

-- ----------------------------
-- Records of weitair_member
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_address
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_address`;
CREATE TABLE `weitair_member_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '电话号码',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '行政区',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `num` varchar(128) NOT NULL DEFAULT '' COMMENT '门牌号',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '性别(1：男、2：女 )',
  `label` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '地址标签(0：家、1：公司、2：学校、3：其他)',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '地址类型(0：快递配送，1：同城配送)',
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否默认地址(0：否、1：是)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户地址';

-- ----------------------------
-- Records of weitair_member_address
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_invoice
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_invoice`;
CREATE TABLE `weitair_member_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发票类型(0：个人、1：单位)',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '个人名称',
  `company` varchar(64) NOT NULL DEFAULT '' COMMENT '公司名称',
  `tax_no` varchar(64) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_account` varchar(64) NOT NULL DEFAULT '' COMMENT '银行账号',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户发票';

-- ----------------------------
-- Records of weitair_member_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_level
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_level`;
CREATE TABLE `weitair_member_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `level` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `level_name` varchar(32) NOT NULL DEFAULT '' COMMENT '等级名称',
  `growth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成长值',
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '默认等级(0：否、1：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COMMENT='客户等级';

-- ----------------------------
-- Records of weitair_member_level
-- ----------------------------
INSERT INTO `weitair_member_level` VALUES ('1', '1', 'VIP1', '0', '1', '1', '0', '2021-03-30 02:00:28', '2021-05-27 06:10:52', null);
INSERT INTO `weitair_member_level` VALUES ('2', '2', '', '0', '0', '1', '0', '2021-03-30 02:11:24', '2021-04-21 03:00:16', null);
INSERT INTO `weitair_member_level` VALUES ('3', '3', '', '0', '0', '0', '0', '2021-03-30 02:17:53', '2021-04-21 03:00:17', null);
INSERT INTO `weitair_member_level` VALUES ('4', '4', '', '0', '0', '0', '0', '2021-03-30 02:25:47', '2021-04-21 03:00:18', null);
INSERT INTO `weitair_member_level` VALUES ('5', '5', '', '0', '0', '0', '0', '2021-03-30 02:25:50', '2021-04-21 03:00:19', null);
INSERT INTO `weitair_member_level` VALUES ('6', '6', '', '0', '0', '0', '0', '2021-03-30 02:25:54', '2021-04-21 03:00:20', null);
INSERT INTO `weitair_member_level` VALUES ('7', '7', '', '0', '0', '0', '0', '2021-03-30 02:25:57', '2021-04-21 03:00:21', null);
INSERT INTO `weitair_member_level` VALUES ('8', '8', '', '0', '0', '0', '0', '2021-03-30 02:26:00', '2021-04-21 03:00:22', null);
INSERT INTO `weitair_member_level` VALUES ('9', '9', '', '0', '0', '0', '0', '2021-03-30 02:26:03', '2021-04-21 03:00:23', null);
INSERT INTO `weitair_member_level` VALUES ('10', '10', '', '0', '0', '0', '0', '2021-03-30 02:26:07', '2021-04-21 03:00:25', null);

-- ----------------------------
-- Table structure for weitair_member_tag
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_tag`;
CREATE TABLE `weitair_member_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_name` varchar(64) NOT NULL DEFAULT '' COMMENT '标签名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户标签';

-- ----------------------------
-- Records of weitair_member_tag
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_tag_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_tag_pivot`;
CREATE TABLE `weitair_member_tag_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户标签中间表';

-- ----------------------------
-- Records of weitair_member_tag_pivot
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_weapp
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_weapp`;
CREATE TABLE `weitair_member_weapp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT '小程序OpenID',
  `session_key` varchar(64) NOT NULL DEFAULT '' COMMENT 'Session Key',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信小程序';

-- ----------------------------
-- Records of weitair_member_weapp
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_member_wechat
-- ----------------------------
DROP TABLE IF EXISTS `weitair_member_wechat`;
CREATE TABLE `weitair_member_wechat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'OpenID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号';

-- ----------------------------
-- Records of weitair_member_wechat
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_message_template
-- ----------------------------
DROP TABLE IF EXISTS `weitair_message_template`;
CREATE TABLE `weitair_message_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '功能描述',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '消息类型(0：买家消息、1：卖家消息)',
  `key` varchar(64) NOT NULL DEFAULT '' COMMENT '关键字',
  `weapp_tid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小程序模板消息的模板编号',
  `weapp_template_id` varchar(64) NOT NULL DEFAULT '' COMMENT '小程序模板消息ID',
  `weapp_content` varchar(255) NOT NULL DEFAULT '' COMMENT '小程序模板消息内容',
  `weapp_value` varchar(64) NOT NULL DEFAULT '' COMMENT '小程序模板消息排列值',
  `weapp_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '小程序模板消息状态(0：禁用、1：启用)',
  `weapp_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否支持(0：不支持、1：支持)',
  `sms_template_id` varchar(32) NOT NULL DEFAULT '' COMMENT '短信模板ID',
  `sms_content` varchar(255) NOT NULL DEFAULT '' COMMENT '短信消息内容',
  `sms_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '短信模板状态(0：禁用、1：启用)',
  `sms_enable` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否支持(0：不支持、1：支持)',
  `sms_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '短信类型(0：验证码、1：短信通知)',
  `system` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '系统级，不能关闭',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='消息模板表';

-- ----------------------------
-- Records of weitair_message_template
-- ----------------------------
INSERT INTO `weitair_message_template` VALUES ('1', '订单发货通知', 'el-icon-ali-deliver', '用于商家发货后通知用户', '0', 'ORDER_SHIPPED', '3637', '', '[{\"key\":\"character_string2\",\"value\":\"订单号\"},{\"key\":\"thing14\",\"value\":\"订单内容\"},{\"key\":\"date3\",\"value\":\"发货时间\"},{\"key\":\"thing6\",\"value\":\"备注\"}]', '[2,14,3,6]', '1', '1', 'SMS_215796659', '尊敬的会员，您编号为${ordersn}的订单已发货。', '1', '1', '1', '0', '1', '0', '2021-04-11 06:38:37', '2021-07-07 05:03:35', null);
INSERT INTO `weitair_message_template` VALUES ('2', '核销成功通知', 'el-icon-ali-hexiao', '用于订单核销成功之后通知用户', '0', 'ORDER_VERIFY', '10056', '', '[{\"key\":\"character_string11\",\"value\":\"订单号\"},{\"key\":\"thing1\",\"value\":\"商品名称\"},{\"key\":\"time10\",\"value\":\"核销时间\"}]', '[11,1,10]', '1', '1', 'SMS_215791689', '尊敬的会员，您编号为${ordersn}的订单核销成功。', '1', '1', '1', '0', '2', '0', '2021-04-12 04:00:34', '2021-07-06 07:06:07', null);
INSERT INTO `weitair_message_template` VALUES ('3', '分销商审核结果通知', 'el-icon-ali-subtitle_unblock_light', '用于通知申请分销商的用户审核结果', '0', 'FENXIAO_VERIFY', '3576', '', '[{\"key\":\"name1\",\"value\":\"申请名称\"},{\"key\":\"phone_number2\",\"value\":\"联系方式\"},{\"key\":\"phrase3\",\"value\":\"审核结果\"}]', '[1,2,3]', '1', '1', 'SMS_215796634', '尊敬的${username}，您${status}分销商资格审核，详情请登录应用查看。', '1', '1', '1', '0', '3', '0', '2021-04-12 04:06:12', '2021-07-06 07:06:08', null);
INSERT INTO `weitair_message_template` VALUES ('4', '用户注册验证码', 'el-icon-ali-friendadd', '用于H5端或公众号端用户注册下发的短信验证码', '0', 'REGISTER_CODE', '0', '', '', '', '0', '0', 'SMS_215066182', '验证码：${code}。此验证码只用于用户注册，10分钟内有效，请勿泄露。', '1', '1', '0', '1', '5', '0', '2021-04-24 16:09:40', '2021-07-02 03:46:28', null);
INSERT INTO `weitair_message_template` VALUES ('5', '用户登录验证码', 'el-icon-ali-unlock', '用于H5端或公众号端用户登录下发的短信验证码', '0', 'LOGIN_CODE', '0', '', '', '', '0', '0', 'SMS_215121129', '验证码：${code}。此验证码只用于短信登录，10分钟内有效，请勿泄露。', '1', '1', '0', '1', '6', '0', '2021-04-25 07:22:18', '2021-07-02 03:46:30', null);
INSERT INTO `weitair_message_template` VALUES ('10', '买家支付通知', 'el-icon-ali-pay', '用于有用户下单并支付成功之后发短信通知商家，接收通知的人员请在：店铺->员工菜单中添加。', '1', 'NEW_ORDER', '0', '', '', '', '0', '0', 'SMS_177350128', '您有新的订单，请及时处理。', '1', '1', '1', '0', '1', '0', '2021-04-16 06:08:56', '2021-07-02 03:57:11', null);
INSERT INTO `weitair_message_template` VALUES ('11', '分销商提现审核结果通知', 'el-icon-ali-redpacket', '用于通知分销商申请提现的审核结果', '0', 'FENXIAO_WITHDRAW', '6698', '', '[{\"key\":\"amount3\",\"value\":\"提现金额\"},{\"key\":\"phrase4\",\"value\":\"提现结果\"},{\"key\":\"thing8\",\"value\":\"提现方式\"},{\"key\":\"date1\",\"value\":\"申请时间\"},{\"key\":\"thing5\",\"value\":\"备注\"}]', '[3,4,8,1,5]', '1', '1', 'SMS_215801569', '您申请提现的${money}元佣金，审核${status}。', '1', '1', '1', '0', '4', '0', '2021-07-02 03:30:05', '2021-07-06 07:06:11', null);

-- ----------------------------
-- Table structure for weitair_module
-- ----------------------------
DROP TABLE IF EXISTS `weitair_module`;
CREATE TABLE `weitair_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `module_name` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `icon` varchar(64) NOT NULL DEFAULT '' COMMENT '图标',
  `server_router` varchar(64) NOT NULL DEFAULT '' COMMENT '服务端路由',
  `client_router` varchar(64) NOT NULL DEFAULT '' COMMENT '前端路由',
  `redirect` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '层级(最多3级菜单)',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型(0：目录、1：菜单、2：权限)',
  `extend` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否权限继承(0：否、1：是 )',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否隐藏(0：否、1：是 )',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `addon_key` varchar(128) NOT NULL DEFAULT '' COMMENT '插件Key',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '简介',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10505 DEFAULT CHARSET=utf8mb4 COMMENT='系统模块';

-- ----------------------------
-- Records of weitair_module
-- ----------------------------
INSERT INTO `weitair_module` VALUES ('2', '系统', '0', 'el-icon-ali-repairfill', '', '/system', '', '0', '0', '0', '0', '7', '', '', '0', '2019-09-26 20:53:21', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('3', '应用', '0', 'el-icon-ali-appstore-fill', '', '/addon', '', '0', '0', '0', '1', '8', '', '', '0', '2021-01-07 16:30:41', '2021-07-10 23:44:29', null);
INSERT INTO `weitair_module` VALUES ('4', '设置', '0', 'el-icon-ali-setting-fill', '', '/setting', '', '0', '0', '0', '0', '6', '', '', '0', '2019-11-05 01:50:43', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10002', '账号', '2', 'el-icon-ali-my_fill_light', '', '/system/account', '/system/account/list', '1', '1', '0', '0', '0', '', '', '0', '2019-09-29 14:16:08', '2021-06-01 02:10:22', null);
INSERT INTO `weitair_module` VALUES ('10004', '角色', '2', 'el-icon-ali-friendaddfill', '', '/system/role', '/system/role/list', '1', '1', '0', '0', '1', '', '', '0', '2019-09-29 14:16:08', '2021-06-01 02:07:43', null);
INSERT INTO `weitair_module` VALUES ('10016', '日志', '2', 'el-icon-ali-rizhi', '', '/system/log', '/system/log/list', '1', '1', '0', '0', '5', '', '', '0', '2019-09-29 14:16:08', '2021-06-01 02:10:28', null);
INSERT INTO `weitair_module` VALUES ('10029', '客户', '0', 'el-icon-ali-peoplefill', '', '/member', '', '0', '0', '0', '0', '3', '', '', '0', '2019-09-26 20:53:21', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10030', '资料', '10029', 'el-icon-ali-profilefill', '', '/member/profile', '/member/profile/list', '1', '1', '0', '0', '1', '', '', '0', '2019-09-26 20:25:24', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10031', '商品', '0', 'el-icon-ali-goodsfill', '', '/goods', '', '0', '0', '0', '0', '1', '', '', '0', '2019-10-12 22:54:42', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10032', '商品', '10031', 'el-icon-ali-goodsfill', '', '/goods/stock', '/goods/stock/list', '1', '1', '0', '0', '1', '', '', '0', '2019-10-12 22:57:58', '2021-06-01 02:10:51', null);
INSERT INTO `weitair_module` VALUES ('10033', '分类', '10031', 'el-icon-ali-appstore-fill', '', '/goods/category', '/goods/category/list', '1', '1', '0', '0', '2', '', '', '0', '2019-10-12 23:03:05', '2021-06-01 02:10:56', null);
INSERT INTO `weitair_module` VALUES ('10034', '规格', '10031', 'el-icon-ali-squarecheckfill', '', '/goods/spec', '/goods/spec/list', '1', '1', '0', '0', '4', '', '', '0', '2019-10-14 13:49:37', '2021-06-01 02:11:02', null);
INSERT INTO `weitair_module` VALUES ('10035', '添加', '10002', '', 'system/account.submit', '/system/account/add', '', '2', '2', '0', '0', '1', '', '', '0', '2019-10-17 01:45:26', '2021-06-01 02:11:20', null);
INSERT INTO `weitair_module` VALUES ('10037', '删除', '10002', '', 'system/account.remove', '', '', '2', '2', '0', '0', '3', '', '', '0', '2019-10-17 01:47:24', '2021-06-01 01:30:59', null);
INSERT INTO `weitair_module` VALUES ('10038', '添加', '10004', '', 'system/role.submit', '/system/role/add', '', '2', '2', '0', '0', '1', '', '', '0', '2019-10-17 01:48:15', '2021-06-01 02:08:21', null);
INSERT INTO `weitair_module` VALUES ('10040', '删除', '10004', '', 'system/role.remove', '', '', '2', '2', '0', '0', '3', '', '', '0', '2019-10-17 01:49:06', '2021-06-01 02:07:43', null);
INSERT INTO `weitair_module` VALUES ('10044', '删除', '10016', '', 'system/log.remove', '', '', '1', '2', '0', '0', '1', '', '', '0', '2019-10-17 01:55:05', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10051', '添加', '10033', '', 'goods/category.add', '/goods/category/add', '', '1', '2', '0', '0', '1', '', '', '0', '2019-10-17 02:06:17', '2021-06-01 02:11:31', null);
INSERT INTO `weitair_module` VALUES ('10052', '删除', '10033', '', 'goods/category.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2019-10-17 02:06:31', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10053', '添加', '10034', '', 'goods/spec.add', '/goods/spec/add', '', '1', '2', '0', '0', '1', '', '', '0', '2019-10-17 02:07:49', '2021-06-01 02:11:34', null);
INSERT INTO `weitair_module` VALUES ('10054', '删除', '10034', '', 'goods/spec.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2019-10-17 02:08:05', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10055', '添加', '10032', '', 'goods/stock.add', '/goods/stock/add', '', '1', '2', '0', '0', '1', '', '', '0', '2019-10-17 02:08:41', '2021-06-01 02:11:36', null);
INSERT INTO `weitair_module` VALUES ('10056', '删除', '10032', '', 'goods/stock.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2019-10-17 02:08:55', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10059', '订单', '0', 'el-icon-ali-form_fill_light', '', '/order', '', '0', '0', '0', '0', '2', '', '', '0', '2019-10-18 18:26:34', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10060', '订单', '10059', 'el-icon-ali-form_fill_light', '', '/order/record', '/order/record/list', '1', '1', '0', '0', '1', '', '', '0', '2019-10-18 18:28:17', '2021-06-01 02:12:45', null);
INSERT INTO `weitair_module` VALUES ('10071', '系统', '4', 'el-icon-ali-control-fill', '', '/setting/system', '', '1', '1', '0', '0', '0', '', '', '0', '2019-11-05 01:58:54', '2021-06-01 02:13:27', null);
INSERT INTO `weitair_module` VALUES ('10082', '详细', '10030', '', 'member/profile.detail', '/member/profile/detail', '', '1', '2', '0', '0', '1', '', '', '0', '2019-12-08 03:10:52', '2021-06-03 08:07:27', null);
INSERT INTO `weitair_module` VALUES ('10083', '财务', '0', 'el-icon-ali-rechargefill', '', '/finance', '', '0', '0', '0', '0', '4', '', '', '0', '2019-12-08 03:31:46', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10084', '支付流水', '10083', 'el-icon-ali-rechargefill', '', '/finance/payment', '/finance/payment/list', '1', '1', '0', '0', '1', '', '', '0', '2019-12-08 03:33:48', '2021-06-01 02:13:36', null);
INSERT INTO `weitair_module` VALUES ('10089', '订单发货', '10060', '', 'order/record.shipment', '/order/record/shipment', '', '1', '2', '0', '0', '2', '', '', '0', '2019-12-22 02:41:10', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10090', '评价', '10059', 'el-icon-ali-comment_fill_light', '', '/order/comment', '/order/comment/list', '1', '1', '0', '0', '4', '', '', '0', '2019-12-22 06:02:36', '2021-06-01 02:14:06', null);
INSERT INTO `weitair_module` VALUES ('10091', '审核', '10090', '', 'order/comment.audit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2019-12-22 06:04:11', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10092', '删除', '10090', '', 'order/comment.remove', '', '', '1', '2', '0', '0', '4', '', '', '0', '2019-12-22 06:04:48', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10105', '补打小票', '10060', '', 'order/record.prints', '', '', '1', '2', '0', '0', '7', '', '', '0', '2020-06-21 02:25:59', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10126', '反馈', '10029', 'el-icon-ali-messagefill', '', '', '', '1', '0', '0', '0', '4', '', '', '0', '2020-06-23 09:29:56', '2021-06-01 02:15:34', null);
INSERT INTO `weitair_module` VALUES ('10128', '支持', '10031', 'el-icon-ali-medal_fill_light', '', '/goods/support', '/goods/support/list', '1', '1', '0', '0', '5', '', '', '0', '2020-06-25 03:49:18', '2021-06-01 02:15:27', null);
INSERT INTO `weitair_module` VALUES ('10129', '添加', '10128', '', 'goods/support.add', '/goods/support/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-06-25 03:50:14', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10130', '删除', '10128', '', 'goods/support.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-06-25 03:50:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10138', '消息', '4', 'el-icon-ali-messagefill', '', '/setting/message', '', '1', '1', '0', '0', '4', '', '', '0', '2020-08-01 03:07:09', '2021-06-01 02:15:43', null);
INSERT INTO `weitair_module` VALUES ('10139', '店铺', '0', 'el-icon-ali-shopfill', '', '/shop', '', '0', '0', '0', '0', '0', '', '', '0', '2020-08-02 02:09:47', '2021-06-01 02:04:53', null);
INSERT INTO `weitair_module` VALUES ('10147', '物流', '4', 'el-icon-ali-deliver_fill', '', '/setting/logistics', '', '1', '1', '0', '0', '5', '', '', '0', '2020-08-03 12:23:17', '2021-06-01 02:15:50', null);
INSERT INTO `weitair_module` VALUES ('10148', '地址', '10139', 'el-icon-ali-locationfill', '', '/shop/address', '/shop/address/list', '1', '1', '0', '0', '3', '', '', '0', '2020-08-05 05:14:42', '2021-06-01 02:15:56', null);
INSERT INTO `weitair_module` VALUES ('10149', '添加', '10148', '', 'shop/address.add', '/shop/address/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-08-05 05:15:11', '2021-06-01 02:15:58', null);
INSERT INTO `weitair_module` VALUES ('10150', '删除', '10148', '', 'shop/address.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-08-05 05:15:26', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10151', '装修', '10139', 'el-icon-ali-zhuangxiu', '', '', '', '1', '0', '0', '0', '0', '', '', '0', '2020-08-06 10:23:41', '2021-06-01 01:53:26', null);
INSERT INTO `weitair_module` VALUES ('10153', '分组', '10031', 'el-icon-ali-yunyingguanli_fuwufenzuguanli', '', '/goods/group', '/goods/group/list', '1', '1', '0', '0', '3', '', '', '0', '2020-08-08 12:12:00', '2021-06-01 02:16:10', null);
INSERT INTO `weitair_module` VALUES ('10154', '添加', '10153', '', 'goods/group.add', '/goods/group/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-08-08 12:12:42', '2021-06-01 02:16:12', null);
INSERT INTO `weitair_module` VALUES ('10155', '删除', '10153', '', 'goods/group.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-08-08 12:13:06', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10156', '发票', '10059', 'el-icon-ali-ticket_money_fill', '', '/order/invoice', '/order/invoice/list', '1', '1', '0', '0', '3', '', '', '0', '2020-08-17 17:20:32', '2021-06-01 02:16:20', null);
INSERT INTO `weitair_module` VALUES ('10157', '开票', '10156', '', 'order/invoice.make', '/order/invoice/make', '', '2', '2', '0', '0', '1', '', '', '0', '2020-08-17 17:24:20', '2021-06-01 02:16:23', null);
INSERT INTO `weitair_module` VALUES ('10160', '员工', '10139', 'el-icon-ali-profilefill', '', '/shop/employee', '/shop/employee/list', '1', '1', '0', '0', '4', '', '', '0', '2020-08-21 06:10:21', '2021-06-01 02:16:27', null);
INSERT INTO `weitair_module` VALUES ('10161', '添加', '10160', '', 'shop/employee.add', '/shop/employee/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-08-21 06:10:48', '2021-06-01 02:16:31', null);
INSERT INTO `weitair_module` VALUES ('10162', '删除', '10160', '', 'shop/employee.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-08-21 06:11:03', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10163', '单位', '10031', 'el-icon-ali-cheng', '', '/goods/unit', '/goods/unit/list', '1', '1', '0', '0', '6', '', '', '0', '2020-08-26 05:50:46', '2021-06-01 02:16:42', null);
INSERT INTO `weitair_module` VALUES ('10164', '添加', '10163', '', 'goods/unit.add', '/goods/unit/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-08-26 05:51:06', '2021-06-01 02:16:44', null);
INSERT INTO `weitair_module` VALUES ('10165', '删除', '10163', '', 'goods/unit.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-08-26 05:51:21', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10169', '标签', '10029', 'el-icon-ali-tagfill', '', '/member/tag', '/member/tag/list', '1', '1', '0', '0', '3', '', '', '0', '2020-09-22 08:28:52', '2021-06-01 02:16:59', null);
INSERT INTO `weitair_module` VALUES ('10170', '添加', '10169', '', 'member/tag.add', '/member/tag/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-09-22 08:29:11', '2021-06-01 02:17:03', null);
INSERT INTO `weitair_module` VALUES ('10171', '删除', '10169', '', 'member/tag.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-09-22 08:29:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10172', '打标签', '10030', '', 'member/profile/edit.tag', '', '', '2', '2', '0', '0', '3', '', '', '0', '2020-09-28 14:38:50', '2021-06-03 08:07:27', null);
INSERT INTO `weitair_module` VALUES ('10173', '页面', '10139', 'el-icon-ali-layout-fill', '', '/shop/page', '/shop/page/list', '1', '1', '0', '0', '1', '', '', '0', '2020-10-13 11:10:41', '2021-06-01 02:17:18', null);
INSERT INTO `weitair_module` VALUES ('10174', '添加', '10173', '', 'shop/page.add', '/shop/page/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-10-13 11:11:48', '2021-06-01 02:17:20', null);
INSERT INTO `weitair_module` VALUES ('10175', '删除', '10173', '', 'shop/page.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-10-13 11:12:07', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10178', '反馈', '10126', '', '', '/member/feedback/index', '/member/feedback/index/list', '1', '1', '0', '0', '0', '', '', '0', '2020-11-06 16:38:56', '2021-06-01 02:17:29', null);
INSERT INTO `weitair_module` VALUES ('10180', '分类', '10126', '', '', '/member/feedback/category', '/member/feedback/category/list', '1', '1', '0', '0', '1', '', '', '0', '2020-11-06 16:55:50', '2021-06-01 02:17:45', null);
INSERT INTO `weitair_module` VALUES ('10181', '删除', '10178', '', 'member/feedback.remove', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-11-06 17:02:56', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10182', '添加', '10180', '', 'member/feedback/category.add', '/member/feedback/category/add', '', '1', '2', '0', '0', '1', '', '', '0', '2020-11-06 17:27:33', '2021-06-01 02:18:25', null);
INSERT INTO `weitair_module` VALUES ('10183', '删除', '10180', '', 'member/feedback/category.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2020-11-06 17:30:46', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10187', '设置', '10059', 'el-icon-ali-setting-fill', '', '/order/setting', '', '1', '1', '0', '0', '5', '', '', '0', '2020-11-17 14:33:36', '2021-06-01 02:18:44', null);
INSERT INTO `weitair_module` VALUES ('10212', '首页', '10151', '', '', '/shop/design', '', '1', '1', '0', '0', '0', '', '', '0', '2020-12-13 05:29:10', '2021-06-01 02:04:53', null);
INSERT INTO `weitair_module` VALUES ('10213', '保存', '10212', '', 'shop/design.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-12-13 05:35:05', '2021-06-01 02:04:53', null);
INSERT INTO `weitair_module` VALUES ('10214', '分类页面', '10151', '', '', '/shop/design/category', '', '1', '1', '0', '0', '2', '', '', '0', '2020-12-14 15:46:32', '2021-06-01 02:20:56', null);
INSERT INTO `weitair_module` VALUES ('10215', '购物车页面', '10151', '', '', '/shop/design/cart', '', '1', '1', '0', '0', '4', '', '', '0', '2020-12-14 15:47:11', '2021-06-01 02:20:58', null);
INSERT INTO `weitair_module` VALUES ('10216', '底部导航', '10151', '', '', '/shop/design/tabbar', '', '1', '1', '0', '0', '1', '', '', '0', '2020-12-14 15:48:13', '2021-06-01 02:21:00', null);
INSERT INTO `weitair_module` VALUES ('10218', '会员页面', '10151', '', '', '/shop/design/mine', '', '1', '1', '0', '0', '3', '', '', '0', '2020-12-14 15:51:13', '2021-06-01 02:21:01', null);
INSERT INTO `weitair_module` VALUES ('10219', '保存', '10216', '', 'shop/design/tabbar.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-12-15 03:49:12', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10220', '保存', '10214', '', 'shop/design/category.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-12-15 03:50:45', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10221', '保存', '10218', '', 'shop/design/mine.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-12-15 03:51:02', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10222', '保存', '10215', '', 'shop/design/cart.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2020-12-15 03:51:17', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10236', '财务数据', '10083', 'el-icon-ali-rankfill', 'finance.index', '/finance/index', '', '1', '1', '0', '0', '0', '', '', '0', '2020-12-31 15:37:32', '2021-06-01 02:22:00', null);
INSERT INTO `weitair_module` VALUES ('10238', '数据', '10031', 'el-icon-ali-rankfill', 'goods.index', '/goods/index', '', '1', '1', '0', '0', '0', '', '', '0', '2021-01-02 16:01:05', '2021-06-01 02:22:55', null);
INSERT INTO `weitair_module` VALUES ('10239', '数据', '10059', 'el-icon-ali-rankfill', 'order.index', '/order/index', '', '1', '1', '0', '0', '0', '', '', '0', '2021-01-02 16:01:34', '2021-06-01 02:23:01', null);
INSERT INTO `weitair_module` VALUES ('10240', '数据', '10029', 'el-icon-ali-rankfill', 'member.index', '/member/index', '', '1', '1', '0', '0', '0', '', '', '0', '2021-01-02 16:02:00', '2021-06-01 02:23:06', null);
INSERT INTO `weitair_module` VALUES ('10256', '素材', '2', 'el-icon-ali-picfill', '', '', '', '1', '0', '0', '0', '3', '', '', '0', '2021-01-09 16:30:54', '2021-06-01 02:57:15', null);
INSERT INTO `weitair_module` VALUES ('10257', '素材', '10256', '', '', '/system/assets/index', '/system/assets/index/list', '2', '1', '0', '0', '0', '', '', '0', '2021-01-09 16:32:58', '2021-06-01 03:07:28', null);
INSERT INTO `weitair_module` VALUES ('10258', '删除', '10257', '', 'system/assets.remove', '', '', '3', '2', '0', '0', '1', '', '', '0', '2021-01-09 16:33:56', '2021-06-01 02:57:38', null);
INSERT INTO `weitair_module` VALUES ('10259', '分组', '10256', '', '', '/system/assets/group', '/system/assets/group/list', '2', '1', '0', '0', '1', '', '', '0', '2021-01-09 16:34:37', '2021-06-01 02:57:15', null);
INSERT INTO `weitair_module` VALUES ('10260', '添加', '10259', '', 'system/assets/group.submit', '/system/assets/group/add', '', '1', '2', '0', '0', '1', '', '', '0', '2021-01-09 16:35:10', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10261', '删除', '10259', '', 'system/assets/group.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2021-01-09 16:35:35', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10263', '链接', '2', 'el-icon-ali-lianjie', '', '/system/link', '/system/link/list', '1', '1', '0', '0', '4', '', '', '0', '2021-01-09 18:09:37', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10265', '添加', '10263', '', 'system/link.submit', '/system/link/add', '', '1', '2', '0', '0', '1', '', '', '0', '2021-01-09 18:10:45', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10266', '删除', '10263', '', 'system/link.remove', '', '', '1', '2', '0', '0', '3', '', '', '0', '2021-01-09 18:11:01', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10285', '等级', '10029', 'el-icon-ali-crownfill', '', '/member/level', '/member/level/list', '1', '1', '0', '0', '2', '', '', '0', '2021-03-03 06:44:40', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10286', '编辑', '10285', '', 'member/level.edit', '/member/level/edit', '', '2', '2', '0', '0', '1', '', '', '0', '2021-03-03 06:45:30', '2021-07-12 09:20:05', null);
INSERT INTO `weitair_module` VALUES ('10288', '支付', '4', 'el-icon-s-finance', '', '/setting/payment', '', '1', '1', '0', '0', '2', '', '', '0', '2021-04-05 03:25:38', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10289', '应用', '4', 'el-icon-menu', '', '/setting/app', '', '1', '1', '0', '0', '1', '', '', '0', '2021-04-07 03:15:58', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10291', '设置', '10031', 'el-icon-ali-setting-fill', '', '/goods/setting', '', '1', '1', '0', '0', '100', '', '', '0', '2021-04-09 00:44:06', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10292', '渠道', '0', 'el-icon-ali-qudao1', '', '/channel', '', '0', '0', '0', '0', '5', '', '', '0', '2021-04-11 06:58:02', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10293', '公众号', '10292', 'el-icon-ali-gongzhonghao', '', '', '', '1', '0', '0', '0', '0', '', '', '0', '2021-04-11 07:02:34', '2021-06-01 03:09:18', null);
INSERT INTO `weitair_module` VALUES ('10294', '小程序', '10292', 'el-icon-ali-xiaochengxu', '', '', '', '1', '0', '0', '0', '1', '', '', '0', '2021-04-11 07:03:25', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10295', '设置', '10293', '', '', '/channel/wechat/setting', '', '2', '1', '0', '0', '2', '', '', '0', '2021-04-11 07:06:54', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10296', '设置', '10294', '', '', '/channel/weapp/setting', '', '2', '1', '0', '0', '2', '', '', '0', '2021-04-11 07:07:29', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10298', '订阅消息', '10294', '', '', '/channel/weapp/subscribe', '/channel/weapp/subscribe/list', '2', '1', '0', '0', '1', '', '', '0', '2021-04-11 08:33:07', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10299', '同步', '10298', '', 'channel/weapp/subscribe.sync', '', '', '1', '2', '0', '0', '1', '', '', '0', '2021-04-11 23:01:35', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10302', '编辑', '10002', '', 'system/account.submit', '/system/account/edit', '', '2', '2', '0', '0', '2', '', '', '0', '2021-04-13 06:12:32', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10304', '编辑', '10004', '', 'system/role.submit', '/system/role/edit', '', '2', '2', '0', '0', '2', '', '', '0', '2021-04-13 06:22:37', '2021-06-01 02:09:36', null);
INSERT INTO `weitair_module` VALUES ('10306', '列表', '10002', '', 'system/account.list', '/system/account/list', '', '2', '2', '0', '0', '0', '', '', '0', '2021-04-14 00:27:25', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10307', '列表', '10004', '', 'system/role.list', '/system/role/list', '', '2', '2', '0', '0', '0', '', '', '0', '2021-04-14 01:04:21', '2021-06-01 02:08:00', null);
INSERT INTO `weitair_module` VALUES ('10308', '列表', '10257', '', 'system/assets.list', '/system/assets/index/list', '', '3', '2', '0', '0', '0', '', '', '0', '2021-04-14 01:13:53', '2021-06-01 03:02:11', null);
INSERT INTO `weitair_module` VALUES ('10309', '编辑', '10259', '', 'system/assets/group.submit', '/system/assets/group/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 01:19:14', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10310', '列表', '10259', '', 'system/assets/group.list', '/system/assets/group/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 01:19:52', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10311', '列表', '10263', '', 'system/link.list', '/system/link/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 01:23:02', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10312', '编辑', '10263', '', 'system/link.submit', '/system/link/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 01:23:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10313', '列表', '10016', '', 'system/log.list', '/system/log/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 01:24:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10328', '配置', '10288', '', 'setting/payment/config.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-14 03:31:06', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10339', '列表', '10173', '', 'shop/page.list', '/shop/page/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 05:01:08', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10340', '编辑', '10173', '', 'shop/page.edit', '/shop/page/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 05:01:36', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10343', '列表', '10148', '', 'shop/address.list', '/shop/address/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 05:04:49', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10344', '编辑', '10148', '', 'shop/address.edit', '/shop/address/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 05:05:14', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10345', '列表', '10160', '', 'shop/employee.list', '/shop/employee/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 05:06:17', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10346', '编辑', '10160', '', 'shop/employee.edit', '/shop/employee/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 05:06:36', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10348', '列表', '10032', '', 'goods/stock.list', '/goods/stock/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:07:07', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10349', '编辑', '10032', '', 'goods/stock.edit', '/goods/stock/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:07:41', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10350', '编辑', '10033', '', 'goods/category.edit', '/goods/category/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:09:02', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10351', '列表', '10033', '', 'goods/category.list', '/goods/category/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:09:21', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10352', '列表', '10153', '', 'goods/group.list', '/goods/group/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:10:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10353', '编辑', '10153', '', 'goods/group.edit', '/goods/group/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:10:53', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10354', '编辑', '10034', '', 'goods/spec.edit', '/goods/spec/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:14:57', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10355', '列表', '10034', '', 'goods/spec.list', '/goods/spec/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:15:26', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10356', '编辑', '10128', '', 'goods/support.edit', '/goods/support/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:16:56', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10357', '列表', '10128', '', 'goods/support.list', '/goods/support/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:17:18', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10358', '编辑', '10163', '', 'goods/unit.edit', '/goods/unit/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 06:18:28', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10359', '列表', '10163', '', 'goods/unit.list', '/goods/unit/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:18:50', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10360', '保存', '10291', '', 'goods/setting.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-14 06:19:42', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10361', '列表', '10060', '', 'order/record.list', '/order/record/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 06:57:22', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10362', '修改地址', '10060', '', 'order/record.logistics', '/order/record/logistics', '', '1', '2', '0', '0', '6', '', '', '0', '2021-04-14 07:00:15', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10363', '订单备注', '10060', '', 'order/record.remark', '/order/record/remark', '', '1', '2', '0', '0', '3', '', '', '0', '2021-04-14 07:00:38', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10364', '订单改价', '10060', '', 'order/record.price', '/order/record/price', '', '1', '2', '0', '0', '4', '', '', '0', '2021-04-14 07:01:00', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10365', '列表', '10156', '', 'order/invoice.list', '/order/invoice/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 07:02:30', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10367', '列表', '10090', '', 'order/comment.list', '/order/comment/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 07:06:33', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10368', '回复', '10090', '', 'order/comment.reply', '/order/comment/reply', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 07:08:45', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10369', '保存', '10187', '', 'order/setting.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-14 07:09:51', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10370', '详情', '10060', '', 'order/record.detail', '/order/record/detail', '', '1', '2', '0', '0', '1', '', '', '0', '2021-04-14 07:25:24', '2021-06-25 08:20:59', null);
INSERT INTO `weitair_module` VALUES ('10371', '编辑', '10169', '', 'member/tag.edit', '/member/tag/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 07:48:50', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10372', '列表', '10169', '', 'member/tag.list', '/member/tag/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 07:49:12', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10373', '编辑', '10180', '', 'member/feedback/category.edit', '/member/feedback/category/edit', '', '1', '2', '0', '0', '2', '', '', '0', '2021-04-14 07:52:43', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10374', '列表', '10180', '', 'member/feedback/category.list', '/member/feedback/category/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 07:53:10', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10375', '列表', '10178', '', 'member/feedback.list', '/member/feedback/index/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 08:07:01', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10376', '列表', '10030', '', 'member/profile.list', '/member/profile/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 08:12:19', '2021-06-03 08:07:27', null);
INSERT INTO `weitair_module` VALUES ('10377', '列表', '10285', '', 'member/level.list', '/member/level/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 08:22:31', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10378', '列表', '10084', '', 'finance/payment.list', '/finance/payment/list', '', '1', '2', '0', '0', '100', '', '', '0', '2021-04-14 09:11:53', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10379', '保存', '10295', '', 'channel/wechat/setting.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2021-04-14 09:19:14', '2021-06-01 03:09:18', null);
INSERT INTO `weitair_module` VALUES ('10380', '保存', '10296', '', 'channel/weapp/setting.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2021-04-14 09:19:58', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10381', '列表', '10298', '', 'channel/weapp/subscribe.list', '/channel/weapp/subscribe/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-14 09:26:46', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10417', '粉丝', '10293', '', '', '/channel/wechat/fans', '/channel/wechat/fans/list', '2', '1', '0', '0', '0', '', '', '0', '2021-04-15 07:59:28', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10418', '同步', '10417', '', 'channel/wechat/fans.sync', '', '', '1', '2', '0', '0', '1', '', '', '0', '2021-04-15 08:00:21', '2021-06-01 03:09:18', null);
INSERT INTO `weitair_module` VALUES ('10419', '列表', '10417', '', 'channel/wechat/fans.list', '/channel/wechat/fans/list', '', '1', '2', '0', '0', '0', '', '', '0', '2021-04-15 08:09:10', '2021-06-01 03:09:18', null);
INSERT INTO `weitair_module` VALUES ('10420', '保存', '10071', '', 'setting/system.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-16 03:39:19', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10421', '保存', '10289', '', 'setting/app.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-16 03:53:29', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10422', '保存', '10147', '', 'setting/logistics.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-16 04:10:32', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10423', '保存', '10138', '', 'setting/message.submit', '', '', '2', '2', '0', '0', '1', '', '', '0', '2021-04-16 05:27:41', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10431', '发布程序', '10294', '', 'channel/weapp/release.index', '/channel/weapp/release', '', '2', '1', '0', '0', '0', '', '', '0', '2021-04-22 02:50:59', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10432', '下载代码包', '10431', '', 'channel/weapp/release.download', '', '', '1', '2', '0', '0', '100', '', '', '0', '2021-04-22 03:49:59', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10433', 'H5', '10292', 'el-icon-ali-mobilefill', '', '', '', '1', '0', '0', '0', '2', '', '', '0', '2021-04-27 16:08:43', '2021-06-01 03:10:02', null);
INSERT INTO `weitair_module` VALUES ('10434', '发布', '10433', '', 'channel/h5/release.index', '/channel/h5/release', '', '2', '1', '0', '0', '100', '', '', '0', '2021-04-27 16:11:52', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10435', '提交', '10434', '', 'channel/h5/release.submit', '', '', '1', '2', '0', '0', '100', '', '', '0', '2021-04-27 16:13:32', '2021-06-01 03:10:02', null);
INSERT INTO `weitair_module` VALUES ('10443', '核销', '10059', 'el-icon-ali-hexiao', 'order/verify.list', '/order/verify', '', '1', '1', '0', '0', '2', '', '', '0', '2021-04-30 01:56:41', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10445', '提交', '10443', '', 'order/verify.submit', '', '', '2', '2', '0', '0', '100', '', '', '0', '2021-04-30 02:12:03', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10449', '设置', '10139', 'el-icon-ali-setting-fill', '', '/shop/setting', '', '1', '1', '0', '0', '100', '', '', '0', '2021-05-19 08:12:20', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10450', '保存', '10449', '', 'shop/setting.submit', '', '', '1', '2', '0', '0', '1', '', '', '0', '2021-05-19 08:12:49', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10454', '查看', '10212', '', 'shop/design.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:24:11', '2021-06-01 02:04:53', null);
INSERT INTO `weitair_module` VALUES ('10455', '查看', '10216', '', 'shop/design/tabbar.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:25:57', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10456', '查看', '10214', '', 'shop/design/category.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:26:24', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10457', '查看', '10218', '', 'shop/design/mine.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:26:50', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10458', '查看', '10215', '', 'shop/design/cart.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:27:18', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10459', '查看', '10449', '', 'shop/setting.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:28:40', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10460', '查看', '10291', '', 'goods/setting.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:31:24', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10461', '查看', '10187', '', 'order/setting.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:33:25', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10462', '查看', '10295', '', 'channel/wechat/setting.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:36:54', '2021-06-01 03:09:18', null);
INSERT INTO `weitair_module` VALUES ('10463', '查看', '10296', '', 'channel/weapp/setting.index', '', '', '1', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:38:44', '2021-06-01 03:09:50', null);
INSERT INTO `weitair_module` VALUES ('10464', '查看', '10071', '', 'setting/system.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:39:53', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10465', '查看', '10289', '', 'setting/app.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:40:16', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10466', '查看', '10288', '', 'setting/payment.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:40:38', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10467', '查看', '10138', '', 'setting/message.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:42:06', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10468', '查看', '10147', '', 'setting/logistics.index', '', '', '2', '2', '0', '0', '0', '', '', '0', '2021-05-25 07:42:36', '2021-06-01 01:37:38', null);
INSERT INTO `weitair_module` VALUES ('10478', '给积分', '10030', '', 'member/profile/edit.point', '', '', '2', '2', '0', '0', '4', '', '', '0', '2021-06-03 08:06:25', '2021-06-03 08:07:27', null);
INSERT INTO `weitair_module` VALUES ('10479', '编辑', '10030', '', 'member/profile/edit.info', '/member/profile/edit', '', '2', '2', '0', '0', '2', '', '', '0', '2021-06-03 08:07:14', '2021-06-04 00:26:02', null);
INSERT INTO `weitair_module` VALUES ('10489', '订单签收', '10060', '', 'order/record.receive', '', '', '2', '2', '0', '0', '5', '', '', '0', '2021-06-25 08:20:34', '2021-06-25 08:23:28', null);

-- ----------------------------
-- Table structure for weitair_order
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order`;
CREATE TABLE `weitair_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户优惠卷ID',
  `order_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '订单编号',
  `logistics_method` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配送方式(0：快递发货、1：同城配送、2：上门自提)',
  `logistics_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费',
  `package_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '包裹状态(0：单包裹、多包裹)',
  `goods_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品合计金额',
  `coupon_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷金额',
  `discount_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠金额',
  `change_price` int(11) NOT NULL DEFAULT '0' COMMENT '改价金额',
  `payment_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际支付金额',
  `payment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `payment_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态(0：未支付、1：已支付)',
  `payment_channel` varchar(16) NOT NULL DEFAULT '' COMMENT '支付渠道(wechat)',
  `shipment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `shipment_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态(0：未发货、1：部分发货、2：已发货)',
  `receive_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '签收状态(0：未签收、2：已签收)',
  `finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单完成时间',
  `finish_time_auto` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动签收时间',
  `close_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关闭时间',
  `close_time_auto` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自动关闭时间',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `order_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单类型(0：默认订单)',
  `order_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '订单状态(0：待支付、1：待发货、2：待收货、3：已完成、4：已关闭)',
  `order_progress` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '订单进度(0：未开始、1：进行中、2：已完成)',
  `comment_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '评论(0：未评论、1：已评论)',
  `invoice_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发票(0：不开票、1：开票)',
  `delete_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户删除(0：未删除、1：已删除)',
  `message` varchar(255) NOT NULL DEFAULT '' COMMENT '买家留言',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '渠道(0：公众号、1：小程序、2：H5)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_sn` (`order_sn`) USING BTREE,
  KEY `receive_status` (`receive_status`) USING BTREE,
  KEY `order_status` (`order_status`) USING BTREE,
  KEY `order_time` (`order_time`) USING BTREE,
  KEY `payment_status` (`payment_status`) USING BTREE,
  KEY `member_id` (`member_id`) USING BTREE,
  KEY `shipment_status` (`shipment_status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单';

-- ----------------------------
-- Records of weitair_order
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_comment
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_comment`;
CREATE TABLE `weitair_order_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品SKUID',
  `satisfaction` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '满意度(0：差评、1：中评、2：好评)',
  `rate` tinyint(3) unsigned NOT NULL DEFAULT '5' COMMENT '分值',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `comment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `reply` varchar(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `reply_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '回复状态(0：待回复、1：已回复)',
  `top_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '置顶状态(0：否、1：是)',
  `image_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否包含图片(0：无图片、1：有图片)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：待审核、1：拒绝、2：通过)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='商品评论';

-- ----------------------------
-- Records of weitair_order_comment
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_comment_images
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_comment_images`;
CREATE TABLE `weitair_order_comment_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `comment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论ID',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='评论图片';

-- ----------------------------
-- Records of weitair_order_comment_images
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_fetch
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_fetch`;
CREATE TABLE `weitair_order_fetch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客户ID',
  `address_name` varchar(64) NOT NULL DEFAULT '' COMMENT '自提点名称',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系电话',
  `business` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '营业时间类型(0：全天、1：自定)',
  `business_begin` varchar(16) NOT NULL DEFAULT '' COMMENT '营业时间',
  `business_end` varchar(16) NOT NULL DEFAULT '' COMMENT '打烊时间',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '行政区',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `verify_code` varchar(32) NOT NULL DEFAULT '' COMMENT '核销码',
  `fetch_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '提货状态(0：待提货、1：已提货)',
  `fetch_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提货时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单自提';

-- ----------------------------
-- Records of weitair_order_fetch
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_goods`;
CREATE TABLE `weitair_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品SKU',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sku_sn` varchar(20) NOT NULL DEFAULT '' COMMENT 'sku_id',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品SKU名称',
  `shipment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `shipment_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态(0：未发货、1：已发货)',
  `image` varchar(512) NOT NULL DEFAULT '' COMMENT '封面图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品价格',
  `line_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '划线价',
  `cost_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成本价',
  `weight` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品重量(单位：克)',
  `volume` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '体积(立方米)',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `goods_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品合计金额(sales_price * quantity)',
  `payment_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际支付金额',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `goods_sku_id` (`goods_sku_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单商品';

-- ----------------------------
-- Records of weitair_order_goods
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_invoice
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_invoice`;
CREATE TABLE `weitair_order_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `member_id` int(11) DEFAULT NULL,
  `category` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发票类型(0：个人、1：单位)',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '抬头内容',
  `company` varchar(64) NOT NULL DEFAULT '' COMMENT '公司名称',
  `tax_no` varchar(64) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_account` varchar(64) NOT NULL DEFAULT '' COMMENT '银行账号',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tax` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '税金',
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '发票代码',
  `invoicing_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开票时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '处理状态(0：未开票、1：已开票)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单发票';

-- ----------------------------
-- Records of weitair_order_invoice
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_logistics
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_logistics`;
CREATE TABLE `weitair_order_logistics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客户ID',
  `address_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '客户地址ID',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人电话',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '区/县',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `num` varchar(32) NOT NULL DEFAULT '' COMMENT '门牌号',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别(0：未知、1：男、2：女 )',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '地址类型(0：快递配送，1：同城配送)',
  `delivery_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '配送时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单物流';

-- ----------------------------
-- Records of weitair_order_logistics
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_package
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_package`;
CREATE TABLE `weitair_order_package` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `express_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递公司ID',
  `express_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '快递单号',
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '配送渠道(0：商家配送、1：第三方配送)',
  `employee_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '员工ID',
  `delivery` varchar(32) NOT NULL DEFAULT '' COMMENT '配送员',
  `verifier` varchar(32) NOT NULL DEFAULT '' COMMENT '核销员',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单包裹';

-- ----------------------------
-- Records of weitair_order_package
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_package_item
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_package_item`;
CREATE TABLE `weitair_order_package_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `package_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '包裹ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单包裹明细';

-- ----------------------------
-- Records of weitair_order_package_item
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_order_verify
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_verify`;
CREATE TABLE `weitair_order_verify` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `verifier` varchar(32) NOT NULL DEFAULT '0' COMMENT '核销员',
  `verify_code` varchar(32) NOT NULL DEFAULT '' COMMENT '核销码',
  `verify_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '核销时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='核销记录';

-- ----------------------------
-- Records of weitair_order_verify
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_page
-- ----------------------------
DROP TABLE IF EXISTS `weitair_page`;
CREATE TABLE `weitair_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '页面名称',
  `header` text NOT NULL COMMENT '导航栏',
  `content` text NOT NULL COMMENT '内容',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `home` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否首页(0：否、1：是)',
  `view` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：下线、1：上线)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='主题页面';

-- ----------------------------
-- Records of weitair_page
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_payment
-- ----------------------------
DROP TABLE IF EXISTS `weitair_payment`;
CREATE TABLE `weitair_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户OPEN_ID',
  `transaction_id` varchar(64) NOT NULL DEFAULT '' COMMENT '微信支付交易ID',
  `payment_sn` varchar(32) NOT NULL DEFAULT '' COMMENT '支付流水号',
  `payment_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付金额',
  `payment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `payment_channel` varchar(16) NOT NULL DEFAULT '' COMMENT '支付渠道(wechat)',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT 'IP',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '支付状态(0：未支付、1：支付中、2：已支付)',
  `channel` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '渠道(0：公众号、1：小程序、2：H5)',
  `response` varchar(1024) NOT NULL DEFAULT '' COMMENT '支付响应结果',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_sn` (`payment_sn`) USING BTREE,
  KEY `member_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='支付流水';

-- ----------------------------
-- Records of weitair_payment
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_payment_channel
-- ----------------------------
DROP TABLE IF EXISTS `weitair_payment_channel`;
CREATE TABLE `weitair_payment_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '渠道名称',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT '英文名称',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `default` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '默认(0：否、1：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='支付渠道';

-- ----------------------------
-- Records of weitair_payment_channel
-- ----------------------------
INSERT INTO `weitair_payment_channel` VALUES ('1', '微信支付', 'wechat', '0', '1', '1', '在公众号或者小程序中使用的支付方式', '0', '2021-04-07 00:17:28', '2021-04-21 03:06:15', null);

-- ----------------------------
-- Table structure for weitair_point
-- ----------------------------
DROP TABLE IF EXISTS `weitair_point`;
CREATE TABLE `weitair_point` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `point` smallint(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '类型(0：收入、1：支出)',
  `intro` varchar(64) NOT NULL DEFAULT '' COMMENT '备注',
  `change_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`member_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分记录';

-- ----------------------------
-- Records of weitair_point
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_role
-- ----------------------------
DROP TABLE IF EXISTS `weitair_role`;
CREATE TABLE `weitair_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `intro` mediumtext NOT NULL COMMENT '角色简介',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='角色';

-- ----------------------------
-- Records of weitair_role
-- ----------------------------
INSERT INTO `weitair_role` VALUES ('1', '管理员', '系统管理员角色，不可删除', '0', '2019-09-14 01:03:47', '2021-04-21 03:08:34', null);

-- ----------------------------
-- Table structure for weitair_role_module
-- ----------------------------
DROP TABLE IF EXISTS `weitair_role_module`;
CREATE TABLE `weitair_role_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `module_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模块ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `module_id` (`module_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限';

-- ----------------------------
-- Records of weitair_role_module
-- ----------------------------
INSERT INTO `weitair_role_module` VALUES ('323', '1', '10139', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('324', '1', '10151', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('325', '1', '10212', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('326', '1', '10454', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('327', '1', '10213', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('328', '1', '10216', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('329', '1', '10455', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('330', '1', '10219', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('331', '1', '10214', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('332', '1', '10456', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('333', '1', '10220', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('334', '1', '10218', '0', '2021-07-12 09:33:22', '2021-07-12 09:33:22', null);
INSERT INTO `weitair_role_module` VALUES ('335', '1', '10457', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('336', '1', '10221', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('337', '1', '10215', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('338', '1', '10458', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('339', '1', '10222', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('340', '1', '10173', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('341', '1', '10339', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('342', '1', '10174', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('343', '1', '10340', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('344', '1', '10175', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('345', '1', '10148', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('346', '1', '10343', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('347', '1', '10149', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('348', '1', '10344', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('349', '1', '10150', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('350', '1', '10160', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('351', '1', '10345', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('352', '1', '10161', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('353', '1', '10346', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('354', '1', '10162', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('355', '1', '10449', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('356', '1', '10459', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('357', '1', '10450', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('358', '1', '10031', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('359', '1', '10238', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('360', '1', '10032', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('361', '1', '10348', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('362', '1', '10055', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('363', '1', '10349', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('364', '1', '10056', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('365', '1', '10033', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('366', '1', '10351', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('367', '1', '10051', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('368', '1', '10350', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('369', '1', '10052', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('370', '1', '10153', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('371', '1', '10352', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('372', '1', '10154', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('373', '1', '10353', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('374', '1', '10155', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('375', '1', '10034', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('376', '1', '10355', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('377', '1', '10053', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('378', '1', '10354', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('379', '1', '10054', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('380', '1', '10128', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('381', '1', '10357', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('382', '1', '10129', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('383', '1', '10356', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('384', '1', '10130', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('385', '1', '10163', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('386', '1', '10359', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('387', '1', '10164', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('388', '1', '10358', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('389', '1', '10165', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('390', '1', '10291', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('391', '1', '10460', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('392', '1', '10360', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('393', '1', '10059', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('394', '1', '10239', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('395', '1', '10060', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('396', '1', '10361', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('397', '1', '10370', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('398', '1', '10089', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('399', '1', '10363', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('400', '1', '10364', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('401', '1', '10489', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('402', '1', '10362', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('403', '1', '10105', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('404', '1', '10443', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('405', '1', '10445', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('406', '1', '10156', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('407', '1', '10365', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('408', '1', '10157', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('409', '1', '10090', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('410', '1', '10367', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('411', '1', '10091', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('412', '1', '10368', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('413', '1', '10092', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('414', '1', '10187', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('415', '1', '10461', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('416', '1', '10369', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('417', '1', '10029', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('418', '1', '10240', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('419', '1', '10030', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('420', '1', '10376', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('421', '1', '10082', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('422', '1', '10479', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('423', '1', '10172', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('424', '1', '10478', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('425', '1', '10285', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('426', '1', '10377', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('427', '1', '10286', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('428', '1', '10169', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('429', '1', '10372', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('430', '1', '10170', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('431', '1', '10371', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('432', '1', '10171', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('433', '1', '10126', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('434', '1', '10178', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('435', '1', '10375', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('436', '1', '10181', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('437', '1', '10180', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('438', '1', '10374', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('439', '1', '10182', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('440', '1', '10373', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('441', '1', '10183', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('442', '1', '10083', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('443', '1', '10236', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('444', '1', '10084', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('445', '1', '10378', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('446', '1', '10292', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('447', '1', '10293', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('448', '1', '10417', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('449', '1', '10419', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('450', '1', '10418', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('451', '1', '10295', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('452', '1', '10462', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('453', '1', '10379', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('454', '1', '10294', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('455', '1', '10431', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('456', '1', '10432', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('457', '1', '10298', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('458', '1', '10381', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('459', '1', '10299', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('460', '1', '10296', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('461', '1', '10463', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('462', '1', '10380', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('463', '1', '10433', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('464', '1', '10434', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('465', '1', '10435', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('466', '1', '4', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('467', '1', '10071', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('468', '1', '10464', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('469', '1', '10420', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('470', '1', '10289', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('471', '1', '10465', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('472', '1', '10421', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('473', '1', '10288', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('474', '1', '10466', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('475', '1', '10328', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('476', '1', '10138', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('477', '1', '10467', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('478', '1', '10423', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('479', '1', '10147', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('480', '1', '10468', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('481', '1', '10422', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('482', '1', '2', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('483', '1', '10002', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('484', '1', '10306', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('485', '1', '10035', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('486', '1', '10302', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('487', '1', '10037', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('488', '1', '10004', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('489', '1', '10307', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('490', '1', '10038', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('491', '1', '10304', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('492', '1', '10040', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('493', '1', '10256', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('494', '1', '10257', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('495', '1', '10308', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('496', '1', '10258', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('497', '1', '10259', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('498', '1', '10310', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('499', '1', '10260', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('500', '1', '10309', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('501', '1', '10261', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('502', '1', '10263', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('503', '1', '10311', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('504', '1', '10265', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('505', '1', '10312', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('506', '1', '10266', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('507', '1', '10016', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('508', '1', '10313', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('509', '1', '10044', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);
INSERT INTO `weitair_role_module` VALUES ('510', '1', '3', '0', '2021-07-12 09:33:23', '2021-07-12 09:33:23', null);

-- ----------------------------
-- Table structure for weitair_search
-- ----------------------------
DROP TABLE IF EXISTS `weitair_search`;
CREATE TABLE `weitair_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `keyword` varchar(128) NOT NULL DEFAULT '' COMMENT '关键词',
  `search_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '搜索时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='搜索记录';

-- ----------------------------
-- Records of weitair_search
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_setting
-- ----------------------------
DROP TABLE IF EXISTS `weitair_setting`;
CREATE TABLE `weitair_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category` varchar(32) NOT NULL DEFAULT '' COMMENT '分类',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'Key',
  `values` text NOT NULL COMMENT '内容',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_key` (`category`,`key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=372 DEFAULT CHARSET=utf8mb4 COMMENT='系统设置';

-- ----------------------------
-- Records of weitair_setting
-- ----------------------------
INSERT INTO `weitair_setting` VALUES ('3', 'goods', 'share', '{\"background\":\"#F56C6C\",\"title\":\"为你挑选了一个好物\",\"color\":\"#FFFFFF\"}', '0', '2021-04-16 04:27:28', '2021-04-21 03:18:34', null);
INSERT INTO `weitair_setting` VALUES ('10', 'system', 'security', '{\"lock\":1,\"limited_time_length\":15,\"fail_times\":3,\"lock_time_length\":15}', '0', '2021-04-16 03:48:26', '2021-04-21 03:18:40', null);
INSERT INTO `weitair_setting` VALUES ('13', 'app', 'location', '{\"name\":\"\",\"key\":\"\"}', '0', '2021-04-21 04:18:38', '2021-07-07 04:50:04', null);
INSERT INTO `weitair_setting` VALUES ('24', 'app', 'base', '{\"app_name\":\"微态尔商城\",\"app_logo\":\"assets/uniapp/logo.png\"}', '0', '2021-04-21 05:31:20', '2021-07-07 04:51:30', null);
INSERT INTO `weitair_setting` VALUES ('64', 'wechat', 'weapp', '{\"app_id\":\"\",\"app_secret\":\"\"}', '0', '2021-05-07 04:38:44', '2021-07-07 04:55:05', null);
INSERT INTO `weitair_setting` VALUES ('65', 'wechat', 'base', '{\"app_id\":\"\",\"app_secret\":\"\"}', '0', '2021-05-07 04:39:01', '2021-07-07 04:55:08', null);
INSERT INTO `weitair_setting` VALUES ('144', 'system', 'base', '{\"title\":\"微态尔商城\",\"intro\":\"以工匠精神打磨产品，以科技助客户创造价值\",\"logo\":\"assets/uniapp/system-logo.png\",\"icp\":\"黔ICP备18004309号-1\",\"icp_link\":\"https://beian.miit.gov.cn\",\"gongan\":\"贵公网安备52010202000678号\",\"gongan_link\":\"http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=52010202000678\"}', '0', '2021-05-19 04:09:15', '2021-07-07 05:00:41', null);
INSERT INTO `weitair_setting` VALUES ('145', 'system', 'copyright', '{\"copyright\":\"© 2018-2021 贵州微态尔科技有限公司 版权所有\",\"link\":\"https://www.weitair.com\"}', '0', '2021-05-19 04:39:58', '2021-05-19 04:39:58', null);
INSERT INTO `weitair_setting` VALUES ('161', 'shop', 'base', '{\"status\":1,\"business\":0,\"business_begin\":\"08:30\",\"business_end\":\"18:30\"}', '0', '2021-05-25 07:29:37', '2021-05-25 07:29:37', null);
INSERT INTO `weitair_setting` VALUES ('172', 'payment', 'wechat', '{\"mch_id\":\"\",\"mch_key\":\"\"}', '0', '2021-06-07 03:33:07', '2021-07-07 04:53:24', null);
INSERT INTO `weitair_setting` VALUES ('202', 'logistics', 'local', '{\"method\":0,\"distance\":10,\"weight\":5,\"sort\":100,\"item\":[{\"min\":0,\"max\":3,\"fee\":3}]}', '0', '2021-06-07 05:39:39', '2021-07-07 04:56:12', null);
INSERT INTO `weitair_setting` VALUES ('349', 'logistics', 'base', '{\"method\":[0,1,2],\"freight_plan\":2}', '0', '2021-07-05 01:06:34', '2021-07-07 04:51:55', null);
INSERT INTO `weitair_setting` VALUES ('360', 'design', 'tabbar', '{\"page_name\":\"\",\"style\":\"default\",\"background\":\"#ffffff\",\"color\":\"#7d7e80\",\"color_active\":\"#353535\",\"item\":[{\"text\":\"首页\",\"link\":{\"name\":\"主页\",\"path\":\"/pages/index/index\"},\"image\":\"assets/uniapp/diy/tabbar/home.png\",\"image_active\":\"assets/uniapp/diy/tabbar/home-active.png\"},{\"text\":\"分类\",\"link\":{\"name\":\"分类\",\"path\":\"/pages/goods/category/index\"},\"image\":\"assets/uniapp/diy/tabbar/category.png\",\"image_active\":\"assets/uniapp/diy/tabbar/category-active.png\"},{\"text\":\"购物车\",\"link\":{\"name\":\"购物车\",\"path\":\"/pages/cart/index\"},\"image\":\"assets/uniapp/diy/tabbar/cart.png\",\"image_active\":\"assets/uniapp/diy/tabbar/cart-active.png\"},{\"text\":\"我的\",\"link\":{\"name\":\"我的\",\"path\":\"/pages/mine/index/index\"},\"image\":\"assets/uniapp/diy/tabbar/mine.png\",\"image_active\":\"assets/uniapp/diy/tabbar/mine-active.png\"}]}', '0', '2021-07-07 01:24:55', '2021-07-07 01:24:55', null);
INSERT INTO `weitair_setting` VALUES ('362', 'design', 'cart', '[]', '0', '2021-07-07 01:57:17', '2021-07-07 01:57:17', null);
INSERT INTO `weitair_setting` VALUES ('364', 'design', 'mine', '[{\"id\":1,\"type\":\"mine\",\"name\":\"会员信息\",\"fixed\":true,\"data\":{\"background_image\":\"\",\"color\":\"#FFFFFF\"}},{\"id\":2,\"type\":\"fixed\",\"name\":\"固定区域\",\"fixed\":true},{\"id\":3,\"type\":\"grid\",\"name\":\"宫格导航\",\"data\":{\"margin\":8,\"column\":4,\"shape\":\"circle\",\"background\":\"#fff\",\"color\":\"#353535\",\"size\":40,\"images\":[{\"image\":\"assets/uniapp/diy/icon/coupon.png\",\"link\":{\"name\":\"我的优惠卷\",\"path\":\"/pages_market/coupon/mine/index\"},\"text\":\"优惠卷\"},{\"image\":\"assets/uniapp/diy/icon/checkin.png\",\"link\":{\"name\":\"每日签到\",\"path\":\"/pages_market/checkin/index\"},\"text\":\"签到有礼\"},{\"image\":\"assets/uniapp/diy/icon/address.png\",\"link\":{\"name\":\"收货地址\",\"path\":\"/pages/mine/address/index\"},\"text\":\"地址管理\"},{\"image\":\"assets/uniapp/diy/icon/favorite.png\",\"link\":{\"name\":\"我的收藏\",\"path\":\"/pages/mine/favorite/index\"},\"text\":\"我的收藏\"},{\"image\":\"assets/uniapp/diy/icon/history.png\",\"link\":{\"name\":\"历史足迹\",\"path\":\"/pages/mine/history/index\"},\"text\":\"历史足迹\"},{\"image\":\"assets/uniapp/diy/icon/feedback.png\",\"link\":{\"name\":\"用户反馈\",\"path\":\"/pages_app/feedback/index\"},\"text\":\"用户反馈\"},{\"image\":\"assets/uniapp/diy/icon/profile.png\",\"link\":{\"name\":\"个人资料\",\"path\":\"/pages/mine/profile/index/index\"},\"text\":\"个人资料\"},{\"image\":\"assets/uniapp/diy/icon/setting.png\",\"link\":{\"name\":\"应用设置\",\"path\":\"/pages_app/setting/index\"},\"text\":\"设置\"}]}}]', '0', '2021-07-07 03:16:51', '2021-07-08 23:46:47', null);
INSERT INTO `weitair_setting` VALUES ('365', 'design', 'category', '{\"level\":2,\"style\":\"2\"}', '0', '2021-07-07 04:43:29', '2021-07-07 04:43:29', null);
INSERT INTO `weitair_setting` VALUES ('367', 'system', 'storage', '{\"driver\":\"local\"}', '0', '2021-07-07 04:53:41', '2021-07-07 04:53:59', null);
INSERT INTO `weitair_setting` VALUES ('368', 'order', 'base', '{\"stock\":0,\"invoice\":0,\"close\":15,\"receive\":7,\"service\":7,\"comment\":0}', '0', '2021-07-07 04:56:36', '2021-07-07 04:56:36', null);
INSERT INTO `weitair_setting` VALUES ('370', 'message', 'sms', '{\"status\":0,\"driver\":\"ali\",\"app_id\":\"\",\"app_secret\":\"\",\"sign\":\"\"}', '0', '2021-07-07 05:06:07', '2021-07-07 05:06:21', null);

-- ----------------------------
-- Table structure for weitair_sms
-- ----------------------------
DROP TABLE IF EXISTS `weitair_sms`;
CREATE TABLE `weitair_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '消息模板ID',
  `key` varchar(64) NOT NULL DEFAULT '' COMMENT '关键字',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` varchar(8) NOT NULL DEFAULT '' COMMENT '验证码',
  `send_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `expire_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '短信类型(0：验证码、1：短信通知)',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '发送状态(0：失败、1：成功)',
  `used` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '使用状态(0：未使用、1：已使用)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='短信记录';

-- ----------------------------
-- Records of weitair_sms
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_spec
-- ----------------------------
DROP TABLE IF EXISTS `weitair_spec`;
CREATE TABLE `weitair_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '规格名称',
  `search` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否搜索属性(10：否、20：是)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='规格';

-- ----------------------------
-- Records of weitair_spec
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `weitair_spec_value`;
CREATE TABLE `weitair_spec_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `spec_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '规格值',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='规格值';

-- ----------------------------
-- Records of weitair_spec_value
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_store_address
-- ----------------------------
DROP TABLE IF EXISTS `weitair_store_address`;
CREATE TABLE `weitair_store_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `address_name` varchar(64) NOT NULL DEFAULT '' COMMENT '自提点名称',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系电话',
  `business` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '营业时间类型(10：全天、20：自定)',
  `business_begin` varchar(16) NOT NULL DEFAULT '' COMMENT '营业时间',
  `business_end` varchar(16) NOT NULL DEFAULT '' COMMENT '打烊时间',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '行政区',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_fetch` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否自提地址(10：否、20：是)',
  `is_shipment` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否发货地址(10：否、20：是)',
  `is_refund` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否发货地址(10：否、20：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='门店地址库';

-- ----------------------------
-- Records of weitair_store_address
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_store_employee
-- ----------------------------
DROP TABLE IF EXISTS `weitair_store_employee`;
CREATE TABLE `weitair_store_employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '接单员',
  `verifier` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否核销员(0：否、1：是)',
  `delivery` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否配送员(0：否、1：是)',
  `status` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='门店员工';

-- ----------------------------
-- Records of weitair_store_employee
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_template
-- ----------------------------
DROP TABLE IF EXISTS `weitair_template`;
CREATE TABLE `weitair_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '模板名称',
  `method` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '计价方式(0：按件数、1：按重量)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='快递模板';

-- ----------------------------
-- Records of weitair_template
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_template_item
-- ----------------------------
DROP TABLE IF EXISTS `weitair_template_item`;
CREATE TABLE `weitair_template_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递模板ID',
  `region` text NOT NULL COMMENT '区域',
  `first` double unsigned NOT NULL DEFAULT '0' COMMENT '首件/首重',
  `first_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首件/首重费用(单位：分)',
  `additional` double unsigned NOT NULL DEFAULT '0' COMMENT '续件/续重',
  `additional_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '续件/续重费用(单位：分)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='快递模板项目';

-- ----------------------------
-- Records of weitair_template_item
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_unit
-- ----------------------------
DROP TABLE IF EXISTS `weitair_unit`;
CREATE TABLE `weitair_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `unit_name` varchar(32) NOT NULL DEFAULT '' COMMENT '单位名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='单位';

-- ----------------------------
-- Records of weitair_unit
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_uv
-- ----------------------------
DROP TABLE IF EXISTS `weitair_uv`;
CREATE TABLE `weitair_uv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端IP地址',
  `entry_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '进入时间',
  `quit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退出时间',
  `user_agent` text NOT NULL COMMENT '客户端',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='访问量';

-- ----------------------------
-- Records of weitair_uv
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_wechat_fans
-- ----------------------------
DROP TABLE IF EXISTS `weitair_wechat_fans`;
CREATE TABLE `weitair_wechat_fans` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'openid',
  `unionid` varchar(255) NOT NULL DEFAULT '' COMMENT 'unionid',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '用户的昵称',
  `headimgurl` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `sex` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户的性别，值为1时是男性，值为2时是女性，值为0时是未知',
  `country` varchar(128) NOT NULL DEFAULT '' COMMENT '用户所在国家',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '用户所在省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '用户所在城市',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT '用户的语言，简体中文为zh_CN',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '公众号运营者对粉丝的备注',
  `subscribe` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '用户是否订阅该公众号标识，值为0时，代表此用户没有关注该公众号，拉取不到其余信息',
  `subscribe_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户关注时间',
  `subscribe_scene` varchar(64) NOT NULL DEFAULT '' COMMENT '用户关注的渠道来源，ADD_SCENE_SEARCH 公众号搜索，ADD_SCENE_ACCOUNT_MIGRATION 公众号迁移，ADD_SCENE_PROFILE_CARD 名片分享，ADD_SCENE_QR_CODE 扫描二维码，ADD_SCENE_PROFILE_LINK 图文页内名称点击，ADD_SCENE_PROFILE_ITEM 图文页右上角菜单，ADD_SCENE_PAID 支付后关注，ADD_SCENE_WECHAT_ADVERTISEMENT 微信广告，ADD_SCENE_OTHERS 其他',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='微信粉丝';

-- ----------------------------
-- Records of weitair_wechat_fans
-- ----------------------------
