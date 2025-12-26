$(function () {
  "use strict"
  $(document).on('click', '#print_trigger', function (e) { 
    let printContents = document.getElementById('printableArea').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  });
});
$(function () {
  "use strict"
  $(document).on('click', '#print_history', function (e) { 
    let printContents = document.getElementById('printableHistoryArea').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  });
});
$(function () {
  "use strict"
  $(document).on('click', '#print_pack_history', function (e) { 
    let printContents = document.getElementById('printablePackHistoryArea').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  });
});
