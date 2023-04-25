import $ from 'jquery';
const ScrollTop = {
  settings: {
    target: '.m-ScrollTop',
  },
  init(args) {
    this.settings = $.extend(true, this.settings, args);
    if ($(this.settings.target).length > 0) {
      this.catchDOM(this.settings, this.afterInit.bind(this));
    }
  },
  afterInit() {
    this.bindEvents();
  },
  catchDOM(settings, callback) {
    const target = $(settings.target);
    this.$target = {
      root: target,
    };
    callback();
  },
  bindEvents() {
    $(this.$target.root).on('click', this.scrollToTop.bind(this));
  },
  scrollToTop() {
    $(window).scrollTop(0);
  },
};
export default ScrollTop;
