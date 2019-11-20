<?php
/**
 * @package     Joomla.Libraries
 * @subpackage  HTML
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;

/**
 * Utility class for Webcomponent elements.
 *
 * @since  4.0.0
 */
abstract class JHtmlWebcomponent
{
	/**
	 * @var    array  Array containing information for loaded files
	 * @since  4.0.0
	 */
	protected static $loaded = array();

	/**
	 * Method to render modal web-component
	 *
	 * @component   joomla-modal
	 *
	 * @param   string  $selector  The ID selector for the modal.
	 *
	 * @since  4.0.0
	 */
	public static function renderModal($selector = 'modal', $params = array(), $body = '')
	{
		// Only load once
		if (!empty(static::$loaded[__METHOD__][$selector]))
		{
			return;
		}

		// Include joomla-modal webcomponent assets (js)
		HTMLHelper::_('webcomponent.assets', 'joomla-modal');

		$layoutData = array(
			'selector' => $selector,
			'params'   => $params,
			'body'     => $body,
		);

		static::$loaded[__METHOD__][$selector] = true;

		return LayoutHelper::render('joomla.webcomponent.modal.main', $layoutData);
	}

	/**
	 * Method to load the webcomponent JavaScript library into the document head
	 *
	 * If debugging mode is on an uncompressed version of Bootstrap is included for easier debugging.
	 *
	 * @param   mixed  $debug  Is debugging mode on? [optional]
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public static function assets($filename, $debug = null)
	{
		// Only load once
		if (!empty(static::$loaded[__METHOD__][$filename]))
		{
			return;
		}

		$debug = (isset($debug) && $debug != JDEBUG) ? $debug : JDEBUG;

		// Load the needed scripts
		HTMLHelper::_('webcomponent', 'system/' . $filename . '.min.js', array('version' => 'auto', 'relative' => true, 'detectDebug' => $debug));

		static::$loaded[__METHOD__][$filename] = true;
	}
}
