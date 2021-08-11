<?php

/**
 * About Sbi admin page class.
 *
 * @since 2.4/5.5
 */
class SB_Instagram_About {

	/**
	 * Admin menu page slug.
	 *
	 * @since 2.4/5.5
	 *
	 * @var string
	 */
	const SLUG = 'sb-instagram-feed-about';

	/**
	 * Default view for a page.
	 *
	 * @since 2.4/5.5
	 *
	 * @var string
	 */
	const DEFAULT_TAB = 'about';

	/**
	 * Array of license types, that are considered being top level and has no features difference.
	 *
	 * @since 2.4/5.5
	 *
	 * @var array
	 */
	public static $licenses_top = array( 'pro', 'agency', 'ultimate', 'elite' );

	/**
	 * List of features that licenses are different with.
	 *
	 * @since 2.4/5.5
	 *
	 * @var array
	 */
	public static $licenses_features = array();

	/**
	 * The current active tab.
	 *
	 * @since 2.4/5.5
	 *
	 * @var string
	 */
	public $view;

	/**
	 * The core views.
	 *
	 * @since 2.4/5.5
	 *
	 * @var array
	 */
	public $views = array();

	/**
	 * Primary class constructor.
	 *
	 * @since 2.4/5.5
	 */
	public function __construct() {

		// In old PHP we can't define this elsewhere.
		self::$licenses_features = array(
			'entries'      => esc_html__( 'Feed Types', 'instagram-feed' ),
			'fields'       => esc_html__( 'Layouts', 'instagram-feed' ),
			'templates'    => esc_html__( 'Post Information', 'instagram-feed' ),
			'conditionals' => esc_html__( 'Image and Video Display', 'instagram-feed' ),
			'addons' => esc_html__( 'Filtering', 'instagram-feed' ),
			//'marketing'    => esc_html__( 'Filtering', 'instagram-feed' ),
			'marketing'     => esc_html__( 'Instagram Stories', 'instagram-feed' ),
			'payments'      => esc_html__( 'Feed Moderation', 'instagram-feed' ),
			'surveys'     => esc_html__( 'Header Display', 'instagram-feed' ),
			'advanced'       => esc_html__( 'Post Linking', 'instagram-feed' ),
			'support'      => esc_html__( 'Customer Support', 'instagram-feed' ),
		);

		// Maybe load tools page.
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
	 * Determining if the user is viewing the our page, if so, party on.
	 *
	 * @since 2.4/5.5
	 */
	public function init() {

		// Check what page we are on.
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';

		// Only load if we are actually on the settings page.
		if ( self::SLUG !== $page ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueues' ) );

		/*
		 * Define the core views for the our tab.
		 */
		$this->views = apply_filters(
			'sbi_admin_about_views',
			array(
				esc_html__( 'About Us', 'instagram-feed' )        => array( 'about' ),
				esc_html__( 'Getting Started', 'instagram-feed' ) => array( 'getting-started' ),
			)
		);

		$license = $this->get_license_type();

		if (
			(
				$license === 'pro' ||
				! in_array( $license, self::$licenses_top, true )
			)
			//sbi_debug()
		) {
			$vs_tab_name = sprintf( /* translators: %1$s - current license type, %2$s - suggested license type. */
				esc_html__( '%1$s vs %2$s', 'instagram-feed' ),
				ucfirst( $license ),
				$this->get_next_license( $license )
			);

			$this->views[ $vs_tab_name ] = array( 'versus' );
		}

		// Determine the current active settings tab.
		$this->view = ! empty( $_GET['view'] ) ? esc_html( $_GET['view'] ) : self::DEFAULT_TAB;

		// If the user tries to load an invalid view - fallback to About Us.
		if (
			! in_array( $this->view, call_user_func_array( 'array_merge', array_values( $this->views ) ), true ) &&
			! has_action( 'sbi_admin_about_display_tab_' . sanitize_key( $this->view ) )
		) {
			$this->view = self::DEFAULT_TAB;
		}

		add_action( 'sbi_admin_page', array( $this, 'output' ) );

		// Hook for addons.
		do_action( 'sbi_admin_about_init' );
	}

	/**
	 * Enqueue assets for the the page.
	 *
	 * @since 2.4/5.5
	 */
	public function enqueues() {

		wp_enqueue_script(
			'jquery-matchheight',
			SBI_PLUGIN_URL . 'js/jquery.matchHeight-min.js',
			array( 'jquery' ),
			'0.7.0',
			false
		);
	}

	/**
	 * Output the basic page structure.
	 *
	 * @since 2.4/5.5
	 */
	public function output() {

		$show_nav = false;
		foreach ( $this->views as $view ) {
			if ( in_array( $this->view, (array) $view, true ) ) {
				$show_nav = true;
				break;
			}
		}
		?>

		<div id="sbi-admin-about" class="wrap sbi-admin-wrap">

			<?php
			if ( $show_nav ) {
				$license      = $this->get_license_type();
				$next_license = $this->get_next_license( $license );
				echo '<ul class="sbi-admin-tabs">';
				foreach ( $this->views as $label => $view ) {
					$class = in_array( $this->view, $view, true ) ? 'active' : '';
					echo '<li>';
					printf(
						'<a href="%s" class="%s">%s</a>',
						esc_url( admin_url( 'admin.php?page=' . self::SLUG . '&view=' . sanitize_key( $view[0] ) ) ),
						esc_attr( $class ),
						esc_html( $label )
					);
					echo '</li>';
				}
				echo '</ul>';
			}
			?>

			<h1 class="sbi-h1-placeholder"></h1>

			<?php
			switch ( $this->view ) {
				case 'about':
					$this->output_about();
					break;
				case 'getting-started':
					$this->output_getting_started();
					break;
				case 'versus':
					$this->output_versus();
					break;
				default:
					do_action( 'sbi_admin_about_display_tab_' . sanitize_key( $this->view ) );
					break;
			}
			?>

		</div>

		<?php
	}

	/**
	 * Display the About tab content.
	 *
	 * @since 2.4/5.5
	 */
	protected function output_about() {

		$this->output_about_info();
		$this->output_about_addons();
	}

	/**
	 * Display the General Info section of About tab.
	 *
	 * @since 1.5.8
	 */
	protected function output_about_info() {

		?>

		<div class="sbi-admin-about-section sbi-admin-columns">

			<div class="sbi-admin-about-text" style="min-height: 340px;">
				<h3>
					<?php esc_html_e( 'Hello and welcome to the Instagram Feed plugin, the most beautiful, clean, and reliable Instagram feed plugin in the world. At Smash Balloon, we build software that helps you create beautiful responsive social media feeds for your website in minutes.', 'instagram-feed' ); ?>
				</h3>

				<p>
					<?php esc_html_e( 'Smash Balloon is a fun-loving WordPress plugin development company birthed into existence in early 2013. We specialize in creating plugins that are not only intuitive and simple to use, but also designed to integrate seamlessly into your website and allow you to display your social media content in powerful and unique ways. Over 1 million awesome people have decided to actively use our plugins, which is an incredible honor that we don’t take lightly. This compels us to try to provide the quickest and most effective customer support that we can, blowing users away with the best customer service they’ve ever experienced.', 'instagram-feed' ); ?>
				</p>
				<p>
					<?php esc_html_e( 'We’re a small, but dedicated, team based in Minnesota in the USA.', 'instagram-feed' ); ?>
				</p>
				<!-- <p>
					<?php
					printf(
						wp_kses(
						/* translators: %1$s - WPBeginner URL, %2$s - OptinMonster URL, %3$s - MonsterInsights URL, %4$s - RafflePress URL. */
							__( 'Instagram Feed is brought to you by the same team that’s behind the largest WordPress resource site, <a href="%1$s" target="_blank" rel="noopener noreferrer">WPBeginner</a>, the most popular lead-generation software, <a href="%2$s" target="_blank" rel="noopener noreferrer">OptinMonster</a>, the best WordPress analytics plugin, <a href="%3$s" target="_blank" rel="noopener noreferrer">MonsterInsights</a>, and the most powerful WordPress contest plugin, <a href="%4$s" target="_blank" rel="noopener noreferrer">RafflePress</a>.', 'instagram-feed' ),
							array(
								'a' => array(
									'href'   => array(),
									'rel'    => array(),
									'target' => array(),
								),
							)
						),
						'https://www.wpbeginner.com/?utm_source=sbiplugin&utm_medium=pluginaboutpage&utm_campaign=aboutsbi',
						'https://optinmonster.com/?utm_source=sbiplugin&utm_medium=pluginaboutpage&utm_campaign=aboutsbi',
						'https://www.monsterinsights.com/?utm_source=sbiplugin&utm_medium=pluginaboutpage&utm_campaign=aboutsbi',
						'https://rafflepress.com/?utm_source=sbiplugin&utm_medium=pluginaboutpage&utm_campaign=aboutsbi'
					);
					?>
				</p>
				<p>
					<?php esc_html_e( 'Yup, we know a thing or two about building awesome products that customers love.', 'instagram-feed' ); ?>
				</p> -->
			</div>

			<div class="sbi-admin-about-image sbi-admin-column-last">
				<figure>
					<img src="<?php echo SBI_PLUGIN_URL; ?>img/about/team.jpg" alt="<?php esc_attr_e( 'The Sbi Team photo', 'instagram-feed' ); ?>">
					<figcaption>
						<?php esc_html_e( 'The Smash Balloon Team', 'instagram-feed' ); ?><br>
					</figcaption>
				</figure>
			</div>

		</div>
		<?php
	}

	/**
	 * Display the Addons section of About tab.
	 *
	 * @since 1.5.8
	 */
	protected function output_about_addons() {

		if ( ! current_user_can( 'manage_instagram_feed_options' ) || 	version_compare( PHP_VERSION,  '5.3.0' ) <= 0
		    || version_compare( PHP_VERSION,  '5.3.0' ) <= 0
		    || version_compare( get_bloginfo('version'), '4.6' , '<' ) ){
			return;
		}

		$all_plugins = get_plugins();
		$am_plugins  = $this->get_am_plugins();

		?>
		<div id="sbi-admin-addons">
			<div class="addons-container">
                <h3><?php echo __( 'Our Other Plugins', 'instagram-feed' ); ?></h3>
				<?php
				foreach ( $am_plugins as $plugin => $details ) :

					$plugin_data = $this->get_plugin_data( $plugin, $details, $all_plugins );

					if ( $plugin === 'wpforms-lite/wpforms.php' ) {
					    echo '<h3>' .__( 'Plugins We Recommend', 'instagram-feed' ). '</h3>';
	                }

					?>
					<div class="addon-container">
						<div class="addon-item">
							<div class="details sbi-clear">
								<img src="<?php echo esc_url( $plugin_data['details']['icon'] ); ?>">
								<h5 class="addon-name">
									<?php echo esc_html( $plugin_data['details']['name'] ); ?>
								</h5>
								<p class="addon-desc">
									<?php echo wp_kses_post( $plugin_data['details']['desc'] ); ?>
								</p>
							</div>
							<div class="actions sbi-clear">
								<div class="status">
									<strong>
										<?php
										printf(
										/* translators: %s - addon status label. */
											esc_html__( 'Status: %s', 'instagram-feed' ),
											'<span class="status-label ' . esc_attr( $plugin_data['status_class'] ) . '">' . wp_kses_post( $plugin_data['status_text'] ) . '</span>'
										);
										?>
									</strong>
								</div>
								<div class="action-button">
									<button class="<?php echo esc_attr( $plugin_data['action_class'] ); ?>" data-plugin="<?php echo esc_attr( $plugin_data['plugin_src'] ); ?>" data-type="plugin">
										<?php echo wp_kses_post( $plugin_data['action_text'] ); ?>
									</button>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Get AM plugin data to display in the Addons section of About tab.
	 *
	 * @since 1.5.8
	 *
	 * @param string $plugin      Plugin slug.
	 * @param array  $details     Plugin details.
	 * @param array  $all_plugins List of all plugins.
	 *
	 * @return array
	 */
	protected function get_plugin_data( $plugin, $details, $all_plugins ) {

		$have_pro = ( ! empty( $details['pro'] ) && ! empty( $details['pro']['plug'] ) );
		$show_pro = false;

		$plugin_data = array();

		if ( $have_pro ) {
			if ( array_key_exists( $plugin, $all_plugins ) ) {
				if ( is_plugin_active( $plugin ) ) {
					$show_pro = true;
				}
			}
			if ( array_key_exists( $details['pro']['plug'], $all_plugins ) ) {
				$show_pro = true;
			}
			if ( $show_pro ) {
				$plugin  = $details['pro']['plug'];
				$details = $details['pro'];
			}
		}

		if ( array_key_exists( $plugin, $all_plugins ) ) {
			if ( is_plugin_active( $plugin ) ) {
				// Status text/status.
				$plugin_data['status_class'] = 'status-active';
				$plugin_data['status_text']  = esc_html__( 'Active', 'instagram-feed' );
				// Button text/status.
				$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary disabled';
				$plugin_data['action_text']  = esc_html__( 'Activated', 'instagram-feed' );
				$plugin_data['plugin_src']   = esc_attr( $plugin );
			} else {
				// Status text/status.
				$plugin_data['status_class'] = 'status-inactive';
				$plugin_data['status_text']  = esc_html__( 'Inactive', 'instagram-feed' );
				// Button text/status.
				$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary';
				$plugin_data['action_text']  = esc_html__( 'Activate', 'instagram-feed' );
				$plugin_data['plugin_src']   = esc_attr( $plugin );
			}
		} else {
			// Doesn't exist, install.
			// Status text/status.
			$plugin_data['status_class'] = 'status-download';
			if ( isset( $details['act'] ) && 'go-to-url' === $details['act'] ) {
				$plugin_data['status_class'] = 'status-go-to-url';
			}
			$plugin_data['status_text'] = esc_html__( 'Not Installed', 'instagram-feed' );
			// Button text/status.
			$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-primary';
			$plugin_data['action_text']  = esc_html__( 'Install Plugin', 'instagram-feed' );
			$plugin_data['plugin_src']   = esc_url( $details['url'] );
		}

		$plugin_data['details'] = $details;

		return $plugin_data;
	}

	/**
	 * Display the Getting Started tab content.
	 *
	 * @since 2.4/5.5
	 */
	protected function output_getting_started() {

		$license = $this->get_license_type();
		?>

		<div class="sbi-admin-about-section sbi-admin-about-section-first-form" style="display:flex;">

			<div class="sbi-admin-about-section-first-form-text">

				<h2>
					<?php esc_html_e( 'Creating Your First Feed', 'instagram-feed' ); ?>
				</h2>

				<p>
					<?php esc_html_e( 'Want to get started creating your first feed with Instagram Feed? By following the step by step instructions in this walkthrough, you can easily publish your first feed on your site.', 'instagram-feed' ); ?>
				</p>

				<p>
					<?php esc_html_e( 'Navigate to Instagram Feed in the admin sidebar to go the Configure page.', 'instagram-feed' ); ?>
				</p>

				<p>
					<?php esc_html_e( 'Click on the large blue button to connect your Instagram account. Select "Personal" if your Instagram account is a personal account, "Business" if it is a business or creator account.', 'instagram-feed' ); ?>
				</p>

                <p>
					<?php esc_html_e( 'Once you connect an Instagram account, you can display your feed on any post, page or widget using the shortcode [instagram-feed]. You can also use the Instagram Feed Gutenberg block if your site has the WordPress block editor enabled.', 'instagram-feed' ); ?>
                </p>

				<ul class="list-plain">
					<li>
						<a href="https://smashballoon.com/display-multiple-instagram-feeds/?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=multiplefeeds" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'How to Display Multiple Feeds', 'instagram-feed' ); ?>
						</a>
					</li>
					<li>
						<a href="https://smashballoon.com/get-access-token-from-another-account/?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=differentaccounts" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Connect a Different Account', 'instagram-feed' ); ?>
						</a>
					</li>
					<li>
						<a href="https://smashballoon.com/differences-between-an-instagram-personal-and-business-account/?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=personalvbusiness" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Personal Vs Business Accounts', 'instagram-feed' ); ?>
						</a>
					</li>
				</ul>

			</div>

			<div class="sbi-admin-about-section-first-form-video">
				<iframe src="https://www.youtube-nocookie.com/embed/q6ZXVU4g970?rel=0" width="540" height="304" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>

		</div>

		<?php if ( ! in_array( $license, self::$licenses_top, true ) ) { ?>
			<div class="sbi-admin-about-section sbi-admin-about-section-hero">

				<div class="sbi-admin-about-section-hero-main">
					<h2>
						<?php esc_html_e( 'Get Instagram Feed Pro and Unlock all the Powerful Features', 'instagram-feed' ); ?>
					</h2>

					<p class="bigger">
						<?php
						echo wp_kses(
							__( 'Thanks for being a loyal Instagram Feed Lite user. <strong>Upgrade to Instagram Feed Pro</strong> to unlock all the awesome features and experience<br>why Instagram Feed is the most popular Instagram plugin.', 'instagram-feed' ),
							array(
								'br'     => array(),
								'strong' => array(),
							)
						);
						?>
					</p>

					<p>
						<?php
						printf(
							wp_kses(
							/* translators: %s - stars. */
								__( 'We know that you will truly love Instagram Feed. It has over <strong>2500+ five star ratings</strong> (%s) and is active on over 1 million websites.', 'instagram-feed' ),
								array(
									'strong' => array(),
								)
							),
							'<i class="fa fa-star" aria-hidden="true"></i>' .
							'<i class="fa fa-star" aria-hidden="true"></i>' .
							'<i class="fa fa-star" aria-hidden="true"></i>' .
							'<i class="fa fa-star" aria-hidden="true"></i>' .
							'<i class="fa fa-star" aria-hidden="true"></i>'
						);
						?>
					</p>
				</div>

				<div class="sbi-admin-about-section-hero-extra">
					<div class="sbi-admin-columns">
						<div class="sbi-admin-column-50">
							<ul class="list-features list-plain">
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Recent hashtag, top Hashtag, and tagged feeds.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'More layouts - masonry, highlight, and carousel.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Captions, comments, dates, likes, and comment counts.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Pop-up lightbox to view images and watch videos.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Filter feeds by word or hashtag.', 'instagram-feed' ); ?>
								</li>
							</ul>
						</div>
						<div class="sbi-admin-column-50 sbi-admin-column-last">
							<ul class="list-features list-plain">
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Display Instagram stories.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Powerful visual moderation system.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'More customization for feed headers.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( 'Even more customization options for your feed.', 'instagram-feed' ); ?>
								</li>
								<li>
									<i class="fa fa-check" aria-hidden="true"></i>
									<?php esc_html_e( '"Shoppable" feeds.', 'instagram-feed' ); ?>
								</li>
							</ul>
						</div>
					</div>

					<hr />

					<h3 class="call-to-action">
						<?php
						if ( 'lite' === $license ) {
							echo '<a href="https://smashballoon.com/instagram-feed/pricing?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=profeaturescompare" target="_blank" rel="noopener noreferrer">';
						} else {
							echo '<a href="https://smashballoon.com/instagram-feed/pricing?utm_campaign=instagram-pro&utm_source=gettingstarted&utm_medium=profeaturescompare" target="_blank" rel="noopener noreferrer">';
						}
						esc_html_e( 'Get Instagram Feed Pro Today and Unlock all the Powerful Features', 'instagram-feed' );
						?>
						</a>
					</h3>

					<?php if ( 'lite' === $license ) { ?>
						<p>
							<?php
							echo wp_kses(
								__( 'Bonus: Instagram Feed Lite users get <span class="price-20-off">50% off regular price</span>, automatically applied at checkout.', 'instagram-feed' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							);
							?>
						</p>
					<?php } ?>
				</div>

			</div>
		<?php } ?>


        <div class="sbi-admin-about-section sbi-admin-about-section-squashed sbi-admin-about-section-post sbi-admin-columns">
            <div class="sbi-admin-column-20">
                <img src="<?php echo SBI_PLUGIN_URL; ?>img/about/steps.png" alt="">
            </div>
            <div class="sbi-admin-column-80">
                <h2>
					<?php esc_html_e( 'Detailed Step-By-Step Guide', 'instagram-feed' ); ?>
                </h2>

                <p>
					<?php esc_html_e( 'View detailed steps with related images on our website. We have a comprehensive guide to getting up and running with Instagram Feed.', 'instagram-feed' ); ?>
                </p>

                <a href="https://smashballoon.com/instagram-feed/free/?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=readsetup" target="_blank" rel="noopener noreferrer" class="sbi-admin-about-section-post-link">
					<?php esc_html_e( 'Read Documentation', 'instagram-feed' ); ?><i class="fa fa-external-link" aria-hidden="true"></i>
                </a>
            </div>
        </div>

		<div class="sbi-admin-about-section sbi-admin-about-section-squashed sbi-admin-about-section-post sbi-admin-columns">
			<div class="sbi-admin-column-20">
				<img src="<?php echo SBI_PLUGIN_URL; ?>img/about/api-error.png" alt="">
			</div>
			<div class="sbi-admin-column-80">
				<h2>
					<?php esc_html_e( 'Troubleshoot Connection and API Errors', 'instagram-feed' ); ?>
				</h2>

				<p>
					<?php esc_html_e( 'Are you having trouble displaying your feed due to an error connecting an account or an Instagram API error? We have several articles to help you troubleshoot issues and help you solve them.', 'instagram-feed' ); ?>
				</p>

				<a href="https://smashballoon.com/instagram-feed/docs/errors/?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=readerrordoc" target="_blank" rel="noopener noreferrer" class="sbi-admin-about-section-post-link">
					<?php esc_html_e( 'Read Documentation', 'instagram-feed' ); ?><i class="fa fa-external-link" aria-hidden="true"></i>
				</a>
			</div>
		</div>

		<?php
	}

	/**
	 * Get the next license type. Helper for Versus tab content.
	 *
	 * @since 1.5.5
	 *
	 * @param string $current Current license type slug.
	 *
	 * @return string Next license type slug.
	 */
	protected function get_next_license( $current ) {

		$current       = ucfirst( $current );
		$license_pairs = array(
			'Lite'  => 'Pro',
			'Basic' => 'Pro',
			'Plus'  => 'Pro',
			'Pro'   => 'Elite',
		);

		return ! empty( $license_pairs[ $current ] ) ? $license_pairs[ $current ] : 'Elite';
	}

	/**
	 * Display the Versus tab content.
	 *
	 * @since 2.4/5.5
	 */
	protected function output_versus() {

		//$license      = $this->get_license_type();
		//$next_license = $this->get_next_license( $license );
		$license      = 'lite';
		$next_license = 'pro';
		?>

		<div class="sbi-admin-about-section sbi-admin-about-section-squashed">
			<h1 class="centered">
				<strong><?php echo esc_html( ucfirst( $license ) ); ?></strong> vs <strong><?php echo esc_html( ucfirst( $next_license ) ); ?></strong>
			</h1>

			<p class="centered">
				<?php esc_html_e( 'Get the most out of your Instagram Feeds by upgrading to Pro and unlocking all of the powerful features.', 'instagram-feed' ); ?>
			</p>
		</div>

		<div class="sbi-admin-about-section sbi-admin-about-section-squashed sbi-admin-about-section-hero sbi-admin-about-section-table">

			<div class="sbi-admin-about-section-hero-main sbi-admin-columns">
				<div class="sbi-admin-column-33">
					<h3 class="no-margin">
						<?php esc_html_e( 'Feature', 'instagram-feed' ); ?>
					</h3>
				</div>
				<div class="sbi-admin-column-33">
					<h3 class="no-margin">
						<?php echo esc_html( ucfirst( $license ) ); ?>
					</h3>
				</div>
				<div class="sbi-admin-column-33">
					<h3 class="no-margin">
						<?php echo esc_html( ucfirst( $next_license ) ); ?>
					</h3>
				</div>
			</div>
			<div class="sbi-admin-about-section-hero-extra no-padding sbi-admin-columns">

				<table>
					<?php
					foreach ( self::$licenses_features as $slug => $name ) {
						$current = $this->get_license_data( $slug, $license );
						$next    = $this->get_license_data( $slug, strtolower( $next_license ) );

						if ( empty( $current ) || empty( $next ) ) {
							continue;
						}
						?>
						<tr class="sbi-admin-columns">
							<td class="sbi-admin-column-33">
								<p><?php echo esc_html( $name ); ?></p>
							</td>
							<td class="sbi-admin-column-33">
								<?php if ( is_array( $current ) ) : ?>
									<p class="features-<?php echo esc_attr( $current['status'] ); ?>">
										<?php echo wp_kses_post( implode( '<br>', $current['text'] ) ); ?>
									</p>
								<?php endif; ?>
							</td>
							<td class="sbi-admin-column-33">
								<?php if ( is_array( $current ) ) : ?>
									<p class="features-full">
										<?php echo wp_kses_post( implode( '<br>', $next['text'] ) ); ?>
									</p>
								<?php endif; ?>
							</td>
						</tr>
						<?php
					}
					?>
				</table>

			</div>

		</div>

		<div class="sbi-admin-about-section sbi-admin-about-section-hero">
			<div class="sbi-admin-about-section-hero-main no-border">
				<h3 class="call-to-action centered">
					<?php
					if ( 'lite' === $license ) {
						echo '<a href="https://smashballoon.com/instagram-feed/pricing?utm_campaign=instagram-free&utm_source=gettingstarted&utm_medium=profeaturescompare" target="_blank" rel="noopener noreferrer">';
					} else {
						echo '<a href="https://smashballoon.com/instagram-feed/pricing?utm_campaign=instagram-pro&utm_source=gettingstarted&utm_medium=profeaturescompare" target="_blank" rel="noopener noreferrer">';
					}
					printf( /* translators: %s - next license level. */
						esc_html__( 'Get Instagram Feed Pro Today and Unlock all the Powerful Features', 'instagram-feed' ),
						esc_html( $next_license )
					);
					?>
					</a>
				</h3>

				<?php if ( 'lite' === $license ) { ?>
                    <p class="centered">
						<?php
						echo wp_kses(
							__( 'Bonus: Instagram Feed Lite users get <span class="price-20-off">50% off regular price</span>, automatically applied at checkout.', 'instagram-feed' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						);
						?>
                    </p>
				<?php } ?>
			</div>
		</div>

		<?php
	}

	/**
	 * List of AM plugins that we propose to install.
	 *
	 * @since 2.4/5.5
	 *
	 * @return array
	 */
	protected function get_am_plugins() {

		$images_url = SBI_PLUGIN_URL . 'img/about/';

		return array(
			'custom-facebook-feed/custom-facebook-feed.php' => array(
				'icon' => $images_url . 'plugin-fb.png',
				'name' => esc_html__( 'Custom Facebook Feed', 'instagram-feed' ),
				'desc' => esc_html__( 'Custom Facebook Feed makes displaying your Facebook posts easy. Keep your site visitors informed and increase engagement with your Facebook page by displaying a feed on your website.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/custom-facebook-feed.zip',
				'pro'  => array(
					'plug' => 'custom-facebook-feed-pro/custom-facebook-feed.php',
					'icon' => $images_url . 'plugin-fb.png',
					'name' => esc_html__( 'Custom Facebook Feed Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'Custom Facebook Feed makes displaying your Facebook posts easy. Keep your site visitors informed and increase engagement with your Facebook page by displaying a feed on your website.', 'instagram-feed' ),
					'url'  => 'https://smashballoon.com/custom-facebook-feed/?utm_campaign=instagram-free&utm_source=cross&utm_medium=cffinstaller',
					'act'  => 'go-to-url',
				),
			),

			'custom-twitter-feeds/custom-twitter-feed.php' => array(
				'icon' => $images_url . 'plugin-tw.jpg',
				'name' => esc_html__( 'Custom Twitter Feeds', 'instagram-feed' ),
				'desc' => esc_html__( 'Custom Twitter Feeds is a highly customizable way to display tweets from your Twitter account. Promote your latest content and update your site content automatically.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/custom-twitter-feeds.zip',
				'pro'  => array(
					'plug' => 'custom-twitter-feeds-pro/custom-twitter-feed.php',
					'icon' => $images_url . 'plugin-tw.jpg',
					'name' => esc_html__( 'Custom Twitter Feeds Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'Custom Twitter Feeds is a highly customizable way to display tweets from your Twitter account. Promote your latest content and update your site content automatically.', 'instagram-feed' ),
					'url'  => 'https://smashballoon.com/custom-twitter-feeds/?utm_campaign=instagram-free&utm_source=cross&utm_medium=ctfinstaller',
					'act'  => 'go-to-url',
				),
			),

			'feeds-for-youtube/youtube-feed.php' => array(
				'icon' => $images_url . 'plugin-yt.png',
				'name' => esc_html__( 'Feeds for YouTube', 'instagram-feed' ),
				'desc' => esc_html__( 'Feeds for YouTube is a simple yet powerful way to display videos from YouTube on your website. Increase engagement with your channel while keeping visitors on your website.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/feeds-for-youtube.zip',
				'pro'  => array(
					'plug' => 'youtube-feed-pro/youtube-feed.php',
					'icon' => $images_url . 'plugin-yt.png',
					'name' => esc_html__( 'Feeds for YouTube Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'Feeds for YouTube is a simple yet powerful way to display videos from YouTube on your website. Increase engagement with your channel while keeping visitors on your website.', 'instagram-feed' ),
					'url'  => 'https://smashballoon.com/youtube-feed/?utm_campaign=instagram-free&utm_source=cross&utm_medium=sbyinstaller',
					'act'  => 'go-to-url',
				),
			),

            'wpforms-lite/wpforms.php' => array(
                'icon' => $images_url . 'plugin-wpforms.png',
                'name' => esc_html__( 'WPForms', 'instagram-feed' ),
                'desc' => esc_html__( 'The most beginner friendly drag & drop WordPress forms plugin allowing you to create beautiful contact forms, subscription forms, payment forms, and more in minutes, not hours!', 'instagram-feed' ),
                'url'  => 'https://downloads.wordpress.org/plugin/wpforms-lite.zip',
                'pro'  => array(
	                'plug' => 'wpforms/wpforms.php',
                    'icon' => $images_url . 'plugin-wpforms.png',
                    'name' => esc_html__( 'WPForms', 'instagram-feed' ),
                    'desc' => esc_html__( 'The most beginner friendly drag & drop WordPress forms plugin allowing you to create beautiful contact forms, subscription forms, payment forms, and more in minutes, not hours!', 'instagram-feed' ),
	                'url'  => 'https://wpforms.com/lite-upgrade/?utm_source=WordPress&utm_campaign=liteplugin&utm_medium=sbi-about-page',
                    'act'  => 'go-to-url',
                ),
            ),

			'google-analytics-for-wordpress/googleanalytics.php' => array(
				'icon' => $images_url . 'plugin-mi.png',
				'name' => esc_html__( 'MonsterInsights', 'instagram-feed' ),
				'desc' => esc_html__( 'MonsterInsights makes it “effortless” to properly connect your WordPress site with Google Analytics, so you can start making data-driven decisions to grow your business.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/google-analytics-for-wordpress.zip',
				'pro'  => array(
					'plug' => 'google-analytics-premium/googleanalytics-premium.php',
					'icon' => $images_url . 'plugin-mi.png',
					'name' => esc_html__( 'MonsterInsights Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'MonsterInsights makes it “effortless” to properly connect your WordPress site with Google Analytics, so you can start making data-driven decisions to grow your business.', 'instagram-feed' ),
					'url'  => 'https://www.monsterinsights.com/?utm_source=proplugin&utm_medium=about-page&utm_campaign=pluginurl&utm_content=7%2E0%2E0',
					'act'  => 'go-to-url',
				),
			),

			'optinmonster/optin-monster-wp-api.php' => array(
				'icon' => $images_url . 'plugin-om.png',
				'name' => esc_html__( 'OptinMonster', 'instagram-feed' ),
				'desc' => esc_html__( 'Our high-converting optin forms like Exit-Intent® popups, Fullscreen Welcome Mats, and Scroll boxes help you dramatically boost conversions and get more email subscribers.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/optinmonster.zip',
			),

			'wp-mail-smtp/wp_mail_smtp.php'         => array(
				'icon' => $images_url . 'plugin-smtp.png',
				'name' => esc_html__( 'WP Mail SMTP', 'instagram-feed' ),
				'desc' => esc_html__( 'Make sure your website\'s emails reach the inbox. Our goal is to make email deliverability easy and reliable. Trusted by over 1 million websites.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/wp-mail-smtp.zip',
				'pro'  => array(
					'plug' => 'wp-mail-smtp-pro/wp_mail_smtp.php',
					'icon' => $images_url . 'plugin-smtp.png',
					'name' => esc_html__( 'WP Mail SMTP Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'Make sure your website\'s emails reach the inbox. Our goal is to make email deliverability easy and reliable. Trusted by over 1 million websites.', 'instagram-feed' ),
					'url'  => 'https://wpmailsmtp.com/pricing/',
					'act'  => 'go-to-url',
				),
			),

			'rafflepress/rafflepress.php'           => array(
				'icon' => $images_url . 'plugin-rp.png',
				'name' => esc_html__( 'RafflePress', 'instagram-feed' ),
				'desc' => esc_html__( 'Turn your visitors into brand ambassadors! Easily grow your email list, website traffic, and social media followers with powerful viral giveaways & contests.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/rafflepress.zip',
				'pro'  => array(
					'plug' => 'rafflepress-pro/rafflepress-pro.php',
					'icon' => $images_url . 'plugin-rp.png',
					'name' => esc_html__( 'RafflePress Pro', 'instagram-feed' ),
					'desc' => esc_html__( 'Turn your visitors into brand ambassadors! Easily grow your email list, website traffic, and social media followers with powerful viral giveaways & contests.', 'instagram-feed' ),
					'url'  => 'https://rafflepress.com/pricing/',
					'act'  => 'go-to-url',
				),
			),

			'all-in-one-seo-pack/all_in_one_seo_pack.php'           => array(
				'icon' => $images_url . 'plugin-seo.png',
				'name' => esc_html__( 'All In One SEO Pack', 'instagram-feed' ),
				'desc' => esc_html__( 'Out-of-the-box SEO for WordPress. Features like XML Sitemaps, SEO for custom post types, SEO for blogs or business sites, SEO for ecommerce sites, and much more. More than 50 million downloads since 2007.', 'instagram-feed' ),
				'url'  => 'https://downloads.wordpress.org/plugin/all-in-one-seo-pack.zip',
			),
		);
	}

	/**
	 * Get the array of data that compared the license data.
	 *
	 * @since 2.4/5.5
	 *
	 * @param string $feature Feature name.
	 * @param string $license License type to get data for.
	 *
	 * @return array|false
	 */
	protected function get_license_data( $feature, $license ) {

		$data = array(
			'entries'      => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'User feeds only', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'User, Hashtag, and Tagged Feeds', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Complete Entry Management inside WordPress', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'User, hashtag, and tagged feeds', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'fields'       => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Grid layout only', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Access to all Standard and Fancy Fields', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Address, Phone, Website URL, Date/Time, Password, File Upload, HTML, Pagebreaks, Section Dividers, Ratings, and Hidden Field', 'instagram-feed' ),
					),
				),
				'plus'  => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Access to all Standard and Fancy Fields', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Address, Phone, Website URL, Date/Time, Password, File Upload, HTML, Pagebreaks, Section Dividers, Ratings, and Hidden Field', 'instagram-feed' ),
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Grid, highlight, masonry, and carousel layouts', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'conditionals' => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Image, carousel, and video thumbnails', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Powerful Form Logic for Building Smart Forms', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Powerful Form Logic for Building Smart Forms', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Display images, swipe through carousel posts, and play videos in a pop-up lightbox', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'templates'    => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Images and link only', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Basic Form Templates', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Basic Form Templates', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Thumbnails, dates, caption, comments, like counts, and comment counts.', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'marketing'    => array(
				'lite'  => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Limited Marketing Integration', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Constant Contact only', 'instagram-feed' ),
					),
				),
				'plus'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( '6 Email Marketing Integrations', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Constant Contact, Mailchimp, AWeber, GetResponse, Campaign Monitor, and Drip', 'instagram-feed' ),
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Display your latest Instagram story in a pop-up lightbox', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'payments'     => array(
				'lite'  => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Visual moderation system for removing posts or creating a "white list" of selected posts', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'surveys'      => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Standard or centered header', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Standard, centered, or boxed header that includes follower and post counts', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'advanced'     => array(
				'lite'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Posts link to the same post on Instagram', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Limited Advanced Features', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Multi-page Forms, File Upload Forms, Multiple Form Notifications, Conditional Form Confirmation', 'instagram-feed' ),
					),
				),
				'plus'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Limited Advanced Features', 'instagram-feed' ) . '</strong>',
						esc_html__( 'Multi-page Forms, File Upload Forms, Multiple Form Notifications, Conditional Form Confirmation', 'instagram-feed' ),
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Allow your posts to link to a URL in the caption or view in a lightbox', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'addons'       => array(
				'lite'  => array(
					'status' => 'none',
					'text'   => array(
						'<strong>' . esc_html__( 'Not available', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic' => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Custom Captcha Addon included', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'  => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Email Marketing Addons included', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Filter by word or hashtag', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'support'      => array(
				'lite'     => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Limited support', 'instagram-feed' ) . '</strong>',
					),
				),
				'basic'    => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Standard Support', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'     => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( 'Standard Support', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'      => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Priority support', 'instagram-feed' ) . '</strong>',
					),
				),
				'elite'    => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Premium Support', 'instagram-feed' ) . '</strong>',
					),
				),
				'ultimate' => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Premium Support', 'instagram-feed' ) . '</strong>',
					),
				),
				'agency'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Premium Support', 'instagram-feed' ) . '</strong>',
					),
				),
			),
			'sites'        => array(
				'basic'    => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( '1 Site', 'instagram-feed' ) . '</strong>',
					),
				),
				'plus'     => array(
					'status' => 'partial',
					'text'   => array(
						'<strong>' . esc_html__( '3 Sites', 'instagram-feed' ) . '</strong>',
					),
				),
				'pro'      => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( '5 Sites', 'instagram-feed' ) . '</strong>',
					),
				),
				'elite'    => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Unlimited Sites', 'instagram-feed' ) . '</strong>',
					),
				),
				'ultimate' => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Unlimited Sites', 'instagram-feed' ) . '</strong>',
					),
				),
				'agency'   => array(
					'status' => 'full',
					'text'   => array(
						'<strong>' . esc_html__( 'Unlimited Sites', 'instagram-feed' ) . '</strong>',
					),
				),
			),
		);

		// Wrong feature?
		if ( ! isset( $data[ $feature ] ) ) {
			return false;
		}

		// Is a top level license?
		$is_licenses_top = in_array( $license, self::$licenses_top, true );

		// Wrong license type?
		if ( ! isset( $data[ $feature ][ $license ] ) && ! $is_licenses_top ) {
			return false;
		}

		// Some licenses have partial data.
		if ( isset( $data[ $feature ][ $license ] ) ) {
			return $data[ $feature ][ $license ];
		}

		// Top level plans has no feature difference with `pro` plan in most cases.
		return $is_licenses_top ? $data[ $feature ]['pro'] : $data[ $feature ][ $license ];
	}

	/**
	 * Get the current installation license type (always lowercase).
	 *
	 * @since 2.4/5.5
	 *
	 * @return string
	 */
	protected function get_license_type() {

		//$type = sbi_setting( 'type', '', 'sbi_license' );

		//if ( empty( $type ) || ! sbi()->pro ) {
			$type = 'lite';
		//}

		return strtolower( $type );
	}
}

new SB_Instagram_About();
