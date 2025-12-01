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
class ExampleIndividualizeFullText extends IndividualizeThemeFullText
{
    // public function getArticleContent(): string
    // {
    //     $article = '';
    //     preg_match('/<article>(.*)<\/article>/is', $this->html, $matches);
    //     if ($matches) {
    //         $article = $matches[0];
    //     }

    //     $dependentFiles = $this->getDependentFiles();
    //     return $this->replaceDependentFileUrls($article, $dependentFiles);
    // }

    // public function getReferencesContent(): string
    // {
    //     preg_match('/<aside>(.*)<\/aside>/is', $this->html, $matches);
    //     if ($matches) {
    //         return $matches[0];
    //     }
    //     return '';
    // }

    // public function getTableOfContents(string $article, bool $includeReferences, int $startLevel = 3, int $depth = 4): array
    // {
    //     return [];
    // }
}
