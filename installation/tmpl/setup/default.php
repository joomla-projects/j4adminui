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
Factory::getDocument()->getWebAssetManager()->enableAsset('choicesjs');
HTMLHelper::_('webcomponent', 'system/fields/joomla-field-fancy-select.min.js', ['version' => 'auto', 'relative' => true]);

?>



<div id="installer-view" data-page-name="setup">
	<div class="row no-gutters">
		<div class="col-auto">
			<ul class="j-install-menu">
				<li>
					<button type="button" role="button" id="navStep0" data-step="step" class="active" title="<?php echo Text::_('INSTL_SELECT_INSTALL_LANG'); ?>">Choose Language</button>
				</li>
				<li>
					<button type="button" role="button" id="navStep1" data-step="step1" title="<?php echo Text::_('INSTL_SETUP_SITE_NAME'); ?>">Site Configuration</button>
				</li>
				<li title="<?php echo Text::_('INSTL_LOGIN_DATA'); ?>">
					<button type="button" role="button" id="navStep2" data-step="step2">Login Data</button>
				</li>
				<li title="<?php echo Text::_('INSTL_DATABASE'); ?>">
					<button type="button" role="button" id="navStep3" data-step="step3">Database Configuration</button>
				</li>
				<li title="<?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?>">
					<button type="button" role="button" id="navStep4" data-step="step3">Installing Site</button>
				</li>
				<li>
					<button type="button" role="button" id="navStep5" data-step="step4">Finalizion Installation</button>
				</li>

			</ul>
		</div>
		<div class="col">
			<form action="index.php" method="post" id="languageForm" class="lang-select j-install-form active">
				<fieldset id="installStep0" class="j-install-step active">
					<div class="j-install-step-body">
						<div class="form-no-margin">
							<div class="control-group">
								<div class="control-label">
									<?php echo $this->form->getLabel('language'); ?>
								</div>
								<div class="controlls">
									<?php echo $this->form->getInput('language'); ?>
								</div>
								<small class="form-text text-muted">Select your prefered language for joomla installation</small>
							</div>
						</div>
						<input type="hidden" name="task" value="language.set">
						<input type="hidden" name="format" value="json">
						<?php echo HTMLHelper::_('form.token'); ?>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" type="button" id="step0"><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset><!-- /#installStep0 -->
			</form>

			<form action="index.php" method="post" id="adminForm" class="form-validate j-install-form d-none">
				<fieldset id="installStep1" class="j-install-step active">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('site_name'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('site_name'); ?>
							</div>
							<small class="form-text text-muted">Enter the name of your Joomla site.</small>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step1"><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset><!-- /#installStep1 -->

				<fieldset id="installStep2" class="j-install-step active">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_user'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('admin_user'); ?>
							</div>
							<small class="form-text text-muted">Enter the real name of your Super User.</small>
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
							<small class="form-text text-muted">Enter super user's username.</small>
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
							<div class="form-text text-muted">
								<small>Set the password for your Super User account.</small>
								<ul class="j-install-from-pass-info">
									<li><small>To make your password stronger-</small></li>
									<li><small>Make it at least 8 characters.</small></li>
									<li><small>Add uppercase letters.</small></li>
									<li><small>Add numbers and punctuations.</small></li>
									<li><small>Make it different from username.</small></li>
								</ul>
							</div>
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
							<small class="form-text text-muted">Enter the super user's email address.</small>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step2"><?php echo Text::_('INSTL_SAVE_AND_NEXT'); ?></button>
					</div>
				</fieldset> <!-- /#installStep2 -->

				<fieldset id="installStep3" class="j-install-step" >
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_type'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('db_type'); ?>
							</div>
							<small class="form-text text-muted">Select a database type form the options.</small>
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
							<small class="form-text text-muted">Enter the host name, usually "localhost" or a name provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a password you created or a password provided by your host.</small>
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
							<small class="form-text text-muted">Enter the database name</small>
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
							<small class="form-text text-muted">Enter a table prefix or use the randomly generated one</small>
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
						<button class="btn btn-primary btn-block" id="setupButton"><?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?></button>
					</div>
				</fieldset><!-- /#installStep3 -->

				<input type="hidden" name="admin_password2" id="jform_admin_password2">
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
