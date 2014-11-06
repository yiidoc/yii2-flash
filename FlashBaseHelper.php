<?php
namespace yii\flash;

use yii\base\Component;
use Yii;

class FlashBaseHelper extends Component
{
    const ALERT_SUCCESS = 'success';
    const ALERT_INFO = 'info';
    const ALERT_WARNING = 'warning';
    const ALERT_DANGER = 'danger';

    /**
     * @param string $message
     * @param string $type
     *
     * ```
     * use yii\flash\Flash;
     *
     * Flash::alert(Flash::ALERT_SUCCESS,'Alert message ...');
     * ```
     */
    public static function alert($type, $message)
    {
        if (Yii::$app->session->hasFlash($type)) {
            $hasMessage = (array)Yii::$app->session->getFlash($type);
            array_push($hasMessage, $message);
            $message = $hasMessage;
        }
        Yii::$app->session->setFlash($type, $message);
    }
} 