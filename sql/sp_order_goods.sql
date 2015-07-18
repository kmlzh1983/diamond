/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : hmv

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-04-17 14:47:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sp_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `sp_order_goods`;
CREATE TABLE `sp_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增主键',
  `order_id` int(10) unsigned DEFAULT '0' COMMENT '订单ID',
  `order_sn` varchar(20) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_sn` varchar(20) NOT NULL DEFAULT '0' COMMENT '商品编号',
  `goods_name` varchar(255) DEFAULT '0' COMMENT '商品名称',
  `goods_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',
  `goods_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `goods_attr` varchar(255) DEFAULT '0' COMMENT '商品属性,,如:黑色',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_order_goods
-- ----------------------------
INSERT INTO `sp_order_goods` VALUES ('1', '1', '0', '1', 'sp201504160090', '洗衣粉', '10.00', '2', '0');
INSERT INTO `sp_order_goods` VALUES ('2', '1', '0', '3', 'sp201504160020', '一次性杯子', '3.00', '5', '0');
INSERT INTO `sp_order_goods` VALUES ('3', '1', '0', '6', 'sp201504162090', '牙刷', '2.00', '3', '0');
INSERT INTO `sp_order_goods` VALUES ('4', '4', '0', '3', 'sp201533162090', '电脑', '22.00', '2', '黑色');
INSERT INTO `sp_order_goods` VALUES ('5', '4', '0', '23', 'sp201504166090', '手机', '22.00', '1', '0');
INSERT INTO `sp_order_goods` VALUES ('6', '5', '0', '22', 'sp201504133090', '打印机', '33.00', '4', '白色');
INSERT INTO `sp_order_goods` VALUES ('7', '5', '0', '55', 'sp201504133090', '笔筒', '2.50', '3', '0');
INSERT INTO `sp_order_goods` VALUES ('8', '6', '0', '44', 'sp201504133390', '钢笔', '2.80', '2', '0');
