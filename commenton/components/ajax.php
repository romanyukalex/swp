<?php

include '../headset.php';

if (CN_TIME_ZONE !== '') {
    date_default_timezone_set(CN_TIME_ZONE);
}

if (!isset($_POST['action']) && !isset($_FILES['ava_admin_upload'])) {
    header("HTTP/1.0 404 Not Found");
    include $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/error_404.php';
    exit;
}

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'logout') {
        CnUser::logout();
        exit(json_encode(true));
    }


    /********************** Отправить комментарий ***************************/
    if ($_POST['action'] == 'message_submit') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        $antiFlood = new CnAntiFlood();
        $checkFlood = $antiFlood->check();

        if ($checkFlood !== true) {
            exit(json_encode($checkFlood));
        }

        if ($cnLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($thisUser == null) exit();
            if ($thisUser[CN_T_BAN] == 1) exit();
        }

        if (!isset($_POST['page_url']) || !isset($_POST['message_text']) || !isset($_POST['page_title'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        if (trim($_POST['message_text']) === '') {
            $notice[0] = 'empty_box';
            $notice[1] = CN_EMPTY_BOX;
            exit(json_encode($notice));
        }

        $countMessage = mb_strlen($_POST['message_text'], CN_SET_ENCODING);
        if ($countMessage > CN_SET_COUNT_CHARS_COMMENTS) {
            $notice[0] = 'long_string';
            $notice[1] = CN_LONG_STRING . ' ' . $countMessage . ' / ' . CN_SET_COUNT_CHARS_COMMENTS;
            exit(json_encode($notice));
        }

        $items[CN_T_UID] = $_SESSION[CN_S_USER_ID];
        $items[CN_T_PID] = CnComment::urlMod($_POST['page_url']);
        $items[CN_T_TEXT] = $_POST['message_text'];
        $items[CN_T_TEXT] = trim($items[CN_T_TEXT]);

        if (CN_SET_MODERATION == 'on' && !isset($_SESSION[CN_S_LOGGED_ADMIN])) {
            $items[CN_T_MODERATION] = 1;
        } else {
            $items[CN_T_MODERATION] = 0;
        }
        $items[CN_T_PAGE_TITLE] = $_POST['page_title'];

        $writeSql = CnComment::writeMain($items);

        if ($writeSql['result'] === 0) {
            unset($_SESSION[CN_S_TEXT_ENTERED][md5($items[CN_T_PID])]);
            $antiFlood->set();

            $thisCnAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';
            $thisUser = null;
            if ($cnLogin == 'admin') {
                $thisUser = $thisCnAdmin;
            }

            $thisCnComments = CnComment::getCommentById($writeSql['insert_id']);

            $thisCnUsers[$thisCnComments[CN_T_UID]] = CnUser::getUserById($thisCnComments[CN_T_UID]);
            $thisCnUsers[$thisCnAdmin['id']] = $thisCnAdmin;

            if (CN_SET_MODERATION == 'on' && !isset($_SESSION[CN_S_LOGGED_ADMIN])) {
                $notice[0] = 2;
                $notice[1] = CN_SENT_MODERATION;
            } else {
                $notice[0] = 1;

                $countMainComments = CnComment::getCountMain($items[CN_T_PID]);
                $countAnswerComments = CnComment::getCountAnswer($items[CN_T_PID]);

                $dataComment['cnMain'] = $thisCnComments;
                $dataComment['cnUsers'] = $thisCnUsers;
                $dataComment['cnLogin'] = $cnLogin;
                $dataComment['cnThisUser'] = $thisUser;

                $commentView = CnComment::getCommentsMainView($dataComment);

                $notice[1] = $commentView;
                $notice[2] = $countMainComments + $countAnswerComments;
            }

            if ($thisCnUsers[$thisCnComments[CN_T_UID]][CN_T_ID] !== 0 && CN_SET_SEND_ADMIN_NOTICE == 'on') {
                CnSendMail::noticeForAdmin($items[CN_T_PID], 'cnm-' . $writeSql['insert_id'], $thisCnUsers[$thisCnComments[CN_T_UID]][CN_T_NAME], $thisCnComments[CN_T_TEXT]);
            }

            exit(json_encode($notice));
        }
    }


    /********************** Ответить на комментарий ***************************/
    if ($_POST['action'] == 'answer_submit') {
        $cnLogin = CnUser::checkAuthorize();
        $cnAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        $antiFlood = new CnAntiFlood();
        $checkFlood = $antiFlood->check();

        if ($checkFlood !== true) {
            exit(json_encode($checkFlood));
        }

        if ($cnLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($thisUser == null) exit();
            if ($thisUser[CN_T_BAN] == 1) exit();
        }

        if (!isset($_POST['page_url']) || !isset($_POST['message_text'])
            || !isset($_POST['page_title']) || !isset($_POST['parent_id'])
            || !isset($_POST['main_id']) || !isset($_POST['comment_type'])
        ) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        if (trim($_POST['message_text']) === '') {
            $notice[0] = 'empty_box';
            $notice[1] = CN_EMPTY_BOX;
            exit(json_encode($notice));
        }

        $countMessage = mb_strlen($_POST['message_text'], CN_SET_ENCODING);
        if ($countMessage > CN_SET_COUNT_CHARS_ANSWER) {
            $notice[0] = 'long_string';
            $notice[1] = CN_LONG_STRING . ' ' . $countMessage . ' / ' . CN_SET_COUNT_CHARS_ANSWER;
            exit(json_encode($notice));
        }

        $level = $_POST['level'];
        $parent_id = preg_replace('/.+-/', '', $_POST['parent_id']);

        $items[CN_T_UID] = $_SESSION[CN_S_USER_ID];
        $items[CN_T_PID] = CnComment::urlMod($_POST['page_url']);
        $items[CN_T_TEXT] = $_POST['message_text'];
        $items[CN_T_TEXT] = trim($items[CN_T_TEXT]);

        if (CN_SET_MODERATION == 'on' && !isset($_SESSION[CN_S_LOGGED_ADMIN])) {
            $items[CN_T_MODERATION] = 1;
        } else {
            $items[CN_T_MODERATION] = 0;
        }
        $items[CN_T_PAGE_TITLE] = $_POST['page_title'];
        $items[CN_T_MCID] = $_POST['main_id'];

        if ($_POST['comment_type'] == 'main') {
            $items[CN_T_PARENT_ID] = 0;
            $parentComment = CnComment::getCommentById($parent_id);
        }
        if ($_POST['comment_type'] == 'answer') {
            $items[CN_T_PARENT_ID] = $parent_id;
            $parentComment = CnComment::getAnswerById($parent_id);
        }

        if (isset($parentComment)) {
            if ($parentComment[CN_T_UID] != 0) {
                $parentUser = CnUser::getUserById($parentComment[CN_T_UID]);
            } else $parentUser = $cnAdmin;
        } else {
            $notice[0] = 'no_more';
            $notice[1] = CN_NO_MORE;
            exit(json_encode($notice));
        }

        $items[CN_T_PUID] = $parentComment[CN_T_UID];

        $quote = array(
            CN_T_PARENT_ID => $_POST['parent_id'],
            CN_T_NAME => $parentUser[CN_T_NAME],
            CN_T_TEXT => $parentComment[CN_T_TEXT]
        );

        $items[CN_T_QUOTE] = base64_encode(serialize($quote));

        $writeSql = CnComment::writeAnswer($items);

        $thisUser = null;
        if ($cnLogin == 'admin') {
            $thisUser = $cnAdmin;
        }

        $thisCnAnswer = CnComment::getAnswerById($writeSql['insert_id']);

        $thisCnUsers[$thisCnAnswer[CN_T_UID]] = CnUser::getUserById($thisCnAnswer[CN_T_UID]);
        $thisCnUsers[$cnAdmin['id']] = $cnAdmin;

        if ($writeSql['result'] === 0) {
            $antiFlood->set();
            if (CN_SET_MODERATION == 'on' && !isset($_SESSION[CN_S_LOGGED_ADMIN])) {
                $notice[0] = 2;
                $notice[1] = CN_SENT_MODERATION;
            } else {
                $notice[0] = 1;

                $countMainComments = CnComment::getCountMain($items[CN_T_PID]);
                $countAnswerComments = CnComment::getCountAnswer($items[CN_T_PID]);


                $dataComment['cnAnswer'] = $thisCnAnswer;
                $dataComment['cnUsers'] = $thisCnUsers;
                $dataComment['cnLogin'] = $cnLogin;
                $dataComment['cnThisUser'] = $thisUser;
                $dataComment['cnMainId'] = $thisCnAnswer[CN_T_MCID];

                $commentView = CnComment::getCommentsAnswerView($dataComment, 0, $level);

                if ($level < CN_SET_LEVEL_INPUT) {
                    $commentView .= '<div class="cn_comments_answer_block"></div>';
                }

                $notice[1] = $commentView;
                $notice[2] = $countMainComments + $countAnswerComments;
                $notice[3] = $writeSql['insert_id'];

                if ($thisCnUsers[$thisCnAnswer[CN_T_UID]][CN_T_ID] != $parentUser[CN_T_ID] && $parentUser[CN_T_AUTH_VIA] != 'guest') {
                    CnSendMail::noticeAnswer($items[CN_T_PID], 'cna-' . $writeSql['insert_id'], $thisCnUsers[$thisCnAnswer[CN_T_UID]][CN_T_NAME], $thisCnAnswer[CN_T_TEXT], $parentUser[CN_T_EMAIL]);
                }
            }

            if ($thisCnUsers[$thisCnAnswer[CN_T_UID]][CN_T_ID] !== 0 && CN_SET_SEND_ADMIN_NOTICE == 'on') {
                CnSendMail::noticeForAdmin($items[CN_T_PID], 'cna-' . $writeSql['insert_id'], $thisCnUsers[$thisCnAnswer[CN_T_UID]][CN_T_NAME], $thisCnAnswer[CN_T_TEXT]);
            }

            exit(json_encode($notice));
        }
    }


    /********************** Удалить комментарий ***************************/
    if ($_POST['action'] == 'delete_comment') {
        $cnLogin = CnUser::checkAuthorize();

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $comment_id = preg_replace('/.+-/', '', $_POST['comment_id']);
        $pageUri = CnComment::urlMod($_POST['page_url']);

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        if ($cnLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($thisUser == null) exit();
            if ($thisUser[CN_T_BAN] == 1) exit();
        }

        $result = null;
        $userAccess = 0;

        if ($_POST['comment_type'] == 'main') {
            $comment = CnComment::getCommentById($comment_id);
            if (!isset($comment)) {
                $notice[0] = 'no_more';
                exit(json_encode($notice));
            }
            if ($cnLogin == 'user') {
                if ($comment[CN_T_UID] == $_SESSION[CN_S_USER_ID]) {
                    $userAccess = 1;
                } else {
                    exit(json_encode($comment));
                }
            }
            if ($userAccess == 1 || $cnLogin == 'admin') {
                $result = CnComment::deleteMainById($comment_id);
            }
        }
        if ($_POST['comment_type'] == 'answer') {
            $comment = CnComment::getAnswerById($comment_id);
            if (!isset($comment)) {
                $notice[0] = 'no_more';
                exit(json_encode($notice));
            }
            if ($cnLogin == 'user') {
                if ($comment[CN_T_UID] == $_SESSION[CN_S_USER_ID]) {
                    $userAccess = 1;
                } else {
                    exit();
                }
            }
            if ($userAccess == 1 || $cnLogin == 'admin') {
                $result = CnComment::deleteAnswerById($comment_id);
            }
        }

        if ($result !== false) {
            $listId = array_values(array_unique(explode(',', trim($result, ','))));
            $notice[0] = 1;
            $notice[1] = $listId;
            $countMainComments = CnComment::getCountMain($pageUri);
            $countAnswerComments = CnComment::getCountAnswer($pageUri);
            $notice[2] = $countMainComments + $countAnswerComments;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /********************** Сортировка ***************************/
    if ($_POST['action'] == 'sort') {

        if (!isset($_POST['sort'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $sort = $_POST['sort'];

        @CnSession::start();
        $_SESSION[CN_S_SORT] = $sort;
        $_SESSION[CN_S_LIMIT_START] = (isset($_SESSION[CN_S_LIMIT_MAX])) ? $_SESSION[CN_S_LIMIT_MAX] : $_SESSION[CN_S_LIMIT_LOAD];

        /*
         * Вывести комментарии
         */
        $cnLogin = CnUser::checkAuthorize();
        $cnAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';
        if (isset($_COOKIE[CN_S_USER_ID]) && isset($_COOKIE[CN_S_TOKEN])) {
            if ($cnLogin == false) {
                $checkToken = CnUser::checkToken($_COOKIE[CN_S_USER_ID], $_COOKIE[CN_S_TOKEN]);

                if ($checkToken != 0) {
                    $_SESSION[CN_S_USER_ID] = $_COOKIE[CN_S_USER_ID];
                    $_SESSION[CN_S_TOKEN] = $_COOKIE[CN_S_TOKEN];
                    $cnLogin = CnUser::checkAuthorize();
                }
            }
        }
        if ($cnLogin == 'user') {
            $user = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($user == null) {
                unset($_SESSION[CN_S_USER_ID]);
                unset($_SESSION[CN_S_TOKEN]);
            }
        } elseif ($cnLogin == 'admin') {
            $user = $cnAdmin;
        }
        if (!isset($_SESSION[CN_S_SORT])) {
            $getSort = CN_SET_SORT;
        } else {
            $getSort = $_SESSION[CN_S_SORT];
        }

        if ($getSort === 'new') {
            $sortCommentsSQL = CN_T_DATE_PUBLISHED . ' desc';
        } elseif ($getSort === 'old') {
            $sortCommentsSQL = CN_T_DATE_PUBLISHED . ' asc';
        } elseif ($getSort === 'best') {
            $sortCommentsSQL = CN_T_HYPE . ' desc, ' . CN_T_DATE_PUBLISHED . ' desc';
        }
        $thisUri = CnComment::urlMod($_POST['page_url']);
        $limit = CN_SET_LIMIT_COMMENTS;
        if (isset($_SESSION[CN_S_LIMIT_START])) {
            $limit = $_SESSION[CN_S_LIMIT_START];
        } else {
            $_SESSION[CN_S_LIMIT_LOAD] = (int)CN_SET_LIMIT_COMMENTS;
        }
        $cnComments = CnComment::getCommentsByUri($thisUri, $sortCommentsSQL, $limit);
        unset($_SESSION[CN_S_LIMIT_START]);
        $listUserIdArr = array();
        $listIdMainCommentsArr = array();
        $listStrIdCommentsArr = array();
        if ($cnComments) {
            foreach ($cnComments as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listIdMainCommentsArr[] = $val[CN_T_ID];
                $listStrIdCommentsArr[] = 'cnm-' . $val[CN_T_ID];
            }
        }
        $listIdMainComments = implode(array_unique($listIdMainCommentsArr), ',');
        $cnAnswer = CnComment::getAnswerByListId($listIdMainComments);
        if ($cnAnswer) {
            foreach ($cnAnswer as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listStrIdCommentsArr[] = 'cna-' . $val[CN_T_ID];
            }
        }
        $listUserIdCommon = implode(array_unique($listUserIdArr), ',');
        $cnUsers = CnUser::getUsersByListId($listUserIdCommon);
        $cnUsers[$cnAdmin['id']] = $cnAdmin;
        $cnRating = CnComment::getRating($listStrIdCommentsArr);

        $echo = '';
        if ($cnComments):
            $dataComment['cnAnswer'] = $cnAnswer;
            $dataComment['cnUsers'] = $cnUsers;
            $dataComment['cnLogin'] = $cnLogin;
            $dataComment['cnThisUser'] = $user;
            $dataComment['cnRating'] = $cnRating;
            foreach ($cnComments as $key => $val):
                $dataComment['cnMain'] = $val;
                $echo .=  CnComment::getCommentsMainView($dataComment);
            endforeach;
        endif;

        $response[0] = 1;
        $response['sort'] = CnComment::getSortView();
        $response['content'] = $echo;

        exit(json_encode($response));
    }


    /********************** Рейтинг ***************************/
    if ($_POST['action'] == 'hype') {

        if (!isset($_POST['hype_type']) || !isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $hypeType = $_POST['hype_type'];
        $commentId = $_POST['comment_id'];
        $commentType = $_POST['comment_type'];
        //$limitComments = $_POST['limit'];

        if (CN_SET_HYPE != 'on') exit();
        if ($hypeType != 'like' && $hypeType != 'dislike') exit();
        if ($commentType != 'main' && $commentType != 'answer') exit();
        if (empty($commentId)) exit();

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        if ($cnLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($thisUser == null) exit();
            if ($thisUser[CN_T_BAN] == 1) exit();
            if ($thisUser[CN_T_AUTH_VIA] == 'guest') {
                $notice[0] = 'guest_auth';
                $notice[1] = CN_GUEST_NOT_APPRECIATE;
                exit(json_encode($notice));
            }

        }

        $cleanId = preg_replace('/.+-/', '', $commentId);
        if ($commentType == 'main') {
            $comment = CnComment::getCommentById($cleanId);
        }
        if ($commentType == 'answer') {
            $comment = CnComment::getAnswerById($cleanId);
        }

        if (!isset($comment)) {
            $notice[0] = 'no_more';
            exit(json_encode($notice));
        }

        $result = CnComment::writeRating($commentId, $_SESSION[CN_S_USER_ID], $commentType, $hypeType);

        if ($result) {
            if ($commentType == 'main') {
                $comment = CnComment::getCommentById($cleanId);
            } elseif ($commentType == 'answer') {
                $comment = CnComment::getAnswerById($cleanId);
            }
            $notice[0] = 1;
            if (isset($comment)) {
                $notice[1] = $comment[CN_T_HYPE];
            }
        } else {
            $notice[0] = 'error_model';
        }

        exit(json_encode($notice));
    }


    /********************** Загрузить ещё ***************************/
    if ($_POST['action'] == 'more_comments') {
        CnSession::start();

        $thisUri = CnComment::urlMod($_POST['page_url']);
        $limit = $_POST['limit'];

        $limitSql = $limit . ',' . CN_SET_LIMIT_COMMENTS;

        $sortCommentsSQL = null;
        if (!isset($_SESSION[CN_S_SORT]) || $_SESSION[CN_S_SORT] == 'new') {
            $sortCommentsSQL = CN_T_DATE_PUBLISHED . ' desc';
        } elseif ($_SESSION[CN_S_SORT] == 'old') {
            $sortCommentsSQL = CN_T_DATE_PUBLISHED . ' asc';
        } elseif ($_SESSION[CN_S_SORT] == 'best') {
            $sortCommentsSQL = CN_T_HYPE . ' desc, ' . CN_T_DATE_PUBLISHED . ' desc';
        } else {
            $sortCommentsSQL = CN_T_DATE_PUBLISHED . ' desc';
        }

        $cnComments = CnComment::getCommentsByUri($thisUri, $sortCommentsSQL, $limitSql);

        $dataComments = $cnComments;

        $listUserIdArr = array();
        $listIdMainCommentsArr = array();
        $listStrIdCommentsArr = array();

        if ($dataComments) {
            foreach ($dataComments as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listIdMainCommentsArr[] = $val[CN_T_ID];
                $listStrIdCommentsArr[] = 'cnm-' . $val[CN_T_ID];
            }
        }

        $listIdMainComments = implode(array_unique($listIdMainCommentsArr), ',');
        $dataAnswer = CnComment::getAnswerByListId($listIdMainComments);
        if ($dataAnswer) {
            foreach ($dataAnswer as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listStrIdCommentsArr[] = 'cna-' . $val[CN_T_ID];
            }
        }

        $dataAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';

        $thisUser = null;
        $dataLogin = CnUser::checkAuthorize();
        if ($dataLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
        } elseif ($dataLogin == 'admin') {
            $thisUser = $dataAdmin;
        }

        $listUserIdCommon = implode(array_unique($listUserIdArr), ',');
        $dataUsers = CnUser::getUsersByListId($listUserIdCommon);
        $dataUsers[$dataAdmin['id']] = $dataAdmin;

        $dataRating = CnComment::getRating($listStrIdCommentsArr);

        $dataComment['cnAnswer'] = $dataAnswer;
        $dataComment['cnUsers'] = $dataUsers;
        $dataComment['cnLogin'] = $dataLogin;
        $dataComment['cnThisUser'] = $thisUser;
        $dataComment['cnRating'] = $dataRating;

        $data = null;
        if ($dataComments):
            foreach ($dataComments as $key => $val):
                $dataComment['cnMain'] = $val;
                $data .= CnComment::getCommentsMainView($dataComment);
            endforeach;
        endif;

        $countCommentsMain = CnComment::getCountMain($thisUri);
        $response['limit'] = $limit + (int)CN_SET_LIMIT_COMMENTS;

        if ($response['limit'] >= $countCommentsMain) {
            $response['limit'] = 'cancel';
        }

        $response['data'] = $data;

        exit(json_encode($response));
    }


    /********************** Отправить жалобу ***************************/
    if ($_POST['action'] == 'complaint_submit') {

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type']) || !isset($_POST['message'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];
        $message = trim($_POST['message']);

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        if ($cnLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($thisUser == null) exit();
            if ($thisUser[CN_T_BAN] == 1) exit();
        }

        if (empty($message)) {
            $notice[0] = 'empty_box';
            $notice[1] = CN_EMPTY_BOX;
            exit(json_encode($notice));
        }

        if (mb_strlen($message, CN_SET_ENCODING) > 150) {
            $notice[0] = 'long_string';
            $notice[1] = CN_LONG_STRING;
            exit(json_encode($notice));
        }

        $items['uid'] = $_SESSION[CN_S_USER_ID];
        $items['notice'] = $message;
        $items['time'] = date('Y-m-d H:i:s', time());

        if ($commentType == 'main') {
            $comment = CnComment::getCommentById($commentId);
        }
        if ($commentType == 'answer') {
            $comment = CnComment::getAnswerById($commentId);
        }

        if (!isset($comment)) {
            $notice[0] = 'no_more';
            $notice[1] = CN_NO_MORE;
            exit(json_encode($notice));
        }

        $result = CnComment::writeComplaint($commentId, $items, $commentType);

        if ($result) {
            $notice[0] = 1;
            $notice[1] = CN_COMPLAINT_SENT;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /********************** Очистить от жалоб ***************************/
    if ($_POST['action'] == 'clean_complaints') {

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $result = CnComment::cleanComplaints($commentId, $commentType);

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /********************** Гостевой вход ***************************/
    if ($_POST['action'] == 'login_guest') {

        if (!isset($_POST['guest_name']) || (CN_SET_RECAPTCHA == 'on' && !isset($_POST['g_recaptcha_response']))) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $guestName = trim($_POST['guest_name']);
        $guestEmail = trim($_POST['guest_email']);
        $recaptchaResponse = $_POST['g_recaptcha_response'];
        $secretRecaptcha = CN_SET_RECAPTCHA_SECRET_KEY;
        $userIp = $_SERVER['REMOTE_ADDR'];
        $urlRecaptcha = 'https://www.google.com/recaptcha/api/siteverify';

        $urlData = $urlRecaptcha . '?secret=' . $secretRecaptcha . '&response=' . $recaptchaResponse . '&remoteip=' . $userIp;

        $randColor = array(
            '#42b5a0', '#e53935', '#eb3f79', '#5b6abf', '#679e37', '#414141', '#8c6d62',
            '#1d87e4', '#f8a724', '#ff6f42', '#a900ff', '#378d3b', '#778f9b', '#00887a',
            '#9a0700', '#79CB93', '#BA1F75', '#E210E8'
        );
        $reservedName = array(
            'admin', 'administrator', 'админ', 'администратор', 'moder', 'moderator',
            'модер', 'модератор', 'support'
        );

        if (empty($guestName)) {
            $notice[0] = 'empty_box';
            $notice[1] = CN_EMPTY_BOX;
            exit(json_encode($notice));
        }

        if (CN_SET_GUEST_EMAIL == 'on') {
            if (CN_SET_GUEST_EMAIL_REQUIRED == 'on') {
                if (empty($guestEmail) || $guestEmail == null) {
                    $notice[0] = 'empty_email_box';
                    $notice[1] = CN_EMPTY_BOX;
                    exit(json_encode($notice));
                }
            }
            if (!empty($guestEmail)) {
                if (!preg_match('/\A[^@]+@[^@\.]+\.+[^@\.]+\z/iu', $guestEmail)) {
                    $notice[0] = 'error_email';
                    $notice[1] = CN_EMAIL_ERROR;
                    exit(json_encode($notice));
                }
            }
        }

        if (in_array(mb_strtolower($guestName, CN_SET_ENCODING), $reservedName)) {
            $notice[0] = 'reserved_name';
            $notice[1] = CN_RESERVED_NAME;
            exit(json_encode($notice));
        }

        if (mb_strlen($guestName, CN_SET_ENCODING) < 2) {
            $notice[0] = 'small_name';
            $notice[1] = CN_SMALL_STRING . ' - ' . mb_strlen($guestName, CN_SET_ENCODING) . ' / 50';
            exit(json_encode($notice));
        }

        if (mb_strlen($guestName, CN_SET_ENCODING) > 50) {
            $notice[0] = 'long_name';
            $notice[1] = CN_LONG_STRING . ' - ' . mb_strlen($guestName, CN_SET_ENCODING) . ' / 50';
            exit(json_encode($notice));
        }

        if (preg_match('/[^a-zA-Zа-яА-ЯёЁ0-9\'_\s\-]+/iu', $guestName)) {
            $notice[0] = 'unresolved_char';
            $notice[1] = CN_UNRESOLVED_CHAR . '(\'-_)';
            exit(json_encode($notice));
        }

        if (CN_SET_RECAPTCHA == 'on') {
            if (empty($recaptchaResponse)) {
                $notice[0] = 'error_auth';
                $notice[1] = CN_ERROR_AUTH;
                exit(json_encode($notice));
            }

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $urlData);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $res = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($res);

            if ($res->success == false) {
                $notice[0] = 'error_recaptcha';
                $notice[1] = CN_ERROR_RECAPTCHA;
                exit(json_encode($notice));
            }
        }

        $token = md5(md5(microtime()) . $guestName . rand(0, 999999));

        $items[CN_T_NAME] = $guestName;
        $items[CN_T_EMAIL] = $guestEmail;
        $items[CN_T_AUTH_VIA] = 'guest';
        $items[CN_T_AVATAR] = $randColor[rand(0, count($randColor) - 1)];
        $items[CN_T_UIP] = $userIp;
        $items[CN_T_TOKEN] = $token;

        $result = CnUser::setGuest($items);

        if ($result) {
            CnUser::userLogin($result, $items[CN_T_TOKEN]);
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_login';
            $notice[1] = CN_ERROR_LOGIN;
        }

        exit(json_encode($notice));
    }


    /********************** Вход в админку ***************************/
    if ($_POST['action'] == 'login_admin') {

        if (!isset($_POST['login']) || !isset($_POST['password'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $login = $_POST['login'];
        $password = $_POST['password'];

        if ($login == CN_ADMIN_LOGIN && $password == CN_ADMIN_PASSWORD) {
            $result = CnUser::adminLogin();
        } else {
            $result = false;
        }

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_login';
            $notice[1] = CN_DATA_INCORRECT;
        }

        exit(json_encode($notice));
    }


    /********************** Одобрить комментарий ***************************/
    if ($_POST['action'] == 'approve') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];

        $result = CnComment::approveModeration($commentId, $commentType);

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_mysql';
            $notice[1] = CN_ERROR_DB;
        }

        exit(json_encode($notice));
    }


    /********************** В корзину ***************************/
    if ($_POST['action'] == 'trash') {

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];
        $pageUri = CnComment::urlMod($_POST['page_url']);

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        if ($commentType != 'main' && $commentType != 'answer') exit();
        if (empty($commentId)) exit();

        if ($commentType == 'main') {
            $comment = CnComment::getCommentById($commentId);
        }
        if ($commentType == 'answer') {
            $comment = CnComment::getAnswerById($commentId);
        }

        if (!isset($comment)) {
            $notice[0] = 'no_more';
            exit(json_encode($notice));
        }

        $result = null;
        if ($commentType == 'main') {
            $result = CnComment::postedMainById($commentId, 0);
        } elseif ($commentType == 'answer') {
            $result = CnComment::postedAnswerById($commentId, 0);
        }

        if ($result !== false) {
            $listId = array_values(array_unique(explode(',', trim($result, ','))));
            $notice[0] = 1;
            $notice[1] = $listId;
            $countMainComments = CnComment::getCountMain($pageUri);
            $countAnswerComments = CnComment::getCountAnswer($pageUri);
            $notice[2] = $countMainComments + $countAnswerComments;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /********************** Восстановить ***************************/
    if ($_POST['action'] == 'recover') {

        if (!isset($_POST['comment_id']) || !isset($_POST['comment_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        if ($commentType != 'main' && $commentType != 'answer') exit();
        if (empty($commentId)) exit();

        $result = null;
        if ($commentType == 'main') {
            $result = CnComment::postedMainById($commentId, 1);
        } elseif ($commentType == 'answer') {
            $result = CnComment::postedAnswerById($commentId, 1);
        }

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /********************** Настройки ***************************/
    if ($_POST['action'] == 'setting') {

        $formCommon = $_POST['form_common'];
        $formAdmin = $_POST['form_admin'];
        $formSocial = $_POST['form_social'];
        $formGuest = $_POST['form_guest'];
        $formLimitAdmin = $_POST['form_limit_admin'];
        $formLimitUsers = $_POST['form_limit_users'];

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $items = array();
        $settingFile = 'setting.php';

        if (isset($formCommon)) {
            foreach ($formCommon as $item => $value) {
                $items[$value['name']] = $value['value'];
            }
            if (!isset($items['cn_set_moderation'])) {
                $items['cn_set_moderation'] = 'off';
            }
            if (!isset($items['cn_set_hype'])) {
                $items['cn_set_hype'] = 'off';
            }
            if (!isset($items['cn_set_links'])) {
                $items['cn_set_links'] = 'off';
            }
            if (!isset($items['cn_set_get'])) {
                $items['cn_set_get'] = 'off';
            }
        }
        if (isset($formGuest)) {
            foreach ($formGuest as $item => $value) {
                $items[$value['name']] = $value['value'];
            }
            if (!isset($items['cn_set_guest'])) {
                $items['cn_set_guest'] = 'off';
            }
            if (!isset($items['cn_set_guest_email'])) {
                $items['cn_set_guest_email'] = 'off';
            }
            if (!isset($items['cn_set_guest_email_required'])) {
                $items['cn_set_guest_email_required'] = 'off';
            }
            if (!isset($items['cn_set_recaptcha'])) {
                $items['cn_set_recaptcha'] = 'off';
            }
        }
        if (isset($formAdmin)) {
            foreach ($formAdmin as $item => $value) {
                $items[$value['name']] = trim($value['value']);
            }
            if (!isset($items['cn_set_send_admin_notice'])) {
                $items['cn_set_send_admin_notice'] = 'off';
            }
        }
        if (isset($formSocial)) {
            $settingFile = 'social_key.php';
            foreach ($formSocial as $item => $value) {
                $items[$value['name']] = trim($value['value']);
            }
            if (!isset($items['cn_vk_switch'])) {
                $items['cn_vk_switch'] = 'off';
            }
            if (!isset($items['cn_ok_switch'])) {
                $items['cn_ok_switch'] = 'off';
            }
            if (!isset($items['cn_fb_switch'])) {
                $items['cn_fb_switch'] = 'off';
            }
            if (!isset($items['cn_g_switch'])) {
                $items['cn_g_switch'] = 'off';
            }
            if (!isset($items['cn_mm_switch'])) {
                $items['cn_mm_switch'] = 'off';
            }
            if (!isset($items['cn_ya_switch'])) {
                $items['cn_ya_switch'] = 'off';
            }
            if (!isset($items['cn_tw_switch'])) {
                $items['cn_tw_switch'] = 'off';
            }
        }
        if (isset($formLimitAdmin)) {
            foreach ($formLimitAdmin as $item => $value) {
                $items[$value['name']] = $value['value'];
            }
            $notice[1] = 'reload_comments';
        }
        if (isset($formLimitUsers)) {
            foreach ($formLimitUsers as $item => $value) {
                $items[$value['name']] = $value['value'];
            }
            $notice[1] = 'reload_users';
        }

        $result = CnPanel::setCommon($items, $settingFile);

        if ($result !== FALSE) {
            $notice[0] = 1;
        } else {
            $notice = 'error_write';
        }

        exit(json_encode($notice));
    }


    /******************* Заблокировать пользователя *********************/
    if ($_POST['action'] == 'user_ban') {

        if (!isset($_POST['user_id'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $userId = $_POST['user_id'];

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $result = CnUser::setBan($userId);

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }


    /******************* Удалить пользователя *********************/
    if ($_POST['action'] == 'user_delete') {
        if (!isset($_POST['user_id'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $userId = $_POST['user_id'];

        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $result = CnUser::setDelete($userId);

        if ($result) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error_mysql';
        }

        exit(json_encode($notice));
    }
    


    /******************* Пометить все как прочитонное *********************/
    if ($_POST['action'] == 'all_read') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        CnComment::readAllComments();

        exit(json_encode(1));
    }


    /************* Пометить комментарий как прочитонный ***************/
    if ($_POST['action'] == 'read_once') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $commentId = preg_replace('/.+-/', '', $_POST['comment_id']);
        $commentType = $_POST['comment_type'];

        if ($commentType !== 'main' && $commentType !== 'answer') exit();
        if (empty($commentId)) exit();

        $result = false;
        if ($commentType === 'main') {
            $result = CnComment::readComment($commentId, 'main');
        }
        if ($commentType === 'answer') {
            $result = CnComment::readComment($commentId, 'answer');
        }

        if ($result !== false) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error';
        }

        exit(json_encode($notice));
    }


    /******************* Пакетные действия *********************/
    if ($_POST['action'] == 'action_selected') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }
        if ($cnLogin != 'admin') exit();

        $formSelected = $_POST['selected_comments'];
        $actionType = $_POST['action_type'];

        if (!isset($_POST['selected_comments']) || !isset($_POST['action_type'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        $mainComments = array();
        $answerComments = array();
        $result = false;
        foreach ($formSelected as $item => $value) {
            if (preg_match('/cnm-[0-9]+/iu', $value['value'])) {
                $mainComments = str_replace('cnm-', '', $value['value']);
                switch ($actionType) {
                    case "delete_selected":
                        $result = CnComment::deleteMainById($mainComments);
                        break;
                    case "trash_selected":
                        $result = CnComment::postedMainById($mainComments, 0);
                        break;
                    case "recover_selected":
                        $result = CnComment::postedMainById($mainComments, 1);
                        break;
                    case "read_selected":
                        $result = CnComment::readComment($mainComments, 'main');
                        break;
                    case "approve_selected":
                        $result = CnComment::approveModeration($mainComments, 'main');
                        break;
                    case "clean_complaints_selected":
                        $result = CnComment::cleanComplaints($mainComments, 'main');
                        break;
                }
            }
            if (preg_match('/cna-[0-9]+/iu', $value['value'])) {
                $answerComments = str_replace('cna-', '', $value['value']);
                switch ($actionType) {
                    case "delete_selected":
                        $result = CnComment::deleteAnswerById($answerComments);
                        break;
                    case "trash_selected":
                        $result = CnComment::postedAnswerById($answerComments, 0);
                        break;
                    case "recover_selected":
                        $result = CnComment::postedAnswerById($answerComments, 1);
                        break;
                    case "read_selected":
                        $result = CnComment::readComment($answerComments, 'answer');
                        break;
                    case "approve_selected":
                        $result = CnComment::approveModeration($answerComments, 'answer');
                        break;
                    case "clean_complaints_selected":
                        $result = CnComment::cleanComplaints($answerComments, 'answer');
                        break;
                }
            }
        }

        if ($result != false) {
            $notice[0] = 1;
        } else {
            $notice[0] = 'error';
        }

        exit(json_encode($notice));
    }


    /******************* Корректировка времени под пользователя *********************/
    if ($_POST['action'] == 'user_time_zone') {
        $userTime = strtotime($_POST['user_time']);
        $timeNow = time();
        $timeComment = $_POST['time_comment'];

        $timeZone = round(($userTime - $timeNow) / 60 / 60);
        $timeCommentNew = $timeComment + ($timeZone * 60 * 60);

        CnSession::start();
        $_SESSION[CN_S_TIME_ZONE] = $timeZone;

        exit(json_encode(CnComment::changeDate(date('d.m.Y H:i', $timeCommentNew))));
    }


    /******************* Загрузка комментариев по ссылке *********************/
    if ($_POST['action'] == 'load_by_link') {
        if (!isset($_POST['hash'])) {
            exit();
        }
        $hash = $_POST['hash'];
        $pathname = CnComment::urlMod($_POST['pathname']);

        $linkPanel = '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php';

        if ($pathname === $linkPanel) {
            $location = 'panel';
        } else {
            $location = 'site';
        }

        preg_match('/^#(cnm|cna)-([0-9]+)$/i', $hash, $match);

        $type = $match[1];
        $id = $match[2];

        if ($type == 'cna') {
            $dataAnswer = CnComment::getAnswerById($id);
            $id = $dataAnswer[CN_T_MCID];
        }

        if ($location === 'panel') {
            $response['link_locate'] = CN_PROTOCOL . $_SERVER['HTTP_HOST'] . '/' . CN_FOLDER_SCRIPT . '/' . CN_PANEL_SCRIPT . '.php?u=chain&i='. $id . $hash;
            exit(json_encode($response));
        }

        $dataMain = CnComment::getCommentByIdAndUrl($id, $pathname);

        if (empty($dataMain)) {
            exit(json_encode('empty'));
        }

        $idMainComments = null;
        $listUserIdArr = array();
        $listStrIdCommentsArr = array();

        if ($dataMain) {
            $listUserIdArr[] = $dataMain[CN_T_UID];
            $idMainComments = $dataMain[CN_T_ID];
            $listStrIdCommentsArr[] = 'cnm-' . $dataMain[CN_T_ID];
        }

        $dataAnswer = CnComment::getAnswerByListId($idMainComments);

        if ($dataAnswer) {
            foreach ($dataAnswer as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listStrIdCommentsArr[] = 'cna-' . $val[CN_T_ID];
            }
        }

        $dataAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';

        $thisUser = null;
        $dataLogin = CnUser::checkAuthorize();
        if ($dataLogin == 'user') {
            $thisUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
        } elseif ($dataLogin == 'admin') {
            $thisUser = $dataAdmin;
        }

        $listUserIdCommon = implode(array_unique($listUserIdArr), ',');
        $dataUsers = CnUser::getUsersByListId($listUserIdCommon);
        $dataUsers[$dataAdmin['id']] = $dataAdmin;

        $dataRating = CnComment::getRating($listStrIdCommentsArr);

        $dataComment['cnMain'] = $dataMain;
        $dataComment['cnAnswer'] = $dataAnswer;
        $dataComment['cnUsers'] = $dataUsers;
        $dataComment['cnLogin'] = $dataLogin;
        $dataComment['cnThisUser'] = $thisUser;
        $dataComment['cnRating'] = $dataRating;

        $data = null;
        if ($dataMain) {
            $data = CnComment::getCommentsMainView($dataComment);
        }

        $response['data'] = $data;

        exit(json_encode($response));
    }


    /******************* Количество комментариев *********************/
    if ($_POST['action'] == 'count_comment') {
        if (!isset($_POST['url'])) {
            exit();
        }

        $uri = $_POST['url'];

        $getCountMain = CnComment::getCountMain($uri);
        $getCountAnswer = CnComment::getCountAnswer($uri);

        $countComments = $getCountMain + $getCountAnswer;

        exit(json_encode($countComments));
    }


    /******************* Последние комментарии *********************/
    if ($_POST['action'] == 'last_comment') {
        @CnSession::start();
        $limit = $_POST['limit_comments'];
        $type = $_POST['type'];

        $arrComments = CnComment::getLastComments($limit, $type);

        $dataComment = null;

        if (!empty($arrComments)) {
            $comments = $arrComments['comments'];

            $userListID = implode(',', array_unique($arrComments['users']));
            $dataAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';
            $users = CnUser::getUsersByListId($userListID);
            $users[$dataAdmin['id']] = $dataAdmin;

            $dataComment['cnComments'] = $comments;
            $dataComment['cnUsers'] = $users;
        }

        $data = CnComment::getLastCommentsView($dataComment);

        exit($data);
    }


    /******************* Сохранить текст в поле ввода *********************/
    if ($_POST['action'] == 'save_text_entered') {
        CnSession::start();

        $pageUri = md5(CnComment::urlMod($_POST['page_url']));

        if (isset($_SESSION[CN_S_TEXT_ENTERED])) {
            if (is_array($_SESSION[CN_S_TEXT_ENTERED])) {
                $data = array();
                foreach ($_SESSION[CN_S_TEXT_ENTERED] as $key => $val) {
                    $data[$key] = $val;
                }
                $data[$pageUri] = $_POST['text'];

                $_SESSION[CN_S_TEXT_ENTERED] = $data;
            }
        } else {
            $arr[$pageUri] = $_POST['text'];
            $_SESSION[CN_S_TEXT_ENTERED] = $arr;
        }

        exit();
    }

    if ($_POST['action'] == 'pid_edit') {
        $cnLogin = CnUser::checkAuthorize();

        if (!$cnLogin) {
            $notice[0] = 'not_auth';
            $notice[1] = CN_NO_AUTH;
            exit(json_encode($notice));
        }

        if ($cnLogin !== 'admin') exit();

        if (!isset($_POST['new_pid']) || !isset($_POST['old_pid'])) {
            $notice[0] = 'error_data';
            $notice[1] = CN_ERROR_DATA;
            exit(json_encode($notice));
        }

        if (empty(trim($_POST['new_pid']))) {
            $notice[0] = 'empty_box';
            $notice[1] = CN_EMPTY_BOX;
            exit(json_encode($notice));
        }

        $oldPid = trim($_POST['old_pid']);
        $newPid = trim($_POST['new_pid']);

        CnComment::updatePid($oldPid, $newPid);

        exit(true);
    }
}


/********************** Загрузить аватар ***************************/
if (isset($_FILES['ava_admin_upload'])) {
    $name = $_FILES['ava_admin_upload']['name'];
    $tmpName = $_FILES['ava_admin_upload']['tmp_name'];
    $size = $_FILES['ava_admin_upload']['size'];
    $type = $_FILES['ava_admin_upload']['type'];
    $error = $_FILES['ava_admin_upload']['error'];

    $cnLogin = CnUser::checkAuthorize();

    if (!$cnLogin) {
        $notice[0] = 'not_auth';
        $notice[1] = CN_NO_AUTH;
        exit(json_encode($notice));
    }
    if ($cnLogin != 'admin') exit();

    $check_type = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/JPG', 'image/JPEG', 'image/PNG', 'image/GIF');

    if ($error != 0) {
        $notice[0] = 'error_preload';
        exit(json_encode($notice));
    }
    if (!in_array($type, $check_type)) {
        $notice[0] = 'error_type';
        exit(json_encode($notice));
    }
    if (disk_free_space($_SERVER['DOCUMENT_ROOT']) < $size) {
        $notice[0] = 'error_size';
        exit(json_encode($notice));
    }

    if (preg_match('/[^a-zA-Z0-9_.-]+/iu', $name)) {
        $nameArr = explode('.', $name);
        $name = 'avatar_' . date('dmYHis', time());
        $name = $name . '.' . array_pop($nameArr);
    }

    $imgPath = '/' . CN_FOLDER_SCRIPT . '/img/avatar/' . $name;
    $upload_file = move_uploaded_file($tmpName, $_SERVER['DOCUMENT_ROOT'] . $imgPath);

    if ($upload_file) {
        $items['cn_set_admin_avatar'] = $imgPath;
        $result = CnPanel::setCommon($items, 'setting.php');

        if ($result != false) {
            $notice[0] = 1;
            $notice[1] = $imgPath;
        } else {
            $notice[0] = 'error_write';
        }
    } else {
        $notice[0] = 'error_upload';
    }

    exit(json_encode($notice));
}
