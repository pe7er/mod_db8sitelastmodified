# Changelog

All notable changes to this project are documented in this file.

The format follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/).

Historical entries (4.0.1 and earlier) are sourced from the
[Joomla Extensions Directory listing](https://extensions.joomla.org/extension/db8-site-last-modified/).

## [5.0.0] - 2026-06-26
git 
### Added
- Joomla 5 and 6 compatible build under `src/modules/mod_db8sitelastmodified`, rebuilt on the modern service-provider + dispatcher architecture.
- "Published" option for the "Use Date from" setting (`publish_up`), alongside Created and Modified. Only articles whose publish date is now or in the past — and that have not expired through `publish_down` — are considered, and that date is also factored into the "Most Recent" calculation.

### Changed
- Helper rewritten as an instantiable class resolved through the HelperFactory, with the application injected and the database accessed via `DatabaseInterface`.

### Fixed
- "Use Date from" never selected Modified or Created, because the parameter (a string) was compared strictly against an integer; it is now cast to `int`.

## [4.1.0] - 2026-06-26

### Changed
- Aligned the Joomla 4 build with the Joomla Coding Standards (PSR-12) — blank line after `<?php`, `\defined('_JEXEC')`, `use` statements before the access guard, same-line braces in layouts, refreshed docblocks, and LF line endings.
- Update server now points at the `main` branch (was `master`).

## [4.0.1] - 2022-03-07

### Changed
- Increased the version number to force Joomla 4 websites onto the new Joomla 4 build.
- Replaced the legacy `helper.php` with a placeholder; the helper now lives in `src/Helper/DateHelper.php`.

## [3.0.2] - 2022-03-15

### Fixed
- Fixed some errors caused by Joomla 4 code in the Joomla 3 module.

## [3.0.1] - 2022-03-07

### Fixed
- Fixed missing files in the installation `.zip` package.

## [3.0.0] - 2022-03-06

### Added
- Joomla 4 version.

### Changed
- Refactored to use namespacing (the standard since Joomla 3.8).

## [2.6.0] - 2015-01-28

### Added
- `raw` filter on the module's text fields, allowing HTML in the text-before and text-after-date fields.

## [2.5.0] - 2014-04-17

### Changed
- Switched date formatting from PHP `strftime` to PHP `date`, so weekday and month names display correctly on multilingual sites.
- Updated for Joomla 3.x, with automatic update notifications.
