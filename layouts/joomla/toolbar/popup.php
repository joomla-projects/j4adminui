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
use Joomla\Utilities\ArrayHelper;

HTMLHelper::_('behavior.core');
HTMLHelper::_('webcomponent', 'system/joomla-toolbar-button.min.js', ['version' => 'auto', 'relative' => true]);

/**
 * @var  int     $id
 * @var  string  $name
 * @var  string  $doTask
 * @var  string  $class
 * @var  string  $text
 * @var  string  $btnClass
 * @var  string  $tagName
 * @var  bool    $listCheck
 * @var  string  $htmlAttributes
 */
extract($displayData, EXTR_OVERWRITE);

$tagName = $tagName ?? 'button';

$modalAttrs['data-href'] = '#' . $selector;

$idAttr   = !empty($id)        ? ' id="' . $id . '"' : '';
$listAttr = !empty($listCheck) ? ' list-selection' : '';

?>
<joomla-toolbar-button <?php echo $idAttr.$listAttr; ?>>
<<?php echo $tagName; ?>
	value="<?php echo $doTask; ?>"
	class="<?php echo $btnClass; ?>"
	<?php echo $htmlAttributes; ?>
	<?php echo ArrayHelper::toString($modalAttrs); ?>
>
	<span class="<?php echo $class; ?> icon-md" aria-hidden="true"></span>
	<?php echo $text; ?>
</<?php echo $tagName; ?>>
</joomla-toolbar-button>
