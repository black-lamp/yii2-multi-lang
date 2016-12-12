`<?php
use bl\multilang\entities\Language;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @author Vyacheslav Nozhenko <vv.nojenko@gmail.com>
 *
 * @var \yii\web\View $this
 * @var Language $current
 * @var Language[] $languages
 * @var array $options
 */

?>
<div class="btn-group dropdown-languages">
    <button data-toggle="dropdown" class="<?= ArrayHelper::getValue($options, 'class') ?>">
        <span><?= Yii::t('languages', $current->name) ?></span>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu pull-right">
        <?php foreach ($languages as $language): ?>
            <li>
                <?= Html::a(Yii::t('languages', $language->name), Url::to(array_merge(
                    ['/' . Yii::$app->controller->getRoute()],
                    Yii::$app->request->getQueryParams(),
                    ['language' => $language->lang_id]))
                ); ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>