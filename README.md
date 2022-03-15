# db8 Site Last Modified

Module to display the last modification date, based on the article (create/modified) dates in your site. 
Note that it does not display any other changes, e.g. in Category or Modules.

## Versions
- **Joomla 4** version: mod_db8sitelastmodified-**j4**-v4.0.1.zip
- **Joomla 3** version: mod_db8sitelastmodified-**j3**-v3.0.1.zip
- Joomla 2.5, 1.5 and 1.0 versions are no longer available

## Usage

- Text before Date: Put here any text that should be displayed before the date.
- Date/time format: Use the PHP date format to format the date/time.
- Text after Date: Put here any text that should be displayed after the date.
- Note: HTML tags are allowed, so you can use <b> and </b> around your text to get bold characters.

## Example

- Text before Date: This site was last &lt;b&gt; modified on:
- Date/time format: l d F Y, H:i:s
- Text after Date: &lt;/b&gt;!!!

will display:

This site was last <b>modified on: Thursday 17 April 2014, 18:30:59</b> !!!

## Changelog

15-Mar-2022 : v3.0.2 (Joomla 3 version)
- Fixed some errors with J4 code in the J3 Module

7-Mar-2022 : v4.0.1 (Joomla 4 version)
- Increased the version number to force Joomla 4 websites to use the new Joomla 4 version
- Replaced old J3 helper.php with empty placeholder (new J4 helper is now located in /src/Helper/DateHelper.php)

7-Mar-2022 : v3.0.1 (Joomla 3 version)
- Fixed issue with missing files in .zip package 

6-Mar-2022 : v3.0.0
- Refactored Joomla 3 version to namespacing (used since Joomla 3.8)
- Added Joomla 4 version

28-Jan-2015 : v2.6.0
- Added filter="raw" to mod_db8sitelastmodified.xml to make it possible to add HTML code to "Text before/after Date" fields.

17-Apr-2014 : v2.5.0
- Changed date format from PHP strftime to PHP date to display weekday & month in other languages. Updated the module to Joomla 3.x and added <updateserver> for automatic future update notifications and one-click-update functionality

## Thanks to
* Chris Gelauff - for Translation of fr-FR language pack.
* Markus Wortmann - for Translation of de-DE language pack.
