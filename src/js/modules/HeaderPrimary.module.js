// import $ from 'jquery';
// const HeaderPrimary = {
//   settings: {
//     target: '.m-HeaderPrimary',
//     dropButton: '.m-Button.-drop'
//   },
//   init(args) {
//     this.settings = $.extend(true, this.settings, args);
//     if ($(this.settings.target).length > 0) {
//       this.catchDOM(this.settings, this.afterInit.bind(this));
//     }
//   },
//   afterInit() {
//     if ($(window).scrollTop() > 0) {
//       $(this.$target.root).addClass('-scroll');
//     }
//     this.bindEvents();
//   },
//   catchDOM(settings, callback) {
//     const target = $(settings.target);
//     this.$target = {
//       root: target,
//       dropButton: target.find(settings.dropButton),
//     };
//     callback();
//   },
//   bindEvents() {
//     $(this.$target.dropButton).parents(".m-HeaderPrimary__item").on('mouseover', this.dropMenu.bind(this));
//     $(this.$target.dropButton).parents(".m-HeaderPrimary__item").on('mouseleave', this.hideMenu.bind(this));
//     $(window).on('scroll', () => {
//       if ($(window).scrollTop() > 0) {
//         $(this.$target.root).addClass('-scroll');
//       }
//       else {
//         $(this.$target.root).removeClass('-scroll');
//       }
//     })
//   },
//   dropMenu(e) {
//     const target = $(e.currentTarget);
//     const drop = $(target).find('.m-HeaderPrimary__drop');
//     $(drop).slideDown({
//       duration: 300,
//       start: function () {
//         $(this).css('display', 'flex');
//       }
//     })
//     $(target).find(this.settings.dropButton).find('span').css('transform', 'rotate(-180deg)');
//   },
//   hideMenu(e) {
//     const target = $(e.currentTarget);
//     const drop = $(target).find('.m-HeaderPrimary__drop');
//     $(drop).slideUp({
//       duration: 300,
//     });
//     $(target).find(this.settings.dropButton).find('span').removeAttr('style');
//   }
// };
// export default HeaderPrimary;
