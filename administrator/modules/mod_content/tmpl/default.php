<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  mod_content
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

//HTMLHelper::_('bootstrap.framework');
HTMLHelper::_('webcomponent', 'system/joomla-tab.min.js', array('version'=> 'auto', 'relative' => true));
?>

<joomla-tab>
	<section orientation="vertical" id="module-content-latest-<?php echo $module->id; ?>" name="<?php echo Text::_('MOD_CONTENT_LATEST'); ?>">
		<table class="table j-striped-table" id="<?php echo str_replace(' ', '', $module->title) . $module->id; ?>">
			<caption class="sr-only"><?php echo $module->title; ?></caption>
			<thead>
				<tr>
					<th scope="col" class="text-center" width="10%"><?php echo Text::_('JGRID_HEADING_ID'); ?></th>
					<th scope="col"><?php echo Text::_('JGLOBAL_TITLE'); ?></th>
					<th scope="col" class="text-center" width="20%"><?php echo Text::_('JDATE'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($latests)) : ?>
				<?php foreach ($latests as $i => $item) : ?>
				<tr>
					<th scope="row" class="text-center">
						<?php echo $item->id; ?>
					</th>
					<td>
						<?php if ($item->checked_out) : ?>
							<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time); ?>
						<?php endif; ?>
						<?php if ($item->link) : ?>
							<a href="<?php echo $item->link; ?>">
								<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>
							</a>
						<?php else : ?>
							<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
					</td>
					<td class="text-center">
						<?php echo HTMLHelper::_('date', $item->publish_up, Text::_('DATE_FORMAT_LC4')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else : ?>
				<tr>
					<th colspan="3">
						<?php echo Text::_('MOD_CONTENT_NO_MATCHING_RESULTS'); ?>
					</th>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
	<section id="module-content-popular-<?php echo $module->id; ?>" name="<?php echo Text::_('MOD_CONTENT_POPULAR'); ?>">
		<table class="table j-striped-table" id="<?php echo str_replace(' ', '', $module->title) . $module->id; ?>">
			<caption class="sr-only"><?php echo $module->title; ?></caption>
			<thead>
				<tr>
					<th scope="col" class="text-center" width="10%"><?php echo Text::_('JGRID_HEADING_ID'); ?></th>
					<th scope="col"><?php echo Text::_('JGLOBAL_TITLE'); ?></th>
					<th scope="col" class="text-center" width="20%"><?php echo Text::_('JGLOBAL_HITS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($popular)) : ?>
				<?php foreach ($popular as $i => $item) : ?>
				<?php $hits = (int) $item->hits; ?>
				<?php $hits_class = ($hits >= 10000 ? 'danger' : ($hits >= 1000 ? 'warning' : ($hits >= 100 ? 'info' : 'secondary'))); ?>
				<tr>
					<th scope="row" class="text-center">
						<?php echo $item->id; ?>
					</th>
					<td scope="row">
						<?php if ($item->checked_out) : ?>
							<?php echo HTMLHelper::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time); ?>
						<?php endif; ?>
						<?php if ($item->link) : ?>
							<a href="<?php echo $item->link; ?>">
								<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>
							</a>
						<?php else : ?>
							<?php echo htmlspecialchars($item->title, ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
					</td>
					<td class="text-center">
						<span class="badge badge-<?php echo $hits_class; ?> m-0"><?php echo $item->id; ?></span>
					</td>
				</tr>
				<?php endforeach; ?>
				<?php else : ?>
				<tr>
					<th colspan="3">
						<?php echo Text::_('MOD_CONTENT_NO_MATCHING_RESULTS'); ?>
					</th>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</section>
</joomla-tab>
