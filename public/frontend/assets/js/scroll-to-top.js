document.addEventListener('DOMContentLoaded', function () {
  var btnScrollToTop = document.getElementById('btnScrollToTop');

  btnScrollToTop.addEventListener('click', function () {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });

  window.addEventListener('scroll', function () {
    if (window.scrollY > 300) {
      btnScrollToTop.style.display = 'block';
    } else {
      btnScrollToTop.style.display = 'none';
    }

    // Ajoutez la classe fadeInUp lorsque vous faites défiler vers le haut
    var animatedTitle = document.querySelector('.animated-title');
    if (animatedTitle && window.scrollY > 100) {
      animatedTitle.classList.add('fadeInUp');
    }
  });
});
