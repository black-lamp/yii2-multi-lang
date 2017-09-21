<?php

namespace bl\multilang\entities;

use Yii;
use yii\db\ActiveRecord;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 *
 * @property number id
 * @property string name
 * @property string lang_id
 * @property boolean show
 * @property boolean active
 * @property boolean default
 */
class Language extends ActiveRecord {

    private static $_currentLangCode;
    private static $_currentLang;
    private static $_defaultLang;

    public static function tableName() {
        return 'language';
    }

    /**
     * @return Language
     */
    public static function getDefault() {
        if(empty(self::$_defaultLang)) {
            self::$_defaultLang = Language::findOne([
                'default' => true
            ]);
        }
        return self::$_defaultLang;
    }

    /**
     * @return Language Current language, or default
     */
    public static function getCurrent() {
        if(empty(self::$_currentLang) || self::$_currentLangCode != Yii::$app->language) {
            self::$_currentLangCode = Yii::$app->language;
            self::$_currentLang = Language::findOne([
                'lang_id' => self::$_currentLangCode
            ]);
        }
        if(empty(self::$_currentLang)) {
            return static::getDefault();
        }
        return self::$_currentLang;
    }

    public static function findOrDefault($languageId) {
        if (empty($languageId) || !$language = Language::findOne($languageId)) {
            $language = Language::find()
                ->where(['lang_id' => \Yii::$app->sourceLanguage])
                ->one();
        }
        return $language;
    }

}
