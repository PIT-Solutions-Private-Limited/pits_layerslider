<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'PITS.'.$_EXTKEY,
	'Layerslider',
	'layerslider'
);

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'PITS.'.$_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'pitslayerslider',	// Submodule key
		'',						// Position
		array(
			'Pitslayerslider' => 'list, select, addtab, addlayer, savetabdata, saveLabel, getdata, deleteTab, allslider, duplicateslider,new',
	
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_pitslayerslider.xml',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Layer Slider');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pitslayerslider_domain_model_layerslider', 'EXT:pits_layerslider/Resources/Private/Language/locallang_csh_tx_pitslayerslider_domain_model_layerslider.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pitslayerslider_domain_model_layerslider');
$TCA['tx_pitslayerslider_domain_model_layerslider'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_layerslider',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Layerslider.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitslayerslider_domain_model_layerslider.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pitslayerslider_domain_model_sublayers', 'EXT:pits_layerslider/Resources/Private/Language/locallang_csh_tx_pitslayerslider_domain_model_sublayers.xml');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pitslayerslider_domain_model_sublayers');
$TCA['tx_pitslayerslider_domain_model_sublayers'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:pits_layerslider/Resources/Private/Language/locallang_db.xml:tx_pitslayerslider_domain_model_sublayers',
		'label' => 'layer_title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'layer_title',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Pitslayerslider.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_pitslayerslider_domain_model_sublayers.gif'
	),
);
$pluginSignature = str_replace('_','',$_EXTKEY).'_layerslider';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature,'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

?>