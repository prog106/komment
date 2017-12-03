<?php
/**
 * @ description : Search dao
 * @ author : prog106 <prog106@gmail.com>
 */
class Searchdao extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    // 가져오기
    public function get_search_from_hashtag($search, $paging, $limit) { // {{{
        $sql = "(SELECT 'answer' as tps, que_srl, mem_name, mem_level, mem_picture, answer as question, likes, hashtag, match(hashtag) against('".$search."' IN BOOLEAN MODE) score, create_at, 'null' as end_time, '0' as respond
                    FROM answer
                    WHERE (match(hashtag) against('*".$search."*' IN BOOLEAN MODE) or match(hashtag) against('".$search."*' IN BOOLEAN MODE)) AND status = 'use')
                UNION
                (SELECT 'question' as tps, que_srl, mem_name, mem_level, mem_picture, question, likes, hashtag, match(hashtag) against('".$search."' IN BOOLEAN MODE) score, create_at, end_time, respond
                    FROM question
                    WHERE (match(hashtag) against('*".$search."*' IN BOOLEAN MODE) or match(hashtag) against('".$search."*' IN BOOLEAN MODE)) AND status = 'use')
                ORDER BY score DESC, end_time ASC LIMIT ".$paging.", ".$limit;
        $result = $this->db->query($sql);
        return $result->result_array();
    } // }}}

}
