import $ from 'jquery';
const HeroHomepage = {
  settings: {
    target: '.b-HeroHomepage',
    burgerTop: '.b-HeroHomepage__burger.-top',
    burgerBottom: '.b-HeroHomepage__burger.-bottom',
    buttonLeft: '.m-Button.-left',
    buttonRight: '.m-Button.-right'
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
      burgerTop: target.find(settings.burgerTop),
      burgerBottom: target.find(settings.burgerBottom),
      buttonLeft: target.find(settings.buttonLeft),
      buttonRight: target.find(settings.buttonRight),
    };
    callback();
  },
  bindEvents() {
    $(window).on("scroll", this.closeBurger.bind(this));
    $(window).on("resize", this.closeBurger.bind(this));
  },
  closeBurger() {
    if ($(window).width() > 768) {
      if ($(window).scrollTop() > 75) {
        $(this.$target.burgerTop).addClass('-closed');
        $(this.$target.burgerBottom).addClass('-closed');
        $(this.$target.buttonLeft).addClass('-closed');
        $(this.$target.buttonRight).addClass('-closed');

      }
      else {
        $(this.$target.burgerTop).removeClass('-closed');
        $(this.$target.burgerBottom).removeClass('-closed');
        $(this.$target.buttonLeft).removeClass('-closed');
        $(this.$target.buttonRight).removeClass('-closed');
      }
    }
    else {
      $(this.$target.burgerTop).removeClass('-closed');
      $(this.$target.burgerBottom).removeClass('-closed');
      $(this.$target.buttonLeft).removeClass('-closed');
      $(this.$target.buttonRight).removeClass('-closed');
    }
  }
};
export default HeroHomepage;
