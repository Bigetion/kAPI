<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');

class sertifikat extends Controller {
	
	function getSertifikatBerlaku(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_produk",[
			"[>]tabel_perusahaan"=>"id_perusahaan",
			"[>]tabel_sni"=>"no_SNI"
		],[
			"tabel_perusahaan.nama_penanggung_jawab",
			"tabel_perusahaan.alamat_penanggung_jawab",
			"tabel_sni.judul_SNI",
			"tabel_produk.id_merk",
			"tabel_produk.jenis_produk",
			"tabel_produk.merk",
			"tabel_produk.no_SNI",
			"tabel_produk.no_sertifikat",
			"tabel_produk.no_lisensi",
			"tabel_produk.tgl_terbit_sertifikat",
			"tabel_produk.tgl_berakhir_sertifikat",
		],["#tabel_produk.tgl_berakhir_sertifikat[>=]"=>"NOW()"]);

		$this->render->json($data);
	}

	function getSertifikatTidakBerlaku(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_produk",[
			"[>]tabel_perusahaan"=>"id_perusahaan",
			"[>]tabel_sni"=>"no_SNI"
		],[
			"tabel_perusahaan.nama_penanggung_jawab",
			"tabel_perusahaan.alamat_penanggung_jawab",
			"tabel_sni.judul_SNI",
			"tabel_produk.id_merk",
			"tabel_produk.jenis_produk",
			"tabel_produk.merk",
			"tabel_produk.no_SNI",
			"tabel_produk.no_sertifikat",
			"tabel_produk.no_lisensi",
			"tabel_produk.tgl_terbit_sertifikat",
			"tabel_produk.tgl_berakhir_sertifikat",
		],["#tabel_produk.tgl_berakhir_sertifikat[<]"=>"NOW()"]);

		$this->render->json($data);
	}

	function getData(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_produk",[
			"[>]tabel_perusahaan"=>"id_perusahaan",
			"[>]tabel_sni"=>"no_SNI"
		],[
			"tabel_perusahaan.id_perusahaan",
			"tabel_perusahaan.nama_penanggung_jawab",
			"tabel_perusahaan.alamat_penanggung_jawab",
			"tabel_perusahaan.provinsi",
			"tabel_perusahaan.kota",
			"tabel_perusahaan.kode_pos",
			"tabel_perusahaan.status",
			"tabel_perusahaan.telp",
			"tabel_perusahaan.website",
			"tabel_perusahaan.email",
			"tabel_sni.judul_SNI",
			"tabel_produk.id_merk",
			"tabel_produk.jenis_produk",
			"tabel_produk.nama_produk",
			"tabel_produk.merk",
			"tabel_produk.tipe_produk",
			"tabel_produk.nama_pabrik",
			"tabel_produk.no_SNI",
			"tabel_produk.status_penerapan",
			"tabel_produk.skema_sertifikasi",
			"tabel_produk.no_sertifikat",
			"tabel_produk.no_lisensi",
			"tabel_produk.tgl_terbit_sertifikat",
			"tabel_produk.tgl_berakhir_sertifikat",
		]);
		$this->render->json($data);
	}

	function getPerusahaanOptions(){
		$data['data'] = $this->db->select("tabel_perusahaan","*");
		$this->render->json($data);
	}
		
	function getSNIOptions(){
		$data['data'] = $this->db->select("tabel_sni","*");
		$this->render->json($data);
	}
	
	// function submitAddSertifikat(){
	// 	$post_data = $this->render->json_post();
		
	// 	$data_perusahaan = array(
	// 	"nama_penanggung_jawab"		=> $post_data["namaPJProduk"],
	// 	"alamat_penanggung_jawab"	=> $post_data["alamatPJProduk"],
	// 	"provinsi"					=> $post_data["provinsi"],
	// 	"kota"						=> $post_data["kabupaten"],
	// 	"kode_pos"					=> $post_data["kodePos"],
	// 	"status"					=> $post_data["statusPJProduk"],
	// 	"telp"						=> $post_data["nomorTelpon"],
	// 	"website"					=> $post_data["website"],
	// 	"email"						=> $post_data["email"],
	// 	);
		
	// 	if($this->db->insert("tabel_perusahaan", $data_perusahaan)){
			
	// 		$data_produk = array(
	// 		"jenis_produk"				=> $post_data["jenisProduk"],
	// 		"nama_produk"				=> $post_data["namaProduk"],
	// 		"merk"						=> $post_data["merk"],
	// 		"tipe_produk"				=> $post_data["tipeProduk"],
	// 		"id_perusahaan"				=> $post_data["pJProduk"],
	// 		"nama_pabrik"				=> $post_data["namaPabrik"],
	// 		"no_SNI"					=> $post_data["noSNI"],
	// 		"status_penerapan"			=> $post_data["statusPenerapan"],
	// 		"skema_sertifikasi"			=> $post_data["skemaSertifikasi"],
	// 		"no_sertifikat"				=> $post_data["nomorSertifikat"],
	// 		"tgl_terbit_sertifikat"		=> $post_data["tanggalTerbit"],
	// 		"tgl_berakhir_sertifikat"	=> $post_data["tanggalBerakhir"]
	// 		);
			
	// 		if($this->db->insert("tabel_produk", $data_produk)){
	// 			$this->set->success_message(true, array("id_merk"=>$this->db->id()));
	// 		}else{
	// 			$this->set->error_message(true);
	// 		}
	// 	}
	// 	else{
	// 		$this->set->error_message(true);
	// 	}
	// }

	// function submitEditSertifikat(){
	// 	$post_data = $this->render->json_post();
		
	// 	$data_perusahaan = array(
	// 	"nama_penanggung_jawab"		=> $post_data["namaPJProduk"],
	// 	"alamat_penanggung_jawab"	=> $post_data["alamatPJProduk"],
	// 	"provinsi"					=> $post_data["provinsi"],
	// 	"kota"						=> $post_data["kabupaten"],
	// 	"kode_pos"					=> $post_data["kodePos"],
	// 	"telp"						=> $post_data["nomorTelpon"],
	// 	"website"					=> $post_data["website"],
	// 	"email"						=> $post_data["email"],
	// 	);
		
	// 	if($this->db->update("tabel_perusahaan", $data_perusahaan, [""=>$post_data[""]])){
			
	// 		$data_produk = array(
	// 		"jenis_produk"				=> $post_data["jenisProduk"],
	// 		"nama_produk"				=> $post_data["namaProduk"],
	// 		"merk"						=> $post_data["merk"],
	// 		"tipe_produk"				=> $post_data["tipeProduk"],
	// 		"id_perusahaan"				=> $post_data["pJProduk"],
	// 		"nama_pabrik"				=> $post_data["namaPabrik"],
	// 		"no_SNI"					=> $post_data["noSNI"],
	// 		"status_penerapan"			=> $post_data["statusPenerapan"],
	// 		"skema_sertifikasi"			=> $post_data["skemaSertifikasi"],
	// 		"no_sertifikat"				=> $post_data["nomorSertifikat"],
	// 		"tgl_terbit_sertifikat"		=> $post_data["tanggalTerbit"],
	// 		"tgl_berakhir_sertifikat"	=> $post_data["tanggalBerakhir"]
	// 		);
			
	// 		if($this->db->update("tabel_produk", $data_produk, [""=>$post_data[""]])){
	// 			$this->set->success_message(true, array("id_merk"=>$this->db->id()));
	// 		}else{
	// 			$this->set->error_message(true);
	// 		}
	// 	}
	// 	else{
	// 		$this->set->error_message(true);
	// 	}
	// }

	function submitAddSertifikat(){
		$post_data = $this->render->json_post();
		
		$data_produk = array(
		"jenis_produk"				=> $post_data["jenisProduk"],
		"nama_produk"				=> $post_data["namaProduk"],
		"merk"						=> $post_data["merk"],
		"tipe_produk"				=> $post_data["tipeProduk"],
		"id_perusahaan"				=> $post_data["pJProduk"],
		"nama_pabrik"				=> $post_data["namaPabrik"],
		"no_SNI"					=> $post_data["noSNI"],
		"status_penerapan"			=> $post_data["statusPenerapan"],
		"skema_sertifikasi"			=> $post_data["skemaSertifikasi"],
		"no_sertifikat"				=> $post_data["nomorSertifikat"],
		"tgl_terbit_sertifikat"		=> $post_data["tanggalTerbit"],
		"tgl_berakhir_sertifikat"	=> $post_data["tanggalBerakhir"]
		);
			
		if($this->db->insert("tabel_produk", $data_produk)){
			$this->set->success_message(true, array("id_merk"=>$this->db->id()));
		}else{
			$this->set->error_message(true);
		}
	}

	function submitEditSertifikat(){
		$post_data = $this->render->json_post();
	
		$data_produk = array(
		"jenis_produk"				=> $post_data["jenisProduk"],
		"nama_produk"				=> $post_data["namaProduk"],
		"merk"						=> $post_data["merk"],
		"tipe_produk"				=> $post_data["tipeProduk"],
		"id_perusahaan"				=> $post_data["pJProduk"],
		"nama_pabrik"				=> $post_data["namaPabrik"],
		"no_SNI"					=> $post_data["noSNI"],
		"status_penerapan"			=> $post_data["statusPenerapan"],
		"skema_sertifikasi"			=> $post_data["skemaSertifikasi"],
		"no_sertifikat"				=> $post_data["nomorSertifikat"],
		"tgl_terbit_sertifikat"		=> $post_data["tanggalTerbit"],
		"tgl_berakhir_sertifikat"	=> $post_data["tanggalBerakhir"]
		);
			
		if($this->db->update("tabel_produk", $data_produk, ["id_merk"=>$post_data["idMerk"]])){
			$this->set->success_message(true);
		}else{
			$this->set->error_message(true);
		}
	}

	function submitDeleteSertifikat(){
		$post_data = $this->render->json_post();
		if($this->db->delete("tabel_produk", ["id_merk" => $post_data['idMerk']])){
            $this->set->success_message(true);
        }
	}

	function submitAddLisensi(){
		$post_data = $this->render->json_post();
		$data_lisensi = array(
			"no_lisensi" 			=> $post_data["nomorLisensi"],
			"tgl_terbit_lisensi" 	=> $post_data["tanggalTerbit"],
			"tgl_berakhir_lisensi" 	=> $post_data["tanggalBerakhir"],
		);
		if($this->db->insert("tabel_lisensi", $data_lisensi)){
			$data_produk = array(
				"no_lisensi"=>$post_data["nomorLisensi"]
			);
			$this->db->update("tabel_produk", $data_produk, ["id_merk" => $post_data['idMerk']]);
			$this->set->success_message(true);
		}else{
			$this->set->error_message(true);
		}
	}

	function submitEditLisensi(){
		$post_data = $this->render->json_post();
		$data_lisensi = array(
			"no_lisensi" 			=> $post_data["nomorLisensi"],
			"tgl_terbit_lisensi" 	=> $post_data["tanggalTerbit"],
			"tgl_berakhir_lisensi" 	=> $post_data["tanggalBerakhir"],
		);
		$this->db->update("tabel_lisensi", $data_lisensi, ["no_lisensi" => $post_data['nomorLisensiOld']]);

		$data_produk = array(
			"no_lisensi"=>$post_data["nomorLisensi"]
		);
		$this->db->update("tabel_produk", $data_produk, ["id_merk" => $post_data['idMerk']]);
		$this->set->success_message(true);
	}

	function submitDeleteLisensi(){
		$post_data = $this->render->json_post();
		$this->db->delete("tabel_lisensi", ["no_lisensi" => $post_data['nomorLisensi']]);
		$data_produk = array(
			"no_lisensi"=> ''
		);
		$this->db->update("tabel_produk", $data_produk, ["id_merk" => $post_data['idMerk']]);
        $this->set->success_message(true);
	}
	
}

?>