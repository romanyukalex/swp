<?php

class CnPanel
{
    /**
     * Записать настройки в файл
     * @param $items
     * @param $settingFail
     * @return int|null
     */
    public static function setCommon($items, $settingFail)
    {
        
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . CN_FOLDER_SCRIPT . '/config/'.$settingFail;

        $result = null;
        if (is_writable($filePath)) {
            $fileData = file($filePath);
            if ($fileData) {
                foreach ($fileData as $key => $val) {
                    foreach ($items as $i => $v) {
                        $i = strtoupper($i);
                        if (preg_match("/define\('$i', (.+)\);/iu", $val, $match)) {
                            $fileData = str_replace($match[0], "define('$i', '$v');", $fileData);
                        }
                    }
                } 
            }
            $result = file_put_contents($filePath, $fileData);
        }

        return $result;
    }
}