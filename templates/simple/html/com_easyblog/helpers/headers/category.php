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
<div class="eb-page-header">
	<?php if ($viewOptions->title) { ?>
		<h1>
			<?php echo $category->getTitle();?>
		</h1>
	<?php } ?>

	<?php if ($viewOptions->description && $category->description) { ?>
		<div class="eb-page-header-bio">
			<?php echo $this->html('string.truncater', $category->description, 350); ?>
		</div>
	<?php } ?>

	<?php echo EB::renderModule('breadcrumb'); ?>
</div>