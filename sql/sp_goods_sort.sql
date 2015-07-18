-- ----------------------------
-- Table structure for sp_goods_sort
-- ----------------------------
DROP TABLE IF EXISTS `sp_goods_sort`;
CREATE TABLE `sp_goods_sort` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `this_week` int(4) DEFAULT '0' COMMENT '本周销量',
  `last_week` int(4) DEFAULT '0' COMMENT '上周销量',
  `this_month` int(4) DEFAULT '0' COMMENT '本月销量',
  `last_month` int(4) DEFAULT '0' COMMENT '上月销量',
  `total` int(4) DEFAULT '0' COMMENT '本周销量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

