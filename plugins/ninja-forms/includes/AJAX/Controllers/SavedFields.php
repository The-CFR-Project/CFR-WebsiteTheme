<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_Controllers_SavedFields extends NF_Abstracts_Controller
{
    public function __construct()
    {
        /**
         * These Ajax calls are all handled in this file by 'create', 'update',
         * and 'delete', respectively
        */
        add_action( 'wp_ajax_nf_create_saved_field', array( $this, 'create' ) );
        add_action( 'wp_ajax_nf_update_saved_field', array( $this, 'update' ) );
        add_action( 'wp_ajax_nf_delete_saved_field', array( $this, 'delete' ) );
    }

    public function create()
    {
        // Does the current user have admin privileges
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            $this->_errors[] = esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms');
            $this->_respond();
        }

        check_ajax_referer( 'ninja_forms_builder_nonce', 'security' );

        if( ! isset( $_POST[ 'field' ] ) || empty( $_POST[ 'field' ] ) ){
            $this->_errors[] = esc_html__( 'Field Not Found', 'ninja-forms' );
            $this->_respond();
        }

        $field_settings = json_decode( stripslashes( $_POST[ 'field' ] ), ARRAY_A );

        $field = Ninja_Forms()->form()->field()->get();
        $field->update_settings( $field_settings );
        $field->update_setting( 'saved', 1 );
        $field->save();

        $this->_data[ 'id' ] = $field->get_id();

        $this->_respond();
    }

    public function update()
    {
        // Does the current user have admin privileges
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            $this->_errors[] = esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms');
            $this->_respond();
        }

        check_ajax_referer( 'ninja_forms_builder_nonce', 'security' );

        if( ! isset( $_POST[ 'field' ] ) || empty( $_POST[ 'field' ] ) ){
            $this->_errors[] = esc_html__( 'Field Not Found', 'ninja-forms' );
            $this->_respond();
        }

        $this->_respond();
    }

    public function delete()
    {
        // Does the current user have admin privileges
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            $this->_errors[] = esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms');
            $this->_respond();
        }

        check_ajax_referer( 'ninja_forms_settings_nonce', 'security' );

        if( ! isset( $_POST[ 'field' ] ) || empty( $_POST[ 'field' ] ) ){
            $this->_errors[] = esc_html__( 'Field Not Found', 'ninja-forms' );
            $this->_respond();
        }

        $id = absint( $_POST[ 'field' ][ 'id' ] );

        $errors = Ninja_Forms()->form()->get_field( $id )->delete();

        $this->_data[ 'id' ] = $id;
        $this->_data[ 'errors' ] = $errors;

        $this->_respond();
    }


}
