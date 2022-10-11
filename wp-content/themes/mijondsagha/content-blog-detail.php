<div class="container-blog-detail">
	<div class="middle clearfix">
		<div class="cbd fleft">
			<div class="cbd-search-box hide">
				<?php get_template_part( 'content', 'blog-search-box' );  ?>
			</div>
			<div class="cbd-detail">
				<?php echo apply_filters('the_content', $post->post_content); ?>	
			</div>
			<div class="cbd-comment">
				<div class="tags-share clearfix">
					<div class="tags fleft clearfix">
						<?php 
							$t = wp_get_post_tags($post->ID);//print_r($t);
							foreach ($t as $key => $tag) {
								?>
									<a class="fleft" href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name; ?></a>
								<?php 
							}

						?>
					</div>
					<div class="share fright clearfix">
						<a id="share-fb" class="share-fb fleft" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_permalink($post->ID); ?>" onclick="return fbs_click('share-fb')" target="_blank" title="Share This on Facebook" rel="nofollow" data-url="https://www.facebook.com/sharer/sharer.php?u=">
							<img class="fleft" src="<?php echo get_template_directory_uri().'/images/fb-gray.png'?>">
						</a>
						<a id="share-t" class="share-t fleft" href="https://twitter.com/home?status=<?php echo get_permalink($post->ID); ?>" onclick="return fbs_click('share-t')" target="_blank" title="Share This on Twitter" rel="nofollow" data-url="https://twitter.com/home?status=<?php echo get_permalink($post->ID); ?>">
							<img class="fleft" src="<?php echo get_template_directory_uri().'/images/twitter-gray.png'?>">
						</a>
						<a id="share-gp" class="share-gp fleft" href="https://plus.google.com/share?url=<?php echo get_permalink($post->ID);?>" onclick="return fbs_click('share-gp')" target="_blank" title="Share This on Google Plus" rel="nofollow" data-url="https://plus.google.com/share?url=<?php echo get_permalink($post->ID);?>">
							<img class="fleft" src="<?php echo get_template_directory_uri().'/images/gplus-gray.png'?>">
						</a>
						<a id="share-li" class="share-li fleft" href="https://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=&source=<?php echo get_permalink($post->ID);?>" onclick="return fbs_click('share-li')" target="_blank" title="Share This on Linkedin" rel="nofollow" data-url="https://www.linkedin.com/shareArticle?mini=true&url=&title=&summary=&source=<?php echo get_permalink($post->ID);?>">
							<img class="fleft" src="<?php echo get_template_directory_uri().'/images/linkedin-gray.png'?>">
						</a>
					</div>
				</div>
				<?php echo apply_filters('the_content_2', "");?>
			</div>
		</div>
		<div class="list-category-blog list-category-blog-detail fright">
			<?php 
				get_template_part( 'content', 'blog-search-box' ); 
				get_template_part( 'content', 'blog-list-content-right' ); 

			?>
		</div>
	</div>
</div>
<div class="container-other-blog"></div>