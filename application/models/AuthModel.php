<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  public function login($username, $password)
  {
    $auth = $this->db->where("username", $username)->get("user");
    // USER FOUND
    if ($auth->num_rows() > 0) {
      // PASSWORD MATCH
      if (password_verify($password, $auth->row()->password)) {
        $time = time();
        $time = date("Y-m-d H:i:s", $time);
        $this->db->query("UPDATE user SET last_login='$time', status='logged_in' WHERE username='$username'");
        // $this->db->query("call log_user_activity($username, 'login', '{$time}');");
        return [true, $auth];
      }
      // PASSWORD FALSE
      else {
        return [false, ''];
      }
    }
    // USER NOT FOUND
    else {
      return [false, ''];
    }
  }
}
