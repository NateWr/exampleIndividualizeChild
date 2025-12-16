<?php
import('plugins.themes.individualizeTheme.classes.IndividualizeThemeFullText');

/**
 * Extract full-text HTML from the example HTML file
 * from Musicologica Austriaca
 *
 * The full string of the HTML galley is located
 * at $this->html. Use $this->getDependentFiles() and
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

        // Change the heading levels
        $article = preg_replace('/<h2/i', '<h3', $article);
        $article = preg_replace('/<\/h2/i', '</h3', $article);

        // Add `id` attributes to the section headings, which are needed to
        // support the links in the table of contents. These are taken from
        // empty <div name="..."></div> elements which appear just before
        // each section heading.
        $article = preg_replace(
            '/<div[^>]*name="([^"]*)"[^>]*>[^<]*<\/div><(h3)[^>]*>([\s\S]*?)<\/h3>/i',
            '<$2 id="$1">$3</$2>',
            $article
        );

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
