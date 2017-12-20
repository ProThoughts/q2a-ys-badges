<?php
    if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
        header('Location: ../');
        exit;
    }

    require_once YSB_DIR . '/qa-ysb-badge.php';
    require_once YSB_DIR . '/qa-ysb-badge-master.php';

    $handle = qa_request_part(1);
    $userid = qa_handle_to_userid($handle);

    $badges = qa_ysb_badge::find_by_userid($userid);


    qa_set_template('user-badge');
    $qa_content = qa_content_prepare(true);
    $qa_content['title'] = qa_lang('ysb/page_title');
    $qa_content['badges'] = array_column($badges, 'hasbadge', 'badgeid');

    return $qa_content;