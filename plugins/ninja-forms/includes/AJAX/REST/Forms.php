<?php if ( ! defined( 'ABSPATH' ) ) exit;

class NF_AJAX_REST_Forms extends NF_AJAX_REST_Controller
{
    protected $action = 'nf_forms';
    private $forms_controller;
    public function __construct()
    {
        parent::__construct();
        $this->forms_controller = new NF_Database_FormsController();
    }

    /**
     * POST /forms/<id>/
     * @param array $request_data [ int $clone_id ]
     * @return array $data [ int $new_form_id ]
     */
    public function post( $request_data )
    {
        // Does the current user have admin privileges
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            $data ['error'] = esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms');
            return $data;
        }

        // If we don't have a nonce...
        // OR if the nonce is invalid...
        if (!isset($request_data['security']) || !wp_verify_nonce($request_data['security'], 'ninja_forms_dashboard_nonce')) {
            // Kick the request out now.
            $data['error'] = esc_html__('Request forbidden.', 'ninja-forms');
            return $data;
        }

        if( isset( $request_data[ 'clone_id' ]) ){
            $clone_id = $request_data[ 'clone_id' ];
            $data[ 'new_form_id' ] = NF_Database_Models_Form::duplicate( $clone_id );
            return $data;
        }
    }

    /**
     * GET forms/
     * @return array [ $forms ]
     */
    public function get($request_data)
    {
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            return ['error' => esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms')];
        }

        // If we don't have a nonce...
        // OR if the nonce is invalid...
        if (!isset($request_data['security']) || !wp_verify_nonce($request_data['security'], 'ninja_forms_dashboard_nonce')) {
            // Kick the request out now.
            $data['error'] = esc_html__('Request forbidden.', 'ninja-forms');
            return $data;
        }

        return $this->forms_controller->getFormsData();
    }

    /**
     * DELETE forms/<id>/
     * @param array $request_data => [ form_id ]
     * @return array $data => [ delete => null ]
     */
    public function delete( $request_data )
    {
        // Does the current user have admin privileges
        if (!current_user_can(apply_filters('ninja_forms_admin_all_forms_capabilities', 'manage_options'))) {
            return ['error' => esc_html__('Access denied. You must have admin privileges to view this data.', 'ninja-forms')];
        }

        // If we don't have a nonce...
        // OR if the nonce is invalid...
        if (!isset($request_data['security']) || !wp_verify_nonce($request_data['security'], 'ninja_forms_dashboard_nonce')) {
            // Kick the request out now.
            $data['error'] = esc_html__('Request forbidden.', 'ninja-forms');
            return $data;
        }
        
        $id = $request_data[ 'form_id' ];

        $form = Ninja_Forms()->form( $id )->get();
        $data[ 'delete' ] = $form->delete();

        return $data;
    }

    /**
     * Form ID, Clone ID
     * @return array $request_data
     */
    protected function get_request_data()
    {
        $request_data = array();

        /*
         * FORM ID
         */
        if( isset( $_REQUEST[ 'form_id' ] ) && $_REQUEST[ 'form_id' ] ){
            $request_data[ 'form_id' ] = absint( $_REQUEST[ 'form_id' ] );
        }

        /*
         * CLONE ID
         */
        if( isset( $_REQUEST[ 'clone_id' ] ) && $_REQUEST[ 'clone_id' ] ){
            $request_data[ 'clone_id' ] = absint( $_REQUEST[ 'clone_id' ] );
        }

        /*
         * Security Nonce
         */
        if (isset($_REQUEST['security']) && $_REQUEST['security']) {
            $request_data[ 'security' ] = $_REQUEST[ 'security' ];
        }


        return $request_data;
    }
}
