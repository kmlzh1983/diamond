/*
Navicat MySQL Data Transfer

Source Server         : xampp
Source Server Version : 50621
Source Host           : localhost:3306
Source Database       : hmv

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2015-04-17 14:47:52
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sp_order_action
-- ----------------------------
DROP TABLE IF EXISTS `sp_order_action`;
CREATE TABLE `sp_order_action` (
  `action_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `action_user` varchar(30) NOT NULL DEFAULT '0' COMMENT '操作者',
  `order_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态',
  `pay_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `shipping_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `action_note` varchar(255) DEFAULT '0' COMMENT '操作备注',
  `log_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sp_order_action
-- ----------------------------
INSERT INTO `sp_order_action` VALUES ('1', '1', 'admin', '1', '0', '0', '批量操作', '1429252619');
INSERT INTO `sp_order_action` VALUES ('2', '4', 'admin', '1', '0', '0', '批量操作', '1429252619');
INSERT INTO `sp_order_action` VALUES ('3', '1', 'admin', '3', '0', '0', '批量操作', '1429252624');
INSERT INTO `sp_order_action` VALUES ('4', '4', 'admin', '3', '0', '0', '批量操作', '1429252624');
INSERT INTO `sp_order_action` VALUES ('5', '1', 'admin', '1', '0', '0', '批量操作', '1429252634');
INSERT INTO `sp_order_action` VALUES ('6', '4', 'admin', '1', '0', '0', '批量操作', '1429252634');
INSERT INTO `sp_order_action` VALUES ('7', '1', 'admin', '2', '0', '0', '批量操作', '1429252639');
INSERT INTO `sp_order_action` VALUES ('8', '4', 'admin', '2', '0', '0', '批量操作', '1429252639');
INSERT INTO `sp_order_action` VALUES ('9', '1', 'admin', '1', '0', '0', '我是管理员,哼,我要强制确认你的订单', '1429252668');
INSERT INTO `sp_order_action` VALUES ('10', '1', 'admin', '2', '0', '0', '谁让我是管理员呢,我要取消你的订单,哼', '1429252698');
INSERT INTO `sp_order_action` VALUES ('11', '1', 'admin', '1', '0', '0', '良心发现,还是再次确认订单吧', '1429252716');
INSERT INTO `sp_order_action` VALUES ('12', '1', 'admin', '3', '0', '0', 'oh no,这次将你的订单无效掉', '1429252736');
INSERT INTO `sp_order_action` VALUES ('13', '1', 'admin', '1', '0', '0', '还是置为确认状态吧', '1429252770');
INSERT INTO `sp_order_action` VALUES ('14', '1', 'admin', '1', '1', '0', '嘿嘿,你没钱没关系,本管理员让你为已付费状态', '1429252804');
INSERT INTO `sp_order_action` VALUES ('15', '1', 'admin', '1', '0', '0', 'oh,no,等下boss该扣小的工资啦,帮不了你了,自己给钱吧', '1429252847');
INSERT INTO `sp_order_action` VALUES ('16', '1', 'admin', '1', '1', '0', '切,这点钱哥还是有嗒,本管理员确定为你埋单了', '1429252889');
INSERT INTO `sp_order_action` VALUES ('17', '1', 'admin', '1', '1', '2', '我要想好了,一旦货发出去了,就只能给你售后或退货了.嗯,我确定了!', '1429252956');
