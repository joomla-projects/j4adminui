<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

require_once JPATH_PLUGINS. '/system/helixultimate/core/classes/menu.php';

class HelixUltimateFeatureMenu {
	private $params;

	public function __construct($params) {
		$this->params = $params;
		$this->position = 'menu';
	}

	public function renderFeature() {
		$output = '<nav class="sp-megamenu-wrapper" role="navigation">';
		$menu = new HelixUltimateMenu('d-none d-lg-block','');
		$output .= $menu->render();
		$output .= '</nav>';

		return $output;
	}
}
