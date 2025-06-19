<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Manage extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dtks_model', 'dtks');
	}

	public function index()
	{
		cek_session();
		$data['title'] = "DTKS";
		$data['subtitle'] = "Kelola DTKS";
		$this->template->load('home/layouts', 'manage/vList', $data);
	}

	public function edit()
	{
		cek_session();
		$id = $this->uri->segment(4);
		$data['title'] = "Edit DTKS";
		$data['subtitle'] = "DTKS > Edit";
		$data['get'] = $this->dtks->get_by_id($id);
		$this->template->load('home/layouts', 'manage/vEdit', $data);
	}

	public function add()
	{
		cek_session();
		$data['title'] = "DTKS";
		$data['subtitle'] = "Tambah DTKS";
		$this->template->load('home/layouts', 'manage/vAdd', $data);
	}

	public function ajax_list()
	{
		cek_session();
		$list = $this->dtks->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $dtks) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $dtks->nik;
            $row[] = $dtks->status;
			$row[] = '<a href="' . base_url() . 'dtks/manage/edit/' . $dtks->id . '" class="btn btn-sm btn-warning mr-1"><i class="ri-edit-2-line"></i> Edit</a>
					  <a href="#" class="btn btn-danger btn-sm" onclick="delete_(' . "'" . $dtks->id . "'" . ')"><i class="ri-delete-bin-2-line"></i> Hapus</a>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->dtks->count_all(),
			"recordsFiltered" => $this->dtks->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

    public function ajax_reset_all() {
    // Hapus semua data dari tabel tbl_status_dtks
    $this->db->empty_table('tbl_status_dtks');
    
    // Atau jika ingin menggunakan delete:
    // $this->db->delete('tbl_status_dtks');
    
    echo json_encode(array("status" => TRUE));
}

	public function save()
{
	cek_session();
	
	$nik = $this->input->post('nik', TRUE);
	$status = $this->input->post('status', TRUE);

	// Validasi NIK tidak boleh kosong
	if (empty($nik)) {
		redirect(base_url('dtks/manage?alert=error&message=' . urlencode('NIK tidak boleh kosong')));
		return;
	}

	// Cek apakah NIK sudah ada di database
	$this->db->where('nik', $nik);
	$existing = $this->db->get('tbl_status_dtks')->row();

	if ($existing) {
		redirect(base_url('dtks/manage?alert=error&message=' . urlencode('NIK sudah terdaftar')));
		return;
	}

	// Data yang akan disimpan
	$data = array(
		'nik' => $nik,
		'status' => $status
	);

	$result = $this->dtks->save($data);

	if ($result) {
		redirect(base_url('dtks/manage?alert=success&message=' . urlencode('Berhasil Tambah Data')));
	} else {
		redirect(base_url('dtks/manage?alert=error&message=' . urlencode('Gagal Tambah Data')));
	}
}


	public function update()
	{
		cek_session();

		// Validasi NIK tidak boleh kosong
		$nik = $this->input->post('nik', TRUE);
        $status = $this->input->post('status', TRUE);
		if(empty($nik)) {
			redirect(base_url('dtks/manage?alert=error&message=' . urlencode('NIK tidak boleh kosong')));
			return;
		}

		$data = array(
			'nik' => $nik,
            'status' => $status
		);

		$result = $this->dtks->update(array('id' => $this->input->post('id')), $data);

		if($result > 0) {
			redirect(base_url('dtks/manage?alert=info&message=' . urlencode('Berhasil Update Data')));
		} else {
			redirect(base_url('dtks/manage?alert=error&message=' . urlencode('Gagal Update Data')));
		}
	}

	public function ajax_delete($id)
	{
		cek_session();
		$this->dtks->delete_by_id($id);
		echo json_encode(array("status" => TRUE, "alert" => "danger", "message" => "Berhasil Hapus Data"));
	}

public function import()
{
    cek_session();
    
    // Buat folder upload jika belum ada
    if (!is_dir('./uploads/temp/')) {
        mkdir('./uploads/temp/', 0777, true);
    }
    
    $config['upload_path'] = './uploads/temp/';
    $config['allowed_types'] = 'xlsx|xls|csv|sql';
    $config['max_size'] = 5120; // 5MB
    $config['encrypt_name'] = TRUE;
    
    $this->load->library('upload', $config);
    
    if (!$this->upload->do_upload('import_file')) {
        $error = $this->upload->display_errors();
        $this->session->set_flashdata('alert', 'error');
        $this->session->set_flashdata('message', strip_tags($error));
        redirect(base_url('dtks/manage/add'));
        return;
    }
    
    $file_data = $this->upload->data();
    $file_path = $file_data['full_path'];
    $file_ext = strtolower($file_data['file_ext']);
    
    // Load model jika belum di-load
    $this->load->model('dtks_model', 'dtks');
    
    $imported = 0;
    $errors = 0;
    $duplicates = 0;
    $error_details = array();
    
    try {
        if ($file_ext == '.csv') {
            $result = $this->import_csv($file_path);
        } elseif ($file_ext == '.xlsx' || $file_ext == '.xls') {
            $result = $this->import_excel($file_path);
        } elseif ($file_ext == '.sql') {
            $result = $this->import_sql($file_path);
        } else {
            throw new Exception('Format file tidak didukung');
        }
        
        $imported = $result['imported'];
        $errors = $result['errors'];
        $duplicates = $result['duplicates'];
        $error_details = isset($result['error_details']) ? $result['error_details'] : array();
        
    } catch (Exception $e) {
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $this->session->set_flashdata('alert', 'error');
        $this->session->set_flashdata('message', 'Error: ' . $e->getMessage());
        redirect(base_url('dtks/manage/add'));
        return;
    }
    
    // Delete uploaded file
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    $total_processed = $imported + $errors + $duplicates;
    $message = "Import selesai! Total data: {$total_processed}, Berhasil: {$imported}, Error: {$errors}, Duplikat: {$duplicates}";
    if (!empty($error_details)) {
        $message .= "\nDetail error: " . implode(', ', array_slice($error_details, 0, 5));
        if (count($error_details) > 5) {
            $message .= " dan " . (count($error_details) - 5) . " error lainnya";
        }
    }
    
    $alert_type = ($errors > 0) ? 'warning' : 'success';
    $this->session->set_flashdata('alert', $alert_type);
    $this->session->set_flashdata('message', $message);
    redirect(base_url('dtks/manage'));
}

private function import_csv($file_path)
{
    $has_header = $this->input->post('has_header') ? true : false;
    $ignore_duplicate = $this->input->post('ignore_duplicate') ? true : false;
    
    $imported = 0;
    $errors = 0;
    $duplicates = 0;
    $error_details = array();
    
    // Debug: Log file path
    log_message('debug', 'Importing CSV file: ' . $file_path);
    
    // Cek apakah file bisa dibaca
    if (!file_exists($file_path) || !is_readable($file_path)) {
        throw new Exception('File CSV tidak dapat dibaca');
    }
    
    // Baca file dengan berbagai encoding
    $file_content = file_get_contents($file_path);
    
    // Detect encoding dan konversi ke UTF-8 jika perlu
    $encoding = mb_detect_encoding($file_content, ['UTF-8', 'UTF-16', 'Windows-1252', 'ISO-8859-1'], true);
    if ($encoding && $encoding !== 'UTF-8') {
        $file_content = mb_convert_encoding($file_content, 'UTF-8', $encoding);
        file_put_contents($file_path, $file_content);
    }
    
    // Baca file CSV dengan delimiter semicolon (;)
    if (($handle = fopen($file_path, "r")) !== FALSE) {
        $row_num = 0;
        $processed_niks = array(); // Track NIK yang sudah diproses untuk mencegah duplikat dalam file yang sama
        
        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) { // Ubah delimiter dari "," ke ";"
            $row_num++;
            
            // Skip header jika ada
            if ($has_header && $row_num == 1) {
                log_message('debug', 'Skipping header row: ' . implode(';', $data));
                continue;
            }
            
            // Debug: Log raw data
            log_message('debug', 'Row ' . $row_num . ' raw data: ' . print_r($data, true));
            
            // Pastikan kolom NIK ada (kolom kedua = index 1)
            if (!isset($data[1]) || $data[1] === null || trim($data[1]) === '') {
                $errors++;
                $error_details[] = "Baris {$row_num}: NIK kosong atau tidak ditemukan";
                log_message('debug', 'Row ' . $row_num . ': Empty NIK');
                continue;
            }
            
            $nik = trim($data[1]);
            
            // Ambil status dari kolom C (index 2) - optional
            $status = isset($data[2]) ? trim($data[2]) : '';
            
            // Debug: Log NIK dan status yang sedang diproses
            log_message('debug', 'Processing NIK: ' . $nik . ', Status: ' . $status . ' (row: ' . $row_num . ')');
            
            // Hapus karakter non-numeric dan format separator dari NIK
            $nik = preg_replace('/[^0-9]/', '', $nik);
            
            // Validasi panjang NIK
            if (strlen($nik) != 16) {
                $errors++;
                $error_details[] = "Baris {$row_num}: NIK harus 16 digit (ditemukan: '" . $nik . "', panjang: " . strlen($nik) . ")";
                log_message('debug', 'Row ' . $row_num . ': Invalid NIK length - ' . $nik);
                continue;
            }
            
            // Validasi NIK tidak boleh semua nol
            if ($nik === '0000000000000000') {
                $errors++;
                $error_details[] = "Baris {$row_num}: NIK tidak valid (semua nol)";
                continue;
            }
            
            // Cek duplikat dalam file yang sama
            if (in_array($nik, $processed_niks)) {
                $duplicates++;
                $error_details[] = "Baris {$row_num}: NIK duplikat dalam file ({$nik})";
                continue;
            }
            
            // Cek duplikat di database
            if ($this->check_nik_exists($nik)) {
                if ($ignore_duplicate) {
                    $duplicates++;
                    log_message('debug', 'NIK already exists, ignoring: ' . $nik);
                    continue;
                } else {
                    $errors++;
                    $error_details[] = "Baris {$row_num}: NIK sudah ada di database ({$nik})";
                    continue;
                }
            }
            
            // Tambahkan ke processed NIKs
            $processed_niks[] = $nik;
            
            // Insert NIK dengan status
            if ($this->insert_nik($nik, $status)) {
                $imported++;
                log_message('debug', 'Successfully imported NIK: ' . $nik . ' with status: ' . $status);
            } else {
                $errors++;
                $error_details[] = "Baris {$row_num}: Gagal menyimpan NIK ({$nik})";
                log_message('error', 'Failed to import NIK: ' . $nik);
            }
        }
        
        fclose($handle);
        log_message('debug', 'CSV import completed. Total rows processed: ' . ($row_num - ($has_header ? 1 : 0)));
    } else {
        throw new Exception('Tidak dapat membaca file CSV');
    }
    
    return array(
        'imported' => $imported, 
        'errors' => $errors, 
        'duplicates' => $duplicates,
        'error_details' => $error_details
    );
}

private function import_excel($file_path)
{
    // Cek apakah PhpSpreadsheet tersedia
    $autoload_paths = [
        APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php',
        APPPATH . 'libraries/PhpSpreadsheet/vendor/autoload.php',
        FCPATH . 'vendor/autoload.php', // Jika menggunakan Composer global
        APPPATH . 'third_party/vendor/autoload.php'
    ];
    
    $loaded = false;
    foreach ($autoload_paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            $loaded = true;
            log_message('debug', 'PhpSpreadsheet loaded from: ' . $path);
            break;
        }
    }
    
    if (!$loaded) {
        // Coba load manual jika autoload tidak tersedia
        $manual_paths = [
            APPPATH . 'third_party/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php',
            APPPATH . 'libraries/PhpSpreadsheet/src/PhpSpreadsheet/IOFactory.php'
        ];
        
        foreach ($manual_paths as $path) {
            if (file_exists($path)) {
                require_once $path;
                $loaded = true;
                break;
            }
        }
    }
    
    if (!$loaded || !class_exists('\PhpOffice\PhpSpreadsheet\IOFactory')) {
        throw new Exception('PhpSpreadsheet library tidak ditemukan. Pastikan library sudah diinstall.');
    }
    
    $ignore_duplicate = $this->input->post('ignore_duplicate') ? true : false;
    
    $imported = 0;
    $errors = 0;
    $duplicates = 0;
    $error_details = array();
    $processed_niks = array();
    
    try {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($file_path);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $spreadsheet = $reader->load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        
        $highestRow = $worksheet->getHighestRow();
        log_message('debug', 'Excel file loaded. Highest row: ' . $highestRow);
        
        // Mulai dari baris 2 (anggap baris 1 adalah header)
        $startRow = 2;
        
        for ($row = $startRow; $row <= $highestRow; $row++) {
            // Ambil NIK dari kolom B
            $nikValue = $worksheet->getCell('B' . $row)->getCalculatedValue();
            // Ambil status dari kolom C
            $statusValue = $worksheet->getCell('C' . $row)->getCalculatedValue();
            
            // Debug: Log cell values
            log_message('debug', 'Row ' . $row . ' - NIK (B): ' . var_export($nikValue, true) . ', Status (C): ' . var_export($statusValue, true));
            
            // Skip jika NIK kosong
            if ($nikValue === null || $nikValue === '' || $nikValue === 0) {
                log_message('debug', 'Row ' . $row . ': Empty NIK in cell B, skipping');
                continue;
            }
            
            // Konversi NIK ke string
            if (is_numeric($nikValue)) {
                // Hindari scientific notation
                $nik = number_format($nikValue, 0, '', '');
            } else {
                $nik = trim((string)$nikValue);
            }
            
            // Konversi status ke string
            $status = '';
            if ($statusValue !== null && $statusValue !== '') {
                $status = trim((string)$statusValue);
            }
            
            // Debug: Log NIK dan status yang sedang diproses
            log_message('debug', 'Processing from Excel row ' . $row . ' - NIK: ' . $nik . ', Status: ' . $status);
            
            // Hapus karakter non-numeric dari NIK
            $nik = preg_replace('/[^0-9]/', '', $nik);
            
            if (strlen($nik) != 16) {
                $errors++;
                $error_details[] = "Baris {$row}: NIK harus 16 digit (ditemukan: '{$nik}', panjang: " . strlen($nik) . ")";
                log_message('debug', 'Row ' . $row . ': Invalid NIK length - ' . $nik);
                continue;
            }
            
            // Validasi NIK tidak boleh semua nol
            if ($nik === '0000000000000000') {
                $errors++;
                $error_details[] = "Baris {$row}: NIK tidak valid (semua nol)";
                continue;
            }
            
            // Cek duplikat dalam file yang sama
            if (in_array($nik, $processed_niks)) {
                $duplicates++;
                $error_details[] = "Baris {$row}: NIK duplikat dalam file ({$nik})";
                continue;
            }
            
            // Cek duplikat di database
            if ($this->check_nik_exists($nik)) {
                if ($ignore_duplicate) {
                    $duplicates++;
                    log_message('debug', 'NIK already exists, ignoring: ' . $nik);
                    continue;
                } else {
                    $errors++;
                    $error_details[] = "Baris {$row}: NIK sudah ada di database ({$nik})";
                    continue;
                }
            }
            
            // Tambahkan ke processed NIKs
            $processed_niks[] = $nik;
            
            // Insert NIK dengan status
            if ($this->insert_nik($nik, $status)) {
                $imported++;
                log_message('debug', 'Successfully imported NIK from Excel: ' . $nik . ' with status: ' . $status);
            } else {
                $errors++;
                $error_details[] = "Baris {$row}: Gagal menyimpan NIK ({$nik})";
                log_message('error', 'Failed to import NIK from Excel: ' . $nik);
            }
        }
        
        log_message('debug', 'Excel import completed. Rows processed: ' . ($highestRow - $startRow + 1));
        
    } catch (Exception $e) {
        log_message('error', 'Excel import error: ' . $e->getMessage());
        throw new Exception('Error membaca file Excel: ' . $e->getMessage());
    }
    
    return array(
        'imported' => $imported, 
        'errors' => $errors, 
        'duplicates' => $duplicates,
        'error_details' => $error_details
    );
}

private function import_sql($file_path)
{
    $sql_content = file_get_contents($file_path);
    
    if (empty($sql_content)) {
        throw new Exception('File SQL kosong');
    }
    
    $ignore_duplicate = $this->input->post('ignore_duplicate') ? true : false;
    
    $imported = 0;
    $errors = 0;
    $duplicates = 0;
    $error_details = array();
    $processed_niks = array();
    
    // Pattern yang lebih fleksibel untuk menangkap INSERT statements
    $patterns = [
        '/INSERT\s+INTO\s+`?tbl_status_dtks`?\s*\([^)]*\)\s*VALUES\s*\(([^)]+)\)/i',
        '/INSERT\s+INTO\s+`?dtks`?\s*\([^)]*\)\s*VALUES\s*\(([^)]+)\)/i',
        '/INSERT\s+INTO\s+`?tbl_status_dtks`?\s+VALUES\s*\(([^)]+)\)/i'
    ];
    
    $all_matches = array();
    foreach ($patterns as $pattern) {
        preg_match_all($pattern, $sql_content, $matches);
        if (!empty($matches[1])) {
            $all_matches = array_merge($all_matches, $matches[1]);
        }
    }
    
    if (empty($all_matches)) {
        throw new Exception('Tidak ditemukan INSERT statement yang valid untuk tabel tbl_status_dtks atau dtks');
    }
    
    log_message('debug', 'Found ' . count($all_matches) . ' INSERT statements in SQL file');
    
    foreach ($all_matches as $index => $values) {
        $line_num = $index + 1;
        
        // Bersihkan values
        $values = trim($values);
        log_message('debug', 'Processing SQL values: ' . $values);
        
        // Parse values dengan lebih robust
        $nik = null;
        $status = '';
        
        // Method 1: Coba parse dengan str_getcsv
        $parts = str_getcsv($values, ',', '"');
        if (count($parts) >= 3) {
            // Format: id, nik, status
            $nik = trim($parts[1], '\'"');
            $status = trim($parts[2], '\'"');
        } elseif (count($parts) >= 2) {
            // Format: nik, status (tanpa id auto increment)
            $nik = trim($parts[0], '\'"');
            $status = trim($parts[1], '\'"');
        } elseif (count($parts) >= 1) {
            // Jika hanya 1 kolom, mungkin itu NIK
            $nik = trim($parts[0], '\'"');
        }
        
        // Method 2: Jika method 1 gagal, coba regex untuk NIK
        if (empty($nik)) {
            if (preg_match('/[\'"](\d{16})[\'"]/', $values, $match)) {
                $nik = $match[1];
            }
        }
        
        if (empty($nik)) {
            $errors++;
            $error_details[] = "Baris {$line_num}: Tidak dapat mengekstrak NIK dari values: {$values}";
            continue;
        }
        
        // Hapus karakter non-numeric dari NIK
        $nik = preg_replace('/[^0-9]/', '', $nik);
        
        if (strlen($nik) != 16) {
            $errors++;
            $error_details[] = "Baris {$line_num}: NIK harus 16 digit (ditemukan: '{$nik}', panjang: " . strlen($nik) . ")";
            continue;
        }
        
        // Validasi NIK tidak boleh semua nol
        if ($nik === '0000000000000000') {
            $errors++;
            $error_details[] = "Baris {$line_num}: NIK tidak valid (semua nol)";
            continue;
        }
        
        // Cek duplikat dalam file yang sama
        if (in_array($nik, $processed_niks)) {
            $duplicates++;
            $error_details[] = "Baris {$line_num}: NIK duplikat dalam file ({$nik})";
            continue;
        }
        
        // Cek duplikat di database
        if ($this->check_nik_exists($nik)) {
            if ($ignore_duplicate) {
                $duplicates++;
                continue;
            } else {
                $errors++;
                $error_details[] = "Baris {$line_num}: NIK sudah ada di database ({$nik})";
                continue;
            }
        }
        
        // Tambahkan ke processed NIKs
        $processed_niks[] = $nik;
        
        // Insert NIK dengan status
        if ($this->insert_nik($nik, $status)) {
            $imported++;
            log_message('debug', 'Successfully imported NIK from SQL: ' . $nik . ' with status: ' . $status);
        } else {
            $errors++;
            $error_details[] = "Baris {$line_num}: Gagal menyimpan NIK ({$nik})";
        }
    }
    
    return array(
        'imported' => $imported, 
        'errors' => $errors, 
        'duplicates' => $duplicates,
        'error_details' => $error_details
    );
}

// Helper methods untuk database operations
private function check_nik_exists($nik)
{
    try {
        // Method 1: Gunakan model jika tersedia
        if (isset($this->dtks) && method_exists($this->dtks, 'get_by_nik')) {
            $result = $this->dtks->get_by_nik($nik);
            return !empty($result);
        }
        
        // Method 2: Query langsung ke database
        $this->db->where('nik', $nik);
        $query = $this->db->get('tbl_status_dtks');
        return $query->num_rows() > 0;
        
    } catch (Exception $e) {
        log_message('error', 'Error checking NIK exists: ' . $e->getMessage());
        return false;
    }
}

private function insert_nik($nik, $status = '')
{
    try {
        $data = array(
            'nik' => $nik,
            'status' => $status
        );
        
        // Debug: Log data yang akan diinsert
        log_message('debug', 'Inserting data: ' . print_r($data, true));
        
        // Method 1: Gunakan model jika tersedia
        if (isset($this->dtks) && method_exists($this->dtks, 'save')) {
            $result = $this->dtks->save($data);
            if ($result) {
                log_message('debug', 'Data inserted via model - NIK: ' . $nik . ', Status: ' . $status);
                return true;
            } else {
                log_message('error', 'Model save failed for NIK: ' . $nik);
                return false;
            }
        }
        
        // Method 2: Insert langsung ke database
        $result = $this->db->insert('tbl_status_dtks', $data);
        if ($result) {
            log_message('debug', 'Data inserted directly to DB - NIK: ' . $nik . ', Status: ' . $status);
            return true;
        } else {
            log_message('error', 'Direct DB insert failed for NIK: ' . $nik . ' - Error: ' . $this->db->error()['message']);
            return false;
        }
        
    } catch (Exception $e) {
        log_message('error', 'Error inserting NIK ' . $nik . ': ' . $e->getMessage());
        return false;
    }
}
}