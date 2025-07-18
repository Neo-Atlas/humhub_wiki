<?php

use yii\helpers\Html;
use humhub\modules\wiki\helpers\Url;
use humhub\widgets\Button;
use humhub\widgets\Link;
use humhub\modules\wiki\widgets\WikiContent;
use humhub\modules\wiki\assets\Assets;

/** @var $templates \humhub\modules\wiki\models\WikiTemplate[] */
/** @var $contentContainer \humhub\modules\content\components\ContentContainerActiveRecord */

$this->title = Yii::t('WikiModule.base', 'Manage Templates');
Assets::register($this);
?>

<div class="panel panel-default">
    <div class="panel-body">
        <?php WikiContent::begin(['cssClass' => 'wiki-page-content']) ?>
            <div class="wiki-headline">
                <div class="wiki-headline-top">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?= Button::primary(Yii::t('WikiModule.base', 'Create Template'))->link(Url::toWikiTemplateCreate())->icon('plus')->sm(); ?>
                </div>
            </div>
            <ul class="wiki-template-list">
                <?php foreach ($templates as $template): ?>
                    <li class="wiki-template-category-list-item d-flex justify-content-between align-items-center">
                        <span class="template-title"><?=$template->title?></span>
                        <span class="template-actions">
                            <?= Button::asLink(null, Url::toWikiTemplateEdit($template, $container))->icon('fa-pencil')
                                ->cssClass('wiki-page-control tt wiki-category-add edit-template')
                                ->title(Yii::t('WikiModule.base', 'Edit Template')) ?>
                            <?= Button::asLink(null, Url::toWikiTemplateDelete($template, $container))->icon('fa-trash-o')
                                ->cssClass('wiki-page-control tt wiki-category-add delete-template')
                                ->title(Yii::t('WikiModule.base', 'Delete Template'))->confirm(Yii::t('WikiModule.base', 'Are you sure you want to delete this template?')); ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php WikiContent::end() ?>
    </div>
</div>
