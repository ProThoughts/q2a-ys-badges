<?php

require_once YSB_DIR.'/qa-ysb-badge.php';
require_once YSB_DIR.'/util/qa-ysb-html-builder.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    public function main_parts($content)
    {
        if($this->template == 'user-badge'){
            $badges = $content['badges'];
            qa_ysb_html_builder::output_user_badge($badges);
        } else {
            parent::main_parts($content);
        }
    }

    public function notices()
    {
        if (qa_is_logged_in()) {
            $badges = qa_ysb_badge::find_by_not_noticed_badges(qa_get_logged_in_userid());
            $badgeids = array_column($badges, 'badgeid');
            if(count($badgeids) > 0) {
                qa_ysb_html_builder::output_badge_dialog($badgeids);
                $this->update_badges_flag($badgeids);
            }
        }
        parent::notices();
    }

    /*
     * バッジのshow_flag を 1 にする(ダイアログ表示済み)
     */
    private function update_badges_flag($badgeids)
    {
        $userid = qa_get_logged_in_userid();
        foreach($badgeids as $id) {
            $badge = new qa_ysb_badge($id);
            $badge->set_show_flag(1);
            $badge->update_badge($userid);
            $badge = null;
        }
    }
}
