<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pdf_test extends CI_Controller
{
    public function index()
    {
        $this->load->library('pdf');

        $this->pdf->loadHtml('<h1>Halo Dunia!</h1>');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("contoh.pdf", array("Attachment" => 0));
    }
}