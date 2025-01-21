<?php
// Check if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$controller = new WP_Easy_Tables_Walkers_Controller();
?>

<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <div class="wp-easy-tables-toolbar-container">
        <!-- Search -->
        <div class="search-container">
            <input type="text" id="search-walkers" class="search" placeholder="Buscar caminantes">
        </div>


        <div class="migrate-button-container">
            <button id="migrate-walkers" class="button button-primary">Migrate Walkers</button>
        </div>
        <!-- Export to excel -->
        <div class="export-button-container">
            <button id="export-walkers" class="button button-primary">Export Walkers</button>
        </div>
    </div>
    <?php
    $walkers = $controller->get_walkers();
    ?>

    <div class="wp-easy-tables-table-wrapper">
        <div class="wp-easy-tables-table-container">
            <table cellspacing="0">
                <thead>
                    <tr>
                        <th id="user_actions" class="manage-column column-columnname sticky sticky-1" scope="col">Acciones</th>
                        <th id="user_id" class="manage-column column-columnname sticky sticky-2" scope="col">ID</th>
                        <th id="user_name" class="manage-column column-columnname sticky sticky-3" scope="col">Nombre</th>
                        <th id="user_lastname" class="manage-column column-columnname sticky sticky-4" scope="col">Apellido</th>
                        <th id="user_email" class="manage-column column-columnname" scope="col">Email</th>
                        <th id="user_phone" class="manage-column column-columnname" scope="col">Telefono</th>
                        <th id="user_birthdate" class="manage-column column-columnname" scope="col">Fecha de Nacimiento</th>
                        <th id="user_eps" class="manage-column column-columnname" scope="col">Eps</th>
                        <th id="user_marital_status" class="manage-column column-columnname" scope="col">Estado Civil</th>
                        <th id="user_shirt_size" class="manage-column column-columnname" scope="col">Talla Camiseta</th>
                        <th id="user_residence_address" class="manage-column column-columnname" scope="col">Dirección</th>
                        <th id="user_address_complement_one" class="manage-column column-columnname" scope="col">Complemento Dirección 1</th>
                        <th id="user_municipality" class="manage-column column-columnname" scope="col">Municipio</th>
                        <th id="user_emergency_contact_name_1" class="manage-column column-columnname" scope="col">Contacto de emergencia 1</th>
                        <th id="user_emergency_contact_phone_1" class="manage-column column-columnname" scope="col">Teléfono de contacto de emergencia 1</th>
                        <th id="user_emergency_contact_relationship_1" class="manage-column column-columnname" scope="col">Parentesco de contacto de emergencia 1</th>
                        <th id="user_emergency_contact_name_2" class="manage-column column-columnname" scope="col">Contacto de emergencia 2</th>
                        <th id="user_emergency_contact_phone_2" class="manage-column column-columnname" scope="col">Teléfono de contacto de emergencia 2</th>
                        <th id="user_emergency_contact_relationship_2" class="manage-column column-columnname" scope="col">Parentesco de contacto de emergencia 2</th>
                        <th id="user_invited_by_name" class="manage-column column-columnname" scope="col">Invitado por</th>
                        <th id="user_invited_by_phone" class="manage-column column-columnname" scope="col">Teléfono de quien lo invitó</th>
                        <th id="user_invited_by_relationship" class="manage-column column-columnname" scope="col">Parentesco con quien lo invitó</th>
                        <th id="user_medical_condition" class="manage-column column-columnname" scope="col">Condición médica</th>
                        <th id="user_special_diet" class="manage-column column-columnname" scope="col">Dieta especial</th>
                        <th id="user_payment_name" class="manage-column column-columnname" scope="col">Nombre de quien paga el retiro</th>
                        <th id="user_payment_phone" class="manage-column column-columnname" scope="col">Teléfono de quien pagará el retiro</th>
                        <th id="user_additional_notes" class="manage-column column-columnname" scope="col">Notas adicionales</th>
                        <th id="user_additional_info" class="manage-column column-columnname" scope="col">Información adicional</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($walkers)) : ?>
                        <?php
                        foreach ($walkers as $walker) {
                            // Serializar el objeto $walker en un formato JSON seguro para HTML
                            $walker->table = 'walkers';
                            $walker_data_json = esc_attr(json_encode($walker));

                            echo '<tr class="user-table-row" data-walker=\'' . $walker_data_json . '\'>';
                            echo '<td class="user-action-container sticky sticky-1"></td>';
                            echo '<td class="sticky sticky-2">' . esc_html($walker->id) . '</td>';
                            echo '<td class="sticky sticky-3">' . esc_html($walker->first_name) . '</td>';
                            echo '<td class="sticky sticky-4">' . esc_html($walker->last_name) . '</td>';
                            echo '<td>' . esc_html($walker->email) . '</td>';
                            echo '<td>' . esc_html($walker->phone_number) . '</td>';
                            echo '<td>' . esc_html($walker->birthdate) . '</td>';
                            echo '<td>' . esc_html($walker->eps) . '</td>';
                            echo '<td>' . esc_html($walker->marital_status) . '</td>';
                            echo '<td>' . esc_html($walker->shirt_size) . '</td>';
                            echo '<td>' . esc_html($walker->residence_address) . '</td>';
                            echo '<td>' . esc_html($walker->address_complement_one) . '</td>';
                            echo '<td>' . esc_html($walker->municipality) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_name_1) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_phone_1) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_relationship_1) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_name_2) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_phone_2) . '</td>';
                            echo '<td>' . esc_html($walker->emergency_contact_relationship_2) . '</td>';
                            echo '<td>' . esc_html($walker->invited_by_name) . '</td>';
                            echo '<td>' . esc_html($walker->invited_by_phone) . '</td>';
                            echo '<td>' . esc_html($walker->invited_by_relationship) . '</td>';
                            echo '<td>' . esc_html($walker->medical_condition) . '</td>';
                            echo '<td>' . esc_html($walker->special_diet) . '</td>';
                            echo '<td>' . esc_html($walker->payment_by_name) . '</td>';
                            echo '<td>' . esc_html($walker->payment_by_phone) . '</td>';
                            echo '<td>' . esc_html($walker->additional_notes) . '</td>';
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