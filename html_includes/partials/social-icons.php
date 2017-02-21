<?php

namespace Yoast\YoastCom\Theme;

$social_profiles = [
	[
		'title'      => __( 'Twitter', 'yoastcom' ),
		'icon'       => '&#xf081;',
		'identifier' => 'twitter',
	],
	[
		'title'      => __( 'Linkedin', 'yoastcom' ),
		'icon'       => '&#xf08c;',
		'identifier' => 'linkedin',
	],
	[
		'title'      => __( 'Facebook', 'yoastcom' ),
		'icon'       => '&#xf082;',
		'identifier' => 'facebook',
	],
	[
		'title'      => __( 'Instagram', 'yoastcom' ),
		'icon'       => '&#xf16d;',
		'identifier' => 'instagram',
	]
];

array_map( function ( $social_profile ) {

	if ( author_has( $social_profile['identifier'] ) ) {

		printf( '<a href="%1$s" class="link--implicit"><span class="visuallyhidden focusable">%2$s</span><span class="text-icon text-icon--%3$s text-icon--social">%4$s</span></a>',
			esc_url( url_social_site( $social_profile['identifier'] ) ),
			$social_profile['title'],
			$social_profile['identifier'],
			$social_profile['icon']
		);
	}

}, $social_profiles );
