<div class="panel-search-qna">
	<div class="middle clearfix">
		<label><?php echo pll__('Find Another Topic');?></label>
		<div class="gray-select fleft hide">
			<select id="select-all-cat-faq" class="select-all-cat-faq" onchange="goto_this(event)">
			<?php 
			$terms = get_terms( 'faq_cat' );
			//print_r($terms);
			//print_r($qobj);
			foreach ( $terms as $key => $term ) {
				?>
				<option <?php if($term->slug==$qobj) echo "selected"; ?> value="<?php echo esc_url( get_term_link( $term ) );?>"><?php echo $term->name; ?>	</option>
				<?php 
			}
			?>
			</select>	
		</div>
		

		<div class="search-box fright">
			<form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
				<input type="text" name="search" placeholder="<?php echo pll__('Search');?>">
				<button class="btn-search">
					<img class="" src="<?php echo get_template_directory_uri().'/images/search.png' ?>">  
				</button>
			    <input type="hidden" name="post_type" value="faq" /> <!-- // hidden 'products' value -->
		    </form>
		</div>
	</div>
</div>