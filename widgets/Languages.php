<?php
namespace bl\multilang\widgets;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

use bl\multilang\entities\Language;

/**
 * Widget for render of dropdown list with languages in ActiveForm
 *
 * Example
 * ```php
 * $form = \yii\widgets\ActiveForm::begin();
 * $form->field($model, 'languageId')
 *      ->widget(\bl\multilang\widgets\Languages::class);
 * $form->end();
 * ```
 *
 * @property array $condition
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class Languages extends InputWidget
{
    /**
     * @var array the condition for getting of languages from database
     */
    public $condition = [
        'active' => true,
        'show' => true
    ];

    /**
     * @var Language[]
     */
    private $_languages;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_languages = Language::findAll($this->condition);

        if (empty($this->options['class'])) {
            $this->options['class'] = 'form-control';
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        return Html::activeDropDownList(
            $this->model,
            $this->attribute,
            ArrayHelper::map($this->_languages, 'id', 'name'),
            $this->options
        );
    }
}
