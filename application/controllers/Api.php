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

    public function import_post()
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

    public function export_get(){
        // Load plugin PHPExcel nya
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        // Panggil class PHPExcel nya
        $excel = new PHPExcel();
        // Settingan awal fil excel
        $excel->getProperties()->setCreator('My Notes Code')
                     ->setLastModifiedBy('My Notes Code')
                     ->setTitle("Data Siswa")
                     ->setSubject("Siswa")
                     ->setDescription("Laporan Semua Data Siswa")
                     ->setKeywords("Data Siswa");
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
          'font' => array('bold' => true), // Set font nya jadi bold
          'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
          'alignment' => array(
            'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
          ),
          'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
          )
        );
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA MAHASISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $excel->getActiveSheet()->mergeCells('A1:H1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B3', "NPM"); // Set kolom B3 dengan tulisan "NIS"
        $excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
        $excel->setActiveSheetIndex(0)->setCellValue('D3', "PRODI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $excel->setActiveSheetIndex(0)->setCellValue('E3', "FAKULTAS"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('F3', "SEMESTER"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('G3', "BEASISWA"); // Set kolom E3 dengan tulisan "ALAMAT"
        $excel->setActiveSheetIndex(0)->setCellValue('H3', "PERIODE"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $npm = $this->input->get('npm');
        
        $where= array(
            'npm' => $npm
        );
        $mahasiswa = $this->Beasiswa->list($where, $npm);
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($mahasiswa as $data){ // Lakukan looping pada variabel siswa
          $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
          $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['npm']);
          $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama']);
          $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['prodi_nama']);
          $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['fakultas_nama']);
          $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['semester']);
          $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['beasiswa']);
          $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['periode']);
          
          // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
          $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
          $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
          
          $no++; // Tambah 1 setiap kali looping
          $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20); // Set width kolom E
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Data Siswa");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
      }


}