<?php
if (!defined('QA_VERSION')) {
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../../qa-include/qa-base.php';
}

require_once YSB_DIR . '/qa-ysb-badge-master.php';

echo 'badge master init start...'.PHP_EOL;
try {
$tmp = new qa_ysb_badge_master();
$tmp->renew();
} catch (Exception $e) {
	echo 'An error occurred.'.PHP_EOL;
	echo $e->getMessage();
	exit;
}
echo 'badge master init done!'.PHP_EOL;
