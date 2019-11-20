<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_extension_updates
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\Checkins\Administrator\Helper;

defined('_JEXEC') or die;


use Joomla\CMS\Factory;

/**
 * mod_checkins_helper, The helper class for the module
 *
 * @since 4.0.0
 */

class CheckinsHelper
{
	/**
	 * Extract and calculate total number of checkin
	 *
	 * @return	int	Total number of checkins
	 *
	 * @since 4.0.0
	 */
	public static function extractCheckinContent() : int
	{
		$checkinModel = Factory::getApplication()->bootComponent('com_checkin')
			->getMVCFactory()->createModel('Checkin', 'Administrator', ['ignore_request' => true]);

		$checkins = $checkinModel->getItems();

		$totalCheckins = 0;

		if (!empty($checkins))
		{
			foreach ($checkins as $checkin)
			{
				$totalCheckins += (int) $checkin;
			}
		}

		return $totalCheckins;
	}
}

