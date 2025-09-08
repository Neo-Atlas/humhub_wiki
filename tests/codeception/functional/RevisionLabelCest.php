<?php

namespace wiki\functional;

use humhub\modules\space\models\Space;
use humhub\modules\wiki\helpers\Url;
use humhub\modules\wiki\models\WikiPage;
use humhub\modules\wiki\Module;
use humhub\modules\user\models\User;
use wiki\FunctionalTester;
use Yii;

class RevisionLabelCest
{
    public function testRevisionLabelEnabled(FunctionalTester $I) 
    {
        $I->wantTo('check Revision Label system enabled');
        $space = $I->loginBySpaceUserGroup(Space::USERGROUP_ADMIN);
        $I->enableModule($space->guid, 'wiki');
        $page = $I->createWiki($space, 'Test Wiki Page', 'Test Wiki Page content');
        $I->amOnSpace($space->guid, '/wiki/page/view', ['id' => $page->id, 'title' => $page->title]);
        $I->see("Revision A");
    }

    public function testRevisionLabelDisabled(FunctionalTester $I) 
    {
        $I->wantTo('check Revision Label system disabled');
        $space = $I->loginBySpaceUserGroup(Space::USERGROUP_ADMIN);
        $I->enableModule($space->guid, 'wiki');
        $I->amOnSpace($space, '/wiki/page/edit');
        $I->fillField('WikiPage[title]', "This is a test page");
        $I->fillField('WikiPageRevision[content]', "This is the content");
        $I->uncheckOption('#pageeditform-revisionlabelenabled');
        $I->saveWiki();
        $I->dontSee("Revision A");
    }
}