export function isElementInViewport (el) {

  if (typeof jQuery === "function" && el instanceof jQuery) {
    el = el[0];
  }

  var rect = el.getBoundingClientRect();
  return (
    (rect.top - window.innerHeight) <= 0 &&
    rect.bottom > 0
  );
}
