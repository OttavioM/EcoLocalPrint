//js/carousel_hommepage_products.js

// JavaScript code goes here
var ulElement = document.getElementById('metaslider-id-640');
var liElements = ulElement.getElementsByTagName('li');

var totalWidth = 0;

for (var i = 0; i < liElements.length; i++) {
  totalWidth += liElements[i].offsetWidth; // Width of the li element
  if (i < liElements.length - 1) {
    // Add space between elements (margin-right)
    totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
  }
}

console.log('Total width including spaces: ' + totalWidth + 'px');

// Now, check if the ul.slides width is greater than totalWidth
if (ulElement.offsetWidth > totalWidth) {
  ulElement.style.display = 'flex';
} else {
  ulElement.style.display = ''; // Revert to the default value if it's not greater
}
