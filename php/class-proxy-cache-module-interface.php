<?php

namespace Yoast\YoastCom\Theme;

interface Proxy_Cache_Module_Interface {
	/**
	 * @return array
	 */
	public function get_vary_options();

	/**
	 * @return null
	 */
	public function set_headers();
}