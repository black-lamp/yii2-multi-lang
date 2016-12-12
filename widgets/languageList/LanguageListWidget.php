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
     * @var array Options.
     */
    public $options = ['class' => 'btn btn-sm btn-warning dropdown-toggle'];

    /**
     * @inheritdoc
     */
    public function run() {
        $current = Language::getCurrent();
        $languages = Language::find()
            ->where(['active' => true])
            ->andWhere(['<>', 'id', $current->id])
            ->all();

        return $this->render('list', [
            'current' => $current, 
            'languages' => $languages,
            'options' => $this->options
        ]);
    }

}
