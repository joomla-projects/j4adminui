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
<?php if ($this->params->get('author_header', true)) { ?>

	<div class="eb-page-header">
		<div class="d-flex align-items-center">
			<div class="mr-4">
				<a class="eb-avatar" href="<?php echo $author->getPermalink();?>">
					<img src="<?php echo $author->getAvatar(); ?>" class="eb-authors-avatar" width="100" height="100" alt="<?php echo $author->getName(); ?>" />
				</a>
			</div>
			<div>
				<h1 class="eb-author-name">
					<?php echo $author->getName(); ?>
				</h1>
				<div class="eb-author-meta">
					<span>
						Total Articles: <span><?php echo $author->getTotalPosts(); ?></span>
					</span>
					<span>
						Member since:: <span><?php echo JHtml::_('date', $author->user->registerDate, 'F Y'); ?></span>
					</span>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="eb-posts" data-blog-posts>
	<?php if ($posts) { ?>
		<?php foreach ($posts as $post) { ?>
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
</div>

<?php if($pagination) {?>
	<?php echo EB::renderModule('easyblog-before-pagination'); ?>
	<?php echo $pagination;?>
	<?php echo EB::renderModule('easyblog-after-pagination'); ?>
<?php } ?>
