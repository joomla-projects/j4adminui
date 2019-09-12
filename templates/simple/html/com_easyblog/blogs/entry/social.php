<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2014 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');

$url    =  $post->getPermalink();
$root   = JURI::base();
$root   = new JURI($root);
$url    = $root->getScheme() . '://' . $root->getHost() . $url;
?>
<div class="eb-tool-social-share">
    <div class="eb-tool-title">Share</div>
	<ul>
        <li>
            <a class="eb-tool-social-share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank" rel="noopener nofollow"><span class="fa fa-facebook-square"></span></a>
        </li>

        <li>
            <a class="eb-tool-social-share-twitter" href="https://twitter.com/intent/tweet?text=<?php echo $post->title; ?>&url=<?php echo urlencode($url); ?>" target="_blank" rel="noopener nofollow"><span class="fa fa-twitter"></span></a>
        </li>
    </ul>
</div>