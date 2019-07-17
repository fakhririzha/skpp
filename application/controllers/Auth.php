<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("AuthModel");
    if ($this->session->username != "") {
      redirect("$this->session->jabatan");
    }
  }
  public function index()
  {
    if (isset($_POST["authUser"])) {
      $u = $this->input->post("username");
      $p = $this->input->post("password");
      $c = $this->input->post("captcha_input");

      $auth = $this->AuthModel->login($u, $p);
      $captcha = $this->session->captcha == $c;

      // AUTH SUCCESS
      if ($auth[0]) {
        // CAPTCHA MATCH
        if ($captcha) {
          $this->session->unset_userdata("username");
          $data = $auth[1]->row();
          $this->session->set_userdata([
            'id' => $data->id,
            'username' => $data->username,
            'jabatan' => $data->jabatan
          ]);
          $this->session->unset_userdata('captcha');
          if ($this->session->jabatan == "admin") {
            redirect("admin");
          } else {
            redirect("bendahara");
          }
        }
        // CAPTCHA FALSE
        else {
          $this->session->set_flashdata([
            'msgType' => 'warning',
            'msgHead' => 'Captcha salah.',
            'msgText' => 'Mohon masukkan angka sesuai gambar.'
          ]);
          redirect("");
        }
      }
      // AUTH FAILED
      else {
        $this->session->set_flashdata([
          'msgType' => 'danger',
          'msgHead' => 'Akses ditolak.',
          'msgText' => 'Informasi login yang anda berikan tidak valid.'
        ]);
        redirect("");
      }
    } else {
      $captcha = $this->generate_captcha();

      $this->session->set_userdata('captcha', $captcha["word"]);
      $data["captcha"] = $captcha;

      $this->load->view('portal/index', $data);
    }
  }

  public function generate_captcha()
  {
    $this->load->helper('captcha');

    if ($this->session->captcha != "") {
      $this->session->unset_userdata('captcha');
    }
    $captcha = create_captcha([
      'word'          => '',
      'img_path'      => './captcha/',
      'img_url'       => 'http://localhost/SKPP/captcha/',
      'font_path'     => '/assets/webfonts/product_sans.ttf',
      'img_width'     => 90,
      'img_height'    => 30,
      'expiration'    => 300,
      'word_length'   => 4,
      'font_size'     => 28,
      'img_id'        => 'captcha',
      'pool'          => '0123456789',

      'colors'        => [
        'background' => [255, 255, 255],
        'border' => [0, 0, 0],
        'text' => [0, 0, 0],
        'grid' => [175, 175, 175]
      ]
    ]);

    return $captcha;
  }
}
