<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_plugins
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Plugins\Administrator\View\Plugin;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\MVC\View\GenericDataException;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * View to edit a plugin.
 *
 * @since  1.5
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * The item object for the newsfeed
	 *
	 * @var    \JObject
	 */
	protected $item;

	/**
	 * The form object for the newsfeed
	 *
	 * @var    \JForm
	 */
	protected $form;

	/**
	 * The model state of the newsfeed
	 *
	 * @var    \JObject
	 */
	protected $state;

	/**
	 * Display the view.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new GenericDataException(implode("\n", $errors), 500);
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		Factory::getApplication()->input->set('hidemainmenu', true);
		$canDo = ContentHelper::getActions('com_plugins');
		$toolbar = Toolbar::getInstance();

		// Get the help information for the plugin item.
		$lang = Factory::getLanguage();

		ToolbarHelper::divider();
		$help = $this->get('Help');

		if ($lang->hasKey($help->url))
		{
			$debug = $lang->setDebug(false);
			$url = Text::_($help->url);
			$lang->setDebug($debug);
		}
		else
		{
			$url = null;
		}

		// Set page title
		ToolbarHelper::title(Text::sprintf('COM_PLUGINS_MANAGER_PLUGIN', Text::_($this->item->name)), 'plugins plugin');

		// Help button
		ToolbarHelper::help($help->key, false, $url);

		// Cancel button
		ToolbarHelper::cancel('plugin.cancel', 'JTOOLBAR_CLOSE');

		// Save item group
		$saveGroup = $toolbar->dropdownButton('save-group');

		$saveGroup->configure(
			function (Toolbar $childBar) use ($canDo)
			{
				// If not checked out, can save the item.
				if ($canDo->get('core.edit'))
				{
					$childBar->apply('plugin.apply');
					$childBar->save('plugin.save');
				}
			}
		);
	}
}
