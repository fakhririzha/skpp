$(document).ready(function () {
  $("#list-user").dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 3, 4, 5, 6] },
      { 'searchable': false, 'targets': [0, 3, 4, 5, 6] }
    ]
  });
});

// function showNotification(from, align, message, type) {
//   $.notify({
//     icon: "now-ui-icons ui-1_bell-53",
//     message: message
//   }, {
//       type: type,
//       timer: 4000,
//       placement: {
//         from: from,
//         align: align
//       }
//     }
//   );
// }
