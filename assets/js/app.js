if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
$(document).ready(function () {

  if ($("#list-user").length) {
    $("#list-user").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
        { 'searchable': false, 'targets': [0, 3, 4, 5, 6] }
      ]
    });
  }

  if ($("#list-siswa").length) {
    $("#list-siswa").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
        { 'searchable': false, 'targets': [2, 3, 4] }
      ]
    });
  }

  if ($("#list-siswa-import").length) {
    $("#list-siswa-import").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [2, 3, 4] },
        { 'searchable': false, 'targets': [2, 3, 4] }
      ]
    });
  }

  if ($("#list-pembagian-kelas").length) {
    $("#list-pembagian-kelas").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [0, 3, 4] },
        { 'searchable': false, 'targets': [0, 3, 4] }
      ]
    });
  }

  if ($("#list-kelas").length) {
    $("#list-kelas").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 6, 7] },
        { 'searchable': false, 'targets': [3, 4, 5, 6, 7] }
      ]
    });
  }

  if ($("#iuran-bulanan").length) {
    $("#iuran-bulanan").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 3, 4, 5] },
        { 'searchable': false, 'targets': [2, 3, 4, 5] }
      ]
    });
  }

  if ($("#iuran-tahunan").length) {
    $("#iuran-tahunan").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 3, 4, 5] },
        { 'searchable': false, 'targets': [2, 3, 4, 5] }
      ]
    });
  }

  if ($("#histori-transaksi").length) {
    $("#histori-transaksi").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 4, 5, 6] },
        { 'searchable': false, 'targets': [0, 1, 2, 4, 5] }
      ]
    });
  }

  if ($("#histori-transaksi-bulanan").length) {
    $("#histori-transaksi-bulanan").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 3, 5, 6] },
        { 'searchable': false, 'targets': [0, 1, 2, 3, 4] }
      ]
    });
  }

  if ($("#histori-transaksi-tahunan").length) {
    $("#histori-transaksi-tahunan").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
        { 'searchable': false, 'targets': [0, 2, 3, 4, 5, 6] }
      ]
    });
  }

  if ($("#histori-pemasukan").length) {
    $("#histori-pemasukan").dataTable({
      'columnDefs': [
        { 'orderable': false, 'targets': [4, 5, 6, 7] },
        { 'searchable': false, 'targets': [0, 1, 2, 3, 5, 6, 7] }
      ]
    });
  }

  if ($("#number-input").length) {
    new Cleave("#number-input", {
      prefix: 'Rp ',
      noImmediatePrefix: true,
      numeral: true,
      numeralThousandsGroupStyle: 'thousand',
      numeralPositiveOnly: true
    });
  }
  if ($("#number-input-2").length) {
    new Cleave("#number-input-2", {
      prefix: 'Rp ',
      noImmediatePrefix: true,
      numeral: true,
      numeralThousandsGroupStyle: 'thousand',
      numeralPositiveOnly: true
    });
  }
  if ($("#number-input-3").length) {
    new Cleave("#number-input-3", {
      prefix: 'Rp ',
      noImmediatePrefix: true,
      numeral: true,
      numeralThousandsGroupStyle: 'thousand',
      numeralPositiveOnly: true
    });
  }

  if ($("#date-input").length) {

    $("#date-input").datepicker({
      uiLibrary: "bootstrap4",
      format: "yyyy-mm-dd",
      iconsLibrary: 'fontawesome'
    });

    $("#date-input").on("focus", function () {
      $(".input-group-append > button").addClass("border-orange");
    });

    $("#date-input").on("focusout", function () {
      $(".input-group-append > button").removeClass("border-orange");
    })

  }
});
