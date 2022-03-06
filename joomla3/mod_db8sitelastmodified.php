<?php
/**
 * @package     mod_db8sitelastmodified
 * @author      Peter Martin, https://db8.nl
 * @copyright   Copyright (C) 2014-2022 Peter Martin. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

use Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$formated_date = modDb8SiteLastModifiedHelper::getModifiedDate($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require ModuleHelper::getLayoutPath('mod_db8sitelastmodified', $params->get('layout', 'default'));