<?php
// Check if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$controller = new WP_Easy_Tables_Servers_Controller();
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="wp-easy-tables-toolbar-container">
        <div class="migrate-button-container">
            <button id="migrate-servers" class="button button-primary">Migrar tabla servidores</button>
        </div>
    </div>
    <?php
    $walkers = $controller->get_servers();
    ?>

    <div class="wp-easy-tables-table-wrapper">
        <div class="wp-easy-tables-table-container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th id="user_actions" class="manage-column column-columnname" scope="col">Acciones</th>
                        <th id="user_id" class="manage-column column-columnname" scope="col">ID</th>
                        <th id="user_name" class="manage-column column-columnname" scope="col">Nombre</th>
                        <th id="user_lastname" class="manage-column column-columnname" scope="col">Apellido</th>
                        <th id="user_email" class="manage-column column-columnname" scope="col">Email</th>
                        <th id="user_phone" class="manage-column column-columnname" scope="col">Telefono</th>
                        <th id="user_birthdate" class="manage-column column-columnname" scope="col">Fecha de Nacimiento</th>
                        <th id="user_eps" class="manage-column column-columnname" scope="col">Eps</th>
                        <th id="user_parish_congregation" class="manage-column column-columnname" scope="col">Parroquia</th>
                        <th id="user_first_service_date" class="manage-column column-columnname" scope="col">Fecha de primer servicio</th>
                        <th id="user_emergency_contact_name" class="manage-column column-columnname" scope="col">Contacto de emergencia</th>
                        <th id="user_emergency_contact_phone" class="manage-column column-columnname" scope="col">Teléfono de contacto de emergencia</th>
                        <th id="user_emergency_contact_relationship" class="manage-column column-columnname" scope="col">Parentesco de contacto de emergencia</th>
                        <th id="medical_condition" class="manage-column column-columnname" scope="col">Condición médica</th>
                        <th id="special_diet" class="manage-column column-columnname" scope="col">Dieta especial</th>
                        <th id="user_additional_info" class="manage-column column-columnname" scope="col">Información adicional</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($walkers)) : ?>
                        <?php
                        foreach ($walkers as $walker) {
                            // Serializar el objeto $walker en un formato JSON seguro para HTML
                            $walker_data_json = esc_attr(json_encode($walker));

                            echo '<tr class="user-table-row" data-walker=\'' . $walker_data_json . '\'>';
                            echo '<td class="user-action-container"></td>';
                            echo '<td>' . esc_html($walker->id) . '</td>';
                            echo '<td>' . esc_html($walker->first_name) . '</td>';
                            echo '<td>' . esc_html($walker->last_name) . '</td>';
                            echo '<td>' . esc_html($walker->email) . '</td>';
                            echo '<td>' . esc_html($walker->phone_number) . '</td>';
                            echo '<td>' . esc_html($walker->birthdate) . '</td>';
                            echo '<td>' . esc_html($walker->eps) . '</td>';
                            echo '<td>' . esc_html($walker->church) . '</td>';
                            echo '<td>' . esc_html($walker->first_service_date) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_name) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_phone) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_relationship) . '</td>';
                            echo '<td>' . esc_html($walker->medical_condition) . '</td>';
                            echo '<td>' . esc_html($walker->special_diet) . '</td>';
                            echo '<td>' . esc_html($walker->additional_info) . '</td>';
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
        </div>
    </div>


    <!-- <?php
            // Pagination links
            echo paginate_links(array(
                'total'   => $total_pages,
                'current' => $paged,
            ));
            ?> -->
</div>