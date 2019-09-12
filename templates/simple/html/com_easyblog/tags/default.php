<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>

<?php if ($this->params->get('tag_search', true)) { ?>
<form name="tags" method="post" action="<?php echo JRoute::_('index.php'); ?>" class="form-tags-search row-table form-horizontal <?php echo $this->isMobile() ? 'is-mobile' : '';?>">
	<div class="col-cell">
		<div class="eb-tags-finder input-group">
			<input type="text" class="form-control" name="filter-tags" placeholder="<?php echo JText::_('COM_EASYBLOG_SEARCH_TAGS', true);?>" />
			<i class="fa fa-tags"></i>
			<div class="input-group-btn">
				<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
			</div>
		</div>
	</div>
	<?php echo $this->html('form.action', 'tags.query'); ?>
</form>
<?php } ?>

<?php if($tags) { ?>
<div class="eb-tags-list fd-cf">
	<?php foreach ($tags as $tag) { ?>
	<div class="eb-tags-grid">
		<div class="eb-tags-item">
			<a href="<?php echo $tag->getPermalink();?>" title="<?php echo $this->html('string.escape', $tag->title);?>">
				<?php echo JText::_($tag->title);?>
				<?php if ($this->params->get('tag_used_counter', true)) { ?>
					<span>(<?php echo $tag->post_count; ?>)</span>
				<?php } ?>
			</a>
		</div>
	</div>
	<?php } ?>
</div>

<?php if($pagination) {?>
	<?php echo EB::renderModule('easyblog-before-pagination'); ?>
	<?php echo $pagination->getPagesLinks();?>
	<?php echo EB::renderModule('easyblog-after-pagination'); ?>
<?php } ?>


<?php } else { ?>
	<div class="eb-empty">
		<i class="fa fa-paper-plane-o"></i>
		<?php echo JText::_('COM_EASYBLOG_DASHBOARD_NO_TAGS_AVAILABLE');?>
	</div>
<?php } ?>

