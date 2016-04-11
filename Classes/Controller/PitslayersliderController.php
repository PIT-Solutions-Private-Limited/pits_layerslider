<?php

namespace PITS\PitsLayerslider\Controller;

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Sivaprasad S <sivaprasad.s@pitsolutions.com>, Pit Solution Pvt Ltd
 *  Abin Sabu <abin.sabu@pitsolutions.com>, PIT Solution Pvt Ltd
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/**
 *
 *
 * @package pits_layerslider
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PitslayersliderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $tags = array("span", "h1", "h2", "h3", "h4", "h5", "h6", "p");

        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause = 'deleted = 0 AND hidden = 0';
        if (!empty($_REQUEST['id'])) {
            $where_clause .= ' AND pid = "' . $_REQUEST['id'] . '" ';
        }


        $tabsRecords['tabsInfo'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = 'tab_order', $limit = '', $uidIndexField = ''
        );

        foreach ($tabsRecords['tabsInfo'] as $tabsKey => $tabs) {
            $tabsRecords['tabsInfo'][$tabsKey]['is_newTransistion'] = ( $tabs['enabletransition'] == 1 ) ? "on" : "off";
            $tabsRecords['tabsInfo'][$tabsKey]['enabletransitionClass'] = ( $tabs['enabletransition'] == 1 ) ? "enabletransition-inactive" : "enabletransition-active";
            $tabsRecords['tabsInfo'][$tabsKey]['enabletransitionClassButton'] = ( $tabs['enabletransition'] == 1 ) ? "" : "enabletransition-inactive";
        }
        //exit;
        foreach ($tabsRecords['tabsInfo'] as $key => $value) {
            $select_fields = '*';
            $from_table = 'tx_pitslayerslider_domain_model_sublayers';
            $where_clause = "parenttab_id =" . $value['uid'] . ' AND deleted = 0 AND hidden = 0';
            $tabsRecords['tabsInfo'][$key]['childLayers'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                    $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = 'layer_order', $limit = '', $uidIndexField = ''
            );
            foreach ($tabsRecords['tabsInfo'][$key]['childLayers'] as $layerInfoKey => $layerInfo) {
                $tabsRecords['tabsInfo'][$key]['childLayers'][$layerInfoKey]['is_htmltag'] = FALSE;
                if (in_array(strtolower($layerInfo['layer_style']), $tags) && empty($layerInfo['layer_image'])) {
                    $tabsRecords['tabsInfo'][$key]['childLayers'][$layerInfoKey]['is_htmltag'] = TRUE;
                }
            }
        }
        $tabsRecords['transitionList'] = array('fade' => 'Fade', 'auto' => 'Auto (Slide from auto direction)', 'top' => 'Top (Slide from top)', 'right' => 'Right (Slide from right)', 'bottom' => 'Bottom (Slide from bottom)', 'left' => 'Left (Slide from left)');
        $tabsRecords['urlControlList'] = array('_self', '_blank', '_parent', '_top');
        $tabsRecords['styleList'] = array('div' => 'Select style', 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'span' => 'Span', 'p' => 'P');
        $tabsRecords['easingList'] = array('linear', 'swing', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce');
        $tabsRecords['tabSliderTrans'] = array('top' => 'top', 'right' => 'right', 'bottom' => 'bottom', 'left' => 'left');
        $tabsRecords['pageId'] = $_REQUEST['id'];


        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause = 'deleted = 0 AND hidden = 0 ';
        $where_clause .=!empty($_REQUEST['id']) ? " AND pid =" . $_REQUEST['id'] . " " : "";
        $tabsRecords_1 = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = '');
        $i = 0;
        foreach ($tabsRecords_1 as $pin => $value) {
            $transition = ( empty($value['transitions3d']) || empty($value['transitions2d']) ) ? true : false;
            $style = '';

            $style .= ( $value['slidedelay'] != '' ) ? "slidedelay: " . $value['slidedelay'] . ";" : "";
            $style .= ( $value['slidedirection'] != '' && $transition ) ? "slidedirection: " . $value['slidedirection'] . ";" : "";
            $style .= ( $value['durationin'] != '' && $transition ) ? "durationin: " . $value['durationin'] . ";" : "";
            $style .= ( $value['easingin'] != '' && $transition ) ? "easingin: " . $value['easingin'] . ";" : "";
            $style .= ( $value['delayin'] != '' && $transition ) ? "delayin: " . $value['delayin'] . ";" : "";
            $style .= ( $value['durationout'] != '' && $transition ) ? "durationout: " . $value['durationout'] . ";" : "";
            $style .= ( $value['easingout'] != '' && $transition ) ? "easingout: " . $value['easingout'] . ";" : "";
            $style .= ( $value['delayout'] != '' && $transition ) ? "delayout: " . $value['delayout'] . ";" : "";

            if (!empty($value['transitions2d'])) {
                $style .= "transition2d: " . $value['transitions2d'] . ";";
            }
            if (!empty($value['transitions3d'])) {
                $style .= "transition3d: " . $value['transitions3d'] . ";";
            }



            #$tabsRecords_1[$pin]['style'] = $style ;
            $select_fields = '*';
            $from_table = 'tx_pitslayerslider_domain_model_sublayers';
            $where_clause = " deleted = 0 AND hidden = 0 AND parenttab_id =" . $value['uid'];
            $layerRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                    $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = ''
            );
            $finalArr [$value['uid']] = $value;
            $finalArr [$value['uid']]['style'] = $style;


            foreach ($layerRecords as $key => $records) {
                if (sizeof(sizeof($layerRecords)) == ($key + 1)) {
                    $i = 0;
                }

                $records['is_htmltag'] = FALSE;
                if (in_array(strtolower($records['layer_style']), $tags) && empty($records['layer_image'])) {
                    $records['is_htmltag'] = TRUE;
                }
                #$records['layer_style']  =  ( $records['layer_style'] == '' ) && empty( $records['layer_image'] ) ? 'div' : $records['layer_style'] ;
                $innerStyle = '';
                $innerStyle .= ( $records['layer_top'] != '' ) ? "top: " . $records['layer_top'] . "px;" : '';
                $innerStyle .= ( $records['layer_left'] != '' ) ? "left: " . $records['layer_left'] . "px;" : '';
                $innerStyle .= ( $records['layer_slidein_dir'] != '' ) ? "slidedirection: " . $records['layer_slidein_dir'] . ";" : '';
                $innerStyle .= ( $records['layer_slideout_dir'] != '' ) ? "slideoutdirection: " . $records['layer_slideout_dir'] . ";" : '';
                $innerStyle .= ( $records['layer_easingin'] != '' ) ? "easingin: " . $records['layer_easingin'] . ";" : '';
                $innerStyle .= ( $records['layer_easingout'] != '' ) ? "easingout: " . $records['layer_easingout'] . ";" : '';
                $innerStyle .= ( $records['layer_slidein_duration'] != '' ) ? "durationin: " . $records['layer_slidein_duration'] . ";" : '';
                $innerStyle .= ( $records['layer_slideout_duration'] != '' ) ? "durationout: " . $records['layer_slideout_duration'] . ";" : '';
                $innerStyle .= ( $records['layer_delay_in'] != '' ) ? "delayin: " . $records['layer_delay_in'] . ";" : '';
                $innerStyle .= ( $records['layer_units'] != '' ) ? "showuntil: " . $records['layer_units'] . ";" : '';
                $innerStyle .= ( $records['layer_custom_style'] != '' ) ? $records['layer_custom_style'] : '';


                $layerRecords[$key]['innerStyle'] = $innerStyle;
                $finalArr [$value['uid']]['child'][$i] = $records;
                $finalArr [$value['uid']]['child'][$i]['innerStyle'] = $innerStyle;
                $i++;
            }
        }
        $pos = strrpos($_SERVER['REQUEST_URI'], "typo3/mod.php?");
        $project = substr($_SERVER['REQUEST_URI'], 0, $pos);
        $urlRef = "http://" . $_SERVER['HTTP_HOST'] . $project;
        $globalSettingArr['baseUrl'] = $urlRef;
        $this->view->assign("globalSetting", $globalSettingArr);
        $this->view->assign("tabInfo", $finalArr);
        $this->view->assign("tabs", $tabsRecords);
    }

    /**
     * action show
     *
     * @param Tx_PitsLayerslider_Domain_Model_Pitslayerslider $pitslayerslider
     * @return void
     */
    public function addtabAction() {
        $request = $this->request->getArguments();
//        print_r($request['tab_id']);
//        print_r($request['title']);
//        die;
//        $insert['tab_id'] = $request['tab_id'];
//        $insert['title'] = $request['title'];
        $insert['title'] = $request['tab_title'];
        if (!empty($_REQUEST['id'])) {
            $insert['pid'] = $_REQUEST['id'];
        }
        $insert['tstamp'] = time();
        $insert['crdate'] = time();
        $insert['tab_order'] = 999;
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitslayerslider_domain_model_layerslider', $insert);
        $sublayer['parenttab_id'] = $GLOBALS['TYPO3_DB']->sql_insert_id();

        $sublayer['tstamp'] = time();
        $sublayer['crdate'] = time();
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitslayerslider_domain_model_sublayers', $sublayer);
        //update the layer name
        $fields_values['layer_title'] = 'Layer #' . $GLOBALS['TYPO3_DB']->sql_insert_id();
        $table = "tx_pitslayerslider_domain_model_sublayers";
        $where = "uid = " . $GLOBALS['TYPO3_DB']->sql_insert_id();
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        exit;
    }

    /**
     * action show
     *
     * @param Tx_PitsLayerslider_Domain_Model_Pitslayerslider $pitslayerslider
     * @return void
     */
    public function addlayerAction() {
        $request = $this->request->getArguments();
        $sublayer['parenttab_id'] = $request['tab_id'];
        if (!empty($_REQUEST['id'])) {
            $sublayer['pid'] = $_REQUEST['id'];
        }
        $sublayer['tstamp'] = time();
        $sublayer['crdate'] = time();
        $sublayer['layer_order'] = 999;
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitslayerslider_domain_model_sublayers', $sublayer);
        $tabInfo["uid"] = $GLOBALS['TYPO3_DB']->sql_insert_id();
        //update the layer name
        $fields_values['layer_title'] = 'Layer #' . $GLOBALS['TYPO3_DB']->sql_insert_id();
        $table = "tx_pitslayerslider_domain_model_sublayers";
        $where = "uid = " . $GLOBALS['TYPO3_DB']->sql_insert_id();
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        $tabInfo["tab_id"] = $request['tab_id'];
        $tabInfo['transitionList'] = array('fade' => 'Fade', 'auto' => 'Auto (Slide from auto direction)', 'top' => 'Top (Slide from top)', 'right' => 'Right (Slide from right)', 'bottom' => 'Bottom (Slide from bottom)', 'left' => 'Left (Slide from left)');
        $tabInfo['urlControlList'] = array('_self', '_blank', '_parent', '_top');
        $tabInfo['styleList'] = array('div' => 'Select style', 'h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6', 'span' => 'Span', 'p' => 'P');
        $tabInfo['easingList'] = array('linear', 'swing', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 'easeInOutElastic', 'easeInBack', 'easeOutBack', 'easeInOutBack', 'easeInBounce', 'easeOutBounce', 'easeInOutBounce');

        $this->view->assign("tabInfo", $tabInfo);
        echo $this->view->render();
        exit;
    }

    /**
     * action savetabdata
     *
     * @return void
     */
    public function savetabdataAction() {
        $request = $this->request->getArguments();
        $counter = 100;
        if (!empty($_REQUEST['id'])) {
            $pid = $_REQUEST['id'];
        }

        foreach ($request['layer_data'] as $uid => $fields_values) {
            $fields_values['layer_order'] = $counter;
            $fields_values['pid'] = $pid;
            $table = "tx_pitslayerslider_domain_model_sublayers";
            $where = "uid = " . $uid;
            $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
            #echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
            $counter++;
        }

        foreach ($request['tab_data'] as $uid => $fields_values) {
            $fields_values['tab_order'] = $counter;
            $table = "tx_pitslayerslider_domain_model_layerslider";
            $where = "uid = " . $uid;
            $fields_values['pid'] = $pid;
            #$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
            #echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery ;
            $counter++;
        }
        exit;
    }

    /**
     * action saveLabel
     *
     * @return void
     */
    public function saveLabelAction() {
        $request = $this->request->getArguments();
        if ($request['type'] == 'tab') {
            $uid = $request['tab_id'];
            $fields_values = array('title' => $request['label_name']);
            $table = "tx_pitslayerslider_domain_model_layerslider";
        } else {
            $uid = $request['layer_id'];
            $fields_values = array('layer_title' => $request['label_name']);
            $table = "tx_pitslayerslider_domain_model_sublayers";
        }
        $where = "uid = " . $uid;
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        exit();
    }

    /**
     * action deleteTab
     *
     * @return void
     */
    public function duplicatesliderAction() {
        $request = $this->request->getArguments();
        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause = 'deleted = 0 AND hidden = 0 AND uid =' . $request['tab_id'];
        #$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $tabsInfo = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = 'tab_order', $limit = '', $uidIndexField = ''
        );
        foreach ($tabsInfo[0] as $key => $value) {
            if ($key != "uid") {
                $insertRecord[$key] = $value;
            }
        }
        $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitslayerslider_domain_model_layerslider', $insertRecord);
        $parenttab_id = $GLOBALS['TYPO3_DB']->sql_insert_id();
        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_sublayers';
        $where_clause = 'deleted = 0 AND hidden = 0 AND parenttab_id =' . $request['tab_id'];
        $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $sublayers = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = 'uid', $limit = '', $uidIndexField = ''
        );

        foreach ($sublayers as $key => $value) {
            foreach ($value as $key_1 => $value_1) {
                if ($key_1 != "uid") {
                    $insertSublayers[$key_1] = $value_1;
                }
                $insertSublayers[$key_1] = ( $key_1 == "parenttab_id" ) ? $parenttab_id : $insertSublayers[$key_1];
            }
            #$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_INSERTquery('tx_pitslayerslider_domain_model_sublayers', $insertSublayers);
            #echo $GLOBALS['TYPO3_DB']->debug_lastBuiltQuery;
        }
    }

    /**
     * action deleteTab
     *
     * @return void
     */
    public function deleteTabAction() {
        $request = $this->request->getArguments();
        $uid = $request['tabId'];
        $fields_values = array('deleted' => 1);
        if ($request['type'] == 'tab') {
            $table = "tx_pitslayerslider_domain_model_layerslider";
            $where = "uid = " . $uid;
            $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
            //Delete sub layer
            $table = "tx_pitslayerslider_domain_model_sublayers";
            $where = "parenttab_id = " . $uid;
            $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        } else {
            //Delete sub layer
            $table = "tx_pitslayerslider_domain_model_sublayers";
            $where = "uid = " . $uid;
            $GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
            $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, $where, $fields_values, $no_quote_fields = '');
        }

        exit();
    }

    public function allsliderAction() {
        $request = $this->request->getArguments();
        $tab_id = $request['tab_id'];
        
        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause = 'deleted = 0 AND hidden = 0 ';
        $where_clause .=!empty($_REQUEST['id']) ? " AND pid =" . $_REQUEST['id'] . " " : "";
        $tabsRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = "uid = $tab_id desc", $limit = '', $uidIndexField = '');
        $i = 0;
        foreach ($tabsRecords as $pin => $value) {
            $transition = ( empty($value['transitions3d']) || empty($value['transitions2d']) ) ? true : false;
            $style = '';

            $style .= ( $value['slidedelay'] != '' ) ? "slidedelay: " . $value['slidedelay'] . ";" : "";
            $style .= ( $value['slidedirection'] != '' && $transition ) ? "slidedirection: " . $value['slidedirection'] . ";" : "";
            $style .= ( $value['durationin'] != '' && $transition ) ? "durationin: " . $value['durationin'] . ";" : "";
            $style .= ( $value['easingin'] != '' && $transition ) ? "easingin: " . $value['easingin'] . ";" : "";
            $style .= ( $value['delayin'] != '' && $transition ) ? "delayin: " . $value['delayin'] . ";" : "";
            $style .= ( $value['durationout'] != '' && $transition ) ? "durationout: " . $value['durationout'] . ";" : "";
            $style .= ( $value['easingout'] != '' && $transition ) ? "easingout: " . $value['easingout'] . ";" : "";
            $style .= ( $value['delayout'] != '' && $transition ) ? "delayout: " . $value['delayout'] . ";" : "";

            if (!empty($value['transitions2d'])) {
                $style .= "transition2d: " . $value['transitions2d'] . ";";
            }
            if (!empty($value['transitions3d'])) {
                $style .= "transition3d: " . $value['transitions3d'] . ";";
            }

            #$tabsRecords[$pin]['style'] = $style ;
            $select_fields = '*';
            $from_table = 'tx_pitslayerslider_domain_model_sublayers';
            $where_clause = " deleted = 0 AND hidden = 0 AND parenttab_id =" . $value['uid'];
            $layerRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                    $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = ''
            );
            $finalArr [$value['uid']] = $value;
            $finalArr [$value['uid']]['style'] = $style;

            $tags = array("span", "h1", "h2", "h3", "h4", "h5", "h6", "p");
            foreach ($layerRecords as $key => $records) {
                if (sizeof(sizeof($layerRecords)) == ($key + 1)) {
                    $i = 0;
                }
                $records['is_htmltag'] = FALSE;
                if (in_array(strtolower($records['layer_style']), $tags)) {
                    $records['is_htmltag'] = TRUE;
                }
                $records['layer_style'] = $records['layer_style'] == '' ? 'div' : $records['layer_style'];
                $innerStyle = '';
                $innerStyle .= ( $records['layer_custom_style'] != '' ) ? $records['layer_custom_style'] : '';
                $innerStyle .= ( $records['layer_top'] != '' ) ? "top: " . $records['layer_top'] . "px;" : '';
                $innerStyle .= ( $records['layer_left'] != '' ) ? "left: " . $records['layer_left'] . "px;" : '';
                $innerStyle .= ( $records['layer_slidein_dir'] != '' ) ? "slidedirection: " . $records['layer_slidein_dir'] . ";" : '';
                $innerStyle .= ( $records['layer_slideout_dir'] != '' ) ? "slideoutdirection: " . $records['layer_slideout_dir'] . ";" : '';
                $innerStyle .= ( $records['layer_easingin'] != '' ) ? "easingin: " . $records['layer_easingin'] . ";" : '';
                $innerStyle .= ( $records['layer_easingout'] != '' ) ? "easingout: " . $records['layer_easingout'] . ";" : '';
                $innerStyle .= ( $records['layer_slidein_duration'] != '' ) ? "durationin: " . $records['layer_slidein_duration'] . ";" : '';
                $innerStyle .= ( $records['layer_slideout_duration'] != '' ) ? "durationout: " . $records['layer_slideout_duration'] . ";" : '';
                $innerStyle .= ( $records['layer_delay_in'] != '' ) ? "delayin: " . $records['layer_delay_in'] . ";" : '';
                $innerStyle .= ( $records['layer_units'] != '' ) ? "showuntil: " . $records['layer_units'] . ";" : '';

                $layerRecords[$key]['innerStyle'] = $innerStyle;
                $finalArr [$value['uid']]['child'][$i] = $records;
                $finalArr [$value['uid']]['child'][$i]['innerStyle'] = $innerStyle;
                $i++;
            }
        }
//        echo "test";
        
        $this->view->assign("globalSetting", $globalSettingArr);
        $this->view->assign("tabInfo", $finalArr);
    }

    /**
     * action saveLabel
     *
     * @return void
     */
    public function getdataAction() {
        $request = $this->request->getArguments();

        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause = "uid =" . $request['tab_id'] . " AND deleted = 0 AND hidden = 0";
        $tabsRecords['sliderInfo'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = ''
        );

        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_sublayers';
        $where_clause = "parenttab_id =" . $request['tab_id'] . " AND deleted = 0 AND hidden = 0";
        $tabsRecords['tabsInfo'] = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows(
                $select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = ''
        );
        $tags = array("span", "h1", "h2", "h3", "h4", "h5", "h6", "p", "div");
        foreach ($tabsRecords['tabsInfo'] as $key => $records) {
            $tabsRecords['tabsInfo'][$key]['is_htmltag'] = FALSE;
            if (in_array(strtolower($records['layer_style']), $tags) && empty($records['layer_image'])) {
                $tabsRecords['tabsInfo'][$key]['is_htmltag'] = TRUE;
            }
        }
        /* print_R($tabsRecords);exit; */
        $this->view->assign("tabInfo", $tabsRecords);
        echo $this->view->render();
        exit;
    }

    /**
     * action new
     *
     * @param \PITS\PitsLayerslider\Domain\Model\Layerslider $newLayerslider
     * @dontvalidate $newLayerslider
     * @return void
     */
    public function newAction(\PITS\PitsLayerslider\Domain\Model\Layerslider $newLayerslider = NULL) {
        $this->view->assign('newLayerslider', $newLayerslider);
    }

}
