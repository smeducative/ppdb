
$(window).scroll(function() {
    if ($(this).scrollTop() > 100) {
      $('.navbar').addClass('scrolled ');
    } else {
      $('.navbar').removeClass('scrolled ');
    }
  });

  if ($(window).scrollTop() > 100) {
    $('.navbar').addClass('scrolled');
  }