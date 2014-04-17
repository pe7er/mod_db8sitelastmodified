<?php

/**
 * @package	mod_db8sitelastmodified
 * @author	Peter Martin, www.db8.nl
 * @copyright	Copyright (C) 2014 Peter Martin. All rights reserved.
 * @license	GNU General Public License version 2 or later.
 */
defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$formated_date = modDb8SiteLastModifiedHelper::getModifiedDate($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_db8sitelastmodified', $params->get('layout', 'default'));