<?php
/**
 * @package Helix Ultimate Framework
 * @author JoomShaper https://www.joomshaper.com
 * @copyright Copyright (c) 2010 - 2018 JoomShaper
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
*/

defined ('_JEXEC') or die();

$doc = JFactory::getDocument();
$app = JFactory::getApplication();

$helix_path = JPATH_PLUGINS . '/system/helixultimate/core/helixultimate.php';
if (file_exists($helix_path)) {
    require_once($helix_path);
    $theme = new helixUltimate;
} else {
    die('Install and activate <a target="_blank" href="https://www.joomshaper.com/helix">Helix Ultimate Framework</a>.');
}

//Coming Soon
if ($this->params->get('comingsoon'))
{
  header("Location: " . $this->baseUrl . "?tmpl=comingsoon");
}

$custom_style = $this->params->get('custom_style');
$preset = $this->params->get('preset');

if($custom_style || !$preset)
{
    $scssVars = array(
        'preset' => 'default',
        'text_color' => $this->params->get('text_color'),
        'bg_color' => $this->params->get('bg_color'),
        'link_color' => $this->params->get('link_color'),
        'link_hover_color' => $this->params->get('link_hover_color'),
        'header_bg_color' => $this->params->get('header_bg_color'),
        'logo_text_color' => $this->params->get('logo_text_color'),
        'menu_text_color' => $this->params->get('menu_text_color'),
        'menu_text_hover_color' => $this->params->get('menu_text_hover_color'),
        'menu_text_active_color' => $this->params->get('menu_text_active_color'),
        'menu_dropdown_bg_color' => $this->params->get('menu_dropdown_bg_color'),
        'menu_dropdown_text_color' => $this->params->get('menu_dropdown_text_color'),
        'menu_dropdown_text_hover_color' => $this->params->get('menu_dropdown_text_hover_color'),
        'menu_dropdown_text_active_color' => $this->params->get('menu_dropdown_text_active_color'),
        'footer_bg_color' => $this->params->get('footer_bg_color'),
        'footer_text_color' => $this->params->get('footer_text_color'),
        'footer_link_color' => $this->params->get('footer_link_color'),
        'footer_link_hover_color' => $this->params->get('footer_link_hover_color'),
        'topbar_bg_color' => $this->params->get('topbar_bg_color'),
        'topbar_text_color' => $this->params->get('topbar_text_color')
    );
}
else
{
    $scssVars = (array) json_decode($this->params->get('preset'));
}

$scssVars['header_height'] = $this->params->get('header_height', '60px');
$scssVars['offcanvas_width'] = $this->params->get('offcanvas_width', '270') . 'px';


//Body Background Image
if ($bg_image = $this->params->get('body_bg_image'))
{
    $body_style = 'background-image: url(' . JURI::base(true) . '/' . $bg_image . ');';
    $body_style .= 'background-repeat: ' . $this->params->get('body_bg_repeat') . ';';
    $body_style .= 'background-size: ' . $this->params->get('body_bg_size') . ';';
    $body_style .= 'background-attachment: ' . $this->params->get('body_bg_attachment') . ';';
    $body_style .= 'background-position: ' . $this->params->get('body_bg_position') . ';';
    $body_style = 'body.site {' . $body_style . '}';
    $doc->addStyledeclaration($body_style);
}

//Custom CSS
if ($custom_css = $this->params->get('custom_css'))
{
    $doc->addStyledeclaration($custom_css);
}

$progress_bar_position = $this->params->get('reading_timeline_position');

if( $app->input->get('view') == 'article' && $this->params->get('reading_time_progress', 0) ) {
    
    $progress_style = 'position:fixed;';
    $progress_style .= 'z-index:9999;';
    $progress_style .= 'height:'.$this->params->get('reading_timeline_height').';';
    $progress_style .= 'background-color:'.$this->params->get('reading_timeline_bg').';';
    $progress_style .= $progress_bar_position == 'top' ? 'top:0;' : 'bottom:0;';
    $progress_style = '.sp-reading-progress-bar { '.$progress_style.' }';
    $doc->addStyledeclaration($progress_style);
}

//Custom JS
if ($custom_js = $this->params->get('custom_js'))
{
    $doc->addScriptdeclaration($custom_js);
}

?>

<!doctype html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="canonical" href="<?php echo JUri::getInstance()->toString(); ?>">
        <?php

        $theme->head();
        
        $theme->add_css('font-awesome.min.css');
        $theme->add_js('main.js');

        $theme->add_scss('master', $scssVars, 'template');
        
        $theme->add_css('custom');

        //Before Head
        if ($before_head = $this->params->get('before_head'))
        {
            echo $before_head . "\n";
        }
        ?>
    </head>
    <body class="<?php echo $theme->bodyClass(); ?>">
    <?php if($this->params->get('preloader')) : ?>
        <div class="sp-preloader"><div></div></div>
    <?php endif; ?>

    <div class="body-wrapper">
        <div class="body-innerwrapper">
            <?php echo $theme->getHeaderStyle(); ?>
            <?php $theme->render_layout(); ?>
        </div>
    </div>

    <!-- Off Canvas Menu -->
    <div class="offcanvas-overlay"></div>
    <div class="offcanvas-menu">
        <a href="#" class="close-offcanvas"><span class="fa fa-remove"></span></a>
        <div class="offcanvas-body">
            <?php
                $sitename = \JFactory::getApplication()->get('sitename');
            ?>
            <div class="offcanvas-header">
                <a href="<?php echo \JURI::base(true); ?>/">
                    <img src="<?php echo JURI::base(true) . '/templates/' . $this->template . '/images/logo.svg'; ?>" alt="<?php echo $sitename; ?>">
                </a>
            </div>
            <div class="offcanvas-inner">
                <jdoc:include type="modules" name="offcanvas" style="sp_xhtml" />
            </div>
            <div class="offcanvas-footer">
                &copy; 2019 Learn Joomla Free. All Rights Reserved.
            </div>
        </div>
    </div>

    <?php $theme->after_body(); ?>

    <?php if($this->countModules('search-popup')) : ?>
        <div class="search-popup" style="display: none;">
            <div class="search-popup-inner">
                <a class="search-popup-close" href="#" aria-label="Close Search" data-toggle="tooltip" data-placement="top" title="Close Search">
                    <svg width="30" height="30" xmlns="http://www.w3.org/2000/svg">
                       <path d="M17.199474 14.970819L29.480058 2.690234c.61538-.615439.61538-1.613216 0-2.228597-.615438-.615438-1.613274-.615438-2.228655 0L14.97076 12.742222 2.690175.461637C2.074737-.1538 1.07696-.1538.46158.461637c-.61538.615439-.615439 1.613217 0 2.228597l12.280585 12.280585L.461579 27.251403c-.615439.61544-.615439 1.613217 0 2.228597.615439.615439 1.613216.61538 2.228596 0L14.97076 17.199415 27.251286 29.48c.61544.615439 1.613275.61538 2.228655 0 .61538-.615439.61538-1.613216 0-2.228597L17.199475 14.97082z" fill-rule="nonzero"/>
                    </svg>
                </a>
                <div class="search-popup-title">Search Here</div>
                <p class="search-popup-description">Begin typing your search above and press return to search.</p>
                <jdoc:include type="modules" name="search-popup" style="sp_xhtml" />
            </div>
        </div>
    <?php endif; ?>

    <jdoc:include type="modules" name="debug" style="none" />
    </body>
</html>