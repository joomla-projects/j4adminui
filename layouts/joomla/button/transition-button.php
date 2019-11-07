<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;


HTMLHelper::_('bootstrap.popover');

/**
 * @var $icon    string
 * @var $title   string
 * @var $value   string
 * @var $task    string
 * @var $options array
 */
extract($displayData, EXTR_OVERWRITE);

HTMLHelper::_('webcomponent', 'system/joomla-dropdown.min.js', ['version' => 'auto', 'relative' => true]);

$only_icon = empty($options['transitions']);
$disabled = !empty($options['disabled']);
$tip = !empty($options['tip']);
$id = (int) $options['id'];
$tipTitle = $options['tip_title'];
$checkboxName = $options['checkbox_name'];

switch(strtoupper($options['stage']))
{
	case 'UNPUBLISHED':
		$color = 'danger';
	break;
	case 'PUBLISHED':
		$color = 'success';
	break;
	case 'TRASHED':
		$color = 'warning';
	break;
	default:
		$color = 'primary';
}

$transitions = json_decode(json_encode($options['transitions']));

Factory::getDocument()->addScriptDeclaration("
	function handleRunTransition(e, id, cb, task = 'articles.runTransition') {
		document.getElementById(id).value = e.dataset.value;
		Joomla.listItemTask(cb, task);
	}
");

$attribs = [
	'id'        => 'transition-select_' . (int) $id,
	'list.attr' => [
		'class'    => 'custom-select custom-select-sm form-control form-control-sm',
		'onchange' => "Joomla.listItemTask('" . $checkboxName . $this->escape($row ?? '') . "', 'articles.runTransition')"]
];

?>


<div id="publishColloutId-<?php echo $id; ?>" class="j-transition-group" data-color="<?php echo $color; ?>">
	<a href="#" class="j-transition-select" data-target="<?php echo 'transition-select_' . (int) $id; ?>"><?php echo $this->escape($options['stage']); ?> <span class="icon-chevron-down"></span></a>
	<joomla-dropdown for="<?php echo 'transition-select_' . (int) $id; ?>">
		<?php foreach($transitions as $transition) : ?>
			<li><a href="javascript:" class="dropdown-item" onclick="handleRunTransition(this, <?php echo '\'' . 'transition_' . (int) $id . '\''; ?>, <?php echo '\'' . $checkboxName . $this->escape($row ?? '') . '\'' ?>);" data-value="<?php echo $transition->value; ?>"><?php echo $transition->text; ?></a></li>
		<?php endforeach; ?>
		<input type="hidden" id="transition_<?php echo (int) $id; ?>" name="transition_<?php echo (int) $id; ?>" value="">
	</joomla-dropdown>
</div>

<joomla-callout action="hover" for="#publishColloutId-<?php echo $id; ?>" position="top">
	<div class="callout-title"><?php echo HTMLHelper::_('tooltipText', Text::_($tipTitle ? : $title), '', 0); ?></div>
	<div class="callout-content"><?php echo HTMLHelper::_('tooltipText', Text::_($title), '', 0); ?></div>
</joomla-callout>