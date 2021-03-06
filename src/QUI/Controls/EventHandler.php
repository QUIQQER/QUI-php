<?php

/**
 * This file contains \QUI\Controls\EventHandler
 */

namespace QUI\Controls;

use QUI;

/**
 * Class Control
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
                throw new QUI\Exception('Control not found: '.$params['control']);
            }

            /* @var $Control QUI\Controls\Control */
            $Control = new $params['control']();
            unset($params['control']);
        } catch (QUI\Exception $Exception) {
            QUI\System\Log::writeException($Exception);

            return '';
        }

        if (isset($params['styles'])
            && method_exists($Control, 'setStyles')
        ) {
            $Control->setStyles(
                QUI\Utils\StringHelper::splitStyleAttributes($params['styles'])
            );
        }


        $assign = isset($params['assign']) ? $params['assign'] : false;

        $Control->setAttributes($params);


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
