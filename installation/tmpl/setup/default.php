<?php
/**
 * @package     Joomla.Installation
 * @subpackage  View
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

/** @var \Joomla\CMS\Installation\View\Setup\HtmlView $this */
?>



<div id="installer-view" data-page-name="setup">
	<div class="row no-gutters">
		<div class="col-12 col-md-auto">
			<ul class="j-install-menu">
				<li id="navStepLi0">
					<button type="button" role="button" id="navStep0" data-step="step" class="active" title="<?php echo Text::_('INSTL_SELECT_INSTALL_LANG'); ?>"><?php echo Text::_('INSTL_CHANGE_LANG'); ?></button>
				</li>
				<li id="navStepLi1">
					<button type="button" role="button" id="navStep1" data-step="step1" title="<?php echo Text::_('INSTL_SETUP_SITE_NAME'); ?>"><?php echo Text::_('INSTL_SITE_CONFIG'); ?></button>
				</li>
				<li id="navStepLi2" title="<?php echo Text::_('INSTL_LOGIN_DATA'); ?>">
					<button type="button" role="button" id="navStep2" data-step="step2"><?php echo Text::_('INSTL_LOGIN_DATA'); ?></button>
				</li>
				<li id="navStepLi3" title="<?php echo Text::_('INSTL_DATABASE'); ?>">
					<button type="button" role="button" id="navStep3" data-step="step3"><?php echo Text::_('INSTL_DATABASE_CONFIG'); ?></button>
				</li>
				<li id="navStepLi4" title="<?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?>">
					<button type="button" role="button" id="navStep4" data-step="step3"><?php echo Text::_('INSTL_INSTALLING_SITE'); ?></button>
				</li>
				<li id="navStepLi5">
					<button type="button" role="button" id="navStep5" data-step="step4"><?php echo Text::_('INSTL_FINALIZE_INSTALLATION'); ?></button>
				</li>
			</ul>
		</div>
		<div class="col">
			<form action="index.php" method="post" id="languageForm" class="lang-select j-install-form active">
				<fieldset id="installStep0" class="j-install-step active">
					<div>
						<div class="form-no-margin">
							<div class="control-group">
								<div class="control-label">
									<?php echo $this->form->getLabel('language'); ?>
								</div>
								<div class="controlls">
									<?php echo $this->form->getInput('language'); ?>
								</div>
								<small class="form-text info"><?php echo Text::_('INSTL_SELECT_LANGUAGE_DESC'); ?></small>
							</div>
						</div>
						<input type="hidden" name="task" value="language.set">
						<input type="hidden" name="format" value="json">
						<?php echo HTMLHelper::_('form.token'); ?>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" type="submit" id="step0"><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset><!-- /#installStep0 -->
			</form>

			<form action="index.php" method="post" id="adminForm" class="form-validate j-install-form d-none">
				<fieldset id="installStep1" class="j-install-step" title="<?php echo Text::_('INSTL_SITE_CONFIG'); ?>">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('site_name'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('site_name'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_SITE_NAME_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_email'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('admin_email'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_SITE_EMAIL_ADDRESS'); ?></small>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step1" ><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset><!-- /#installStep1 -->

				<fieldset id="installStep2" class="j-install-step" title="<?php echo Text::_('INSTL_LOGIN_DATA'); ?>">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_user'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('admin_user'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_LOGIN_DATA_SUPER_USER_NAME_DESC'); ?></small>
						</div>
					</div>

					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_username'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('admin_username'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_LOGIN_DATA_USERNAME_DESC'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_password'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('admin_password'); ?>
							</div>
							<div class="form-text info">
								<small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_DESC'); ?></small>
								<ul class="j-install-from-pass-info">
									<li><small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_HINT_STRENGTH'); ?></small></li>
									<li><small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_HINT_LENGTH'); ?></small></li>
									<li><small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_HINT_UPPERCASE'); ?></small></li>
									<li><small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_HINT_PUNTUATION'); ?></small></li>
									<li><small><?php echo Text::_('INSTL_LOGIN_DATA_PASSWORD_HINT_DIFF_USER'); ?></small></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step2" ><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset> <!-- /#installStep2 -->

				<fieldset id="installStep3" class="j-install-step" title="<?php echo Text::_('INSTL_DATABASE_CONFIG'); ?>" >
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_type'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('db_type'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_TYPE_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_host'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('db_host'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_HOST_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_user'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('db_user'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_HOST_USERNAME_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_pass'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('db_pass'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_HOST_PASSWORD_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_name'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('db_name'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_NAME_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_prefix'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('db_prefix'); ?>
							</div>
							<small class="form-text info"><?php echo Text::_('INSTL_DATABASE_TABLE_PREFIX_DESCRIPTION'); ?></small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php //echo $this->form->getLabel('db_old'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('db_old'); ?>
							</div>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary btn-block" id="setupButton" ><?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?></button>
					</div>
				</fieldset><!-- /#installStep3 -->

				<fieldset id="installStep4" class="j-install-step" title="<?php echo Text::_('INSTL_INSTALLING_SITE'); ?>" >
					<p class="installation-message"><?php echo Text::_('Please wait while your site is installing…'); ?></p>
					<div class="j-progress j-has-percent">
						<div class="progress-bar progress-bar-striped progress-bar-animated" id="installation-progress" role="progressbar" style="width: 0%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
						<span class="j-progress-percent"></span>
					</div>

					<div class="j-install-completing-list">
						<ul class="j-install-progress">
							<li class="list-item" id="db-check"><span class="j-spinner inactive"></span><?php echo Text::_('INSTL_INSTALL_STATUS_CHK_DB'); ?></li>
							<li class="list-item" id="db-backup"><span class="j-spinner inactive"></span><?php echo Text::_('INSTL_INSTALL_STATUS_BKUP_DB'); ?></li>
							<li class="list-item" id="db-create"><span class="j-spinner inactive"></span><?php echo Text::_('INSTL_INSTALL_STATUS_CREATE_DB'); ?></li>
							<li class="list-item" id="configuration-file"><span class="j-spinner inactive"></span><?php echo Text::_('INSTL_INSTALL_STATUS_CREATE_CONFIG_FILE'); ?></li>
						</ul>
					</div>
				</fieldset><!-- /#installStep4 -->

				<input type="hidden" name="admin_password2" id="jform_admin_password2">
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
