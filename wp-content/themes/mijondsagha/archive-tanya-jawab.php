<?php get_header();?>
<?php 
$page = get_posts(array('name' => 'tanya-jawab-page','post_type' => 'page'));
$main_content = apply_filters('the_content', $page[0]->post_content);
set_query_var( 'title', $page[0]->post_title );
set_query_var( 'main_content', $main_content);

print_r($page);
?>
<?php 
if ( have_posts() ) :
	?>
	<div id="content-qna-list" class="content content-page content-qna-list">
		<?php get_template_part( 'content', 'slide-default' ); ?>
		<?php get_template_part( 'content', 'panel-qna' ); ?>
		<div class="conten-qna clearfix">
			<div class="middle clearfix">
				<?php 
					get_template_part( 'content', 'sidebar-menu' );
					get_template_part( 'content', 'qna' );	
				?>
			</div>
		</div>
	</div> 
	<?php
endif;
?>
<?php get_footer();?>