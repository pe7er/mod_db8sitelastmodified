<?php
/**
 * @package     mod_db8sitelastmodified
 * @author      Peter Martin, https://db8.nl
 * @copyright   Copyright (C) 2014-2022 Peter Martin. All rights reserved.
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
     * Get a formatted date of most recently created or modified article
     *
     * @param Registry  &$params object holding the models parameters
     *
     * @return  string
     * @throws  Exception
     * @since   3.0.0
     */
    public static function getModifiedDate(&$params)
    {
        $app = Factory::getApplication();
        $user = $app->getIdentity();
        $timezone = $user->getTimezone();
        $dateFormat = $params->get('dateformat', 'l d-m-Y, H:i:s');

        // Get max created & modified dates from content table
        $db = Factory::getContainer()->get('DatabaseDriver');
        $query = $db->getQuery(true)
            ->select('MAX( ' . $db->quoteName('created', 'created') . ' )')
            ->select('MAX( ' . $db->quoteName('modified', 'modified') . ' )')
            ->from($db->quoteName('#__content'));
        $db->setQuery($query);

        $result = $db->loadObject();

        // determine what will be used for create/modified date
        $dateDisplay = $params->get('datedisplay');
        if ($dateDisplay == 1) {
            $displayDate = $result->modified;
        } elseif ($dateDisplay == 2) {
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
