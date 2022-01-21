
<h2>Recent modified articles</h2>

<?php if (count($recent_articles)):  ?>

<ul>
    <?php foreach($recent_articles as $article):  ?>



        <li> <?php echo anchor('admin/Article/edit/'. $article->id ,e($article->title)) ?> - <?php echo date('Y-m-d')?> </li>
    <?php endforeach; ?>
</ul>

<?php endif;  ?>


