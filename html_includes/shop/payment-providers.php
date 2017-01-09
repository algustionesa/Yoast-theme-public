<?php

namespace Yoast\YoastCom\Theme;

foreach ( $template_args['providers'] as $arg ) {
	printf("<img src='%s' alt='%s' class='yst-payment-method' />", $arg->icon(), $arg->name());
}
