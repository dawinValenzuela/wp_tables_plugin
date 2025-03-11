<?php
/**
 * WP Easy Tables Walkers Controller
 *
 * This file contains the controller for managing walkers in the WP Easy Tables plugin.
 *
 * @package WP_Easy_Tables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once plugin_dir_path( __FILE__ ) . '../services/class-wp-easy-tables-walkers-service.php';

/**
 * Class WP_Easy_Tables_Walkers_Controller
 *
 * This class handles the controller logic for managing walkers in the WP Easy Tables plugin.
 */
class WP_Easy_Tables_Walkers_Controller {


	/**
	 * Service instance for managing walkers.
	 *
	 * @var WP_Easy_Tables_Walkers_Service
	 */
	private $service;

	/**
	 * Constructor for WP_Easy_Tables_Walkers_Controller.
	 */
	public function __construct() {
		$this->service = new WP_Easy_Tables_Walkers_Service();
	}

	/**
	 * Get all walkers.
	 *
	 * @return array List of walkers.
	 */
	public function get_walkers() {
		return $this->service->get_walkers();
	}

	/**
	 * Search for walkers based on a search term.
	 *
	 * @param WP_REST_Request $request The request object containing the search term.
	 * @return void
	 */
	public function search_walkers( $request ) {
		$search  = $request->get_param( 'search' );
		$walkers = $this->service->search_walkers( $search );

		wp_send_json_success( $walkers );

		wp_die();
	}

	/**
	 * Migrate walkers to the new table.
	 *
	 * @return void
	 */
	public function migrate_walkers() {
		$result = $this->service->migrate_walkers_to_new_table();

		if ( $result['success'] ) {
			wp_send_json_success( $result );
		} else {
			wp_send_json_error( $result['message'] );
		}

		wp_die();
	}

	/**
	 * Update additional information for a walker.
	 *
	 * @param WP_REST_Request $request The request object containing the walker ID and additional information.
	 * @return void
	 */
	public function update_additional_info( $request ) {
		$walker_id       = $request->get_param( 'walker_id' );
		$additional_info = $request->get_param( 'additional_info' );

		$result = $this->service->update_additional_info( $walker_id, $additional_info );

		if ( $result['success'] ) {
			wp_send_json_success( $result );
		} else {
			wp_send_json_error( $result['message'] );
		}

		wp_die();
	}

	/**
	 * Export walkers to an Excel file.
	 *
	 * @return void
	 */
	public function export_walkers_to_excel() {
			$walkers     = $this->service->get_walkers();
			$spreadsheet = new Spreadsheet();
			$sheet       = $spreadsheet->getActiveSheet();

			$sheet->setCellValue( 'A1', 'ID' );
			$sheet->setCellValue( 'B1', 'Nombre' );
			$sheet->setCellValue( 'C1', 'Apellido' );
			$sheet->setCellValue( 'D1', 'Email' );
			$sheet->setCellValue( 'E1', 'Teléfono' );
			$sheet->setCellValue( 'F1', 'Dirección' );
			$sheet->setCellValue( 'G1', 'Fecha de nacimiento' );
			$sheet->setCellValue( 'H1', 'EPS' );
			$sheet->setCellValue( 'I1', 'Estado Civil' );
			$sheet->setCellValue( 'J1', 'Talla Camiseta' );
			$sheet->setCellValue( 'K1', 'Contacto de emergencia 1' );
			$sheet->setCellValue( 'L1', 'Teléfono de contacto de emergencia 1' );
			$sheet->setCellValue( 'M1', 'Parentesco de contacto de emergencia 1' );
			$sheet->setCellValue( 'N1', 'Contacto de emergencia 2' );
			$sheet->setCellValue( 'O1', 'Teléfono de contacto de emergencia 2' );
			$sheet->setCellValue( 'P1', 'Parentesco de contacto de emergencia 2' );
			$sheet->setCellValue( 'Q1', 'Invitado por' );
			$sheet->setCellValue( 'R1', 'Teléfono de quien lo invitó' );
			$sheet->setCellValue( 'S1', 'Parentesco con quien lo invitó' );
			$sheet->setCellValue( 'T1', 'Condición médica' );
			$sheet->setCellValue( 'U1', 'Dieta especial' );
			$sheet->setCellValue( 'V1', 'Nombre de quien paga el retiro' );
			$sheet->setCellValue( 'W1', 'Teléfono de quien pagará el retiro' );
			$sheet->setCellValue( 'X1', 'Notas adicionales' );
			$sheet->setCellValue( 'Y1', 'Información adicional' );

			$row = 2;
		foreach ( $walkers as $walker ) {
			$sheet->setCellValue( 'A' . $row, $walker->id );
			$sheet->setCellValue( 'B' . $row, $walker->first_name );
			$sheet->setCellValue( 'C' . $row, $walker->last_name );
			$sheet->setCellValue( 'D' . $row, $walker->email );
			$sheet->setCellValue( 'E' . $row, $walker->phone_number );
			$sheet->setCellValue( 'F' . $row, $walker->residence_address );
			$sheet->setCellValue( 'G' . $row, $walker->birthdate );
			$sheet->setCellValue( 'H' . $row, $walker->eps );
			$sheet->setCellValue( 'I' . $row, $walker->marital_status );
			$sheet->setCellValue( 'J' . $row, $walker->shirt_size );
			$sheet->setCellValue( 'K' . $row, $walker->emergency_contact_name_1 );
			$sheet->setCellValue( 'L' . $row, $walker->emergency_contact_phone_1 );
			$sheet->setCellValue( 'M' . $row, $walker->emergency_contact_relationship_1 );
			$sheet->setCellValue( 'N' . $row, $walker->emergency_contact_name_2 );
			$sheet->setCellValue( 'O' . $row, $walker->emergency_contact_phone_2 );
			$sheet->setCellValue( 'P' . $row, $walker->emergency_contact_relationship_2 );
			$sheet->setCellValue( 'Q' . $row, $walker->invited_by_name );
			$sheet->setCellValue( 'R' . $row, $walker->invited_by_phone );
			$sheet->setCellValue( 'S' . $row, $walker->invited_by_relationship );
			$sheet->setCellValue( 'T' . $row, $walker->medical_condition );
			$sheet->setCellValue( 'U' . $row, $walker->special_diet );
			$sheet->setCellValue( 'V' . $row, $walker->payment_by_name );
			$sheet->setCellValue( 'W' . $row, $walker->payment_by_phone );
			$sheet->setCellValue( 'X' . $row, $walker->additional_notes );
			$sheet->setCellValue( 'Y' . $row, $walker->additional_info );
			++$row;
		}

			$filename  = 'caminantes_' . gmdate( 'Y-m-d_H-i-s' ) . '.xlsx';
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
