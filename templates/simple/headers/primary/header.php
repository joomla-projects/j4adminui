<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

$data = $displayData;
$offcanvs_position = $displayData->params->get('offcanvas_position', 'right');

$feature_folder_path     = JPATH_THEMES . '/' . $data->template->template . '/features/';

include_once $feature_folder_path.'logo.php';
include_once $feature_folder_path.'menu.php';
include_once $feature_folder_path.'tools.php';

$output  = '';

$output .= '<header id="sp-header">';
$output .= '<div class="container">';
$output .= '<div class="container-inner">';
$output .= '<div class="d-flex">';

// Logo
$output .= '<div id="sp-logo" class="mr-2 mr-md-5">';
$logo    = new HelixUltimateFeatureLogo($data->params);
$output .= $logo->renderFeature();
$output .= '</div>';

// Menu
$output .= '<div id="sp-menu" class="ml-2 ml-md-5">';
$menu    = new HelixUltimateFeatureMenu($data->params);
$output .= $menu->renderFeature();
$output .= '</div>';

// Tools
$output .= '<div id="sp-tools" class="ml-auto d-flex">';
$tools    = new HelixUltimateFeatureTools($data->params);
$output .= $tools->renderFeature();
$output .= '</div>';

$output .= '<a id="offcanvas-toggler" aria-label="'. JText::_('HELIX_ULTIMATE_NAVIGATION') .'" class="offcanvas-toggler-right d-inline-block d-lg-none ml-3" href="#"><i class="fa fa-bars" aria-hidden="true" title="'. JText::_('HELIX_ULTIMATE_NAVIGATION') .'"></i></a>';

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '<div class="learn-joomla-brand"><span></span><span></span><span></span></div>';
$output .= '</header>';

echo $output;