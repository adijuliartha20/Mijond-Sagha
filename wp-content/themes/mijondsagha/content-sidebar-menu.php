<div class="sidebar-menu fleft">
	<?php 
	$terms = get_terms( 'faq_cat' );
	//print_r($qobj);
	?>
	<ul>
	<?php 
		foreach ( $terms as $key => $term ) {
			//if($key>3) break;
			?>
			<li>
	    		<a class="<?php if($term->slug==$qobj->slug) echo "current"; ?>" href="<?php echo esc_url( get_term_link( $term ) );?>" alt="<?php echo esc_attr( sprintf( __( 'Veiw all post filed under %s', 'my_localization_domain' ), $term->name ) ) ; ?>">
	    			<?php echo $term->name; ?>	 	
	    		</a>
		    </li>
		<?php } ?>	 		    
	</ul>

</div>