<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$data = $displayData;

$isClientSelector = $data['options']['selectorFieldName'] === 'client_id';
$clientOptions = $isClientSelector ? $data['view']->filterForm->getField('client_id')->options : array();

$state = $data['view']->get('State');

if ($state->get('filter.client_id', null) !== null)
{
	$defaultValue = $clientOptions ? $state->get('filter.client_id', 0) : 0;
}

if ($state->get('client_id', null) !== null)
{
	$defaultValue = $clientOptions ? $state->get('client_id', 0) : 0;
}

?>

<div class="js-stools-field-selector">
	<div class="sr-only">
		<?php echo $data['view']->filterForm->getField($data['options']['selectorFieldName'])->label; ?>
	</div>
	<?php if($isClientSelector) : ?>
		<div class="btn-group btn-justified btn-group-border" role="group">
			<?php foreach($clientOptions as $key => $option) : ?>
				<button type="button" class="btn js-stools-selector-btn <?php echo $defaultValue == $option->value ? 'btn-default btn-outline' : 'btn-secondary'; ?>" value="<?php echo $option->value; ?>"><?php echo $option->text; ?></button>
			<?php endforeach; ?>
		</div>
		<input type="hidden" value="<?php echo $defaultValue; ?>" class="js-stools-selector-client-id-field" name="client_id" />
	<?php else : ?>
		<?php echo $data['view']->filterForm->getField($data['options']['selectorFieldName'])->input; ?>
	<?php endif; ?>
</div>
