<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_db8sitelastmodified
 *
 * @author      Peter Martin <joomla@db8.nl>
 * @copyright   (C) 2014 - 2026 Peter Martin
 * @link        https://extensions.db8.nl
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

\defined('_JEXEC') or die;

/**
 * @var  string  $formattedDate  Prefix, date and suffix as one string.
 * @var  string  $textPre        The "text before" option (may hold HTML).
 * @var  string  $dateText       The formatted date.
 * @var  string  $textPost       The "text after" option (may hold HTML).
 * @var  string  $isoDate        The same date in ISO 8601, for the datetime attribute.
 */

if (!$formattedDate) {
    return;
}
?>
<p class="db8sitelastmodified">
    <?php echo $textPre; ?><time datetime="<?php echo htmlspecialchars($isoDate, ENT_QUOTES, 'UTF-8'); ?>"><?php echo $dateText; ?></time><?php echo $textPost; ?>
</p>
