<?php
import('lib.pkp.classes.plugins.ThemePlugin');
import('plugins.themes.exampleIndividualizeChild.ExampleIndividualizeFullText');

class ExampleIndividualizeChild extends ThemePlugin
{
    public function isActive()
    {
        if (defined('SESSION_DISABLE_INIT')) return true;
        return parent::isActive();
    }

    public function init()
    {
        $this->setParent('individualizetheme');

        /**
         * (Optional) Load custom CSS for the full-text on the article landing page
         */
        $this->addStyle('example-individualize-article-full-text', 'css/example.css', ['contexts' => 'frontend-article-view']);
    }

    /**
     * Return false to disable full text and hide
     * the theme option.
     */
    public function supportsArticleFullText(): bool
    {
        return true;
    }

    /**
     * Load the custom extractor class instead of
     * the Individualize theme's built-in extractor
     * class.
     *
     * @see ExampleIndividualizeFullTextExtractor
     */
    public function getFullTextExtractor(string $html, ArticleGalley $galley, Submission $submission): ?ExampleIndividualizeFullText
    {
        return new ExampleIndividualizeFullText($html, $galley, $submission);
    }

    public function getDisplayName()
    {
        return __('plugins.themes.exampleIndividualizeChild.name');
    }

    public function getDescription()
    {
        return __('plugins.themes.exampleIndividualizeChild.description');
    }
}