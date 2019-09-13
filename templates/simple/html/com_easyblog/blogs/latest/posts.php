<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>

<div class="eb-page-header">
	<h1>
		Joomla Resources
	</h1>

	<div class="eb-page-header-bio">
		Helpful Joomla tutorials, tips, and resources on how to create & manage Joomla websites like a Pro.
	</div>

	<?php echo EB::renderModule('breadcrumb'); ?>
</div>

<div data-eb-posts-section data-url="<?php echo $currentPageLink; ?>">

	<?php if (isset($autoload) && $autoload) { ?>
	<div class="eb-post"></div>
	<?php } ?>

	<?php echo EB::renderModule('easyblog-before-entries');?>

	<?php if ($posts) { ?>
		<?php $key = 1; ?>
		<?php foreach ($posts as $post) { ?>
			<?php if (!EB::isSiteAdmin() && $this->config->get('main_password_protect') && !empty($post->blogpassword) && !$post->verifyPassword()) { ?>
				<?php echo $this->output('site/blogs/latest/default.protected', array('post' => $post)); ?>
			<?php } else { ?>
				<?php echo $this->output('site/blogs/latest/default.main', array('post' => $post)); ?>
			<?php } ?>

			<?php if($key == 2) : ?>
				<div class="eb-post-ad">
					<?php echo EB::renderModule('ad2'); ?>
				</div>
			<?php endif; ?>
			
			<?php $key++; ?>
		<?php } ?>
	<?php } else { ?>
	<div class="eb-empty">
		<i class="fa fa-paper-plane-o"></i>
		<?php echo JText::_('COM_EASYBLOG_NO_BLOG_ENTRY');?>
	</div>
	<?php } ?>

	<?php echo EB::renderModule('easyblog-after-entries'); ?>
</div>