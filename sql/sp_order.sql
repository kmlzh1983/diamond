/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : hmv

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-04-17 09:55:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sp_order
-- ----------------------------
DROP TABLE IF EXISTS `sp_order`;
CREATE TABLE `sp_order` (
  `order_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `order_sn` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '购买用户的id',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为未确认,1为已确认,2为取消订单,3为无效订单,4为退货,5为已分单,6为部分分单',
  `shipping_status` tinyint(1) unsigned DEFAULT '0' COMMENT '0为未发货,1为已发货',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为未付款,1为已付款',
  `country` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '国家代码',
  `province` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '省份代码',
  `city` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '城市代码',
  `district` smallint(5) NOT NULL DEFAULT '0' COMMENT '区/县代码',
  `address` varchar(255) NOT NULL DEFAULT '0' COMMENT '完整收获地址',
  `consignee` varchar(50) NOT NULL DEFAULT '0' COMMENT '收货人名字',
  `best_time` varchar(200) NOT NULL DEFAULT '0' COMMENT '最佳送货时间',
  `zipcode` varchar(60) NOT NULL DEFAULT '0' COMMENT '邮编',
  `tel` varchar(60) NOT NULL DEFAULT '0' COMMENT '电话',
  `mobile` varchar(60) NOT NULL DEFAULT '0' COMMENT '手机',
  `email` varchar(60) NOT NULL DEFAULT '0' COMMENT '邮箱',
  `pay_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '付款方式的id',
  `pay_name` varchar(120) NOT NULL DEFAULT '0' COMMENT '付款名称',
  `money_goods` decimal(10,0) DEFAULT NULL,
  `money_paid` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '总付款',
  `pack_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '打包费用',
  `pay_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '付款手续费',
  `shipping_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递费用',
  `insure_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保险费用',
  `receipt_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '发票税额',
  `card_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '贺卡费用',
  `discount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣金额',
  `package_type` varchar(20) NOT NULL DEFAULT '0' COMMENT '包装类型',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单创建时间',
  `pay_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `shipping_id` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '快递id',
  `shipping_name` varchar(100) NOT NULL DEFAULT '0' COMMENT '快递名称',
  `shipping_sn` varchar(50) NOT NULL DEFAULT '0' COMMENT '运单号',
  `shipping_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `message` varchar(255) DEFAULT '0' COMMENT '买家留言',
  `receive_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收获时间',
  `how_oos` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0为等待所有商品备其后再发,1为分批发货',
  `card_type` varchar(20) DEFAULT '0' COMMENT '贺卡类型',
  `card_message` varchar(255) DEFAULT '0' COMMENT '贺卡留言内容',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_order
-- ----------------------------
INSERT INTO `sp_order` VALUES ('1', '201504170001', '3', '0', '0', '0', '0', '0', '0', '0', '东方科技大厦1901室', '王朝', '中午', '100001', '0755-011111', '13888888888', 'x@vsoyou.com', '1', '银行卡付款', '200', '200.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '1429235219', '0', '0', '0', '0', '0', '速度发货给好评', '0', '0', '0', '0');
INSERT INTO `sp_order` VALUES ('4', '201504170002', '3', '0', '0', '0', '0', '0', '0', '0', '腾讯大厦1901室', '腾星', '中午', '100001', '0755-2222222', '13999999999', 'x@tencent.com', '1', '银行卡付款', '400', '400.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '1429235619', '0', '0', '0', '0', '0', '速度发货!!!!!!!!!!!!!!!!!!!!!!', '0', '0', '0', '0');
INSERT INTO `sp_order` VALUES ('5', '201504170003', '3', '0', '0', '0', '0', '0', '0', '0', '百度大厦1901室', '李宏', '中午', '100004', '0755-333333', '13111111111', 'x@baidu.com', '2', '支付宝付款', '800', '800.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '1429235919', '0', '0', '0', '0', '0', '请大大们赶紧发货', '0', '0', '0', '0');
INSERT INTO `sp_order` VALUES ('6', '201504170004', '3', '0', '0', '0', '0', '0', '0', '0', '财富港大厦1901室', '李一', '下午', '100007', '0755-666666', '13222222222', 'd@d.com', '2', '支付宝付款', '700', '700.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0', '1429239919', '0', '0', '0', '0', '0', '啊啊啊啊啊啊', '0', '0', '0', '0');
