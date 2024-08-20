<?php

if (!defined('ABSPATH')) {
    exit;
}

class WP_Easy_Tables_Walkers_Service {

    public function fetch_parish_congregations() {
        global $wpdb;
        return $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'user_registration_user_parish_congregation'");
    }

    public function fetch_filtered_users($filters) {
        $search_name = isset($filters['search_name']) ? sanitize_text_field($filters['search_name']) : '';
        $user_status = isset($filters['user_status']) ? sanitize_text_field($filters['user_status']) : '';
        $parish_congregation = isset($filters['parish_congregation']) ? sanitize_text_field($filters['parish_congregation']) : '';
        $users_per_page = isset($filters['users_per_page']) ? intval($filters['users_per_page']) : 10;
        $paged = isset($filters['paged']) ? intval($filters['paged']) : 1;
        $offset = ($paged - 1) * $users_per_page;

        $users_query_args = array(
            'search'         => '*' . esc_attr($search_name) . '*',
            'search_columns' => array('user_login', 'user_nicename', 'user_email'),
            'number'         => $users_per_page,
            'offset'         => $offset,
        );

        if ($user_status === 'active') {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_status',
                'value'   => 'active',
                'compare' => '='
            );
        } elseif ($user_status === 'inactive') {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_status',
                'value'   => 'inactive',
                'compare' => '='
            );
        }

        if (!empty($parish_congregation)) {
            $users_query_args['meta_query'][] = array(
                'key'     => 'user_registration_user_parish_congregation',
                'value'   => $parish_congregation,
                'compare' => '='
            );
        }

        $user_query = new WP_User_Query($users_query_args);
        $users = $user_query->get_results();

        // $users = get_users($users_query_args);
        // $total_users = count_users()['total_users'];
        // $total_pages = ceil($total_users / $users_per_page);

        // $result = array(
        //     'users' => $users,
        //     'total_users' => $total_users,
        //     'total_pages' => $total_pages
        // );

        // $result = array();
        // foreach ($users as $user) {
        //     $result[] = (object) array(
        //         'display_name' => $user->display_name,
        //         'user_email' => $user->user_email,
        //         'status' => get_user_meta($user->ID, 'user_status', true),
        //         'parish' => get_user_meta($user->ID, 'user_registration_user_parish_congregation', true),
        //     );
        // }

        return $users;
    }

    public function get_walkers() {
        global $wpdb;
        $submissions_table = $wpdb->prefix . 'e_submissions';
        $submissions_table_values = $wpdb->prefix . 'e_submissions_values';

        // Get all submissions for the walkers_registration form and then get the information for each walker from the submissions_values table

        $submissions = $wpdb->get_results("SELECT * FROM $submissions_table WHERE form_name = 'walkers_registration'");

        $walkers = array();
        foreach ($submissions as $submission) {
            $walker = new stdClass();
            $walker->id = $submission->id;
            $values = $wpdb->get_results("SELECT * FROM $submissions_table_values WHERE submission_id = $submission->id");
            
            // iterare over the values and set the walker properties, e.g. inside values there is a row key and value.
            foreach ($values as $value) {
                $walker->{$value->key} = $value->value;
            }

            $walkers[] = $walker;
            
        }

        return $walkers;
    }
}