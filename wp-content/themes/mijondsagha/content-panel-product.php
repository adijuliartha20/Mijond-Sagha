<?php
$qobj = get_queried_object();
$count_posts = wp_count_posts( 'produk' )->publish;

$terms = get_terms( 'produk_cat' );
$count = count( $terms );
//print_r($qobj);
//echo $count;

//print_r($terms);
$lbl = pll__('There are n products available');
$lbl = str_replace('n', $count_posts, $lbl);

 ?>
<div class="panel-product"  name="section-scroll">
	<div class="middle">
		<div class="header-pp clearfix">
			<label class="lbl-available fleft"><?php echo $lbl; ?></label>
			<div class="search-box fright">
				<form role="search" action="<?php echo site_url('/'); ?>" method="get" id="searchform">
					<input type="text" name="search" placeholder="<?php echo pll__('Search');?>">
					<button class="btn-search">
						<img class="" src="<?php echo get_template_directory_uri().'/images/search.png' ?>">  
					</button>
				    <input type="hidden" name="post_type" value="produk" /> <!-- // hidden 'products' value -->
			    </form>
			</div>
		</div>

		<div class="panel-category-product clearfix">
			<select id="all-category" class="all-category hide">
				<option value="<?php echo get_post_type_archive_link( 'produk' ); ?>"><?php echo pll__('Categories'); ?>	</option>
				<?php
				foreach ( $terms as $key => $term ) { ?>
					<option value="<?php echo esc_url( get_term_link( $term ) );?>"><?php echo $term->name; ?>	</option>
				<?php
				} ?>	
			</select>
			<label class="lbl-pcp fleft"><?php echo pll__('Categories');?></label>
			<?php
				if ( $count > 0 ) {
					?>
					<div class="list-category-produk fright">
						<ul>
							<?php 
								foreach ( $terms as $key => $term ) {
									if($key>3) break;
									?>
									<li>
							    		<a class="<?php  if($qobj->slug== $term->slug) echo "current"; ?>" href="<?php echo esc_url( get_term_link( $term ) );?>" alt="<?php echo esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) ; ?>">
							    			<?php echo $term->name; ?>	 	
							    		</a>
								    </li>
							<?php }
							//other category
							if($count > 3){ ?>
								<li>
								<select id="other-category" class="select-category-product" data-placeholder="Your Placeholder" >
									<option value="other"><?php echo pll__('Others'); ?>	</option>
								<?php
								foreach ( $terms as $key => $term ) { ?>
									<option value="<?php echo esc_url( get_term_link( $term ) );?>"><?php echo $term->name; ?>	</option>
								<?php
								}
								?>		
								</select>
								</li>
								<?php 
							}?>

						</ul>
					</div>
					<?php 
				}
			 ?>
		</div>

	</div>
</div>