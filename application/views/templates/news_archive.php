<!-- Main content     -->

<div class="span8">
    <?php if($pagination) : ?>

        <section class="pagination">
            <?php  echo $pagination ?>
        </section>

    <?php endif;  ?>
    <div class="row">
        <?php if(count($articles)) : ?>
            <?php foreach ($articles as $article) :  ?>
                <article class="span8"><?php echo get_excerpt($article); ?><hr></article>
            <?php endforeach; ?>
        <?php endif;  ?>
    </div>
</div>

<!--  Sidebar   -->
<div class="span3 sidebar">
    <h2> Recent news </h2>
    <?php

    $this->load->view('sidebar');
    ?>

</div>