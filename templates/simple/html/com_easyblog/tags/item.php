<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasySocial is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<?php if ($this->params->get('tag_header', true) && ($this->params->get('tag_title', true))) { ?>
	<div class="eb-page-header">
		<?php if ($this->params->get('tag_title', true)) { ?>
			<h1>
				<?php echo $tag->getTitle();?>
			</h1>
		<?php } ?>
	</div>
<?php } ?>

<div class="eb-posts for-tag" data-blog-posts>
	<?php echo EB::renderModule('easyblog-before-entries');?>

	<?php if ($private > 0 || $team > 0) { ?>
	<div class="eb-empty">
		<i class="fa fa-info-circle"></i>
		<?php if ($private > 0 && $team > 0) { ?>
			<div><?php echo JText::sprintf('COM_EASYBLOG_TAG_PRIVATE_AND_TEAM_BLOG_INFO', $private, $team); ?></div>
		<?php } elseif ($private > 0) { ?>
			<?php echo $this->getNouns('COM_EASYBLOG_TAG_PRIVATE_BLOG' , $private, true );?>
		<?php } elseif ($team > 0) { ?>
			<?php echo $this->getNouns('COM_EASYBLOG_TAG_TEAM_BLOG_INFO', $team, true);?>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($posts) { ?>
		<?php foreach ($posts as $post){ ?>

			<!-- Determine if post custom fields should appear or not in tag listings -->
			<?php if (!$this->params->get('tag_post_customfields')) { ?>
				<?php $post->fields = '';?>
			<?php } ?>

			<?php if (!EB::isSiteAdmin() && $this->config->get('main_password_protect') && !empty($post->blogpassword) && !$post->verifyPassword()) { ?>
				<?php echo $this->output('site/blogs/latest/default.protected', array('post' => $post)); ?>
			<?php } else { ?>
				<?php echo $this->output('site/blogs/latest/default.main', array('post' => $post)); ?>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>
		<div class="eb-empty">
			<i class="fa fa-info-circle"></i>
			<?php echo JText::_('COM_EASYBLOG_NO_BLOG_ENTRY');?>
		</div>
	<?php } ?>

	<?php echo EB::renderModule('easyblog-after-entries'); ?>
</div>

<?php if($pagination) {?>
	<?php echo EB::renderModule('easyblog-before-pagination'); ?>

	<?php echo $pagination->getPagesLinks();?>

	<?php echo EB::renderModule('easyblog-after-pagination'); ?>
<?php } ?>
