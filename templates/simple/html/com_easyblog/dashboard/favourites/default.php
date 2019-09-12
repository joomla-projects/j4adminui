<?php
/**
* @package  EasyBlog
* @copyright Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license  GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<form method="post" action="<?php echo JRoute::_('index.php?option=com_easyblog&view=dashboard&layout=favourites');?>" class="eb-dashboard-entries <?php echo !$posts ? 'is-empty' : '';?>" data-eb-dashboard-posts>
	<h1 class="eb-page-header">Favourite Posts</h1>
	<div class="eb-dashboard-empty">
		<div class="eb-dashboard-empty__content">
			<i class="eb-dashboard-empty__icon fa fa-align-left"></i>
			<div class="eb-dashboard-empty__text">
				<b><?php echo JText::_('COM_EB_EMPTY_FAVOURITES_POSTS');?></b>
			</div>
		</div>
	</div>

	<?php foreach ($posts as $post) { ?>
		<div class="eb-post" data-eb-post-item data-id="<?php echo $post->id;?>" class="<?php echo $post->isPending() ? 'is-pending': ''; ?>">
			<div class="eb-post-content">
				<div class="eb-post-head no-overflow">
					<?php echo $this->output('site/blogs/latest/post.cover', array('post' => $post)); ?>
					<div class="eb-post-body type-<?php echo $post->posttype; ?>">
						<h2 class="eb-post-title reset-heading">
							<a href="<?php echo $post->getPermalink();?>" class="text-inherit" target="_blank"><?php echo $post->title;?></a>
						</h2>
						<div class="eb-post-intro">
							<?php echo $post->getIntro();?>
						</div>
						<div class="post-actions" data-eb-actions data-id="<?php echo $post->id;?>">
							<a href="javascript:void(0);" class="text-danger" data-eb-action="posts.unfavourite" data-type="form">
								<i class="fa fa-heart"></i> <?php echo JText::_('COM_EB_UNFAVOURITE_POST');?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if ($pagination) { ?>
		<div class="eb-box-pagination pagination text-center">
			<?php echo $pagination->getPagesLinks(); ?>
		</div>
	<?php } ?>

	<input type="hidden" name="return" value="<?php echo base64_encode(EBFactory::getURI(true));?>" data-table-grid-return />
	<input type="hidden" name="ids[]" value="" data-table-grid-id />
	<input type="hidden" name="sort" value="" />
	<input type="hidden" name="ordering" value="" />
	<input type="hidden" name="view" value="dashboard" />
	<input type="hidden" name="layout" value="favourites" />
	<?php echo $this->html('form.action'); ?>
</form>
