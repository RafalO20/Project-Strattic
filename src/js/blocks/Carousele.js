import $ from 'jquery';
const Carousele = {
  settings: {
    target: '.container',
    slider: '.mySwiper',
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
    };
    callback();
  },
  bindEvents() {
  },
  initSwiper() {
    const swiper = new Swiper(this.$target.slider[0], {
      pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
      },
    })
  },
};
export default Carousele;