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

namespace Db8\Module\Db8SiteLastModified\Site\Dispatcher;

\defined('_JEXEC') or die;

use Joomla\CMS\Dispatcher\AbstractModuleDispatcher;
use Joomla\CMS\Helper\HelperFactoryAwareInterface;
use Joomla\CMS\Helper\HelperFactoryAwareTrait;

/**
 * Dispatcher class for mod_db8sitelastmodified
 *
 * @since  5.0.0
 */
class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface
{
    use HelperFactoryAwareTrait;

    /**
     * Returns the layout data.
     *
     * @return  array
     *
     * @since   5.0.0
     */
    protected function getLayoutData(): array
    {
        $data   = parent::getLayoutData();
        $params = $data['params'];
        $date   = $this->getHelperFactory()
            ->getHelper('DateHelper')
            ->getDisplayDate($params, $this->getApplication());

        // The parts, for layouts that mark the date up with <time datetime>.
        $data['textPre']  = $date ? (string) $params->get('text_pre', '') : '';
        $data['textPost'] = $date ? (string) $params->get('text_post', '') : '';
        $data['dateText'] = $date ? $date->format($params->get('dateformat', 'l d-m-Y, H:i:s'), true) : '';
        $data['isoDate']  = $date ? $date->toISO8601(true) : '';

        // The whole text, as before, for the plaintext layout and existing overrides.
        $data['formattedDate'] = $date ? $data['textPre'] . $data['dateText'] . $data['textPost'] : '';

        return $data;
    }
}
