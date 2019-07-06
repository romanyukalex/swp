<?php

class CnSession
{
    public static function start()
    {
        /********** Сессии для Joomla *******/
        if (CN_SET_SESSION == 'joomla') {
            @define('_JEXEC', 1);
            @define('DS', DIRECTORY_SEPARATOR);
            @define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);

            $pathDefines = JPATH_BASE . DS . 'includes' . DS . 'defines.php';
            $pathFramework = JPATH_BASE . DS . 'includes' . DS . 'framework.php';

            if (file_exists($pathDefines) && file_exists($pathFramework)) {
                @require_once($pathDefines);
                @require_once($pathFramework);

                $mainframe = JFactory::getApplication('site');
                $mainframe->initialise();
            }
        }


        /********** Сессии для MODX REVO ********/
        if (CN_SET_SESSION == 'modxrevo') {
            if (!defined('MODX_API_MODE')) {
                define('MODX_API_MODE', true);
            }

            $pathConfigCore = $_SERVER['DOCUMENT_ROOT'] . '/config.core.php';
            $pathModxClass = $_SERVER['DOCUMENT_ROOT'] . '/core/model/modx/modx.class.php';

            if (file_exists($pathConfigCore) && file_exists($pathModxClass)) {
                @include($pathConfigCore);
                @include_once($pathModxClass);
                $modx = new modX();
                $modx->initialize('web');
            }
        }


        /********** Сессии для MODX EVO ********/
        if (CN_SET_SESSION == 'modxevo') {

            register_shutdown_function(function () {
                $error = error_get_last();
                if (!is_null($error)) {
                    if (preg_match('/MODX_CLI/iu', $error['message'])) {
                        echo '<br><br><p><strong>MODX is not configured for "Commenton". Read the manual - <strong style="color: red;">commenton/manual/CMS/ModxEvo.txt</strong>.</strong></p>';
                    }
                }
            });

            define('COMMENTON_ENABLE', true);

            $pathConfigInc = $_SERVER['DOCUMENT_ROOT'] . '/manager/includes/config.inc.php';

            if (file_exists($pathConfigInc)) {
                @include $pathConfigInc;
                @startCMSSession();
            }
        }


        /********** Сессии для Hostcms ********/
        if (CN_SET_SESSION == 'hostcms') {
            $pathBootstrap = $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

            if (file_exists($pathBootstrap)) {
                @include $pathBootstrap;
                @Core_Session::start();
            }
        }


        /********** Сессии для Bitrix ********/
        if (CN_SET_SESSION == 'bitrix') {
            $pathPrologBefore = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

            if (file_exists($pathPrologBefore)) {
                @require $pathPrologBefore;
                @CModule::IncludeModule('security');
                @CSecuritySession::activate();
            }
        }


        /********* Стандартные сессии *******/
        @session_start();
    }
}