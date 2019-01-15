# StructuredNavigation - an extension for MediaWiki
[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
[![Build Status](https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation.svg?branch=master)](https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation)

**StructuredNavigation** allows creating navigation templates that can be used on articles. 

> Note: While this project is definitely functional (feel free to play with it!), do keep in mind that it's still in development phase. This project will be released as stable once all tasks under the ["Stable Release" project](https://github.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation/projects/1) have been accomplished.

## Contributing
Are you interested in contributing? Read the [official contribution guide](.github/CONTRIBUTING.md), which covers:
 - [How to submit an issue](.github/CONTRIBUTING.md#submitting-an-issue)
 - [How to submit a patch](.github/CONTRIBUTING.md#submitting-a-patch)
 - [Coding conventions](.github/CONTRIBUTING.md#coding-conventions)

## Install
This extension requires MediaWiki 1.32 (or greater) and PHP 7.1 (or greater). To install:

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
You can play with an example in `/docs/examples`. For this example, let's try using `wikipedia-en-dontnod-entertainment.json`.

1. Create a new page at `Navigation:Dontnod Entertainment`, import the JSON into that page,
then save your edit.
2. At a separate wikitext page, add `<mw-navigation title="Dontnod Entertainment">` and press save.

## License
Licensed under [GNU General Public License v2.0](COPYING).
