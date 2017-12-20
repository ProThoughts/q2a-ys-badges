<?php
class qa_ysb_badge_master
{
    const TABLE_NAME = '^ysb_badge_master';

    public static function find_all()
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        return qa_db_read_all_assoc(qa_db_query_sub($sql));
    }

    public function renew()
    {
        $badges = include( YSB_DIR . '/qa-ysb-badge-master-data.php');

        qa_db_query_sub('DELETE FROM ' . self::TABLE_NAME);
        $sql = 'INSERT INTO ' . self::TABLE_NAME;
        $sql .= ' (badgeid, name, event) VALUES (#, #, #);';
        foreach ($badges as $badge) {
            qa_db_query_sub(
                $sql,
                $badge['badgeid'],
                $badge['name'],
                $badge['event']
            );
        }
    }

    public function find_badge_name_by_event($event)
    {
        $sql = 'SELECT name FROM ' . self::TABLE_NAME;
        $sql .= " WHERE event like $";
        $sql .= " ORDER BY badgeid";
        return qa_db_read_all_values(qa_db_query_sub($sql, '%'.$event.'%'), true);
    }
}
