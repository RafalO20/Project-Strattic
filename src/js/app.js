// import external dependencies
import $ from "jquery";
import "../sass/app.sass";

import HeroHomepage from "./blocks/HeroHomepage.block";
import ProductDescription from "./blocks/ProductDescription.block";

import BurgerMenu from "./modules/BurgerMenu.module";
import ScrollTop from "./modules/ScrollTop.module";
// import HeaderPrimary from "./modules/HeaderPrimary.module";
import CarouselProducts from "./modules/CarouselProducts.module";
import Carousele from "./blocks/Carousele";
import Nav from "./blocks/Nav.block";

$(document).ready(() => {
  CarouselProducts.init();
  HeroHomepage.init();
  BurgerMenu.init();
  ScrollTop.init();
  // HeaderPrimary.init();
  ProductDescription.init();
  Carousele.init();
  Nav.init();
})
