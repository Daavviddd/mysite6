<?php

class Grocery_Shopping_Customizer_Notify_Section extends WP_Customize_Section {
	
	public $type = 'grocery-shopping-customizer-notify-section';
	
	public $grocery_shopping_recommended_actions = '';
	
	public $recommended_plugins = '';
	
	public $total_actions = '';
	
	public $plugin_text = '';
	
	public $dismiss_button = '';

	
	public function check_active( $slug ) {
		if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
			$needs = is_plugin_active( $slug . '/' . $slug . '.php' ) ? 'deactivate' : 'activate';

			return array(
				'status' => is_plugin_active( $slug . '/' . $slug . '.php' ),
				'needs'  => $needs,
			);
		}

		return array(
			'status' => false,
			'needs'  => 'install',
		);
	}

	
	public function create_action_link( $state, $slug ) {
		switch ( $state ) {
			case 'install':
				return wp_nonce_url(
					add_query_arg(
						array(
							'action' => 'install-plugin',
							'plugin' => $slug,
						),
						network_admin_url( 'update.php' )
					),
					'install-plugin_' . $slug
				);
				break;
			case 'deactivate':
				return add_query_arg(
					array(
						'action'        => 'deactivate',
						'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' ),
					), network_admin_url( 'plugins.php' )
				);
				break;
			case 'activate':
				return add_query_arg(
					array(
						'action'        => 'activate',
						'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
						'plugin_status' => 'all',
						'paged'         => '1',
						'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' ),
					), network_admin_url( 'plugins.php' )
				);
				break;
		}// End switch().
	}

	
	public function call_plugin_api( $slug ) {
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		$call_api = get_transient( 'grocery_shopping_cust_notify_plugin_info_' . $slug );
		if ( false === $call_api ) {
			$call_api = plugins_api(
				'plugin_information', array(
					'slug'   => $slug,
					'fields' => array(
						'downloaded'        => false,
						'rating'            => false,
						'description'       => false,
						'short_description' => true,
						'donate_link'       => false,
						'tags'              => false,
						'sections'          => false,
						'homepage'          => false,
						'added'             => false,
						'last_updated'      => false,
						'compatibility'     => false,
						'tested'            => false,
						'requires'          => false,
						'downloadlink'      => false,
						'icons'             => false,
					),
				)
			);
			set_transient( 'grocery_shopping_cust_notify_plugin_info_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
		}

		return $call_api;
	}

	
	public function json() {
		$json = parent::json();
		global $grocery_shopping_customizer_notify_grocery_shopping_recommended_actions;
		global $grocery_shopping_customizer_notify_recommended_plugins;

		global $grocery_shopping_install_button_label;
		global $grocery_shopping_activate_button_label;
		global $grocery_shopping_deactivate_button_label;

		$formatted_array                               = array();
		$grocery_shopping_customizer_notify_show_grocery_shopping_recommended_actions = get_option( 'grocery_shopping_customizer_notify_show' );
		foreach ( $grocery_shopping_customizer_notify_grocery_shopping_recommended_actions as $key => $grocery_shopping_lite_customizer_notify_recommended_action ) {
			if ( $grocery_shopping_customizer_notify_show_grocery_shopping_recommended_actions[ $grocery_shopping_lite_customizer_notify_recommended_action['id'] ] === false ) {
				continue;
			}
			if ( $grocery_shopping_lite_customizer_notify_recommended_action['check'] ) {
				continue;
			}

			$grocery_shopping_lite_customizer_notify_recommended_action['index'] = $key + 1;

			if ( isset( $grocery_shopping_lite_customizer_notify_recommended_action['plugin_slug'] ) ) {
				$active = $this->check_active( $grocery_shopping_customizer_notify_recommended_action['plugin_slug'] );
				$grocery_shopping_lite_customizer_notify_recommended_action['url'] = $this->create_action_link( $active['needs'], $grocery_shopping_lite_customizer_notify_recommended_action['plugin_slug'] );
				if ( $active['needs'] !== 'install' && $active['status'] ) {
					$grocery_shopping_lite_customizer_notify_recommended_action['class'] = 'active';
				} else {
					$grocery_shopping_lite_customizer_notify_recommended_action['class'] = '';
				}

				switch ( $active['needs'] ) {
					case 'install':
						$grocery_shopping_lite_customizer_notify_recommended_action['button_class'] = 'install-now button';
						$grocery_shopping_lite_customizer_notify_recommended_action['button_label'] = $grocery_shopping_install_button_label;
						break;
					case 'activate':
						$grocery_shopping_lite_customizer_notify_recommended_action['button_class'] = 'activate-now button button-primary';
						$grocery_shopping_lite_customizer_notify_recommended_action['button_label'] = $grocery_shopping_activate_button_label;
						break;
					case 'deactivate':
						$grocery_shopping_lite_customizer_notify_recommended_action['button_class'] = 'deactivate-now button';
						$grocery_shopping_lite_customizer_notify_recommended_action['button_label'] = $grocery_shopping_deactivate_button_label;
						break;
				}
			}
			$formatted_array[] = $grocery_shopping_lite_customizer_notify_recommended_action;
		}// End foreach().

		$customize_plugins = array();

		$grocery_shopping_lite_customizer_notify_show_recommended_plugins = get_option( 'grocery_shopping_customizer_notify_show_recommended_plugins' );

		foreach ( $grocery_shopping_customizer_notify_recommended_plugins as $slug => $plugin_opt ) {

			if ( ! $plugin_opt['recommended'] ) {
				continue;
			}

			if ( isset( $grocery_shopping_lite_customizer_notify_show_recommended_plugins[ $slug ] ) && $grocery_shopping_lite_customizer_notify_show_recommended_plugins[ $slug ] ) {
				continue;
			}

			$active = $this->check_active( $slug );

			if ( ! empty( $active['needs'] ) && ( $active['needs'] == 'deactivate' ) ) {
				continue;
			}

			$ti_customizer_notify_recommended_plugin['url'] = $this->create_action_link( $active['needs'], $slug );
			if ( $active['needs'] !== 'install' && $active['status'] ) {
				$ti_customizer_notify_recommended_plugin['class'] = 'active';
			} else {
				$ti_customizer_notify_recommended_plugin['class'] = '';
			}
			
			switch ( $active['needs'] ) {
				case 'install':
					$ti_customizer_notify_recommended_plugin['button_class'] = 'install-now button';
					$ti_customizer_notify_recommended_plugin['button_label'] = $grocery_shopping_install_button_label;
					break;
				case 'activate':
					$ti_customizer_notify_recommended_plugin['button_class'] = 'activate-now button button-primary';
					$ti_customizer_notify_recommended_plugin['button_label'] = $grocery_shopping_activate_button_label;
					break;
				case 'deactivate':
					$ti_customizer_notify_recommended_plugin['button_class'] = 'deactivate-now button';
					$ti_customizer_notify_recommended_plugin['button_label'] = $grocery_shopping_deactivate_button_label;
					break;
			}
			$info = $this->call_plugin_api( $slug );
			$ti_customizer_notify_recommended_plugin['id']          = $slug;
			$ti_customizer_notify_recommended_plugin['plugin_slug'] = $slug;

			if ( ! empty( $plugin_opt['description'] ) ) {
				$ti_customizer_notify_recommended_plugin['description'] = $plugin_opt['description'];
			} else {
				$ti_customizer_notify_recommended_plugin['description'] = $info->short_description;
			}

			$ti_customizer_notify_recommended_plugin['title'] = $info->name;

			$customize_plugins[] = $ti_customizer_notify_recommended_plugin;

		}// End foreach().

		$json['grocery_shopping_recommended_actions'] = $formatted_array;
		$json['recommended_plugins'] = $customize_plugins;
		$json['total_actions']       = count( $grocery_shopping_customizer_notify_grocery_shopping_recommended_actions );
		$json['plugin_text']         = $this->plugin_text;
		$json['dismiss_button']      = $this->dismiss_button;
		return $json;

	}
	
	protected function render_template() {
	?>
		<# if( data.grocery_shopping_recommended_actions.length > 0 || data.recommended_plugins.length > 0 ){ #>
			<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">

				<h3 class="accordion-section-title">
					<span class="section-title" data-plugin_text="{{ data.plugin_text }}">
						<# if( data.grocery_shopping_recommended_actions.length > 0 ){ #>
							{{ data.title }}
						<# }else{ #>
							<# if( data.recommended_plugins.length > 0 ){ #>
								{{ data.plugin_text }}
							<# }#>
						<# } #>
					</span>
					<# if( data.grocery_shopping_recommended_actions.length > 0 ){ #>
						<span class="grocery-shopping-customizer-plugin-notify-actions-count">
							<span class="current-index">{{ data.grocery_shopping_recommended_actions[0].index }}</span>
							{{ data.total_actions }}
						</span>
					<# } #>
				</h3>
				<div class="grocery-shopping-theme-recomended-actions_container" id="plugin-filter">
					<# if( data.grocery_shopping_recommended_actions.length > 0 ){ #>
						<# for (action in data.grocery_shopping_recommended_actions) { #>
							<div class="grocery-shopping-recommeded-actions-container epsilon-required-actions" data-index="{{ data.grocery_shopping_recommended_actions[action].index }}">
								<# if( !data.grocery_shopping_recommended_actions[action].check ){ #>
									<div class="grocery-shopping-epsilon-recommeded-actions">
										<p class="title">{{ data.grocery_shopping_recommended_actions[action].title }}</p>
										<span data-action="dismiss" class="dashicons dashicons-no grocery-shopping-customizer-notify-dismiss-recommended-action" id="{{ data.grocery_shopping_recommended_actions[action].id }}"></span>
										<div class="description">{{{ data.grocery_shopping_recommended_actions[action].description }}}</div>
										<# if( data.grocery_shopping_recommended_actions[action].plugin_slug ){ #>
											<div class="custom-action">
												<p class="plugin-card-{{ data.grocery_shopping_recommended_actions[action].plugin_slug }} action_button {{ data.grocery_shopping_recommended_actions[action].class }}">
													<a data-slug="{{ data.grocery_shopping_recommended_actions[action].plugin_slug }}" class="{{ data.grocery_shopping_recommended_actions[action].button_class }}" href="{{ data.grocery_shopping_recommended_actions[action].url }}">{{ data.grocery_shopping_recommended_actions[action].button_label }}</a>
												</p>
											</div>
										<# } #>
										<# if( data.grocery_shopping_recommended_actions[action].help ){ #>
											<div class="custom-action">{{{ data.grocery_shopping_recommended_actions[action].help }}}</div>
										<# } #>
									</div>
								<# } #>
							</div>
						<# } #>
					<# } #>

					<# if( data.recommended_plugins.length > 0 ){ #>
						<# for (action in data.recommended_plugins) { #>
							<div class="grocery-shopping-recommeded-actions-container epsilon-recommended-plugins" data-index="{{ data.recommended_plugins[action].index }}">
								<# if( !data.recommended_plugins[action].check ){ #>
									<div class="grocery-shopping-epsilon-recommeded-actions">
										<p class="title">{{ data.recommended_plugins[action].title }}</p>
										<span data-action="dismiss" class="dashicons dashicons-no grocery-shopping-customizer-notify-dismiss-button-recommended-plugin" id="{{ data.recommended_plugins[action].id }}"></span>
										<div class="description">{{{ data.recommended_plugins[action].description }}}</div>
										<# if( data.recommended_plugins[action].plugin_slug ){ #>
											<div class="custom-action">
												<p class="plugin-card-{{ data.recommended_plugins[action].plugin_slug }} action_button {{ data.recommended_plugins[action].class }}">
													<a data-slug="{{ data.recommended_plugins[action].plugin_slug }}" class="{{ data.recommended_plugins[action].button_class }}" href="{{ data.recommended_plugins[action].url }}">{{ data.recommended_plugins[action].button_label }}</a>
												</p>
											</div>
										<# } #>
										<# if( data.recommended_plugins[action].help ){ #>
											<div class="custom-action">{{{ data.recommended_plugins[action].help }}}</div>
										<# } #>
									</div>
								<# } #>
							</div>
						<# } #>
					<# } #>
				</div>
			</li>
		<# } #>
	<?php
	}
}