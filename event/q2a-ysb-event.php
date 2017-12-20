<?php

require_once YSB_DIR . '/qa-ysb-badge.php';
require_once YSB_DIR . '/qa-ysb-badge-master.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-base.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-answer.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-question.php';
require_once YSB_DIR . '/awards/qa-ysb-awards-blog.php';

class q2a_ysb_event {

    function process_event($event, $post_userid, $post_handle, $cookieid, $params) {

        $bm = new qa_ysb_badge_master();
        $awards = $bm->find_badge_name_by_event($event);

        foreach($awards as $name){
            $classname = 'qa_ysb_awards_' . $name;
            $awardsclass = new $classname();

            $awardsclass->awards_by_event($event, $post_userid, $params);
        }
    }
}
