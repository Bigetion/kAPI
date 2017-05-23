<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');

class sertifikat extends Controller {
	
	private $col1 = array(
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
		"tabel_produk.tgl_berakhir_sertifikat"
	);

	private $col2 = array(
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
		"tabel_produk.tgl_berakhir_sertifikat"
	);

	private function getSNI($data){
		$newData = array();
		foreach ($data as $key => $value) {
			$sni = $this->db->select("tabel_sni",["no_SNI(id)", "no_SNI(text)", "judul_SNI"], ["no_sni" => explode(';',$value['no_SNI'])]);
			$newData[$key] = $value;
			$newData[$key]['sni'] = $sni;
		}
		return $newData;
	}

	private function getQueryByOptions($ac, $intCol){
		$post_data = $this->render->json_post();

		$data = array();

		$col = $this->col1;
		if($intCol!=1) $col == $this->col2;
		if(isset($post_data['page'])){
			$limit = 10;

			if(isset($post_data['q'])){
				if(isset($post_data['searchBy'])){
					foreach ($col as $value) {
						$colExplode = explode('.',$value);
						if($post_data['searchBy'] == $colExplode[1]) $post_data['searchBy'] = $value;
					}
					$ac[$post_data['searchBy']."[~]"] = $post_data['q'];
				}
				else {
					$searchByAll = array();
					foreach ($col as $value) {
						$searchByAll[$value."[~]"] = $post_data['q'];
					}
					$ac["OR"] = $searchByAll;	
				}
			}

			$dataTmp = $this->db->select("tabel_produk",[
				"[>]tabel_perusahaan"=>"id_perusahaan",
				"[>]tabel_sni"=>"no_SNI"
			], $col, $ac);
			$offset = ($post_data['page']-1) * $limit;
			$ac["LIMIT"] = [$offset, $limit];

			$data['totalRecord'] = count($dataTmp);
			$data['totalPage'] = ceil(count($dataTmp) / $limit);
		}

		return [ $data, $ac ];
	}

	function getSertifikatBerlaku(){
		$post_data = $this->render->json_post();

		$ac = array("#tabel_produk.tgl_berakhir_sertifikat[>=]"=>"NOW()");
		$gQBO = $this->getQueryByOptions($ac, 1);
		$data = $gQBO[0];
		$ac = $gQBO[1];

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
		], $ac);

		$data['data'] = $this->getSNI($data['data']);
		$data['log'] = $this->db->log();
		$this->render->json($data);
	}

	function getSertifikatTidakBerlaku(){
		$post_data = $this->render->json_post();

		$ac = array("#tabel_produk.tgl_berakhir_sertifikat[<]"=>"NOW()");
		$gQBO = $this->getQueryByOptions($ac, 1);
		$data = $gQBO[0];
		$ac = $gQBO[1];

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
		],$ac);

		$data['data'] = $this->getSNI($data['data']);
		$data['log'] = $this->db->log();
		$this->render->json($data);
	}

	function getData(){
		$post_data = $this->render->json_post();

		$ac = array();
		$gQBO = $this->getQueryByOptions($ac, 2);
		$data = $gQBO[0];
		$ac = $gQBO[1];

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
		], $ac);

		$data['data'] = $this->getSNI($data['data']);
		$this->render->json($data);
	}

	function getDataByLSPRO(){
		$post_data = $this->render->json_post();

		$ac = array("tabel_perusahaan.id_lspro" => $post_data['idLSPRO']);
		$gQBO = $this->getQueryByOptions($ac, 2);
		$data = $gQBO[0];
		$ac = $gQBO[1];

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
		], $ac);

		$data['data'] = $this->getSNI($data['data']);
		$this->render->json($data);
	}

	function getPerusahaanOptions(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_perusahaan","*", array('id_lspro' => $post_data['idLSPRO']));
		$this->render->json($data);
	}
		
	function getSNIOptions(){
		$post_data = $this->render->json_post();
		if(isset($post_data['page'])){
			$limit = 10;
			$dataTmp = $this->db->select("tabel_sni",["no_SNI(id)", "no_SNI(text)"], ["no_sni[~]" => $post_data['q']]);

			$offset = ($post_data['page']-1) * $limit;

			$data['data'] = $this->db->select("tabel_sni",["no_SNI(id)", "no_SNI(text)", "judul_SNI"], ["no_sni[~]" => $post_data['q'], "LIMIT" => [$offset, $limit]]);
			$data['totalPage'] = ceil(count($dataTmp) / $limit);
		}else{
			$data['data'] = $this->db->select("tabel_sni","*");
		}
		$data['log'] = $this->db->log();
		$this->render->json($data);
	}

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