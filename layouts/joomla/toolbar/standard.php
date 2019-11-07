<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('behavior.core');
HTMLHelper::_('webcomponent', 'system/joomla-toolbar-button.min.js', ['version' => 'auto', 'relative' => true]);

/**
 * @var  string  $id
 * @var  string  $onclick
 * @var  string  $class
 * @var  string  $text
 * @var  string  $btnClass
 * @var  string  $tagName
 * @var  string  $htmlAttributes
 * @var  string  $task             The task which should be executed
 * @var  bool    $listCheck        Boolean, whether selection from a list is needed
 * @var  string  $form             CSS selector for a target form
 * @var  bool    $formValidation   Whether the form need to be validated before run the task
 * @var  string  $message          Confirmation message before run the task
 *
 */
extract($displayData, EXTR_OVERWRITE);

$tagName  = $tagName ?? 'button';

$taskAttr = '';
$idAttr   = !empty($id)             ? ' id="' . $id . '"' : '';
$listAttr = !empty($listCheck)      ? ' list-selection' : '';
$formAttr = !empty($form)           ? ' form="' . $this->escape($form) . '"' : '';
$validate = !empty($formValidation) ? ' form-validation' : '';
$msgAttr  = !empty($message)        ? ' confirm-message="' . $this->escape($message) . '"' : '';

if (!empty($task))
{
	$taskAttr = ' task="' . $task . '"';
}
elseif (!empty($onclick))
{
	$htmlAttributes .= ' onclick="' . $onclick . '"';
}

$iconClass = '';

switch($class)
{
	case 'icon-apply':
	case 'icon-save':
	case 'icon-save-new':
	case 'icon-save-copy':
	case 'icon-cancel':
		$iconClass = false;
	break;
	case 'icon-featured':
		$iconClass = 'icon-star-full';
	break;
	case 'icon-checkin':
		$iconClass = 'icon-checkinmark';
	break;
	default:
		$iconClass = $class;
}
?>

<joomla-toolbar-button <?php echo $idAttr.$taskAttr.$listAttr.$formAttr.$validate.$msgAttr; ?>>
<?php if (!empty($group)) : ?>
<a href="#" class="dropdown-item">
	<?php if(!empty($iconClass)) : ?>
		<span class="<?php echo trim($iconClass ?? ''); ?> icon-md"></span>
	<?php endif; ?>
	<?php echo $text ?? ''; ?>
</a>
<?php else : ?>
<<?php echo $tagName; ?>
	class="<?php echo $btnClass ?? ''; ?>"
	<?php echo $htmlAttributes ?? ''; ?>
	>
	<?php if(!empty($iconClass)) : ?>
		<span class="<?php echo trim($iconClass ?? ''); ?> icon-md" aria-hidden="true"></span>
	<?php endif; ?>
	<?php echo $text ?? ''; ?>
</<?php echo $tagName; ?>>
<?php endif; ?>
</joomla-toolbar-button>