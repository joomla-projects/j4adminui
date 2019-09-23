<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('bootstrap.popover');

/**
 * @var $icon    string
 * @var $title   string
 * @var $value   string
 * @var $task    string
 * @var $options array
 */
extract($displayData, EXTR_OVERWRITE);

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

$default = [
    HTMLHelper::_('select.option', '', $this->escape($options['stage'])),
    HTMLHelper::_('select.option', '-1', '--------', ['disable' => true])
];

$transitions = array_merge($default, $options['transitions']);

$attribs = [
    'id'        => 'transition-select_' . (int) $id,
    'list.attr' => [
        'class'    => 'custom-select custom-select-sm form-control form-control-sm',
        'data-color' => $color,
        'onchange' => "Joomla.listItemTask('" . $checkboxName . $this->escape($row ?? '') . "', 'articles.runTransition')"]
    ];
?>

<div id="publishColloutId-<?php echo $id; ?>" class="j-transition-group">
    <?php echo HTMLHelper::_('select.genericlist', $transitions, 'transition_' . (int) $id, $attribs); ?>
</div>

<joomla-callout action="hover" for="#publishColloutId-<?php echo $id; ?>" position="top">
    <div class="callout-title"><?php echo HTMLHelper::_('tooltipText', Text::_($tipTitle ? : $title), '', 0); ?></div>
    <div class="callout-content"><?php echo HTMLHelper::_('tooltipText', Text::_($title), '', 0); ?></div>
</joomla-callout>