<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */

defined('_JEXEC') or die();

class HelixUltimateFeatureLogo {
    
    private $params;
    
    public function __construct($params) {
        $this->params = $params;
        $this->position = 'logo';
    }
    
    public function renderFeature() {
        $template_name = JFactory::getApplication()->getTemplate();
        $menu_type = $this->params->get('menu_type');
        $offcanvs_position = $this->params->get('offcanvas_position', 'right');
        $doc = \JFactory::getDocument();
        
        $logo = JURI::base(true) . '/templates/' . $template_name . '/images/logo.svg';
        
        $html = '';
        
        $custom_logo_class = '';
        $sitename = \JFactory::getApplication()->get('sitename');
        
		$html .= '<div class="logo">';
        $html .= '<a href="' . \JURI::base(true) . '/">';
        $html .= '<img class="logo-image' . $custom_logo_class . '" src="' . $logo . '" alt="' . $sitename . '">';
        $html .= '</a>';
        $html .= '</div>';
        
        return $html;
    }
}
