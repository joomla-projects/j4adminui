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
<form method="post" action="<?php echo JRoute::_('index.php');?>" enctype="multipart/form-data" data-eb-dashboard-account>
		
	<div class="row d-flex justify-content-center">
		<div class="col-md-8 col-lg-5">
			<h2 class="mb-4">Account Settings</h2>

			<?php echo $this->output('site/dashboard/account/profile'); ?>
			
			<button class="btn btn-primary">
				<i class="fa fa-save"></i>&nbsp; <?php echo JText::_('COM_EASYBLOG_SAVE_PROFILE'); ?>
			</button>
		</div>
	</div>

	<?php echo $this->html('form.action', 'profile.save'); ?>
</form>
