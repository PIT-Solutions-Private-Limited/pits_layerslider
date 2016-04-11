<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'PITS.'.$_EXTKEY,
	'Layerslider',
	array(
		'Layerslider' => 'list, show, new, create',
                'Pitslayerslider' => 'list, select, addtab, addlayer, savetabdata, saveLabel, getdata, deleteTab, allslider, duplicateslider, new',
		
	),
	// non-cacheable actions
	array(
		'Layerslider' => 'create',
		'Pitslayerslider' => 'addtab,addlayer',
	)
);

