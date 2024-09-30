<?php
// Check if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$controller = new WP_Easy_Tables_Servers_Controller();
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form method="GET" action="">
        <!-- <input type="hidden" name="page" value="wp_easy_tables" />
        <input type="text" name="search_name" placeholder="Search by name" value="<?php echo isset($_GET['search_name']) ? esc_attr($_GET['search_name']) : ''; ?>" />
        <select name="user_status">
            <option value="">All Users</option>
            <option value="1" <?php selected($_GET['user_status'], 'active'); ?>>Active</option>
            <option value="0" <?php selected($_GET['user_status'], 'inactive'); ?>>Inactive</option>
        </select> -->
        <!-- <select name="parish_congregation">
            <option value="">All Parishes</option>
            <?php
            // global $wpdb;
            // $parish_congregations = $wpdb->get_col("SELECT DISTINCT meta_value FROM {$wpdb->usermeta} WHERE meta_key = 'user_registration_user_parish_congregation'");
            // foreach ($parish_congregations as $parish) {
            //     echo '<option value="' . esc_attr($parish) . '" ' . selected($_GET['parish_congregation'], $parish, false) . '>' . esc_html($parish) . '</option>';
            // }

            // $parish_congregations = $controller->get_parish_congregations();
            // foreach ($parish_congregations as $parish) {
            //     echo '<option value="' . esc_attr($parish) . '" ' . selected($_GET['parish_congregation'], $parish, false) . '>' . esc_html($parish) . '</option>';
            // }
            ?>
        </select> -->
        <!-- <select name="users_per_page">
            <option value="10" <?php selected($_GET['users_per_page'], 10); ?>>10</option>
            <option value="20" <?php selected($_GET['users_per_page'], 20); ?>>20</option>
            <option value="50" <?php selected($_GET['users_per_page'], 50); ?>>50</option>
        </select>
        <button type="submit">Apply Filters</button> -->
        <!-- Clear filters -->
        <a href="<?php echo admin_url('admin.php?page=wp_easy_tables'); ?>">Clear Filters</a>
    </form>
    <div class="migrate-button-container">
        <button id="migrate-servers" class="button button-primary">Migrar tabla servidores</button>
    </div>

    <?php
    $walkers = $controller->get_servers();
    ?>

    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="user_id" class="manage-column column-columnname" scope="col">ID</th>
                <th id="user_name" class="manage-column column-columnname" scope="col">Nombre</th>
                <th id="user_lastname" class="manage-column column-columnname" scope="col">Apellido</th>
                <th id="user_email" class="manage-column column-columnname" scope="col">Email</th>
                <th id="user_phone" class="manage-column column-columnname" scope="col">Telefono</th>
                <th id="user_birthdate" class="manage-column column-columnname" scope="col">Fecha de Nacimiento</th>
                <th id="user_eps" class="manage-column column-columnname" scope="col">Eps</th>
                <th id="user_actions" class="manage-column column-columnname" scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($walkers)) : ?>
                <?php
                foreach ($walkers as $walker) {
                    // Serializar el objeto $walker en un formato JSON seguro para HTML
                    $walker_data_json = esc_attr(json_encode($walker));

                    echo '<tr class="user-table-row" data-walker=\'' . $walker_data_json . '\'>';
                    echo '<td>' . esc_html($walker->id) . '</td>';
                    echo '<td>' . esc_html($walker->first_name) . '</td>';
                    echo '<td>' . esc_html($walker->last_name) . '</td>';
                    echo '<td>' . esc_html($walker->email) . '</td>';
                    echo '<td>' . esc_html($walker->phone_number) . '</td>';
                    echo '<td>' . esc_html($walker->birthdate) . '</td>';
                    echo '<td>' . esc_html($walker->eps) . '</td>';
                    echo '<td class="user-action-container"></td>';
                    echo '</tr>';
                }
                ?>
            <?php else : ?>
                <tr>
                    <td colspan="9">No users found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- <?php
            // Pagination links
            echo paginate_links(array(
                'total'   => $total_pages,
                'current' => $paged,
            ));
            ?> -->
</div>