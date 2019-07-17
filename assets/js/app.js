$(document).ready(function () {
  $("#sidebar").mCustomScrollbar({
    theme: "minimal"
  });

  $('#dismiss, .overlay').on('click', function () {
    // hide sidebar
    $('#sidebar').removeClass('active');
    // hide overlay
    $('.overlay').removeClass('active');
  });

  $('#sidebarCollapse').on('click', function () {
    // open sidebar
    $('#sidebar').addClass('active');
    // fade in the overlay
    $('.overlay').addClass('active');
    $('.collapse.in').toggleClass('in');
    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
  });

  $('.menu-sidebar li').on('click', function () {
    $(this).toggleClass('active');
    $(this).siblings().removeClass('active');
    $(this).siblings().children().removeClass('show');
    $(this).siblings().children().attr('aria-expanded', 'false');
  });

  $('#userlist-table').dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [1, 2, 4, 5, 6] },
      { 'searchable': false, 'targets': [0, 3, 4, 5, 6] }
    ]
  });

  $('#tabelsiswa').dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [2, 3, 4] },
      { 'searchable': false, 'targets': [2, 3, 4] }
    ]
  });

  $('#tabelsiswa_tahunan').dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [2, 3, 4, 6] },
      { 'searchable': false, 'targets': [2, 3, 4, 6] }
    ]
  });

  $('#tabelkelas').dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [3, 4, 5] },
      { 'searchable': false, 'targets': [3, 4, 5] }
    ]
  });

  $('#laporandetailbulan').dataTable({
    'columnDefs': [
      { 'orderable': false, 'targets': [0, 1, 2, 3, 4] }
    ]
  });

  function addLeadingZero(n) {
    if (n <= 9) {
      return "0" + n;
    }

    return n;
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

  let current_date = new Date(Date.now());
  let formatted_date = addLeadingZero(current_date.getDate()) + "-" + addLeadingZero(current_date.getMonth() + 1) + "-" + current_date.getFullYear();
  // $('#add-user-modal').modal();
  $('#datepicker').datepicker({
    format: 'dd-mm-yyyy',
    uiLibrary: 'bootstrap4',
    value: formatted_date,
    icons: {
      rightIcon: '<i class="fas fa-calendar-alt"></i>'
    }
    // iconsLibrary: 'fontawesome'
  });

  $('#rentangawal').datepicker({
    format: 'yyyy-mm-dd',
    uiLibrary: 'bootstrap4',
    icons: {
      rightIcon: '<i class="fas fa-calendar-alt"></i>'
    }
  });

  $('#rentangakhir').datepicker({
    format: 'yyyy-mm-dd',
    uiLibrary: 'bootstrap4',
    icons: {
      rightIcon: '<i class="fas fa-calendar-alt"></i>'
    }
  });

});
