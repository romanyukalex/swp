<?php

class CnPagination
{
    private $countItems;
    private $limitItems = CN_SET_LIMIT_COMMENTS_ADMIN;
    private $pageKey = 'p=';
    private $sumPage = 8; //Кол-во отображаемых кнопок

    /**
     * CnPagination constructor.
     * @param $type 'moderation' or 'trash' or 'complaints' or 'common' or 'users' or 'page' or 'person' or 'new'
     * @param null $param 'if($type == person) uid' or 'if($type == page) pid'
     */
    public function __construct($type, $param = null)
    {
        if ($type === 'users') {
            $this->countItems = CnUser::getCount();
            $this->limitItems = CN_SET_LIMIT_USERS_ADMIN;
        } elseif ($type === 'page_list') {
            $this->countItems = CnComment::getPagesCount();
            $this->limitItems = CN_SET_LIMIT_PAGE_LIST;
            $this->pageKey = 'pl=';
        } else {
            $this->countItems = CnComment::getCountByCondition($type, $param);
        }

    }

    public function navigationView($categoryUri = null)
    {
        $cP = ceil($this->countItems / $this->limitItems);

        if (($this->sumPage % 2) == 0) $this->sumPage = $this->sumPage - 1;
        $sumPageDouble = floor($this->sumPage / 2);

        $numPageNow = null;
        if (isset($_GET[trim($this->pageKey, '=')])) {
            $numPageNow = $_GET[trim($this->pageKey, '=')];
        }

        if ($this->countItems > $this->limitItems) {
            echo '<div class="cn_block_pagination">';
            for ($i = 1; $i < $cP + 1; $i++) {
                $select = null;

                if ($i == 1) $link = rtrim($categoryUri, '?&');
                else $link = $categoryUri . $this->pageKey . $i;

                if ($i == $numPageNow || $i == 1 && empty($numPageNow)) $select = 'style="background:#0c9ec8;"';

                if ($i == 1 && $i < ($numPageNow) - $sumPageDouble) {
                    echo '<a href="' . $link . '">' . CN_BY_THE_BEGINNING . '</a>';
                }
                if ($i < ($numPageNow) - $sumPageDouble && $i < $cP - ($sumPageDouble * 2)) {
                    continue;
                }


                echo '<a ' . $select . ' href="' . $link . '">' . $i . '</a>';


                if ($i >= $numPageNow + $sumPageDouble && $i >= $this->sumPage && $i < $cP) {
                    echo '<a href="' . $categoryUri . $this->pageKey . $cP . '">' . CN_TO_THE_END . '</a>';
                }
                if ($i >= $numPageNow + $sumPageDouble && $i >= $this->sumPage) {
                    break;
                }
            }
            echo '</div>';
        }
    }

}