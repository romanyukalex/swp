<?php

class CnCommentController
{
    public $vkontakte;
    public $odnoklassniki;
    public $facebook;
    public $google;
    public $mail;
    public $yandex;

    public $cnLogin;
    public $cnAdmin;
    public $user;
    public $sortCommentsSQL;
    public $limit = CN_SET_LIMIT_COMMENTS;
    public $cnComments;
    public $cnAnswer;
    public $cnUsers;
    public $cnRating;
    public $countMainComments;
    public $countAnswerComments;
    public $cnFolderFiles;

    
    public function actionView()
    {
        $this->vkontakte = (CN_VK_SWITCH === 'on') ? new vkAuth() : false;
        $this->odnoklassniki = (CN_OK_SWITCH === 'on') ? new okAuth() : false;
        $this->facebook = (CN_FB_SWITCH === 'on') ? new fbAuth() : false;
        $this->google = (CN_G_SWITCH === 'on') ? new gAuth() : false;
        $this->mail = (CN_MM_SWITCH === 'on') ? new mailAuth() : false;
        $this->yandex = (CN_YA_SWITCH === 'on') ? new yaAuth() : false;

        $this->cnLogin = CnUser::checkAuthorize();
        $this->cnAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';

        if (isset($_COOKIE[CN_S_USER_ID]) && isset($_COOKIE[CN_S_TOKEN])) {
            if ($this->cnLogin == false) {
                $checkToken = CnUser::checkToken($_COOKIE[CN_S_USER_ID],$_COOKIE[CN_S_TOKEN]);

                if ($checkToken != 0) {
                    $_SESSION[CN_S_USER_ID] = $_COOKIE[CN_S_USER_ID];
                    $_SESSION[CN_S_TOKEN] = $_COOKIE[CN_S_TOKEN];
                    $this->cnLogin = CnUser::checkAuthorize();
                }
            }
        }

        if ($this->cnLogin == 'user') {
            $this->user = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($this->user == null) {
                unset($_SESSION[CN_S_USER_ID]);
                unset($_SESSION[CN_S_TOKEN]);
            }
        } elseif ($this->cnLogin == 'admin') {
            $this->user = $this->cnAdmin;
        }

        if (!isset($_SESSION[CN_S_SORT])) {
            $getSort = CN_SET_SORT;
        } else {
            $getSort = $_SESSION[CN_S_SORT];
        }

        if ($getSort === 'new') {
            $this->sortCommentsSQL = CN_T_DATE_PUBLISHED . ' desc';
        } elseif ($getSort === 'old') {
            $this->sortCommentsSQL = CN_T_DATE_PUBLISHED . ' asc';
        } elseif ($getSort === 'best') {
            $this->sortCommentsSQL = CN_T_HYPE . ' desc, ' . CN_T_DATE_PUBLISHED . ' desc';
        }

        $thisUri = CnComment::urlMod($_SERVER['REQUEST_URI']);

        if (isset($_SESSION[CN_S_LIMIT_START])) {
            $this->limit = $_SESSION[CN_S_LIMIT_START];
        } else {
            $_SESSION[CN_S_LIMIT_LOAD] = (int)CN_SET_LIMIT_COMMENTS;
        }

        $this->cnComments = CnComment::getCommentsByUri($thisUri, $this->sortCommentsSQL, $this->limit);

        unset($_SESSION[CN_S_LIMIT_START]);

        $listUserIdArr = array();
        $listIdMainCommentsArr = array();
        $listStrIdCommentsArr = array();

        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listIdMainCommentsArr[] = $val[CN_T_ID];
                $listStrIdCommentsArr[] = 'cnm-'.$val[CN_T_ID];
            }
        }

        $listIdMainComments = implode(array_unique($listIdMainCommentsArr), ',');

        $this->cnAnswer = CnComment::getAnswerByListId($listIdMainComments);

        if ($this->cnAnswer) {
            foreach ($this->cnAnswer as $key => $val) {
                $listUserIdArr[] = $val[CN_T_UID];
                $listStrIdCommentsArr[] = 'cna-'.$val[CN_T_ID];
            }
        }

        $listUserIdCommon = implode(array_unique($listUserIdArr), ',');
        $this->cnUsers = CnUser::getUsersByListId($listUserIdCommon);
        $this->cnUsers[$this->cnAdmin['id']] = $this->cnAdmin;

        $this->countMainComments = CnComment::getCountMain($thisUri);
        $this->countAnswerComments = CnComment::getCountAnswer($thisUri);

        $this->cnRating = CnComment::getRating($listStrIdCommentsArr);

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_view.php';
    }

    
    
    public function actionAnswerView($dataComment, $parentId = 0, $indexVal = 0)
    {
        $indexVal++;

        $cnAnswer = isset($dataComment['cnAnswer']) ? $dataComment['cnAnswer'] : null;

        if ($cnAnswer) {

            $cnAnswerArr = null;

            foreach ($cnAnswer as $index => $value) {
                $cnAnswerArr[$value[CN_T_PARENT_ID]][] = $value;
            }

            if (is_array($cnAnswerArr) && isset($cnAnswerArr[$parentId])) {
                foreach ($cnAnswerArr[$parentId] as $value) {

                    if ($dataComment['cnMainId'] == $value[CN_T_MCID]) {
                        $dataComment['cnAnswer'] = $value;
                        echo CnComment::getCommentsAnswerView($dataComment, $parentId, $indexVal);

                        $classEnd = '';
                        if ($indexVal == CN_SET_LEVEL_INPUT-1) $classEnd = 'cn_last_answer';

                        if ($indexVal < CN_SET_LEVEL_INPUT) echo '<div class="cn_comments_answer_block '.$classEnd.'">';
                        $dataComment['cnAnswer'] = $cnAnswer;
                        $this->actionAnswerView($dataComment, $value[CN_T_ID], $indexVal);
                        if ($indexVal < CN_SET_LEVEL_INPUT) echo '</div>';
                    }
                }
            }
        }
    }

    
    
    public function actionAnswerViewOne($dataComment, $parentId = 0, $indexVal = 0)
    {
        $data = null;

        $cnAnswer = isset($dataComment['cnAnswer']) ? $dataComment['cnAnswer'] : null;

        if ($cnAnswer) {
            foreach ($cnAnswer as $value) {
                if ($dataComment['cnMainId'] == $value[CN_T_MCID]) {
                    $dataComment['cnAnswer'] = $value;
                    echo CnComment::getCommentsAnswerView($dataComment, $parentId, $indexVal);
                }
            }
        }
    }

}