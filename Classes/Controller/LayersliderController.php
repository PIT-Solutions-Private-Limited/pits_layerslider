<?php

namespace PITS\PitsLayerslider\Controller;

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\DebugUtility;

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2013
 *  Sivaprasad S <sivaprasad.s@pitsolutions.com>, Pit Solution Pvt Ltd
 *  Abin Sabu <abin.sabu@pitsolutions.com>, PIT Solution Pvt Ltd
 *  Akhil Jayan <akhil.jn@pitsolutions.com>, PIT Solution Pvt Ltd
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
class LayersliderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * action list
     *
     * @return void
     */
    public function listAction() {
        $baseurl = $GLOBALS['TSFE']->tmpl->setup['config.']['baseURL'];
        $globalSettingArr = $this->settings;
        $this->cObj = $this->configurationManager->getContentObject();
        $recordPid = $this->cObj->data['pages'];
        $select_fields = '*';
        $from_table = 'tx_pitslayerslider_domain_model_layerslider';
        $extendedWhere = (!empty($globalSettingArr['teaser']) ) ? ' AND uid IN (' . $globalSettingArr['teaser'] . ')' : ' AND pid IN(' . $recordPid . ')';
        $where_clause = 'deleted = 0 AND hidden = 0' . $extendedWhere;
        $tabsRecords = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy = '', $orderBy = '', $limit = '', $uidIndexField = '');
        $i = 0;
        if ($this->settings['enablejquery'] == 1) {
            $this->response->addAdditionalHeaderData('<!-- layerslider --><script src="typo3conf/ext/pits_layerslider/Resources/Public/Js/jquery-1.9.1.js" type="text/javascript"></script><!-- layerslider -->');
        }
        if ($this->settings['enablejqueryui'] == 1) {
            $this->response->addAdditionalHeaderData('<!-- layerslider --><script src="typo3conf/ext/pits_layerslider/Resources/Public/Js/jquery-ui.js" type="text/javascript"></script><!-- layerslider -->');
        }
        if ($this->settings['enablejqueryeasing'] == 1) {
            $this->response->addAdditionalHeaderData('<!-- layerslider --><script src="typo3conf/ext/pits_layerslider/Resources/Public/layerslider/jQuery/jquery-easing-1.3.js" type="text/javascript"></script><!-- layerslider -->');
        }


        foreach ($tabsRecords as $pin => $value) {
            if (empty($value['transitions3d']) || empty($value['transitions2d'])) {
                $transition = true;
            } else {
                $transition = false;
            }
            $style = '';
            if ($value['slidedelay'] != '') {
                $style .= "slidedelay: " . $value['slidedelay'] . ";";
            }
            if ($value['slidedirection'] != '' && $transition) {
                $style .= "slidedirection: " . $value['slidedirection'] . ";";
            }
            if ($value['durationin'] != '' && $transition) {
                $style .= "durationin: " . $value['durationin'] . ";";
            }
            if ($value['easingin'] != '' && $transition) {
                $style .= "easingin: " . $value['easingin'] . ";";
            }
            if ($value['delayin'] != '' && $transition) {
                $style .= "delayin: " . $value['delayin'] . ";";
            }
            if ($value['durationout'] != '' && $transition) {
                $style .= "durationout: " . $value['durationout'] . ";";
            }
            if ($value['easingout'] != '' && $transition) {
                $style .= "easingout: " . $value['easingout'] . ";";
            }
            if ($value['delayout'] != '' && $transition) {
                $style .= "delayout: " . $value['delayout'] . ";";
            }

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

            $tags = array("span", "h1", "h2", "h3", "h4", "h5", "h6", "p", "div");
            foreach ($layerRecords as $key => $records) {
                if (sizeof(sizeof($layerRecords)) == ($key + 1)) {
                    $i = 0;
                }
                $records['is_htmltag'] = FALSE;
                if (in_array(strtolower($records['layer_style']), $tags) && empty($records['layer_image'])) {
                    $records['is_htmltag'] = TRUE;
                }
                /* top: {layers.layer_top}px;
                  left: {layers.layer_left}px;slidedirection : {layers.layer_slidein_dir};
                  slideoutdirection : {layers.layer_slideout_dir};
                  easingin : {layers.layer_easingin};
                  easingout : {layers.layer_easingout};
                  durationin : {layers.layer_slidein_duration};
                  durationout : {layers.layer_slideout_duration};
                  delayin :{layers.layer_delay_in};
                  scalein : 0;showuntil:{layers.layer_units};
                  rotatein: 180;
                  rotateout: -90; */
                $records['layer_style'] = $records['layer_style'] == '' ? 'div' : $records['layer_style'];
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
                $innerStyle .= 'white-space:nowrap;';

                $layerRecords[$key]['innerStyle'] = $innerStyle;
                $finalArr [$value['uid']]['child'][$i] = $records;
                $finalArr [$value['uid']]['child'][$i]['innerStyle'] = $innerStyle;
                $i++;
            }
        }


        $globalSettingArr['jsOptions'] = $this->prepareGlobalOptions($globalSettingArr);
        $this->view->assign("globalSetting", $globalSettingArr);
        $this->view->assign("tabInfo", $finalArr);
        $this->view->assign("baseurl", $baseurl);
    }

    /**
     * action show
     *
     * @param Tx_PitsLayerslider_Domain_Model_Layerslider $layerslider
     * @return void
     */
    public function showAction(Tx_PitsLayerslider_Domain_Model_Layerslider $layerslider) {
        $this->view->assign('layerslider', $layerslider);
    }

    /**
     * action show
     *
     * @param \PITS\PitsLayerslider\Domain\Model\Layerslider $layerslider
     * @return void
     */
    public function select(&$params, &$pObj) {
        $start = strpos($_REQUEST['returnUrl'], '?') + 4;
        $returnUrl = strchr($_REQUEST['returnUrl'], '&');
        // \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($_REQUEST);
        // die;
        /* if( !$returnUrl ){
          $end = strlen($_REQUEST['returnUrl']);
          }else{
          $end = strpos($_REQUEST['returnUrl'], '&');
          } */
        $end = (!$returnUrl ) ? strlen($_REQUEST['returnUrl']) : strpos($_REQUEST['returnUrl'], '&');
        substr($_REQUEST['returnUrl'], $start, $end);
        $ararty = array_keys($_REQUEST['edit']['tt_content']);
        $uid = $pid = str_replace(",", "", $ararty[0]);


        // $select_fields = 'pid';
        // $from_table = "tt_content";
        // $groupBy1 = 'pid';
        // $orderBy1 = NULL;
        // $where_clause = "uid = " . $uid;
        // $selectedStorageFolder = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields, $from_table, $where_clause, $groupBy1, $orderBy1);
        // $storageFolderId = $selectedStorageFolder[0]['pid'];
        $select_fields_2 = '*';
        $from_table_2 = 'tx_pitslayerslider_domain_model_layerslider';
        $where_clause_2 = 'deleted = 0 AND hidden = 0';
        // $where_clause_2 = 'deleted = 0 AND hidden = 0 AND pid IN ( ' . $storageFolderId . ' ) ';
        $groupBy_2 = NULL;
        $orderBy_2 = 'title';
        //$GLOBALS['TYPO3_DB']->store_lastBuiltQuery = 1;
        $sliderInformation = $GLOBALS['TYPO3_DB']->exec_SELECTgetRows($select_fields_2, $from_table_2, $where_clause_2, $groupBy_2, $orderBy_2);


        foreach ($sliderInformation as $value) {
            $params['items'][] = array($value['title'], $value['uid']);
        }
        //return $params;
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

    /**
     * action create
     *
     * @param Tx_PitsLayerslider_Domain_Model_Layerslider $newLayerslider
     * @return void
     */
    public function createAction(\PITS\PitsLayerslider\Domain\Model\Layerslider $newLayerslider) {
        $this->layersliderRepository->add($newLayerslider);
        $this->flashMessageContainer->add('Your new Layerslider was created.');
        $this->redirect('list');
    }

    public function prepareGlobalOptions($globalSettingArr) {


        $javaString = '';

        $javaString .= 'jQuery(document).ready(function(){jQuery("#layerslider").layerSlider({';

        $javaString .= (!empty($globalSettingArr["isResponsive"])) ? 'responsive : ' . $globalSettingArr["isResponsive"] . ',' : ''; //resposive
        $javaString .= (!empty($globalSettingArr["responsive_under"])) ? 'responsiveUnder : ' . $globalSettingArr["responsive_under"] . ',' : ''; //responsiveUnder
        $javaString .= (!empty($globalSettingArr["layer_container"])) ? 'sublayerContainer : ' . $globalSettingArr["layer_container"] . ',' : ''; //sublayerContainer
        $javaString .= (!empty($globalSettingArr["isTwoWaySlideShow"])) ? 'twoWaySlideshow : ' . $globalSettingArr["isTwoWaySlideShow"] . ',' : ''; //twoWaySlideshow

        $javaString .= (!empty($globalSettingArr["isRandomSlide"])) ? 'randomSlideshow : ' . $globalSettingArr["isRandomSlide"] . ',' : ''; //randomSlideshow
        $javaString .= (!empty($globalSettingArr["isImagePreloadEnable"])) ? 'imgPreload : ' . $globalSettingArr["isImagePreloadEnable"] . ',' : ''; //imgPreload
        $javaString .= (!empty($globalSettingArr["isPrevNextEnable"])) ? 'navPrevNext : ' . $globalSettingArr["isPrevNextEnable"] . ',' : ''; //navPrevNext
        $javaString .= (!empty($globalSettingArr["isStartStopEnable"])) ? 'navStartStop : ' . $globalSettingArr["isStartStopEnable"] . ',' : ''; //navStartStop

        $javaString .= (!empty($globalSettingArr["thumbnail_container_width"])) ? 'tnContainerWidth : "' . $globalSettingArr["thumbnail_container_width"] . '%",' : ''; //tnContainerWidth
        $javaString .= (!empty($globalSettingArr["tnActiveOpacity"])) ? 'tnActiveOpacity : ' . $globalSettingArr["tnActiveOpacity"] . ',' : ''; //tnActiveOpacity
        $javaString .= (!empty($globalSettingArr["thumbnail_inactive_opacity"])) ? 'tnInactiveOpacity : ' . $globalSettingArr["thumbnail_inactive_opacity"] . ',' : ''; //tnInactiveOpacity
        $javaString .= (!empty($globalSettingArr["isPrevNextOnHover"])) ? 'hoverPrevNext : ' . $globalSettingArr["isPrevNextOnHover"] . ',' : ''; //hoverPrevNext

        $javaString .= (!empty($globalSettingArr["isBottomNavOnHover"])) ? 'hoverBottomNav : ' . $globalSettingArr["isBottomNavOnHover"] . ',' : ''; //hoverBottomNav
        $javaString .= (!empty($globalSettingArr["select_skin"])) ? 'skin : "' . $globalSettingArr["select_skin"] . '",' : ''; //skin
        $javaString .= 'skinsPath : "typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/",'; //skinsPath
        $javaString .= (!empty($globalSettingArr["isPauseOnHover"])) ? 'pauseOnHover : ' . $globalSettingArr["isPauseOnHover"] . ',' : ''; //pauseOnHover

        $javaString .= (!empty($globalSettingArr["bgColor"])) ? 'globalBGColor : "' . $globalSettingArr["bgColor"] . '",' : ''; //globalBGColor
        $javaString .= (!empty($globalSettingArr["isAnimateFirstSlide"])) ? 'animateFirstLayer : ' . $globalSettingArr["isAnimateFirstSlide"] . ',' : ''; //animateFirstLayer
        $javaString .= (!empty($globalSettingArr["loops"])) ? 'loops : "' . $globalSettingArr["loops"] . '",' : ''; //loops
        $javaString .= (!empty($globalSettingArr["isForceLoop"])) ? 'forceLoopNum : ' . $globalSettingArr["isForceLoop"] . ',' : ''; //forceLoopNum

        $javaString .= (!empty($globalSettingArr["autoPlaySlideshowSelector"])) ? 'autoPauseSlideshow : "' . $globalSettingArr["autoPlaySlideshowSelector"] . '",' : ''; //autoPauseSlideshow
        $javaString .= (!empty($globalSettingArr["isBarTimerEnable"])) ? 'showBarTimer : "' . $globalSettingArr["isBarTimerEnable"] . '",' : ''; //showBarTimer
        $javaString .= (!empty($globalSettingArr["isCircleTimerEnable"])) ? 'showCircleTimer : ' . $globalSettingArr["isCircleTimerEnable"] . ',' : ''; //showCircleTimer

        /* $jScript = 'responsive          : ' . $globalSettingArr["isResponsive"] . ',
          responsiveUnder         : ' . $globalSettingArr["responsive_under"] . ',
          sublayerContainer       : ' . $globalSettingArr["layer_container"] . ',
          twoWaySlideshow         : ' . $globalSettingArr["isTwoWaySlideShow"] . ',
          randomSlideshow         : ' . $globalSettingArr["isRandomSlide"] . ',
          imgPreload              : ' . $globalSettingArr["isImagePreloadEnable"] . ',
          navPrevNext             : ' . $globalSettingArr["isPrevNextEnable"] . ',
          navStartStop            : ' . $globalSettingArr["isStartStopEnable"] . ',
          navButtons              : ' . $globalSettingArr["isNavButtonsEnable"] . ',
          thumbnailNavigation     : "' . $globalSettingArr["thumbil_navigation"] . '",
          tnWidth                 : ' . $globalSettingArr["thumbnail_width"] . ',
          tnHeight                : ' . $globalSettingArr["thumbnail_height"] . ',
          tnContainerWidth        : "' . $globalSettingArr["thumbnail_container_width"] . '%",
          tnActiveOpacity         : ' . $globalSettingArr["thumbnail_opacity"] . ',
          tnInactiveOpacity       : ' . $globalSettingArr["thumbnail_inactive_opacity"] . ',
          hoverPrevNext           : ' . $globalSettingArr["isPrevNextOnHover"] . ',
          hoverBottomNav          : ' . $globalSettingArr["isBottomNavOnHover"] . ',
          skin                    : "' . $globalSettingArr["select_skin"] . '",
          skinsPath               : "typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/",
          pauseOnHover            : ' . $globalSettingArr["isPauseOnHover"] . ',
          globalBGColor           : "' . $globalSettingArr["bgColor"] . '",
          animateFirstLayer       : ' . $globalSettingArr["isAnimateFirstSlide"] . ',
          loops                   : ' . $globalSettingArr["loops"] . '",
          forceLoopNum            : ' . $globalSettingArr["isForceLoop"] . ',
          autoPauseSlideshow      : "' . $globalSettingArr["autoPlaySlideshowSelector"] . '",
          showBarTimer            : ' . $globalSettingArr["isBarTimerEnable"] . ',
          showCircleTimer         : ' . $globalSettingArr["isCircleTimerEnable"] . ',
          });
          });';
         */
        $javaString .=' });});';
        return $javaString;
    }

}
