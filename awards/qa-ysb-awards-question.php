<?php

/**
 * 質問系のバッジ付与のベースクラス
 */
abstract class qa_ysb_awards_question_base extends qa_ysb_awards_base
{

    public function get_award_target($event, $post_userid, $params)
    {
        if($event == 'q_post' && $this->check_award_badge($post_userid, $params)){
            return array($post_userid);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        return true;
    }
}

/*
 * 質問者
 * 質問を投稿する
 */
class qa_ysb_awards_questioner extends qa_ysb_awards_question_base
{
    public function get_badgeid()
    {
        return 201;
    }

}

/*
 * 人気の質問
 * 質問にいいね！が3つ以上つく
 */
class qa_ysb_awards_good_question extends qa_ysb_awards_question_base
{
    const UPVOTE_THRESHOLD = 3;

    public function get_badgeid()
    {
        return 202;
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if ($event == 'q_vote_up' && $this->check_award_badge($post_userid, $params)) {
            return array($params['userid']);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        $sql = 'SELECT count(*)';
        $sql .= ' FROM ^posts WHERE upvotes >= #';
        $sql .= ' AND type="Q" AND postid = #';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::UPVOTE_THRESHOLD, $params['postid']));

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 回答多数
 * 回答が5件以上寄せられる
 */
class qa_ysb_awards_with_many_answer extends qa_ysb_awards_question_base
{
    const ANSWER_THRESHOLD = 5;

    public function get_badgeid()
    {
        return 203;
    }

    public function get_award_target($event, $post_userid, $params)
    {
        if ($event == 'a_post' && $this->check_award_badge($post_userid, $params)) {
            return array($params['parent']['userid']);
        }
        return array();
    }

    public function check_award_badge($userid, $params)
    {
        $sql = 'SELECT count(*)';
        $sql .= ' FROM ^posts WHERE acount >= #';
        $sql .= ' AND type="Q" AND postid = #';
        $count = qa_db_read_one_value(qa_db_query_sub($sql, self::ANSWER_THRESHOLD, $params['parent']['postid']));

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 詳しい質問
 * 500文字以上の質問を投稿する
 */
class qa_ysb_awards_detail_question extends qa_ysb_awards_question_base
{
    const CHAR_LENGTH_THRESHOLD = 500;

    public function get_badgeid()
    {
        return 204;
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
 * 画像付き質問
 * 画像付きの質問を投稿する
 */
class qa_ysb_awards_question_with_image extends qa_ysb_awards_question_base
{
    public function get_badgeid()
    {
        return 205;
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
 * 動画付き質問
 * 動画付きの質問を投稿する
 */
class qa_ysb_awards_question_with_video extends qa_ysb_awards_question_base
{
    public function get_badgeid()
    {
        return 206;
    }

    public function check_award_badge($userid, $params)
    {
        $content = $params['content'];
        $regex = "/\[uploaded-video=\"?[^\"\]]+\"?\]/isU";
        if(preg_match($regex, $content, $matches)) {
            return true;
        } else {
            return false;
        }
    }
}

/*
 * 好奇心旺盛
 * 3件質問する
 */
class qa_ysb_awards_full_of_curiosity extends qa_ysb_awards_question_base
{
    const QUESTION_COUNT = 3;

    public function get_badgeid()
    {
        return 207;
    }

    public function check_award_badge($userid, $params)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='Q'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::QUESTION_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}

/*
 * 勉強熱心
 * 10件質問する
 */
class qa_ysb_awards_hardworking extends qa_ysb_awards_question_base
{
    const QUESTION_COUNT = 10;

    public function get_badgeid()
    {
        return 208;
    }

    public function check_award_badge($userid, $params)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='Q'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::QUESTION_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}

/*
 * 質問の達人
 * 30件質問する
 */
class qa_ysb_awards_question_master extends qa_ysb_awards_question_base
{
    const QUESTION_COUNT = 30;

    public function get_badgeid()
    {
        return 209;
    }

    public function check_award_badge($userid, $params)
    {
        $sql = "SELECT count(*)";
        $sql.= " FROM ^posts";
        $sql.= " WHERE type='Q'";
        $sql.= " AND userid=#";

        $count = qa_db_read_one_value(qa_db_query_sub($sql, $userid));
        if ($count >= self::QUESTION_COUNT) {
            return true;
        } else {
            return false;
        }

    }
}