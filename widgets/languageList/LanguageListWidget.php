<?php

namespace bl\multilang\widgets\languageList;

use bl\multilang\entities\Language;
use Yii;
use yii\base\Widget;

/**
 * Description of LanguageList
 *
 * @author RuslanSaiko
 */
class LanguageListWidget extends Widget
{
    /**
     * @var bool Is showing current language.
     */
    public $showCurrent = false;

    /**
     * @var array Options.
     */
    public $options = ['class' => 'btn btn-sm btn-warning dropdown-toggle'];

    /**
     * @inheritdoc
     */
    public function run()
    {
        $current = Language::getCurrent();
        $query = Language::find()->where(['active' => true]);

        if (!$this->showCurrent) {
            $query->andWhere(['<>', 'id', $current->id]);
        }

        $languages = $query->all();

        return $this->render('list', [
            'current' => $current,
            'languages' => $languages,
            'options' => $this->options
        ]);
    }

}
