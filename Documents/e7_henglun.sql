-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 05 月 09 日 14:11
-- 服务器版本: 5.1.36
-- PHP 版本: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `e7_henglun`
--

-- --------------------------------------------------------

--
-- 表的结构 `acm_func2role`
--

CREATE TABLE IF NOT EXISTS `acm_func2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menuId` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '对应菜单定义文件中的id',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FuncId` (`menuId`),
  KEY `RoleId` (`roleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_func2role`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_funcdb`
--

CREATE TABLE IF NOT EXISTS `acm_funcdb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(10) NOT NULL DEFAULT '0',
  `funcName` varchar(20) COLLATE utf8_bin NOT NULL,
  `leftId` int(10) NOT NULL DEFAULT '0',
  `rightId` int(10) NOT NULL DEFAULT '0',
  `usedByStandard` tinyint(1) NOT NULL DEFAULT '1' COMMENT '标准本是否可用',
  `usedByJingji` tinyint(1) NOT NULL DEFAULT '1' COMMENT '经济版是否可用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_funcdb`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_roledb`
--

CREATE TABLE IF NOT EXISTS `acm_roledb` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `GroupName` (`roleName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_roledb`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_sninfo`
--

CREATE TABLE IF NOT EXISTS `acm_sninfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL,
  `sninfo` varchar(1000) NOT NULL,
  `userId` int(10) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='动态密码卡信息' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `acm_sninfo`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_user2message`
--

CREATE TABLE IF NOT EXISTS `acm_user2message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL COMMENT '用户Id',
  `messageId` int(10) NOT NULL COMMENT '通知Id',
  `kind` int(1) NOT NULL DEFAULT '0' COMMENT '0表示查看信息，1表示弹出窗但未查看信息',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户查看通知表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `acm_user2message`
--

INSERT INTO `acm_user2message` (`id`, `userId`, `messageId`, `kind`) VALUES
(1, 1, 2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `acm_user2role`
--

CREATE TABLE IF NOT EXISTS `acm_user2role` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `roleId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`roleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_user2role`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_user2trader`
--

CREATE TABLE IF NOT EXISTS `acm_user2trader` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL DEFAULT '0',
  `traderId` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UserId` (`userId`,`traderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `acm_user2trader`
--


-- --------------------------------------------------------

--
-- 表的结构 `acm_userdb`
--

CREATE TABLE IF NOT EXISTS `acm_userdb` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `acm_userdb`
--

INSERT INTO `acm_userdb` (`id`, `userName`, `realName`, `shenfenzheng`, `passwd`, `lastLoginTime`, `loginCnt`, `sn`, `snInfo`) VALUES
(1, 'admin', '管理员', '', 'admin', '2014-04-04', 4, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_fapiao`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_fapiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `fapiaoHead` varchar(20) COLLATE utf8_bin NOT NULL,
  `fapiaoCode` varchar(20) COLLATE utf8_bin NOT NULL,
  `clientId` int(11) NOT NULL COMMENT '客户Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户发票抬头',
  `fukuanFangshi` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '付款方式',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00',
  `huilv` decimal(10,4) NOT NULL DEFAULT '1.0000' COMMENT '开票汇率',
  `bizhong` varchar(20) COLLATE utf8_bin NOT NULL,
  `fapiaoDate` date NOT NULL DEFAULT '0000-00-00',
  `memo` text COLLATE utf8_bin NOT NULL,
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `yixiangId` (`clientId`),
  KEY `fapiaoCode` (`fapiaoCode`),
  KEY `head` (`head`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='开票表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_ar_fapiao`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_guozhang`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_guozhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderId` int(11) NOT NULL,
  `ord2proId` int(11) NOT NULL,
  `chukuId` int(10) NOT NULL COMMENT '出库id,原料或成品出库',
  `chuku2proId` int(10) NOT NULL,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '区别原料与成品出库',
  `productId` int(10) NOT NULL,
  `cnt` decimal(10,2) NOT NULL,
  `unit` char(20) COLLATE utf8_bin NOT NULL,
  `danjia` decimal(10,2) NOT NULL,
  `bizhong` char(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `huilv` decimal(10,4) NOT NULL COMMENT '汇率',
  `guozhangDate` date NOT NULL,
  `clientId` int(11) NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  `moneyYishou` decimal(10,2) NOT NULL COMMENT '已收金额',
  `moneyFapiao` decimal(10,2) NOT NULL COMMENT '发票金额',
  PRIMARY KEY (`id`),
  KEY `ord2proId` (`ord2proId`),
  KEY `orderId` (`orderId`),
  KEY `guozhangDate` (`guozhangDate`),
  KEY `yixiangId` (`clientId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='发货入账表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_ar_guozhang`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_ar_income`
--

CREATE TABLE IF NOT EXISTS `caiwu_ar_income` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `bankId` int(11) NOT NULL COMMENT '账户Id',
  `type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '收汇方式',
  `shouhuiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '收汇单号',
  `shouhuiDate` date NOT NULL COMMENT '收汇日期',
  `clientId` int(11) NOT NULL,
  `bizhong` char(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `huilv` decimal(10,4) NOT NULL COMMENT '汇率',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `shouhuiDate` (`shouhuiDate`),
  KEY `yixiangId` (`clientId`),
  KEY `head` (`head`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='收汇登记表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_ar_income`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_bank`
--

CREATE TABLE IF NOT EXISTS `caiwu_bank` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(40) COLLATE utf8_bin NOT NULL,
  `address` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `manger` char(10) COLLATE utf8_bin NOT NULL COMMENT '负责人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `contacter` char(10) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '营业厅电话',
  `acountCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '开户账号',
  `xingzhi` char(10) COLLATE utf8_bin NOT NULL COMMENT '性质(基本户|一般户|税务专用)',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `itemName` (`itemName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='银行帐号' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `caiwu_bank`
--

INSERT INTO `caiwu_bank` (`id`, `itemName`, `address`, `manger`, `tel`, `contacter`, `phone`, `acountCode`, `xingzhi`, `memo`) VALUES
(2, '工商银行', '延陵西路158号', '隋启龙', '0519-83036225', '王丽', '15296534105', '338856478995241', '基本户', '');

-- --------------------------------------------------------

--
-- 表的结构 `caiwu_bank_copy`
--

CREATE TABLE IF NOT EXISTS `caiwu_bank_copy` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(40) COLLATE utf8_bin NOT NULL,
  `address` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `manger` char(10) COLLATE utf8_bin NOT NULL COMMENT '负责人',
  `tel` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `contacter` char(10) COLLATE utf8_bin NOT NULL COMMENT '联系人',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '营业厅电话',
  `acountCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '开户账号',
  `xingzhi` char(10) COLLATE utf8_bin NOT NULL COMMENT '性质(基本户|一般户|税务专用)',
  PRIMARY KEY (`id`),
  KEY `itemName` (`itemName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='银行帐号' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_bank_copy`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_fapiao`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_fapiao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) NOT NULL COMMENT '台头',
  `fapiaoCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `supplierId` int(11) NOT NULL COMMENT '加工户',
  `money` decimal(20,2) NOT NULL DEFAULT '0.00',
  `fapiaoDate` date NOT NULL DEFAULT '0000-00-00',
  `memo` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fapiaoCode` (`fapiaoCode`),
  KEY `jghId` (`supplierId`),
  KEY `fapiaoDate` (`fapiaoDate`),
  KEY `head` (`head`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='应付发票' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_yf_fapiao`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_fukuan`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_fukuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '台头',
  `fukuanCode` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '收汇单号',
  `fukuanDate` date NOT NULL COMMENT '付款日期',
  `supplierId` int(11) NOT NULL COMMENT '供应商id',
  `fkType` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '付款方式',
  `money` decimal(15,2) NOT NULL COMMENT '付款金额',
  `memo` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fukuanDate` (`fukuanDate`),
  KEY `jghId` (`supplierId`),
  KEY `head` (`head`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='付款表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_yf_fukuan`
--


-- --------------------------------------------------------

--
-- 表的结构 `caiwu_yf_guozhang`
--

CREATE TABLE IF NOT EXISTS `caiwu_yf_guozhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rukuId` int(11) NOT NULL,
  `ruku2ProId` int(11) NOT NULL,
  `jiagonghuId` int(10) NOT NULL COMMENT '加工户Id',
  `gongxuId` int(10) NOT NULL COMMENT '工序Id',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '应付款类型',
  `productId` int(10) NOT NULL COMMENT '产品Id',
  `cnt` decimal(10,2) NOT NULL,
  `cntM` decimal(10,2) NOT NULL,
  `cntKg` decimal(10,2) NOT NULL,
  `unit` char(20) COLLATE utf8_bin NOT NULL,
  `danjia` decimal(10,2) NOT NULL,
  `guozhangDate` date NOT NULL,
  `money` decimal(15,2) NOT NULL,
  `gangNum` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '缸号',
  `colorNo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '色号',
  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `yishouPiao` decimal(10,2) NOT NULL COMMENT '已收票金额',
  `yifukuan` decimal(10,2) NOT NULL COMMENT '已付款金额',
  `zhekouMoney` decimal(10,2) NOT NULL COMMENT '折扣金额',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '制单人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `ruku2ProId` (`ruku2ProId`),
  KEY `rukuId` (`rukuId`),
  KEY `guozhangDate` (`guozhangDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='应付入账表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `caiwu_yf_guozhang`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cpck`
--

CREATE TABLE IF NOT EXISTS `chengpin_cpck` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '发生类别',
  `guozhangId` int(11) NOT NULL COMMENT '过账id',
  `cpckCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '成品出库号',
  `orderId` int(10) NOT NULL COMMENT '生产订单号',
  `cpckDate` date NOT NULL COMMENT '成品出库日期',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` int(10) NOT NULL COMMENT '创建人',
  `dt` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cpckCode` (`cpckCode`),
  KEY `orderId` (`orderId`),
  KEY `cpckDate` (`cpckDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品出库' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_cpck`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cpck2product`
--

CREATE TABLE IF NOT EXISTS `chengpin_cpck2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '出库主表ID',
  `chukuId` int(10) NOT NULL,
  `productId` int(10) NOT NULL COMMENT '产品id',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细表ID',
  `cntDuan` int(10) NOT NULL COMMENT '出库件数',
  `cnt` decimal(10,2) NOT NULL COMMENT '原始数量',
  `unit` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '原始单位',
  `danjia` decimal(10,2) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `cntKg` decimal(10,2) NOT NULL COMMENT '折合公斤数',
  `cntM` decimal(10,2) NOT NULL COMMENT '米数',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `ord2proId` (`ord2proId`),
  KEY `chukuId` (`chukuId`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品出库明细表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_cpck2product`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cprk`
--

CREATE TABLE IF NOT EXISTS `chengpin_cprk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '发生类别',
  `cprkCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '成品入库号',
  `orderId` int(10) NOT NULL COMMENT '生产订单号',
  `cprkDate` date NOT NULL COMMENT '入库时间',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注 ',
  `creater` int(10) NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  PRIMARY KEY (`id`),
  KEY `cprkCode` (`cprkCode`),
  KEY `orderId` (`orderId`),
  KEY `cprkDate` (`cprkDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='成品入库' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_cprk`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_cprk2product`
--

CREATE TABLE IF NOT EXISTS `chengpin_cprk2product` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `rukuId` int(10) NOT NULL COMMENT '入库主表id',
  `cntDuan` int(10) NOT NULL COMMENT '段数',
  `cnt` decimal(10,2) NOT NULL COMMENT '出库数量',
  `unit` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '计量单位',
  `danjia` decimal(10,2) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  `cntKg` decimal(10,2) NOT NULL COMMENT '折合公斤数',
  `cntM` decimal(10,2) NOT NULL COMMENT '米数',
  `productId` int(10) NOT NULL COMMENT '产品id',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细表id',
  `dajuanKind` smallint(1) NOT NULL COMMENT '0单卷单匹1打包',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `rukuId` (`rukuId`),
  KEY `productId` (`productId`),
  KEY `ord2proId` (`ord2proId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='入库明细表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_cprk2product`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_kucun`
--

CREATE TABLE IF NOT EXISTS `chengpin_kucun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFasheng` date NOT NULL COMMENT '发生日期',
  `orderId` int(10) NOT NULL COMMENT '生产订单号',
  `ord2proId` int(10) NOT NULL COMMENT '订单明细表id',
  `duanFasheng` int(10) NOT NULL COMMENT '段数',
  `cntFasheng` decimal(10,2) NOT NULL COMMENT '原始数量',
  `unitFasheng` varchar(20) NOT NULL COMMENT '发生单位',
  `cntKgFasheng` decimal(10,2) NOT NULL COMMENT '发生公斤数,针织产品一般以公斤数为库存核算单位',
  `cntMFasheng` decimal(10,2) NOT NULL COMMENT '发生米数',
  `danjiaFasheng` decimal(10,2) NOT NULL COMMENT '单价',
  `moneyFasheng` decimal(15,2) NOT NULL COMMENT '发生金额',
  PRIMARY KEY (`id`),
  KEY `dateFasheng` (`dateFasheng`),
  KEY `orderId` (`orderId`),
  KEY `ord2proId` (`ord2proId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='成品库存表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_kucun`
--


-- --------------------------------------------------------

--
-- 表的结构 `chengpin_madan_son`
--

CREATE TABLE IF NOT EXISTS `chengpin_madan_son` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cprk2proId` int(10) NOT NULL COMMENT '入库明细表id',
  `number` smallint(4) NOT NULL COMMENT '件号',
  `cnt` double(10,2) NOT NULL COMMENT '码数',
  `cnt_format` varchar(100) COLLATE utf8_bin NOT NULL,
  `lot` char(5) COLLATE utf8_bin NOT NULL COMMENT '质量等级',
  `cpck2proId` int(11) NOT NULL COMMENT '出库明细表id',
  PRIMARY KEY (`id`),
  KEY `cpck2proId` (`cpck2proId`),
  KEY `cprk2proId` (`cprk2proId`),
  KEY `number` (`number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='码单登记表从表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `chengpin_madan_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `jichu_client`
--

CREATE TABLE IF NOT EXISTS `jichu_client` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户档案' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jichu_client`
--

INSERT INTO `jichu_client` (`id`, `traderId`, `compCode`, `zhujiCode`, `compName`, `codeAtOrder`, `people`, `tel`, `fax`, `mobile`, `email`, `accountId`, `taxId`, `address`, `kaipiao`, `zhizaoPic`, `memo`, `comeFrom`, `isVip`, `isStop`, `letters`) VALUES
(1, 1, '0001', '', '常州五金总会', 'CTT', '', '', '', '', '', '', '', '', '', 'upload/yyzz/b20140429150738.jpg', '', '', 0, 0, 'CZWJZH');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_client_taitou`
--

CREATE TABLE IF NOT EXISTS `jichu_client_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `clientId` int(10) NOT NULL COMMENT '客户Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '客户的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jichu_client_taitou`
--


-- --------------------------------------------------------

--
-- 表的结构 `jichu_department`
--

CREATE TABLE IF NOT EXISTS `jichu_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `depName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '部门名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `depName` (`depName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='部门档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_department`
--

INSERT INTO `jichu_department` (`id`, `depName`) VALUES
(1, '业务部'),
(2, '生产部');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_employ`
--

CREATE TABLE IF NOT EXISTS `jichu_employ` (
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
  PRIMARY KEY (`id`),
  KEY `employName` (`employName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='员工档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_employ`
--

INSERT INTO `jichu_employ` (`id`, `employCode`, `employName`, `codeAtEmploy`, `sex`, `depId`, `gongzhong`, `fenlei`, `mobile`, `address`, `dateEnter`, `isFire`, `dateLeave`, `shenfenNo`, `hetongCode`, `isCaiyang`, `isDayang`, `type`, `paixu`) VALUES
(1, '001', '张三', 'CS', 0, 1, '验布', '', '156151515', '', '0000-00-00', 0, '0000-00-00', '161616316161616', '', 0, 0, '正式', 0),
(2, '002', '李四', '', 0, 1, '', '', '', '', '0000-00-00', 0, '0000-00-00', '', '', 0, 0, '正式', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_gongxu`
--

CREATE TABLE IF NOT EXISTS `jichu_gongxu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工序名称',
  `orderLine` int(10) NOT NULL COMMENT '排列顺序',
  `isStop` tinyint(1) NOT NULL COMMENT '是否停用该工序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`orderLine`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工序设置' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `jichu_gongxu`
--

INSERT INTO `jichu_gongxu` (`id`, `itemName`, `orderLine`, `isStop`) VALUES
(1, '球经染色', 1, 0),
(2, '坯布织造', 2, 0),
(3, '针织牛仔', 3, 0),
(4, '坯布染色', 4, 0),
(5, '成布送整', 5, 0),
(6, '成布印花', 6, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_gongzhong`
--

CREATE TABLE IF NOT EXISTS `jichu_gongzhong` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '工种',
  `orderLine` int(10) NOT NULL COMMENT '排列顺序',
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`orderLine`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='工种档案' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `jichu_gongzhong`
--

INSERT INTO `jichu_gongzhong` (`id`, `itemName`, `orderLine`) VALUES
(1, '验布', 1),
(2, '机修', 3),
(3, '机修小工', 4),
(4, '修布', 5),
(5, '挡车', 6),
(6, '装卸', 2);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_head`
--

CREATE TABLE IF NOT EXISTS `jichu_head` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公司台头' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_head`
--

INSERT INTO `jichu_head` (`id`, `head`, `address`, `code`, `bankName`, `accountId`, `tel`, `zipcode`, `fax`, `fadingPeo`) VALUES
(1, '常州市恒纶纺织有限公司', '常州市中吴大道585号', 'HL', '江苏江南农村商业银行常州市万都商城支行', '89801110012010000000959', '0519-88388527', '', '0519-86329753', ''),
(2, '临沂金秀纺织有限公司', '常州市中吴大道585号', 'JX', '中国工商银行股份有限公司临沂兰山支行', '1610020109200257811', '0519-88388527', '', '0519-86329753', '');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_jiagonghu`
--

CREATE TABLE IF NOT EXISTS `jichu_jiagonghu` (
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
  PRIMARY KEY (`id`),
  KEY `comp_name` (`compName`),
  KEY `comp_id` (`compCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='加工户档案' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jichu_jiagonghu`
--

INSERT INTO `jichu_jiagonghu` (`id`, `compCode`, `compName`, `jghCode`, `tel`, `address`, `fuzeren`, `isStop`, `memo`, `gongxuId`) VALUES
(2, '0001', '常州五金总会', '', '', '', '', 0, '', 1),
(3, '0001', '常州老三', '', '1150564616481', '武进区', '张三', 0, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `jichu_product`
--

CREATE TABLE IF NOT EXISTS `jichu_product` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '坯纱，色纱，针织，坯布，色布，其他',
  `zhonglei` varchar(10) COLLATE utf8_bin NOT NULL,
  `proCode` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '产品编码',
  `pinzhong` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '品种',
  `proName` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '品名',
  `color` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '颜色',
  `guige` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '规格',
  `comeFrom` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '来源',
  `menfu` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(60) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0纱1成布9其他',
  `zhujiCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '助记码',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  UNIQUE KEY `proCode` (`proCode`),
  KEY `pinzhong` (`pinzhong`),
  KEY `pinming` (`proName`),
  KEY `guige` (`guige`),
  KEY `kind` (`kind`),
  KEY `zhonglei` (`zhonglei`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_product`
--

INSERT INTO `jichu_product` (`id`, `kind`, `zhonglei`, `proCode`, `pinzhong`, `proName`, `color`, `guige`, `comeFrom`, `menfu`, `kezhong`, `type`, `zhujiCode`, `memo`) VALUES
(1, '坯纱', '全棉', 'RTR0012', '', '6s', '白色', '半精梳 ', '', '', '', 0, 'QM6sBBai', '全面'),
(2, '坯布', '', 'RTR0013', '泡泡布', '', '蓝色', '45*45 50*50', '', '', '', 1, 'RTR0013', '条纹布');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_supplier`
--

CREATE TABLE IF NOT EXISTS `jichu_supplier` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='加工户档案' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jichu_supplier`
--

INSERT INTO `jichu_supplier` (`id`, `compCode`, `zhujiCode`, `compName`, `people`, `tel`, `fax`, `address`, `memo`) VALUES
(2, '0001', '', '王场', '王经理', '', '', '', '开始将对方');

-- --------------------------------------------------------

--
-- 表的结构 `jichu_supplier_taitou`
--

CREATE TABLE IF NOT EXISTS `jichu_supplier_taitou` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `supplierId` int(10) NOT NULL COMMENT '坯纱供应商Id',
  `taitou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '供应商的开票抬头',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='客户发票抬头' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `jichu_supplier_taitou`
--


-- --------------------------------------------------------

--
-- 表的结构 `mail_db`
--

CREATE TABLE IF NOT EXISTS `mail_db` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='邮件' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `mail_db`
--


-- --------------------------------------------------------

--
-- 表的结构 `oa_message`
--

CREATE TABLE IF NOT EXISTS `oa_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kindName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '生产通知或生产变更通知',
  `title` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `content` text COLLATE utf8_bin NOT NULL COMMENT '内容',
  `buildDate` date NOT NULL COMMENT '发布日期',
  `orderId` int(10) NOT NULL COMMENT '订单id',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产通知' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `oa_message`
--

INSERT INTO `oa_message` (`id`, `kindName`, `title`, `content`, `buildDate`, `orderId`, `creater`, `dt`) VALUES
(3, '订单变动通知', 'DS140430001单(泡泡布   45*45 50*50 蓝色),要货数变化', 0xe8afb7e59084e983a8e997a8e5b7a5e4bd9ce4babae59198e6b3a8e6848f3ae4baa7e593814453313430343330303031e58d9528e6b3a1e6b3a1e5b88320202034352a34352035302a353020e8939de889b2292ce8a681e8b4a7e695b0e58f98e58c962ce8a681e8b4a7e58f98e4b8ba323030302e30304d2ce8afb7e6b3a8e6848fe58d8fe8b083e5b9b6e4ba92e79bb8e9809ae79fa5efbc81, '2014-05-04', 0, '管理员', '2014-05-04 10:11:35'),
(2, '行政通知', '放假通知', 0x352e31e694bee5818733e5a4a9efbc8ce789b9e6ada4e9809ae79fa5efbc8ce79bb8e4ba92e8bdace5918a, '2014-04-30', 0, '管理员', '2014-04-30 20:20:07');

-- --------------------------------------------------------

--
-- 表的结构 `oa_message_class`
--

CREATE TABLE IF NOT EXISTS `oa_message_class` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `className` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别名称',
  `isWindow` tinyint(1) NOT NULL COMMENT '是否弹出窗0否1是',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `oa_message_class`
--

INSERT INTO `oa_message_class` (`id`, `className`, `isWindow`) VALUES
(1, '行政通知', 0);

-- --------------------------------------------------------

--
-- 表的结构 `pisha_cgrk`
--

CREATE TABLE IF NOT EXISTS `pisha_cgrk` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '入库类型',
  `psPlanId` int(10) NOT NULL COMMENT '坯纱采购计划id',
  `rukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入库单号',
  `songhuoCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '送货单号',
  `jiagonghuId` int(10) NOT NULL COMMENT '供应商id或加工户id',
  `gongxuId` int(10) NOT NULL COMMENT '工序id',
  `rukuDate` date NOT NULL COMMENT '入库日期',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'dt',
  PRIMARY KEY (`id`),
  KEY `psPlanId` (`psPlanId`),
  KEY `rukuCode` (`rukuCode`),
  KEY `rukuDate` (`rukuDate`),
  KEY `jiagonghuId` (`jiagonghuId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱采购入库主表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_cgrk`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_cgrk_son`
--

CREATE TABLE IF NOT EXISTS `pisha_cgrk_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cgrkId` int(10) NOT NULL COMMENT '采购计划id',
  `productId` int(10) NOT NULL COMMENT '坯纱id',
  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `cntKg` decimal(15,2) NOT NULL COMMENT '入库公斤数',
  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '明细备注',
  `danjia` decimal(15,6) NOT NULL COMMENT '坯纱单价',
  `return4id` int(11) NOT NULL COMMENT '退纱：pisha_cgrk_son表关联id',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  `psPlan2proId` int(11) NOT NULL COMMENT '坯纱采购计划明细id',
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱采购入库子表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_cgrk_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_kucun`
--

CREATE TABLE IF NOT EXISTS `pisha_kucun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFasheng` date DEFAULT NULL COMMENT '发生日期',
  `rukuId` int(11) NOT NULL COMMENT '入库表id',
  `chukuId` int(11) NOT NULL COMMENT '出库表id',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出入库类型',
  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `jiagonghuId` int(11) NOT NULL COMMENT '加工户id',
  `productId` int(11) NOT NULL COMMENT '原料id',
  `cntFasheng` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `danjiaFasheng` decimal(15,6) NOT NULL COMMENT '单价',
  `moneyFasheng` decimal(15,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='原料库存表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_kucun`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_llck`
--

CREATE TABLE IF NOT EXISTS `pisha_llck` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `planId` int(10) NOT NULL COMMENT '生产计划id',
  `orderId` int(10) NOT NULL COMMENT '订单主表id',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出库类型',
  `jiagonghuId` int(10) NOT NULL COMMENT '加工户id',
  `chukuDate` date NOT NULL COMMENT '出库日期',
  `chukuCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出库单号',
  `yuanyin` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '出库原因',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `planId` (`planId`),
  KEY `chukuDate` (`chukuDate`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='领料出库主表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_llck`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_llck_son`
--

CREATE TABLE IF NOT EXISTS `pisha_llck_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `llckId` int(10) NOT NULL COMMENT '坯纱领料出库id',
  `jiagonghuId` int(10) NOT NULL COMMENT '供应商id',
  `productId` int(10) NOT NULL COMMENT '坯纱id',
  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '明细备注',
  `cntKg` decimal(10,2) NOT NULL COMMENT '出库数量',
  `danjia` decimal(15,6) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`id`),
  KEY `supplierId` (`jiagonghuId`),
  KEY `llckId` (`llckId`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱领料出库子表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_llck_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_plan`
--

CREATE TABLE IF NOT EXISTS `pisha_plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `supplierId` int(10) NOT NULL COMMENT '供应商id',
  `planDate` date NOT NULL COMMENT '计划日期',
  `planCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '采购计划单号',
  `isOver` int(1) NOT NULL DEFAULT '0' COMMENT '是否审核：0否1是',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'dt',
  PRIMARY KEY (`id`),
  KEY `supplierId` (`supplierId`),
  KEY `planDate` (`planDate`),
  KEY `planCode` (`planCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱采购计划表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_plan`
--


-- --------------------------------------------------------

--
-- 表的结构 `pisha_plan_son`
--

CREATE TABLE IF NOT EXISTS `pisha_plan_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psPlanId` int(10) NOT NULL COMMENT '采购计划id',
  `productId` int(10) NOT NULL COMMENT '坯纱id',
  `pihao` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `cntKg` decimal(15,2) NOT NULL COMMENT '入库公斤数',
  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '明细备注',
  `danjia` decimal(15,6) NOT NULL COMMENT '坯纱单价',
  `money` decimal(10,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='坯纱采购入库子表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `pisha_plan_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_kucun`
--

CREATE TABLE IF NOT EXISTS `shengchan_kucun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateFasheng` date DEFAULT NULL COMMENT '发生日期',
  `rukuId` int(11) NOT NULL COMMENT '入库表id',
  `chukuId` int(11) NOT NULL COMMENT '出库表id',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出入库类型',
  `pihao` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `colorNo` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '色号',
  `gangNum` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '缸号',
  `menfu` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `kezhong` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '批号',
  `unit` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '单位',
  `jiagonghuId` int(11) NOT NULL COMMENT '加工户id',
  `productId` int(11) NOT NULL COMMENT '原料id',
  `cnt` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `cntCi` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `cntM` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `cntCiM` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `cntKg` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `cntCiKg` decimal(15,2) NOT NULL COMMENT '发生数量,入库为+，出库为-',
  `danjia` decimal(15,6) NOT NULL COMMENT '单价',
  `money` decimal(15,2) NOT NULL COMMENT '金额',
  PRIMARY KEY (`id`),
  KEY `jiagonghuId` (`jiagonghuId`),
  KEY `productId` (`productId`),
  KEY `rukuId` (`rukuId`),
  KEY `chukuId` (`chukuId`),
  KEY `dateFasheng` (`dateFasheng`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='原料库存表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_kucun`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_plan`
--

CREATE TABLE IF NOT EXISTS `shengchan_plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '计划类型',
  `orderId` int(10) NOT NULL COMMENT '订单主表Id',
  `planDate` date NOT NULL COMMENT '计划日期',
  `planCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '计划单号',
  `planMemo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `overDate` date NOT NULL COMMENT '计划完成时间',
  `overDateReal` date NOT NULL COMMENT '实际完成时间',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'dt',
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `planDate` (`planDate`),
  KEY `planCode` (`planCode`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产计划主表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `shengchan_plan`
--

INSERT INTO `shengchan_plan` (`id`, `kind`, `orderId`, `planDate`, `planCode`, `planMemo`, `overDate`, `overDateReal`, `creater`, `dt`) VALUES
(3, '成布', 0, '2014-05-09', 'JH140509001', '', '2014-05-09', '0000-00-00', '', '2014-05-09 10:30:33'),
(4, '色纱', 0, '2014-05-09', 'JH140509002', '', '2014-05-09', '0000-00-00', '', '2014-05-09 10:30:41');

-- --------------------------------------------------------

--
-- 表的结构 `shengchan_plan2product`
--

CREATE TABLE IF NOT EXISTS `shengchan_plan2product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planId` int(11) NOT NULL COMMENT '计划主表id',
  `ord2proId` int(11) NOT NULL COMMENT '订单从表id',
  `productId` int(11) NOT NULL COMMENT '产品id',
  `cntShengchan` decimal(12,1) NOT NULL COMMENT '计划生产数量',
  `memo` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `planId` (`planId`),
  KEY `ord2proId` (`ord2proId`),
  KEY `productId` (`productId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='生产计划从表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `shengchan_plan2product`
--

INSERT INTO `shengchan_plan2product` (`id`, `planId`, `ord2proId`, `productId`, `cntShengchan`, `memo`) VALUES
(3, 3, 0, 2, 1100.0, ''),
(4, 4, 0, 1, 150.0, '');

-- --------------------------------------------------------

--
-- 表的结构 `shengchan_plan2product_gongxu`
--

CREATE TABLE IF NOT EXISTS `shengchan_plan2product_gongxu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan2proId` int(11) NOT NULL,
  `gongxuName` varchar(20) NOT NULL COMMENT '工序名，不要id，直接varchar',
  `orderLine` smallint(2) NOT NULL COMMENT '顺序',
  `dateFrom` date NOT NULL COMMENT '开始日期',
  `dateTo` date NOT NULL COMMENT '结束日期',
  PRIMARY KEY (`id`),
  KEY `plan2proId` (`plan2proId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='生产计划，各工序的设置' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_plan2product_gongxu`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_scck`
--

CREATE TABLE IF NOT EXISTS `shengchan_scck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `planId` int(10) NOT NULL COMMENT '生产计划id',
  `scckCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '生产出库编码',
  `scckDate` date NOT NULL COMMENT '生产出库日期',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出库类别',
  `jiagonghuId` int(10) NOT NULL COMMENT '出库的加工户id',
  `toJghId` int(10) NOT NULL COMMENT '发送到的加工户id',
  `clientId` int(10) NOT NULL COMMENT '客户id',
  `isGuozhang` tinyint(1) NOT NULL COMMENT '是否过账：0是1否',
  `gongxuId` int(10) NOT NULL COMMENT '加工类别，工序类别对应的id',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'dt',
  PRIMARY KEY (`id`),
  KEY `planId` (`planId`),
  KEY `jiagonghuId` (`jiagonghuId`),
  KEY `gongxuId` (`gongxuId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产出库主表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_scck`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_scck_son`
--

CREATE TABLE IF NOT EXISTS `shengchan_scck_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scckId` int(11) NOT NULL COMMENT '生产入库id',
  `productId` int(10) NOT NULL COMMENT '产品id',
  `gangNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '缸号',
  `colorNo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '色号',
  `cntPi` int(10) NOT NULL COMMENT '匹数',
  `cnt` decimal(10,2) NOT NULL COMMENT '一等品',
  `cntCi` decimal(10,2) NOT NULL COMMENT '次品',
  `menfu` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `unit` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '单位',
  `cntM` decimal(10,2) NOT NULL COMMENT '米数',
  `cntKg` decimal(10,2) NOT NULL COMMENT '公斤',
  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '明细备注',
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `scckId` (`scckId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产出库子表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_scck_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_scrk`
--

CREATE TABLE IF NOT EXISTS `shengchan_scrk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scrkDate` date NOT NULL COMMENT '入库日期',
  `scrkCode` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入库编号',
  `kind` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入库类别',
  `planId` int(10) NOT NULL COMMENT '生产计划id',
  `jiagonghuId` int(10) NOT NULL COMMENT '加工户id',
  `isGuozhang` tinyint(1) NOT NULL COMMENT '是否过账：0是1否',
  `gongxuId` int(10) NOT NULL COMMENT '加工类别，工序类别对应的id',
  `memo` varchar(200) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '创建人',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'dt',
  PRIMARY KEY (`id`),
  KEY `scrkDate` (`scrkDate`),
  KEY `scrkCode` (`scrkCode`),
  KEY `gongxuId` (`gongxuId`),
  KEY `jiagonghuId` (`jiagonghuId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产入库表，主表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_scrk`
--


-- --------------------------------------------------------

--
-- 表的结构 `shengchan_scrk_son`
--

CREATE TABLE IF NOT EXISTS `shengchan_scrk_son` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scrkId` int(11) NOT NULL COMMENT '生产入库id',
  `productId` int(10) NOT NULL COMMENT '产品id',
  `gangNum` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '缸号',
  `colorNo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '色号',
  `cntPi` int(10) NOT NULL COMMENT '匹数',
  `cnt` decimal(10,2) NOT NULL COMMENT '一等品',
  `cntCi` decimal(10,2) NOT NULL COMMENT '次品',
  `menfu` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `unit` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '单位',
  `cntM` decimal(10,2) NOT NULL COMMENT '米数',
  `cntKg` decimal(10,2) NOT NULL COMMENT '公斤',
  `scck2proId` int(11) NOT NULL COMMENT '表shengchan_scck_son关联id，出库表出库时同时在入库表中添加一条入库字段，表示调库',
  `scrk2proId` int(11) NOT NULL COMMENT '表shengchan_scrk_son关联id：有降等，退库的操作，关联id',
  `memoView` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '明细备注',
  PRIMARY KEY (`id`),
  KEY `productId` (`productId`),
  KEY `scrkId` (`scrkId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='生产入库子表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `shengchan_scrk_son`
--


-- --------------------------------------------------------

--
-- 表的结构 `sys_dbchange_log`
--

CREATE TABLE IF NOT EXISTS `sys_dbchange_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fileName` varchar(40) NOT NULL COMMENT '文件名',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  `memo` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fileName` (`fileName`),
  KEY `dt` (`dt`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='数据补丁执行表' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_dbchange_log`
--


-- --------------------------------------------------------

--
-- 表的结构 `sys_pop`
--

CREATE TABLE IF NOT EXISTS `sys_pop` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL COMMENT '标题',
  `content` text NOT NULL,
  `dateFrom` date NOT NULL COMMENT '其实日期',
  `dateTo` date NOT NULL COMMENT '截止日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='工具箱中设置的弹窗信息' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_pop`
--


-- --------------------------------------------------------

--
-- 表的结构 `sys_set`
--

CREATE TABLE IF NOT EXISTS `sys_set` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `item` varchar(20) COLLATE utf8_bin NOT NULL,
  `itemName` varchar(50) COLLATE utf8_bin NOT NULL,
  `value` varchar(200) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='系统参数设置' AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `sys_set`
--


-- --------------------------------------------------------

--
-- 表的结构 `trade_order`
--

CREATE TABLE IF NOT EXISTS `trade_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `kind` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '0' COMMENT '订单类型',
  `orderCode` varchar(20) CHARACTER SET utf8 NOT NULL COMMENT '订单号',
  `orderDate` date NOT NULL COMMENT '签订日期',
  `traderId` int(11) NOT NULL COMMENT '业务员ID',
  `traderName` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '业务员名字',
  `clientId` int(11) NOT NULL COMMENT '客户ID',
  `lianxiren` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户联系人',
  `clientOrder` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户合同号',
  `xsType` varchar(20) COLLATE utf8_bin NOT NULL,
  `huilv` decimal(10,4) NOT NULL DEFAULT '1.0000' COMMENT '汇率',
  `bizhong` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '币种',
  `overflow` smallint(1) NOT NULL COMMENT '溢短装',
  `pichang` smallint(2) NOT NULL COMMENT '匹长',
  `moneyDayang` decimal(10,2) NOT NULL COMMENT '打样收费',
  `packing` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '包装要求',
  `checking` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '检验要求',
  `warpShrink` smallint(2) NOT NULL COMMENT '经向缩率',
  `weftShrink` smallint(2) NOT NULL COMMENT '纬向缩率',
  `orderItem1` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem2` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem3` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem4` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem5` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem6` varchar(300) COLLATE utf8_bin NOT NULL,
  `orderItem7` varchar(300) COLLATE utf8_bin NOT NULL,
  `memoTrade` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '经营要求',
  `memoYongjin` varchar(500) COLLATE utf8_bin NOT NULL COMMENT '佣金备注',
  `memoWaigou` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '外购备注',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `isOver` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否完成',
  `isCheck` tinyint(1) NOT NULL COMMENT '是否审核',
  `checkPeo` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '审核人',
  `checkDate` datetime NOT NULL COMMENT '审核日期',
  `headId` int(10) NOT NULL COMMENT '公司抬头id',
  `creater` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '制表人(当前用户)',
  PRIMARY KEY (`id`),
  KEY `orderCode` (`orderCode`),
  KEY `orderDate` (`orderDate`),
  KEY `traderId` (`traderId`),
  KEY `clientId` (`clientId`),
  KEY `clientOrder` (`clientOrder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='订单基本信息' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `trade_order`
--

INSERT INTO `trade_order` (`id`, `kind`, `orderCode`, `orderDate`, `traderId`, `traderName`, `clientId`, `lianxiren`, `clientOrder`, `xsType`, `huilv`, `bizhong`, `overflow`, `pichang`, `moneyDayang`, `packing`, `checking`, `warpShrink`, `weftShrink`, `orderItem1`, `orderItem2`, `orderItem3`, `orderItem4`, `orderItem5`, `orderItem6`, `orderItem7`, `memoTrade`, `memoYongjin`, `memoWaigou`, `memo`, `isOver`, `isCheck`, `checkPeo`, `checkDate`, `headId`, `creater`) VALUES
(1, '成布', 'HL140509001', '2014-05-09', 1, '', 1, '', '', '', 1.0000, 'RMB', 0, 0, 0.00, '', '', 0, 0, '按乙方确认样和FZ/T72008-2006标准生产。如果乙方对甲方的产品质量有异议，请在收货后15个工作日内提出，乙方开裁视为合格。', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '', '', '', '', 0, 1, '管理员', '2014-05-09 13:43:40', 1, ''),
(2, '色纱', 'HL140509002', '2014-05-09', 1, '', 1, '', '', '', 1.0000, 'RMB', 0, 0, 0.00, '', '', 0, 0, '1.颜色按客户指定的合理缸差范围进行生产，色牢度干摩擦4级，湿摩擦浅色3-4级，深色2.5-3级，达到环保要求。对色广源：D65（自然光）\r\n               2.缩水经纬3%—4%，弹性、手感好，克重达标。\r\n               3.强度好：顶破强力300N以上。\r\n               4.布面不准有色迹、污点、色花。废边在1.5cm以内。\r\n               5.按照FR标准执行。\r\n               6.工艺损耗6%-7%。\r\n               7.定型染色疵点不超过1%', '塑料薄膜包装。特殊要求另行协商。', '大货数量允许 ±3%。', '由甲方送货到乙方指定国内地点， 费用由甲方负责,特殊情况另行协商。', '自乙方定金到甲方账户，并在乙方确认大货产前样品质后开始算交期。', '预付合同总金额的30%作为定金，余款提货前结清，如分批交货的,定金在最后一批货款中结算。', '本协议在履行过程中如发生争议，由双方协商解决；如协商不能解决，按下列两种方式解决(1) 提交签约地仲裁委员会仲裁； (2) 依法向人民法院起诉；', '', '', '', '', 0, 1, '管理员', '2014-05-09 13:35:30', 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `trade_order2product`
--

CREATE TABLE IF NOT EXISTS `trade_order2product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numId` int(10) NOT NULL,
  `orderId` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '订单主表id',
  `productId` int(10) NOT NULL COMMENT '产品Id',
  `menfu` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '门幅',
  `kezhong` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '克重',
  `cntM` decimal(10,2) NOT NULL COMMENT '米数',
  `cntKg` decimal(10,2) NOT NULL COMMENT '千克数',
  `cntYaohuo` decimal(10,2) NOT NULL COMMENT '要货数量',
  `dateJiaohuo` date NOT NULL COMMENT '交货日期 ',
  `unit` varchar(10) COLLATE utf8_bin NOT NULL COMMENT '单位(m/y/kg)',
  `danjia` decimal(10,3) NOT NULL COMMENT '单价',
  `memo` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '备注',
  `spic` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '小图路径',
  `bpic` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '大图路径',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderId` (`orderId`),
  KEY `chanpinId` (`productId`),
  KEY `numId` (`numId`),
  KEY `dateJiaohuo` (`dateJiaohuo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='合同与产品的对应表' AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `trade_order2product`
--

INSERT INTO `trade_order2product` (`id`, `numId`, `orderId`, `productId`, `menfu`, `kezhong`, `cntM`, `cntKg`, `cntYaohuo`, `dateJiaohuo`, `unit`, `danjia`, `memo`, `spic`, `bpic`, `dt`) VALUES
(1, 1, '1', 2, '140', '2.5', 2400.00, 840.00, 2400.00, '2014-05-09', 'M', 6.850, '', '', '', '2014-05-09 09:02:22'),
(2, 1, '2', 1, '', '', 0.00, 1000.00, 1000.00, '2014-05-09', 'Kg', 15.000, '', '', '', '2014-05-09 11:20:32');
