<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_accessibility
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

 defined('_JEXEC') or die;

 use Joomla\CMS\Factory;
 use Joomla\CMS\Language\Text;
 use Joomla\CMS\Response\JsonResponse;

/**
 * mod_accessobility_helper helper class for the module
 * 
 */
class ModAccessibilityHelper
{
    public static function doAccessibleAjax()
	{
		$app = Factory::getApplication();

		// declare variables
		$data = array();
		$data['status'] = false;
		
        
		echo new JsonResponse('joomla');
		
        //echo new JsonResponse($data);
		$app->close();
    }
}