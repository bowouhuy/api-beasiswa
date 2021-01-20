<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require('./application/third_party/phpoffice/vendor/autoload.php');
use chriskacerguis\RestServer\RestController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        
        parent::__construct();
        $this->load->model('Beasiswa');
        // $this->load->model('Objek');
        // $this->load->model('Cart');
        // $this->load->model('Transaksi');
        Header('Access-Control-Allow-Origin: *'); //for allow any domain, insecure
        Header('Access-Control-Allow-Headers: *'); //for allow any headers, insecure
        Header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE'); //method allowed
    }

    public function mahasiswa_get(){
        $npm = $this->input->get('npm');
        
        $where= array(
            'npm' => $npm
        );

        $response = $this->Beasiswa->list($where, $npm);
        

        if($response){
            $this->response(
                [
                    'status' => true,
                    'result' => $response
                ]
            );
        }else{
            $this->response(
                [
                    'status' => false,
                    'result' => "No Data Found"
                ]
            );
        }
    }

    public function mahasiswa_post(){
        $npm = $this->post('npm');
        $nama = $this->post('nama');
        $prodi = $this->post('prodi');
        $semester = $this->post('semester');
        $beasiswa = $this->post('beasiswa');
        $periode = $this->post('periode');
        $data = array(
            'npm' => $npm,
            'nama' => $nama,
            'prodi' => $prodi,
            'semester' => $semester,
            'beasiswa' => $beasiswa,
            'periode' => $periode,
        );

        $response = $this->Beasiswa->insert($data);
        
        if(! $response){
            $this->response(
                [
                    'status' => true,
                    'result' => "Success"
                ]
            );
        }else{
            $this->response(
                [
                    'status' => false,
                    'result' => $response
                ]
            );
        }
    }

    public function mahasiswa_put(){
        $npm = $this->put('npm');
        $nama = $this->put('nama');
        $prodi = $this->put('prodi');
        $semester = $this->put('semester');
        $beasiswa = $this->put('beasiswa');
        $periode = $this->put('periode');
        $data = array(
            'npm' => $npm,
            'nama' => $nama,
            'prodi' => $prodi,
            'semester' => $semester,
            'beasiswa' => $beasiswa,
            'periode' => $periode,
        );

        $response = $this->Beasiswa->edit($data);
        if(! $response){
            $this->response(
                [
                    'status' => true,
                    'result' => "Success Edit ".$data['npm']
                ]
            );
        }else{
            $this->response(
                [
                    'status' => false,
                    'result' => $response
                ]
            );
        }
    }

    public function mahasiswa_delete(){
        $npm = $this->delete('npm');

        $response = $this->Beasiswa->destroy($npm);
        if(! $response){
            $this->response(
                [
                    'status' => true,
                    'result' => "Success Delete ".$npm
                ]
            );
        }else{
            $this->response(
                [
                    'status' => false,
                    'result' => $response
                ]
            );
        }
    }

    public function upload_post()
    {
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        $config['upload_path'] = realpath('excel');
        $config['allowed_types'] = 'xlsx|xls|csv';
        $config['max_size'] = '10000';
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {

            //upload gagal
            $this->response(
                [
                    'status' => false,
                    'result' => $this->upload->display_errors()
                ]
            );
            // $this->session->set_flashdata('notif', '<div class="alert alert-danger"><b>PROSES IMPORT GAGAL!</b> '.$this->upload->display_errors().'</div>');
            // //redirect halaman
            // redirect('import/');

        } else {

            $data_upload = $this->upload->data();

            $excelreader     = new PHPExcel_Reader_Excel2007();
            $loadexcel         = $excelreader->load('excel/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
            $sheet             = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

            $data = array();

            $numrow = 1;
            foreach($sheet as $row){
                            if($numrow > 1){
                                array_push($data, array(
                                    'npm' => $row['A'],
                                    'nama'      => $row['B'],
                                    'prodi'      => $row['C'],
                                    'semester'      => $row['D'],
                                    'beasiswa'      => $row['E'],
                                    'periode'      => $row['F'],
                                ));
                    }
                $numrow++;
            }
            $this->db->insert_batch('mahasiswa', $data);
            //delete file from server
            unlink(realpath('excel/'.$data_upload['file_name']));

            //upload success
            $this->response(
                [
                    'status' => true,
                    'result' => "Success Upload data"
                ]
            );
            // $this->session->set_flashdata('notif', '<div class="alert alert-success"><b>PROSES IMPORT BERHASIL!</b> Data berhasil diimport!</div>');
            //redirect halaman
            redirect('import/');

        }
    }

    public function export_get()
     {
        $where = "";
        $npm = "";
          $semua_pengguna = $this->Beasiswa->list($where, $npm);

          $spreadsheet = new Spreadsheet;

          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('A1', 'No')
                      ->setCellValue('B1', 'NPM')
                      ->setCellValue('C1', 'Nama')
                      ->setCellValue('D1', 'Prodi')
                      ->setCellValue('E1', 'Fakultas')
                      ->setCellValue('F1', 'Semester')
                      ->setCellValue('G1', 'Beasiswa')
                      ->setCellValue('H1', 'Periode');

          $kolom = 2;
          $nomor = 1;
          foreach($semua_pengguna as $pengguna) {

               $spreadsheet->setActiveSheetIndex(0)
                           ->setCellValue('A' . $kolom, $nomor)
                           ->setCellValue('B' . $kolom, $pengguna->npm)
                           ->setCellValue('C' . $kolom, $pengguna->nama)
                           ->setCellValue('D' . $kolom, $pengguna->prodi_nama)
                           ->setCellValue('E' . $kolom, $pengguna->fakultas_nama)
                           ->setCellValue('F' . $kolom, $pengguna->semester)
                           ->setCellValue('G' . $kolom, $pengguna->beasiswa)
                           ->setCellValue('H' . $kolom, $pengguna->periode);

               $kolom++;
               $nomor++;

          }

          $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Latihan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


}