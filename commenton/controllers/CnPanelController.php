<?php

class CnPanelController
{
    private $cnAdmin;
    private $cnComments;
    private $cnUsers;
    private $cnPerson;

    public function __construct()
    {
        if (!isset($_SESSION[CN_S_LOGGED_ADMIN])) {
            include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/cn_login.php';
            exit();
        }

        $this->cnAdmin = include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/admin_data.php';
    }

    public function actionView()
    {
        $this->cnComments = CnComment::getByCondition('common');

        $usersListId = array();
        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                if ($val[CN_T_UID] != 0) {
                    $usersListId[] = $val[CN_T_UID];
                }
            }
            $usersListId = implode(array_unique($usersListId), ',');
        }

        if (!empty($usersListId) && is_string($usersListId)) {
            $this->cnUsers = CnUser::getUsersByListId($usersListId);
        }
        $this->cnUsers[0] = $this->cnAdmin;

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_panel.php';
    }

    public function actionModeration()
    {
        $this->cnComments = CnComment::getByCondition('moderation');

        $usersListId = array();
        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                if ($val[CN_T_UID] != 0) {
                    $usersListId[] = $val[CN_T_UID];
                }
            }
            $usersListId = implode(array_unique($usersListId), ',');
        }

        if (!empty($usersListId) && is_string($usersListId)) {
            $this->cnUsers = CnUser::getUsersByListId($usersListId);
        }
        $this->cnUsers[0] = $this->cnAdmin;

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_moderation.php';
    }

    public function actionUsers()
    {
        if (isset($_GET['b']) && $_GET['b'] == 'banned') {
            $this->cnUsers = CnUser::getBanned();
        } else {
            $this->cnUsers = CnUser::getAll();
        }
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_users.php';

    }

    public function actionPerson()
    {
        if (isset($_GET['i'])) {

            if ($_GET['i'] == 0) {
                $this->cnUsers[0] = $this->cnAdmin;
            } else {
                $this->cnUsers = CnUser::getUsersByListId($_GET['i']);
            }

            $this->cnPerson = $this->cnUsers[$_GET['i']];
            $this->cnComments = CnComment::getByCondition('person', $_GET['i']);

            include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_users_person.php';
        }
    }

    public function actionTrash()
    {
        $this->cnComments = CnComment::getByCondition('trash');

        $usersListId = array();
        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                if ($val[CN_T_UID] != 0) {
                    $usersListId[] = $val[CN_T_UID];
                }
            }
            $usersListId = implode(array_unique($usersListId), ',');
        }

        if (!empty($usersListId) && is_string($usersListId)) {
            $this->cnUsers = CnUser::getUsersByListId($usersListId);
        }
        $this->cnUsers[0] = $this->cnAdmin;

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_trash.php';
    }

    public function actionSetting()
    {
        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_setting.php';
    }

    public function actionComplaints()
    {
        $this->cnComments = CnComment::getByCondition('complaints');
        $usersListId = array();
        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                if ($val[CN_T_UID] != 0) {
                    $usersListId[] = $val[CN_T_UID];
                }
            }
            $usersListId = implode(array_unique($usersListId), ',');
        }

        if (!empty($usersListId) && is_string($usersListId)) {
            $this->cnUsers = CnUser::getUsersByListId($usersListId);
        }
        $this->cnUsers[0] = $this->cnAdmin;

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_complaints.php';
    }

    public function actionPage_List()
    {
        if (isset($_GET['pid'])) {
            $this->cnComments = CnComment::getByCondition('page', $_GET['pid']);
            $usersListId = array();
            if ($this->cnComments) {
                foreach ($this->cnComments as $key => $val) {
                    if ($val[CN_T_UID] != 0) {
                        $usersListId[] = $val[CN_T_UID];
                    }
                }
                $usersListId = implode(array_unique($usersListId), ',');
            }

            if (!empty($usersListId) && is_string($usersListId)) {
                $this->cnUsers = CnUser::getUsersByListId($usersListId);
            }
            $this->cnUsers[0] = $this->cnAdmin;
        } else {
            if (isset($_GET['f']) && !empty($_GET['f'])) {
                $pageList = CnComment::getPageByFilter(str_replace(CN_PROTOCOL . $_SERVER['HTTP_HOST'], '', urldecode($_GET['f'])));
            } else {
                $pageList = CnComment::getPages(isset($_GET['pl']) ? $_GET['pl'] : 1);
            }
        }

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_pages.php';
    }

    public function actionNew()
    {
        $this->cnComments = CnComment::getByCondition('new');

        $usersListId = array();
        if ($this->cnComments) {
            foreach ($this->cnComments as $key => $val) {
                if ($val[CN_T_UID] != 0) {
                    $usersListId[] = $val[CN_T_UID];
                }
            }
            $usersListId = implode(array_unique($usersListId), ',');
        }

        if (!empty($usersListId) && is_string($usersListId)) {
            $this->cnUsers = CnUser::getUsersByListId($usersListId);
        }
        $this->cnUsers[0] = $this->cnAdmin;

        include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_new.php';
    }

    public function actionChain()
    {
        if (isset($_GET['i']) && !empty($_GET['i'])) {
            $this->cnComments = CnComment::getCommentChain($_GET['i']);

            $usersListId = array();
            if ($this->cnComments) {
                foreach ($this->cnComments as $key => $val) {
                    if ($val[CN_T_UID] != 0) {
                        $usersListId[] = $val[CN_T_UID];
                    }
                }
                $usersListId = implode(array_unique($usersListId), ',');
            }

            if (!empty($usersListId) && is_string($usersListId)) {
                $this->cnUsers = CnUser::getUsersByListId($usersListId);
            }
            $this->cnUsers[0] = $this->cnAdmin;

            include_once $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/views/panel/cn_chain.php';
        }
    }
}