<?php
/*
    Plugin Name: Badge
    Plugin URI: https://github.com/yshiga/q2a-ys-badges
    Plugin Description: provide simple badge functions
    Plugin Version: 1.0.0
    Plugin Date: 2017-8-9
    Plugin Author: yshiga
    Plugin Author URI: https://38qa.net/
    Plugin License: GPLv2
    Plugin Minimum Question2Answer Version: 1.5
    Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

@define( 'YSB_DIR', dirname( __FILE__ ) );
@define( 'YSB_FOLDER', basename( dirname( __FILE__ ) ) );
@define( 'YSB_TARGET_THEME_NAME', 'q2a-material-lite');
@define( 'YSB_RELATIVE_PATH', '../qa-plugin/'.YSB_FOLDER.'/');

qa_register_plugin_module('event', 'install/q2a-ysb-install.php', 'q2a_ysb_install', 'YSB Install');
qa_register_plugin_module('event', 'event/q2a-ysb-event.php', 'q2a_ysb_event', 'YSB Event');

qa_register_plugin_layer('layer/q2a-ysb-layer.php','YSB layer');

qa_register_plugin_phrases('lang/q2a-ysb-lang-*.php', 'ysb');

qa_register_plugin_overrides('qa-ysb-overrides.php');