<?php

declare(strict_types=1);

namespace lindesbs\contaotoolbox\Service;

use Contao\ArticleModel;
use Contao\ContentModel;
use Contao\Controller;
use Contao\LayoutModel;
use Contao\ModuleModel;
use Contao\NewsArchiveModel;
use Contao\NewsModel;
use Contao\PageModel;
use Contao\StringUtil;
use Contao\ThemeModel;
use Exception;
use lindesbs\contaotoolbox\Constants\Constant;
use lindesbs\contaotoolbox\Constants\Page;

class DCATools
{
    private static $arrSortingOrder = [];

    public function getContent(
        string $title,
        array $arrOptons,
        NewsModel|ArticleModel|PageModel $parent,
        bool $bDoNotCheck = false
    ): ContentModel {
        $alias = substr(StringUtil::generateAlias($title), 0, 64);
        $objContent = ContentModel::findOneBy('alias', $alias);

        if (!$objContent) {
            $objContent = new ContentModel();
        }

        $arrMandatory = $this->preConfigTable('tl_content', $objContent);


        $objContent->tstamp = time();
        $objContent->headline = ['unit' => 'h2', 'value' => $title];
        $objContent->alias = $alias;
        $objContent->pid = $parent->id;
        $objContent->ptable = 'tl_article';

        $objContent->sorting = $this->getSortingID($objContent);

        if ($parent instanceof NewsModel) {
            $ptable = 'tl_news';
        }

        $objContent->type = 'text';
        $objContent->text = '';


        foreach ($arrOptons as $key => $value) {
            if (is_array($value)) {
                $objContent->$key = serialize($value);
                continue;
            }

            if ($value instanceof DCATools) {
                $objContent->$key = $value->id;

                continue;
            }

            $objContent->$key = $value;
        }


        if (!$bDoNotCheck) {
            $this->postConfigTable($arrMandatory, $objContent);
        }
        $objContent->save();

        return $objContent;
    }

    public function getModule(string $title, array $arrOptons): ModuleModel
    {
        $alias = StringUtil::generateAlias($title);
        $objModule = ModuleModel::findOneBy('alias', $alias);

        if (!$objModule) {
            $objModule = new ModuleModel();
        }

        $arrMandatory = $this->preConfigTable('tl_module', $objModule);

        $objModule->tstamp = time();
        $objModule->name = $title;
        $objModule->alias = $alias;
        $objModule->pages = [];
        $objModule->singleSRC = [];
        $objModule->url = '';
        $objModule->multiSRC = [];

        $objModule->sorting = $this->getSortingID($objModule);
        $objModule->groups = [];
        $objModule->rss_feed = '';

        $objModule->faq_categories = [];
        $objModule->news_archives = [];
        $objModule->list_fields = [];
        $objModule->cal_calendar = 0;
        $objModule->nl_channels = [];

        $objModule->numberOfItems = 30;


        foreach ($arrOptons as $key => $value) {
            if (is_array($value)) {
                $objModule->$key = serialize($value);
            } else {
                $objModule->$key = $value;
            }
        }


        $this->postConfigTable($arrMandatory, $objModule);
        $objModule->save();

        return $objModule;
    }


    public function getTheme(string $title, array $arrOptions = null, bool $bUpdate = false): ThemeModel
    {
        $alias = StringUtil::generateAlias($title);
        $objTheme = ThemeModel::findOneBy('alias', $alias);

        if (!$objTheme) {
            $objTheme = new ThemeModel();
        }

        $arrMandatory = $this->preConfigTable('tl_theme', $objTheme);

        $objTheme->tstamp = time();
        $objTheme->name = $title;
        $objTheme->alias = $alias;
        $objTheme->author = 1;

        $objTheme->sorting = $this->getSortingID($objTheme);

        if (is_array($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                if (is_array($value)) {
                    $objTheme->$key = serialize($value);
                } else {
                    $objTheme->$key = $value;
                }
            }
        }

        $this->postConfigTable($arrMandatory, $objTheme);
        $objTheme->save();

        return $objTheme;
    }

    public function getLayout(string $title, array $arrOptions, int $parent = 0): LayoutModel
    {
        $alias = StringUtil::generateAlias($title);
        $objLayout = LayoutModel::findOneBy('alias', $alias);

        if (!$objLayout) {
            $objLayout = new LayoutModel();
        }

        $arrMandatory = $this->preConfigTable('tl_layout', $objLayout);

        $objLayout->tstamp = time();

        if ($parent !== 0) {
            $objLayout->pid = $parent;
        }

        $objLayout->name = $title;
        $objLayout->alias = $alias;

        $objLayout->sorting = $this->getSortingID($objLayout);
        $objLayout->row = "3rw";
        $objLayout->cols = "3cl";
        $objLayout->headerHeight = serialize([
            'unit' => '',
            'value' => ''
        ]);
        $objLayout->footerHeight = serialize([
            'unit' => '',
            'value' => ''
        ]);

        $objLayout->widthLeft = serialize([
            'unit' => '',
            'value' => ''
        ]);

        $objLayout->widhtRight = serialize([
            'title' => '',
            'id' => '',
            'template' => '',
            'position' => ''
        ]);


        $objLayout->loadingOrder = 'externalFirst';

        $objLayout->frameworks = serialize([
            'layout.css',
            'responsive.css'
        ]);

        $objLayout->template = $this->getConfig('template', 'fe_page', $arrOptions);
        $objLayout->viewport = $this->getConfig('viewport', 'width=device-width, initial-scale=1.0', $arrOptions);

        foreach ($arrOptions as $key => $value) {
            if (is_array($value)) {
                $objLayout->$key = serialize($value);
            } else {
                $objLayout->$key = $value;
            }
        }

        $this->postConfigTable($arrMandatory, $objLayout);
        $objLayout->save();

        return $objLayout;
    }

    private function getConfig(string $key, mixed $default, mixed $heap = null)
    {
        if ($heap === null) {
            return $default;
        }

        if (is_numeric($heap)) {
            return $heap;
        }

        if (array_key_exists($key, $heap)) {
            return $heap[$key];
        }
        return $default;
    }

    public function getNewsArchive(string $title, array $arrOptions = []): NewsArchiveModel
    {
        $alias = StringUtil::generateAlias($title);
        $objNewsArchive = NewsArchiveModel::findOneBy('alias', $alias);

        if (!$objNewsArchive) {
            $objNewsArchive = new NewsArchiveModel();
        }

        $arrMandatory = $this->preConfigTable('tl_news_archive', $objNewsArchive);

        $objNewsArchive->tstamp = time();
        $objNewsArchive->perPage = $this->getConfig('perPage', 30, $arrOptions);
        $objNewsArchive->title = $title;
        $objNewsArchive->alias = $alias;
        $objNewsArchive->groups = [];
        $objNewsArchive->jumpTo = 0;

        $objNewsArchive->sorting = $this->getSortingID($objNewsArchive);


        if (is_array($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                if (is_array($value)) {
                    $objNewsArchive->$key = serialize($value);
                } else {
                    $objNewsArchive->$key = $value;
                }
            }
        }

        $this->postConfigTable($arrMandatory, $objNewsArchive);

        $objNewsArchive->save();

        return $objNewsArchive;
    }

    /**
     * @throws Exception
     */
    public function getNews(string $title, array $arrOptions, NewsArchiveModel $archive): NewsModel
    {
        $alias = StringUtil::generateAlias($title);
        $objNews = NewsModel::findOneBy('alias', $alias);

        if (!$objNews) {
            $objNews = new NewsModel();
        }

        $arrMandatory = $this->preConfigTable('tl_news', $objNews);

        $objNews->pid = $archive->id;
        $objNews->tstamp = time();
        $objNews->headline = $title;
        $objNews->alias = $alias;

        $objNews->addEnclosure = false;
        $objNews->enclosure = 0;
        $objNews->published = true;
        $objNews->articleId = 0;
        $objNews->jumpTo = 0;
        $objNews->author = 0;
        $objNews->url = '';

        $objNews->sorting = $this->getSortingID($objNews);
        unset($arrMandatory['singleSRC']);

        if (is_array($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                if (is_array($value)) {
                    $objNews->$key = serialize($value);
                } else {
                    $objNews->$key = $value;
                }
            }
        }

        $this->postConfigTable($arrMandatory, $objNews);

        $objNews->save();

        return $objNews;
    }

    public function getPage(string $title, array $arrOptions, int $parent): PageModel
    {
        Controller::loadDataContainer('tl_page');

        if (!is_array($arrOptions)) {
            $arrOptions = [];
        }

        $alias = StringUtil::generateAlias($title);
        $objPage = PageModel::findOneByAlias($alias);

        if (!$objPage) {
            $objPage = new PageModel();
        }

        $arrMandatory = $this->preConfigTable('tl_page', $objPage);

        $objPage->tstamp = time();
        $objPage->title = $title;
        $objPage->alias = $alias;
        $objPage->pid = $parent;
        $objPage->url = '';
        $objPage->twoFactorJumpTo = 0;
        $objPage->type = 'regular';
        $objPage->language = 'de';
        $objPage->robots = 'index,follow';
        $objPage->enableCanonical = 1;
        $objPage->sitemap = 'map_default';
        $objPage->published = true;

        $objPage->sorting = $this->getSortingID($objPage);
        $objPage->groups = [];

        if (in_array(Page::SSLROOT, $arrOptions, true)) {
            $arrOptions = array_merge($arrOptions, Page::SSLRoot());
        }
        if (in_array(Page::NOSSLROOT, $arrOptions, true)) {
            $arrOptions = array_merge($arrOptions, Page::NoSSLRoot());
        }

        if (is_array($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                if (is_array($value)) {
                    $objPage->$key = serialize($value);
                } else {
                    $objPage->$key = $value;
                }
            }
        }

        $this->postConfigTable($arrMandatory, $objPage);
        $objPage->save();

        return $objPage;
    }


    public function getArticle(
        string $title,
        array $arrOptions,
        int|PageModel|ArticleModel|NewsModel $page
    ): ArticleModel {
        $alias = StringUtil::generateAlias($title);
        $objArticle = ArticleModel::findOneBy('alias', $alias);

        if (!$objArticle) {
            $objArticle = new ArticleModel();
        }

        $arrMandatory = $this->preConfigTable('tl_article', $objArticle);

        $objArticle->tstamp = time();

        if ($page instanceof PageModel) {
            $objArticle->pid = $page->id;
        } else {
            $objArticle->pid = $page;
        }

        $objArticle->title = $title;
        $objArticle->alias = $alias;
        $objArticle->author = 0;
        $objArticle->inColumn = 'main';
        $objArticle->groups = [];
        $objArticle->published = true;

        $objArticle->sorting = $this->getSortingID($objArticle);

        if (is_array($arrOptions)) {
            foreach ($arrOptions as $key => $value) {
                if (is_array($value)) {
                    $objArticle->$key = serialize($value);
                } else {
                    $objArticle->$key = $value;
                }
            }
        }

        $this->postConfigTable($arrMandatory, $objArticle);

        $objArticle->save();

        return $objArticle;
    }

    /**
     * @param string $table
     * @param PageModel|null $objPage
     * @return array
     */
    public function preConfigTable(string $table, mixed $objDCA): array
    {
        Controller::loadDataContainer($table);
        $arrMandatory = [];

        foreach ($GLOBALS['TL_DCA'][$table]['fields'] as $fieldKey => $fieldValue) {
            if (array_key_exists('default', $fieldValue)) {
                $objDCA->$fieldKey = $fieldValue['default'];
            }

            if ((array_key_exists('eval', $fieldValue)) &&
                (array_key_exists('mandatory', $fieldValue['eval']))) {
                $arrMandatory[$fieldKey] = $objDCA->$fieldKey;
            }
        }
        return $arrMandatory;
    }

    public function postConfigTable(array $arrMandatory, mixed $objDCA): void
    {
        $bFound = false;
        foreach ($arrMandatory as $fieldKey => $fieldValue) {
            if (!isset($objDCA->$fieldKey)) {
                $bFound = true;
                echo sprintf("Missing setting for key [%s] => [%s]" . PHP_EOL, $fieldKey, $fieldValue);
            }
        }
    }

    /**
     * @param null $objSorting
     * @return int
     */
    public function getSortingID(mixed $objSorting): int
    {
        $sorting = 0;
        $sortingObjects = $objSorting::findAll();

        if ($objSorting !== null) {
            if (!array_key_exists($objSorting::class, self::$arrSortingOrder)) {
                self::$arrSortingOrder[$objSorting::class] = [];
            }
            if (!array_key_exists($objSorting->pid, self::$arrSortingOrder[$objSorting::class])) {
                self::$arrSortingOrder[$objSorting::class][$objSorting->pid] = 0;
            }

            $sorting = self::$arrSortingOrder[$objSorting::class][$objSorting->pid];
            foreach ($sortingObjects as $obj) {
                $sorting = max($sorting, $obj->sorting);
            }

            $sorting += 128;
            $objSorting->sorting = $sorting;
            self::$arrSortingOrder[$objSorting::class][$objSorting->pid] = $sorting;
        }
        return $sorting;
    }
}