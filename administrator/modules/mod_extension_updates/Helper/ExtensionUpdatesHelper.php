<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_extension_updates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\ExtensionUpdates\Administrator\Helper;

defined('_JEXEC') or die;


use Joomla\CMS\Factory;
use Joomla\CMS\Extension\ExtensionHelper;

/**
 * mod_extension_updates_helper helper class for the module
 * 
 */
abstract class ExtensionUpdatesHelper
{
    public static function extractExtensionsContent() : array
    {
        $totalExtensions = static::getTotalInstalledExtensions();
        $updatableExtensions = static::getUpdateableExtensions();

        $content = array();

        $content['percentage'] = static::calculatePercentage($totalExtensions, $updatableExtensions);
        $content['updatableCount'] = count($updatableExtensions);
        $content['updatableInfo'] = static::groupExtensions($updatableExtensions);
        $content['updateJoomla'] = static::checkJoomlaUpdate();

        return $content;
    }

    private static function groupExtensions($extensions) : array
    {
        $result = array(
            'component' => 0,
            'plugin' => 0,
            'template' => 0,
            'module' => 0,
            'library' => 0,
            'package' => 0
        );

        if (empty($extensions)) 
        {
            return $result;
        }

        foreach($extensions as $extension)
        {
            $result[$extension->type]++;
        }

        return $result;
    }

    private static function calculatePercentage($total, $updatable) : float
    {
        $updatedExtensions = $total - count($updatable);
        $updatePercentage = (float)($updatedExtensions * 100) / $total;

        return round($updatePercentage);
    }
    
    private static function checkJoomlaUpdate(): bool
    {
        $updateModel = Factory::getApplication()->bootComponent('com_installer')
            ->getMVCFactory()->createModel('Update', 'Administrator', ['ignore_request' => true]);
        
        $eid = ExtensionHelper::getExtensionRecord('files_joomla')->extension_id;
        $updateModel->setState('filter.extension_id', $eid);
        $extensions = $updateModel->getItems();
        
        return !empty($extensions) ? true : false;
    }

    private static function getUpdateableExtensions() : array
    {
        $updateModel = Factory::getApplication()->bootComponent('com_installer')
            ->getMVCFactory()->createModel('Update', 'Administrator', ['ignore_request' => true]);
        
        $extensions = $updateModel->getItems();

        return $extensions;
    }

    private static function getTotalInstalledExtensions() : int
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query->select('COUNT(extension_id)')
            ->from($db->quoteName('#__extensions'))
            ->where($db->quoteName('name') . ' <> ' . $db->quote('files_joomla'));
        $db->setQuery($query);

        return $db->loadResult();
    }
}