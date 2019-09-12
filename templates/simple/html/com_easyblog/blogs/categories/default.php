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
<div class="eb-categories">
<?php if ($categories) { ?>
	<?php foreach ($categories as $category) { ?>
	<div class="eb-category" data-category-wrapper>
		
		<?php echo $this->html('headers.category', $category, array(
			'title' => $this->params->get('category_title', true), 
			'description' => $this->params->get('category_description', true), 
			'avatar' => $this->params->get('category_avatar', true), 
			'subcategories' => $this->params->get('subcategories', true),
			'rss' => $this->params->get('category_rss', true),
			'subscription' => $this->params->get('category_subscriptions', true)
			)
		); ?>

		<?php if ($this->params->get('category_posts', true)) { ?>
			<div class="eb-category">
				<?php if ($this->params->get('category_posts', true)) { ?>
					<div class="eb-category-posts" id="posts-<?php echo $category->id; ?>">
						<?php if ($category->blogs) { ?>
							<?php $catp = 1; ?>
							<?php foreach ($category->blogs as $post) { ?>
								<?php if ($catp <= $limitPreviewPost) { ?>
									<div class="eb-category-post">
										<time>
											<?php echo $post->getDisplayDate($post->category->getParam('listing_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC3'));?>
										</time>
										<div>
											<a href="<?php echo $post->getPermalink();?>"><?php echo $post->title;?></a>
										</div>
										<p>
											<?php echo $post->getIntro(); ?>
										</p>
									</div>
								<?php } ?>
								<?php $catp++; ?>
							<?php } ?>

							<a href="<?php echo $category->getPermalink();?>" class="btn btn-show-all">
								<?php echo JText::_('COM_EASYBLOG_CATEGORIES_VIEW_ALL_POSTS');?> <i class="fa fa-long-arrow-right ml-3"></i>
							</a>
						<?php } else { ?>
							<div class="eb-empty">
								<?php echo JText::_('COM_EASYBLOG_NO_BLOG_ENTRY');?>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php } ?>
<?php } else { ?>
	<div class="eb-empty"><?php echo JText::_('COM_EASYBLOG_DASHBOARD_CATEGORIES_NO_CATEGORY_AVAILABLE'); ?></div>
<?php } ?>

	<?php if ($pagination) { ?>
		<?php echo $pagination; ?>
	<?php } ?>
</div>
