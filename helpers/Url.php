<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2018 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\wiki\helpers;

use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\helpers\ContentContainerHelper;
use humhub\modules\wiki\models\WikiPage;
use humhub\modules\wiki\models\WikiPageRevision;
use humhub\modules\wiki\models\WikiTemplate;

/**
 * Class Url
 */
class Url extends \yii\helpers\Url
{
    public const ROUTE_HOME = '/wiki/overview/index';
    public const ROUTE_OVERVIEW = '/wiki/overview/list-categories';
    public const ROUTE_LAST_EDITED = '/wiki/overview/last-edited';
    public const ROUTE_SEARCH = '/wiki/overview/search';
    public const ROUTE_UPDATE_FOLDING_STATE = '/wiki/overview/update-folding-state';
    public const ROUTE_WIKI_PAGE = '/wiki/page/view';
    public const ROUTE_WIKI_ENTRY = '/wiki/page/entry';
    public const ROUTE_WIKI_EDIT = '/wiki/page/edit';
    public const ROUTE_WIKI_DELETE = '/wiki/page/delete';
    public const ROUTE_WIKI_HISTORY = '/wiki/page/history';
    public const ROUTE_WIKI_DIFF = '/wiki/page/diff';
    public const ROUTE_WIKI_DIFF_EDITING = '/wiki/page/diff-editing';
    public const ROUTE_WIKI_REVERT = '/wiki/page/revert';
    public const ROUTE_EXTRACT_TITLES = '/wiki/page/headlines';
    public const ROUTE_WIKI_MERGE = '/wiki/page/merge';
    public const ROUTE_WIKI_CREATE_COPY = '/wiki/page/create-copy';
    public const ROUTE_WIKI_EDITING_STATUS = '/wiki/page/editing-status';
    public const ROUTE_WIKI_EDITING_TIMER_UPDATE = '/wiki/page/editing-timer-update';
    public const ROUTE_WIKI_GET_TEMPLATE_CONTENT = '/wiki/template/get-template-content';
    public const ROUTE_WIKI_TEMPLATE_INDEX = '/wiki/template/index';
    public const ROUTE_WIKI_TEMPLATE_CREATE = '/wiki/template/create';
    public const ROUTE_WIKI_TEMPLATE_EDIT = '/wiki/template/edit';
    public const ROUTE_WIKI_TEMPLATE_DELETE = '/wiki/template/delete';
    public const ROUTE_WIKI_APPEND = '/wiki/page/append';
    public const ROUTE_WIKI_GET_APPEND_CONTENT = '/wiki/page/get-append-content';


    public static function toHome(ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_OVERVIEW, 'container' => $container]);
    }

    public static function toOverview(ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_OVERVIEW, 'container' => $container]);
    }

    public static function toSearch(ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_SEARCH, 'container' => $container]);
    }

    public static function toLastEdited(ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_LAST_EDITED, 'container' => $container]);
    }

    public static function toWikiHistory(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_HISTORY, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiDiff(WikiPage $page, WikiPageRevision $revision1 = null, WikiPageRevision $revision2 = null)
    {
        $rev1 = $revision1 ? $revision1->revision : null;
        $rev2 = $revision2 ? $revision2->revision : null;
        return static::to([static::ROUTE_WIKI_DIFF, 'id' => $page->id, 'revision1' => $rev1, 'revision2' => $rev2, 'container' => $page->content->container]);
    }

    public static function toWikiDiffEditing(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_DIFF_EDITING, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiRevertRevision(WikiPage $page, $revision)
    {
        if ($revision instanceof WikiPageRevision) {
            $revision = $revision->revision;
        }

        return static::to([static::ROUTE_WIKI_REVERT, 'id' => $page->id, 'toRevision' => $revision, 'container' => $page->content->container]);
    }

    public static function toWikiCreateForCategory(WikiPage $page)
    {
        return static::wikiEdit($page->content->container, null, $page->id);
    }

    private static function wikiEdit(ContentContainerActiveRecord $container, $id = null, $categoryId = null)
    {
        return static::to([static::ROUTE_WIKI_EDIT, 'id' => $id, 'container' => $container, 'categoryId' => $categoryId]);
    }

    public static function toWikiCreate(ContentContainerActiveRecord $container, $categoryId = null)
    {
        return static::wikiEdit($container, null, $categoryId);
    }

    public static function toWikiEdit(WikiPage $page)
    {
        return static::wikiEdit($page->content->container, $page->id);
    }

    /**
     * @param WikiPage $page
     * @param WikiPageRevision $revision
     * @return string
     */
    public static function toWiki(WikiPage $page, WikiPageRevision $revision = null)
    {
        $rev = $revision ? $revision->revision : null;
        return static::to([static::ROUTE_WIKI_PAGE, 'id' => $page->id, 'title' => $page->title, 'revisionId' => $rev, 'container' => $page->content->container]);
    }

    public static function toWikiDelete(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_DELETE, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toExtractTitles()
    {
        return static::to([static::ROUTE_EXTRACT_TITLES, 'container' => ContentContainerHelper::getCurrent()]);
    }

    public static function toUpdateFoldingState()
    {
        return static::to([static::ROUTE_UPDATE_FOLDING_STATE, 'container' => ContentContainerHelper::getCurrent()]);
    }

    public static function toWikiEntry(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_ENTRY, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiMerge(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_MERGE, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiCreateCopy(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_CREATE_COPY, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiEditingStatus(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_EDITING_STATUS, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiEditingTimerUpdate(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_EDITING_TIMER_UPDATE, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiGetTemplateContent(WikiTemplate $template) 
    {
        return static::to([static::ROUTE_WIKI_GET_TEMPLATE_CONTENT, 'id' => $template->id, 'container' => ContentContainerHelper::getCurrent()]);
    }

    public static function toWikiTemplateIndex()
    {
        return static::to([static::ROUTE_WIKI_TEMPLATE_INDEX, 'container' => ContentContainerHelper::getCurrent()]);
    }

    public static function toWikiTemplateCreate()
    {
        return static::to([static::ROUTE_WIKI_TEMPLATE_CREATE, 'container' => ContentContainerHelper::getCurrent()]);
    }

    public static function toWikiTemplateEdit(WikiTemplate $template, ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_WIKI_TEMPLATE_EDIT, 'id' => $template->id, 'container' => $container]);
    }

    public static function toWikiTemplateDelete(WikiTemplate $template, ContentContainerActiveRecord $container)
    {
        return static::to([static::ROUTE_WIKI_TEMPLATE_DELETE, 'id' => $template->id, 'container' => $container]);
    } 

    public static function toWikiAppend(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_APPEND, 'id' => $page->id, 'container' => $page->content->container]);
    }

    public static function toWikiGetAppendContent(WikiPage $page)
    {
        return static::to([static::ROUTE_WIKI_GET_APPEND_CONTENT, 'id' => $page->id, 'container' => $page->content->container]);
    }
}
