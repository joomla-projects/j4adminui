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
use Joomla\Registry\Registry;

$data = $displayData;

Text::script('JFILTER_SHOW_FILTER', true);
Text::script('JFILTER_HIDE_FILTER', true);

// Receive overridable options
$data['options'] = !empty($data['options']) ? $data['options'] : array();

if (is_array($data['options']))
{
	$data['options'] = new Registry($data['options']);
}

// Options
$filterButton 	= $data['options']->get('filterButton', true);
$searchButton 	= $data['options']->get('searchButton', true);
$clearButton 	= $data['options']->get('filtersHidden', false);

$filters = $data['view']->filterForm->getGroup('filter');
?>

<?php if (!empty($filters['filter_search'])) : ?>
	<?php if ($searchButton) : ?>
		<div class="btn-group js-stools-input">
			<div class="input-group">
				<label for="filter_search" class="sr-only">
					<?php if (isset($filters['filter_search']->label)) : ?>
						<?php echo Text::_($filters['filter_search']->label); ?>
					<?php else : ?>
						<?php echo Text::_('JSEARCH_FILTER'); ?>
					<?php endif; ?>
				</label>
				<?php echo $filters['filter_search']->input; ?>
				<?php if ($filters['filter_search']->description) : ?>
				<div role="tooltip" id="<?php echo $filters['filter_search']->name . '-desc'; ?>">
					<?php echo htmlspecialchars(Text::_($filters['filter_search']->description), ENT_COMPAT, 'UTF-8'); ?>
				</div>
				<?php endif; ?>
				<span class="input-group-append">
					<button type="submit" class="btn btn-primary" aria-label="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<span class="icon-search" aria-hidden="true"></span>
					</button>
				</span>
			</div>
		</div>
		<?php if($filterButton) : ?>
			<button type="button" class="hasTooltip js-stools-btn-filter btn btn-filter ml-3">
				<span class="icon-filter mr-2" aria-hidden="true"></span>
				<span class="js-stools-filter-btn-text" data-status="<?php echo $clearButton ? '1' : '0'; ?>"><?php echo $clearButton ? Text::_('JFILTER_SHOW_FILTER') : Text::_('JFILTER_HIDE_FILTER'); ?></span>
				<?php if ($clearButton) : ?>
					<span class="icon-plus-circle js-stools-right ml-2" aria-hidden="true"></span>
				<?php else : ?>
					<span class="icon-minus-circle js-stools-right ml-2" aria-hidden="true"></span>
				<?php endif; ?>
			</button>
			<button type="button" class="btn btn-link js-stools-btn-clear ml-3 <?php echo $clearButton ? 'd-none' : ''; ?>">
				<span class="icon-cancel" aria-hidden="true"></span>
				<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		<?php endif; ?>
	<?php endif; ?>
<?php endif;
