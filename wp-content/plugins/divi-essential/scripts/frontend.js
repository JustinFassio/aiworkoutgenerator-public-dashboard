jQuery(document).ready(function($) {
  // adjust br tag in ultimate image hover effect module....
  if ($(".dnext-neip-uih-descwrap").length) {
    $(".dnext-neip-uih-descwrap").each(function() {
      $("p:empty").remove();
      $(".dnext-neip-uih-des-pra").after("<br>");
    });
  }
});
