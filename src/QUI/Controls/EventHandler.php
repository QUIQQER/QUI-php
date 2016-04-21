<?php

/**
 * This file contains \QUI\Controls\EventHandler
 */

namespace QUI\Controls;

use QUI;

/**
 * Class Control
 *
 * @package QUI\Controls
 */
class EventHandler
{
    /**
     * @param $Smarty
     */
    public static function onSmartyInit(\Smarty $Smarty)
    {
        // {qui control=""}
        if (!isset($Smarty->registered_plugins['function'])
            || !isset($Smarty->registered_plugins['function']['qui'])
        ) {
            $Smarty->registerPlugin("function", "qui", "\\QUI\\Controls\\EventHandler::smartyHelper");
        }
    }

    /**
     * Smarty helper {qui control=""}
     *
     * @param $params
     * @param $Smarty
     * @return string|mixed
     */
    public static function smartyHelper($params, \Smarty_Internal_Template $Smarty)
    {
        if (!isset($params['control'])) {
            return '';
        }

        try {
            if (!class_exists($params['control'])) {
                throw new QUI\Exception('Control not found: ' . $params['control']);
            }

            /* @var $Control \QUI\Control */
            $Control = new $params['control']();

        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeException($Exception);
            return '';
        }


        $assign = isset($params['assign']) ? $params['assign'] : false;

        if (!$assign) {
            if (method_exists($Control, 'create')) {
                try {
                    return $Control->create();

                } catch (QUI\Exception $Exception) {
                    QUI\System\Log::writeException($Exception);
                }
            }

            return '';
        }

        $Smarty->assign($assign, $Control);
        return '';
    }
}
