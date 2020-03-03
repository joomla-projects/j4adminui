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
 * Helper class for the module mod_extension_updates
 *
 * @since 4.0.0
 */
abstract class ExtensionUpdatesHelper
{
	/**
	 * Installed extensions except core extensions
	 *
	 * @var	array
	 *
	 * @since 4.0.0
	 */
	private static $extensions = [];

	/**
	 * Get all the installed extensions except the core extensions
	 *
	 * @return	void
	 * @since 	4.0.0
	 */
	private static function getInstalledExtensionsExceptCore() : void
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query->select('type, element, client_id, folder')
			->from($db->quoteName('#__extensions'));
		$db->setQuery($query);

		$extensions = $db->loadObjectList();

		// Purge the core extensions form the calcuation
		if (!empty($extensions) && is_array($extensions))
		{
			foreach ($extensions as $index => $ext)
			{
				// Check if the extension is a core extension, then remove it from the array
				if (ExtensionHelper::checkIfCoreExtension($ext->type, $ext->element, $ext->client_id, $ext->folder))
				{
					unset($extensions[$index]);
				}
			}
		}

		self::$extensions = array_values($extensions);
	}

	/**
	 * Get all the extensions
	 *
	 * @return	array	The extensions
	 *
	 * @since 4.0.0
	 */
	public function getExtensions() : array
	{
		return self::$extensions;
	}

	/**
	 * Count the total extensions except core extensions
	 *
	 * @return	int	The total number of extensions
	 *
	 * @since 	4.0.0
	 */
	private function getTotalExtensions() : int
	{
		return \count(self::$extensions);
	}

	/**
	 * Extract all the extensions contents i.e. Total number of extensions,
	 * Total updatable extensions, Joomla! core update status
	 *
	 * @return	array	Extensions contents
	 *
	 * @since	4.0.0
	 */
	public static function extractExtensionsContent() : array
	{
		self::getInstalledExtensionsExceptCore();

		$totalNoncoreExtensions = self::getTotalExtensions();
		$outdatedExtensions 	= self::getOutdatedExtensions();

		return array(
			'percentage' => self::calculatePercentage($totalNoncoreExtensions, $outdatedExtensions),
			'updatableCount' => \count($outdatedExtensions),
			'updatableInfo' => self::groupExtensions($outdatedExtensions),
			'updateJoomla' => self::checkJoomlaUpdate()
		);
	}

	/**
	 * Group outdated extensions by it's types
	 *
	 * @param	array	$extensions		Outdated extensions
	 *
	 * @return	array	Grouped updatable/outdated extensions
	 *
	 * @since 	4.0.0
	 */
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

		foreach ($extensions as $extension)
		{
			$result[$extension->type]++;
		}

		return $result;
	}

	/**
	 * Calculation of updated extensions percentage.
	 * This is assuming that the Joomla! along with core extensions takes 50% of the total extensions,
	 * That means if Joomla! is outdated then the 50% of the system is outdated
	 *
	 * @param	int		$total		Total number of extensions
	 * @param	int		$outdated	Total number of updatable extensions
	 *
	 * @return	int		Percentage of system update status
	 *
	 * @since	4.0.0
	 */
	private static function calculatePercentage($total, $outdated) : int
	{
		$isJoomlaOutdated	= self::checkJoomlaUpdate();
		$updatedExtensions 	= $total - \count($outdated);

		$percentage = (float) ($updatedExtensions * 0.5 * 100) / $total;

		// If Joomla! is not outdated then add the 50% with the percentage.
		if (!$isJoomlaOutdated)
		{
			$percentage = $percentage + 50;
		}

		return floor($percentage);
	}

	/**
	 * Check Joomla! core update status
	 *
	 * @return	mixed	Latest Joomla! version or false
	 *
	 * @since 4.0.0
	 */
	private static function checkJoomlaUpdate()
	{
		$updateModel = Factory::getApplication()
			->bootComponent('com_installer')
			->getMVCFactory()
			->createModel('Update', 'Administrator', ['ignore_request' => true]);

		$eid = ExtensionHelper::getExtensionRecord('files_joomla')->extension_id;
		$updateModel->setState('filter.extension_id', $eid);
		$extensions = $updateModel->getItems();

		return !empty($extensions) ? $extensions[0]->version : false;
	}


	/**
	 * Get outdated extensions except core extensions
	 *
	 * @return	array	Outdated extensions
	 *
	 * @since 4.0.0
	 */
	private static function getOutdatedExtensions() : array
	{
		$updateModel = Factory::getApplication()
			->bootComponent('com_installer')
			->getMVCFactory()
			->createModel('Update', 'Administrator', ['ignore_request' => true]);

		$extensions = $updateModel->getItems();

		if (!empty($extensions))
		{
			foreach ($extensions as $index => $ext)
			{
				if (ExtensionHelper::checkIfCoreExtension($ext->type, $ext->element, $ext->client_id, $ext->folder))
				{
					unset($extensions[$index]);
				}
			}
		}

		return array_values($extensions);
	}
}
