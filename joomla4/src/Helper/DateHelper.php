<?php

/**
 * @package     mod_db8sitelastmodified
 * @author      Peter Martin, https://db8.nl
 * @copyright   Copyright (C) 2014-2026 Peter Martin. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

namespace Db8\Module\Db8SiteLastModified\Site\Helper;

\defined('_JEXEC') or die;

use Exception;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;

/**
 * Helper for module db8 Site Last Modified
 *
 * @since  3.0.0
 */
abstract class DateHelper
{
    /**
     * Get a formatted date of the most recently created or modified article.
     *
     * @param   Registry  $params  Object holding the module's parameters.
     *
     * @return  string
     *
     * @throws  Exception
     * @since   3.0.0
     */
    public static function getModifiedDate(&$params)
    {
        $app        = Factory::getApplication();
        $user       = $app->getIdentity();
        $timezone   = $user->getTimezone();
        $dateFormat = $params->get('dateformat', 'l d-m-Y, H:i:s');

        // Get max created & modified dates from the content table.
        $db    = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->select('MAX(' . $db->quoteName('created') . ') as created')
            ->select('MAX(' . $db->quoteName('modified') . ') as modified')
            ->from($db->quoteName('#__content'));
        $db->setQuery($query);

        $result = $db->loadObject();

        // Determine which date will be used: created, modified or the most recent.
        $dateDisplay = $params->get('datedisplay');

        if ($dateDisplay === 1) {
            $displayDate = $result->modified;
        } elseif ($dateDisplay === 2) {
            $displayDate = $result->created;
        } else {
            $displayDate = max($result->modified, $result->created);
        }

        $date = Factory::getDate(Factory::getDate($displayDate, 'UTC'))
            ->setTimezone($timezone)
            ->format($dateFormat);

        return $params->get('text_pre') . $date . $params->get('text_post');
    }
}
