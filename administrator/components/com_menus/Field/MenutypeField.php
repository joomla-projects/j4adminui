<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_menus
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Menus\Administrator\Field;

defined('JPATH_BASE') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Object\CMSObject;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Form\Field\ListField;
use Joomla\Component\Menus\Administrator\Helper\MenusHelper;

/**
 * Menu Type field.
 *
 * @since  1.6
 */
class MenutypeField extends ListField
{
	/**
	 * The form field type.
	 *
	 * @var     string
	 * @since   1.6
	 */
	protected $type = 'menutype';

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   1.6
	 */
	protected function getInput()
	{
		HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', array('version' => 'auto', 'relative' => true));
		HTMLHelper::_('script', 'com_menus/admin-item-modal.js', ['version' => 'auto', 'relative' => true]);

		$html     = array();
		$recordId = (int) $this->form->getValue('id');
		$size     = (string) ($v = $this->element['size']) ? ' size="' . $v . '"' : '';
		$class    = (string) ($v = $this->element['class']) ? ' class="form-control ' . $v . '"' : ' class="form-control"';
		$required = (string) $this->element['required'] ? ' required="required"' : '';
		$clientId = (int) $this->element['clientid'] ?: 0;

		$input = Factory::getApplication()->input;

		// Checking if loaded via index.php or component.php
		$tmpl = ($input->getCmd('tmpl', 'component') != '') ? '1' : '';
		$tmpl = "'" . json_encode($tmpl, JSON_NUMERIC_CHECK) . "'";

		$menuTypes = $this->getMenuTypes($clientId);

		// Get a reverse lookup of the base link URL to Title
		switch ($this->value)
		{
			case 'url':
				$value = Text::_('COM_MENUS_TYPE_EXTERNAL_URL');
				break;

			case 'alias':
				$value = Text::_('COM_MENUS_TYPE_ALIAS');
				break;

			case 'separator':
				$value = Text::_('COM_MENUS_TYPE_SEPARATOR');
				break;

			case 'heading':
				$value = Text::_('COM_MENUS_TYPE_HEADING');
				break;

			case 'container':
				$value = Text::_('COM_MENUS_TYPE_CONTAINER');
				break;

			default:
				$link = $this->form->getValue('link');

				$model = Factory::getApplication()->bootComponent('com_menus')
					->getMVCFactory()->createModel('Menutypes', 'Administrator', array('ignore_request' => true));
				$model->setState('client_id', $clientId);

				$rlu   = $model->getReverseLookup();

				// Clean the link back to the option, view and layout
				$value = Text::_(ArrayHelper::getValue($rlu, MenusHelper::getLinkKey($link)));
				break;
		}

		$dropdownText = Text::_('JSELECT') . ' <span class="icon-caret-v" area-hidden="true"></span>';

		if (!empty($value))
		{
			$dropdownText = $value . ' <span class="icon-caret-v" area-hidden="true"></span>';
		}

		$html[] = '<a href="javascript:" class="btn btn-secondary text-left j-has-dropdown" data-target="menuTypeDropdown">' . $dropdownText . '</a>';
		$html[] = '<joomla-dropdown for="menuTypeDropdown">';

		if (!empty($menuTypes))
		{
			foreach ($menuTypes as $name => $children)
			{
				if (!empty($children))
				{
					$html[] = '<li class="has-submenu" data-action="hover">';
					$html[] = '<a class="dropdown-item">' . $name . '</a>';
					$html[] = '<ul class="submenu">';

					foreach ($children as $child)
					{
						$menutype = array('id' => $recordId, 'title' => $child->type ?? $child->title, 'request' => $child->request);
						$menutype = "'" . base64_encode(json_encode($menutype)) . "'";
						$html[] = '<li><a class="dropdown-item" href="javascript:" onclick="Joomla.setMenuType(' . $menutype . ', ' . $tmpl . ');">';
						$html[] = '<h4 class="menu-item-title">' . Text::_($child->title) . '</h4>';
						$html[] = '<span class="text-mute">' . Text::_($child->description) . '</span>';
						$html[] = '</a></li>';
					}

					$html[] = '</ul>';
					$html[] = '</li>';
				}
				else
				{
					$html[] = '<li><a class="dropdown-item" href="javascript:">' . $name . '</a></li>';
				}
			}
		}

		$html[] = '</joomla-dropdown>';

		$html[] = '<input type="hidden" ' . $required . ' readonly="readonly" id="' . $this->id
			. '" value="' . $value . '"' . $size . $class . '>';
		$html[] = '<input type="hidden" name="' . $this->name . '" value="'
			. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" id="' . $this->id . '_val">';

		return implode("\n", $html);
	}

	/**
	 * Get all menu types
	 *
	 * @param 	int		$clientId	Current clientId
	 *
	 * @return 	array
	 *
	 * @since 	4.0.0
	 */
	private function getMenuTypes($clientId)
	{
		$model = Factory::getApplication()->bootComponent('com_menus')
			->getMVCFactory()->createModel('Menutypes', 'Administrator', array('ignore_request' => true));

		$state = $model->getState();
		$model->setState('client_id', $clientId);

		$types = $model->getTypeOptions();
		$this->addCustomTypes($types, $state);

		$sortedTypes = array();

		foreach ($types as $name => $list)
		{
			$tmp = array();

			foreach ($list as $item)
			{
				$tmp[Text::_($item->title)] = $item;
			}

			uksort($tmp, 'strcasecmp');
			$sortedTypes[Text::_($name)] = $tmp;
		}

		uksort($sortedTypes, 'strcasecmp');

		return $sortedTypes;
	}

	/**
	 * Method to add system link types to the link types array
	 *
	 * @param   array	$types	The list of link types
	 * @param	object	$state	Load joomla current state
	 *
	 * @return	void
	 *
	 * @since	4.0.0
	 */
	private function addCustomTypes(&$types, $state)
	{
		if (empty($types))
		{
			$types = array();
		}

		// Adding System Links
		$list           = array();
		$o              = new CMSObject;
		$o->title       = 'COM_MENUS_TYPE_EXTERNAL_URL';
		$o->type        = 'url';
		$o->description = 'COM_MENUS_TYPE_EXTERNAL_URL_DESC';
		$o->request     = null;
		$list[]         = $o;

		$o              = new CMSObject;
		$o->title       = 'COM_MENUS_TYPE_ALIAS';
		$o->type        = 'alias';
		$o->description = 'COM_MENUS_TYPE_ALIAS_DESC';
		$o->request     = null;
		$list[]         = $o;

		$o              = new CMSObject;
		$o->title       = 'COM_MENUS_TYPE_SEPARATOR';
		$o->type        = 'separator';
		$o->description = 'COM_MENUS_TYPE_SEPARATOR_DESC';
		$o->request     = null;
		$list[]         = $o;

		$o              = new CMSObject;
		$o->title       = 'COM_MENUS_TYPE_HEADING';
		$o->type        = 'heading';
		$o->description = 'COM_MENUS_TYPE_HEADING_DESC';
		$o->request     = null;
		$list[]         = $o;

		if ($state->get('client_id') == 1)
		{
			$o              = new CMSObject;
			$o->title       = 'COM_MENUS_TYPE_CONTAINER';
			$o->type        = 'container';
			$o->description = 'COM_MENUS_TYPE_CONTAINER_DESC';
			$o->request     = null;
			$list[]         = $o;
		}

		$types['COM_MENUS_TYPE_SYSTEM'] = $list;
	}
}
