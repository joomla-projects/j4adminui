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
					<button type="button" role="button" id="navStep2" data-step="step2">Database Configuration</button>
				</li>
				<li title="<?php echo Text::_('INSTL_DATABASE'); ?>">
					<button type="button" role="button" id="navStep3" data-step="step3">Installing Site</button>
				</li>
				<li>
					<button type="button" role="button" id="navStep4" data-step="step4">Finalizion Installation</button>
				</li>

			</ul>
		</div>
		<div class="col">
			<form action="index.php" method="post" id="languageForm" class="lang-select j-install-form d-none">
				<fieldset id="installStep0" class="j-install-step">
					<div class="j-install-step-body">
						<div class="form-group">
							<?php echo $this->form->getLabel('language'); ?>
							<?php echo $this->form->getInput('language'); ?>
						</div>
						<input type="hidden" name="task" value="language.set">
						<input type="hidden" name="format" value="json">
						<?php echo HTMLHelper::_('form.token'); ?>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" data-step="step1">Save & Next <span class="fas fa-angle-right icon right"></span></button>
					</div>
				</fieldset>
			</form>
			<form action="index.php" method="post" id="adminForm" class="form-validate j-install-form active">
				<fieldset id="installStep1" class="j-install-step">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('site_name'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('site_name'); ?>
							</div>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step1"><?php echo Text::_('INSTL_SETUP_LOGIN_DATA'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></button>
					</div>
				</fieldset>
				<fieldset id="installStep2" class="j-install-step active">
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('admin_user'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('admin_user'); ?>
							</div>
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary" id="step2"><?php echo Text::_('INSTL_CONNECT_DB'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></button>
					</div>
				</fieldset>
				<fieldset id="installStep3" class="j-install-step" >
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_type'); ?>
							</div>
							<div class="controlls">
								<?php echo $this->form->getInput('db_type'); ?>
							</div>
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
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
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
						</div>
					</div>
					<div class="form-no-margin">
						<div class="control-group">
							<div class="control-label">
								<?php echo $this->form->getLabel('db_old'); ?>
							</div>
							<div class="controls">
								<?php echo $this->form->getInput('db_old'); ?>
							</div>
							<small class="form-text text-muted">Either a username you created or a username provided by your host.</small>
						</div>
					</div>
					<div class="j-install-step-footer">
						<button class="btn btn-primary btn-block" id="setupButton"><?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?> <span class="fa fa-chevron-right" aria-hidden="true"></span></button>
					</div>
				</fieldset>

				<input type="hidden" name="admin_password2" id="jform_admin_password2">
				<?php echo HTMLHelper::_('form.token'); ?>
			</form>
		</div>
	</div>
</div>
