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

if (!$formattedDate) {
    return;
}
?>
<div class="db8sitelastmodified">
    <?php echo $formattedDate; ?>
</div>
