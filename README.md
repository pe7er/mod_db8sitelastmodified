db8sitelastmodified
===================

db8 Site Last Modified
This Module displays the last site modification date, based on the article (create/modified) dates in your site. Note that it does not display any other changes, e.g. in Category or Modules.

Usage:

Text before Date: Put here any text that should be displayed before the date.
Date/time format: Use the PHP date format to format the date/time.
Text after Date: Put here any text that should be displayed after the date.
Note: HTML tags are allowed, so you can use <b> and </b> around your text to get bold characters.

Example:

Text before Date: This site was last < b >modified on:
Date/time format: l d F Y, H:i:s
Text after Date: < /b >!!!
will display:
This site was last <b>modified on: Thursday 17 April 2014, 18:30:59</b> !!!


Changelog:

Version v2.6 - Added filter="raw" to mod_db8sitelastmodified.xml to make it possible to add HTML code to "Text before/after Date" fields.

Version v2.5 - Changed date format from PHP strftime to PHP date to display weekday & month in other languages. Updated the module to Joomla 3.x and added <updateserver> for automatic future update notifications and one-click-update functionality

Thanks to:

Chris Gelauff - for Translation of fr-FR language pack.

Markus Wortmann - for Translation of de-DE language pack.
