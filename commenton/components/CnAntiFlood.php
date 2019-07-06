<?php

/*
 * Если Пользователь ввел больше $countFlood сообщений в течении $timeFloodStart сеунд,
 * следующие сообщения он сможет отправлять с промежутком в $timeFloodMeter секунд,
 * по истечению $timeFloodEnd секунд, счетчик сбрасывается.
 */
class CnAntiFlood
{
    public $timeFloodStart = 10; // Промежуток между сообщениями
    public $timeFloodEnd = 300; // Общее время действия тыймера
    public $timeFloodMeter = 60; // Время блокировки сообщений
    public $countFlood = 2; // Кол-во сообщений до включения
    
    public function check()
    {
        if(!isset($_SESSION[CN_S_LOGGED_ADMIN])) {
            if (isset($_SESSION[CN_S_COUNT_FLOOD]) && $_SESSION[CN_S_COUNT_FLOOD] >= $this->countFlood) {
                if (isset($_SESSION[CN_S_TIME_FLOOD]) && $_SESSION[CN_S_TIME_FLOOD] + $this->timeFloodMeter > time()) {
                    $timeFlood = $_SESSION[CN_S_TIME_FLOOD] + $this->timeFloodMeter - time();
                    $notice[0] = 'flood';
                    $notice[1] = sprintf(CN_WAIT_SEC, $timeFlood);
                    return $notice;
                }
            }
        }
        return true;
    }

    public function set()
    {
        if(!isset($_SESSION[CN_S_LOGGED_ADMIN])) {
            if (isset($_SESSION[CN_S_TIME_FLOOD])) {
                if (time() - $_SESSION[CN_S_TIME_FLOOD] < $this->timeFloodStart) {
                    if (isset($_SESSION[CN_S_COUNT_FLOOD])) {
                        $_SESSION[CN_S_COUNT_FLOOD]++;
                    } else {
                        $_SESSION[CN_S_COUNT_FLOOD] = 1;
                    }
                } elseif (time() - $_SESSION[CN_S_TIME_FLOOD] > $this->timeFloodEnd) {
                    unset($_SESSION[CN_S_COUNT_FLOOD]);
                }
            }
            $_SESSION[CN_S_TIME_FLOOD] = time();
        }
    }
}