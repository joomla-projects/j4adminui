<?php
/**
 * @package     Joomla.Admin
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/**
 * Layout variables
 * ---------------------
 *
 * @var  string   $asset The asset text
 * @var  string   $authorField The label text
 * @var  integer  $authorId The author id
 * @var  string   $class The class text
 * @var  boolean  $disabled True if field is disabled
 * @var  string   $folder The folder text
 * @var  string   $id The label text
 * @var  string   $link The link text
 * @var  string   $name The name text
 * @var  string   $preview The preview image relative path
 * @var  integer  $previewHeight The image preview height
 * @var  integer  $previewWidth The image preview width
 * @var  string   $onchange  The onchange text
 * @var  boolean  $readonly True if field is readonly
 * @var  integer  $size The size text
 * @var  string   $value The value text
 * @var  string   $src The path and filename of the image
 */
extract($displayData);

$attr = '';

// Initialize some field attributes.
$attr .= !empty($class) ? ' class="form-control field-media-input ' . $class . '"' : ' class="form-control field-media-input"';
$attr .= !empty($size) ? ' size="' . $size . '"' : '';

// Initialize JavaScript field attributes.
$attr .= !empty($onchange) ? ' onchange="' . $onchange . '"' : '';

switch ($preview)
{
	case 'no': // Deprecated parameter value
	case 'false':
	case 'none':
		$showPreview = false;
		break;
	case 'yes': // Deprecated parameter value
	case 'true':
	case 'show':
	case 'tooltip':
	default:
		$showPreview = true;
		break;
}

// Pre fill the contents of the popover
if ($showPreview)
{
	if ($value && file_exists(JPATH_ROOT . '/' . $value))
	{
		$src = Uri::root() . $value;
	}
	else
	{
		$src = '';
	}
	$width = $previewWidth;
	$height = $previewHeight;
	$style = '';
	$style .= ($width > 0) ? 'max-width:' . $width . 'px;' : '';
	$style .= ($height > 0) ? 'max-height:' . $height . 'px;' : '';

	$imgattr = array(
		'id' => $id . '_preview',
		'class' => 'media-preview',
		'style' => $style,
	);

	$img = HTMLHelper::_('image', $src, Text::_('JLIB_FORM_MEDIA_PREVIEW_ALT'), $imgattr);

	$previewImg = '<div id="' . $id . '_preview_img"' . '>' . $img . '</div>';
	$previewImgEmpty = '<div id="' . $id . '_preview_empty"' . ($src ? ' style="display:none"' : '') . '>'
		. Text::_('JLIB_FORM_MEDIA_PREVIEW_EMPTY') . '</div>';

	$showPreview = 'static';
}

// The url for the modal
$url    = ($readonly ? ''
	: ($link ? $link
		: 'index.php?option=com_media&amp;tmpl=component&amp;asset='
		. $asset . '&amp;author=' . $authorId)
	. '&amp;fieldid={field-media-id}&amp;path=local-0:/' . $folder);
?>
<joomla-field-media class="field-media-wrapper"
		type="image" <?php // @TODO add this attribute to the field in order to use it for all media types ?>
		base-path="<?php echo Uri::root(); ?>"
		root-folder="<?php echo ComponentHelper::getParams('com_media')->get('file_path', 'images'); ?>"
		url="<?php echo $url; ?>"
		modal-container=".modal"
		modal-width="100%"
		modal-height="400px"
		input=".field-media-input"
		button-select=".button-select"
		button-clear=".button-clear"
		button-save-selected=".button-save-selected"
		preview="static"
		preview-container=".field-media-preview"
		preview-width="<?php echo $previewWidth; ?>"
		preview-height="<?php echo $previewHeight; ?>"
		has-preview-image="<?php echo $src !== ""; ?>"
>
	<input type="text" name="<?php echo $name; ?>" id="<?php echo $id; ?>" value="<?php echo htmlspecialchars($value, ENT_COMPAT, 'UTF-8'); ?>" readonly="readonly"<?php echo $attr; ?>>
	<?php
	HTMLHelper::_('webcomponent', 'system/joomla-modal.min.js', ['version' => 'auto', 'relative' => true]);
	HTMLHelper::_('webcomponent', 'system/fields/joomla-field-media.min.js', ['version' => 'auto', 'relative' => true]);
	Text::script('JLIB_FORM_MEDIA_PREVIEW_EMPTY', true);
	?>
	<joomla-modal role="dialog" id="imageModal_<?php echo $id; ?>" title="<?php echo Text::_('JLIB_FORM_CHANGE_IMAGE'); ?>" width="85vw" height="75vh" iframe="<?php echo $url ?>">
		<section>&nbsp;</section>
		<footer>
			<button type="button" class="btn btn-secondary button-save-selected"><?php echo Text::_('JSELECT'); ?></button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo Text::_('JCANCEL'); ?></button>
		</footer>
	</joomla-modal>
	<div class="field-media-preview-wrapper">
		<?php if ($showPreview) : ?>
			<div class="field-media-preview">
				<?php echo ' ' . $previewImgEmpty; ?>
				<?php echo ' ' . $previewImg; ?>
			</div>
			<button type="button" class="btn btn-secondary button-clear"><?php echo Text::_("JLIB_FORM_BUTTON_REMOVE_MEDIA"); ?></button>
		<?php endif; ?>

		<?php if ($disabled != true) : ?>
			<button  type="button" class="btn btn-link button-select"><span class="icon icon-plus" aria-hidden="true"></span><?php echo Text::_("JLIB_FORM_BUTTON_ADD_MEDIA"); ?></button>
		<?php endif; ?>
	</div>

</joomla-field-media>
