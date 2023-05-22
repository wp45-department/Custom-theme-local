<?php 
get_header();
?>
<section id="hero" class="d-flex align-items-center">

<div class="container">
  <div class="row">
    <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
      <h1><?php echo the_title(); ?></h1>
      <h2>We are team of talented designers making websites with Bootstrap</h2>
    </div>
    <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
      <?php echo the_post_thumbnail(); ?>
    </div>
  </div>
</div>
</section>
<div class="cust-podcast-excerpt">
<?php echo the_excerpt(); ?>
</div>
<?php 
get_footer();
?>