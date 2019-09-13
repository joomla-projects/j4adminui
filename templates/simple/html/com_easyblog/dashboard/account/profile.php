<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2019 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>

<?php if ($this->config->get('layout_avatar') && $this->config->get('layout_avatarIntegration') == 'default') { ?>
	<div class="form-group">
		<div class="d-flex mb-4 align-items-center">
			<div class="eb-avatar mr-4">
				<img class="avatar-image" src="<?php echo $profile->getAvatar(); ?>" style="width: 86px!important; height: 86px!important;" />
			</div>

			<?php if ($this->acl->get('upload_avatar')) { ?>
				<div id="avatar-upload-form">
					<h3><?php echo $this->escape($this->my->name); ?></h3>
					<a href="javascript:;" onClick="document.getElementById('file-upload').click();" class="btn btn-primary">Upload Avatar</a>
					<div class="mts d-none">
						<input id="file-upload" type="file" name="avatar" />
					</div>
					<div><span id="upload-clear"></span></div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<div class="form-group">
	<input type="text" name="fullname" value="<?php echo $this->escape($this->my->name); ?>" class="form-control" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_REALNAME'); ?>">
</div>

<div class="form-group">
	<input type="text" name="nickname" value="<?php echo $this->escape($profile->nickname); ?>" class="form-control" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_WHAT_OTHERS_CALL_YOU'); ?>">
</div>

<div class="form-group">
	<input type="text" value="<?php echo $this->my->username; ?>" class="form-control" disabled="disabled" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_USERNAME'); ?>">
</div>

<?php if ($this->config->get('main_joomlauserparams')) { ?>
	<div class="form-group">
		<input type="text" name="email" value="<?php echo $this->escape($this->my->email); ?>" class="form-control" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_EMAIL'); ?>">
	</div>

	<div class="form-group">
		<input type="password" id="password" name="password" class="form-control" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_PASSWORD'); ?>">
	</div>

	<div class="form-group">
		<input type="password" id="password2" name="password2" class="form-control" placeholder="<?php echo JText::_('COM_EASYBLOG_DASHBOARD_ACCOUNT_RECONFIRM_PASSWORD'); ?>">
	</div>
<?php } ?>
