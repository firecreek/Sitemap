<a href="#"><?php __('Sitemap'); ?></a>
<ul>
   <li><?php echo $html->link(__('Maintain', true), array('plugin' => 'sitemap', 'controller' => 'sitemap', 'action' => 'index')); ?></li>
   <li><?php echo $html->link(__('Sitemap settings', true), array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Sitemap')); ?></li>
</ul>
