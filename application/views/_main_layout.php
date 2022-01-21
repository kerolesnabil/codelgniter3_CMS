<?php  $this->load->view('components/Page_head.php')  ?>

<body>
<div class="container">
    <section>
        <h1><?php  echo  anchor('',config_item('site_name'))?></h1>
    </section>
    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <?php echo get_menu($menu)   ?>
            </div>
        </div>
    </div>
</div>
<div class="container">

    <?php  $this->load->view('templates/'.$subview) ;?>
</div>

<?php  $this->load->view('components/Page_tail')  ?>