<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2017 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div class="eb-mod-top-posts<?php echo $modules->getWrapperClass();?>" data-eb-module-topblogs>
    <?php if ($posts) { ?>
        <div class="eb-mod-top-post-list">
            <?php foreach ($posts as $key => $post) { ?>
                <div class="eb-mod-top-post d-flex">
                    <?php if ($params->get('photo_show', true) && $post->cover) { ?>
                        <div class="eb-mod-top-post-thumb">
                            <a href="<?php echo $post->getPermalink();?>" class="eb-mod-top-post-image-cover" 
                                title="<?php echo EB::themes()->escape($post->getImageTitle());?>" 	
                                style="background-image: url('<?php echo $post->cover;?>');">
                            </a>
                            <span><?php echo $key + 1; ?></span>
                        </div>
                    <?php } ?>
                    <div class="eb-mod-top-post-title">
                        <a href="<?php echo $post->getPermalink(); ?>" title="<?php echo EB::themes()->escape($post->title); ?>"><?php echo $post->title;?></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>