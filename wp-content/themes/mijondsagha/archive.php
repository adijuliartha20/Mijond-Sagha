<?php get_header();?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.11&appId=115507108641441';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php 
if ( have_posts() ) :
	?>
	<div id="page-blog" class="content content-page<?php echo ' content-'.$post->post_name?>">
		<?php 
			get_template_part( 'content', 'slide' );
			get_template_part( 'content', 'blog' );
		?>
	</div>
	<?php
endif;
?>
<?php get_footer();?>