# How to contribute
Thank you for showing interest in contributing! This document describes several ways on how you can contribute to the project.

## Submitting an issue
Before you open an issue, please search through the existing issues; your issue might have already been reported!

You can submit an issue by going to the [issues form](https://github.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation/issues/new/choose). We have form templates that you should use if you're submitting a bug report or feature request. If your issue doesn't fall under either of these categories, you can [open a regular issue instead.](https://github.com/SamanthaNguyen/mediawiki-extensions-StructuredNavigation/issues/new)

> **Notes**:
> - If you find a security vulnerability, do NOT open an issue. Email me at `samanthanguyen1116@gmail.com` instead.
> - Before you open an issue, please search through the existing issues; your issue might have already been reported!

## Submitting a patch
Is it your first time submitting a patch to this extension? If it is, make sure to run `composer update` which will install dependencies for development. You won't have to run that command again when you've done it once already.

Your patches should always only be doing one thing and one thing only; anything out-of-scope of the specific patch's purpose should be in a separate patch.

When you submit a patch:
 - Always write a clear log message describing what was changed and why it was changed. One-line messages are fine for small changes, but bigger changes should include a paragraph describing its impacts.
 - Tag any specific issue(s) if any of them are relevant
 - Follow [code conventions](#coding-conventions)

## Coding conventions
This project follows the MediaWiki coding conventions, and uses MediaWiki CodeSniffer (MediaWiki's standard built on top of `squizlabs/php_codesnifer`) to enforce these coding conventions. Before you submit a patch,
make sure to run `composer test`. If there are warnings and errors, be sure to fix them before submitting.
Some sniffs can be auto-fixed using `composer fix`, but others will have to be done through manual intervention.

References:
 - [PHP coding conventions for MediaWiki - MediaWiki.org](https://www.mediawiki.org/wiki/Manual:Coding_conventions/PHP)
 - [MediaWiki CodeSniffer](https://github.com/wikimedia/mediawiki-tools-codesniffer)
 - [`squizlab/php_codesniffer`](https://github.com/squizlabs/PHP_CodeSniffer)

## References
This contribution guide used [OpenGovernment's contributing guide](https://github.com/opengovernment/opengovernment/blob/master/CONTRIBUTING.md) and [`nayafia/contributing-template`](https://github.com/nayafia/contributing-template) as references to help make this guide. Thank you!
