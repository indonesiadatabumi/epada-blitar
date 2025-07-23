<?php
die('xx');
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once "../../config/superglobal_var.php";
include_once "../../config/db_connect.php";
include_once ($_DOCUMENT_ROOT."/classes/functions.php"); 
 
$f = new functions;


$data = json_decode(file_get_contents("php://input"));

$kode_billing =  $_GET['nop'];
$merchant_channel =  $_GET['Merchant'];
$bank_id    = '01';
$KodeRek = '4110111';


// var_dump($_GET['nop']);
  
$sql="select a.kd_booking,to_char(a.tgl_rekam,'dd') hari ,to_char(a.tgl_rekam,'mm') masa , to_char(a.tgl_rekam,'yyyy') tahun,a.tgl_rekam,status_booking,
status_bayar,bphtb_yg_harus_dibayar,b.nm_pembeli, b.alamat_pembeli, to_char(c.expire_time,'ddmmyyyy') expire_time from ebphtb.tbl_data_transaksi a
left join ebphtb.tbl_pembeli b on a.kd_booking=b.kd_booking 
join tbl_booking c on a.kd_booking = c.kd_booking 
where a.kd_booking='$kode_billing' and a.status_booking='1'";
 

//  echo $sql;

$result=$db->Execute($sql);
$row=$result->FetchRow();
if(is_array($row)){
    foreach($row as $key=>$val){
        $key=strtolower($key);
        $$key=$val;
    }

} 

 $bphtb_yg_harus_dibayar = (int) $bphtb_yg_harus_dibayar;

if($status_bayar=='1'){
    $response_code	="13";
    $message	    ="DATA TAGIHAN TELAH LUNAS";
    
}elseif($status_booking=='2'){
    $response_code	="10";
    $message	    ="DATA TAGIHAN TIDAK DITEMUKAN";
}elseif(empty($kd_booking)){
    $response_code	= "10";
    $message	    = "DATA TAGIHAN TIDAK DITEMUKAN";
}else{
    $response_code	= "00";
    $message	    = "Success";
    $nama_wp	    = $nm_pembeli;
    $alamat	        = $alamat_pembeli;
    $masa_pajak	    = $masa;
    $tahun_pajak    = $tahun;
    $jumlah_bayar   = $bphtb_yg_harus_dibayar;
    $tanggal_booking=$tgl_rekam;
	$tanggal_jatuh_tempo = date('Y-m-d', 1);
    
    $tanggal_booking=preg_replace("/(:|[\s]+|-)/","",$tanggal_booking);
    $tanggal_expired= $expire_time;
}
 
    $transaction_id = date("YmdHis").rand("1000","9999");
    $remote_addr    = $_SERVER['REMOTE_ADDR'];
	
    if(empty($response_code)) $response_code='00';
    $f->log_ws("billing_code_inquiry","BANK_ID:$bank_id;;KODE_BILLING:$kode_billing;;RESPONSE:$response_code;;TRANSACTION_id:$transaction_id;;NAMA_WP:$nama_wp;;JUMLAH_BAYAR::$jumlah_bayar;;TANGGAL_BOOKING:$tanggal_booking;;TANGGAL_EXPIRED:$tanggal_expired;;MESSAGE:$message;;");

    $sql="insert into ebphtb.tbl_ws_log (fungsi,tanggal,kode_billing,ip,bank_id,merchant_channel,response_code,message,transaction_id)
		values ('bphtb_inquiry',sysdate,'$kode_billing','$remote_addr','$bank_id','$merchant_channel','$response_code','$message','$transaction_id')";
    
    $result=$db->Execute($sql);
	if(!$result) print $db->ErrorMsg();
    
    $arr_stat = array();
    $arr_stat['IsError'] = "False";
    $arr_stat['ResponseCode'] = $response_code;
    $arr_stat['ErrorDesc'] = $message;

    if($response_code=='00'){
    $array_rest = ['Nop'=> $kode_billing, 'Nama'  => $nama_wp, 'Alamat' => $alamat ,
        'Masa' => $masa_pajak, 'Tahun' => $tahun_pajak,'NoSk' => $transaction_id,'JatuhTempo'  => $tanggal_jatuh_tempo ,'KodeRek' => $KodeRek,'Pokok' => $jumlah_bayar ,
        'Denda'  => 0,'Total' => $jumlah_bayar,'Status'=>$arr_stat];
	}else{	
	 $array_rest = ['Status'=>$arr_stat];
	}
    echo json_encode($array_rest,JSON_UNESCAPED_SLASHES);
    
     