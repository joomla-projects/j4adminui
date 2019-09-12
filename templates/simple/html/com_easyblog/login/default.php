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
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="login" class="<?php echo $this->isMobile() ? 'is-mobile' : '';?>">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-8">
			<h3 class="eb-login-title reset-heading mb-15">
				<?php echo JText::_('COM_EASYBLOG_MEMBER_LOGIN');?>
			</h3>

			<div class="form-group">
				<input type="text" name="username" id="eb-username" class="form-control" autocomplete="off" placeholder="<?php echo JText::_('COM_EASYBLOG_USERNAME'); ?>" />
			</div>

			<div class="form-group">
				<input type="password" name="password" id="eb-password" class="form-control" autocomplete="off" placeholder="<?php echo JText::_('COM_EASYBLOG_PASSWORD'); ?>" />
			</div>

			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<button type="submit" class="btn btn-primary">Login Now</button>
				</div>
				<?php if(JPluginHelper::isEnabled('system', 'remember')) { ?>
					<div class="form-check">
						<input id="eb-remember" type="checkbox" name="remember" class="form-check-input" alt="<?php echo JText::_('COM_EASYBLOG_REMEMBER_ME', true) ?>" value="yes" />
						<label for="eb-remember" class="form-check-label"><?php echo JText::_('COM_EASYBLOG_REMEMBER_ME') ?></label>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
	
	<input type="hidden" value="com_users"  name="option">
	<input type="hidden" value="user.login" name="task">
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo $this->html('form.token'); ?>

	<?php if ($this->config->get('integrations_jfbconnect_login')) { ?>
		<?php echo EB::jfbconnect()->getTag();?>
	<?php } ?>
</form>
