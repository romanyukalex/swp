<?php

class CnShare
{
    public function getLink($url = null, $title = null, $text = null, $image = null)
    {
        $url = urlencode($url);
        $title = urlencode($title);
        $image = urlencode($image);

        return '<span class="cn_vk_share" title="' . CN_VK_RU . '"
               data-cn-sh="http://vk.com/share.php?url=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '&title=' . $title . ':%20' . urlencode(mb_strimwidth(strip_tags(htmlspecialchars_decode($text)), 0, 500, '...', CN_SET_ENCODING)) . '&image=' . $image . '&noparse=true"></span>
            <span class="cn_ok_share" title="' . CN_OK_RU . '"
               data-cn-sh="https://connect.ok.ru/offer?url=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '"></span>
            <span class="cn_fb_share" title="' . CN_FACEBOOK . '"
               data-cn-sh="https://www.facebook.com/sharer/sharer.php?u=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '&picture=' . $image . '"></span>
            <span class="cn_g_share" title="' . CN_GOOGLE . ' +"
               data-cn-sh="https://plus.google.com/share?url=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '"></span>
            <span class="cn_mm_share" title="' . CN_MY_MAIL_RU . '"
               data-cn-sh="http://connect.mail.ru/share?url=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '&title=' . $title . '&description=' . urlencode(mb_strimwidth(strip_tags(htmlspecialchars_decode($text)), 0, 500, '...', CN_SET_ENCODING)) . '&image_url=' . $image . '"></span>
            <span class="cn_tw_share" title="' . CN_TWITTER . '"
               data-cn-sh="https://twitter.com/share?url=' . CN_PROTOCOL . $_SERVER['HTTP_HOST'] . $url . '&text=' . $title . ':%20' . urlencode(mb_strimwidth(strip_tags(htmlspecialchars_decode($text)), 0, 200, '...', CN_SET_ENCODING)) . '"></span>';
    }
}