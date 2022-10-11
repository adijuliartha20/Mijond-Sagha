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
if (have_posts()) :
	?>
	<div id="page-detail-blog" class="content content-blog-style content-blog<?php echo ' content-'.$post->post_name?>">
		<?php 
			set_query_var( 'id_current', array($post->ID));
			get_template_part( 'content', 'slide' );
			get_template_part( 'content', 'blog-detail' );
			get_template_part( 'content', 'blog-other' );
		?>
		<div class="category-list-mobile hide">
			<div class="middle">
				<?php get_template_part( 'content', 'blog-list-content-right' ); ?>	
			</div>
		</div>
	</div>
	<?php
else :
	get_template_part( 'content', 'none' );		
endif;?>
<?php get_footer();?>	