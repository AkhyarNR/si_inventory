<?php
    $tgl = date("d - m - Y");
    $this->load->library('pdf');
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); 
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Laporan Admin');
  
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' Laporan ', PDF_HEADER_STRING, array(70, 70, 70), array(70, 70, 70));
    $pdf->setFooterData(K_TIMEZONE, array(0,64,0), array(0,64,128)); 
  
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
  
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 
  
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);    
  
    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); 
  
    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
  
    // set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }   

    $pdf->setFontSubsetting(true);   
    $pdf->SetFont('times', '', 12, '', true);

    $pdf->AddPage();

    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    $html = <<<EOD
    <h1>
    Laporan Data Peminjaman Barang SI Inventori LAB.RPL
    </h1>
     
EOD;
    $pdf->Ln(4);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, 'C', true);
    $pdf->Ln(4);
    $tglAw=$this->session->userdata('tglAwal');
    $tglAk=$this->session->userdata('tglAkhir');
    $table = '<p align="left"> Periode : '.date('d M Y',strtotime($tglAw)).' s/d '.date('d M Y',strtotime($tglAk)).'</p> <table border="1"  cellpadding="0" cellspacing="3" align="center" fontsize="12">';
        $table .= '
            <tr style="background-color:#FFFF00;color:#000000;">
            <th width="30">No</th>
            <th colspan="1" width="70">Nama Peminjam</th>
            <th colspan="1" width="70">Kode Barang</th>
            <th colspan="1" width="100">Nama Barang</th>
            <th colspan="1" width="50">Jumlah</th>
            <th colspan="1" width="70">Tanggal Pinjam</th>
            <th colspan="1" width="70">Tanggal Kembali</th>
            <th colspan="1" width="80">Spesifikasi</th>
            <th colspan="1" width="100">Status Peminjaman</th>
            </tr>
            ';
        $no=1;
        foreach($dataPinjam as $keluar){
        $table .='
            <tr>
            <td width="30">'.$no.'</td>
            <td colspan="1" width="70">'.$keluar->nama_peminjam.'</td>
            <td colspan="1" width="70">'.$keluar->kode_barang.'</td>
            <td colspan="1" width="100">'.$keluar->nama_barang.'</td>
            <th colspan="1" width="50">'.$keluar->jumlah.'</th>
            <td colspan="1" width="70">'.$keluar->tanggal_pinjam.'</td>
            <td colspan="1" width="70">'.$keluar->tanggal_kembali.'</td>
            <td colspan="1" width="80">'.$keluar->spesifikasi.'</td>
            <td colspan="1" width="100">'.$keluar->status_pinjam.'</td>
            </tr>';
        $no++;
        }
        
    $table .= '</table>';

    $pdf->writeHTMLCell(0, 0, 10, 50, $table, '', 1, 0, true, 'L'); 
    $pdf->Ln(30);

    $ttd = '<p>Administrator, </p>
    <p>Jember, '.$tgl.'</p>
    <br>
    <p></p>
    <B> '.ucfirst(0).' </B>';

    $pdf->writeHTMLCell(0, 0, '', '', $ttd, 0, 1, 0, true, 'R', true);
    $pdf->LastPage();

    $pdf->Output('Laporan_BarangKeluar.pdf', 'I'); 
?>

