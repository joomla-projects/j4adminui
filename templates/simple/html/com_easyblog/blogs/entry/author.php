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
<div class="eb-entry-author">
	<h4 class="eb-section-heading reset-heading">
		<?php echo JText::_('COM_EASYBLOG_ABOUT_THE_AUTHOR');?>
	</h4>

	<div class="eb-entry-author-bio cell-top">
		<?php if ($this->entryParams->get('post_author_box_avatar', true)) { ?>
		<div class="col-cell">
			<a href="<?php echo $post->getAuthorPermalink();?>" class="eb-entry-author-avatar eb-avatar col-cell">
				<img src="<?php echo $post->creator->getAvatar();?>" width="50" height="50" alt="<?php echo $post->getAuthorName();?>" />
			</a>
		</div>
		<?php } ?>

		<div class="col-cell">
			<?php if ($this->entryParams->get('post_author_box_title', true)) { ?>
			<h3 class="eb-authors-name reset-heading">
				<a href="<?php echo $post->getAuthorPermalink();?>"><?php echo $post->getAuthorName();?></a>
			</h3>
			<?php } ?>

			<?php if (EB::points()->hasIntegrations()) { ?>
			<div class="eb-points">
				<?php echo EB::points()->html($post->creator); ?>
			</div>
			<?php } ?>

			<div class="eb-entry-author-meta muted fd-cf">

				<?php if ($post->creator->getWebsite() && $this->entryParams->get('post_author_box_website', true)) { ?>
				<span class="eb-authors-url">
					<a href="<?php echo $this->escape($post->creator->getWebsite()); ?>" target="_blank" class="author-url" rel="nofollow"
						 data-eb-provide="tooltip" title="<?php echo JText::_('COM_EB_VISIT_WEBSITE', true);?>"
					>
						<i class="fa fa-globe"></i>
					</a>
				</span>
				<?php } ?>

				<?php if ($this->acl->get('allow_subscription') && $this->config->get('main_bloggersubscription') && $post->creator->getAcl()->get('add_entry')) { ?>
				<span>
					<a class="<?php echo $isBloggerSubscribed ? 'hide' : ''; ?>" href="javascript:void(0);" data-blog-subscribe data-type="blogger" data-id="<?php echo $post->creator->id;?>"
						data-eb-provide="tooltip" title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_SUBSCRIBE_TO_BLOGGER', true);?>"
					>
						<i class="fa fa-envelope"></i>
					</a>
					<a class="<?php echo $isBloggerSubscribed ? '' : 'hide'; ?>" href="javascript:void(0);" data-blog-unsubscribe data-type="blogger" data-subscription-id="<?php echo $isBloggerSubscribed;?>"
						data-eb-provide="tooltip" data-title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_UNSUBSCRIBE_TO_BLOGGER', true);?>"
					>
						<i class="fa fa-envelope"></i>
					</a>
				</span>
				<?php } ?>

				<?php if ($this->entryParams->get('post_author_box_view_profile', true)) { ?>
				<span>
					<a href="<?php echo $post->getAuthorPermalink();?>">
						<i class="fa fa-user"></i>
					</a>
				</span>
				<?php } ?>

				<?php if (!$this->my->guest && EB::messaging()->hasMessaging($post->creator->id)) { ?>
				<span>
					<?php echo EB::messaging()->html($post->creator);?>
				</span>
				<?php } ?>
			</div>

			<?php if (EB::achievements()->hasIntegrations()) { ?>
			<div class="eb-achievements mt-10">
				<?php echo EB::achievements()->html($post->creator); ?>
			</div>
			<?php } ?>
		</div>

	</div>

	<?php if ($post->creator->getBioGraphy() && $this->entryParams->get('post_author_box_biography', true)) { ?>
	<div class="eb-entry-author-details">
		<?php echo $post->creator->getBioGraphy(); ?>
	</div>
	<?php } ?>

	<?php if ($this->entryParams->get('post_author_recent', true) && $recent) { ?>
	<div class="eb-entry-author-recents">
		<h5 class="reset-heading col-cell cell-tight"><?php echo JText::_('COM_EASYBLOG_AUTHOR_RECENT_POSTS');?></h5>

		<?php if ($this->entryParams->get('post_author_box_more_posts', true)) { ?>
		<span class="col-cell text-right">
			<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=blogger&layout=listings&id=' . $post->creator->id);?>"><?php echo JText::_('COM_EASYBLOG_ABOUT_AUTHOR_VIEW_MORE_POSTS');?></a>
		</span>
		<?php } ?>

		<?php foreach ($recent as $recentPost) { ?>
		<div>
			<a href="<?php echo $recentPost->getPermalink();?>">
				<i class="fa fa-file-o pull-left mr-10"></i>
				<time class="pull-right"><?php echo $recentPost->getDisplayDate($this->entryParams->get('post_date_source', 'created'))->format(JText::_('DATE_FORMAT_LC1')); ?></time>
				<span><?php echo $recentPost->title;?></span>
			</a>
		</div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
