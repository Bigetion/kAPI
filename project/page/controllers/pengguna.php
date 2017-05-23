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

	function getProfile(){
		$post_data = $this->render->json_post();
		$data['data'] = $this->db->select("users",[
		"[>]roles" => "id_role",
		"[>]tabel_pengguna_internal" => ["id_external"=>"id_pengguna_internal"]
		],[
		"users.id_user","users.id_role","users.id_external","users.username", "roles.role_name", "tabel_pengguna_internal.nama", "tabel_pengguna_internal.email", "tabel_pengguna_internal.email"
		],["users.id_user" => $post_data['idUser']]);
		
		$this->render->json($data);	
	}

	function changePassword(){
		$post_data = $this->render->json_post();
		$user = $this->db->select("users","*",["id_user"=>$post_data['idUser']]);
		if(password_verify($post_data['passwordOld'],$user[0]['password'])){
			$data = array(
				"password"	=> password_hash($post_data['passwordNew'],1)
			);
			if($this->db->update("users", $data, ["id_user"=>$post_data['idUser']])){
				$this->set->success_message(true);
			}else{
				$this->set->error_message(true);
			}
		}
	}

	function getRoleOptions(){
		$data['data'] = $this->db->select("roles","*");
        $this->render->json($data);
	}

	function getLSPROOptions(){
		$data['data'] = $this->db->select("tabel_lspro","*");
        $this->render->json($data);
	}

	function submitAdd(){
        $post_data = $this->render->json_post();
        $data = array(
            'nama'	=> $post_data['nama'],
            'email' => $post_data['email'],
        );
        if($this->db->insert("tabel_pengguna_internal", $data)){
            $id_pengguna_internal = $this->db->id();
            $data = array(
				'username'		=> $post_data['namaUser'],
            	'password'  	=> password_hash($post_data['password'],1),
				'id_role'		=> $post_data['idRole'],
				'id_external'	=> $id_pengguna_internal
			);
			if($this->db->insert("users", $data)){
				$id_user = $this->db->id();
				$this->set->success_message(true, array('id'=>$id_user, 'id_pengguna_internal'=>$id_pengguna_internal));
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
			$this->db->delete("tabel_pengguna_internal", ["id_pengguna_internal" => $post_data['idExternal']]);
            $this->set->success_message(true);
        }
    }

	function submitUpdateLSPRO(){
		$post_data = $this->render->json_post();
		$data = array(
            'id_user'	=> $post_data['idUser']
        );
		$this->db->update("tabel_lspro", $data, ["id_lspro" => $post_data['idLSPRO']]);

		$this->set->success_message(true, $this->db->log());
	}
}
?>