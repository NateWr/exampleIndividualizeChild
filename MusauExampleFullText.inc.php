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
class MusauExampleFullText extends IndividualizeThemeFullText
{
    public function getArticleContent(): string
    {
        $article = '';

        // Extract main article text up to but not including the references section
        preg_match('/<div id=\"articleContent\"[\s\S]*?>([\s\S]*?)<div name=\"References\"/i', $this->html, $matches);
        if ($matches) {
            $article = $matches[1];
        }

        // Remove the back to index and next article buttons just before the references
        $article = preg_replace('/(<table[\s\S]*?back to index[\s\S]*<\/table>[\s]*?)$/i', '', $article);

        $article = $this->replaceEndnoteUrls($article);

        $dependentFiles = $this->getDependentFiles();
        return $this->replaceDependentFileUrls($article, $dependentFiles);
    }

    public function getReferencesContent(): string
    {
        $references = '';
        preg_match('/<h2>References<\/h2>(<ol[\s\S]*?<\/ol>)/is', $this->html, $matches);
        if ($matches) {
            $references = $matches[1];
        }

        $references = $this->replaceEndnoteUrls($references);

        // Wrap in a unique class so we can target them with CSS styles
        return '<div class="musau-references">' . $references . '</div>';
    }

    public function getTableOfContents(string $article, bool $includeReferences, int $startLevel = 3, int $depth = 4): array
    {
        return [];
    }

    /**
     * Replace full absolute URLs to endnotes with
     * relative URLs
     *
     * The following: * https://www.musau.org/parts/neue-article-page/view/171#endnote-639107038914623-1
     * Becomes: #endnote-639107038914623-1
     */
    protected function replaceEndnoteUrls(string $content): string
    {
        return preg_replace('/(https:\/\/www\.musau\.org\/parts\/neue-article-page\/view\/[0-9]*?#endnote)/i', '#endnote', $content);
    }
}
