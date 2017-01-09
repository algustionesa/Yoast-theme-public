<?php

namespace Yoast\YoastCom\Theme;

class Proxy_Cache_Control {

	/** @var Proxy_Cache_Module_Interface[] Modules */
	protected $modules;

	public function add_module( Proxy_Cache_Module_Interface $module ) {
		$this->modules[] = $module;
	}

	public function set_headers() {
		if ( headers_sent() ) {
			trigger_error( 'Cannot set cache headers, headers already sent.' );

			return;
		}

		$this->set_vary_header();

		$this->set_module_headers();
	}

	public function get_vary_options() {
		$vary_options = array();
		foreach ( $this->modules as $module ) {
			$module_vary  = $module->get_vary_options();
			$vary_options = array_merge( $vary_options, $module_vary );
		}

		return array_unique( $vary_options );
	}

	private function set_vary_header() {
		$vary = $this->get_vary_options();
		if ( ! empty( $vary ) ) {
			header( 'Vary: ' . implode( ', ', $vary ) );
		}
	}

	private function set_module_headers() {
		foreach ( $this->modules as $module ) {
			$module->set_headers();
		}
	}
}
