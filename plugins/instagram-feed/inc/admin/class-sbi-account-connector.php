<?php
/**
 * Class SBI_Account_Connector
 *
 * Connecting new accounts from
 *
 * @since 5.10
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class SBI_Account_Connector {

	/**
	 * @var array
	 *
	 * @since 5.10
	 */
	private $account_data;

	/**
	 * @var int
	 *
	 * @since 5.10
	 */
	private $id;

	public function construct() {
		$this->account_data = array();
	}

	/**
	 * When connecting accounts, modals are launched for various parts of the
	 * sequence
	 *
	 * @param $sb_instagram_user_id string
	 *
	 * @since 5.10
	 */
	public static function maybe_launch_modals( $sb_instagram_user_id ) {
		if ( ! empty( $_POST ) ) {
			return;
		}
		$connected_accounts = SBI_Account_Connector::stored_connected_accounts();
		if( isset( $_GET['sbi_access_token'] ) && isset( $_GET['sbi_graph_api'] ) ) {
			sbi_get_business_account_connection_modal( $sb_instagram_user_id );
		} elseif ( isset( $_GET['sbi_access_token'] ) && isset( $_GET['sbi_account_type'] ) ) {
			sbi_get_personal_connection_modal( $connected_accounts );
		}
	}

	/**
	 * @return int
	 *
	 * @since 5.10
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * @return array
	 *
	 * @since 5.10
	 */
	public function get_account_data() {
		return $this->account_data;
	}

	/**
	 * Get API data for the connected account using the account access
	 * token and ID
	 *
	 * @param $data array
	 *
	 * @return array
	 *
	 * @since 5.10
	 */
	public function fetch( $data ) {
		if ( ! isset( $data['user_id'] ) ) {
			return array( 'error' => __( 'Invalid account ID', 'instagram-feed' ) );
		}
		if ( ! isset( $data['access_token'] ) ) {
			return array( 'error' => __( 'Invalid access token', 'instagram-feed' ) );
		}

		$connection = new SB_Instagram_API_Connect( $data, 'header', array() );
		$connection->connect();

		if ( !$connection->is_wp_error() && ! $connection->is_instagram_error() ) {
			$new_data = $connection->get_data();

			if ( $data['type'] === 'basic' ) {
				$basic_account_access_token_connect = new SB_Instagram_API_Connect( $data, 'access_token', array() );
				$basic_account_access_token_connect->connect();
				$token_data = $basic_account_access_token_connect->get_data();

				if ( !$basic_account_access_token_connect->is_wp_error() && ! $basic_account_access_token_connect->is_instagram_error() ) {
					$expires_in = $token_data['expires_in'];
					$expires_timestamp = time() + $expires_in;
				} else {
					$expires_timestamp = time() + 60 * DAY_IN_SECONDS;
				}

				$new_connected_account = array(
					'access_token' => $data['access_token'],
					'account_type' => 'personal',
					'user_id' => $new_data['id'],
					'username' => $new_data['username'],
					'expires_timestamp' => $expires_timestamp,
					'type' => 'basic',
					'profile_picture' => ''
				);

			} else {
				$new_connected_account = array(
					'access_token' => $data['access_token'],
					'id' => $new_data['id'],
					'username' => $new_data['username'],
					'type' => 'business',
					'is_valid' => true,
					'last_checked' => time(),
					'profile_picture' => $new_data['profile_picture_url']
				);
			}

			return $new_connected_account;

		} else {

			if ( $connection->is_wp_error() ) {
				$error = $connection->get_wp_error();
			} else {
				$error = $connection->get_data();
			}
			return array( 'error' => sbi_formatted_error( $error ) );
		}


	}

	/**
	 * Add data to current set of information about the account
	 * being connected
	 *
	 * @param $data array
	 *
	 * @return bool
	 *
	 * @since 5.10
	 */
	public function add_account_data( $data ) {
		$data['id'] = isset( $data['id'] ) ? $data['id'] : $data['user_id'];
		if ( ! isset( $data['id'] ) ) {
			return false;
		}
		if ( ! isset( $data['access_token'] ) ) {
			return false;
		}

		$access_token = isset( $data['access_token'] ) ? $data['access_token'] : '';
		$page_access_token = isset( $data['page_access_token'] ) ? $data['page_access_token'] : '';
		$username = isset( $data['username'] ) ? $data['username'] : '';
		$name = isset( $data['name'] ) ? $data['name'] : '';
		$profile_picture = isset( $data['profile_picture_url'] ) ? $data['profile_picture_url'] : '';
		if ( empty( $profile_picture ) ) {
			$profile_picture = isset( $data['profile_picture'] ) ? $data['profile_picture'] : '';
		}
		$user_id = isset( $data['id'] ) ? $data['id'] : '';
		$type = isset( $data['type'] ) ? $data['type'] : 'basic';
		$account_type = isset( $data['account_type'] ) ? $data['account_type'] : 'business';
		$this->id = $user_id;
		$this->account_data = array(
			'access_token' => $access_token,
			'user_id' => $user_id,
			'username' => $username,
			'is_valid' => true,
			'last_checked' => time(),
			'type' => $type,
			'account_type' => $account_type,
			'profile_picture' => ''
		);

		if ( $type === 'business' ) {
			$this->account_data['use_tagged'] = '1';
			$this->account_data['name'] = sbi_sanitize_emoji( $name );
			$this->account_data['profile_picture'] = $profile_picture;
			$this->account_data['local_avatar'] = SB_Instagram_Connected_Account::create_local_avatar( $username, $profile_picture );
			$this->account_data['page_access_token'] = $page_access_token;
		}

		if ( isset( $data[ 'expires_timestamp']) ) {
			$this->account_data['expires_timestamp'] = $data[ 'expires_timestamp'];
		}

		return true;
	}

	/**
	 * Save data for new or existing connected account
	 *
	 * @return bool
	 *
	 * @since 5.10
	 */
	public function update_stored_account() {
		$options = sbi_get_database_settings();
		$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();
		$options['connected_accounts'] = $connected_accounts;

		if ( ! empty( $this->account_data ) ) {
			$options['connected_accounts'][ $this->id ] = $this->account_data;
			update_option( 'sb_instagram_settings', $options );

			return true;
		}
		return false;
	}

	/**
	 * Actions after updating or connecting an account
	 *
	 * @since 5.10
	 */
	public function after_update() {
		global $sb_instagram_posts_manager;
		$sb_instagram_posts_manager->remove_connected_account_error( $this->account_data );
		$sb_instagram_posts_manager->add_action_log( 'Connection or updating account ' . $this->account_data['username'] );

		do_action( 'sbi_account_connector_after_update', $this->account_data );
	}

	/**
	 * @return array
	 *
	 * @since 5.10
	 */
	public static function stored_connected_accounts() {
		$options = sbi_get_database_settings();
		$connected_accounts =  isset( $options['connected_accounts'] ) ? $options['connected_accounts'] : array();
		return $connected_accounts;
	}
}