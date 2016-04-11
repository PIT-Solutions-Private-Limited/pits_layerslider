<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitslayerslider_domain_model_layerslider'] = array(
	'ctrl' => $TCA['tx_pitslayerslider_domain_model_layerslider']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title , background , thumbnail , slidedelay ,
				slidedirection , durationin	 ,easingin ,delayin,durationout,easingout,delayout,layer_link,  layer_link_target , tab_order  ,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_pitslayerslider_domain_model_layerslider',
				'foreign_table_where' => 'AND tx_pitslayerslider_domain_model_layerslider.pid=###CURRENT_PID### AND tx_pitslayerslider_domain_model_layerslider.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			),
		),
		'background' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.background',
				'config' => array(
						'type' => 'text',
				        'cols' => '30',
				        'rows' => '5',
				),
		),
		'thumbnail' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.thumbnail',
				'config' => array(
						'type' => 'text',
						'cols' => '30',
						'rows' => '5',
				),
		),
		'slidedelay' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.slidedelay',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'slidedirection' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.slidedirection',
				'config' => array(
						'type' => 'select',
						'items' => array(
							array('Select', ''),
							array('Fade', 'fade'),
						    array('Top', 'top'),
						    array('Right', 'right'),
						    array('Left', 'left'),
							array('Bottom', 'bottom'),
						)
				),
		),
		'durationin' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.durationin',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'easingin' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.easingin',
				'config' => array(
						'type' => 'select',
						'items' => array(
							array('linear' , 'linear' ),
							array('swing' , 'swing'),
							array('easeInQuad' , 'easeInQuad'),
							array('easeOutQuad' ,'easeOutQuad'),
							array('easeInOutQuad' , 'easeInOutQuad'),
							array('easeInCubic' , 'easeInCubic'),
							array('easeOutCubic' ,'easeOutCubic'),
							array('easeInOutCubic' ,'easeInOutCubic'),
							array('easeInQuart' , 'easeInQuart'),
							array('easeOutQuart' , 'easeOutQuart'),
							array('easeInOutQuart' ,'easeInOutQuart'),
							array('easeInQuint' ,'easeInQuint'),
							array('easeOutQuint' ,'easeOutQuint'),
							array('easeInOutQuint' ,'easeInOutQuint'),
							array('easeInSine' ,'easeInSine'),
							array('easeOutSine' ,'easeOutSine'),
							array('easeInOutSine' ,'easeInOutSine'),
							array('easeInExpo' ,'easeInExpo'),
							array('easeOutExpo' ,'easeOutExpo'),
							array('easeInOutExpo' ,'easeInOutExpo'),
							array('easeInCirc' ,'easeInCirc'),
							array('easeOutCirc' ,'easeOutCirc'),
							array('easeInOutCirc' ,'easeInOutCirc'),
							array('easeInElastic' ,'easeInElastic'),
							array('easeOutElastic' ,'easeOutElastic'),
							array('easeInOutElastic' ,'easeInOutElastic'),
							array('easeInBack' ,'easeInBack'),
							array('easeOutBack' ,'easeOutBack'),
							array('easeInOutBack' ,'easeInOutBack'),
							array('easeInBounce' ,'easeInBounce'),
							array('easeOutBounce' ,'easeOutBounce'),
							array('easeInOutBounce' , 'easeInOutBounce'),
						),
				),
		),
		'delayin' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.delayin',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),	
		'durationout' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.durationout',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'easingout' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.easingout',
				'config' => array(
						'type' => 'select',
						'items' => array(
							array('linear' , 'linear' ),
							array('swing' , 'swing'),
							array('easeInQuad' , 'easeInQuad'),
							array('easeOutQuad' ,'easeOutQuad'),
							array('easeInOutQuad' , 'easeInOutQuad'),
							array('easeInCubic' , 'easeInCubic'),
							array('easeOutCubic' ,'easeOutCubic'),
							array('easeInOutCubic' ,'easeInOutCubic'),
							array('easeInQuart' , 'easeInQuart'),
							array('easeOutQuart' , 'easeOutQuart'),
							array('easeInOutQuart' ,'easeInOutQuart'),
							array('easeInQuint' ,'easeInQuint'),
							array('easeOutQuint' ,'easeOutQuint'),
							array('easeInOutQuint' ,'easeInOutQuint'),
							array('easeInSine' ,'easeInSine'),
							array('easeOutSine' ,'easeOutSine'),
							array('easeInOutSine' ,'easeInOutSine'),
							array('easeInExpo' ,'easeInExpo'),
							array('easeOutExpo' ,'easeOutExpo'),
							array('easeInOutExpo' ,'easeInOutExpo'),
							array('easeInCirc' ,'easeInCirc'),
							array('easeOutCirc' ,'easeOutCirc'),
							array('easeInOutCirc' ,'easeInOutCirc'),
							array('easeInElastic' ,'easeInElastic'),
							array('easeOutElastic' ,'easeOutElastic'),
							array('easeInOutElastic' ,'easeInOutElastic'),
							array('easeInBack' ,'easeInBack'),
							array('easeOutBack' ,'easeOutBack'),
							array('easeInOutBack' ,'easeInOutBack'),
							array('easeInBounce' ,'easeInBounce'),
							array('easeOutBounce' ,'easeOutBounce'),
							array('easeInOutBounce' , 'easeInOutBounce'),
						),
				),
		),
		'delayout' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.delayout',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_link' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_link',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_link_target' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_link_target',
				'config' => array(
						'type' => 'select',
						'items' => array(
							array('Select', ''),
							array('_self', '_self'),
						    array('_blank', '_blank'),
						    array('_parent', '_parent'),
						    array('_top', '_top'),
						)
				),
		),
	),
);
