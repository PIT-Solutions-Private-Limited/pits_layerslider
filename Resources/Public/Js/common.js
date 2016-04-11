var myMask = new Ext.LoadMask(Ext.getBody(), {msg: "Please wait..."});
var baseUrl = location.href.substr(0, location.href.lastIndexOf("/") + 1);
var pageid;
var transitionId = '';
var selectedId = '';
var transitionGallery;

jQuery(document).ready(function () {

    jQuery(".ls-reset ").click(function () {
        jQuery(this).parent().find('input').val('');
    });
    // Transition selection window on colorbox
    jQuery(".colorbox-link").colorbox({
        inline: true,
        width: "75%",
        onOpen: function ( ) {
            selectedId = jQuery(this).attr("id").split("_");
            transitionId = selectedId[1];
            transitionGallery.init();
        }
    });

    // Transition On/Off
    jQuery(".ls-checkbox").click(function () {
        var enableTransitionId = '#enabletransition-' + jQuery(this).attr("id").split("-")[2];
        var enableTransitionButtonId = '#transistion_' + jQuery(this).attr("id").split("-")[2];

        var checkboxId = '#ls-checkbox-' + jQuery(this).attr("id").split("-")[2];
        var slideinId = '#ls-slidein-' + jQuery(this).attr("id").split("-")[2];
        var slideoutId = '#ls-slideout-' + jQuery(this).attr("id").split("-")[2];
        var transitionid = '#transition-' + jQuery(this).attr("id").split("-")[2];
        var transitionid_1 = '#transistion_' + jQuery(this).attr("id").split("-")[2];
        if (jQuery(this).hasClass('off')) {
            jQuery(enableTransitionId).val(1);
            jQuery(checkboxId).removeClass('off').addClass('on');
            jQuery(slideinId).fadeOut();
            jQuery(slideoutId).fadeOut();
            jQuery(transitionid).fadeIn();
            console.log(jQuery(transitionid_1));
            jQuery(transitionid_1).removeClass('enabletransition-inactive');
        } else {
            jQuery(enableTransitionId).val(0);
            jQuery(checkboxId).removeClass('on').addClass('off');
            jQuery(slideinId).fadeIn();
            jQuery(slideoutId).fadeIn();
            jQuery(transitionid).fadeOut();
        }
    });



    pageId = jQuery("#pageid").val();
    jQuery(".draggable").draggable({
        scroll: false,
        drag: function () {
        }
    });

    //Tabs
    var tabs = jQuery(".tabs").tabs({
        activate: function (event, ui) {
            var tabHref = ui.newTab.find("a").attr("href").split("-");
            var tab_id = tabHref[1];
            var url = jQuery("#uri-getdata").val();
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({
                        'tab_id': tab_id
                    })
                },
                success: function (html) {
                    jQuery("#layerslider").empty();
                    jQuery("#layerslider").html(html);


                    jQuery('#layerslider').layerSlider({
                        skin: 'preview',
                        autoStart: false,
                        responsive: false,
                        skinsPath: '../typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/',
                        thumbnailNavigation: 'hover',
                        hoverPrevNext: false,
                        autoPlayVideos: false,
                        navPrevNext: true,
                        navStartStop: true,
                        navButtons: true
                    });
                    myMask.hide();
                    doDraggableAction();
                    myMask.hide();
                }
            });
        }
    });

    jQuery(".duplicate").click(function () {
        myMask.show();
        var tab_id = jQuery(this).attr("id").split("-")[1];
        var url = jQuery("#duplicateslider-url").val();
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({'tab_id': tab_id})
            },
            success: function (html) {
                myMask.hide();
                window.location.reload(true);
            }
        });
    });

    var activeTabIdx = jQuery('.tabs').tabs('option', 'active');
    var tabs_inner = jQuery(".tabs_inner").tabs({active: 1});

    //Select the active tab for Ui tabs
    jQuery(".slider_tab > li").each(function (index, value) {
        if (jQuery(this).hasClass("ui-state-active")) {
//            myMask.show();
            jQuery('#layersliderw').hide();
            var tabHref = jQuery(this).find("a").attr("href").split("-");
            var tab_id = tabHref[1];
//            var url = baseUrl + 'mod.php?M=web_PitsLayersliderPitslayerslider&id=' + pageId + '&tx_pitslayerslider_web_pitslayersliderpitslayerslider[action]=getdata';
            var url = jQuery("#uri-getdata").val();
            jQuery.ajax({
                url: url,
                type: "POST",
                data: {
                    tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({
                        'tab_id': tab_id
                    })
                },
                success: function (html) {
                    jQuery("#layerslider").html(html);
                    jQuery('#layerslider').show();
                    jQuery('#layerslider').layerSlider({
//                        skin: 'preview',
                        skin: 'defaultskin',
                        autoStart: false,
                        responsive: false,
                        skinsPath: '../typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/',
                        thumbnailNavigation: 'hover',
                        hoverPrevNext: false,
                        autoPlayVideos: false,
                        navPrevNext: true,
                        navStartStop: true,
                        navButtons: true,
                        cbInit: function (element) {
                            console.log(jQuery('#layerslider').layerSlider("stop"));
                        }
                    });
                    myMask.hide();
                    doDraggableAction();

                }
            });
        }
    });

    //Sortable tabs
    tabs.find(".ui-tabs-nav").sortable({
        axis: "x",
        stop: function () {
            tabs.tabs("refresh");
        }
    });
    //Form
    jQuery("#layer-slider").click(function () {
        myMask.show();
        var url =jQuery("#uri-savetabdata").val();
//        var url = baseUrl + 'mod.php?M=web_PitsLayersliderPitslayerslider&id=' + pageId + '&tx_pitslayerslider_web_pitslayersliderpitslayerslider[action]=savetabdata';
        jQuery.ajax({
            url: url,
            type: "POST",
            data: jQuery('#layer_sliderform').serialize(),
            success: function (html) {
                myMask.hide();
            }
        });
    });

    jQuery("#add_tab").click(function () {
        var tabTitle = jQuery("#tab_title"),
                tabContent = jQuery("#tab_content"),
                tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close'  style='float: left;' role='presentation'>Remove Tab</span></li>",
                tabCounter = jQuery(".tabs ul li").size() + 1;
        if (jQuery('.tabs >ul >li').size() === 0) {
            var tabNumber = 1;
        } else {
            var tabNumber = jQuery('.tabs >ul >li').size();
            tabNumber = tabNumber + 1;
        }
        var label = tabTitle.val() || "Tab " + tabNumber,
                id = "tabs-" + tabNumber,
                li = jQuery(tabTemplate.replace(/#\{href\}/g, "#" + id).replace(/#\{label\}/g, label)),
                tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
        tabs.find(".slider_tab").append(li);
        var innerTabId = (jQuery("#tabs_inner_" + tabNumber).size() === 0) ? 1 : jQuery("#tabs_inner_" + tabNumber).size() + 1;
        var innerSlideCount = innerTabId;
        var newconetent = '';
        //newconetent = newconetent.replace(/\{slideId\}/g,tabNumber);  
        tabs.append("<div id='" + id + "' class = 'ui-tabs-panel ui-widget-content ui-corner-bottom' >" + newconetent + "</div>");
        tabs.tabs("refresh");
        jQuery(".tabs_inner").tabs({
            collapsible: true,
            active: 1
        });
        if (tabNumber === 1) {
            jQuery(".tabs").tabs({active: 0});
        } else {
            var active = jQuery('.tabs >ul >li').size();
            active = active - 1;
            jQuery(".tabs").tabs({active: active});
        }
        var url = jQuery("#add-tab-form").attr("action");
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({
                    'tab_id': tabNumber,
                    'tab_title': label
                })},
            success: function (html) {
                jQuery(".tabs_inner").tabs({active: 1});
                location.reload(true);
            }
        });
    });

    jQuery(document).on("click", '.sub_layer', function () {
        jQuery(this).hide();
        var button_id = jQuery(this).attr("id").split("_");
        var tab_id = button_id[2];
//        var url = baseUrl + 'mod.php?M=web_PitsLayersliderPitslayerslider&id=' + pageId + '&tx_pitslayerslider_web_pitslayersliderpitslayerslider[action]=addlayer';
        var url = jQuery("#new-addlayer-url").val();
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({
                    'tab_id': tab_id,
                    'title': 'Layer'
                })
            },
            success: function (html) {

                jQuery("#tabs-" + tab_id).append(html);
                jQuery(".tabs_inner").tabs({collapsible: true, active: 1});
            }
        });
        tabs.tabs("refresh");
        return false;
    });

    jQuery(".tabs_inner").tabs({collapsible: true, active: 1});

    jQuery(document).on("click", '#preview', function () {
        jQuery('#layersliderw').show();
        jQuery('.ls-bg').removeClass("background");
        jQuery('.ls-layer').removeClass("test");
        jQuery(this).hide();
        jQuery('#stop').show();
        jQuery('#layersliderw').layerSlider({});
    });

    jQuery(document).on("click", '#all_preview', function () {
        var activeTabIdx = jQuery('.tabs').tabs('option', 'active');
        var url = jQuery("#uri-allslider").val();
        var tab_id = '';
        jQuery(".slider_tab > li").each(function (index, value) {
            if (jQuery(this).hasClass("ui-state-active")) {
                myMask.show();
                var tabHref = jQuery(this).find("a").attr("href").split("-");
                tab_id = tabHref[1];
            }
        });
        jQuery.ajax({
            url: url,
            type: "POST",
            data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({'tab_id': tab_id})},
            success: function (html) {
                console.log(html);
                jQuery("#layerslider").empty();
                jQuery("#layersliderw").empty();
                jQuery("#layersliderw").html(html);
                jQuery('#layersliderw').layerSlider({
                    skin: 'preview',
                    responsive: false,
                    skinsPath: '../typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/',
                    thumbnailNavigation: 'hover',
                    hoverPrevNext: false,
                    autoPlayVideos: false,
                    navPrevNext: true,
                    navStartStop: true,
                    navButtons: true
                });
                jQuery('#layerslider').fadeOut();
                jQuery('#layersliderw').fadeIn();
                myMask.hide();
            }
        });

    });


    jQuery(document).on("keyup change", '.attributes', function () {
        var idRecord = jQuery(this).attr("id").split("_");
        if (idRecord[0] === "layertext" || idRecord[0] === "layercustomstyle" || idRecord[0] === 'htmltag') {
            var id = idRecord[1];
        }

        if (idRecord[0] === "layer" && (idRecord[1] === "custom" || idRecord[1] === "left" || idRecord[1] === "top")) {
            var id = idRecord[2];
        }

        var imageDomElement = "#child_layer_img_" + id + "_text";
        var isImageExists = jQuery(imageDomElement).val();

        var targetID = "#layer_" + id;
        var htmlTagObj = '#htmltag_' + id;

        var tag = jQuery(htmlTagObj).val();
        var value = jQuery('#layertext_' + id).val();
        var className = jQuery("#layer_custom_" + id).val();
        var style = "#layercustomstyle_" + id;
        var layerTop = "#layer_top_" + id;
        var layerLeft = "#layer_left_" + id;
        console.log(tag);
        var elementStyle = jQuery(style).val() + "top : " + jQuery(layerTop).val() + "px; Left : " + jQuery(layerLeft).val() + "px; position:absolute;white-space:nowrap;";
        if (isImageExists === '') {
            if (jQuery(targetID).length > 0) {
                jQuery(targetID).remove();
            }
            jQuery('<' + tag + '>', {id: "layer_" + id, class: 'draggable ' + className, text: value, style: elementStyle, }).appendTo("#ls-preview-content");
            doDraggableAction();
        } else {
            jQuery(targetID).attr("style", "");
            jQuery(targetID).attr("style", elementStyle);
        }
    });

    /*jQuery('').on("chnage" ,'', function(){
     var idRecord = jQuery(this).attr("id").split("_");
     alert(idRecord[0]);
     if( idRecord[0] == "layertext" ||  idRecord[0] == "layercustomstyle" ){
     var id = idRecord[1];
     }
     
     if( idRecord[0] == "layer" && (  idRecord[1] == "custom" || idRecord[1] == "left" || idRecord[1] == "top" ) ){
     var id = idRecord[2];
     }
     
     var imageDomElement = "#child_layer_img_"+id+"_text";
     var isImageExists = jQuery( imageDomElement ).val() ;
     
     var targetID = "#layer_"+id ;
     var htmlTagObj = '#htmltag_'+id;
     
     var tag = jQuery(htmlTagObj).val();
     var value = jQuery('#layertext_'+id).val();
     var className = jQuery("#layer_custom_"+id).val() ;
     var style = "#layercustomstyle_"+id ;
     var layerTop = "#layer_top_"+id ;
     var layerLeft = "#layer_left_"+id ;
     console.log(tag);
     var elementStyle = jQuery(style).val()+"top : "+ jQuery(layerTop).val() + "px; Left : "+ jQuery(layerLeft).val() +"px; position:absolute;";
     
     
     if ( isImageExists == '' ){
     
     if( jQuery(targetID).length > 0 ){
     jQuery(targetID).remove();
     }
     jQuery('<'+tag+'>', { id: "layer_"+id, class: 'draggable '+ className, text: value, style:elementStyle, }).appendTo("#ls-preview-content");
     doDraggableAction();
     }else{
     var elementStyle = jQuery(style).val()+"top : "+ jQuery(layerTop).val() + "px; Left : "+ jQuery(layerLeft).val() +"px; position:absolute;";
     alert(elementStyle);
     jQuery( targetID ).attr("style","");
     jQuery( targetID ).attr("style",elementStyle);
     }
     });*/

    jQuery(document).on("click", '#stop', function () {
        jQuery('#layersliderw').layerSlider('stop');
        jQuery('#preview').show();
        jQuery('#layersliderw').layerSlider("stop");
        jQuery('#layersliderw').fadeOut();
        jQuery("#layerslider").show();

        jQuery(".slider_tab > li").each(function (index, value) {
            if (jQuery(this).hasClass("ui-state-active")) {
//                myMask.show();
                var tabHref = jQuery(this).find("a").attr("href").split("-");
                var tab_id = tabHref[1];
                var url = jQuery("#uri-getdata").val();
                jQuery.ajax({
                    url: url,
                    type: "POST",
                    data: {tx_pitslayerslider_web_pitslayersliderpitslayerslider: ({
                            'tab_id': tab_id
                        })
                    },
                    success: function (html) {
                        myMask.hide();
                        jQuery('#layerslider').layerSlider({
                            skin: 'preview',
                            autoStart: false,
                            responsive: false,
                            skinsPath: '../typo3conf/ext/pits_layerslider/Resources/Public/layerslider/skins/',
                            thumbnailNavigation: 'hover',
                            hoverPrevNext: false,
                            autoPlayVideos: false,
                            navPrevNext: true,
                            navStartStop: true,
                            navButtons: true
                        });
                        jQuery("#layerslider").html(html);
                        doDraggableAction();
                    }
                });
            }
        });
    });
});


function rand() {
    return Math.random().toString(36).substr(2); // remove `0.`
}
;

function token() {
    return rand() + rand(); // to make it longer
}
;

