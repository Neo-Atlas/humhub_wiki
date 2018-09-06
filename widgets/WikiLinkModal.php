<?php


namespace humhub\modules\wiki\widgets;


use humhub\widgets\Modal;
use Yii;

class WikiLinkModal extends Modal
{
    public function init()
    {
        $this->header = Yii::t('WikiModule.base', '<strong>Set</strong> wiki link');
        $this->body = $this->render('wikiLinkModal');
        parent::init(); // TODO: Change the autogenerated stub
    }

}