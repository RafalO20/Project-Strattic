import $ from 'jquery';
const ProductDescription = {
  settings: {
    target: '.b-ProductDescription',
    slider: '.b-ProductDescription__slider',
    thumbnails: '.b-ProductDescription__thumbnails',
  },
  init(args) {
    this.settings = $.extend(true, this.settings, args);
    if ($(this.settings.target).length > 0) {
      this.catchDOM(this.settings, this.afterInit.bind(this));
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
      slider: target.find(settings.slider),
      thumbnails: target.find(settings.thumbnails),
    };
    callback();
  },
  bindEvents() {
  },
  initSwiper() {
    const thumbsSwiper = new Swiper(this.$target.thumbnails[0], {
      spaceBetween: 5,
      slidesPerView: 3,
      freeMode: true,
      watchSlidesProgress: true,
    });
    const swiper = new Swiper(this.$target.slider[0], {
      slidesPerView: 1,
      thumbs: {
        swiper: thumbsSwiper,
      },
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
      breakpoints: {
        320: {
          slidesPerView: 1.5,
          spaceBetween: 20,
          allowTouchMove: true,
        },
        611: {
          slidesPerView: 2.5,
          spaceBetween: 20,
        },
        969: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
      }
    })
  },
};
export default ProductDescription;
