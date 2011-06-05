<div class="regions index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Page', true), array('action'=>'add')); ?></li>
        </ul>
    </div>

    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
            $paginator->sort('id'),
            $paginator->sort('loc'),
            $paginator->sort('lastmod'),
            $paginator->sort('changefreq'),
            $paginator->sort('priority'),
            __('Actions', true),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($records AS $record) {
            $actions  = $this->Html->link(__('Edit', true), array('action' => 'edit', $record['Sitemap']['id']));
            $actions .= ' ' . $this->Html->link(__('Delete', true), array(
                'action' => 'delete',
                $record['Sitemap']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?', true));

            $rows[] = array(
                $record['Sitemap']['id'],
                $record['Sitemap']['loc'],
                $record['Sitemap']['lastmod'],
                $record['Sitemap']['changefreq'],
                $record['Sitemap']['priority'],
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
</div>

<div class="paging"><?php echo $paginator->numbers(); ?></div>
<div class="counter"><?php echo $paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true))); ?></div>
