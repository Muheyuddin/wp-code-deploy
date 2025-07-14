<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, netlink_single_post_params() ); ?>

    <?php netlink_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-meta">

    	<!-- Meta Left -->
    	<div class="meta-left">
			 <?php netlink_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
    	</div><!-- Meta Left -->
    	<!-- Meta Right -->
    	<div class="meta-right">
			<?php netlink_template_part( 'post', 'templates/'.$Post_Style.'/parts/author', '', $template_args ); ?>
    	</div><!-- Meta Right -->

    </div><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'netlink_single_post_dynamic_template_part', netlink_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->