<?php

if (!defined('ABSPATH')) {
    exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once plugin_dir_path(__FILE__) . '../services/class-wp-easy-tables-servers-service.php';

class WP_Easy_Tables_Servers_Controller
{

    private $service;

    public function __construct()
    {
        $this->service = new WP_Easy_Tables_Servers_Service();
    }

    public function get_servers()
    {
        return $this->service->get_servers();
    }

    public function migrate_servers()
    {
        $result = $this->service->migrate_servers_to_new_table();

        // Enviar la respuesta como JSON
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }

        // Finalizar la ejecución del script
        wp_die();
    }

    public function update_additional_info($request)
    {
        $server_id = $request->get_param('walker_id');
        $additional_info = $request->get_param('additional_info');

        $result = $this->service->update_additional_info($server_id, $additional_info);

        // Enviar la respuesta como JSON
        if ($result['success']) {
            wp_send_json_success($result);
        } else {
            wp_send_json_error($result['message']);
        }

        // Finalizar la ejecución del script
        wp_die();
    }

    public function export_servers_to_excel()
    {
        $servers = $this->service->get_servers();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Apellido');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Telefono');
        $sheet->setCellValue('F1', 'Fecha de Nacimiento');
        $sheet->setCellValue('G1', 'Eps');
        $sheet->setCellValue('H1', 'Fecha de primer servicio');
        $sheet->setCellValue('I1', 'Parroquia');
        $sheet->setCellValue('J1', 'Contacto de emergencia');
        $sheet->setCellValue('K1', 'Teléfono de contacto de emergencia');
        $sheet->setCellValue('L1', 'Parentesco de contacto de emergencia');
        $sheet->setCellValue('M1', 'Condición médica');
        $sheet->setCellValue('N1', 'Dieta especial');
        $sheet->setCellValue('O1', 'Información adicional');

        // Set data
        $row = 2;
        foreach ($servers as $server) {
            $sheet->setCellValue('A' . $row, $server->id);
            $sheet->setCellValue('B' . $row, $server->first_name);
            $sheet->setCellValue('C' . $row, $server->last_name);
            $sheet->setCellValue('D' . $row, $server->email);
            $sheet->setCellValue('E' . $row, $server->phone_number);
            $sheet->setCellValue('F' . $row, $server->birthdate);
            $sheet->setCellValue('G' . $row, $server->eps);
            $sheet->setCellValue('H' . $row, $server->first_service_date);
            $sheet->setCellValue('I' . $row, $server->church);
            $sheet->setCellValue('J' . $row, $server->emergency_contact_name);
            $sheet->setCellValue('K' . $row, $server->emergency_contact_phone);
            $sheet->setCellValue('L' . $row, $server->emergency_contact_relationship);
            $sheet->setCellValue('M' . $row, $server->medical_condition);
            $sheet->setCellValue('N' . $row, $server->special_diet);
            $sheet->setCellValue('O' . $row, $server->additional_info);
            $row++;
        }

        // Save file
        $filename = 'caminantes_' . date('Y-m-d_H-i-s') . '.xlsx';
        $file_path = tempnam(sys_get_temp_dir(), $filename);
        $writer = new Xlsx($spreadsheet);
        $filename = 'servers_' . date('Y-m-d_H-i-s') . '.xlsx';
        $writer->save($file_path);

        // Send file
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));

        readfile($file_path);
        unlink($file_path);
        exit;
    }
}
