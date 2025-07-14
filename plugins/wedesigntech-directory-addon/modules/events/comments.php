<?php
if ( post_password_required() ) {
	return;
}?>

<div id="events" class="events-area">
	<?php
	if ( have_events() ) : ?>

	    <h3><?php events_number(esc_html__('No Events','dtdr'), esc_html__('Events ( 1 )','dtdr'), esc_html__('Events  ( % )','dtdr') );?></h3>

		<?php the_events_navigation(); ?>

        <ul class="eventlist">
     		<?php wp_list_events( array( 'avatar_size' => 50, 'callback' => 'dtdr_modify_events_html' ) ); ?>
        </ul>

        <?php the_events_navigation();

    endif;

	if ( ! events_open() && get_events_number() && post_type_supports( get_post_type(), 'events' ) ) : ?>
        <p class="noevents"><?php esc_html_e( 'Events are closed.','dtdr'); ?></p><?php
	endif;


	ob_start();
	event_form();
	$event_form = ob_get_contents();
	$event_form = str_replace('<form ','<form enctype="multipart/form-data" ', $event_form);
	ob_end_clean();

	echo dtdr_html_output($event_form);
	?>
</div>