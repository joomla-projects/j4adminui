<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.Khonsu
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       4.0
 */
defined('_JEXEC') or die;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

/** @var JDocumentHtml $this */
$app   = Factory::getApplication();
$lang  = $app->getLanguage();
$input = $app->input;
$wa    = $this->getWebAssetManager();
// Detecting Active Variables
$option     = $input->get('option', '');
$view       = $input->get('view', '');
$layout     = $input->get('layout', 'default');
$task       = $input->get('task', 'display');
$itemid     = $input->get('Itemid', '');
$cpanel     = $option === 'com_cpanel';
$hiddenMenu = $app->input->get('hidemainmenu');
$menuSettings = $app->input->cookie->get('main-sidebar');

$hiddenMenuClass = $hiddenMenu || $menuSettings == 'closed' ? 'main-sidebar-collapsed' : '';
$hiddenMenuClass .= $hiddenMenu ? ' hide-sidebar-toggler' : '';

$joomlaLogo = $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';
require_once __DIR__ . '/Service/HTML/Khonsu.php';
// Template params
$siteLogo  = $this->params->get('siteLogo')
	? JUri::root() . $this->params->get('siteLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo-joomla.svg';
$smallLogo = $this->params->get('smallLogo')
	? JUri::root() . $this->params->get('smallLogo')
	: $this->baseurl . '/templates/' . $this->template . '/images/logo.svg';
$logoAlt = htmlspecialchars($this->params->get('altSiteLogo', ''), ENT_COMPAT, 'UTF-8');
$logoSmallAlt = htmlspecialchars($this->params->get('altSmallLogo', ''), ENT_COMPAT, 'UTF-8');
// Enable assets
$wa->enableAsset('template.khonsu.' . ($this->direction === 'rtl' ? 'rtl' : 'ltr'));
// Load specific language related CSS
HTMLHelper::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', ['version' => 'auto']);
// Load customer stylesheet if available
HTMLHelper::_('stylesheet', 'custom.css', array('version' => 'auto', 'relative' => true));
// Load specific template related JS
// TODO: Adapt refactored build tools pt.2 @see https://issues.joomla.org/tracker/joomla-cms/23786
HTMLHelper::_('script', 'media/templates/' . $this->template . '/js/template.min.js', ['version' => 'auto']);
// Set some meta data
$this->setMetaData('viewport', 'width=device-width, initial-scale=1');
// @TODO sync with _variables.scss
$this->setMetaData('theme-color', '#1c3d5c');
$this->addScriptDeclaration('cssVars();');
// Opacity must be set before displaying the DOM, so don't move to a CSS file
$css = '
	.container-main > * {
		opacity: 0;
	}
	.sidebar-wrapper > * {
		opacity: 0;
	}
';
// $this->addStyleDeclaration($css);
$this->addStyleDeclaration("
    :root {
        --skeleton-bg: url(". Uri::root() . 'media/system/images/skeleton.gif' .");
    }
");

$monochrome = (bool) $this->params->get('monochrome');
HTMLHelper::getServiceRegistry()->register('khonsu', 'JHtmlKhonsu');
HTMLHelper::_('khonsu.rootcolors', $this->params);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<jdoc:include type="metas" />
	<jdoc:include type="styles" />
</head>

<body class="admin <?php echo $option . ' view-' . $view . ' layout-' . $layout . ($task ? ' task-' . $task : '') . ($monochrome ? ' monochrome' : ''); ?>">

<noscript>
	<div class="j-alert j-alert-danger" role="alert">
		<?php echo Text::_('JGLOBAL_WARNJAVASCRIPT'); ?>
	</div>
</noscript>

<?php // Wrapper ?>
<div id="wrapper" class="d-flex wrapper <?php echo $hiddenMenuClass; ?>">
	<?php // Header ?>
	<header id="header" class="header">
		<div class="logo-header">
			<div class="main-logo d-flex align-items-center">
				<?php // No home link in edit mode (so users can not jump out) and control panel (for a11y reasons) ?>
				<?php if ($hiddenMenu || $cpanel) : ?>
					<div class="logo">
						<img class="logo-main" src="<?php echo $siteLogo; ?>" alt="<?php echo $logoAlt; ?>">
						<img class="logo-small" src="<?php echo $smallLogo; ?>" alt="<?php echo $logoSmallAlt; ?>">
					</div>
				<?php else : ?>
					<a class="logo" href="<?php echo Route::_('index.php'); ?>"
					   aria-label="<?php echo Text::_('TPL_BACK_TO_CONTROL_PANEL'); ?>">
						<img class="logo-main" src="<?php echo $siteLogo; ?>" alt="">
						<img class="logo-small" src="<?php echo $smallLogo; ?>" alt="">
					</a>
				<?php endif; ?>
				<div class="joomla-version mx-3 d-none d-sm-inline-flex" title="<?php echo JVERSION; ?>">
					<span class="sr-only"><?php echo Text::sprintf('MOD_VERSION_CURRENT_VERSION_TEXT', JVERSION); ?></span>
					<span class="text-truncate" aria-hidden="true"><?php echo JVERSION; ?></span>
				</div>
			</div>
			<?php if (!$hiddenMenu): ?>
				<div class="sidebar-toggle d-none d-sm-block">
					<a id="menu-collapse" href="#" title="<?php echo Text::_('JTOGGLE_SIDEBAR_MENU'); ?>">
						<span id="menu-collapse-icon" class="icon-<?php echo $hiddenMenuClass === 'closed' ? 'angle-double-right' : 'angle-double-left' ?> duotone" aria-hidden="true"></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="header-title">
			<jdoc:include type="modules" name="title" />
		</div>
		<div class="header-items">
			<jdoc:include type="modules" name="status" style="header-item" />
		</div>
		<div class="navbar-wrap">
			<div class="navbar-mobile-quick-wrap">
				<jdoc:include type="modules" name="quickmenu" style="none" />
			</div>
			<button class="navbar-toggler toggler-burger collapsed" type="button" data-toggle="collapse" data-target="#sidebar-wrapper" aria-controls="sidebar-wrapper" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</header>

	<?php // Sidebar ?>

	<?php //if (!$hiddenMenu) : ?>

	<div id="sidebar-wrapper" class="sidebar-wrapper sidebar-menu" <?php echo $hiddenMenu ? 'data-hidden="' . $hiddenMenu . '"' : ''; ?>>
		<div id="sidebarmenu">
			<jdoc:include type="modules" name="menu" style="none" />
		</div>
	</div>

	<span class="navbar-mobile-overlay navbar-toggler collapsed" data-toggle="collapse" data-target="#sidebar-wrapper" aria-controls="sidebar-wrapper" aria-expanded="false"></span>

	<?php //endif; ?>

	<?php // container-fluid ?>
	<div class="container-fluid container-main">
		<?php if (!$cpanel) : ?>
			<?php // Subheader ?>
			<button type="button" class="toggle-toolbar mx-auto btn btn-secondary my-3 d-md-none d-lg-none d-xl-none" data-toggle="collapse"
					data-target=".subhead"><?php echo Text::_('TPL_KHONSU_TOOLBAR'); ?>
				<span class="icon-chevron-down" aria-hidden="true"></span>
			</button>
			<div id="subhead" class="subhead mb-4">
				<div id="container-collapse" class="container-collapse"></div>
				<div class="row">
					<div class="col-md-12">
						<jdoc:include type="modules" name="toolbar" style="no" />
					</div>
				</div>
			</div>
		<?php endif; ?>
		<section id="content" class="content">
			<?php // Begin Content ?>
			<jdoc:include type="modules" name="top" style="xhtml" />
			<div class="row">
				<div class="col-md-12">
					<main>
						<jdoc:include type="component" />
					</main>
				</div>
				<?php if ($this->countModules('bottom')) : ?>
					<jdoc:include type="modules" name="bottom" style="xhtml" />
				<?php endif; ?>
			</div>
			<?php // End Content ?>
		</section>

		<div class="notify-alerts">
			<jdoc:include type="message" />
		</div>
	</div>
</div>
<jdoc:include type="modules" name="debug" style="none" />
<jdoc:include type="scripts" />
</body>
</html>
