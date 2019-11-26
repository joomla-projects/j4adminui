<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Cpanel\Administrator\View\Cpanel;

defined('_JEXEC') or die;

use Joomla\CMS\Application\ApplicationHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Helper\ModuleHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;

/**
 * HTML View class for the Cpanel component
 *
 * @since  1.0
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * Array of cpanel modules
	 *
	 * @var  array
	 */
	protected $modules = null;

	/**
	 * Array of cpanel modules
	 *
	 * @var  array
	 */
	protected $quickicons = null;

	/**
	 * Moduleposition to load
	 *
	 * @var  string
	 */
	protected $position = null;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{
		$app = Factory::getApplication();
		$this->extension = ApplicationHelper::stringURLSafe($app->input->getCmd('dashboard'));

		$title = Text::_('COM_CPANEL_DASHBOARD_BASE_TITLE');
		$icon  = 'dashboard';

		$position = ApplicationHelper::stringURLSafe($this->extension);

		// Generate a title for the view cpanel
		if (!empty($this->extension))
		{
			$parts = explode('.', $this->extension);

			$prefix = 'COM_CPANEL_DASHBOARD_';
			$lang = Factory::getLanguage();

			if (strpos($parts[0], 'com_') === false)
			{
				$prefix .= strtoupper($parts[0]);
			}
			else
			{
				$prefix = strtoupper($parts[0]) . '_DASHBOARD';

				// Need to load the language file
				$lang->load($parts[0], JPATH_BASE, null, false, true)
				|| $lang->load($parts[0], JPATH_ADMINISTRATOR . '/components/' . $parts[0], null, false, true);
				$lang->load($parts[0]);
			}

			$sectionkey = !empty($parts[1]) ? '_' . strtoupper($parts[1]) : '';
			$key = $prefix . $sectionkey . '_TITLE';
			$keyIcon = $prefix . $sectionkey . '_ICON';

			// Search for a component title
			if ($lang->hasKey($key))
			{
				$title = Text::_($key);
			}

			if (empty($parts[1]))
			{
				// Default core icons.
				if ($parts[0] === 'content')
				{
					$icon = 'fa fa-file-alt';
				}
				elseif ($parts[0] === 'components')
				{
					$icon = 'fa fa-puzzle-piece';
				}
				elseif ($parts[0] === 'menus')
				{
					$icon = 'fa fa-list';
				}
				elseif ($parts[0] === 'system')
				{
					$icon = 'fa fa-wrench';
				}
				elseif ($parts[0] === 'users')
				{
					$icon = 'fa fa-users';
				}
				elseif ($parts[0] === 'privacy')
				{
					$icon = 'lock';
				}
				elseif ($parts[0] === 'help')
				{
					$icon = 'fa fa-info-circle';
				}
				elseif ($lang->hasKey($keyIcon))
				{
					$icon = Text::_($keyIcon);
				}
				else
				{
					$icon = '';
				}
			}
			elseif ($lang->hasKey($keyIcon))
			{
				$icon = Text::_($keyIcon);
			}
		}

		// Set toolbar items for the page
		ToolbarHelper::title($title, $icon . ' cpanel');
		ToolbarHelper::help('screen.cpanel');

		// Display the cpanel modules
		$this->position = $position ? 'cpanel-' . $position : 'cpanel';
		$this->modules = ModuleHelper::getModules($this->position);

		// Grouping the dashboard modules by quickicons, left column, right columns
		$modules = array(
			'quickicon' => array(),
			'left_column' => array(),
			'right_column' => array()
		);

		foreach ($this->modules as $module)
		{
			if ($module->module === 'mod_quickicon')
			{
				$modules['quickicon'][] = $module;
			}
			else
			{
				$params = json_decode($module->params);

				if (!empty($params->column_position))
				{
					if ($params->column_position === 0)
					{
						$modules['left_column'][] = $module;
					}
					else
					{
						$modules['right_column'][] = $module;
					}
				}
				else
				{
					$modules['left_column'][] = $module;
				}
			}
		}

		// Sort left column by ordering key.
		\usort($modules['left_column'],
			function ($a, $b)
			{
				return $a->ordering <=> $b->ordering;
			}
		);

		// Sort rigth column by ordering key
		\usort($modules['right_column'],
			function ($a, $b)
			{
				return $a->ordering <=> $b->ordering;
			}
		);

		$this->modules = $modules;

		parent::display($tpl);
	}
}
