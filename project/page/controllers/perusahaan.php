<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');

class perusahaan extends Controller {

	function getData(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_produk","*");
		$this->render->json($data);
	}

	function submitAdd(){
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

	function submitEdit(){
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

	function submitDelete(){
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