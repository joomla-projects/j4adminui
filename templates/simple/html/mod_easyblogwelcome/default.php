<?php
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="mod-welcome<?php echo $modules->getWrapperClass();?>">
	
	<?php if (!$my->guest) { ?>
		<ul class="profile-info">
			<li>
				<a href="<?php echo EB::getEditProfileLink();;?>">
					<i class="fa fa-edit fa-fw"></i>
					Edit Profile
				</a>
			</li>

			<?php if ($acl->get('add_entry')) { ?>
				<li>
					<a href="<?php echo EB::composer()->getComposeUrl(); ?>" target="_blank" data-eb-composer>
						<i class="fa fa-pencil fa-fw"></i>
						Write New Post
					</a>
				</li>

				<li>
					<a href="<?php echo $author->getProfileLink();?>">
						<i class="fa fa-file-text fa-fw"></i>
						<?php echo JText::_('MOD_EASYBLOGWELCOME_MYBLOGS');?>
					</a>
				</li>

				<?php if ((($config->get('comment_easyblog')) && $config->get('main_comment_multiple')) && $config->get('main_comment')) { ?>
					<li>
						<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=dashboard&layout=comments');?>">
							<i class="fa fa-comments fa-fw"></i>
							<?php echo JText::_( 'MOD_EASYBLOGWELCOME_MYCOMMENTS');?>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
		
			<?php if ($params->get('enable_login', true)) { ?>
				<li>
					<a href="<?php echo JRoute::_('index.php?option=com_users&task=user.logout&' . JSession::getFormToken() . '=1&return='.$return);?>">
						<i class="fa fa-sign-out fa-fw"></i>
						<?php echo JText::_('MOD_EASYBLOGWELCOME_LOGOUT');?>
					</a>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>

	<?php if ($my->guest && $params->get('enable_login', true)) { ?>
		<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', false)); ?>" method="post" name="login" id="form-login">
			<div class="form-group">
				<input id="eb-username" type="text" name="username" class="form-control" placeholder="<?php echo JText::_('MOD_EASYBLOGWELCOME_USERNAME') ?>" />
			</div>

			<div class="form-group">
				<input id="eb-password" type="password" name="password" class="form-control" placeholder="<?php echo JText::_('MOD_EASYBLOGWELCOME_PASSWORD') ?>" />
			</div>

			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<button class="btn btn-primary">Login Now</button>
				</div>

				<?php if (JPluginHelper::isEnabled('system', 'remember')) { ?>
					<div class="form-check">
						<input id="eb-remember" type="checkbox" name="remember" class="form-check-input" value="yes" />
						<label for="eb-remember" class="form-check-label"><?php echo JText::_('MOD_EASYBLOGWELCOME_REMEMBER_ME'); ?></label>
					</div>
				<?php } ?>
			</div>

			<div class="login-lost-password-username">
				Forgot <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">Password</a> or <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">Username</a>?
			</div>

			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="user.login" />
			<input type="hidden" name="return" value="<?php echo $return; ?>" />
			<?php echo JHTML::_('form.token'); ?>

			<?php if ($config->get('integrations_jfbconnect_login')) { ?>
				<?php echo EB::jfbconnect()->getTag();?>
			<?php } ?>
		</form>
	<?php } ?>
</div>
