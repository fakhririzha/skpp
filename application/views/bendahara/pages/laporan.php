<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title product-sans">Laporan Keuangan</h4>
        <?php if ($this->session->suksesMsg != "") : ?>
          <hr>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('suksesMsg') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php elseif ($this->session->actionMsg != "") : ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('actionMsg') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endif; ?>
        <hr>
      </div>
      <div class="card-body">
        <div class="col-lg-4 col-md-6">
          <div class="card card-chart orange-main text-white">
            <div class="card-header">
              <h4 class="card-title"><i class="now-ui-icons business_money-coins"></i> Laporan SPP</h4>
            </div>
            <div class="card-body text-right">
              <a href="<?= base_url() ?>bendahara/laporanspp" class="btn btn-info navy-gradient">Klik</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-footer">
      </div>
    </div>
  </div>
</div>
