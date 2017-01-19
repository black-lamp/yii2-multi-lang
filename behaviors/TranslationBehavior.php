<?php
namespace bl\multilang\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecordInterface;

use bl\multilang\entities\Language;

/**
 * Class SeoDataBehavior
 *
 * Configuration example:
 * Add this behavior to your ActiveRecord model
 * ```php
 *  public function behaviors() {
 *      return [
 *              'translation' => [
 *              'class' => TranslationBehavior::className(),
 *              'translationClass' => ArticleTranslation::className(),
 *              'relationColumn' => 'articleId'
 *              'languageColumn' => 'languageId'
 *          ]
 *      ];
 *  }
 * ```
 * @property ActiveRecordInterface $owner
 * @property string $translationClass
 * @property string $relationColumn
 * @property string $languageColumn
 *
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 * @package bl\multilang\behaviors
 */
class TranslationBehavior extends Behavior
{
    /**
     * @var string
     */
    public $translationClass;
    /**
     * @var string
     */
    public $relationColumn;
    /**
     * @var string
     */
    public $languageColumn = 'language_id';


    /**
     * Method for getting translation from database
     * 
     * @param null|integer $languageId
     */
    public function getTranslation($languageId = null)
    {
        /* @var $modelClass ActiveRecordInterface */
        $modelClass = $this->translationClass;

        if(!empty($languageId)) {
            /* @var $language ActiveRecordInterface */
            if($language = Language::findOne($languageId)) {
                /* @var $translation ActiveRecordInterface */
                $translation = $modelClass::findOne([
                    $this->languageColumn => $language->getPrimaryKey(),
                    $this->relationColumn => $this->owner->getPrimaryKey()
                ]);
                
                return $translation;
            }
        }

        $language = Language::findOne(['lang_id' => Yii::$app->language]);

        // try to find translation on current language
        $translation = $modelClass::findOne([
            $this->languageColumn => $language->getPrimaryKey(),
            $this->relationColumn => $this->owner->getPrimaryKey()
        ]);

        if(!$translation) {
            // get default language
            $language = Language::findOne(['default' => true]);

            // try to find translation on default language
            $translation =  $modelClass::findOne([
                $this->languageColumn => $language->getPrimaryKey(),
                $this->relationColumn => $this->owner->getPrimaryKey()
            ]);

            if(!$translation) {
                // find any translation
                $translation =  $modelClass::findOne([
                    $this->relationColumn => $this->owner->getPrimaryKey()
                ]);
            }
        }

        return $translation;
    }
}
