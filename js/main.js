$(document).ready(function(){
	$(".group1").colorbox({rel:'group1'});
});

$(function(){
    $('.instagramWidget img:gt(0)').hide();
    setInterval(function(){
      $('.instagramWidget :first-child').fadeOut(1000)
         .next('img').fadeIn(1000)
         .end().appendTo('.instagramWidget');}, 
      4000);
});