$(document).ready(function () {
  $("#list-user").dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
      { 'searchable': false, 'targets': [0, 3, 4, 5, 6] }
    ]
  });

  $("#list-siswa").dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
      { 'searchable': false, 'targets': [2, 3, 4] }
    ]
  });

  $("#iuran-bulanan").dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 3, 4, 5] },
      { 'searchable': false, 'targets': [2, 3, 4, 5] }
    ]
  });

  if ($("#number-input").length) {
    new Cleave("#number-input", {
      prefix: 'Rp ',
      noImmediatePrefix: true,
      numeral: true,
      numeralThousandsGroupStyle: 'thousand',
      numeralPositiveOnly: true
    });
  }
});
