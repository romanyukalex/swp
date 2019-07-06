<?php

class CnUser
{
    /**
     * Кол-во пользователей
     * @return int
     */
    public static function getCount()
    {
        $mysqli = CnDb::getConnect();

        if (isset($_GET['b']) && $_GET['b'] == 'banned') {
            $ban = 1;
        } else {
            $ban = 0;
        }

        $sql = $mysqli->query("SELECT " . CN_T_ID . " FROM " . CN_T_USER . " WHERE " . CN_T_BAN . " = $ban");

        return $sql->num_rows;
    }

    /**
     * Записать гостя в БД
     * @param $items
     * @return int|null
     */
    public static function setGuest($items)
    {
        $mysqli = CnDb::getConnect();

        $result = null;

        $sql = $mysqli->prepare("INSERT INTO " . CN_T_USER . "
            (
			" . CN_T_NAME . ",
			" . CN_T_EMAIL . ",
			" . CN_T_AUTH_VIA . ",
			" . CN_T_AVATAR . ",
			" . CN_T_UIP . ",
			" . CN_T_TOKEN . "
            ) VALUES (?,?,?,?,?,?)
        ");
        $sql->bind_param('ssssss', $items[CN_T_NAME], $items[CN_T_EMAIL], $items[CN_T_AUTH_VIA], $items[CN_T_AVATAR], $items[CN_T_UIP], $items[CN_T_TOKEN]);
        $sql->execute();

        if ($sql->errno == 0) {
            $result = $sql->insert_id;
        }

        return $result;
    }

    /**
     * Удалить пользователя
     * @param $id
     * @return bool|mysqli_result
     */
    public static function setDelete($id)
    {
        $mysqli = CnDb::getConnect();

        $sqlUser = $mysqli->query("DELETE FROM " . CN_T_USER . " WHERE " . CN_T_ID . " = $id LIMIT 1");

        if ($sqlUser) {
            $mysqli->query("DELETE FROM " . CN_T_COMMENTS . " WHERE " . CN_T_UID . " = $id");
            $mysqli->query("DELETE FROM " . CN_T_ANSWER . " WHERE " . CN_T_UID . " = $id");
        }

        return $sqlUser;
    }

    /**
     * Заблокировать пользователя
     * @param $id
     * @return bool|mysqli_result
     */
    public static function setBan($id)
    {
        $mysqli = CnDb::getConnect();

        $sqlUserBan = $mysqli->query("SELECT " . CN_T_BAN . " FROM " . CN_T_USER . " WHERE " . CN_T_ID . " = $id");
        $userBanResult = $sqlUserBan->fetch_assoc();
        if ($userBanResult[CN_T_BAN] == 0) {
            $userBan = 1;
            $userStatus = CN_BLOCKED_STATUS;
        } else {
            $userBan = 0;
            $userStatus = '-';
        }

        $sql = $mysqli->query("UPDATE " . CN_T_USER . " SET " . CN_T_BAN . " = $userBan, " . CN_T_STATUS . " = '$userStatus' WHERE " . CN_T_ID . " = $id");

        return $sql;
    }

    /**
     * Получить всех пользователей
     * @return array|null
     */
    public static function getAll()
    {
        $mysqli = CnDb::getConnect();

        if (isset($_GET['p'])) {
            $pageNum = $_GET['p'];
        } else {
            $pageNum = 1;
        }

        $limit = (CN_SET_LIMIT_USERS_ADMIN * $pageNum) - CN_SET_LIMIT_USERS_ADMIN . ", " . CN_SET_LIMIT_USERS_ADMIN;

        $data = null;
        $sql = $mysqli->query("SELECT * FROM " . CN_T_USER . " WHERE " . CN_T_BAN . " = 0  ORDER BY " . CN_T_DATE_REG . " DESC LIMIT $limit");
        if ($sql) {
            while ($arr = $sql->fetch_assoc()) {
                $data[] = $arr;
            }
        }
        return $data;
    }

    /**
     * Получить заблокированных пользователей
     * @return array|null
     */
    public static function getBanned()
    {
        $mysqli = CnDb::getConnect();

        if (isset($_GET['p'])) {
            $pageNum = $_GET['p'];
        } else {
            $pageNum = 1;
        }

        $limit = (CN_SET_LIMIT_USERS_ADMIN * $pageNum) - CN_SET_LIMIT_USERS_ADMIN . ", " . CN_SET_LIMIT_USERS_ADMIN;

        $data = null;
        $sql = $mysqli->query("SELECT * FROM " . CN_T_USER . " WHERE " . CN_T_BAN . " = 1 ORDER BY " . CN_T_DATE_REG . " DESC LIMIT $limit");
        if ($sql) {
            while ($arr = $sql->fetch_assoc()) {
                $data[] = $arr;
            }
        }
        return $data;
    }

    /**
     * Получить пользователей по списку id
     * @param $listId
     * @return null
     */
    public static function getUsersByListId($listId)
    {
        $mysqli = CnDb::getConnect();

        $result = null;

        if ($listId) {
            $sql = $mysqli->query("SELECT * FROM " . CN_T_USER . " WHERE " . CN_T_ID . " IN($listId)");

            if ($sql) {
                while ($arr = $sql->fetch_assoc()) {
                    $result[$arr[CN_T_ID]] = $arr;
                }
            }
        }

        return $result;
    }

    /**
     * Вся информация о пользователе по id
     * @param $id <p>user id</p>
     * @return array|bool
     */
    public static function getUserById($id)
    {
        if (!is_numeric($id)) {
            return null;
        }

        $mysqli = CnDb::getConnect();
        $sql = $mysqli->prepare("SELECT * FROM " . CN_T_USER . " WHERE " . CN_T_ID . " = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        if (function_exists('mysqli_stmt_get_result')) {
            $result = $sql->get_result();
            return $result->fetch_assoc();
        } else {
            $result = CnGetResult::go($sql);
            return array_shift($result);
        }
    }

    /**
     * Записать Email в БД
     * @param $id
     * @param $email
     * @return bool
     */
    public static function writeEmail($id, $email)
    {
        $mysqli = CnDb::getConnect();
        $sql = $mysqli->prepare("UPDATE " . CN_T_USER . " SET " . CN_T_EMAIL . " = ? WHERE " . CN_T_ID . " = $id");
        $sql->bind_param('s', $email);
        return $sql->execute();
    }

    /**
     * Записать/Обновить информацию о пользователе
     * @param $userData
     * @param $provider
     * @return bool|int Выводит созданный ID
     */
    public static function writeAuth($userData, $provider)
    {
        $result = false;

        $mysqli = CnDb::getConnect();
        $sqlCheck = $mysqli->query("SELECT * FROM " . CN_T_USER . " WHERE " . CN_T_AUTH_VIA . " = '$provider' AND " . CN_T_SID . " = '" . $userData[CN_T_SID] . "' LIMIT 1");

        $userInfo = $sqlCheck->fetch_assoc();

        if (empty($userData[CN_T_EMAIL])) {
            if (!empty($userInfo[CN_T_EMAIL])) {
                $userData[CN_T_EMAIL] = $userInfo[CN_T_EMAIL];
            }
        }

        if ($sqlCheck->num_rows == 0) {
            $sqlAddUser = $mysqli->prepare("INSERT INTO " . CN_T_USER . "
                (
                " . CN_T_SID . ",
				" . CN_T_NAME . ",
				" . CN_T_EMAIL . ",
				" . CN_T_AUTH_VIA . ",
				" . CN_T_AVATAR . ",
				" . CN_T_LINK . ",
				" . CN_T_UIP . ",
				" . CN_T_TOKEN . "
                ) VALUES (?,?,?,?,?,?,?,?)
            ");
            $sqlAddUser->bind_param('ssssssss',
                $userData[CN_T_SID],
                $userData[CN_T_NAME],
                $userData[CN_T_EMAIL],
                $provider,
                $userData[CN_T_AVATAR],
                $userData[CN_T_LINK],
                $_SERVER['REMOTE_ADDR'],
                $userData[CN_T_TOKEN]
            );
            $sqlAddUser->execute();

            if ($sqlAddUser->errno == 0) $result = $sqlAddUser->insert_id;
        } else {
            $sqlUpdateUser = $mysqli->prepare("UPDATE `" . CN_T_USER . "`
                SET 
                `" . CN_T_SID . "` = ?,
                `" . CN_T_NAME . "` = ?,
                `" . CN_T_EMAIL . "` = ?,
				`" . CN_T_AVATAR . "` = ?,
				`" . CN_T_LINK . "` = ?,
				`" . CN_T_UIP . "` = ?,
				`" . CN_T_TOKEN . "` = ?
				WHERE
				`" . CN_T_SID . "` = '" . $userData[CN_T_SID] . "'
            ");
            $sqlUpdateUser->bind_param('sssssss',
                $userData[CN_T_SID],
                $userData[CN_T_NAME],
                $userData[CN_T_EMAIL],
                $userData[CN_T_AVATAR],
                $userData[CN_T_LINK],
                $_SERVER['REMOTE_ADDR'],
                $userData[CN_T_TOKEN]
            );
            $sqlUpdateUser->execute();

            $userId = $userInfo[CN_T_ID];

            if ($sqlUpdateUser->errno == 0) $result = $userId;
        }

        return $result;
    }

    /**
     * Проверяет наличие параметров сессии для авторизации
     * @return bool
     */
    public static function checkAuthorize()
    {
        CnSession::start();

        if (isset($_SESSION[CN_S_USER_ID]) && isset($_SESSION[CN_S_TOKEN])) {
            $checkUser = CnUser::getUserById($_SESSION[CN_S_USER_ID]);
            if ($checkUser == null) {
                return false;
            }
            return 'user';
        } elseif (isset($_SESSION[CN_S_LOGGED_ADMIN]) && isset($_SESSION[CN_S_USER_ID]) && $_SESSION[CN_S_USER_ID] === 0) {
            return 'admin';
        } else {
            return false;
        }
    }

    /**
     * Проверка токена
     * @param $userId
     * @param $token
     * @return bool
     */
    public static function checkToken($userId, $token)
    {
        $mysqli = CnDb::getConnect();

        $sql = $mysqli->prepare("SELECT COUNT(*) as count FROM " . CN_T_USER . " WHERE " . CN_T_ID . " = ? AND " . CN_T_TOKEN . " = ?");
        $sql->bind_param('is', $userId, $token);
        $sql->execute();

        if (function_exists('mysqli_stmt_get_result')) {
            $result = $sql->get_result();
            $result = $result->fetch_assoc();
        } else {
            $result = CnGetResult::go($sql);
            $result = array_shift($result);
        }
        return $result['count'];
    }

    /**
     * Записывает информацию в сессию и куки после авторизации пользователя
     * @param $uid <p>user id</p>
     * @param $utc <p>token</p>
     * @return bool
     */
    public static function userLogin($uid, $utc)
    {
        CnSession::start();

        unset($_SESSION[CN_S_LOGGED_ADMIN]);

        $_SESSION[CN_S_USER_ID] = $uid;
        $_SESSION[CN_S_TOKEN] = $utc;
        
        setcookie(CN_S_USER_ID, $uid, time() + 60 * 60 * 24 * (int)CN_COOKIE_TIME, '/', CN_COOKIE_DOMAIN);
        setcookie(CN_S_TOKEN, $utc, time() + 60 * 60 * 24 * (int)CN_COOKIE_TIME, '/', CN_COOKIE_DOMAIN);

        return true;
    }

    /**
     * Записывает информацию в сессию и куки после авторизации администратора
     * @return bool
     */
    public static function adminLogin()
    {
        CnSession::start();

        unset($_SESSION[CN_S_TOKEN]);

        setcookie(CN_S_USER_ID, '', time() - 3600, '/', CN_COOKIE_DOMAIN);
        setcookie(CN_S_TOKEN, '', time() - 3600, '/', CN_COOKIE_DOMAIN);

        $_SESSION[CN_S_LOGGED_ADMIN] = 'yes';
        $_SESSION[CN_S_USER_ID] = 0;

        return true;
    }

    /**
     * @return bool
     */
    public static function logout()
    {
        CnSession::start();

        unset($_SESSION[CN_S_USER_ID]);
        unset($_SESSION[CN_S_TOKEN]);
        unset($_SESSION[CN_S_LOGGED_ADMIN]);

        setcookie(CN_S_USER_ID, '', time() - 3600, '/', CN_COOKIE_DOMAIN);
        setcookie(CN_S_TOKEN, '', time() - 3600, '/', CN_COOKIE_DOMAIN);

        return true;
    }
}