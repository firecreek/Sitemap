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
                echo $this->Form->input('loc',array('label'=>'URL'));
                echo $this->Form->input('lastmod',array('label'=>'Last Modified'));
                echo $this->Form->input('changefreq',array('label'=>'Change Frequency'));
                echo $this->Form->input('priority',array('label'=>'Priority'));
            ?>
            </div>
        </div>
    </fieldset>

    <div class="buttons">
    <?php
        echo $this->Form->hidden('id');
        echo $this->Form->end(__('Save', true));
        echo $this->Html->link(__('Cancel', true), array(
            'action' => 'index',
        ), array(
            'class' => 'cancel',
        ));
    ?>
    </div>
</div>