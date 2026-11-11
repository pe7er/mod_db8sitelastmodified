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

namespace Db8\Module\Db8SiteLastModified\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Date\Date;
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
        $date = $this->getDisplayDate($params, $app);

        if ($date === null) {
            return '';
        }

        return $params->get('text_pre')
            . $date->format($params->get('dateformat', 'l d-m-Y, H:i:s'), true)
            . $params->get('text_post');
    }

    /**
     * Get the date to show, in the visitor's (or the site's) timezone.
     *
     * Layouts format it for display and use toISO8601(true) for the
     * machine-readable datetime attribute.
     *
     * @param   Registry                 $params  Object holding the module's parameters.
     * @param   CMSApplicationInterface  $app     The application.
     *
     * @return  Date|null  Null when there is no article date to show.
     *
     * @throws  \Exception
     * @since   5.1.0
     */
    public function getDisplayDate(Registry $params, CMSApplicationInterface $app): ?Date
    {
        $timezone = $app->getIdentity()->getTimezone();

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

        $query = $db->createQuery()
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
            return null;
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
            return null;
        }

        // format() and toISO8601() switch back to UTC unless $local is true.
        return Factory::getDate($displayDate, 'UTC')->setTimezone($timezone);
    }
}
