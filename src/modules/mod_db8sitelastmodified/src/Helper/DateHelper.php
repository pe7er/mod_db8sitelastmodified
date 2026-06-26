<?php

/**
 * @package     mod_db8sitelastmodified
 * @author      Peter Martin, https://db8.nl
 * @copyright   Copyright (C) 2014-2026 Peter Martin. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

namespace Db8\Module\Db8SiteLastModified\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Factory;
use Joomla\Database\DatabaseInterface;
use Joomla\Registry\Registry;

/**
 * Helper for module db8 Site Last Modified
 *
 * @since  5.0.0
 */
class DateHelper
{
    /**
     * Get a formatted date of the most recently created or modified article.
     *
     * @param   Registry                 $params  Object holding the module's parameters.
     * @param   CMSApplicationInterface  $app     The application.
     *
     * @return  string
     *
     * @throws  \Exception
     * @since   5.0.0
     */
    public function getModifiedDate(Registry $params, CMSApplicationInterface $app): string
    {
        $timezone   = $app->getIdentity()->getTimezone();
        $dateFormat = $params->get('dateformat', 'l d-m-Y, H:i:s');

        // Get max created, modified & published dates from the content table.
        $db       = Factory::getContainer()->get(DatabaseInterface::class);
        $nowDate  = Factory::getDate()->toSql();
        $nullDate = $db->getNullDate();

        // For the published date only consider articles whose publish_up is now or in the
        // past and which have not expired (publish_down empty or still in the future).
        $publishUp   = $db->quoteName('publish_up');
        $publishDown = $db->quoteName('publish_down');
        $publishCase = 'MAX(CASE WHEN ' . $publishUp . ' <= :publishUpNow'
            . ' AND (' . $publishDown . ' IS NULL'
            . ' OR ' . $publishDown . ' = :nullDate'
            . ' OR ' . $publishDown . ' >= :publishDownNow)'
            . ' THEN ' . $publishUp . ' END) as publish_up';

        $query = $db->getQuery(true)
            ->select('MAX(' . $db->quoteName('created') . ') as created')
            ->select('MAX(' . $db->quoteName('modified') . ') as modified')
            ->select($publishCase)
            ->from($db->quoteName('#__content'))
            ->bind(':publishUpNow', $nowDate)
            ->bind(':publishDownNow', $nowDate)
            ->bind(':nullDate', $nullDate);
        $db->setQuery($query);

        $result = $db->loadObject();

        if (!$result) {
            return '';
        }

        // Determine which date will be used: created, modified or the most recent.
        $dateDisplay = (int) $params->get('datedisplay');

        if ($dateDisplay === 1) {
            $displayDate = $result->modified;
        } elseif ($dateDisplay === 2) {
            $displayDate = $result->created;
        } elseif ($dateDisplay === 3) {
            $displayDate = $result->publish_up;
        } else {
            // Most recent of created, modified and the (already filtered) published date.
            $dates       = array_filter([$result->modified, $result->created, $result->publish_up]);
            $displayDate = $dates ? max($dates) : null;
        }

        if (!$displayDate) {
            return '';
        }

        $date = Factory::getDate(Factory::getDate($displayDate, 'UTC'))
            ->setTimezone($timezone)
            ->format($dateFormat);

        return $params->get('text_pre') . $date . $params->get('text_post');
    }
}
