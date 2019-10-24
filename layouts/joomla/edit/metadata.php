<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;

HTMLHelper::_('webcomponent', 'system/joomla-callout.min.js', array('version'=> 'auto', 'relative' => true));

$form = $displayData->getForm();

// JLayout for standard handling of metadata fields in the administrator content edit screens.
$fieldSets = $form->getFieldsets('metadata');
?>

<?php foreach ($fieldSets as $name => $fieldSet) : ?>
	<?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
		<div class="j-alert j-alert-info mt-0 mb-4">
			<span class="icon-info-circle" aria-hidden="true"></span><span class="sr-only"><?php echo Text::_('INFO'); ?></span>
			<?php echo $this->escape(Text::_($fieldSet->description)); ?>
		</div>
	<?php endif; ?>

	<?php
	// Include the real fields in this panel.
	if ($name === 'jmetadata')
	{
		echo $form->renderField('metadesc');
		echo $form->renderField('metakey');
	}
	?>

	<a href="javascript:;" id="jmetadata-callout" class="btn btn-secondary btn-block"><span class="icon-options-cog" area-hidden="true"></span> <?php echo Text::_('JGLOBAL_FIELDSET_SEO_ADVANCED_OPTIONS'); ?></a>
	<joomla-callout for="#jmetadata-callout" dismiss="true" position="bottom">
		<div class="callout-content">
		<?php
		foreach ($form->getFieldset($name) as $field)
		{
			if ($field->name !== 'jform[metadata][tags][]')
			{
				echo $field->renderField();
			}
		} ?>
		</div>
	</joomla-callout>
<?php endforeach; ?>
