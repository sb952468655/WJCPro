<?php
$_sysMenu = array(
    array(
		'text'=>'订单管理',
		'expanded'=> false,
		'id'=>'1',
		'children'=>array(
			array('text'=>'订单登记','expanded'=> false,'src'=>'?controller=Trade_Order&action=add','leaf'=>true,'id'=>'1-1','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'订单查询','expanded'=> false,'src'=>'?controller=Trade_Order&action=right','leaf'=>true,'id'=>'1-2'),
			array('text'=>'订单明细查询','expanded'=> false,'src'=>'?controller=Trade_Order&action=ListView','leaf'=>true,'id'=>'1-3'),
			array('text'=>'订单汇总','expanded'=> false,'src'=>'?controller=Trade_Order&action=ClientHuizong','leaf'=>true,'id'=>'1-5','icon'=>'Resource/Image/Menu/report2.gif'),
		)
    ),
	array(
		'text'=>'计划管理',
		'expanded'=> false,
		'id'=>'2','children'=>array(
			array('text'=>'生产计划设置','expanded'=> false,'src'=>'?controller=Shengchan_Plan&action=Add','leaf'=>true,'id'=>'2-1','icon'=>'Resource/Image/Menu/add2.gif'),
			array('text'=>'生产计划查询','expanded'=> false,'src'=>'?controller=Shengchan_Plan&action=right','leaf'=>true,'id'=>'2-5'),
			array('text'=>'工序/投料计划设置','expanded'=> false,'src'=>'?controller=Shengchan_PlanTl&action=List4Gongxu','leaf'=>true,'id'=>'2-3'),
			array('text'=>'工序/投料计划查询','expanded'=> false,'src'=>'?controller=Shengchan_PlanTl&action=right','leaf'=>true,'id'=>'2-4'),
	)),
	array(
		'text'=>'仓库管理','expanded'=> false,'id'=>'3','children'=>array(
		array(
			'text'=>'纱管理',
			'expanded'=> false,
			'id'=>'3-1',
			'children'=>array(
				array('text'=>'采购计划登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Plan&action=add','leaf'=>true,'id'=>'3-1-1','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'采购计划查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Plan&action=right','leaf'=>true,'id'=>'3-1-2'),
				array('text'=>'采购计划明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Plan&action=ViewMingxi','leaf'=>true,'id'=>'3-1-23'),
				array('text'=>'初始化登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Init&action=Add','leaf'=>true,'id'=>'3-1-3','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'初始化查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Init&action=Right','leaf'=>true,'id'=>'3-1-4','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'采购入库登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Cgrk&action=Add','leaf'=>true,'id'=>'3-1-5','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'采购入库查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Cgrk&action=right','leaf'=>true,'id'=>'3-1-6'),
				array('text'=>'采购入库明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Cgrk&action=ViewMingxi','leaf'=>true,'id'=>'3-1-24'),
				array('text'=>'前工序发料登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Llck&action=add','leaf'=>true,'id'=>'3-1-11','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'前工序发料查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Llck&action=right','leaf'=>true,'id'=>'3-1-12'),
				array('text'=>'前工序发料明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Llck&action=listView','leaf'=>true,'id'=>'3-1-25'),
				array('text'=>'前工序验收登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Scrk&action=add','leaf'=>true,'id'=>'3-1-7','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'前工序验收查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Scrk&action=right','leaf'=>true,'id'=>'3-1-8'),
				array('text'=>'前工序验收明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Scrk&action=listView','leaf'=>true,'id'=>'3-1-26'),
				// array('text'=>'其他入库登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Qtrk&action=add','leaf'=>true,'id'=>'3-1-9','icon'=>'Resource/Image/Menu/add2.gif'),
				// array('text'=>'其他入库查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Qtrk&action=right','leaf'=>true,'id'=>'3-1-10'),
				array('text'=>'织布发料登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_LlckZb&action=add','leaf'=>true,'id'=>'3-1-21','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'织布发料查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_LlckZb&action=right','leaf'=>true,'id'=>'3-1-22'),
				array('text'=>'织布发料明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_LlckZb&action=listView','leaf'=>true,'id'=>'3-1-30'),
				array('text'=>'销售出库登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Xsck&action=add','leaf'=>true,'id'=>'3-1-13','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'销售出库查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Xsck&action=right','leaf'=>true,'id'=>'3-1-14'),
				array('text'=>'销售出库明细查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Xsck&action=ListView','leaf'=>true,'id'=>'3-1-50'),
				array('text'=>'其他出库登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Qtck&action=add','leaf'=>true,'id'=>'3-1-15','icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'其他出库查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Qtck&action=right','leaf'=>true,'id'=>'3-1-16'),
				// array('text'=>'调库登记','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Diaoku&action=add','leaf'=>true,'id'=>'3-1-17','icon'=>'Resource/Image/Menu/add2.gif'),
				// array('text'=>'调库查询','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Diaoku&action=right','leaf'=>true,'id'=>'3-1-18'),
				array('text'=>'纱库存报表','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Llck&action=report','leaf'=>true,'id'=>'3-1-19','icon'=>'Resource/Image/Menu/report2.gif'),
				array('text'=>'坯纱染色损耗统计','expanded'=> false,'src'=>'?controller=Shengchan_Cangku_Scrk&action=SunhaoTongji','leaf'=>true,'id'=>'3-1-20','icon'=>'Resource/Image/Menu/report2.gif'),
		)),
		array(
			'text'=>'布管理',
			'expanded'=> false,
			'id'=>'3-2',
			'children'=>array(
				array(
					'text'=>'织造管理',
					'expanded'=> false,
					'id'=>'3-2-1',
					'children'=>array(
						array(
							'text'=>'初始化登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Init&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-12',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'初始化查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Init&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-13'
						),
						array(
							'text'=>'采购入库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cgrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-14',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'采购入库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cgrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-15'
						),
						array(
							'text'=>'采购入库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cgrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-16'
						),
						array(
							'text'=>'织布验收登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Scrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-1',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'织布验收查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Scrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-2'
						),
						array(
							'text'=>'织布验收明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Scrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-20'
						),
						array(
							'text'=>'预定型发料登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckDx&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-61',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'预定型发料查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckDx&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-62'
						),
						array(
							'text'=>'预定型发料明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckDx&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-63'
						),
						array(
							'text'=>'预定型验收登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_ScrkDx&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-64',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'预定型验收查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_ScrkDx&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-65'
						),
						array(
							'text'=>'预定型验收明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_ScrkDx&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-66'
						),
						array(
							'text'=>'染色发料登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Llck&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-3',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'染色发料查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Llck&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-4'
						),
						array(
							'text'=>'染色发料明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Llck&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-40'
						),
						array(
							'text'=>'后整发料登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckHzl&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-10',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'后整发料查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckHzl&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-11'
						),
						array(
							'text'=>'后整发料明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_LlckHzl&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-1-41'
						),
						array(
							'text'=>'销售码单出库',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_CkWithMadan&action=Add',
							'leaf'=>true,
							'id'=>'3-2-1-5',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cpck&action=add',
							'leaf'=>true,
							'id'=>'3-2-1-6',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库退回',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cpck&action=addTui',
							'leaf'=>true,
							'id'=>'3-2-1-60',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cpck&action=right',
							'leaf'=>true,
							'id'=>'3-2-1-7'
						),
						array(
							'text'=>'销售出库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cpck&action=listView',
							'leaf'=>true,
							'id'=>'3-2-1-49'
						),
						array(
							'text'=>'销售出库审核',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Cpck&action=ShenheList',
							'leaf'=>true,
							'id'=>'3-2-1-50'
						),
						array(
							'text'=>'坯布库存报表',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Llck&action=Report',
							'leaf'=>true,
							'id'=>'3-2-1-8',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
						array(
							'text'=>'织造损耗统计',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Zhizao_Scrk&action=SunhaoTongji',
							'leaf'=>true,
							'id'=>'3-2-1-9',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
				)),
				array(
					'text'=>'染色管理',
					'expanded'=> false,
					'id'=>'3-2-2',
					'children'=>array(
						array(
							'text'=>'初始化登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Init&action=add',
							'leaf'=>true,
							'id'=>'3-2-2-12',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'初始化查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Init&action=right',
							'leaf'=>true,
							'id'=>'3-2-2-13'
						),
						array(
							'text'=>'采购入库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cgrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-2-14',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'采购入库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cgrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-2-15'
						),
						array(
							'text'=>'采购入库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cgrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-2-16'
						),
						array(
							'text'=>'坯布染色验收登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Scrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-2-1',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'坯布染色验收查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Scrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-2-2'
						),
						array(
							'text'=>'染色验收明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Scrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-2-20'
						),
						array(
							'text'=>'后整发料登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Llck&action=add',
							'leaf'=>true,
							'id'=>'3-2-2-3',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'后整发料查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Llck&action=right',
							'leaf'=>true,
							'id'=>'3-2-2-4'
						),
						array(
							'text'=>'后整发料明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Llck&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-2-40'
						),
						array(
							'text'=>'销售码单出库',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_CkWithMadan&action=Add',
							'leaf'=>true,
							'id'=>'3-2-2-5',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cpck&action=add',
							'leaf'=>true,
							'id'=>'3-2-2-6',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库退回',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cpck&action=addTui',
							'leaf'=>true,
							'id'=>'3-2-2-60',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cpck&action=right',
							'leaf'=>true,
							'id'=>'3-2-2-7'
						),
						array(
							'text'=>'销售出库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cpck&action=listView',
							'leaf'=>true,
							'id'=>'3-2-2-49'
						),
						array(
							'text'=>'销售出库审核',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Cpck&action=ShenheList',
							'leaf'=>true,
							'id'=>'3-2-2-50'
						),
						array(
							'text'=>'染色布库存报表',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Llck&action=Report',
							'leaf'=>true,
							'id'=>'3-2-2-8',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
						array(
							'text'=>'坯布染色损耗统计',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Ranbu_Scrk&action=SunhaoTongji',
							'leaf'=>true,
							'id'=>'3-2-2-9',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
				)),
				array(
					'text'=>'后整理管理',
					'expanded'=> false,
					'id'=>'3-2-3',
					'children'=>array(
						array(
							'text'=>'初始化登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Init&action=add',
							'leaf'=>true,
							'id'=>'3-2-3-12',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'初始化查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Init&action=right',
							'leaf'=>true,
							'id'=>'3-2-3-13'
						),
						array(
							'text'=>'采购入库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cgrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-3-14',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'采购入库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cgrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-3-15'
						),
						array(
							'text'=>'采购入库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cgrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-3-16'
						),
						array(
							'text'=>'后整理验收登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Scrk&action=add',
							'leaf'=>true,
							'id'=>'3-2-3-1',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'后整理验收查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Scrk&action=right',
							'leaf'=>true,
							'id'=>'3-2-3-2'
						),
						array(
							'text'=>'后整理验收明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Scrk&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-3-20'
						),
						array(
							'text'=>'后整发料登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Llck&action=add',
							'leaf'=>true,
							'id'=>'3-2-3-3',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'后整发料查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Llck&action=right',
							'leaf'=>true,
							'id'=>'3-2-3-4'
						),
						array(
							'text'=>'后整发料明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Llck&action=ListView',
							'leaf'=>true,
							'id'=>'3-2-3-40'
						),
						array(
							'text'=>'销售码单出库',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_CkWithMadan&action=Add',
							'leaf'=>true,
							'id'=>'3-2-3-5',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库登记',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cpck&action=add',
							'leaf'=>true,
							'id'=>'3-2-3-6',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库退回',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cpck&action=AddTui',
							'leaf'=>true,
							'id'=>'3-2-3-60',
							'icon'=>'Resource/Image/Menu/add2.gif'
						),
						array(
							'text'=>'销售出库查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cpck&action=right',
							'leaf'=>true,
							'id'=>'3-2-3-7'
						),
						array(
							'text'=>'销售出库明细查询',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cpck&action=listView',
							'leaf'=>true,
							'id'=>'3-2-3-49'
						),
						array(
							'text'=>'销售出库审核',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Cpck&action=ShenheList',
							'leaf'=>true,
							'id'=>'3-2-3-50'
						),
						array(
							'text'=>'后整理库存报表',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Llck&action=Report',
							'leaf'=>true,
							'id'=>'3-2-3-8',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
						array(
							'text'=>'后整理损耗统计',
							'expanded'=> false,
							'src'=>'?controller=Shengchan_Hzl_Scrk&action=SunhaoTongji',
							'leaf'=>true,
							'id'=>'3-2-3-9',
							'icon'=>'Resource/Image/Menu/report2.gif'
						),
				)),
		)),
	)),
	array(
    	'text'=>'财务管理',
    	'expanded'=> false,
    	'id'=>'8',
    	'children'=>array(
			array('text'=>'应付管理','expanded'=> false,'id'=>'8-1','children'=>array(
				array('text'=>'其它过账登记','expanded'=> false,'id'=>'8-1-10','src'=>'?controller=Caiwu_Yf_Guozhang&action=OtherGuozhang','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'其它过账查询','expanded'=> false,'id'=>'8-1-11','src'=>'?controller=Caiwu_Yf_Guozhang&action=right2','leaf'=>true),
				array('text'=>'采购过账','expanded'=> false,'id'=>'8-1-1','src'=>'?controller=Shengchan_Ruku&action=PopupOnGuozhang2','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'加工过账','expanded'=> false,'id'=>'8-1-2','src'=>'?controller=Shengchan_Ruku&action=PopupOnGuozhangJg2','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'过账查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Guozhang&action=right','leaf'=>true,'id'=>'8-1-3'),
				array('text'=>'收票登记','expanded'=> false,'id'=>'8-1-4','src'=>'?controller=Caiwu_Yf_Fapiao&action=add','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'收票查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Fapiao&action=right','leaf'=>true,'id'=>'8-1-5'),
				array('text'=>'付款登记','expanded'=> false,'id'=>'8-1-6','src'=>'?controller=Caiwu_Yf_Fukuan&action=add','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'付款查询','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Fukuan&action=right','leaf'=>true,'id'=>'8-1-7'),
				array('text'=>'应付款报表','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Guozhang&action=report','leaf'=>true,'id'=>'8-1-8','icon'=>'Resource/Image/Menu/report2.gif'),
				array('text'=>'外协加工对账单','expanded'=> false,'src'=>'?controller=Caiwu_Yf_Guozhang&action=DuizhangList','leaf'=>true,'id'=>'8-1-9','icon'=>'Resource/Image/Menu/report2.gif'),
				
			)),
			array('text'=>'应收管理','expanded'=> false,'id'=>'8-2','children'=>array(
				array('text'=>'其它过账登记','expanded'=> false,'id'=>'8-2-8','src'=>'?controller=Caiwu_Ys_Guozhang&action=OtherGuozhang','leaf'=>true,'icon'=>'Resource/Image/Menu/add2.gif'),
				array('text'=>'其它过账查询','expanded'=> false,'id'=>'8-2-9','src'=>'?controller=Caiwu_Ys_Guozhang&action=right2','leaf'=>true),
				array('text'=>'出库过账','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'8-2-1','src'=>'?controller=Shengchan_Chuku&action=PopupOnGuozhang2','leaf'=>true),								
				array('text'=>'过账查询','expanded'=> false,'id'=>'8-2-2','src'=>'?controller=Caiwu_Ys_Guozhang&action=right','leaf'=>true),
				array('text'=>'开票登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'8-2-3','src'=>'?controller=Caiwu_Ys_Fapiao&action=add','leaf'=>true),
				array('text'=>'开票查询','expanded'=> false,'id'=>'8-2-4','src'=>'?controller=Caiwu_Ys_Fapiao&action=right','leaf'=>true),
				array('text'=>'收款登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'id'=>'8-2-5','src'=>'?controller=Caiwu_Ys_Income&action=add','leaf'=>true),
				array('text'=>'收款查询','expanded'=> false,'id'=>'8-2-6','src'=>'?controller=Caiwu_Ys_Income&action=right','leaf'=>true),
				array('text'=>'应收款报表','expanded'=> false,'id'=>'8-2-7','src'=>'?controller=Caiwu_Ys_Guozhang&action=report','leaf'=>true,'icon'=>'Resource/Image/Menu/report2.gif'),
				
			)),
    		array('text'=>'收支管理','expanded'=> false,'id'=>'8-3','children'=>array(
				array('text'=>'收款登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Caiwu_Income&action=add','leaf'=>true,'id'=>'8-3-1'),
				array('text'=>'收款查询','expanded'=> false,'src'=>'?controller=caiwu_income&action=right','leaf'=>true,'id'=>'8-3-2'),
				array('text'=>'支出登记','icon'=>'Resource/Image/Menu/add2.gif','expanded'=> false,'src'=>'?controller=Caiwu_Feiyong&action=add','leaf'=>true,'id'=>'8-3-3'),
				array('text'=>'支出查询','expanded'=> false,'src'=>'?controller=Caiwu_Feiyong&action=right','leaf'=>true,'id'=>'8-3-4'),
				array('text'=>'现金日报表','expanded'=> false,'src'=>'?controller=Caiwu_CashReport&action=right','leaf'=>true,'id'=>'8-3-5'),
	            array('text'=>'费用明细报表','expanded'=> false,'src'=>'?controller=Caiwu_CashReport&action=Report','leaf'=>true,'id'=>'8-3-8'),
				array('text'=>'支出科目定义','expanded'=> false,'src'=>'?controller=jichu_Feiyong&action=right','leaf'=>true,'id'=>'8-3-7'),
				
		)),
	)),
	array(
		'text'=>'报表中心',
		'expanded'=> false,//是否展开
		'id'=>9,
		'children'=>array(//如果是目录，leaf为false,或者不写,同时必须定义children属性，children下是另一颗树
			array('text'=>'订单跟踪统计','expanded'=> false,'src'=>'?controller=Trade_Order&action=Tracing','leaf'=>true,'id'=>'9-1','icon'=>'Resource/Image/Menu/report2.gif'),
			array('text'=>'订单成本统计','expanded'=> false,'src'=>'?controller=Trade_Order&action=chengbenReport','leaf'=>true,'id'=>'9-2','icon'=>'Resource/Image/Menu/report2.gif'),
			
			array('text'=>'染厂投坯日报表','expanded'=> false,'src'=>'?controller=Shengchan_Ranbu_Scrk&action=TouliaoReport','leaf'=>true,'id'=>'9-10','icon'=>'Resource/Image/Menu/report2.gif'),
			array('text'=>'染厂出缸日报表','expanded'=> false,'src'=>'?controller=Shengchan_Ranbu_Scrk&action=ChanliangTongji','leaf'=>true,'id'=>'9-11','icon'=>'Resource/Image/Menu/report2.gif'),
			array('text'=>'仓库出入库明细','expanded'=> false,'src'=>'?controller=Shengchan_chuku&action=ReportViewRC','leaf'=>true,'id'=>'9-12','icon'=>'Resource/Image/Menu/report2.gif'),
			array('text'=>'销售明细报表','expanded'=> false,'src'=>'?controller=Shengchan_chuku&action=ReportViewXS','leaf'=>true,'id'=>'9-13','icon'=>'Resource/Image/Menu/report2.gif'),
			array('text'=>'销售汇总报表','expanded'=> false,'src'=>'?controller=Shengchan_chuku&action=ReportHuizongXS','leaf'=>true,'id'=>'9-14','icon'=>'Resource/Image/Menu/report2.gif'),
		)
	),
	array(
		'text'=>'基础资料',
		'expanded'=> false,
		'id'=>'6',
		'children'=>array(
			array('text'=>'客户档案','expanded'=> false,'src'=>'?controller=Jichu_Client&action=right','leaf'=>true,'id'=>'6-1'),
			array('text'=>'供应商档案','expanded'=> false,'src'=>'?controller=Jichu_Supplier&action=right','leaf'=>true,'id'=>'6-2'),
			array('text'=>'纱档案','expanded'=> false,'src'=>'?controller=Jichu_Product&action=right','leaf'=>true,'id'=>'6-3'),
			array('text'=>'布档案','expanded'=> false,'src'=>'?controller=Jichu_Chanpin&action=right','leaf'=>true,'id'=>'6-6'),
			array('text'=>'加工户档案','expanded'=> false,'src'=>'?controller=Jichu_Jiagonghu&action=right','leaf'=>true,'id'=>'6-4'),
			array('text'=>'工序档案','expanded'=> false,'src'=>'?controller=Jichu_Gongxu&action=right','leaf'=>true,'id'=>'6-5'),
			
			array('text'=>'部门档案','expanded'=> false,'src'=>'?controller=Jichu_Department&action=right','leaf'=>true,'id'=>'6-7'),
			array('text'=>'员工档案','expanded'=> false,'src'=>'?controller=Jichu_Employ&action=right','leaf'=>true,'id'=>'6-8'),
			// array('text'=>'机台设备档案','expanded'=> false,'src'=>'?controller=Jichu_Jitai&action=right','leaf'=>true,'id'=>'6-9'),
			array('text'=>'仓库档案','expanded'=> false,'src'=>'?controller=Jichu_Kuwei&action=right','leaf'=>true,'id'=>'6-10'),
			array('text'=>'银行账户','expanded'=> false,'src'=>'?controller=caiwu_bank&action=right','leaf'=>true,'id'=>'6-16'),
			// array('text'=>'颜色档案','expanded'=> false,'src'=>'?controller=Jichu_Color&action=right','leaf'=>true,'id'=>'6-17')
		)
	),
	array(
		'text'=>'系统设置',
		'expanded'=> false,
		'id'=>'7',
		'children'=>array(
			array('text'=>'权限管理','expanded'=> false,'id'=>'7-1','children'=>array(
				array('text'=>'用户管理','icon'=>'Resource/Image/Menu/adduser.png','expanded'=>false,'src'=>'?controller=Acm_User&action=right','leaf'=>true,'id'=>'7-1-1'),
				array('text'=>'组管理','expanded'=> false,'src'=>'?controller=Acm_Role&action=right','leaf'=>true,'id'=>'7-1-2'),
				array('text'=>'权限设置','expanded'=> false,'src'=>'?controller=Acm_Func&action=setQx','leaf'=>true,'id'=>'7-1-3')
			)),
			array('text'=>'修改密码','expanded'=> false,'src'=>'?controller=Acm_User&action=changePwd','leaf'=>true,'id'=>'7-2'),
		)
	),
	array('text'=>'通知管理','icon'=>'Resource/Image/Menu/messages.gif','expanded'=> false,'src'=>'?controller=OaMessage&action=right','leaf'=>true,'id'=>'101'),
	array('text'=>'通知类别','icon'=>'Resource/Image/Menu/messages.gif','expanded'=> false,'src'=>'?controller=OaMessageClass&action=right','leaf'=>true,'id'=>'103')
);
?>
