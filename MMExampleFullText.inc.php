<?php
import('plugins.themes.individualizeTheme.classes.IndividualizeThemeFullText');

/**
 * Example implementation of a child class to
 * customize the full-text HTML that is extracted
 * from a HTML galley.
 *
 * The full string of the HTML galley is located
 * at $this->html. Uncomment one of these plugins
 * to override it and extract the appropriate
 * content from the galley.
 *
 * Use $this->getDependentFiles() and
 * $this->replaceDependendentFileUrls() to replace
 * URLs to images, videos and other assets that
 * are referenced in the HTML galley. This does not
 * replace URLs in the HTML <head> such as linked
 * CSS files.
 */
class MMExampleFullText extends IndividualizeThemeFullText
{
    public function getArticleContent(): string
    {
        $article = '';

        // Extract main article text up to but not including the references section
        preg_match('/<div class=\"htmlgalley\">([\s\S]*?)<div class=\"references\"/i', $this->html, $matches);
        if ($matches) {
            $article = $matches[1];
        }

        // Remove the header and abstract at the top of the article
        $article = preg_replace('/(<header[\s\S.]*?)<hr>/i', '', $article);

        // Remove the <hr> elements
        $article = preg_replace('/<hr>/i', '', $article);

        // Fix CSS clash with the .footnotes class
        $article = str_replace('<section class="footnotes"', '<section class="mm-footnotes"', $article);

        $dependentFiles = $this->getDependentFiles();
        return $this->replaceDependentFileUrls($article, $dependentFiles);
    }

    public function getReferencesContent(): string
    {
        $references = '';
        preg_match('/<div class=\"references\">[\s\S]*?<h2 id=\"references\">References<\/h2>([\s\S]*?)<\/div>/is', $this->html, $matches);
        if ($matches) {
            $references = $matches[1];
        }

        // Re-structure heading levels for the
        // different reference sections (Archival Sources, Ethnographic Data)
        $references = preg_replace('/<h2/i', '<h4', $references);

        // Wrap in a unique class so we can target them with CSS styles
        return '<div class="mm-references">' . $references . '</div>';
    }

    public function getTableOfContents(string $article, bool $includeReferences, int $startLevel = 3, int $depth = 4): array
    {
        return [];
    }
}
