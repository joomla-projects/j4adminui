<?php
/**
 * @package		EasyBlog
 * @copyright	Copyright (C) 2010 Stack Ideas Private Limited. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 *
 * EasyBlog is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die('Restricted access');
?>

<div id="blog-login">
	<div class="blog-login-head">
		<?php echo JText::_('COM_EASYBLOG_MEMBERS_LOGIN');?>
	</div>

	<p><?php echo JText::_('COM_EASYBLOG_PLEASE_LOGIN_TO_VIEW_THIS_PAGE');?></p>

	<form action="<?php echo JRoute::_('index.php'); ?>" method="post" name="login">
		<div id="form-login-username" style="padding-bottom: 5px;">
			<label for="username"><?php echo JText::_('COM_EASYBLOG_USERNAME') ?></label><br />
			<input id="username" type="text" name="username" class="inputbox halfwidth" alt="username" size="18" />
		</div>
		<div id="form-login-password" style="padding-bottom: 5px;">
			<label for="passwd"><?php echo JText::_('COM_EASYBLOG_PASSWORD') ?></label><br />
			<input id="passwd" type="password" name="password" class="inputbox halfwidth" size="18" alt="password" />
		</div>
		<?php if(JPluginHelper::isEnabled('system', 'remember')) { ?>
		<div id="form-login-remember">
			<input id="remember" type="checkbox" name="remember" value="yes" alt="Remember Me"/>
			<label for="remember"><?php echo JText::_('COM_EASYBLOG_REMEMBER_ME') ?></label>
		</div>
		<?php } ?>
		<br />
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('COM_EASYBLOG_LOGIN_BUTTON') ?>" />
		<ul class="blog-login-helper reset-ul float-li clearfix">
			<li>
				<a href="<?php echo EB::getResetPasswordLink();?>">
				<?php echo JText::_('COM_EASYBLOG_FORGOT_YOUR_PASSWORD'); ?></a>
			</li>
			<li>
				<a href="<?php echo EB::getRemindUsernameLink(); ?>">
				<?php echo JText::_('COM_EASYBLOG_FORGOT_YOUR_USERNAME'); ?></a>
			</li>
			<li class="float-r">
			<?php
				$usersConfig	= JComponentHelper::getParams( 'com_users' );
				if($usersConfig->get('allowUserRegistration')){ ?>
					<a href="<?php echo EB::getRegistrationLink();?>"><?php echo JText::_('COM_EASYBLOG_CREATE_AN_ACCOUNT'); ?></a>
				<?php } ?>
			</li>
		</ul>

		<input type="hidden" value="com_users"  name="option">
		<input type="hidden" value="user.login" name="task">
		<input type="hidden" name="return" value="<?php echo $return; ?>" />

		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
