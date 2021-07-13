DROP TABLE IF EXISTS `weitair_coupon`;
CREATE TABLE `weitair_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `coupon_name` varchar(32) NOT NULL DEFAULT '' COMMENT '优惠卷名称',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷类型(0：满减卷、1：折扣券)',
  `coupon_visible` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷公开性(0：不公开、1：公开)',
  `discount` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣率范围(0-10，9.5代表9.5折)',
  `discount_limit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大优惠金额',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '额度(单位：分)',
  `condition` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用条件(单位：分)',
  `total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发行数量(限制领取的优惠券数量)',
  `received` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取数量',
  `used` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `expire_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '到期类型(0：领取后生效、1：固定时间)',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `effective_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '有效时间(用于领取后生效：如30天后)',
  `receive_limit` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '限领(每人最多能领取数)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `goods_limit` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '适用商品(0：全部商品可用、1：指定商品可用、2：指定商品不可用)',
  `tag_limit` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '给领卷用户打标签(0：否、1：是)',
  `tag` text NOT NULL COMMENT '标签ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：已结束、1：进行中)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷';

DROP TABLE IF EXISTS `weitair_coupon_goods`;
CREATE TABLE `weitair_coupon_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷适用商品';

DROP TABLE IF EXISTS `weitair_coupon_receive`;
CREATE TABLE `weitair_coupon_receive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷ID',
  `member_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupon_name` varchar(32) NOT NULL DEFAULT '' COMMENT '优惠卷名称',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷类型(0：满减卷、1：折扣券)',
  `discount` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣率范围(0-10，9.5代表9.5折)',
  `discount_limit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最大优惠金额',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '额度(单位：分)',
  `condition` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用条件(单位：分)',
  `receive_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取时间',
  `used_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
  `expire_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '来源(0：主动领取、1：系统发放)',
  `goods_limit` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '适用商品(0：全部商品可用、1：指定商品可用、2：指定商品不可用)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：未使用、1：已使用)',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷领取';

DROP TABLE IF EXISTS `weitair_coupon_receive_goods`;
CREATE TABLE `weitair_coupon_receive_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `coupon_receive_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷适用商品';
