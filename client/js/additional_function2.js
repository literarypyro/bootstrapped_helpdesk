$(function(){

$(".datatable2").dataTable({sDom:"<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",sPaginationType:"bootstrap", "aaSorting": [[ 1, "desc" ]],oLanguage:{sLengthMenu:"_MENU_ records per page"}});

$("#filterResults").click(function(b){b.preventDefault();$("#datafilterModal").modal("show")});
$("#filterResults2").click(function(b){b.preventDefault();$("#datafilterModal").modal("show")});

});