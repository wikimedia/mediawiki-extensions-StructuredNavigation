<p align="center">
	<img src="/resources/images/structured-navigation-colored.png" width="600px">
</p>

# <p align="center"> StructuredNavigation</p>
<p align="center">
	<strong>A MediaWiki extension that allows creating machine-readable navigation templates.</strong>
</p>

<p align="center">
	<a href="https://opensource.org/licenses/MIT">
		<img src="https://img.shields.io/badge/License-MIT-brightgreen.svg" alt="License: MIT">
	</a>
	<a href="https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation">
		<img src="https://travis-ci.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation.svg?branch=master" alt="Build Status">
	</a>
</p>

## How to Use
<p align="center">
	<img src="/resources/images/how-to-process.png" width="800px">
</p>

You can play with an example in `/docs/examples`. For this example, let's try using `wikipedia-en-dontnod-entertainment.json`.

1. Create a new page at `Navigation:Dontnod Entertainment`, import the JSON into that page,
then save your edit.
2. At a separate wikitext page, add `<mw-navigation title="Dontnod Entertainment" />` and press save.

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

## License
Licensed under the [MIT license](LICENSE.txt).
