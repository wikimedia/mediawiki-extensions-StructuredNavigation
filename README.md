<p align="center">
	<img src="/resources/images/structured-navigation-colored.png" width="600px">
</p>

# <p align="center"> StructuredNavigation</p>
<p align="center">
	<strong>A MediaWiki extension that allows creating machine-readable navigation templates.</strong>
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
This extension requires MediaWiki 1.34 (or greater) and PHP 7.4 (or greater). To install:

1. Git clone this repository locally on your wiki.
2. Add this line to your `LocalSettings.php` file:
```php
wfLoadExtension( 'StructuredNavigation' );
```

## Benefits
Using this extension allows creating navigations that:
  - are machine-readable in JSON, an open format for storing data
  - are retrievable with MediaWiki's Action API and REST API
  - only contain data: presentation details are separated from the content. No wikitext, inline CSS, or HTML required; e.g the separator symbol is auto-appended after each link using CSS.
  - are automatically tracked using the `structurednavigation` page property (try using `[[Special:PagesWithProp/structurednavigation]]`)
  - produce semantic and accessible HTML

## License
Licensed under the [MIT license](LICENSE.txt).
