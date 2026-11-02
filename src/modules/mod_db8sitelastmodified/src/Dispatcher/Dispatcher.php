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
        $data = parent::getLayoutData();

        $data['formattedDate'] = $this->getHelperFactory()
            ->getHelper('DateHelper')
            ->getModifiedDate($data['params'], $this->getApplication());

        return $data;
    }
}
