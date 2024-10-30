<?php

// Security
if (!defined('ABSPATH')) exit;

if( class_exists( 'WP_Customize_Control' ) ) {


	// ========== GENERAL CONTROLS ==========

	if ( !class_exists( 'mwm_custom_panel' ) ) {
		class mwm_custom_panel extends WP_Customize_Panel {
	
			public $panel;
		
			public $type = 'mwm_custom_panel';
		
			public function json() {
				  $array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'type', 'panel', ) );
				  $array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
				  $array['content'] = $this->get_content();
				  $array['active'] = $this->active();
				  $array['instanceNumber'] = $this->instance_number;
		
				  return $array;
			}
		}
	}

	if ( !class_exists( 'mwm_custom_section' ) ) {
		class mwm_custom_section extends WP_Customize_Section {

			public $section;
		
			public $type = 'mwm_custom_section';
		
			public function json() {
				$array = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section', ) );
				$array['title'] = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
				$array['content'] = $this->get_content();
				$array['active'] = $this->active();
				$array['instanceNumber'] = $this->instance_number;
			
				if ( $this->panel ) {
					$array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
				} else {
					$array['customizeAction'] = 'Customizing';
				}
		
				return $array;
			}
		}
	}


	// ========== CUSTOM CONTROLS ==========

	if ( !class_exists( 'mwm_slider_control' ) ) {
		class mwm_slider_control extends WP_Customize_Control {

			/**
			 * The type of control being rendered
			 */
			public $type = 'slider-control';

			public function __construct( $manager, $id, $args = array() ) {
				parent::__construct( $manager, $id, $args );
				$defaults = array(
					'min' => 0,
					'max' => 100,
					'step' => 1
				);
				$args = wp_parse_args( $args, $defaults );

				$this->min = $args['min'];
				$this->max = $args['max'];
				$this->step = $args['step'];
			}
			
			/**
			 * Render the control in the customizer
			 */
			public function render_content() {
			?>
				<label class="mwm-custom-controls__container">
					<span class="mwm-custom-controls__title"><?php echo esc_html( $this->label ); ?></span>
					<input id="<?php echo $this->id; ?>" class='mwm-custom-controls__range-slider' min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" type='range' <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" oninput="jQuery(this).next('input').val( jQuery(this).val() );">
					<input class="mwm-custom-controls__input-number" min="<?php echo $this->min ?>" max="<?php echo $this->max ?>" step="<?php echo $this->step ?>" onKeyUp="jQuery(this).prev('input').val( jQuery(this).val() ).trigger('change');" onChange="jQuery(this).prev('input').val( jQuery(this).val() ).trigger('change');" type='number' value='<?php echo esc_attr( $this->value() ); ?>'>
				</label>
			<?php
			}
		}
	}

	if ( !class_exists( 'mwm_separator_control' ) ) {
		class mwm_separator_control extends WP_Customize_Control {

			/**
			 * The type of control being rendered
			 */
			public $type = 'separator-control';

			public function __construct( $manager, $id, $args = array() ) {
				parent::__construct( $manager, $id, $args );
				$defaults = array(
					'description' => '',
					'line' => false
				);
				$args = wp_parse_args( $args, $defaults );

				$this->description = $args['description'];
				$this->line = $args['line'];
			}
			
			/**
			 * Render the control in the customizer
			 */
			public function render_content() {
			?>
				<label class="mwm-custom-controls__container">
					<?php if ( $this->label ) : ?>
						<span class="mwm-custom-controls__title mwm-custom-controls__header"><strong><?php echo esc_html( $this->label ); ?></strong></span>
					<?php endif; ?>

					<?php if ( $this->description && $this->label ) : ?>
						<p class="description"><?php echo $this->description; ?></p>
					<?php endif; ?>

					<?php if ( $this->line ) : ?>
						<hr />
					<?php endif; ?>
				</label>
			<?php
			}
		}
	}

	if ( !class_exists( 'mwm_button_control' ) ) {
		class mwm_button_control extends WP_Customize_Control {

			/**
			 * The type of control being rendered
			 */
			public $type = 'button-control';

			public function __construct( $manager, $id, $args = array() ) {
				parent::__construct( $manager, $id, $args );
				$defaults = array(
					'id'	=>	'',
					'class'	=>	'button button-primary',
					'help' 	=> ''
				);
				$args = wp_parse_args( $args, $defaults );

				$this->id = $args['id'];
				$this->class = $args['class'];
				$this->help = $args['help'];
			}
			
			/**
			 * Render the control in the customizer
			 */
			public function render_content() {
			?>
				<label class="mwm-custom-controls__container">
					<button type="button" id="<?php echo $this->id; ?>" class="<?php echo $this->class; ?>"><?php echo $this->label; ?></button>
					<?php if ($this->help) : ?>
						<p class="mwm-custom-controls__help"><?php echo $this->help; ?></p>
					<?php endif; ?>
				</label>
			<?php
			}
		}
	}


	// ========= ASSETS ==========

	// Enqueue scripts
	if ( !function_exists( 'mwm_customize_custom_controls_scripts' ) ) {
		function mwm_customize_custom_controls_scripts() {
			wp_register_script( 'mwm-customize-controls', plugins_url( 'assets/js/customizer-script.js', __FILE__ ), array('jquery'), '1.0.0', true );
			wp_register_script( 'mwm-customize-controls-preview', plugins_url( 'assets/js/preview-script.js', __FILE__ ), array('jquery'), '1.0.0', true );

			wp_enqueue_script( 'mwm-customize-controls' );
			wp_enqueue_script( 'mwm-customize-controls-preview' );
		}
		add_action( 'customize_controls_enqueue_scripts', 'mwm_customize_custom_controls_scripts' );
	}
	
	// Enqueue styles
	if ( !function_exists( 'mwm_customize_custom_controls_styles' ) ) {
		function mwm_customize_custom_controls_styles() {
			wp_register_style( 'mwm-customize-controls', plugins_url( 'assets/css/styles.css', __FILE__ ), array(), '1.0.0' );
			wp_enqueue_style( 'mwm-customize-controls' );
		}
		add_action( 'customize_controls_print_styles', 'mwm_customize_custom_controls_styles' );
	}
}