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

  if ($("#number-input").length) {
    new Cleave("#number-input", {
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
