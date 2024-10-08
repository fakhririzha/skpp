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

  public function logout($uname = '')
  {
    $user_check = $this->db->query("SELECT * FROM user WHERE username='$uname'")->num_rows();
    if ($user_check > 0) {
      if ($this->db->query("UPDATE user SET status='inactive' WHERE username='$uname'")) {
        // $time = time();
        // $time = date("Y-m-d H:i:s", $time);
        // $this->db->query("call log_user_activity('$uname', 'logout', '{$time}');");
        return true;
      } else {
        return false;
      }
    }
  }
}
