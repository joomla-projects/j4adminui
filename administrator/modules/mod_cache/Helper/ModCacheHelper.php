<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_latest
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Module\Content\Administrator\Helper;

defined('_JEXEC') or die;

use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Administrator\Model\ArticlesModel;
use Joomla\Registry\Registry;

/**
 * Helper for mod_cache
 *
 * @since  4.0
 */
abstract class ModCacheHelper
{
	/**
	 * Get a list of articles.
	 *
	 * @param   Registry       &$params  The module parameters.
	 * @param   ArticlesModel  $model    The model.
	 *
	 * @return  mixed  An array of articles, or false on error.
	 */
	public static function clearCache()
	{
		// $app->setHeader('status', 200, true);
        // $app->sendHeaders();
        // echo new JsonResponse($articleid);
		// $app->close();
		
		echo \json_encode('joomla');
		die();

	}
}
