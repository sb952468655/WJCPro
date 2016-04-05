/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50136
Source Host           : localhost:3306
Source Database       : ceshi

Target Server Type    : MYSQL
Target Server Version : 50136
File Encoding         : 65001

Date: 2016-04-05 15:40:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `acm_func2role`
-- ----------------------------
DROP TABLE IF EXISTS `acm_func2role`;
CREATE TABLE `acm_func2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menuId` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '对应菜单定义文件中的id',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FuncId` (`menuId`),
  KEY `RoleId` (`roleId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_func2role
-- ----------------------------
INSERT INTO `acm_func2role` VALUES ('4', '1-2-1', '1');
INSERT INTO `acm_func2role` VALUES ('3', '1-1', '1');
INSERT INTO `acm_func2role` VALUES ('5', '1-5', '1');

-- ----------------------------
-- Table structure for `acm_funcdb`
-- ----------------------------
DROP TABLE IF EXISTS `acm_funcdb`;
CREATE TABLE `acm_funcdb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) NOT NULL DEFAULT '0',
  `funcName` varchar(20) COLLATE utf8_bin NOT NULL,
  `leftId` int(10) NOT NULL DEFAULT '0',
  `rightId` int(10) NOT NULL DEFAULT '0',
  `usedByStandard` tinyint(1) NOT NULL DEFAULT '1' COMMENT '标准本是否可用',
  `usedByJingji` tinyint(1) NOT NULL DEFAULT '1' COMMENT '经济版是否可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_funcdb
-- ----------------------------

-- ----------------------------
-- Table structure for `acm_roledb`
-- ----------------------------
DROP TABLE IF EXISTS `acm_roledb`;
CREATE TABLE `acm_roledb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupName` (`roleName`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_roledb
-- ----------------------------
INSERT INTO `acm_roledb` VALUES ('1', '业务员');

-- ----------------------------
-- Table structure for `acm_sninfo`
-- ----------------------------
DROP TABLE IF EXISTS `acm_sninfo`;
CREATE TABLE `acm_sninfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL,
  `sninfo` varchar(1000) NOT NULL,
  `userId` int(10) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='动态密码卡信息';

-- ----------------------------
-- Records of acm_sninfo
-- ----------------------------

-- ----------------------------
-- Table structure for `acm_user2message`
-- ----------------------------
DROP TABLE IF EXISTS `acm_user2message`;
CREATE TABLE `acm_user2message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '用户Id',
  `messageId` int(10) NOT NULL COMMENT '通知Id',
  `kind` int(1) NOT NULL DEFAULT '0' COMMENT '0表示查看信息，1表示弹出窗但未查看信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户查看通知表';

-- ----------------------------
-- Records of acm_user2message
-- ----------------------------
INSERT INTO `acm_user2message` VALUES ('1', '1', '2', '1');
INSERT INTO `acm_user2message` VALUES ('2', '2', '2', '1');

-- ----------------------------
-- Table structure for `acm_user2role`
-- ----------------------------
DROP TABLE IF EXISTS `acm_user2role`;
CREATE TABLE `acm_user2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`roleId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_user2role
-- ----------------------------
INSERT INTO `acm_user2role` VALUES ('1', '2', '1');

-- ----------------------------
-- Table structure for `acm_user2trader`
-- ----------------------------
DROP TABLE IF EXISTS `acm_user2trader`;
CREATE TABLE `acm_user2trader` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `traderId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`traderId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_user2trader
-- ----------------------------
INSERT INTO `acm_user2trader` VALUES ('1', '2', '1');

-- ----------------------------
-- Table structure for `acm_userdb`
-- ----------------------------
DROP TABLE IF EXISTS `acm_userdb`;
CREATE TABLE `acm_userdb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userName` varchar(10) COLLATE utf8_bin NOT NULL,
  `realName` varchar(10) COLLATE utf8_bin NOT NULL,
  `shenfenzheng` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '身份证号',
  `passwd` varchar(10) COLLATE utf8_bin NOT NULL,
  `lastLoginTime` date NOT NULL COMMENT '最后一次登录日期',
  `loginCnt` int(10) NOT NULL COMMENT '当前日登录次数',
  `sn` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '动态密码卡sn',
  `snInfo` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '动态密码的字符串',
  PRIMARY KEY (`id`),
  KEY `UserId` (`userName`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of acm_userdb
-- ----------------------------
INSERT INTO `acm_userdb` VALUES ('1', 'admin', '管理员', '', 'admin', '2014-04-04', '4', '', '');
INSERT INTO `acm_userdb` VALUES ('2', 'zs', '张三', '', 'zs', '0000-00-00', '0', '', '');

-- ----------------------------
-- Table structure for `jichu_client`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_client`;
CREATE TABLE `jichu_client` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `traderId` int(10) NOT NULL COMMENT '本单位联系人',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `codeAtOrder` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '合同简称',
  `people` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '对方联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `accountId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '帐号',
  `taxId` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '税号',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `kaipiao` text COLLATE utf8_bin NOT NULL,
  `zhizaoPic` varchar(100) COLLATE utf8_bin NOT NULL,
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `comeFrom` char(10) COLLATE utf8_bin NOT NULL COMMENT '来源',
  `isVip` int(10) NOT NULL COMMENT '0受限制，1不受限制',
  `isStop` tinyint(1) NOT NULL COMMENT '是否停止往来',
  `letters` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户名转换字母',
  PRIMARY KEY (`id`),
  UNIQUE KEY `compName` (`compName`),
  KEY `compCode` (`compCode`),
  KEY `traderId` (`traderId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户档案';

-- ----------------------------
-- Records of jichu_client
-- ----------------------------
INSERT INTO `jichu_client` VALUES ('1', '1', '0001', '', '常州五金总会', 'CTT', '', '', '', '', '', '', '', '', '', 'upload/yyzz/b20140429150738.jpg', '', '', '0', '0', 'CZWJZH');
INSERT INTO `jichu_client` VALUES ('2', '2', '0002', '', '百丽服装', 'BL', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', 'BLFZ');
INSERT INTO `jichu_client` VALUES ('3', '1', '0003', '', '曲奇服装设计公司', 'QQ', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', 'QQFZSJGS');
INSERT INTO `jichu_client` VALUES ('4', '2', '0004', '', '丽华', 'LH', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', 'LH');
INSERT INTO `jichu_client` VALUES ('5', '1', '0005', '', '鲲鹏公司', 'GP', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', 'PGS');
INSERT INTO `jichu_client` VALUES ('7', '2', '0007', '', '易奇科技', 'YQ', '', '', '', '', '', '', '', '', '', '', '', '', '0', '0', 'YQKJ');

-- ----------------------------
-- Table structure for `jichu_client_taitou`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_client_taitou`;
CREATE TABLE `jichu_client_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `clientId` int(10) NOT NULL COMMENT '客户Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头';

-- ----------------------------
-- Records of jichu_client_taitou
-- ----------------------------

-- ----------------------------
-- Table structure for `jichu_department`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_department`;
CREATE TABLE `jichu_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '部门名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `depName` (`depName`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='部门档案';

-- ----------------------------
-- Records of jichu_department
-- ----------------------------
INSERT INTO `jichu_department` VALUES ('1', '业务部');
INSERT INTO `jichu_department` VALUES ('2', '生产部');

-- ----------------------------
-- Table structure for `jichu_employ`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_employ`;
CREATE TABLE `jichu_employ` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `employCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工编码',
  `employName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '员工名称',
  `codeAtEmploy` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '简称',
  `sex` smallint(1) NOT NULL DEFAULT '0' COMMENT '性别',
  `depId` int(10) NOT NULL COMMENT '部门ID',
  `gongzhong` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '工种',
  `fenlei` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '修布工分类',
  `mobile` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机',
  `address` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `dateEnter` date NOT NULL COMMENT '入厂时间',
  `isFire` tinyint(1) NOT NULL COMMENT '是否离职：1为是',
  `dateLeave` date NOT NULL COMMENT '离厂时间',
  `shenfenNo` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '身份证号',
  `hetongCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '劳动合同号',
  `isCaiyang` smallint(1) NOT NULL DEFAULT '0' COMMENT '是否可以采样',
  `isDayang` tinyint(1) NOT NULL COMMENT '是否打样人',
  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别',
  `paixu` tinyint(1) NOT NULL DEFAULT '0' COMMENT '排序',
  `letters` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '首字母',
  PRIMARY KEY (`id`),
  KEY `employName` (`employName`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='员工档案';

-- ----------------------------
-- Records of jichu_employ
-- ----------------------------
INSERT INTO `jichu_employ` VALUES ('1', '001', '张三', 'CS', '0', '1', '验布', '', '156151515', '', '0000-00-00', '0', '0000-00-00', '161616316161616', '', '0', '0', '正式', '0', 'ZS');
INSERT INTO `jichu_employ` VALUES ('2', '002', '李四', '', '0', '1', '', '', '', '', '0000-00-00', '0', '0000-00-00', '', '', '0', '0', '正式', '0', 'LS');

-- ----------------------------
-- Table structure for `jichu_gongxu`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_gongxu`;
CREATE TABLE `jichu_gongxu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工序名称',
  `orderLine` int(10) NOT NULL COMMENT '排列顺序',
  `isStop` tinyint(1) NOT NULL COMMENT '是否停用该工序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`orderLine`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工序设置';

-- ----------------------------
-- Records of jichu_gongxu
-- ----------------------------
INSERT INTO `jichu_gongxu` VALUES ('1', '球经染色', '1', '0');
INSERT INTO `jichu_gongxu` VALUES ('2', '坯布织造', '2', '0');
INSERT INTO `jichu_gongxu` VALUES ('3', '针织牛仔', '3', '0');
INSERT INTO `jichu_gongxu` VALUES ('4', '坯布染色', '4', '0');
INSERT INTO `jichu_gongxu` VALUES ('5', '成布送整', '5', '0');
INSERT INTO `jichu_gongxu` VALUES ('6', '成布印花', '6', '0');

-- ----------------------------
-- Table structure for `jichu_gongzhong`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_gongzhong`;
CREATE TABLE `jichu_gongzhong` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工种',
  `orderLine` int(10) NOT NULL COMMENT '排列顺序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`orderLine`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工种档案';

-- ----------------------------
-- Records of jichu_gongzhong
-- ----------------------------
INSERT INTO `jichu_gongzhong` VALUES ('1', '验布', '1');
INSERT INTO `jichu_gongzhong` VALUES ('2', '机修', '3');
INSERT INTO `jichu_gongzhong` VALUES ('3', '机修小工', '4');
INSERT INTO `jichu_gongzhong` VALUES ('4', '修布', '5');
INSERT INTO `jichu_gongzhong` VALUES ('5', '挡车', '6');
INSERT INTO `jichu_gongzhong` VALUES ('6', '装卸', '2');

-- ----------------------------
-- Table structure for `jichu_head`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_head`;
CREATE TABLE `jichu_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) NOT NULL COMMENT '公司台头',
  `address` varchar(100) NOT NULL COMMENT '地址',
  `code` varchar(20) NOT NULL COMMENT '合同编码',
  `bankName` varchar(100) NOT NULL COMMENT '开户银行',
  `accountId` varchar(50) NOT NULL COMMENT '账号',
  `tel` varchar(50) NOT NULL COMMENT '电话',
  `zipcode` varchar(20) NOT NULL COMMENT '邮政编码',
  `fax` varchar(50) NOT NULL COMMENT '传真',
  `fadingPeo` varchar(20) NOT NULL COMMENT '法定代表人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公司台头';

-- ----------------------------
-- Records of jichu_head
-- ----------------------------
INSERT INTO `jichu_head` VALUES ('1', '常州市恒纶纺织有限公司', '常州市中吴大道585号', 'HL', '江苏江南农村商业银行常州市万都商城支行', '89801110012010000000959', '0519-88388527', '', '0519-86329753', '');
INSERT INTO `jichu_head` VALUES ('2', '临沂金秀纺织有限公司', '常州市中吴大道585号', 'JX', '中国工商银行股份有限公司临沂兰山支行', '1610020109200257811', '0519-88388527', '', '0519-86329753', '');

-- ----------------------------
-- Table structure for `jichu_jiagonghu`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_jiagonghu`;
CREATE TABLE `jichu_jiagonghu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `compCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '公司编码',
  `compName` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '公司名称',
  `jghCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '加工户编号',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `address` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '厂址',
  `fuzeren` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '负责人',
  `isStop` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否停止往来1是0否',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL,
  `gongxuId` int(10) NOT NULL COMMENT '属于的加工类型',
  `letters` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '首字母',
  `isSupplier` tinyint(1) NOT NULL COMMENT '是否供应商:1是0否',
  `isSelf` tinyint(1) NOT NULL COMMENT '是否本厂：0否1是',
  `feeBase` tinyint(1) NOT NULL COMMENT '加工费依据：0生产领用，1产量',
  PRIMARY KEY (`id`),
  KEY `comp_name` (`compName`),
  KEY `comp_id` (`compCode`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='加工户档案';

-- ----------------------------
-- Records of jichu_jiagonghu
-- ----------------------------
INSERT INTO `jichu_jiagonghu` VALUES ('2', '020001', '常州五金总会', '', '', '', '', '0', '', '1', 'CZWJZH', '1', '0', '0');
INSERT INTO `jichu_jiagonghu` VALUES ('3', '010001', '常州老三', '', '1150564616481', '武进区', '张三', '0', '', '0', 'CZLS', '0', '0', '1');
INSERT INTO `jichu_jiagonghu` VALUES ('4', '010002', '坯纱供应商1', '', '', '', '李四', '0', '', '0', '', '1', '0', '0');
INSERT INTO `jichu_jiagonghu` VALUES ('5', '020002', '沃利斯加工厂', '', '', '', '王丽斯', '0', '', '0', 'WLSJGC', '0', '0', '0');
INSERT INTO `jichu_jiagonghu` VALUES ('7', '020003', '本厂', '', '', '', '', '0', '', '0', 'BC', '0', '1', '0');
INSERT INTO `jichu_jiagonghu` VALUES ('8', '010003', '坯布供应商1', '', '', '', '', '0', '', '0', '', '1', '0', '0');

-- ----------------------------
-- Table structure for `jichu_jitai`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_jitai`;
CREATE TABLE `jichu_jitai` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `jitaiName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '机台名称',
  `jitaiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '机台编号',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `orderLine` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `jitaiCode` (`jitaiCode`),
  KEY `orderLine` (`orderLine`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='机台基础档案';

-- ----------------------------
-- Records of jichu_jitai
-- ----------------------------
INSERT INTO `jichu_jitai` VALUES ('1', '机台0012', 'NTB0012', '制造机台', '2');
INSERT INTO `jichu_jitai` VALUES ('2', '机台0010', 'NTB0010', '', '1');

-- ----------------------------
-- Table structure for `jichu_kuwei`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_kuwei`;
CREATE TABLE `jichu_kuwei` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kuweiName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '库位名称',
  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='库位';

-- ----------------------------
-- Records of jichu_kuwei
-- ----------------------------
INSERT INTO `jichu_kuwei` VALUES ('6', '坯纱仓库', '');
INSERT INTO `jichu_kuwei` VALUES ('7', '色纱仓库', '');
INSERT INTO `jichu_kuwei` VALUES ('8', '坯布仓库', '');
INSERT INTO `jichu_kuwei` VALUES ('9', '成品布', '');

-- ----------------------------
-- Table structure for `jichu_product`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_product`;
CREATE TABLE `jichu_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '坯纱，色纱，针织，坯布，色布，其他',
  `zhonglei` varchar(50) COLLATE utf8_bin NOT NULL,
  `proCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '产品编码',
  `pinzhong` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '品种',
  `proName` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `color` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '颜色',
  `guige` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '规格',
  `comeFrom` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '来源',
  `menfu` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0原料1成品布2坯/加工布9其他',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `chengfenPer` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '成分比列',
  PRIMARY KEY (`id`),
  UNIQUE KEY `proCode` (`proCode`),
  KEY `pinzhong` (`pinzhong`),
  KEY `pinming` (`proName`),
  KEY `guige` (`guige`),
  KEY `kind` (`kind`),
  KEY `zhonglei` (`zhonglei`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of jichu_product
-- ----------------------------
INSERT INTO `jichu_product` VALUES ('1', '全棉', '全棉', 'RTR0012', '', '6s', '白色', '半精梳 ', '', '', '', '0', 'QM6sBBai', '全面', '');
INSERT INTO `jichu_product` VALUES ('2', '坯布', 'C/TU/P/V', 'A00001', '泡泡布', '', '蓝色', '45*45 50*50', '', '', '', '1', 'RTR0013', '条纹布', '45/15/30/10');
INSERT INTO `jichu_product` VALUES ('3', '全棉', '全棉', 'FVF41411', '', '45VC', '坯白', '精纺', '', '', '', '0', '', '', '');
INSERT INTO `jichu_product` VALUES ('4', '氨纶', '氨纶', 'CVC14568', '', '45C', '元白', '精纺', '', '', '', '0', '', '', '');
INSERT INTO `jichu_product` VALUES ('5', '色布', 'C/P/TU', 'CPV99665', '格子布', '', '红蓝', '45*45 49*50', '', '', '', '1', '', '', '60/25/15');
INSERT INTO `jichu_product` VALUES ('6', '坯布', '', 'A00002', '测试布', '', '元白', '45*45 50*50', '', '', '', '1', '', '', '');
INSERT INTO `jichu_product` VALUES ('7', '', '', '', '雅布', '', '黄色', '11', '', '', '', '1', '', '', '');

-- ----------------------------
-- Table structure for `jichu_product_chengfen`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_product_chengfen`;
CREATE TABLE `jichu_product_chengfen` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `proId` int(10) NOT NULL COMMENT '主表id,外键字段',
  `productId` int(10) NOT NULL COMMENT '坯纱/色纱对应的id',
  `chengfenPer` decimal(10,1) NOT NULL COMMENT '百分比',
  `memoView` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '备注描述',
  `sort` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `proId` (`proId`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成分比列表';

-- ----------------------------
-- Records of jichu_product_chengfen
-- ----------------------------
INSERT INTO `jichu_product_chengfen` VALUES ('1', '2', '4', '60.0', '', '0');
INSERT INTO `jichu_product_chengfen` VALUES ('2', '2', '3', '25.0', '', '0');
INSERT INTO `jichu_product_chengfen` VALUES ('4', '2', '1', '15.0', '', '0');
INSERT INTO `jichu_product_chengfen` VALUES ('5', '6', '4', '50.0', '', '0');
INSERT INTO `jichu_product_chengfen` VALUES ('6', '6', '3', '30.0', '', '0');
INSERT INTO `jichu_product_chengfen` VALUES ('7', '6', '1', '20.0', '', '0');

-- ----------------------------
-- Table structure for `jichu_product_gongxu`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_product_gongxu`;
CREATE TABLE `jichu_product_gongxu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `proId` int(10) NOT NULL COMMENT '外键',
  `gongxuName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工序名称',
  `qtmemo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '其他备注',
  `sort` int(10) NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `proId` (`proId`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成布工序信息';

-- ----------------------------
-- Records of jichu_product_gongxu
-- ----------------------------
INSERT INTO `jichu_product_gongxu` VALUES ('23', '6', '成布印花', '', '0');
INSERT INTO `jichu_product_gongxu` VALUES ('24', '2', '坯布染色', '', '0');
INSERT INTO `jichu_product_gongxu` VALUES ('10', '2', '坯布织造', '', '0');
INSERT INTO `jichu_product_gongxu` VALUES ('22', '6', '针织牛仔', '', '0');
INSERT INTO `jichu_product_gongxu` VALUES ('21', '6', '球经染色', '', '0');
INSERT INTO `jichu_product_gongxu` VALUES ('25', '2', '成布送整', '', '0');

-- ----------------------------
-- Table structure for `jichu_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_supplier`;
CREATE TABLE `jichu_supplier` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `compCode` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '加工户编码',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `compName` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '加工户名称',
  `people` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `fax` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '传真',
  `address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `compName` (`compName`),
  KEY `compCode` (`compCode`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='加工户档案';

-- ----------------------------
-- Records of jichu_supplier
-- ----------------------------
INSERT INTO `jichu_supplier` VALUES ('2', '0001', '', '王场', '王经理', '', '', '', '开始将对方');

-- ----------------------------
-- Table structure for `jichu_supplier_taitou`
-- ----------------------------
DROP TABLE IF EXISTS `jichu_supplier_taitou`;
CREATE TABLE `jichu_supplier_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `supplierId` int(10) NOT NULL COMMENT '坯纱供应商Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '供应商的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头';

-- ----------------------------
-- Records of jichu_supplier_taitou
-- ----------------------------

-- ----------------------------
-- Table structure for `mail_db`
-- ----------------------------
DROP TABLE IF EXISTS `mail_db`;
CREATE TABLE `mail_db` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `senderId` int(10) NOT NULL COMMENT '发件人',
  `accepterId` int(10) NOT NULL COMMENT '收件人',
  `title` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `attachment` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '附件',
  `mailCode` int(10) NOT NULL COMMENT '邮件编码，纯数字',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timeRead` datetime NOT NULL COMMENT '查看日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='邮件';

-- ----------------------------
-- Records of mail_db
-- ----------------------------

-- ----------------------------
-- Table structure for `oa_message`
-- ----------------------------
DROP TABLE IF EXISTS `oa_message`;
CREATE TABLE `oa_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kindName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '生产通知或生产变更通知',
  `title` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `buildDate` date NOT NULL COMMENT '发布日期',
  `orderId` int(10) NOT NULL COMMENT '订单id',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产通知';

-- ----------------------------
-- Records of oa_message
-- ----------------------------
INSERT INTO `oa_message` VALUES ('3', '订单变动通知', 'DS140430001单(泡泡布   45*45 50*50 蓝色),要货数变化', 0xE8AFB7E59084E983A8E997A8E5B7A5E4BD9CE4BABAE59198E6B3A8E6848F3AE4BAA7E593814453313430343330303031E58D9528E6B3A1E6B3A1E5B88320202034352A34352035302A353020E8939DE889B2292CE8A681E8B4A7E695B0E58F98E58C962CE8A681E8B4A7E58F98E4B8BA323030302E30304D2CE8AFB7E6B3A8E6848FE58D8FE8B083E5B9B6E4BA92E79BB8E9809AE79FA5EFBC81, '2014-05-04', '0', '管理员', '2014-05-04 10:11:35');
INSERT INTO `oa_message` VALUES ('2', '行政通知', '放假通知', 0x352E31E694BEE5818733E5A4A9EFBC8CE789B9E6ADA4E9809AE79FA5EFBC8CE79BB8E4BA92E8BDACE5918A, '2014-04-30', '0', '管理员', '2014-04-30 20:20:07');

-- ----------------------------
-- Table structure for `oa_message_class`
-- ----------------------------
DROP TABLE IF EXISTS `oa_message_class`;
CREATE TABLE `oa_message_class` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `className` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别名称',
  `isWindow` tinyint(1) NOT NULL COMMENT '是否弹出窗0否1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of oa_message_class
-- ----------------------------
INSERT INTO `oa_message_class` VALUES ('1', '行政通知', '0');

-- ----------------------------
-- Table structure for `sys_dbchange_log`
-- ----------------------------
DROP TABLE IF EXISTS `sys_dbchange_log`;
CREATE TABLE `sys_dbchange_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(40) NOT NULL COMMENT '文件名',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `memo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fileName` (`fileName`),
  KEY `dt` (`dt`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='数据补丁执行表';

-- ----------------------------
-- Records of sys_dbchange_log
-- ----------------------------
INSERT INTO `sys_dbchange_log` VALUES ('1', 'li_140510_0.txt', '2014-05-10 10:34:50', 'ALTER TABLE `pisha_plan`\nCHANGE COLUMN `supplierId` `jiagonghuId`  int(10) NOT NULL COMMENT \'供应商id；供应商与加工户合并在一张表中，所以取名加工户Id\' AFTER `id`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('2', 'li_140514_0.txt', '2014-05-14 15:53:54', 'CREATE TABLE `trade_order_feiyong` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `feiyongName` varchar(30) COLLATE utf8_bin NOT NULL COMMENT \'费用类别\',\n  `orderId` int(10) NOT NULL,\n  `qtMoney` decimal(10,2) NOT NULL COMMENT \'金额\',\n  `qtmemo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  PRIMARY KEY (`id`),\n  KEY `orderId` (`orderId`),\n  KEY `feiyongName` (`feiyongName`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'订单其他费用登记\';', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('3', 'li_140516_0.txt', '2014-05-16 10:46:06', 'ALTER TABLE `jichu_jiagonghu`\nADD COLUMN `letters`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'首字母\' AFTER `gongxuId`;\nCREATE TABLE `jichu_jitai` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `jitaiName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'机台名称\',\n  `jitaiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'机台编号\',\n  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  `orderLine` int(10) NOT NULL COMMENT \'排序\',\n  PRIMARY KEY (`id`),\n  KEY `jitaiCode` (`jitaiCode`),\n  KEY `orderLine` (`orderLine`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'机台基础档案\';ALTER TABLE `jichu_employ`\nADD COLUMN `letters`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'首字母\' AFTER `paixu`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('4', 'li_140516_1.txt', '2014-05-16 14:55:45', 'ALTER TABLE `shengchan_plan`\nADD COLUMN `isOver`  tinyint(1) NOT NULL COMMENT \'是否完成：0否1是\' AFTER `overDateReal`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('5', 'li_140516_2.txt', '2014-05-16 16:35:00', 'ALTER TABLE `jichu_jiagonghu`\nADD COLUMN `isSupplier`  tinyint(1) NOT NULL COMMENT \'是否供应商:1是0否\' AFTER `letters`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('6', 'li_140519_0.txt', '2014-05-19 10:33:06', 'ALTER TABLE `pisha_cgrk`\nDROP COLUMN `gongxuId`,\nMODIFY COLUMN `rukuDate`  date NOT NULL COMMENT \'入库日期\' AFTER `jiagonghuId`;\n\nALTER TABLE `pisha_cgrk`\nADD COLUMN `gongxuName`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'工序名称\' AFTER `rukuDate`;\n\nALTER TABLE `pisha_llck`\nADD COLUMN `gongxuName`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'工序名称\' AFTER `chukuCode`;\n\nALTER TABLE `shengchan_scrk`\nCHANGE COLUMN `gongxuId` `gongxuName`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'工序名称，加工类型\' AFTER `isGuozhang`;\n\nALTER TABLE `shengchan_scck`\nCHANGE COLUMN `gongxuId` `gongxuName`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'工序名称，加工类别\' AFTER `isGuozhang`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('7', 'li_140519_1.txt', '2014-05-19 10:44:13', 'ALTER TABLE  `pisha_cgrk` ADD INDEX (  `gongxuName` );\nALTER TABLE  `pisha_llck` ADD INDEX (  `gongxuName` );', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('8', 'li_140519_2.txt', '2014-05-19 10:55:34', 'ALTER TABLE `pisha_cgrk`\nADD COLUMN `isGuozhang`  tinyint(1) NOT NULL COMMENT \'是否过账:0是1否\' AFTER `rukuDate`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('9', 'li_140520_0.txt', '2014-05-20 10:28:49', 'ALTER TABLE `pisha_plan`\nCHANGE COLUMN `isOver` `isCheck`  int(1) NOT NULL DEFAULT 0 COMMENT \'是否审核：0否1是\' AFTER `planCode`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('10', 'li_140522_0.txt', '2014-05-22 14:58:23', 'ALTER TABLE `pisha_kucun`\nADD COLUMN `gongxuName`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'工序名称；库位（如：本厂，求精染色……）\' AFTER `moneyFasheng`;ALTER TABLE `pisha_kucun`\nCHANGE COLUMN `danjiaFasheng` `danjia`  decimal(15,6) NOT NULL COMMENT \'单价\' AFTER `cntFasheng`,\nADD COLUMN `isTuiku`  tinyint(1) NOT NULL COMMENT \' 是否退库：0否1是\' AFTER `gongxuName`;ALTER TABLE `pisha_cgrk`\nADD COLUMN `isTuiku`  tinyint(1) NOT NULL COMMENT \'是否退库：0否1是\' AFTER `dt`;ALTER TABLE `pisha_cgrk`\nMODIFY COLUMN `isTuiku`  tinyint(1) NOT NULL COMMENT \'是否退库入库（可能是下面流程退回来重新入库的，标记下）：0否1是\' AFTER `dt`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('11', 'li_140523_0.txt', '2014-05-23 10:54:01', 'ALTER TABLE `shengchan_plan`\nADD COLUMN `kind`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'计划类型\' AFTER `id`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('12', 'li_140526_0.txt', '2014-05-26 13:39:50', 'ALTER TABLE `pisha_llck`\nDROP COLUMN `planId`,\nDROP COLUMN `orderId`,\nMODIFY COLUMN `kind`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'出库类型\' AFTER `id`;\n\nALTER TABLE `pisha_llck_son`\nADD COLUMN `plan2proId`  int(11) NOT NULL COMMENT \'生产计划子表id\' AFTER `id`;\nALTER TABLE  `pisha_llck_son` ADD INDEX (  `plan2proId` );', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('13', 'li_140526_1.txt', '2014-05-26 14:16:53', 'ALTER TABLE `pisha_cgrk`\nCHANGE COLUMN `jiagonghuId` `supplierId`  int(10) NOT NULL COMMENT \'供应商id\' AFTER `songhuoCode`;ALTER TABLE `pisha_llck_son`\nCHANGE COLUMN `jiagonghuId` `supplierId`  int(10) NOT NULL COMMENT \'供应商id\' AFTER `llckId`;\nALTER TABLE `pisha_kucun`\nADD COLUMN `supplierId`  int(10) NOT NULL COMMENT \'供应商id\' AFTER `isTuiku`;\nALTER TABLE `pisha_plan`\nCHANGE COLUMN `jiagonghuId` `supplierId`  int(10) NOT NULL COMMENT \'供应商id；\' AFTER `id`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('14', 'li_140526_2.txt', '2014-05-26 15:56:41', 'ALTER TABLE `pisha_llck`\nADD COLUMN `clientId`  int(10) NOT NULL COMMENT \'客户id\' AFTER `kind`,\nADD COLUMN `departmentId`  int(10) NOT NULL COMMENT \'部门id\' AFTER `clientId`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('15', 'li_140526_3.txt', '2014-05-26 16:09:37', 'ALTER TABLE `pisha_llck`\nADD COLUMN `isGuozhang`  tinyint(1) NOT NULL COMMENT \'是否过账：0否1是\' AFTER `gongxuName`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('16', 'li_140527_0.txt', '2014-05-27 10:55:37', 'ALTER TABLE `pisha_llck_son`\nADD COLUMN `diaoboId`  int(11) NOT NULL COMMENT \'调拨出库生成两条记录，关联id信息\' AFTER `money`;ALTER TABLE `pisha_cgrk`\nADD COLUMN `jiagonghuId`  int(10) NOT NULL COMMENT \'加工户Id\' AFTER `supplierId`;\nALTER TABLE  `pisha_cgrk` ADD INDEX (  `jiagonghuId` );ALTER TABLE `jichu_jiagonghu`\nADD COLUMN `isSelf`  tinyint(1) NOT NULL COMMENT \'是否本厂：0否1是\' AFTER `isSupplier`;\nALTER TABLE  `pisha_cgrk_son` ADD INDEX (  `cgrkId` );', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('17', 'li_140527_1.txt', '2014-05-27 13:23:11', 'ALTER TABLE  `pisha_kucun` ADD INDEX (  `rukuId` );ALTER TABLE  `pisha_kucun` ADD INDEX (  `chukuId` );ALTER TABLE  `pisha_kucun` ADD INDEX (  `jiagonghuId` );ALTER TABLE  `pisha_kucun` ADD INDEX (  `supplierId` );ALTER TABLE  `pisha_kucun` ADD INDEX (  `productId` );ALTER TABLE  `pisha_llck` ADD INDEX (  `clientId` );ALTER TABLE  `pisha_llck` ADD INDEX (  `jiagonghuId` );', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('18', 'li_140527_2.txt', '2014-05-27 13:52:07', 'ALTER TABLE `pisha_kucun`\nDROP COLUMN `gongxuName`,\nMODIFY COLUMN `isTuiku`  tinyint(1) NOT NULL COMMENT \' 是否退库：0否1是\' AFTER `moneyFasheng`;\nALTER TABLE `pisha_cgrk`\nDROP COLUMN `gongxuName`,\nMODIFY COLUMN `memo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'备注\' AFTER `isGuozhang`;\nALTER TABLE `pisha_llck`\nDROP COLUMN `gongxuName`,\nMODIFY COLUMN `isGuozhang`  tinyint(1) NOT NULL COMMENT \'是否过账：0否1是\' AFTER `chukuCode`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('19', 'li_140527_3.txt', '2014-05-27 15:57:49', 'ALTER TABLE `pisha_llck`\nADD COLUMN `dbId`  int(10) NOT NULL COMMENT \'调拨id;方便同时对两条数据进行处理\' AFTER `memo`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('20', 'li_140528_0.txt', '2014-05-28 10:47:32', 'ALTER TABLE `pisha_llck`\nADD COLUMN `peolingliao`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'领料人\' AFTER `departmentId`;ALTER TABLE `pisha_llck`\nADD COLUMN `isCheck`  tinyint(1) NOT NULL COMMENT \'是否审核：0否1是\' AFTER `clientId`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('21', 'li_140529_0.txt', '2014-05-29 17:03:09', 'ALTER TABLE `shengchan_plan2product`\nMODIFY COLUMN `memo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT \'备注\' AFTER `cntShengchan`,\nADD COLUMN `menfu`  varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'门幅\' AFTER `memo`,\nADD COLUMN `kezhong`  varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'克重\' AFTER `menfu`;ALTER TABLE `jichu_product`\nMODIFY COLUMN `zhonglei`  varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL AFTER `kind`,\nADD COLUMN `chengfenPer`  varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'成分比列\' AFTER `memo`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('22', 'li_140530_0.txt', '2014-05-30 10:42:22', 'ALTER TABLE `trade_order`\nADD COLUMN `orderKind`  varchar(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'大货/大样\' AFTER `kind`;ALTER TABLE `trade_order`\nMODIFY COLUMN `orderKind`  tinyint(1) NOT NULL COMMENT \'0大货/1大样\' AFTER `kind`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('23', 'li_140606_0.txt', '2014-06-06 10:52:44', 'CREATE TABLE `shengchan_plan2product_touliao` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `plan2proId` int(11) NOT NULL,\n  `productId` int(11) NOT NULL,\n  `chengfenPer` decimal(10,2) NOT NULL COMMENT \'百分比\',\n  `sunhao` decimal(10,2) NOT NULL COMMENT \'损耗\',\n  `cntKg` decimal(10,2) NOT NULL COMMENT \'计划投料(Kg)\',\n  `memoView` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT \'备注描述\',\n  `orderLine` smallint(2) NOT NULL COMMENT \'顺序\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  PRIMARY KEY (`id`),\n  KEY `plan2proId` (`plan2proId`),\n  KEY `productId` (`productId`)\n) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT=\'生产计划投料设置\';CREATE TABLE `jichu_product_chengfen` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `proId` int(10) NOT NULL COMMENT \'主表id,外键字段\',\n  `productId` int(10) NOT NULL COMMENT \'坯纱/色纱对应的id\',\n  `chengfenPer` decimal(10,2) NOT NULL COMMENT \'百分比\',\n  `memoView` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'备注描述\',\n  `sort` int(10) NOT NULL COMMENT \'排序\',\n  PRIMARY KEY (`id`),\n  KEY `proId` (`proId`),\n  KEY `productId` (`productId`)\n) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'成分比列表\';ALTER TABLE `shengchan_plan2product`\nADD COLUMN `pibuCnt`  decimal(10,2) NOT NULL COMMENT \'坯布数量(Kg)\' AFTER `kezhong`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('24', 'li_140606_1.txt', '2014-06-06 13:56:11', 'CREATE TABLE `jichu_product_gongxu` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `proId` int(10) NOT NULL COMMENT \'外键\',\n  `gongxuName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'工序名称\',\n  `qtmemo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'其他备注\',\n  `sort` int(10) NOT NULL COMMENT \'排序\',\n  PRIMARY KEY (`id`),\n  KEY `proId` (`proId`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'成布工序信息\';', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('25', 'li_140606_2.txt', '2014-06-06 15:29:41', 'ALTER TABLE `pisha_plan_son`\nADD COLUMN `plan2tlId`  int(10) NOT NULL COMMENT \'计划明细表投料表id\' AFTER `money`;\nALTER TABLE `pisha_plan`\nADD COLUMN `plan2proId`  int(10) NOT NULL COMMENT \'生产计划明细表id\' AFTER `dt`;ALTER TABLE `pisha_plan_son`\nADD COLUMN `supplierId`  int(10) NOT NULL COMMENT \'供应商id\' AFTER `plan2tlId`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('26', 'li_140611_0.txt', '2014-06-11 13:48:45', 'ALTER TABLE `jichu_jiagonghu`\nADD COLUMN `feeBase`  tinyint(1) NOT NULL COMMENT \'加工费依据：0生产领用，1产量\' AFTER `isSelf`;ALTER TABLE `pisha_plan`\nDROP COLUMN `supplierId`,\nMODIFY COLUMN `planDate`  date NOT NULL COMMENT \'计划日期\' AFTER `id`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('27', 'li_140613_0.txt', '2014-06-13 14:32:47', 'ALTER TABLE `cangku_kucun`\nDROP COLUMN `isTuiku`,\nMODIFY COLUMN `supplierId`  int(10) NOT NULL COMMENT \'供应商id\' AFTER `money`;\nALTER TABLE `cangku_ruku`\nDROP COLUMN `isTuiku`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('28', 'li_140613_1.txt', '2014-06-13 15:15:38', 'CREATE TABLE `cangku_chuku` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱仓库/布仓库\',\n  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出库类型\',\n  `clientId` int(10) NOT NULL COMMENT \'客户id\',\n  `isCheck` tinyint(1) NOT NULL COMMENT \'是否审核：0否1是\',\n  `departmentId` int(10) NOT NULL COMMENT \'部门id\',\n  `peolingliao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'领料人\',\n  `jiagonghuId` int(10) NOT NULL COMMENT \'加工户id\',\n  `chukuDate` date NOT NULL COMMENT \'出库日期\',\n  `chukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出库单号\',\n  `isGuozhang` tinyint(1) NOT NULL COMMENT \'是否过账：0是1否\',\n  `yuanyin` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'出库原因\',\n  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  `dbId` int(10) NOT NULL COMMENT \'调拨id;方便同时对两条数据进行处理\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位id\',\n  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'创建人\',\n  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  PRIMARY KEY (`id`),\n  KEY `chukuDate` (`chukuDate`),\n  KEY `clientId` (`clientId`),\n  KEY `jiagonghuId` (`jiagonghuId`),\n  KEY `type` (`type`),\n  KEY `kind` (`kind`),\n  KEY `kuweiId` (`kuweiId`),\n  KEY `isCheck` (`isCheck`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库出库主表\';CREATE TABLE `cangku_chuku_son` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `plan2proId` int(11) NOT NULL COMMENT \'生产计划子表id\',\n  `chukuId` int(10) NOT NULL COMMENT \'出库id,pk\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `productId` int(10) NOT NULL COMMENT \'坯纱id\',\n  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `cnt` decimal(10,2) NOT NULL COMMENT \'出库数量\',\n  `cntCi` decimal(10,2) NOT NULL COMMENT \'次品数量\',\n  `danjia` decimal(15,6) NOT NULL COMMENT \'单价\',\n  `money` decimal(15,2) NOT NULL COMMENT \'金额\',\n  `diaoboId` int(11) NOT NULL COMMENT \'调拨出库生成两条记录，关联id信息\',\n  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'明细备注\',\n  `return4id` int(10) NOT NULL COMMENT \'退回的时候关联本表id字段\',\n  PRIMARY KEY (`id`),\n  KEY `supplierId` (`supplierId`),\n  KEY `chukuId` (`chukuId`),\n  KEY `productId` (`productId`),\n  KEY `plan2proId` (`plan2proId`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库出库子表\';CREATE TABLE `cangku_kucun` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `dateFasheng` date DEFAULT NULL COMMENT \'发生日期\',\n  `rukuId` int(11) NOT NULL COMMENT \'入库表id\',\n  `chukuId` int(11) NOT NULL COMMENT \'出库表id\',\n  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出入库类型\',\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱/布仓库\',\n  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `jiagonghuId` int(11) NOT NULL COMMENT \'加工户id\',\n  `productId` int(11) NOT NULL COMMENT \'原料id\',\n  `cnt` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `cntCi` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `money` decimal(15,2) NOT NULL COMMENT \'金额\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位Id\',\n  PRIMARY KEY (`id`),\n  KEY `rukuId` (`rukuId`),\n  KEY `chukuId` (`chukuId`),\n  KEY `jiagonghuId` (`jiagonghuId`),\n  KEY `supplierId` (`supplierId`),\n  KEY `productId` (`productId`),\n  KEY `kind` (`kind`),\n  KEY `type` (`type`),\n  KEY `kuweiId` (`kuweiId`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库库存表\';CREATE TABLE `cangku_ruku` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `kind` varchar(30) COLLATE utf8_bin NOT NULL COMMENT \'入库类型\',\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱仓库/布仓库\',\n  `cgPlanId` int(10) NOT NULL COMMENT \'采购计划id\',\n  `rukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'入库单号\',\n  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'送货单号\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `jiagonghuId` int(10) NOT NULL COMMENT \'加工户Id\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位Id\',\n  `rukuDate` date NOT NULL COMMENT \'入库日期\',\n  `isGuozhang` tinyint(1) NOT NULL COMMENT \'是否需要过账:0是1否\',\n  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'创建人\',\n  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'dt\',\n  PRIMARY KEY (`id`),\n  KEY `psPlanId` (`cgPlanId`),\n  KEY `rukuCode` (`rukuCode`),\n  KEY `rukuDate` (`rukuDate`),\n  KEY `jiagonghuId` (`supplierId`),\n  KEY `jiagonghuId_2` (`jiagonghuId`),\n  KEY `kuweiId` (`kuweiId`),\n  KEY `type` (`type`),\n  KEY `kind` (`kind`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'入库主表\';CREATE TABLE `cangku_ruku_son` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `rukuId` int(10) NOT NULL COMMENT \'入库主表id\',\n  `productId` int(10) NOT NULL COMMENT \'坯纱id\',\n  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `cnt` decimal(15,2) NOT NULL COMMENT \'入库数(Kg)\',\n  `cntCi` decimal(15,2) NOT NULL COMMENT \'次品数量\',\n  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'明细备注\',\n  `danjia` decimal(15,6) NOT NULL COMMENT \'坯纱单价\',\n  `return4id` int(11) NOT NULL COMMENT \'退库：cangku_ruku_son表关联id\',\n  `money` decimal(10,2) NOT NULL COMMENT \'金额\',\n  `plan2proId` int(10) NOT NULL COMMENT \'生产计划明细表关联id\',\n  PRIMARY KEY (`id`),\n  KEY `productId` (`productId`),\n  KEY `rukuId` (`rukuId`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库入库子表\';', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('29', 'li_140613_2.txt', '2014-06-13 15:18:11', 'DROP TABLE `pisha_cgrk`, `pisha_cgrk_son`, `pisha_kucun`, `pisha_llck`, `pisha_llck_son`, `shengchan_kucun`, `shengchan_scck`, `shengchan_scck_son`, `shengchan_scrk`, `shengchan_scrk_son`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('30', 'li_140616_0.txt', '2014-06-16 11:56:57', 'CREATE TABLE `cangku_kucun` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `dateFasheng` date DEFAULT NULL COMMENT \'发生日期\',\n  `rukuId` int(11) NOT NULL COMMENT \'入库表id\',\n  `chukuId` int(11) NOT NULL COMMENT \'出库表id\',\n  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出入库类型\',\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱/布仓库\',\n  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `jiagonghuId` int(11) NOT NULL COMMENT \'加工户id\',\n  `productId` int(11) NOT NULL COMMENT \'原料id\',\n  `cnt` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `cntCi` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `money` decimal(15,2) NOT NULL COMMENT \'金额\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位Id\',\n  PRIMARY KEY (`id`),\n  KEY `rukuId` (`rukuId`),\n  KEY `chukuId` (`chukuId`),\n  KEY `jiagonghuId` (`jiagonghuId`),\n  KEY `supplierId` (`supplierId`),\n  KEY `productId` (`productId`),\n  KEY `kind` (`kind`),\n  KEY `type` (`type`),\n  KEY `kuweiId` (`kuweiId`)\n) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库库存表\';', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('31', 'li_140616_1.txt', '2014-06-16 13:13:20', 'ALTER TABLE `cangku_ruku_son`\nADD COLUMN `planGxId`  int(10) NOT NULL COMMENT \'生产计划工序表对应的id\' AFTER `plan2proId`;ALTER TABLE `cangku_chuku_son`\nADD COLUMN `planGxId`  int(10) NOT NULL COMMENT \'生产计划下工序表对应id\' AFTER `return4id`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('32', 'li_140616_2.txt', '2014-06-16 16:55:00', 'ALTER TABLE `jichu_product`\nMODIFY COLUMN `type`  tinyint(1) NOT NULL DEFAULT 0 COMMENT \'0原料1成品布2坯/加工布9其他\' AFTER `kezhong`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('33', 'li_140617_0.txt', '2014-06-17 09:23:05', 'CREATE TABLE `cangku_ruku` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `kind` varchar(30) COLLATE utf8_bin NOT NULL COMMENT \'入库类型\',\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱仓库/布仓库\',\n  `cgPlanId` int(10) NOT NULL COMMENT \'采购计划id\',\n  `rukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'入库单号\',\n  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'送货单号\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `jiagonghuId` int(10) NOT NULL COMMENT \'加工户Id\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位Id\',\n  `rukuDate` date NOT NULL COMMENT \'入库日期\',\n  `isGuozhang` tinyint(1) NOT NULL COMMENT \'是否需要过账:0是1否\',\n  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'创建人\',\n  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT \'dt\',\n  PRIMARY KEY (`id`),\n  KEY `psPlanId` (`cgPlanId`),\n  KEY `rukuCode` (`rukuCode`),\n  KEY `rukuDate` (`rukuDate`),\n  KEY `jiagonghuId` (`supplierId`),\n  KEY `jiagonghuId_2` (`jiagonghuId`),\n  KEY `kuweiId` (`kuweiId`),\n  KEY `type` (`type`),\n  KEY `kind` (`kind`)\n) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'入库主表\';\nCREATE TABLE `cangku_ruku_son` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `rukuId` int(10) NOT NULL COMMENT \'入库主表id\',\n  `productId` int(10) NOT NULL COMMENT \'坯纱id\',\n  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `cnt` decimal(15,2) NOT NULL COMMENT \'入库数(Kg)\',\n  `cntCi` decimal(15,2) NOT NULL COMMENT \'次品数量\',\n  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'明细备注\',\n  `danjia` decimal(15,6) NOT NULL COMMENT \'坯纱单价\',\n  `return4id` int(11) NOT NULL COMMENT \'退库：cangku_ruku_son表关联id\',\n  `money` decimal(10,2) NOT NULL COMMENT \'金额\',\n  `plan2proId` int(10) NOT NULL COMMENT \'生产计划明细表关联id\',\n  `planGxId` int(10) NOT NULL COMMENT \'生产计划工序表对应的id\',\n  PRIMARY KEY (`id`),\n  KEY `productId` (`productId`),\n  KEY `rukuId` (`rukuId`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库入库子表\';\nCREATE TABLE `cangku_chuku` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱仓库/布仓库\',\n  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出库类型\',\n  `clientId` int(10) NOT NULL COMMENT \'客户id\',\n  `isCheck` tinyint(1) NOT NULL COMMENT \'是否审核：0否1是\',\n  `departmentId` int(10) NOT NULL COMMENT \'部门id\',\n  `peolingliao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'领料人\',\n  `jiagonghuId` int(10) NOT NULL COMMENT \'加工户id\',\n  `chukuDate` date NOT NULL COMMENT \'出库日期\',\n  `chukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出库单号\',\n  `isGuozhang` tinyint(1) NOT NULL COMMENT \'是否过账：0是1否\',\n  `yuanyin` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'出库原因\',\n  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  `dbId` int(10) NOT NULL COMMENT \'调拨id;方便同时对两条数据进行处理\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位id\',\n  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'创建人\',\n  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  PRIMARY KEY (`id`),\n  KEY `chukuDate` (`chukuDate`),\n  KEY `clientId` (`clientId`),\n  KEY `jiagonghuId` (`jiagonghuId`),\n  KEY `type` (`type`),\n  KEY `kind` (`kind`),\n  KEY `kuweiId` (`kuweiId`),\n  KEY `isCheck` (`isCheck`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库出库主表\';\nCREATE TABLE `cangku_chuku_son` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `plan2proId` int(11) NOT NULL COMMENT \'生产计划子表id\',\n  `chukuId` int(10) NOT NULL COMMENT \'出库id,pk\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `productId` int(10) NOT NULL COMMENT \'坯纱id\',\n  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `cnt` decimal(10,2) NOT NULL COMMENT \'出库数量\',\n  `cntCi` decimal(10,2) NOT NULL COMMENT \'次品数量\',\n  `danjia` decimal(15,6) NOT NULL COMMENT \'单价\',\n  `money` decimal(15,2) NOT NULL COMMENT \'金额\',\n  `diaoboId` int(11) NOT NULL COMMENT \'调拨出库生成两条记录，关联id信息\',\n  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT \'明细备注\',\n  `return4id` int(10) NOT NULL COMMENT \'退回的时候关联本表id字段\',\n  `planGxId` int(10) NOT NULL COMMENT \'生产计划下工序表对应id\',\n  PRIMARY KEY (`id`),\n  KEY `supplierId` (`supplierId`),\n  KEY `chukuId` (`chukuId`),\n  KEY `productId` (`productId`),\n  KEY `plan2proId` (`plan2proId`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库出库子表\';\nCREATE TABLE `cangku_kucun` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `dateFasheng` date DEFAULT NULL COMMENT \'发生日期\',\n  `rukuId` int(11) NOT NULL COMMENT \'入库表id\',\n  `chukuId` int(11) NOT NULL COMMENT \'出库表id\',\n  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'出入库类型\',\n  `type` varchar(20) COLLATE utf8_bin NOT NULL COMMENT \'纱/布仓库\',\n  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'批号\',\n  `jiagonghuId` int(11) NOT NULL COMMENT \'加工户id\',\n  `productId` int(11) NOT NULL COMMENT \'原料id\',\n  `cnt` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `cntCi` decimal(15,2) NOT NULL COMMENT \'发生数量,入库为+，出库为-\',\n  `money` decimal(15,2) NOT NULL COMMENT \'金额\',\n  `supplierId` int(10) NOT NULL COMMENT \'供应商id\',\n  `kuweiId` int(10) NOT NULL COMMENT \'库位Id\',\n  PRIMARY KEY (`id`),\n  KEY `rukuId` (`rukuId`),\n  KEY `chukuId` (`chukuId`),\n  KEY `jiagonghuId` (`jiagonghuId`),\n  KEY `supplierId` (`supplierId`),\n  KEY `productId` (`productId`),\n  KEY `kind` (`kind`),\n  KEY `type` (`type`),\n  KEY `kuweiId` (`kuweiId`)\n) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'仓库库存表\';', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('34', 'li_140617_1.txt', '2014-06-17 10:05:58', 'ALTER TABLE `jichu_product_chengfen`\nMODIFY COLUMN `chengfenPer`  decimal(10,1) NOT NULL COMMENT \'百分比\' AFTER `productId`;\nALTER TABLE `shengchan_plan2product_touliao`\nMODIFY COLUMN `chengfenPer`  decimal(10,1) NOT NULL COMMENT \'百分比\' AFTER `productId`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('35', 'li_140617_2.txt', '2014-06-17 15:33:18', 'ALTER TABLE `cangku_chuku_son`\nADD COLUMN `planTlId`  int(10) NOT NULL COMMENT \'投料计划id\' AFTER `planGxId`;\n', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('36', 'li_140618_0.txt', '2014-06-18 11:14:03', 'ALTER TABLE `cangku_kucun`\nADD COLUMN `isCheck`  tinyint(1) NOT NULL COMMENT \'是否审核：0否1是，审核后的记录才统计库存\' AFTER `kuweiId`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('37', 'li_140623_0.txt', '2014-06-23 09:23:31', 'ALTER TABLE `cangku_ruku_son`\nADD COLUMN `cntJian`  int(10) NOT NULL COMMENT \'件数\' AFTER `cntCi`;\nALTER TABLE `cangku_chuku_son`\nADD COLUMN `cntJian`  int(10) NOT NULL COMMENT \'件数\' AFTER `cntCi`;\nALTER TABLE `cangku_kucun`\nADD COLUMN `cntJian`  int(10) NOT NULL COMMENT \'件数\' AFTER `cntCi`;', '程序员提交，不需执行');
INSERT INTO `sys_dbchange_log` VALUES ('38', 'li_140623_1.txt', '2014-06-23 10:14:12', 'CREATE TABLE `jichu_kuwei` (\n  `id` int(10) NOT NULL AUTO_INCREMENT,\n  `kuweiName` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'库位名称\',\n  `memo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT \'备注\',\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT=\'库位\';', '程序员提交，不需执行');

-- ----------------------------
-- Table structure for `sys_pop`
-- ----------------------------
DROP TABLE IF EXISTS `sys_pop`;
CREATE TABLE `sys_pop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` text NOT NULL,
  `dateFrom` date NOT NULL COMMENT '其实日期',
  `dateTo` date NOT NULL COMMENT '截止日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='工具箱中设置的弹窗信息';

-- ----------------------------
-- Records of sys_pop
-- ----------------------------

-- ----------------------------
-- Table structure for `sys_set`
-- ----------------------------
DROP TABLE IF EXISTS `sys_set`;
CREATE TABLE `sys_set` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item` varchar(20) COLLATE utf8_bin NOT NULL,
  `itemName` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='系统参数设置';

-- ----------------------------
-- Records of sys_set
-- ----------------------------
