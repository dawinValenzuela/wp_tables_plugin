<?php
// Check if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once plugin_dir_path(__FILE__) . '../controllers/class-wp-easy-tables-controller.php';

$controller = new WP_Easy_Tables_Controller();
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="GET" action="">
        <input type="hidden" name="page" value="wp_easy_tables" />
        <input type="text" name="search_name" placeholder="Search by name" value="<?php echo isset($_GET['search_name']) ? esc_attr($_GET['search_name']) : ''; ?>" />
        <select name="user_status">
            <option value="">All Users</option>
            <option value="1" <?php selected($_GET['user_status'], 'active'); ?>>Active</option>
            <option value="0" <?php selected($_GET['user_status'], 'inactive'); ?>>Inactive</option>
        </select>
        <select name="parish_congregation">
            <option value="">All Parishes</option>
            <?php
                // global $wpdb;
                // $parish_congregations = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'user_registration_user_parish_congregation'");
                // foreach ($parish_congregations as $parish) {
                //     echo '<option value="' . esc_attr($parish) . '" ' . selected($_GET['parish_congregation'], $parish, false) . '>' . esc_html($parish) . '</option>';
                // }
                
                $parish_congregations = $controller->get_parish_congregations();
                foreach ($parish_congregations as $parish) {
                    echo '<option value="' . esc_attr($parish) . '" ' . selected($_GET['parish_congregation'], $parish, false) . '>' . esc_html($parish) . '</option>';
                }
            ?>
        </select>
        <select name="users_per_page">
            <option value="10" <?php selected($_GET['users_per_page'], 10); ?>>10</option>
            <option value="20" <?php selected($_GET['users_per_page'], 20); ?>>20</option>
            <option value="50" <?php selected($_GET['users_per_page'], 50); ?>>50</option>
        </select>
        <button type="submit">Apply Filters</button>
        <!-- Clear filters -->
        <a href="<?php echo admin_url('admin.php?page=wp_easy_tables'); ?>">Clear Filters</a>
    </form>

    <?php
        $users = $controller->get_filtered_users($_GET);
    ?>

    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="user_id" class="manage-column column-columnname" scope="col">User ID</th>
                <th id="user_login" class="manage-column column-columnname" scope="col">Username</th>
                <th id="user_email" class="manage-column column-columnname" scope="col">Email</th>
                <th id="user_registered" class="manage-column column-columnname" scope="col">Registered Date</th>
                <th id="user_role" class="manage-column column-columnname" scope="col">Role</th>
                <th id="user_status" class="manage-column column-columnname" scope="col">Status</th>
                <th id="user_birthdate" class="manage-column column-columnname" scope="col">Birthdate</th>
                <th id="user_retreat_date" class="manage-column column-columnname" scope="col">Emaus Retreat Date</th>
                <th id="user_notes" class="manage-column column-columnname" scope="col">Additional Notes</th>
                <th id="user_cellphone" class="manage-column column-columnname" scope="col">Cellphone</th>
                <th id="user_parish" class="manage-column column-columnname" scope="col">Parish Congregation</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)) : ?>
                <?php
                    foreach ( $users as $user ) {
                        $user_id = $user->ID;
                        $user_login = esc_html($user->user_login);
                        $user_email = esc_html($user->user_email);
                        $user_registered = esc_html($user->user_registered);

                        // Obtener el rol del usuario
                        $user_meta = get_userdata($user_id);
                        $user_roles = $user_meta->roles;
                        $role = !empty($user_roles) ? implode(', ', $user_roles) : 'No role';

                        // Obtener el estado del usuario
                        $status = get_user_meta($user_id, 'user_status', true);
                        $status_display = $status == 0 ? 'Inactive' : 'Active';

                        $birthdate = esc_html(get_user_meta( $user_id, 'user_registration_user_birthdate', true ));
                        $retreat_date = esc_html(get_user_meta( $user_id, 'user_registration_user_emaus_retreat_date', true ));
                        $notes = esc_html(get_user_meta( $user_id, 'user_registration_user_additional_notes', true ));
                        $cellphone = esc_html(get_user_meta( $user_id, 'user_registration_user_cellphone', true ));
                        $parish = esc_html(get_user_meta( $user_id, 'user_registration_user_parish_congregation', true ));

                        echo "<tr>
                                <td>{$user_id}</td>
                                <td>{$user_login}</td>
                                <td>{$user_email}</td>
                                <td>{$user_registered}</td>
                                <td>{$role}</td>
                                <td>{$status_display}</td>
                                <td>{$birthdate}</td>
                                <td>{$retreat_date}</td>
                                <td>{$notes}</td>
                                <td>{$cellphone}</td>
                                <td>{$parish}</td>
                            </tr>";
                    }
                ?>
            <?php else : ?>
            <tr>
                <td colspan="9">No users found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <?php
        // Pagination links
        echo paginate_links(array(
            'total'   => $total_pages,
            'current' => $paged,
        ));
    ?>
</div>
