# About this extension
**StructuredNavigation** allows creating navigation templates that can be used on articles.

## Install
This extension was developed on the latest commit of the `REL1_32` branch of MediaWiki core; however, it should probably work just as well on a 1.31 installation. This extension requires at least PHP 7.1. To install:

1. Git clone this repository locally on your wiki.
2. Add this line to your `LocalSettings.php` file:
```php
wfLoadExtension( 'StructuredNavigation' );
```

## Benefits
Using this extension allows creating navigations that are:
  - machine-readable (`.json`, a universally accepted data format )
  - automatically tracked using the `structurednavigation` page property (try using `[[Special:PagesWithProp/structurednavigation]]`)
  - produced using a standard, semantic HTML output
  - semantically sane: presentation details are separated from content (e.g separator symbol is auto-appended after each link using CSS - much nicer than having to manually include it after each link)

## How to Use
You can play with an example in `/docs/examples`. Let's say you use `dontnod-entertainment.json`.

1. Create a new page at `Navigation:Dontnod Entertainment`, import the JSON into that page,
then save your edit.
2. At a separate wikitext page, add `<mw-navigation title="Dontnod Entertainment">` and press save.

## Presentation vs Content
Navigations only contain pure content - that is, it does not contain any information on how it should be styled such as the header background color, font size of group title, etc. A proposed way to handle presentation details:

- Have the wiki of interest install the TemplateStyles extension.
- Have the navigation of interest, e.g `<mw-navigation title="Dontnod Entertainment">`, inside a template called `[[Template:Dontnod Entertainment]]`.
- Create a template subpage at `[[Template:Dontnod Entertainment/styles.css]]`. (Any styles the user wants to override can be done here.)
- Include `<templatestyles src="/styles.css" />` at the top of the template

Note that this extension does not actually have a hard software dependency on TemplateStyles, but should work extremely well with TemplateStyles.

## TODO
  - The navigation tag should allow identifying itself through an ID selector by accepting an `id` attribute
  - Should provide a visual editor for creating structured navigations
  - Validate JSON against a schema (currently this extension just assumes each navigation JSON is in the same format)
  - Allow to have groups within groups (maybe?)
  - Figure out and implement separation between presentation and content; at the end, styling structured navigations should be easily customisable
  - Include a maintenance script and special page for mass-migrating wikitext-based navigation templates to structured navigations
  - Include the navigation-bar/template links (view, talk, edit) in the render
  - Allow extensions to add their own renderer for a StructuredNavigation entity (e.g MobileFrontend could provide their own version specifically designed for mobile). This could be done by providing a hook