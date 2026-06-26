<?php

/**
 * @package     mod_db8sitelastmodified
 * @author      Peter Martin, https://db8.nl
 * @copyright   Copyright (C) 2014-2026 Peter Martin. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

use Db8\Module\Db8SiteLastModified\Site\Helper\DateHelper;
use Joomla\CMS\Helper\ModuleHelper;

\defined('_JEXEC') or die;

$formattedDate = DateHelper::getModifiedDate($params);

require ModuleHelper::getLayoutPath('mod_db8sitelastmodified', $params->get('layout', 'default'));
