# Example Individualize Full-text Theme

This is an example theme that demonstrates how to extract full-text from different HTML galleys in a child theme for the [Individualize Theme](https://github.com/NateWr/individualizeTheme) for OJS.

## Usage

Custom full-text extractors are named `<Journal>ExampleFullText.inc.php`. Each extractor is written to extract the article's full text from the corresponding sample HTML file.

Follow these steps to test an example.

1. In OJS, create an HTML galley and upload one of the `sample-files/sample-*.html` files.
2. Upload the corresponding `sample-files/sample-*.jpg` file as a Dependent File and select **Image** as the file type.
3. Publish the submission with the HTML galley.
4. Uncomment the correct full-text extractor for this sample HTML galley in `ExampleIndividualizeChild::getFullTextExtractor()`.

You should now see the full-text on the article landing page in OJS's reader interface.

## How it works

Each full-text extractor extends `IndividualizeThemeFullText` from the [Individualize Theme](https://github.com/NateWr/individualizeTheme). Typically, you will overwrite one or more of the existing methods, using regular expressions to extract the main article content and references from the HTML galley. In practice, each HTML galley is different and one or more of the following need to be done:

1. Remove the title, author and other metadata which already appears on the article landing page in OJS. (It may be possible to hide this with CSS, depending on how the HTML galley is structured.)
3. Separate the main article from the references and handle endnotes or multiple sections of references.
4. Restructure headings like `<h2>` so that they are nested correctly on the page. (The Individualize theme puts article content under a `<h2>Full Text</h2>` heading, so headings within the article should typically start at `<h3>`.)
5. Make sure all headings have appropriate `id` attributes, so that the table of contents can link to the heading.
6. Remove references or other elements from the headings that shouldn't appear in the Table of Contents.
7. Replace dependent file URLs (use the helper methods `getDependentFiles()` and `replaceDependentFileUrls()`).

