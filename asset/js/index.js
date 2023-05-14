
// 
// ↓↓ Loading animation ↓↓

// ↓Firstvisit の設定
// window.addEventListener('load', function() {
//   const loading = document.querySelector('#loading');
//   const firstVisit = localStorage.getItem('firstVisit');
//   if (!firstVisit) {
//     // 初回のアクセス時のみローディングアニメーションを表示
//     localStorage.setItem('firstVisit', 'true');
//     loading.classList.add('loaded');
//   } else {
//     // 二回目以降はローディングアニメーションを非表示にする
//     loading.style.display = 'none';
//   }
// });

// ↓アニメーションが終わったら#splashエリアをフェードアウト
$("#loading").delay(250).fadeOut(250);

// ↑↑ Loading animation ↑↑
// 


// ↓ rateYo
$('.star').rateYo({
  precision: 1,
  readOnly: true,
  starWidth: "20px",
  normalFill: "#A0A0A0",
  ratedFill: "#F39C12"
});
// ↑ rateYo

// ↓ slick 'Ranking_slider'
$(function() {
  $('.Ranking_slider').not('.slick-initialized').slick({
    autoplay: true, // 自動再生ON OFF
    infinite: true,
    dots: false, // ドットインジケーターON OFF
    centerMode: false, // 両サイドに前後のスライド表示
    centerPadding: '0px', // 左右のスライドのpadding
    slidesToShow: 4, // 一度に表示するスライド数
    autoplaySpeed: 4500, //隣あう画像のスライドするまでの間隔時間
    cssEase: 'linear', //開始から終了まで一定に変化する
    arrows: true, //スライド移動の矢印
    prevArrow: '<img src="./asset/img/btn/left.png" class="slide-arrow prev-arrow">',
    nextArrow: '<img src="./asset/img/btn/right.png" class="slide-arrow next-arrow">',
    responsive: [
      {
        breakpoint: 1280,
        settings: {
          slidesToShow: 3,
          infinite: true,
        }
      },
      {
        breakpoint: 640,
        settings: {
          slidesToShow: 2
        }
      }
    ]
  })

  $('.Ranking_slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    if(currentSlide === 0){
      $('[data-slick-index="-1"]', this).addClass('slide-trans');
    }
    if(nextSlide === 0){
      $('[data-slick-index="10"]', this).addClass('slide-trans');
    }
  });

  $('.Ranking_slider').on('afterChange', function(event, slick, currentSlide) {
    $('[data-slick-index="-1"]', this).removeClass('slide-trans');
    $('[data-slick-index="0"]', this).removeClass('slide-trans');
    $('[data-slick-index="8"]', this).removeClass('slide-trans');
    $('[data-slick-index="9"]', this).removeClass('slide-trans');
    $('[data-slick-index="10"]', this).removeClass('slide-trans');
  });
});
// ↑ slick 'Ranking_slider'

// ↓ slick 'New_slider'
$(function() {
  let New_sliderOptions = {
    autoplay: false,
    dots: false,
    centerMode: false,
    centerPadding: '5px',
    slidesToShow: 5,
    arrows: true,
    adaptiveHeight: false,
    prevArrow: '<img src="./asset/img/btn/left.png" class="slide-arrow prev-arrow">',
    nextArrow: '<img src="./asset/img/btn/right.png" class="slide-arrow next-arrow">'
  };

  // load時の可変設定
  $(window).on('load', function() {
    if ($(window).width() <= 1280) {
      $('.New_slider').not('.slick-initialized').slick('unslick');
    } else {
      $('.New_slider').not('.slick-initialized').slick(New_sliderOptions);
    }
  });

  // resize時の可変設定
  $(window).resize(function() {
    if (window.matchMedia('(max-width: 1280px)').matches) {
      $('.New_slider').not('.slick-initialized').slick('unslick');
    } else {
      $('.New_slider').not('.slick-initialized').slick(New_sliderOptions);
    }
  });

  $('.New_slider').not('.slick-initialized').slick(New_sliderOptions);
});
// ↑ slick 'New_slider'

// debug用
$(window).scroll(function() {
  $('#scroll-amount').text($(this).scrollTop() + 'px');
});

