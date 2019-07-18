$(document).ready(function () {
  $("#list-user").dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 3, 4, 5] },
      { 'searchable': false, 'targets': [0, 2, 3, 4, 5] }
    ]
  });
});
