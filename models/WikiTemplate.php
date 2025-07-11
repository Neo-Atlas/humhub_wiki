<?php

namespace humhub\modules\wiki\models;

use humhub\components\ActiveRecord;
use humhub\modules\space\models\Space;
use humhub\modules\content\models\ContentContainer;
use humhub\modules\content\widgets\richtext\ProsemirrorRichText;
use Yii;

/**
 * Class WikiTemplate
 *
 * @property int $id
 * @property int|null $contentcontainer_id  (nullable because Global templates = NULL)
 * @property string $title
 * @property string|null $content
 * @property string|null $appendable_content
 * @property boolean|false $is_appendable
 */
class WikiTemplate extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wiki_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['content', 'title_template', 'appendable_content'], 'string'],
            [['contentcontainer_id'], 'integer'],
            [['placeholders', 'appendable_content_placeholder'], 'safe'],
            [['is_appendable'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('WikiModule.base', 'Title'),
            'content' => Yii::t('WikiModule.base', 'Content'),
            'title_template' => Yii::t('WikiModule.base', 'Title Template'),
            'is_appendable' => Yii::t('WikiModule.base', 'Is Appendable'),
            'appendable_content' => Yii::t('WikiModule.base', 'Appendable Content'),
            'placeholders' => Yii::t('WikiModule.base', 'Placeholders'),
        ];
    }

    /**
     * Contentcontainer support (Space/User)
     */
    public function getContentName()
    {
        return $this->title;
    }

    public function getContentDescription()
    {
        return Yii::t('WikiModule.base', 'Wiki Template');
    }

    public function getContentContainer()
    {
        return $this->hasOne(ContentContainer::class, ['id' => 'contentcontainer_id']);
    }

    /**
     * Converting normal text into Richtext and storing in database
     */
    public function afterSave($insert, $changedAttributes)
    {
        ProsemirrorRichText::postProcess($this->content, $this);
        ProsemirrorRichText::postProcess($this->appendable_content, $this);
        
        parent::afterSave($insert, $changedAttributes);
    }
}

