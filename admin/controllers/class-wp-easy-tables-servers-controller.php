<?php
/**
 * WP Easy Tables Servers Controller
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once plugin_dir_path( __FILE__ ) . '../services/class-wp-easy-tables-servers-service.php';

/**
 * Class WP_Easy_Tables_Servers_Controller
 *
 * This class handles server-related operations for the WP Easy Tables plugin.
 */
class WP_Easy_Tables_Servers_Controller {


	/**
	 * Service instance for handling server operations.
	 *
	 * @var WP_Easy_Tables_Servers_Service
	 */
	private $service;

	/**
	 * Constructor for WP_Easy_Tables_Servers_Controller.
	 */
	public function __construct() {
		$this->service = new WP_Easy_Tables_Servers_Service();
	}

	/**
	 * Retrieve the list of servers.
	 *
	 * @return array List of servers.
	 */
	public function get_servers() {
		return $this->service->get_servers();
	}

	/**
	 * Migrate servers to a new table.
	 *
	 * @return void
	 */
	public function migrate_servers() {
		$result = $this->service->migrate_servers_to_new_table();

		if ( $result['success'] ) {
			wp_send_json_success( $result );
		} else {
			wp_send_json_error( $result['message'] );
		}

		wp_die();
	}

	/**
	 * Update additional information for a server.
	 *
	 * @param WP_REST_Request $request The request object containing server ID and additional info.
	 * @return void
	 */
	public function update_additional_info( $request ) {
		$server_id       = $request->get_param( 'server_id' );
		$additional_info = $request->get_param( 'additional_info' );

		$result = $this->service->update_additional_info( $server_id, $additional_info );

		if ( $result['success'] ) {
			wp_send_json_success( $result );
		} else {
			wp_send_json_error( $result['message'] );
		}

		wp_die();
	}

	/**
	 * Export the list of servers to an Excel file.
	 *
	 * @return void
	 */
	public function export_servers_to_excel() {
		$servers     = $this->service->get_servers();
		$spreadsheet = new Spreadsheet();
		$sheet       = $spreadsheet->getActiveSheet();

		$sheet->setCellValue( 'A1', 'ID' );
		$sheet->setCellValue( 'B1', 'Nombre' );
		$sheet->setCellValue( 'C1', 'Apellido' );
		$sheet->setCellValue( 'D1', 'Email' );
		$sheet->setCellValue( 'E1', 'Telefono' );
		$sheet->setCellValue( 'F1', 'Fecha de Nacimiento' );
		$sheet->setCellValue( 'G1', 'Eps' );
		$sheet->setCellValue( 'H1', 'Fecha de primer servicio' );
		$sheet->setCellValue( 'I1', 'Parroquia' );
		$sheet->setCellValue( 'J1', 'Contacto de emergencia' );
		$sheet->setCellValue( 'K1', 'Teléfono de contacto de emergencia' );
		$sheet->setCellValue( 'L1', 'Parentesco de contacto de emergencia' );
		$sheet->setCellValue( 'M1', 'Condición médica' );
		$sheet->setCellValue( 'N1', 'Dieta especial' );
		$sheet->setCellValue( 'O1', 'Información adicional' );

		$row = 2;
		foreach ( $servers as $server ) {
			$sheet->setCellValue( 'A' . $row, $server->id );
			$sheet->setCellValue( 'B' . $row, $server->first_name );
			$sheet->setCellValue( 'C' . $row, $server->last_name );
			$sheet->setCellValue( 'D' . $row, $server->email );
			$sheet->setCellValue( 'E' . $row, $server->phone_number );
			$sheet->setCellValue( 'F' . $row, $server->birthdate );
			$sheet->setCellValue( 'G' . $row, $server->eps );
			$sheet->setCellValue( 'H' . $row, $server->first_service_date );
			$sheet->setCellValue( 'I' . $row, $server->church );
			$sheet->setCellValue( 'J' . $row, $server->emergency_contact_name );
			$sheet->setCellValue( 'K' . $row, $server->emergency_contact_phone );
			$sheet->setCellValue( 'L' . $row, $server->emergency_contact_relationship );
			$sheet->setCellValue( 'M' . $row, $server->medical_condition );
			$sheet->setCellValue( 'N' . $row, $server->special_diet );
			$sheet->setCellValue( 'O' . $row, $server->additional_info );
			++$row;
		}

		$filename  = 'servers_' . gmdate( 'Y-m-d_H-i-s' ) . '.xlsx';
		$file_path = tempnam( sys_get_temp_dir(), $filename );
		$writer    = new Xlsx( $spreadsheet );
		$writer->save( $file_path );

		header( 'Content-Description: File Transfer' );
		header( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
		header( 'Content-Disposition: attachment; filename="' . basename( $filename ) . '"' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate' );
		header( 'Pragma: public' );
		header( 'Content-Length: ' . filesize( $file_path ) );

		readfile( $file_path );
		wp_delete_file( $file_path );
		exit;
	}
}
