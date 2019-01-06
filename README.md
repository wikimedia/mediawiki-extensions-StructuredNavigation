# About
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![Build Status](https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation.svg?branch=master)](https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation)

**StructuredNavigation** allows creating navigation templates that can be used on articles. 

> Note: This project is currently in development phase; this project will be released as stable once all tasks under the ["Stable Release" project](https://github.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation/projects/1) have been accomplished.

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
You can play with an example in `/docs/examples`. Let's say you use `wikipediaen-dontnod-entertainment.json`.

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
