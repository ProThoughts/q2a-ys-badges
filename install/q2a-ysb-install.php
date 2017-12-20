<?php
// don't allow this page to be requested directly from browser
if (!defined('QA_VERSION')) {
    header('Location: ../../');
    exit;
}

class q2a_ysb_install
{

    // 生成するテーブル。qa_ysb_のプレフィックスは抜き
    private $table_names = array('badges', 'badge_master');

    /**
     * create table function of framework
     * @param  [type] $tableslc []
     * @return array  array of table creattion sqls
     */
    function init_queries($tableslc)
    {
        $queries = array();

        foreach($this->table_names as $table_name) {
            if (!in_array(qa_db_add_table_prefix('ysb_' . $table_name), $tableslc)) {
                    $queries[] = file_get_contents(YSB_DIR . '/sql/qa_ysb_create_' . $table_name . '_table.sql');
                }
        }

        if (count($queries) > 0) {
            return $queries;
        }

        return null;
    }

    function process_event($event, $post_userid, $post_handle, $cookieid, $params)
    {
        // do nothing
    }
}
