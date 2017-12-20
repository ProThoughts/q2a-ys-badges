<?php

class qa_ysb_html_builder {
    const IMAGE_BASE = 'qa-plugin/q2a-ys-badges/img/';

    /*
     * ユーザーバッジ一覧出力
     */
    public static function output_user_badge($badges)
    {
        $imgurl = qa_opt('site_url').self::IMAGE_BASE.'badge_';
        $imgclass = 'no-badge-icon';
        $txtclass = 'mdl-typography--body-1';
        $txtclass2 = 'mdl-typography--body-1-color-contrast mdl-color-text--grey';
        $headclass = 'mdl-typography--display-1-color-contrast';
        include YSB_DIR . '/html/user-badge.html';
    }

    /*
     * バッジのダイアログ出力
     */
    public static function output_badge_dialog($badgeids)
    {
        $url = qa_opt('site_url').self::IMAGE_BASE;
        $handle = qa_get_logged_in_handle();
        $badgesurl = qa_path('user/'.$handle.'/badge',null,qa_opt('site_url'));
        $badgeobj = self::get_badges($badgeids);
        include YSB_DIR . '/html/badge-dialog.html';
    }

    /*
     * バッジ情報取得
     */
    private static function get_badges($ids)
    {
        $handle = qa_get_logged_in_handle();
        $badges = array();
        foreach($ids as $id) {
            $msgid = self::get_msgid($id);
            $badges[] = array(
                'id' => $id,
                'title' => qa_lang_sub('ysb/badge_title', qa_lang('ysb/badge_head_'.$id)),
                'img' => qa_opt('site_url').self::IMAGE_BASE.'badge_'.$id.'.svg',
                'msg' => qa_lang_sub($msgid, $handle)
            );
        }
        return $badges;
    }

    /*
     * ダイアログのメッセージID取得
     */
    private static function get_msgid($id)
    {
        $msgid = '';
        switch (substr($id,0,1)) {
            case '1':
                $msgid = 'ysb/badge_dialog_msg_answer';
                break;
            case '2':
                $msgid = 'ysb/badge_dialog_msg_question';
                break;
            case '3':
                $msgid = 'ysb/badge_dialog_msg_blog';
                break;
        }
        return $msgid;
    }
}
