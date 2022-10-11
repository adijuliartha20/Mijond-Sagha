<div class="search-box">
	<form role="search" action="<?php echo site_url('/search'); ?>" method="get" id="searchform">
		<input type="text" name="keyword" placeholder="<?php echo pll__('Search Blog');?>">
		<button class="btn-search">
			<img class="" src="<?php echo get_template_directory_uri().'/images/search.png' ?>">  
		</button>
	    <input type="hidden" name="post_type" value="blog" /> <!-- // hidden 'products' value -->
    </form>
</div>