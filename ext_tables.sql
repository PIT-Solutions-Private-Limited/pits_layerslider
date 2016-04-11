#
# Table structure for table 'tx_pitslayerslider_domain_model_layerslider'
#
CREATE TABLE tx_pitslayerslider_domain_model_layerslider (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(100) DEFAULT '' NOT NULL,
	tab_id int(11) DEFAULT '0' NOT NULL,
	background varchar(255) DEFAULT '' NOT NULL,
        thumbnail varchar(255) DEFAULT '' NOT NULL,
        slidedelay int(11) unsigned DEFAULT '0' NOT NULL,
        slidedirection varchar(255) DEFAULT '' NOT NULL,
        durationin int(11) unsigned DEFAULT '0' NOT NULL,
        easingin  varchar(255) DEFAULT '' NOT NULL,
        delayin  int(11) unsigned DEFAULT '0' NOT NULL,
        durationout  int(11) unsigned DEFAULT '0' NOT NULL,
        easingout  varchar(255) DEFAULT '' NOT NULL,
        delayout int(11) unsigned DEFAULT '0' NOT NULL,
        layer_link  varchar(255) DEFAULT '' NOT NULL,
        layer_link_target varchar(255) DEFAULT '' NOT NULL,
	transitions2d varchar(255) DEFAULT '' NOT NULL,
	transitions3d varchar(255) DEFAULT '' NOT NULL,
	enabletransition int(11) DEFAULT '0' NOT NULL,

        tab_order  int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_pitslayerslider_domain_model_sublayers'
#
CREATE TABLE tx_pitslayerslider_domain_model_sublayers (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	layer_text varchar(255) DEFAULT '' NOT NULL,
	layer_style varchar(15) DEFAULT '' NOT NULL,
	layer_url varchar(255) DEFAULT '' NOT NULL,
	layer_link_control varchar(15) DEFAULT '' NOT NULL,
	layer_image text,
	layer_title varchar(255) DEFAULT '' NOT NULL,
	layer_image_alt  varchar(255) DEFAULT '' NOT NULL,
	layer_custom varchar(255) DEFAULT '' NOT NULL,
	layer_top int(11) DEFAULT '0' NOT NULL,
	layer_left int(11) DEFAULT '0' NOT NULL,
	layer_custom_style text,
	layer_slidein_dir varchar(255) DEFAULT '' NOT NULL,
	layer_easingin varchar(255) DEFAULT '' NOT NULL,
	layer_easingout varchar(255) DEFAULT '' NOT NULL, 
	layer_slideout_dir varchar(255) DEFAULT '' NOT NULL,
	layer_slider_other_options varchar(255) DEFAULT '' NOT NULL,
	layer_slidein_duration int(11) DEFAULT '0' NOT NULL,
	layer_delay_in int(11) DEFAULT '0' NOT NULL,
	layer_delay_out int(11) DEFAULT '0' NOT NULL,
	layer_slideout_duration int(11) DEFAULT '0' NOT NULL,
	layer_units int(11) DEFAULT '0' NOT NULL,
	layer_background int(11) DEFAULT '0' NOT NULL,
	parenttab_id int(11) DEFAULT '0' NOT NULL,
        layer_order  int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);



#
# Table structure for table 'tx_pitslayerslider_domain_model_pitslayerslider'
#
CREATE TABLE tx_pitslayerslider_domain_model_pitslayerslider (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);
