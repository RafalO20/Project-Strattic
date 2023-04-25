import $ from 'jquery';
//import Swiper from 'swiper'; 

const CarouselProducts = {
  settings: {
    target: '.m-CarouselProducts',
    next: '.swiper-button-next',
    prev: '.swiper-button-prev',
  },
  init(args) {
    this.settings = $.extend(true, this.settings, args);
    if ($(this.settings.target).length > 0) {
      this.catchDOM(this.settings, this.afterInit.bind(this));
      this.addIdToScrolls();
      this.initSwiper();
    }
  },
  afterInit() {
    this.bindEvents();
  },
  catchDOM(settings, callback) {
    const target = $(settings.target);
    this.$target = {
      root: target,
      next: target.find(settings.next),
      prev: target.find(settings.prev),
    };
    callback();
  },
  bindEvents() {
  },
  addIdToScrolls() {
    let scrolls = $(".b-CarouselRepeated__scroll");
    if(scrolls.length > 0 ) {
      $.each(scrolls, (index, scrollbar) => {
        scrollbar.id=`scrollbar-${index}`;
      } )
    }
  },
  initSwiper() {
    $(this.$target.prev).fadeOut();
    let swipers = $('.swiper');
    let swiper = []
    $.each( swipers, (index, item) => {
      swiper[index] = new Swiper(item, {
        slidesPerView: 4.5,
        spaceBetween: 9,
        allowTouchMove: false,
        scrollbar: {
          el: `.b-CarouselRepeated__scroll#scrollbar-${index}`,
          draggable: true,     
          dragClass: 'b-CarouselRepeated__ear',
          dragSize: 54,
        },
        pagination: {
          el: '.swiper-pagination',
          type: 'bullets',
          clickable: true,
        },
        breakpoints: {
        320: {
          slidesPerView: 1.5,
          slidesToScroll: 1,
          spaceBetween: 6,
          allowTouchMove: true,
        },
        610: {
          slidesPerView: 2.5,
          slidesToScroll: 1,
        },
        969: {
          slidesPerView: 3.5,
          spaceBetween: 9,
          slidesToScroll: 1,
        },
        1024: {
          slidesPerView: 4,
          allowTouchMove: false,
        },
        1441: {
          slidesPerView: 4.5,
        },
      }
      })
    })

    if(Array.isArray(swiper)) {
      $.each(swiper , (index, item ) => {
        if(item.params.slidesPerView >= item.slides.length ) {
          $(this.$target.next[index]).css("display", "none")
        }
        item.on('slidePrevTransitionEnd', () => {
          $(this.$target.next[index]).css("display", "flex")
          $(this.$target.prev[index]).css("display", "flex")
          let parentSwiper =  $('.swiper')[index];
          let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
          if($(firstSlide).length === 1) {
            $(this.$target.prev[index]).css("display", "none")
          }
        });
        item.on('slideNextTransitionEnd', () => {
          this.carouselPosition(index);
          $(this.$target.prev[index]).css("display", "flex")
        });
      })
      $.each(this.$target.next , (index, item ) => {
        $(this.$target.next[index]).on('click', () => {
          let parentSwiper =  $('.swiper')[index];
          let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
          if($(firstSlide).length === 1) {
            $(firstSlide).removeClass('swiper-slide-active')
          }
          else {
            swiper[index].slideNext();
          }
          this.carouselPosition(index);
          $(this.$target.prev[index]).css("display", "flex")

        });
        $(this.$target.prev[index]).on('click', () => {
          swiper[index].slidePrev();
          $(this.$target.next[index]).css("display", "flex")
          $(this.$target.prev[index]).css("display", "flex")
          let parentSwiper =  $('.swiper')[index];
          let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
          if($(firstSlide).length === 1) {
            $(this.$target.prev[index]).css("display", "none")
          }
    
        });
      })
    }
    else {
      swiper.on('slidePrevTransitionEnd', () => {
        $(this.$target.next[0]).css("display", "flex")
        $(this.$target.prev[0]).css("display", "flex")
        let parentSwiper =  $('.swiper')[0];
        let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
        if($(firstSlide).length === 1) {
          $(this.$target.prev).css("display", "none")
        }
      });
      swiper.on('slideNextTransitionEnd', () => {
        this.carouselPosition(0);
        $(this.$target.prev[0]).css("display", "flex")
      });
      $(this.$target.next[0]).on('click', () => {
        let parentSwiper =  $('.swiper')[0];
        let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
        if($(firstSlide).length === 1) {
          $(firstSlide).removeClass('swiper-slide-active')
        }
        else {
          swiper.slideNext();
        }
        this.carouselPosition(0);
        $(this.$target.prev[0]).css("display", "flex")
  
      });
      $(this.$target.prev[0]).on('click', () => {
        swiper.slidePrev();
        $(this.$target.next[0]).css("display", "flex")
        $(this.$target.prev[0]).css("display", "flex")
        let parentSwiper =  $('.swiper')[0];
        let firstSlide = $(parentSwiper).find('.swiper-slide.swiper-slide-active:first-child');
        if($(firstSlide).length === 1) {
          $(this.$target.prev[0]).css("display", "none")
        }
  
      });
    }
  },
  carouselPosition(index) {
    let parentSwiper =  $('.swiper')[index];
    let firstSlide = $(parentSwiper).find('.swiper-slide:last-child');
    if($(window).width() - $(firstSlide)[0].getBoundingClientRect().right > -10 ) {
      $(this.$target.next[index]).css("display", "none")
    }
  },
  

};
export default CarouselProducts;
