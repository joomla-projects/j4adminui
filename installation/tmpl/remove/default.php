<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var \Joomla\CMS\Installation\View\Remove\HtmlView $this */
?>
<div id="installer-view" data-page-name="remove">
	<div class="row no-gutters">
		<div class="col-12 col-md-auto">
			<ul class="j-install-menu">
				<li>
					<button type="button" role="button" data-step="step" class="completed" title="<?php echo Text::_('INSTL_SELECT_INSTALL_LANG'); ?>">Choose Language</button>
				</li>
				<li>
					<button type="button" role="button" data-step="step1" class="completed" title="<?php echo Text::_('INSTL_SETUP_SITE_NAME'); ?>">Site Configuration</button>
				</li>
				<li title="<?php echo Text::_('INSTL_LOGIN_DATA'); ?>">
					<button type="button" role="button" data-step="step2" class="completed"><?php echo Text::_('INSTL_LOGIN_DATA'); ?></button>
				</li>
				<li title="<?php echo Text::_('INSTL_DATABASE'); ?>">
					<button type="button" role="button" data-step="step3" class="completed"><?php echo Text::_('INSTL_DATABASE_CONFIG'); ?></button>
				</li>
				<li title="<?php echo Text::_('INSTL_INSTALL_JOOMLA'); ?>">
					<button type="button" role="button" data-step="step3" class="completed"><?php echo Text::_('INSTL_INSTALLING_SITE'); ?></button>
				</li>
				<li>
					<button type="button" role="button" data-step="step4" class="active"><?php echo Text::_('INSTL_FINALIZE_INSTALLATION'); ?></button>
				</li>

			</ul>
		</div><!-- left side navigation column -->
		<div class="col j-install-righ-col">
			<fieldset id="installCongrat" class="j-install-form no-padding j-install-step active">
				<div class="j-install-step-iconic-header">
					<span class="icon-check icon" aria-hidden="true"></span> <span><?php echo Text::_('INSTL_COMPLETE_CONGRAT'); ?></span>
				</div>

				<div class="j-install-step-form j-install-step-body pt-4">
					<h4><?php echo Text::_('INSTL_COMPLETE_TITLE'); ?></h4>
					<p id="customize-installation"><?php echo Text::sprintf('INSTL_COMPLETE_DESC', "<a href='javascript:' id='installAddFeatures'>". Text::_('INSTL_COMPLETE_ADD_PRECONFIG') . "</a>") ?></p>
				</div>

				<div id="installRecommended" class="j-install-step active">
					<div class="j-install-step-form">
						<?php $displayTable = false; ?>
						<?php foreach ($this->phpsettings as $setting) : ?>
							<?php if ($setting->state !== $setting->recommended) : ?>
								<?php $displayTable = true; ?>
							<?php endif; ?>
						<?php endforeach; ?>
						<?php if ($displayTable) : ?>
							<hr>
							<div class="j-install-step-body">
								<?php echo Text::_('INSTL_PRECHECK_RECOMMENDED_SETTINGS_DESC'); ?>
							</div>

							<table class="j-install-step-table">
								<thead>
								<tr>
									<th>
										<?php echo Text::_('INSTL_PRECHECK_DIRECTIVE'); ?>
									</th>
									<th>
										<span class="success"><?php echo Text::_('INSTL_PRECHECK_RECOMMENDED'); ?></span>
									</th>
									<th>
										<span class="danger"><?php echo Text::_('INSTL_PRECHECK_ACTUAL'); ?></span>
									</th>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($this->phpsettings as $setting) : ?>
									<?php if ($setting->state !== $setting->recommended) : ?>
										<tr>
											<td>
												<?php echo $setting->label; ?>
											</td>
											<td class="text-uppercase">
												<?php echo Text::_($setting->recommended ? 'JON' : 'JOFF'); ?>
											</td>
											<td class="text-uppercase">
												<?php echo Text::_($setting->state ? 'JON' : 'JOFF'); ?>
											</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>
						<?php if ($this->development) : ?>
							<div class="j-install-remove-check">
								<div class="j-checkbox-group">
									<a href="javascript:" id="removeInstallationFolder"><?php echo Text::_('INSTL_COMPLETE_REMOVE_FOLDER'); ?></a>
									<p class="d-none" id="removeFolderMsg"><?php echo Text::_('INSTL_COMPLETE_FOLDER_REMOVED'); ?></p>
								</div>
							</div>
						<?php endif; ?>
						<?php echo HTMLHelper::_('form.token'); ?>

						<div class="btn-group btn-group-lg j-install-step-btn-group j-install-step-footer no-padding">
							<a class="btn btn-default" href="<?php echo Uri::root(); ?>" title="<?php echo Text::_('JSITE'); ?>"><span class="icon-eye-open" aria-hidden="true"></span> <?php echo Text::_('INSTL_COMPLETE_SITE_BTN'); ?></a>
							<a class="btn btn-primary" href="<?php echo Uri::root(); ?>administrator/" title="<?php echo Text::_('JADMINISTRATOR'); ?>"><span class="icon-cog" aria-hidden="true"></span> <?php echo Text::_('INSTL_COMPLETE_ADMIN_BTN'); ?></a>
						</div>

					</div>
				</div>
			</fieldset>


			<fieldset id="installLanguages" class="j-install-step j-install-form only-pb">
				<div class="j-install-step-body pt-4">
					<h3><?php echo Text::_('INSTL_LANGUAGES'); ?></h3>
				</div>
				<div class="j-install-step-form">
					<?php if (!$this->items) : ?>
						<p><?php echo Text::_('INSTL_LANGUAGES_WARNING_NO_INTERNET'); ?></p>
						<p>
							<a href="#"
							   class="btn btn-primary"
							   onclick="return Install.goToPage('remove');">
								<span class="icon-arrow-left icon-white" aria-hidden="true"></span>
								<?php echo Text::_('INSTL_LANGUAGES_WARNING_BACK_BUTTON'); ?>
							</a>
						</p>
						<p><?php echo Text::_('INSTL_LANGUAGES_WARNING_NO_INTERNET2'); ?></p>
					<?php else : ?>
					<form action="index.php" method="post" id="languagesForm" class="form-validate">
						<p id="wait_installing" style="display: none;">
							<?php echo Text::_('INSTL_LANGUAGES_MESSAGE_PLEASE_WAIT'); ?><br>
							<div id="wait_installing_spinner" class="spinner spinner-img" style="display: none;"></div>
						</p>
						<div class="j-install-step-body pb-4"><?php echo Text::_('INSTL_LANGUAGES_DESC'); ?></div>
						<div class="j-install-scrollable-table">
							<table>
								<thead>
								<tr>
									<td scope="col">
										<input type="checkbox" id="j-install-check-all-lang" class="j-checkbox">
									</td>
									<th scope="col">
										<?php echo Text::_('INSTL_LANGUAGES_COLUMN_HEADER_LANGUAGE'); ?>
									</th>
									<th scope="col" width="35%">
										<?php echo Text::_('INSTL_LANGUAGES_COLUMN_HEADER_LANGUAGE_TAG'); ?>
									</th>
									<th scope="col" width="5%" class="text-center">
										<?php echo Text::_('INSTL_LANGUAGES_COLUMN_HEADER_VERSION'); ?>
									</th>
								</tr>
								</thead>
								<tbody id="j-lang-checkboxes">
								<?php $version = new \Joomla\CMS\Version; ?>
								<?php $currentShortVersion = preg_replace('#^([0-9\.]+)(|.*)$#', '$1', $version->getShortVersion()); ?>
								<?php foreach ($this->items as $i => $language) : ?>
									<?php // Get language code and language image. ?>
									<?php preg_match('#^pkg_([a-z]{2,3}-[A-Z]{2})$#', $language->element, $element); ?>
									<?php $language->code = $element[1]; ?>
									<tr>
										<td>
											<input class="j-checkbox" type="checkbox" id="cb<?php echo $i; ?>" name="cid[]" value="<?php echo $language->update_id; ?>">
										</td>
										<td scope="row">
											<label for="cb<?php echo $i; ?>"><?php echo $language->name; ?></label>
										</td>
										<td>
											<?php echo $language->code; ?>
										</td>
										<td class="text-center">
											<?php // Display a Note if language pack version is not equal to Joomla version ?>
											<?php if (substr($language->version, 0, 3) != $version::MAJOR_VERSION . '.' . $version::MINOR_VERSION || substr($language->version, 0, 5) != $currentShortVersion) : ?>
												<span class="hasTooltip" title="<?php echo Text::_('JGLOBAL_LANGUAGE_VERSION_NOT_PLATFORM'); ?>"><?php echo $language->version; ?></span>
											<?php else : ?>
												<span><?php echo $language->version; ?></span>
											<?php endif; ?>
										</td>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
						<div class="j-install-step-body btn-wrapper j-install-step-footer">
							<?php echo HTMLHelper::_('form.token'); ?>
							<?php endif; ?>
							<button id="skipLanguages" class="btn">
								<?php echo Text::_('JSKIP'); ?>
							</button>
							<button id="installLanguagesButton" class="btn btn-primary">
								<?php echo Text::_('JNEXT'); ?>
							</button>
						</div>
					</form>
				</div>
			</fieldset>

			<fieldset id="installSampleData" class="j-install-step j-install-form">
				<div class="j-install-step-form">
					<h2><?php echo Text::_('INSTL_SITE_INSTALL_SAMPLE_LABEL'); ?></h2>
					<p><?php echo Text::_('INSTL_SITE_INSTALL_SAMPLE_DESC'); ?></p>


					<form action="index.php" method="post" id="sampleDataForm" class="form-validate j-install-step-footer">
						<div class="">
							<input type="hidden" name="sample_file" value="sample_testing.sql">
							<?php echo HTMLHelper::_('form.token'); ?>
							<div class="btn-wrapper">
								<button id="skipSampleData" class="btn">
									<?php echo Text::_('JSKIP'); ?>
								</button>
								<button id="installSampleDataButton" class="btn btn-primary">
									<?php echo Text::_('INSTL_SITE_INSTALL_SAMPLE'); ?>
								</button>
							</div>
						</div>
					</form>
				</div>
			</fieldset>

			<fieldset id="installFinal" class="j-install-form no-padding j-install-step">
				<div class="j-install-step-iconic-header">
					<span class="icon-check icon" aria-hidden="true"></span> <span><?php echo Text::_('INSTL_COMPLETE_CONGRAT'); ?></span>
				</div>

				<div class="j-install-step-form j-install-step-body pt-4">
					<p><?php echo Text::_('INSTL_COMPLETE_FINAL_DESC'); ?></p>
				</div>

				<div class="btn-group btn-group-lg j-install-step-btn-group j-install-step-footer no-padding">
					<a class="btn btn-default" href="<?php echo Uri::root(); ?>" title="<?php echo Text::_('JSITE'); ?>"><span class="icon-eye-open" aria-hidden="true"></span> <?php echo Text::_('INSTL_COMPLETE_SITE_BTN'); ?></a>
					<a class="btn btn-primary" href="<?php echo Uri::root(); ?>administrator/" title="<?php echo Text::_('JADMINISTRATOR'); ?>"><span class="icon-cog" aria-hidden="true"></span> <?php echo Text::_('INSTL_COMPLETE_ADMIN_BTN'); ?></a>
				</div>
			</fieldset>
		</div><!-- right side information column -->
	</div>
</div>
