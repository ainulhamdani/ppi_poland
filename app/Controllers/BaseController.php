<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\Events\Events;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();

	}

	public function useSelect2($elements){
		Events::on('add_more_style', function() {
				echo '
					<!-- Select2 -->
					<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/select2/css/select2.min.css">
					<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">';
		});
		Events::on('add_more_js', function() {
				echo '
				<!-- Select2 -->
				<script src="'.base_url().'/assets/theme/adminlte/plugins/select2/js/select2.full.min.js"></script>';
		});
		if(is_array($elements)&&!empty($elements)){
			foreach ($elements as $element) {
				Events::on('custom_script', function() use($element){
						echo '<script>
						$(function () {
							$(".'.$element.'").select2();
						});
						</script>';
				});
			}
		} elseif(is_string($elements)){
			Events::on('custom_script', function() use($elements){
					echo '<script>
					$(function () {
						$(".'.$elements.'").select2();
					});
					</script>';
			});
		}

	}

	public function useDataTables($elements){
		Events::on('add_more_style', function() {
				echo '
				<!-- DataTables -->
				<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
				<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">';
		});
		Events::on('add_more_js', function() {
				echo '
				<!-- DataTables -->
				<script src="'.base_url().'/assets/theme/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
				<script src="'.base_url().'/assets/theme/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
				<script src="'.base_url().'/assets/theme/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
				<script src="'.base_url().'/assets/theme/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>';
		});

		if(is_array($elements)&&!empty($elements)){
			foreach ($elements as $element) {
				Events::on('custom_script', function() use($element){
						echo '<script>
						$(function () {
							$("#'.$element.'").DataTable({
								"autoWidth": false,
								"responsive": true,
							});
						});
						</script>';
				});
			}
		} elseif(is_string($elements)){
			Events::on('custom_script', function() use($elements) {
					echo '<script>
					$(function () {
						$("#'.$elements.'").DataTable({
							"autoWidth": false,
							"responsive": true,
						});
					});
					</script>';
			});
		}
	}

	public function useDropzone(){
		Events::on('add_more_style', function() {
				echo '
				<!-- Dropzone -->
				<link rel="stylesheet" href="'.base_url().'/assets/css/dropzone.min.css">';
		});
		Events::on('add_more_js', function() {
				echo '
				<!-- Dropzone -->
				<script src="'.base_url().'/assets/js/dropzone.min.js"></script>
				<script>Dropzone.autoDiscover = false;</script>';
		});
	}

	public function useSweetAlert2(){
		Events::on('add_more_style', function() {
				echo '
				<!-- SweetAlert2 -->
				<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">';
		});
		Events::on('add_more_js', function() {
				echo '
				<!-- SweetAlert2 -->
				<script src="'.base_url().'/assets/theme/adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>';
		});
	}

	public function useJQVMap(){
		Events::on('add_more_style', function() {
				echo '
				<!-- JQVMap -->
				<link rel="stylesheet" href="'.base_url().'/assets/theme/adminlte/plugins/jqvmap/jqvmap.min.css">';
		});
		Events::on('add_more_js', function() {
				echo '
				<!-- JQVMap -->
				<script src="'.base_url().'/assets/theme/adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
				<script src="'.base_url().'/assets/theme/adminlte/plugins/jqvmap/maps/jquery.vmap.poland.js"></script>';
		});
	}

	public function useImageCompressor(){
		Events::on('add_more_js', function() {
				echo '
				<!-- Image Compressor -->
				<script src="'.base_url().'/assets/js/image-compressor/image-compressor.min.js"></script>';
		});
	}

}
