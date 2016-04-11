<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_pitslayerslider_domain_model_sublayers'] = array(
	'ctrl' => $TCA['tx_pitslayerslider_domain_model_sublayers']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource,
				hidden , layer_title, layer_text , layer_style, , layer_url ,layer_link_control
				layer_image ,layer_title ,layer_image_alt ,layer_custom ,
				layer_top ,layer_left ,layer_custom_style ,layer_slidein_dir ,layer_easingin ,layer_easingout ,layer_slideout_dir ,layer_slider_other_options ,
				layer_slidein_duration ,layer_delay_in int(11) ,layer_delay_out int(11) ,layer_slideout_duration ,layer_units ,layer_background ,parenttab_id ,
				;;1,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_pitslayerslider_domain_model_sublayers',
				'foreign_table_where' => 'AND tx_pitslayerslider_domain_model_sublayers.pid=###CURRENT_PID### AND tx_pitslayerslider_domain_model_sublayers.sys_language_uid IN (-1,0)',
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
		'layer_title' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_title',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_text' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_text',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_style' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_style',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_url' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_url',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_link_control' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_link_control',
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
		'layer_image' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_image',
				'config' => array(
						'type' => 'text',
						'cols' => '20',
						'rows' => '5',
				)
		),
		'layer_title' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_title',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_image_alt' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_image_alt',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_custom' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_custom',
				'config' => array(
						'type' => 'text',
						'cols' => '20',
						'rows' => '5',
				)
		),
		'layer_top' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_top',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_left' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_left',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				)
		),
		'layer_custom_style' => array(
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_custom_style',
				'config' => array(
						'type' => 'text',
						'cols' => '20',
						'rows' => '5',
				)
		),
		'layer_slidein_dir' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_slidein_dir',
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
		'layer_easingin' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_easingin',
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
		'layer_easingout' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_easingout',
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
		'layer_slideout_dir' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_slideout_dir',
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
		'layer_slider_other_options' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_slider_other_options',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_slidein_duration' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_slidein_duration',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),	
		'layer_delay_in' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_delay_in',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_delay_out' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_delay_out',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_slideout_duration' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_slideout_duration',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'layer_units' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.layer_units',
				'config' => array(
						'type' => 'input',
						'size' => 30,
						'max' => 255,
				),
		),
		'parenttab_id' => array(
				'exclude' => 0,
				'label' => 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider.parenttab_id',
				'config' => array(
						'type' => 'select',
						'foreign_table' => 'tx_pitslayerslider_domain_model_layerslider',
						'foreign_table_where' => "AND tx_pitslayerslider_domain_model_layerslider.deleted = 0 AND tx_pitslayerslider_domain_model_layerslider.hidden = 0",
						'size' => 1,
						'minitems' => 0,
						'maxitems' => 1
						
				),
		),	
			
			
			
			
			
	),
);


?>