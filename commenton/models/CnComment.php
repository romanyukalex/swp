<?php

class CnComment
{
    /**
     * Обновить PID
     * @param $oldPid
     * @param $newPid
     * @return bool
     */
    public static function updatePid($oldPid, $newPid)
    {
        $mysqli = CnDb::getConnect();

        $file = file_get_contents(CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $newPid);
        preg_match("/<head>[\w\W]*<title>(.*)<\/title>[\w\W]*<\/head>/iu", $file, $matches);
        if (isset($matches[1]) && !empty($matches[1])) {
            $title = $matches[1];
        } else {
            $title = $newPid;
        }

        $mysqli->query("UPDATE " . CN_T_COMMENTS . " SET `" . CN_T_PID . "` = '$newPid', `".CN_T_PAGE_TITLE."` = '$title' WHERE " . CN_T_PID . " = '$oldPid'");
        $mysqli->query("UPDATE " . CN_T_ANSWER . " SET `" . CN_T_PID . "` = '$newPid', `".CN_T_PAGE_TITLE."` = '$title' WHERE " . CN_T_PID . " = '$oldPid'");

        return true;
    }

    /**
     * Получить последние комментарии
     * @param $limit
     * @param $type
     * @return array
     */
    public static function getLastComments($limit, $type)
    {
        $mysqli = CnDb::getConnect();

        if ($type === 'main') {
            $sql = $mysqli->query("SELECT * FROM `" . CN_T_COMMENTS . "` WHERE `" . CN_T_MODERATION . "` = 0 AND `" . CN_T_POSTED . "` = 1 AND `" . CN_T_TEXT . "` != '' ORDER BY `" . CN_T_DATE_PUBLISHED . "`  DESC LIMIT $limit");
        } else {
            $sql = $mysqli->query("
            (SELECT 
            `" . CN_T_ID . "`, 
            `" . CN_T_PARENT_ID . "`, 
            `" . CN_T_MCID . "`, 
            `" . CN_T_PID . "`, 
            `" . CN_T_PAGE_TITLE . "`, 
            `" . CN_T_UID . "`, 
            `" . CN_T_PUID . "`, 
            `" . CN_T_TEXT . "`, 
            `" . CN_T_ATTACH . "`, 
            `" . CN_T_QUOTE . "`, 
            `" . CN_T_NEW . "`, 
            `" . CN_T_POSTED . "`, 
            `" . CN_T_MODERATION . "`, 
            `" . CN_T_HYPE . "`, 
            `" . CN_T_COMPLAIN . "`, 
            `" . CN_T_DATE_PUBLISHED . "` 
            FROM `" . CN_T_ANSWER . "` WHERE `" . CN_T_MODERATION . "` = 0 AND `" . CN_T_POSTED . "` = 1 AND `" . CN_T_TEXT . "` != '' ORDER BY `" . CN_T_DATE_PUBLISHED . "` DESC LIMIT $limit)
                UNION ALL
            (SELECT 
            `" . CN_T_ID . "`, 
            NULL, 
            NULL, 
            `" . CN_T_PID . "`, 
            `" . CN_T_PAGE_TITLE . "`, 
            `" . CN_T_UID . "`, 
            NULL, 
            `" . CN_T_TEXT . "`, 
            `" . CN_T_ATTACH . "`, 
            NULL, 
            `" . CN_T_NEW . "`, 
            `" . CN_T_POSTED . "`, 
            `" . CN_T_MODERATION . "`, 
            `" . CN_T_HYPE . "`, 
            `" . CN_T_COMPLAIN . "`, 
            `" . CN_T_DATE_PUBLISHED . "` 
            FROM `" . CN_T_COMMENTS . "` WHERE `" . CN_T_MODERATION . "` = 0 AND `" . CN_T_POSTED . "` = 1 AND `" . CN_T_TEXT . "` != '' ORDER BY `" . CN_T_DATE_PUBLISHED . "`  DESC LIMIT $limit) ORDER BY `" . CN_T_DATE_PUBLISHED . "` DESC LIMIT $limit");
        }

        $data = array();
        while ($arr = $sql->fetch_assoc()) {
            $data['comments'][] = $arr;
            $data['users'][] = $arr[CN_T_UID];
        }

        return $data;
    }

    /**
     * Получить рейтинг
     * @param $listId (array)
     * @return array
     */
    public static function getRating($listId)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->prepare("SELECT * FROM " . CN_T_RATING . " WHERE " . CN_T_CID . " = ?");
        $data = array();
        if (!empty($listId)) {
            foreach ($listId as $val) {
                $sql->bind_param('s', $val);
                $sql->execute();
                if (function_exists('mysqli_stmt_get_result')) {
                    $get_result = $sql->get_result();
                    if ($get_result) {
                        while ($dataArr = $get_result->fetch_assoc()) {
                            $data[] = $dataArr;
                        }
                    }
                } else {
                    $get_result = CnGetResult::go($sql);
                    if ($get_result) {
                        while ($dataArr = array_shift($get_result)) {
                            $data[] = $dataArr;
                        }
                    }
                }
            }
        }
        $result = array();
        foreach ($data as $val) {
            if (!empty($val)) {
                $result[] = $val;
            }
        }

        return $result;
    }


    /**
     * Кол-во новых комментариев
     * @return int
     */
    public static function getCountNewComments()
    {
        $mysqli = CnDb::getConnect();

        $sqlMain = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_COMMENTS . " WHERE " . CN_T_NEW . " = 1 AND " . CN_T_UID . " != 0 AND " . CN_T_MODERATION . " = 0");
        $sqlAnswer = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_ANSWER . " WHERE " . CN_T_NEW . " = 1 AND " . CN_T_UID . " != 0 AND " . CN_T_MODERATION . " = 0");

        return $sqlMain->num_rows + $sqlAnswer->num_rows;
    }


    /**
     * Отметить все как прочитанное
     * @return bool
     */
    public static function readAllComments()
    {
        $mysqli = CnDb::getConnect();

        $mysqli->query("UPDATE " . CN_T_COMMENTS . " SET " . CN_T_NEW . " = 0 WHERE " . CN_T_NEW . " = 1");
        $mysqli->query("UPDATE " . CN_T_ANSWER . " SET " . CN_T_NEW . " = 0 WHERE " . CN_T_NEW . " = 1");

        return true;
    }


    /**
     * Отметить комментарий как прочитанный
     * @param $id (id комментария)
     * @param $type ('main' or 'answer')
     * @return bool
     */
    public static function readComment($id, $type)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'main') {
            $mysqli->query("UPDATE " . CN_T_COMMENTS . " SET " . CN_T_NEW . " = 0 WHERE " . CN_T_ID . " = $id");
        }
        if ($type == 'answer') {
            $mysqli->query("UPDATE " . CN_T_ANSWER . " SET " . CN_T_NEW . " = 0 WHERE " . CN_T_ID . " = $id");
        }

        return true;
    }


    /**
     * Получить страницы с комментариями
     * @param int $number
     * @return null
     */
    public static function getPages($number = 1)
    {
        $mysqli = CnDb::getConnect();
        $data = null;
        $offset = (CN_SET_LIMIT_PAGE_LIST * $number) - CN_SET_LIMIT_PAGE_LIST;
        $sqlMain = $mysqli->query("SELECT DISTINCT " . CN_T_PID . ", " . CN_T_PAGE_TITLE . " FROM " . CN_T_COMMENTS . " ORDER BY " . CN_T_PAGE_TITLE . " DESC LIMIT " . CN_SET_LIMIT_PAGE_LIST . " OFFSET $offset");
        while ($arr = $sqlMain->fetch_assoc()) {
            $data[$arr[CN_T_PID]] = $arr;
        }
        uasort($data, function ($a, $b) {
            if ($a[CN_T_PAGE_TITLE] === $b[CN_T_PAGE_TITLE])
                return 0;

            return $a[CN_T_PAGE_TITLE] > $b[CN_T_PAGE_TITLE] ? 1 : -1;
        });

        return $data;
    }

    /**
     * Получить кол-во страниц
     * @return mixed
     */
    public static function getPagesCount()
    {
        $mysqli = CnDb::getConnect();
        $sqlMain = $mysqli->query("SELECT COUNT(DISTINCT " . CN_T_PAGE_TITLE . ") as count FROM " . CN_T_COMMENTS);

        $data = $sqlMain->fetch_assoc();
        $count = $data['count'];

        return $count;
    }

    public static function getPageByFilter($pid)
    {
        $mysqli = CnDb::getConnect();
        $sqlMain = $mysqli->query("SELECT " . CN_T_PID . ", " . CN_T_PAGE_TITLE . " FROM " . CN_T_COMMENTS . " WHERE " . CN_T_PID . " = '$pid' LIMIT 1");
        $data = null;
        if ($sqlMain) {
            while ($arr = $sqlMain->fetch_assoc()) {
                $data[$arr[CN_T_PID]] = $arr;
            }
        }

        return $data;
    }

    /**
     * Количество главных комментариев
     * @param $uri
     * @return int
     */
    public static function getCountMain($uri)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_COMMENTS . " WHERE " . CN_T_PID . " = '$uri' AND " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 0");

        return $sql->num_rows;
    }

    /**
     * Количество ответов
     * @param $uri
     * @return int
     */
    public static function getCountAnswer($uri)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_ANSWER . " WHERE " . CN_T_PID . " = '$uri' AND " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 0");

        return $sql->num_rows;
    }


    /**
     * Количество комментариев на модерации
     * @return int
     */
    public static function getCountModeration()
    {
        $mysqli = CnDb::getConnect();

        $sqlMain = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_COMMENTS . " WHERE " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 1");
        $sqlAnswer = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_ANSWER . " WHERE " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 1");

        return $sqlMain->num_rows + $sqlAnswer->num_rows;
    }


    /**
     * Количество жалоб
     * @return int
     */
    public static function getCountComplaints()
    {
        $mysqli = CnDb::getConnect();

        $sqlMain = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_COMMENTS . " WHERE " . CN_T_POSTED . " = 1 AND " . CN_T_COMPLAIN . " != ''");
        $sqlAnswer = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_ANSWER . " WHERE " . CN_T_POSTED . " = 1 AND " . CN_T_COMPLAIN . " != ''");

        return $sqlMain->num_rows + $sqlAnswer->num_rows;
    }


    /**
     * Записать рейтинг
     * @param $id
     * @param $uid
     * @param $type
     * @param $hypeType
     * @return bool|mysqli_result|null
     */
    public static function writeRating($id, $uid, $type, $hypeType)
    {
        $mysqli = CnDb::getConnect();

        $writeSqlComment = null;

        if ($hypeType == 'like') $score = 1;
        elseif ($hypeType == 'dislike') $score = -1;
        else $score = 0;

        $rating = null;

        $getSqlRating = $mysqli->query("SELECT * FROM " . CN_T_RATING . " WHERE " . CN_T_CID . " = '$id' AND " . CN_T_UID . " = $uid  LIMIT 1");
        if ($getSqlRating) {
            $rating = $getSqlRating->fetch_assoc();
        }

        if ($rating) {
            $writeSqlRating = $mysqli->query("UPDATE " . CN_T_RATING . " SET " . CN_T_SCORE . " = $score WHERE " . CN_T_CID . " = '$id' AND " . CN_T_UID . " = $uid LIMIT 1");
        } else {
            $writeSqlRating = $mysqli->query("INSERT INTO " . CN_T_RATING . " (" . CN_T_CID . "," . CN_T_UID . "," . CN_T_SCORE . ") VALUES ('$id',$uid,$score)");
        }

        if ($writeSqlRating) {
            if ($type == 'main') $table = CN_T_COMMENTS;
            else $table = CN_T_ANSWER;

            $ratingScore = null;

            $getSqlRating = $mysqli->query("SELECT * FROM " . CN_T_RATING . " WHERE " . CN_T_CID . " = '$id'");
            if ($getSqlRating) {
                while ($arr = $getSqlRating->fetch_assoc()) {
                    $ratingScore += $arr[CN_T_SCORE];
                }

            }

            if ($ratingScore !== null) {
                $commentId = preg_replace('/.+-/', '', $id);
                $writeSqlComment = $mysqli->query("UPDATE $table SET " . CN_T_HYPE . " = $ratingScore WHERE " . CN_T_ID . " = $commentId  LIMIT 1");
            }
        }

        return $writeSqlComment;
    }

    /**
     * Одобрить комментарий
     * @param $id 'comment id'
     * @param $type 'main' or 'answer'
     * @return bool|mysqli_result
     */
    public static function approveModeration($id, $type)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'main') $table = CN_T_COMMENTS;
        else $table = CN_T_ANSWER;

        $sql = $mysqli->query("UPDATE $table SET " . CN_T_MODERATION . " = 0, " . CN_T_NEW . " = 0 WHERE " . CN_T_ID . " = $id LIMIT 1");

        return $sql;
    }

    /**
     * Общее кол-во комментариев по сотоянию (например: на модерации, в корзине и т.д.)
     * @param $type 'moderation' or 'trash' or 'complaints' or 'common' or 'page' or 'person' or 'new'
     * @param null $param 'if($type == person) uid' or 'if($type == page) pid'
     * @return int
     */
    public static function getCountByCondition($type, $param = null)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'new') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_NEW . " = 1 AND " . CN_T_UID . " != 0 AND " . CN_T_MODERATION . " = 0";
        } elseif ($type == 'moderation') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 1";
        } elseif ($type == 'trash') {
            $where = CN_T_POSTED . " = 0";
        } elseif ($type == 'complaints') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_COMPLAIN . " != ''";
        } elseif ($type == 'page' && isset($param)) {
            $where = CN_T_PID . " = '$param' AND " . CN_T_POSTED . " = 1";
        } elseif ($type == 'person' && isset($param)) {
            $where = CN_T_UID . " = '$param' AND " . CN_T_POSTED . " = 1";
        } else {
            $where = CN_T_POSTED . " = 1";
        }

        $sqlMain = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_COMMENTS . " WHERE $where");
        $sqlAnswer = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_ANSWER . " WHERE $where");

        return $sqlMain->num_rows + $sqlAnswer->num_rows;
    }

    /**
     * Получить комментарии по состоянию (например: на модерации, а корзине и т.д.)
     * @param $type 'moderation' or 'trash' or 'complaints' or 'common' or 'page' or 'person' or 'new'
     * @param null $param 'if($type == person) uid' or 'if($type == page) pid'
     * @return array|null
     */
    public static function getByCondition($type, $param = null)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'new') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_NEW . " = 1 AND " . CN_T_UID . " != 0 AND " . CN_T_MODERATION . " = 0";
        } elseif ($type == 'moderation') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 1";
        } elseif ($type == 'trash') {
            $where = CN_T_POSTED . " = 0";
        } elseif ($type == 'complaints') {
            $where = CN_T_POSTED . " = 1 AND " . CN_T_COMPLAIN . " != ''";
        } elseif ($type == 'page' && isset($param)) {
            $where = CN_T_PID . " = '$param' AND " . CN_T_POSTED . " = 1";
        } elseif ($type == 'person' && isset($param)) {
            $where = CN_T_UID . " = $param AND " . CN_T_POSTED . " = 1";
        } else {
            $where = CN_T_POSTED . " = 1";
        }

        if (isset($_GET['p'])) {
            $pageNum = $_GET['p'];
        } else {
            $pageNum = 1;
        }

        $limit = CN_SET_LIMIT_COMMENTS_ADMIN;
        $offset = (CN_SET_LIMIT_COMMENTS_ADMIN * $pageNum) - CN_SET_LIMIT_COMMENTS_ADMIN;

        $sqlUnited = $mysqli->query("SELECT * FROM `" . CN_T_UNITED . "` WHERE `" . CN_T_CID . "` IN (SELECT `" . CN_T_ID . "` FROM `" . CN_T_COMMENTS . "` WHERE $where AND `" . CN_T_TYPE . "` = 'main') OR `" . CN_T_CID . "` IN (SELECT `" . CN_T_ID . "` FROM `" . CN_T_ANSWER . "` WHERE $where AND `" . CN_T_TYPE . "` = 'answer') ORDER BY `" . CN_T_DATE_PUBLISHED . "` DESC LIMIT $limit OFFSET $offset");

        $main = '';
        $answer = '';
        while ($arr = $sqlUnited->fetch_assoc()) {
            if ($arr[CN_T_TYPE] === 'main') {
                $main .= $arr[CN_T_CID] . ',';
            }
            if ($arr[CN_T_TYPE] === 'answer') {
                $answer .= $arr[CN_T_CID] . ',';
            }
        }

        $data = null;
        $dataLimit = null;

        if ($main) {
            $sqlMain = $mysqli->query("SELECT * FROM `" . CN_T_COMMENTS . "` WHERE `" . CN_T_ID . "` IN(" . trim($main, ',') . ")");

            if ($sqlMain) {
                while ($arr = $sqlMain->fetch_assoc()) {
                    $data[] = $arr;
                }
            }
        }

        if ($answer) {
            $sqlAnswer = $mysqli->query("SELECT * FROM `" . CN_T_ANSWER . "` WHERE `" . CN_T_ID . "` IN(" . trim($answer, ',') . ")");
            if ($sqlAnswer) {
                while ($arr = $sqlAnswer->fetch_assoc()) {
                    $data[] = $arr;
                }
            }
        }

        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $row) {
                $volume[$key] = $row[CN_T_DATE_PUBLISHED];
            }
            array_multisort($volume, SORT_DESC, $data);

            $dataLimit = $data;
        }

        return $dataLimit;
    }

    /**
     * Цепочка комментария
     * @param $id
     * @return array|null
     */
    public static function getCommentChain($id)
    {
        $mysqli = CnDb::getConnect();

        $sqlMain = $mysqli->query("SELECT * FROM " . CN_T_COMMENTS . " WHERE " . CN_T_ID . " = $id LIMIT 1");
        $sqlAnswer = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_MCID . " = $id");

        $data = null;
        $dataLimit = null;

        if ($sqlMain) {
            while ($arr = $sqlMain->fetch_assoc()) {
                $data[] = $arr;
            }
        }
        if ($sqlAnswer) {
            while ($arr = $sqlAnswer->fetch_assoc()) {
                $data[] = $arr;
            }
        }


        if (is_array($data) && !empty($data)) {
            foreach ($data as $key => $row) {
                $volume[$key] = $row[CN_T_DATE_PUBLISHED];
            }
            array_multisort($volume, SORT_ASC, $data);
        }

        return $data;
    }

    /**
     * Очистить от жалоб
     * @param $id 'comment id'
     * @param $type 'main' or 'answer'
     * @return bool|mysqli_result
     */
    public static function cleanComplaints($id, $type)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'main') $table = CN_T_COMMENTS;
        else $table = CN_T_ANSWER;

        $sql = $mysqli->query("UPDATE $table SET " . CN_T_COMPLAIN . " = NULL, " . CN_T_NEW . " = 0 WHERE " . CN_T_ID . " = $id LIMIT 1");

        return $sql;
    }

    /**
     * Записать жалобу в БД
     * @param $id 'comment id'
     * @param $items
     * @param $type 'main' or 'answer'
     * @return int
     */
    public static function writeComplaint($id, $items, $type)
    {
        $mysqli = CnDb::getConnect();

        if ($type == 'main') $table = CN_T_COMMENTS;
        else $table = CN_T_ANSWER;

        $sqlSelect = $mysqli->query("SELECT " . CN_T_COMPLAIN . " FROM $table WHERE " . CN_T_ID . " = $id");
        if ($sqlSelect) {
            $complaints = $sqlSelect->fetch_assoc();
            $complaints = $complaints[CN_T_COMPLAIN];
            if (!empty($complaints)) {
                $complaintsArr = unserialize(base64_decode($complaints));
            }
        }

        $complaintsArr[] = $items;
        $complaintsData = base64_encode(serialize($complaintsArr));

        $sqlWrite = $mysqli->prepare("UPDATE $table SET " . CN_T_COMPLAIN . " = ? WHERE " . CN_T_ID . " = $id");
        $sqlWrite->bind_param('s', $complaintsData);
        $sqlWrite->execute();

        return $sqlWrite->affected_rows;
    }

    /**
     * Записать комментарий в БД
     * @param $items array
     * @return int
     */
    public static function writeMain($items)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->prepare("INSERT INTO " . CN_T_COMMENTS . " 
        (
            " . CN_T_UID . ",
            " . CN_T_PID . ",
            " . CN_T_TEXT . ",
            " . CN_T_MODERATION . ",
            " . CN_T_PAGE_TITLE . "
        ) VALUES (?,?,?,?,?)
        ");
        $sql->bind_param('issis', $items[CN_T_UID], $items[CN_T_PID], $items[CN_T_TEXT], $items[CN_T_MODERATION], $items[CN_T_PAGE_TITLE]);
        $sql->execute();

        $result['result'] = $sql->errno;
        $result['insert_id'] = $mysqli->insert_id;

        if ($result['result'] === 0) {
            $mysqli->query("INSERT INTO " . CN_T_UNITED . " (" . CN_T_TYPE . "," . CN_T_CID . ") VALUES ('main'," . $result['insert_id'] . ")");
        }

        return $result;
    }


    /**
     * Записать ответ на комментарий в БД
     * @param $items
     * @return int
     */
    public static function writeAnswer($items)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->prepare("INSERT INTO " . CN_T_ANSWER . " 
        (
            " . CN_T_UID . ",
            " . CN_T_PID . ",
            " . CN_T_TEXT . ",
            " . CN_T_MODERATION . ",
            " . CN_T_PAGE_TITLE . ",
            " . CN_T_MCID . ",
            " . CN_T_PARENT_ID . ",
            " . CN_T_PUID . ",
            " . CN_T_QUOTE . "
        ) VALUES (?,?,?,?,?,?,?,?,?)
        ");
        $sql->bind_param('issisiiis',
            $items[CN_T_UID],
            $items[CN_T_PID],
            $items[CN_T_TEXT],
            $items[CN_T_MODERATION],
            $items[CN_T_PAGE_TITLE],
            $items[CN_T_MCID],
            $items[CN_T_PARENT_ID],
            $items[CN_T_PUID],
            $items[CN_T_QUOTE]
        );
        $sql->execute();

        $result['result'] = $sql->errno;
        $result['insert_id'] = $mysqli->insert_id;

        if ($result['result'] === 0) {
            $mysqli->query("INSERT INTO " . CN_T_UNITED . " (" . CN_T_TYPE . "," . CN_T_CID . "," . CN_T_MCID . ") VALUES ('answer'," . $result['insert_id'] . "," . $items[CN_T_MCID] . ")");
        }

        return $result;
    }


    /**
     * Получить комментарии по URI
     * @param $pid
     * @param null $sort
     * @param $limit
     * @return array|null
     */
    public static function getCommentsByUri($pid, $sort = null, $limit)
    {
        $mysqli = CnDb::getConnect();

        $result = null;
        $orderBy = null;

        if ($sort != null) {
            $orderBy = 'ORDER BY ' . $sort;
        }

        $sql = $mysqli->query("SELECT * FROM " . CN_T_COMMENTS . " WHERE " . CN_T_PID . " = '$pid' AND " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 0 $orderBy LIMIT $limit");

        if ($sql) {
            while ($arr = $sql->fetch_assoc()) {
                $result[] = $arr;
            }
        }

        return $result;
    }


    /**
     * Получить ответы на комментарии по URI
     * @param $pid
     * @param null $sort
     * @return array|null
     */
    public static function getAnswerByUri($pid, $sort = null)
    {
        $mysqli = CnDb::getConnect();

        $result = null;
        $orderBy = null;

        if ($sort != null) {
            $orderBy = 'ORDER BY ' . $sort;
        }

        $sql = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_PID . " = '$pid' AND " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 0 $orderBy");

        if ($sql) {
            while ($arr = $sql->fetch_assoc()) {
                $result[] = $arr;
            }
        }

        return $result;
    }


    /**
     * Получить ответы на комментарии по списку ID
     * @param $listId
     * @param null $sort
     * @return array|null
     */
    public static function getAnswerByListId($listId, $sort = null)
    {
        $mysqli = CnDb::getConnect();

        $data = null;
        $orderBy = null;

        if ($sort != null) {
            $orderBy = 'ORDER BY ' . CN_T_DATE_PUBLISHED . ' asc';
        }

        if ($listId) {
            $sql = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_MCID . " IN($listId) AND " . CN_T_POSTED . " = 1 AND " . CN_T_MODERATION . " = 0 $orderBy");

            if ($sql) {
                while ($arr = $sql->fetch_assoc()) {
                    $data[] = $arr;
                }
            }
        }

        return $data;
    }


    /**
     * Получить комментарий по ID
     * @param $id
     * @return array
     */
    public static function getCommentById($id)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->query("SELECT * FROM " . CN_T_COMMENTS . " WHERE " . CN_T_ID . " = '$id' LIMIT 1");

        return $sql->fetch_assoc();
    }


    /**
     * Получить комментарий по ID и URL
     * @param $id
     * @param $pid
     * @return array
     */
    public static function getCommentByIdAndUrl($id, $pid)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->query("SELECT * FROM " . CN_T_COMMENTS . " WHERE " . CN_T_ID . " = '$id' AND ".CN_T_PID." = '$pid' LIMIT 1");

        return $sql->fetch_assoc();
    }


    /**
     * Получить ответ на комментарий по ID
     * @param $id
     * @return array
     */
    public static function getAnswerById($id)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_ID . " = '$id' LIMIT 1");

        return $sql->fetch_assoc();
    }


    /**
     * Удаляет главный комментарий и все ответы на него
     * @param $id
     * @return bool
     */
    public static function deleteMainById($id)
    {
        $mysqli = CnDb::getConnect();

        $selectId[] = 'cnm-' . $id;

        $sqlSelectId = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_MCID . " = $id");
        if ($sqlSelectId) {
            while ($arr = $sqlSelectId->fetch_assoc()) {
                $selectId[] = 'cna-' . $arr[CN_T_ID];
            }
        }

        if ($selectId) {
            $sqlDeleteRating = $mysqli->prepare("DELETE FROM " . CN_T_RATING . " WHERE " . CN_T_CID . " = ?");
            foreach ($selectId as $value) {
                $sqlDeleteRating->bind_param('s', $value);
                $sqlDeleteRating->execute();
            }
        }

        $sqlMain = $mysqli->query("DELETE FROM " . CN_T_COMMENTS . " WHERE " . CN_T_ID . " = $id LIMIT 1");

        if ($sqlMain) {
            $mysqli->query("DELETE FROM " . CN_T_UNITED . " WHERE " . CN_T_CID . " = $id AND ".CN_T_TYPE." = 'main' LIMIT 1");

            $sqlAnswer = $mysqli->query("DELETE FROM " . CN_T_ANSWER . " WHERE " . CN_T_MCID . " = $id");
            if ($sqlAnswer) {
                $mysqli->query("DELETE FROM " . CN_T_UNITED . " WHERE " . CN_T_MCID . " = $id AND ".CN_T_TYPE." = 'answer'");
            }
        } else return false;

        return true;
    }


    /**
     * Удаляет ответ на комментарий и все его потомки
     * @param $id
     * @return bool
     */
    public static function deleteAnswerById($id)
    {
        $mysqli = CnDb::getConnect();

        $ratingCid = 'cna-' . $id;
        $listId = null;

        $sqlSelectAnswer = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_ID . " = $id LIMIT 1");
        if ($sqlSelectAnswer) {
            $arrSelect = $sqlSelectAnswer->fetch_assoc();
            $listId .= $arrSelect[CN_T_ID] . ',';
        }

        $sqlAnswer = $mysqli->query("DELETE FROM " . CN_T_ANSWER . " WHERE " . CN_T_ID . " = $id");
        $mysqli->query("DELETE FROM " . CN_T_UNITED . " WHERE " . CN_T_CID . " = $id AND ".CN_T_TYPE." = 'answer' LIMIT 1");
        $mysqli->query("DELETE FROM " . CN_T_RATING . " WHERE " . CN_T_CID . " = '$ratingCid'");

        if ($sqlAnswer) {
            $sql = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_PARENT_ID . " = $id");

            if ($sql) {
                while ($arr = $sql->fetch_assoc()) {
                    $listId .= $arr[CN_T_ID] . ',';
                    $listId .= self::deleteAnswerById($arr[CN_T_ID]);
                }
            }
        } else return false;

        return $listId;
    }


    /**
     * Переместить главный комментарий в корзину / из корзины
     * @param $id
     * @param int $action '1 - restore' or '0 - remove'
     * @return bool
     */
    public static function postedMainById($id, $action = 1)
    {
        $mysqli = CnDb::getConnect();

        $mainAction = null;
        $answerAction = null;

        if ($action == 1) {
            $mainAction = 1;
            $answerAction = 1;
        } elseif ($action == 0) {
            $mainAction = 0;
            $answerAction = 2;
        }

        $sqlMain = $mysqli->query("UPDATE " . CN_T_COMMENTS . " SET " . CN_T_POSTED . " = $mainAction, " . CN_T_NEW . " = 0  WHERE " . CN_T_ID . " = $id LIMIT 1");

        if ($sqlMain) {
            $mysqli->query("UPDATE " . CN_T_ANSWER . " SET " . CN_T_POSTED . " = $answerAction, " . CN_T_NEW . " = 0 WHERE " . CN_T_MCID . " = $id");
        } else return false;

        return true;
    }


    /**
     * Переместить ответ на комментарий в корзину / из корзины
     * @param $id
     * @param int $action '1 - restore' or '0 - remove'
     * @return bool
     */
    public static function postedAnswerById($id, $action = 1)
    {
        $mysqli = CnDb::getConnect();

        $mainAction = null;
        $answerAction = null;
        $listId = $id . ',';

        if ($action == 1) {
            $mainAction = 1;
            $answerAction = 1;
        } elseif ($action == 0) {
            $mainAction = 0;
            $answerAction = 2;
        } elseif ($action == 2) {
            $mainAction = 2;
            $answerAction = 2;
        }

        $sqlAnswer = $mysqli->query("UPDATE " . CN_T_ANSWER . " SET " . CN_T_POSTED . " = $mainAction, " . CN_T_NEW . " = 0 WHERE " . CN_T_ID . " = $id LIMIT 1");

        if ($sqlAnswer) {
            $sql = $mysqli->query("SELECT * FROM " . CN_T_ANSWER . " WHERE " . CN_T_PARENT_ID . " = $id");

            if ($sql) {
                while ($arr = $sql->fetch_assoc()) {
                    $listId .= $arr[CN_T_ID] . ',';
                    $listId .= self::postedAnswerById($arr[CN_T_ID], $answerAction);
                }
            }
        } else return false;

        return $listId;
    }


    /**
     * Склонение чисел
     * @param $number
     * @param $suffix
     * @return mixed
     */
    public static function declensionWord($number, $suffix)
    {
        $keys = array(2, 0, 1, 1, 1, 2);
        $mod = $number % 100;
        $suffix_key = ($mod > 7 && $mod < 20) ? 2 : $keys[min($mod % 10, 5)];
        return $suffix[$suffix_key];
    }


    public static function changeDate($date)
    {
        $date = date_parse($date);
        $month = unserialize(CN_MONTH_NAME_ARRAY);
        if ($date['minute'] < 10) $date['minute'] = '0' . $date['minute'];
        $result = $date['day'] . ' ' . $month[$date['month']] . ' ' . $date['year'] . ' ' . $date['hour'] . ':' . $date['minute'];
        return $result;
    }


    public static function changeTime($time)
    {
        $echoTime = null;
        $timeNow = time();
        $timeSql = strtotime($time);

        $deSec = unserialize(CN_DECLINATION_SECONDS);
        $deMinute = unserialize(CN_DECLINATION_MINUTE);
        $deHour = unserialize(CN_DECLINATION_HOUR);
        $deDay = unserialize(CN_DECLINATION_DAY);
        $deWeek = unserialize(CN_DECLINATION_WEEK);
        $deMonth = unserialize(CN_DECLINATION_MONTH);
        $deYear = unserialize(CN_DECLINATION_YEAR);

        $sec = floor($timeNow - $timeSql);
        $minute = floor($sec / 60);
        $hour = floor($sec / 60 / 60);
        $day = floor($sec / 60 / 60 / 24);
        $week = floor($sec / 60 / 60 / 24 / 7);
        $month = floor($sec / 60 / 60 / 24 / 7 / 4);
        $year = floor($sec / 60 / 60 / 24 / 7 / 4 / 12);

        if ($sec == 0) {
            $echoTime = CN_JUST_NOW;
        }
        if ($sec < 60 && $sec > 0) {
            $echoTime = $sec . ' ' . self::declensionWord($sec, $deSec) . ' ' . CN_AGO;
        }
        if ($sec >= 60) {
            $echoTime = $minute . ' ' . self::declensionWord($minute, $deMinute) . ' ' . CN_AGO;
        }
        if ($minute >= 60) {
            $echoTime = $hour . ' ' . self::declensionWord($hour, $deHour) . ' ' . CN_AGO;
        }
        if ($hour >= 24) {
            $echoTime = $day . ' ' . self::declensionWord($day, $deDay) . ' ' . CN_AGO;
        }
        if ($day >= 7) {
            $echoTime = $week . ' ' . self::declensionWord($week, $deWeek) . ' ' . CN_AGO;
        }
        if ($week >= 4) {
            $echoTime = $month . ' ' . self::declensionWord($month, $deMonth) . ' ' . CN_AGO;
        }
        if ($month >= 12) {
            $echoTime = $year . ' ' . self::declensionWord($year, $deYear) . ' ' . CN_AGO;
        }

        return $echoTime;
    }


    /**
     * @param $dataComment array(cnMain, cnAnswer, cnUsers, cnLogin, cnThisUser, cnRating)
     * @return string
     */
    public static function getCommentsMainView($dataComment)
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_main_comments.php';
        return ob_get_clean();
    }


    /**
     * @param $dataComment array(cnAnswer, cnUsers, cnLogin, cnThisUser, cnRating, cnMainId)
     * @param int $parentId
     * @param int $indexVal
     * @return string
     */
    public static function getCommentsAnswerView($dataComment, $parentId = 0, $indexVal = 0)
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_answer_comments.php';
        return ob_get_clean();
    }

    /**
     * @param $dataComment array(cnComments, cnUsers)
     * @return string
     */
    public static function getLastCommentsView($dataComment)
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_last_comments.php';
        return ob_get_clean();
    }

    /**
     * @return string
     */
    public static function getSortView()
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_sort.php';
        return ob_get_clean();
    }


    /**
     * Фильтрует текст комментария
     * @param $data
     * @return mixed|string
     */
    public static function filterCommentsView($data) {
        $dataCommentText = $data;
        $dataCommentText = htmlspecialchars($dataCommentText);
        $dataCommentText = nl2br($dataCommentText);
        
        return $dataCommentText;
    }


    public static function urlMod($url) {
        $url = urldecode($url);
        if (CN_SET_GET === 'off') {
            $url = preg_replace('/^([^\?]+)(?:\?.*)?$/iu', '$1', $url);
        }
        return $url;
    }
}