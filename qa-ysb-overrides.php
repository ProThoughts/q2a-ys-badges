<?php

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
	header('Location: ../../');
	exit;
}

function qa_page_routing()
{
    $routing = qa_page_routing_base();
    if (qa_opt('site_theme') === YSB_TARGET_THEME_NAME) {
        $part = qa_request_part(2);
        switch ($part) {
            case 'badge':
                $routing['user/'] = YSB_RELATIVE_PATH . 'page/user-badge.php';
        }
    }
    return $routing;
}
