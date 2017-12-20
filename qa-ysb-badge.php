<?php

require_once YSB_DIR . '/qa-ysb-badge-master.php';

class qa_ysb_badge {

    const TABLE_NAME = '^ysb_badges';
    private $badgeid;
    private $show_flag;

    public function __construct($badgeid)
    {
        $this->badgeid = $badgeid;
        $this->show_flag = 0;
    }

    public function set_show_flag($value)
    {
        $this->show_flag = $value;
    }

    /**
    * userid でバッジの取得状況を取得する
    * @return [array] [badees]
    */
    public static function find_by_userid($userid)
    {
        $sql = 'SELECT bm.badgeid, CASE WHEN bd.userid IS NULL THEN 0 ELSE 1 END as hasbadge';
        $sql .= ' FROM  ^ysb_badge_master AS bm LEFT JOIN ^ysb_badges AS bd ON bm.badgeid = bd.badgeid ';
        $sql .= ' AND bd.userid = #';
        $sql .= ' ORDER BY badgeid';
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $userid));
    }

    /*
     * useridでまだダイアログを表示していないバッジを取得
     */
    public static function find_by_not_noticed_badges($userid)
    {
        $sql = 'SELECT bd.badgeid';
        $sql .= ' FROM  ^ysb_badges AS bd';
        $sql .= ' WHERE bd.userid = # AND bd.show_flag = 0';
        $sql .= ' ORDER BY badgeid';
        return qa_db_read_all_assoc(qa_db_query_sub($sql, $userid));
    }

    /**
     * ユーザーにバッチを与える
     *
     * @param [type] $userid [バッジを授与するユーザーID]
     */
    public function add_badge($userid)
    {
        qa_db_query_sub(
            'INSERT INTO ' . self::TABLE_NAME .
            ' ( badgeid, userid, show_flag, created, updated ) '.
            ' VALUES (#, #, #, NOW(), NOW())',
            $this->badgeid, $userid, $this->show_flag 
        );
        error_log('badge was added, badgeid:' . $this->badgeid . ', userid:' . $userid);
    }
    
    /*
     * バッジを持っているかチェック
     */
    public function has_badge($userid)
    {
        $sql = 'SELECT count(*) FROM ' . self::TABLE_NAME  . ' WHERE badgeid=# AND userid=#';
        $result = qa_db_read_one_value(qa_db_query_sub($sql, $this->badgeid, $userid), true);

        if($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * バッジのshow_flagを更新
     */
    public function update_badge($userid)
    {
        $sql = 'UPDATE '.self::TABLE_NAME;
        $sql .= ' SET show_flag = #, updated = NOW()';
        $sql .= ' WHERE badgeid = # AND userid = #';
        qa_db_query_sub($sql, $this->show_flag, $this->badgeid, $userid);
    }
}
