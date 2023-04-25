import $ from 'jquery';
const BurgerMenu = {
  settings: {
    target: '.m-BurgerMenu',
    open: '.m-BurgerMenu__open',
    close: '.m-BurgerMenu__close',
    slide: '.m-BurgerMenu__slide',
    dropButton: '.m-Button.-drop',
    link: '.m-Button:not(.-drop)'
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
      open: target.find(settings.open),
      close: target.find(settings.close),
      slide: target.find(settings.slide),
      dropButton: target.find(settings.dropButton),
      link: target.find(settings.link),
    };
    callback();
  },
  bindEvents() {
    $(this.$target.open).on('click', this.openMenu.bind(this));
    $(this.$target.close).on('click', this.closeMenu.bind(this));
    $(this.$target.dropButton).on('click', this.dropMenu.bind(this));
    $(this.$target.link).on("click", this.closeMenu.bind(this))
  },
  openMenu() {
    $(this.$target.slide).addClass('-open');
    $('body').css('overflow', 'hidden');
  },
  closeMenu() {
    $(this.$target.slide).removeClass('-open');
    $('body').removeAttr('style');
  },
  dropMenu(e) {
    const target = $(e.currentTarget);
    const drop = $(target).siblings('.m-BurgerMenu__drop');
    $(drop).slideToggle({
      duration: 300,
      start: function() {
        $(this).css('display', 'flex');
      }
    }).toggleClass('-open');
    if ($(drop).hasClass('-open')) {
      $(target).find('span').css('transform', 'rotate(-180deg)');
    } else {
      $(target).find('span').removeAttr('style');
    }
  }
};
export default BurgerMenu;
