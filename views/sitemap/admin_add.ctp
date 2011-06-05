<div class="sitemap form">
    <h2><?php echo $title_for_layout; ?></h2>
    <?php echo $this->Form->create('Sitemap',array('url'=>$this->here));?>
    <fieldset>
        <div class="tabs">
            <ul>
                <li><a href="#sitemap-main"><span><?php __('Sitemap'); ?></span></a></li>
            </ul>

            <div id="region-main">
            <?php
                echo $this->Form->input('loc',array('value'=>'/','label'=>'URL'));
                echo $this->Form->input('lastmod',array('value'=>'-7 days','label'=>'Last Modified'));
                echo $this->Form->input('changefreq',array('value'=>'weekly','label'=>'Change Frequency'));
                echo $this->Form->input('priority',array('value'=>'0.6','label'=>'Priority'));
            ?>
            </div>
        </div>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->end(__('Save', true));
        echo $this->Html->link(__('Cancel', true), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>