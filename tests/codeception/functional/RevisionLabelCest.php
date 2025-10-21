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

    public function testRevisionIncrement(FunctionalTester $I) 
    {
        $I->wantTo('check Revision Label increment');
        $space = $I->loginBySpaceUserGroup(Space::USERGROUP_ADMIN);
        $I->enableModule($space->guid, 'wiki');
        $page = $I->createWiki($space, 'Test Wiki Page', 'Test Wiki Page content');
        $I->amOnSpace($space->guid, '/wiki/page/view', ['id' => $page->id, 'title' => $page->title]);
        $I->see("Revision A");

        $I->click('Edit');
        $I->fillField('WikiPageRevision[content]', "This is the updated content");
        $I->fillField('PageEditForm[saveAsNewRevision]', 1);
        $I->saveWiki();

        $I->see("Revision B");
    }

    public function testRevisionLabelNoincrement(FunctionalTester $I) 
    {
        $I->wantTo('check Revision Label no increment when not saving as new revision also check content update');
        $space = $I->loginBySpaceUserGroup(Space::USERGROUP_ADMIN);
        $I->enableModule($space->guid, 'wiki');
        $page = $I->createWiki($space, 'Test Wiki Page', 'Test Wiki Page content');
        $I->amOnSpace($space->guid, '/wiki/page/view', ['id' => $page->id, 'title' => $page->title]);
        $I->see("Revision A");

        $I->click('Edit');
        $I->fillField('WikiPageRevision[content]', "This is the updated content");
        $I->fillField('PageEditForm[saveAsNewRevision]', 0);
        $I->saveWiki();

        $I->see("Revision A");
        $I->see("This is the updated content");
    }

    public function testHideMinorchangesToggleButton(FunctionalTester $I) 
    {
        $I->wantTo('check Hide Minor Changes toggle button');
        $space = $I->loginBySpaceUserGroup(Space::USERGROUP_ADMIN);
        $I->enableModule($space->guid, 'wiki');
        $page = $I->createWiki($space, 'Test Wiki Page', 'Test Wiki Page content');
        $I->amOnSpace($space->guid, '/wiki/page/view', ['id' => $page->id, 'title' => $page->title]);
        $I->see("Revision A");

        $I->click('Edit');
        $I->fillField('WikiPageRevision[content]', "This is the updated content");
        $I->fillField('PageEditForm[saveAsNewRevision]', 1);
        $I->saveWiki();
        $I->see("Revision B");

        $I->click('Edit');
        $I->fillField('WikiPageRevision[content]', "This is the second updated content");
        $I->fillField('PageEditForm[saveAsNewRevision]', 0);
        $I->saveWiki();
        $I->see("Revision B");
        $I->see("This is the second updated content");

        $I->amOnSpace($space->guid, '/wiki/page/history', ['id' => $page->id]);
        $I->see("Hide minor changes");
        $I->seeNumberOfElements('ul.wiki-page-history > li', 3);
        $I->click("Hide minor changes");
        $I->see("Show minor changes");
        $I->seeNumberOfElements('ul.wiki-page-history > li', 2);
        $I->click("Show minor changes");
        $I->see("Hide minor changes");
        
    }
}