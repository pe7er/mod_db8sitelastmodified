<?php

/**
 * @package	mod_db8sitelastmodified
 * @author	Peter Martin, www.db8.nl
 * @copyright	Copyright (C) 2014 Peter Martin. All rights reserved.
 * @license	GNU General Public License version 2 or later.
 */
defined('_JEXEC') or die;

/**
 * Helper for mod_db8sitelastmodified
 *
 * @package     Joomla.Site
 * @subpackage  mod_db8sitelastmodified
 */

abstract class modDb8SiteLastModifiedHelper
{
    /**
    * Retrieves a formatted date
    *
    * @param JParameter Module parameters
    * @return a string with text + formatted a local time/date according to locale settings + text
    */
    public static function getModifiedDate(&$params)
    {
        // Get user + time zone configuration
        $config = JFactory::getConfig();
        $user   = JFactory::getUser();
 
        // get max created & modified dates from content table
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('MAX( created ) AS created, MAX( modified ) AS modified');
        $query->from('#__content');
        $db->setQuery($query);
        $result = $db->loadObject();

        // determine what will be used for create/modified date
        $datedisplay = $params->get('datedisplay');
        if ( $datedisplay == 1 ){
            $displaydate = $result->modified;
        }elseif( $datedisplay == 2 ){
            $displaydate = $result->created;
        }else{
            $displaydate = max($result->modified, $result->created);
        }

        //take timezone for user into account
        $date = JFactory::getDate($displaydate, 'UTC');
        $date->setTimezone(new DateTimeZone($user->getParam('timezone', $config->get('offset'))));

	$formatteddate = $params->get('text_pre').$date->format($params->get('dateformat', 'l d-m-Y, H:i:s'), true, true).$params->get('text_post');

        return $formatteddate;

    }
}