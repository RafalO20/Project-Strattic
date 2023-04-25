import $ from 'jquery';
const Nav = {
  settings: {
    target: '.m-HeaderPrimary',
    dropLink: '.m-Button.-drop'
  },
  init(args) {
    this.settings = $.extend(true, this.settings, args);
    if ($(this.settings.target).length > 0) {
      this.catchDOM(this.settings, this.afterInit.bind(this));
    }
  },
  afterInit() {
    if ($(window).scrollTop() > 0) {
      $(this.$target.root).addClass('-scroll');
    }
    this.bindEvents();
  },
  catchDOM(settings, callback) {
    const target = $(settings.target);
    this.$target = {
      root: target,
      dropLink: target.find(settings.dropLink),
    };
    callback();
  },
  bindEvents() {
    $(this.$target.dropLink).parents(".m-HeaderPrimary__item").on('mouseover', this.dropMenu.bind(this));
    $(this.$target.dropLink).parents(".m-HeaderPrimary__item").on('mouseleave', this.hideMenu.bind(this));
    $(window).on('scroll', () => {
      if ($(window).scrollTop() > 0) {
        $(this.$target.root).addClass('-scroll');
      }
      else {
        $(this.$target.root).removeClass('-scroll');
      }
    })
  },
  dropMenu(e) {
    const target = $(e.currentTarget);
    const drop = $(target).find('.m-HeaderPrimary__drop');
    $(drop).fadeIn({
      duration: 300,
      start: function () {
        $(this).css('display', 'flex');
      }
    })
    $(target).find(this.settings.dropLink).find('span').css('transform', 'rotate(-180deg)');
  },
  hideMenu(e) {
    const target = $(e.currentTarget);
    const drop = $(target).find('.m-HeaderPrimary__drop');
    $(drop).fadeOut({
      duration: 300,
    });
    $(target).find(this.settings.dropLink).find('span').removeAttr('style');
  }
};
export default Nav;