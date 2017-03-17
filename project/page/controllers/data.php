<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');
class data extends Controller {

	function getUserInfo(){
		$data['idRole'] = id_role;
		$data['idUser'] = id_user;

		$dataUser = $this->db->select("users",[
		"[>]roles" => "id_role",
		"[>]tabel_pengguna_internal" => ["id_external"=>"id_pengguna_internal"]
		],[
		"users.id_user","users.id_role","users.id_external","users.username", "roles.role_name", "tabel_pengguna_internal.nama", "tabel_pengguna_internal.email"
		], ["users.id_user"=>id_user]);

		if(count($dataUser) > 0){
			$data['username'] = $dataUser[0]['nama'];
			$data['roleName'] = $dataUser[0]['role_name'];
		}
		$this->render->json($data);
	}
}
?>