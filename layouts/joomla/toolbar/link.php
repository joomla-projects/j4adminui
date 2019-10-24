<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

/**
 * @var  int     $id
 * @var  string  $name
 * @var  string  $class
 * @var  string  $text
 * @var  string  $btnClass
 * @var  string  $tagName
 * @var  string  $htmlAttributes
 */
extract($displayData, EXTR_OVERWRITE);


$id = isset($id) ? 'id="' . $id . '"' : '';

$margin = (strpos($url ?? '', 'index.php?option=com_config') === false) ? '' : '';
$target = empty($target) ? '' : 'target="' . $target . '"';
?>
<joomla-toolbar-button class="<?php echo $margin; ?>" <?php echo $id; ?>>
	<a
		class="<?php echo $btnClass; ?>"
		href="<?php echo $url; ?>"
		<?php echo $target; ?>
		<?php echo $htmlAttributes; ?>>
		<span class="<?php echo $class; ?> icon-md" aria-hidden="true"></span>
		<?php echo $text ?: ''; ?>
	</a>
</joomla-toolbar-button>
