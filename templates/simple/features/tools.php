<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

class HelixUltimateFeatureTools {

	private $params;

	public function __construct($params) {
		$this->params = $params;
		$this->position = 'menu';
	}

	public function renderFeature() {
		$user = JFactory::getUser();

		$output = '<div class="site-tools d-flex">';
		$output .= '<ul>';
		$output .= '<li><a class="anchor-search-popup" href="#"><svg width="18" height="18" xmlns="http://www.w3.org/2000/svg"><path d="M17.78 16.722l-4.328-4.328A7.588 7.588 0 0 0 7.585 0a7.586 7.586 0 1 0 0 15.171 7.546 7.546 0 0 0 4.806-1.715l4.327 4.324a.75.75 0 0 0 1.062-1.058zm-10.194-3.06a6.084 6.084 0 0 1-6.08-6.076c0-3.35 2.726-6.08 6.08-6.08a6.09 6.09 0 0 1 6.08 6.08c0 3.35-2.73 6.076-6.08 6.076z" fill="#000" fill-rule="nonzero"/></svg></a></li>';
		
		$document 	= JFactory::getDocument();
		$renderer  	= $document->loadRenderer('modules');
		$options   	= array('style' => 'sp_xhtml');
		$render 	= $renderer->render('login', $options, null);

		if ($user->id) {
			$acl = EB::acl();
			if ($acl->get('add_entry')) {
				$user = EB::user();
				$attr = array(
					'user' => $user,
					'size' => 36
				);
				$output 	.= '<li class="position-relative"><a class="anchor-login-dropdown" href="#"><span class="eb-avatar">'. coreHelper::getAvatar($attr) .'</span><span><span class="d-none d-md-inline-block">'. $user->getName() .'</span> <span class="fa fa-angle-down"></span></span></a><div class="login-dropdown" style="display: none;">'. $render .'</div></li>';
			}
		}

		$output 	.= '</ul>';
		$output 	.= '</div>';

		return $output;

	}
}
