<?php

/**
 * 回答系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_answer_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params) {
        if($event == 'a_post' && $this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params){
        return true;
    }
}

/*
 * 人気の回答
 * 回答にいいね！が３つ以上つく
 */
class qa_ysb_awards_good_answer extends qa_ysb_awards_answer_base {

    const UPVOTE_THRESHOLD = 3;

    public function get_badgeid()
    {
        return 102;
    }

    public function check_award_badge($userid, $params)
    {
        $sql = 'SELECT count(*) ';
        $sql .= 'FROM ^posts WHERE upvotes >= #';
        $sql .= ' AND type="A" AND postid=#';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $params['postid']));
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if($event == 'a_vote_up' && $this->check_award_badge($post_userid, $params)){
            return array($params['userid']);
        }
        return array();
    }
}

/*
 * 回答者
 * 回答を投稿する
 */
class qa_ysb_awards_answer extends qa_ysb_awards_answer_base
{
    public function get_badgeid(){
        return 101;
    }

}

/*
 * 即当者
 * 15分以内に回答する
 */
class qa_ysb_awards_quick_answer extends qa_ysb_awards_answer_base
{

    const MIN_THRESHOLD = 15;

    public function get_badgeid()
    {
        return 103;
    }

    public function check_award_badge($userid, $params)
    {
        $before15min = new DateTime('-15 min');
        
        return (int)$before15min->format('U') < (int)$params['parent']['created'];
    }
}

/*
 * 救世主
 * 1日以上回答がない質問に回答する
 */
class qa_ysb_awards_savior extends qa_ysb_awards_answer_base
{

    public function get_badgeid()
    {
        return 104;
    }

    public function check_award_badge($userid, $params)
    {
        $before24hour = new DateTime('-24 hour');
        $acount = $params['parent']['acount'];
        $created = $params['parent']['created'];
        if ($acount < 1 
            && (int)$created <= (int)$before24hour->format('U')) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 詳しい回答
 * 500文字以上の回答を投稿する
 */
class qa_ysb_awards_detail_answer extends qa_ysb_awards_answer_base
{

    const CHAR_LENGTH_THRESHOLD = 500;

    public function get_badgeid()
    {
        return 105;
    }

    public function check_award_badge($userid, $params)
    {
        $content = strip_tags($params['content']);
        if (mb_strlen($content, "UTF-8") >= self::CHAR_LENGTH_THRESHOLD) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 画像付き回答
 * 画像付きの回答を投稿する
 */
class qa_ysb_awards_answer_with_image extends qa_ysb_awards_answer_base
{
    public function get_badgeid()
    {
        return 106;
    }

    public function check_award_badge($userid, $params)
    {
        $content = $params['content'];
        $regex = "/\[image=\"?[^\"\]]+\"?\]/isU";
        if(preg_match($regex, $content, $matches)) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 親切
 * 5件回答する
 */
class qa_ysb_awards_kind extends qa_ysb_awards_answer_base
{
    const ANSWER_COUNT = 5;

    public function get_badgeid()
    {
        return 107;
    }

    public function check_award_badge($userid, $params)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='A'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::ANSWER_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}

/*
 * 人助け
 * 15件回答する
 */
class qa_ysb_awards_help_others extends qa_ysb_awards_answer_base
{
    const ANSWER_COUNT = 15;

    public function get_badgeid()
    {
        return 108;
    }

    public function check_award_badge($userid, $params = null)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='A'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::ANSWER_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}

/*
 * ヒーロー
 * 50件回答する
 */
class qa_ysb_awards_hero extends qa_ysb_awards_answer_base
{
    const ANSWER_COUNT = 50;

    public function get_badgeid()
    {
        return 109;
    }

    public function check_award_badge($userid, $params = null)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='A'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::ANSWER_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}