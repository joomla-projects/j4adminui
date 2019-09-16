<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Multilanguage;

$app       = Factory::getApplication();
$form      = $displayData['data']->getForm();

$input     = $app->input;
$component = $input->getCmd('option', 'com_content');

if ($component === 'com_categories')
{
	$extension = $input->getCmd('extension', 'com_content');
	$parts     = explode('.', $extension);
	$component = $parts[0];
}

$saveHistory = ComponentHelper::getParams($component)->get('save_history', 0);
$fields = ( isset($displayData['fields']) && $displayData['fields'] ) ? $displayData['fields'] : array(
	'transition',
	array('parent', 'parent_id'),
	array('published', 'state', 'enabled'),
	array('category', 'catid'),
	'featured',
	'sticky',
	'access',
	'language',
	'tags',
	'note',
	'version_note',
);

$hiddenFields   = ( isset($displayData['data']->hidden_fields) && $displayData['data']->hidden_fields ) ? $displayData['data']->hidden_fields : array();

if (!$saveHistory)
{
	$hiddenFields[] = 'version_note';
}

if (!Multilanguage::isEnabled())
{
	$hiddenFields[] = 'language';
	$form->setFieldAttribute('language', 'default', '*');
}

$html   = array();
$html[] = '<fieldset class="form-vertical">';

foreach ($fields as $field)
{
	foreach ((array) $field as $f)
	{
		if ($form->getField($f))
		{
			if (in_array($f, $hiddenFields))
			{
				$form->setFieldAttribute($f, 'type', 'hidden');
			}

			$html[] = $form->renderField($f);
			break;
		}
	}
}

$html[] = '</fieldset>';

echo implode('', $html);
