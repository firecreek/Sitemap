<?php echo '<?xml version="1.0" encoding="UTF-8" ?>'; ?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.9">
<?php foreach($output as $page): ?>
  <url>
    <?php foreach($page as $key => $val): ?>
      <<?php echo $key; ?>><?php echo $val; ?></<?php echo $key; ?>>
    <?php endforeach; ?>
  </url>
<?php endforeach; ?>
</urlset>