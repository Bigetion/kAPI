<?php  if ( ! defined('INDEX')) exit('No direct script access allowed');
class pengguna extends Controller {
	function getList(){
		$data['data'] = $this->db->select("users",[
		"[>]roles" => "id_role",
		"[>]tabel_pengguna_internal" => ["id_external"=>"id_pengguna_internal"]
		],[
		"users.id_user","users.id_role","users.id_external","users.username", "roles.role_name", "tabel_pengguna_internal.nama", "tabel_pengguna_internal.email"
		]);
		
		$this->render->json($data);	
	}

	function getRoleOptions(){
		$data['data'] = $this->db->select("roles","*");
        $this->render->json($data);
	}

	function submitAdd(){
        $post_data = $this->render->json_post();
        $data = array(
            'nama'	=> $post_data['nama'],
            'email' => $post_data['email'],
        );
        if($this->db->insert("tabel_pengguna_internal", $data)){
            $id = $this->db->id();
            $data = array(
				'username'		=> $post_data['namaUser'],
            	'password'  	=> password_hash($post_data['password'],1),
				'id_role'		=> $post_data['idRole'],
				'id_external'	=> $id
			);
			if($this->db->insert("users", $data)){
				$id = $this->db->id();
				$this->set->success_message(true, array('id_pengguna_internal'=>$id));
			}
        }
    }

	function submitEdit(){
		$post_data = $this->render->json_post();
		$data = array(
			'username'	=> $post_data['namaUser'],
			'id_role'	=> $post_data['idRole'],
		);
		$this->db->update("users", $data, ["id_user" => $post_data['idUser']]);

        $data = array(
            'nama'	=> $post_data['nama'],
            'email' => $post_data['email'],
        );
		$this->db->update("tabel_pengguna_internal", $data, ["id_pengguna_internal" => $post_data['idExternal']]);

		$this->set->success_message(true);
	}

	function submitDelete(){
        $post_data = $this->render->json_post();
        if($this->db->delete("users", ["id_user" => $post_data['idUser']])){
            $this->set->success_message(true);
        }
    }
}
?>