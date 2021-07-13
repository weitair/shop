DROP TABLE IF EXISTS `weitair_article`;
CREATE TABLE `weitair_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `subtitle` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `style` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表类型(10：大图、20:左图、30：右图)',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看量',
  `best_status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐(0：否、1：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：下线、1：上线)',
  `content` text NOT NULL COMMENT '内容',
  `publish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章';

DROP TABLE IF EXISTS `weitair_article_banner`;
CREATE TABLE `weitair_article_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `redirect` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：下线、1：上线)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章横幅';

DROP TABLE IF EXISTS `weitair_article_category`;
CREATE TABLE `weitair_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `category_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(0：禁用、1：启用)',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '层级',
  `app_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '应用ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章分类';
