<div id="services">
<div class="title-container">

  <h2 class="color text-center">services</h2>
</div>

<div class="services-grid">

<?php query_posts('post_type=services'); ?>
		<?php

while ( have_posts() ) : the_post();
?>

		<div class="service-card">
	
			<h3> <?php the_field('title') ?>
			</h3>
		
 
			<p>from 
				<?php the_field('description') ?>
      </p>
			<p>from 
				<?php the_field('price') ?>
      </p>
		</div>
		<?php
endwhile; // End of the loop.
    ?>

		<?php wp_reset_query(); ?>

		<div class="service-dog">

		<div class="dog">
  <div class="ears"></div>
  
  <div class="body">
    <div class="eyes"></div>
    <div class="beard">
      <div class="mouth">
        <div class="tongue"></div>
      </div>
    </div>
    <div class="belt">
      <div class="locket"></div>
      <div class="dot dot1"></div>
      <div class="dot dot2"></div>
      <div class="dot dot3"></div>
      <div class="dot dot4"></div>
      <div class="tag"></div>
    </div>
    <div class="stomach">
    </div>
    <div class="legs">
      <div class="left"></div>
      <div class="right"></div>
    </div>
  </div>
  <div class="tail">
  </div>
</div>
</div>
		</div>

<button class="hero-button btn-color">book now</button>

</div>