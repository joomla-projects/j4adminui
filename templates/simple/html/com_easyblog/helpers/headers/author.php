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
<div class="eb-page-header">
	<div class="d-flex">
		
		<?php if ($this->config->get('layout_avatar') && $viewOptions->avatar) { ?>
			<div class="mr-4">
				<a class="eb-avatar" href="<?php echo $author->getPermalink();?>">
					<img src="<?php echo $author->getAvatar(); ?>" class="eb-authors-avatar" width="100" height="100" alt="<?php echo $author->getName(); ?>" />
				</a>
			</div>
		<?php } ?>

		<div>
			<?php if ($viewOptions->name) { ?>
				<h1>
					<?php echo $author->getName(); ?>
				</h1>
			<?php } ?>

			<?php if($author->description) { ?>
				<div class="eb-page-header-bio">
					<?php echo $author->description; ?>
				</div>
			<?php } ?>
		</div>
	</div>
</div>