<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
    }

    public function index()
    {
        // Redirect ke method run atau tampilkan informasi
        echo "Migration Controller. Gunakan /migration/run atau /migration/latest untuk menjalankan migrasi.";
    }

    public function run()
    {
        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration berhasil dijalankan.";
        }
    }

    public function latest()
    {
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration ke versi terbaru berhasil dijalankan.";
        }
    }
}
