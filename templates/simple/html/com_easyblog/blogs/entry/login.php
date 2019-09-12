<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2017 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="login" class="eb-login text-center <?php echo $this->isMobile() ? 'is-mobile' : '';?>">
	<h3 class="eb-login-title reset-heading mb-15"><?php echo JText::_('COM_EASYBLOG_MEMBERS_LOGIN');?></h3>
	<p><?php echo JText::_('COM_EASYBLOG_PLEASE_LOGIN_TO_READ_FULL_ENTRY');?></p>

	<div class="form-group">
		<input id="username" type="text" name="username" class="form-control" alt="username" size="18" />
	</div>
	
	<div class="form-group">
		<input id="passwd" type="password" name="password" class="form-control" size="18" alt="password" />
	</div>

	<div class="eb-login-footer">
		<?php if(JPluginHelper::isEnabled('system', 'remember')) { ?>
		<div class="eb-login-footer__cell text-left">
			<div class="eb-checkbox">
				<input id="remember" type="checkbox" name="remember" value="yes" alt="Remember Me"/>
				<label for="remember"><?php echo JText::_('COM_EASYBLOG_REMEMBER_ME') ?></label>
			</div>
		</div>
		<?php } ?>

		<div class="eb-login-footer__cell text-right">
			<input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('COM_EASYBLOG_LOGIN_BUTTON') ?>" />
		</div>
	</div>

	<hr />

	<div class="eb-login-help row-table">
		<div class="col-cell">
			<a href="<?php echo EB::getResetPasswordLink(); ?>" class="btn btn-block btn-default">
				<?php echo JText::_('COM_EASYBLOG_FORGOT_YOUR_PASSWORD'); ?>
			</a>
		</div>
		<div class="col-cell">
			<a href="<?php echo EB::getRemindUsernameLink(); ?>" class="btn btn-block btn-default">
				<?php echo JText::_('COM_EASYBLOG_FORGOT_YOUR_USERNAME'); ?>
			</a>
		</div>
	</div>

	<?php
	$usersConfig = JComponentHelper::getParams( 'com_users' );
	if ($usersConfig->get('allowUserRegistration')) : ?>
	<a href="<?php echo EB::getRegistrationLink();?>" class="btn btn-block btn-success">
		<?php echo JText::_('COM_EASYBLOG_CREATE_AN_ACCOUNT'); ?>
	</a>
	<?php endif; ?>

	<input type="hidden" value="com_users"  name="option">
	<input type="hidden" value="user.login" name="task">
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHTML::_('form.token'); ?>
</form>
