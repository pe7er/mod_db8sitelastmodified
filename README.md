# mod_db8sitelastmodified - db8 Site Last Modified

Joomla 5 and Joomla 6 site module that shows when your site was last changed, based on the dates of your articles. It does not look at other changes, such as categories or modules.

## What it does
- Shows the most recent date of your published articles: their modified, created or publish-up date, or whichever is the most recent.
- Formats the date with a PHP date format, in the timezone of the visitor's account or the site's default timezone.
- Puts your own text before and after the date. HTML is allowed, so `<b>` and `</b>` make the text bold.

## Requirements
- Joomla 5 or 6
- PHP 8.1 or later

## Installation
Install like any other Joomla module, then create a *db8 Site Last Modified* module in Content > Site Modules and assign it to a position. Updates come from https://extensions.db8.nl.

## Configuration
- **Use Date from**: modified, created, publish-up, or the most recent of these.
- **Text before date**: text shown before the date.
- **Date/Time format**: a PHP date format, such as `l d F Y, H:i:s`.
- **Text after date**: text shown after the date.

Example: *Text before date* `This site was last <b>modified on:`, *Date/Time format* `l d F Y, H:i:s` and *Text after date* `</b>!!!` display:

This site was last <b>modified on: Thursday 17 April 2014, 18:30:59</b>!!!

## Available Languages
- Dutch (nl-NL)
- English (en-GB)
- French (fr-FR)
- German (de-DE)

## Older versions
The Joomla 3 and Joomla 4 versions are in `downloads/` and on the GitHub releases page; Joomla 2.5, 1.5 and 1.0 versions are no longer available.

## Build
- `scripts/build.sh` builds `dist/mod_db8sitelastmodified-<version>.zip` with a `.sha512` sidecar
- `scripts/install.sh /path/to/joomla` builds and installs it into a Joomla site
- `scripts/sync.sh /path/to/joomla` copies changed files into an installed copy (`--dry-run` shows what would change)

## Changelog
See [CHANGELOG.md](CHANGELOG.md) for release notes.

## Thanks to
* Chris Gelauff - for the translation of the fr-FR language pack.
* Markus Wortmann - for the translation of the de-DE language pack.
