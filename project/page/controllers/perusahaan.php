<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');

class perusahaan extends Controller {

	function getData(){
		$post_data = $this->render->json_post();
		$data["data"] = $this->db->select("tabel_perusahaan","*");
		$this->render->json($data);
	}

	function submitAdd(){
		$post_data = $this->render->json_post();
		$data = array(
			"nama_penanggung_jawab" 	=> $post_data["namaPJProduk"],
			"alamat_penanggung_jawab"	=> $post_data["alamatPJProduk"],
			"provinsi" 					=> $post_data["provinsi"],
			"kota" 						=> $post_data["kabupaten"],
			"kode_pos" 					=> $post_data["kodePos"],
			"status" 					=> $post_data["statusPJProduk"],
			"telp" 						=> $post_data["nomorTelpon"],
			"website" 					=> $post_data["website"],
			"email" 					=> $post_data["email"],
		);
		if($this->db->insert("tabel_perusahaan", $data)){
			$this->set->success_message(true, array("id"=>$this->db->id()));
		}else{
			$this->set->error_message(true, $this->db->log());
		}
	}

	function submitEdit(){
		$post_data = $this->render->json_post();
		$data = array(
			"nama_penanggung_jawab" 	=> $post_data["namaPJProduk"],
			"alamat_penanggung_jawab"	=> $post_data["alamatPJProduk"],
			"provinsi" 					=> $post_data["provinsi"],
			"kota" 						=> $post_data["kabupaten"],
			"kode_pos" 					=> $post_data["kodePos"],
			"status" 					=> $post_data["statusPJProduk"],
			"telp" 						=> $post_data["nomorTelpon"],
			"website" 					=> $post_data["website"],
			"email" 					=> $post_data["email"],
		);
		$this->db->update("tabel_perusahaan", $data, ["id_perusahaan" => $post_data['idPerusahaan']]);
		$this->set->success_message(true);
	}

	function submitDelete(){
		$post_data = $this->render->json_post();
		$this->db->delete("tabel_perusahaan", ["id_perusahaan" => $post_data['idPerusahaan']]);
        $this->set->success_message(true);
	}
	
}

?>