<?php
namespace yii\flash;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

/**
 * Class Alert
 * @package yii\flash
 *
 * ```php
 * use yii\flash\Alert;
 *
 * echo Alert::widget();
 * ```
 *
 * ```html
 * <?=\yii\flash\Alert::widget();?>
 * ```
 */
class Alert extends Widget
{
    public $options = [];
    public $closeButton = [];

    protected $definedTypes = ['success', 'info', 'warning', 'danger'];
    private $_alerts = [];

    public function init()
    {
        $allFlash = Yii::$app->session->getAllFlashes();
        foreach ($this->definedTypes as $type) {
            if (array_key_exists($type, $allFlash)) {
                if (is_array($allFlash[$type])) {
                    foreach ($allFlash[$type] as $message) {
                        $this->setAlert($type, $message);
                    }
                } else {
                    $this->setAlert($type, $allFlash[$type]);
                }
                Yii::$app->session->removeFlash($type);
            }
        }
    }

    public function run()
    {
        foreach ($this->getAlerts() as $alert) {
            if (isset($this->options['class'])) {
                Html::addCssClass($this->options, 'alert');
                Html::addCssClass($this->options, 'alert-' . $alert['type']);
            } else {
                $this->options['class'] = 'alert alert-' . $alert['type'];
            }
            echo \yii\bootstrap\Alert::widget([
                'closeButton' => $this->closeButton,
                'options' => $this->options,
                'body' => $alert['body'],
            ]);
        }
    }

    public function getAlerts()
    {
        return $this->_alerts;
    }

    public function setAlert($type, $message)
    {
        $this->_alerts[] = ['type' => $type, 'body' => $message];
    }
} 