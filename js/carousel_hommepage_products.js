//js/carousel_hommepage_products.js

// window.onload = function() {
    // JavaScript code goes here
    // var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
    // var liElements = ulElement.getElementsByTagName('li');

    // console.log('ulElement:', ulElement); // Log the ul element

    // var totalWidth = 0;

    // for (var i = 0; i < liElements.length; i++) {
    // totalWidth += liElements[i].offsetWidth; // Width of the li element
    // if (i < liElements.length - 1) {
    //     // Add space between elements (margin-right)
    //     totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
    // }
    
    // console.log('liElement ' + i + ':', liElements[i]); // Log each li element
    // }

    // console.log('Total width including spaces: ' + totalWidth + 'px');
    // console.log('JS with DOM')
    // // Now, check if the ul.slides width is greater than totalWidth
    // if (ulElement.offsetWidth > totalWidth) {
    // ulElement.style.display = 'flex';
    // ulElement.style.justifyContent = 'center'; // Add justify-content: center
    // ulElement.style.width = '100%';
    // } else {
    // ulElement.style.display = 'block'; // Revert to the default value if it's not greater
    // ulElement.style.justifyContent = ''; // Revert justify-content if not greater
    // ulElement.style.width = '1000%'; // as default
    // }
// }

// window.onload = function() {
    // JavaScript code goes here
    var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
    var liElements = ulElement.getElementsByTagName('li');
  
    console.log('ulElement:', ulElement); // Log the ul element
    console.log('ul.slide width is: ' + ulElement.offsetWidth)
  
    var totalWidth = 0;
  
    for (var i = 0; i < liElements.length; i++) {
      totalWidth += liElements[i].offsetWidth; // Width of the li element
      if (i < liElements.length - 1) {
        // Add space between elements (margin-right)
        totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
      }
  
      console.log('liElement ' + i + ':', liElements[i]); // Log each li element
    }
  
    console.log('Total width including spaces: ' + totalWidth + 'px');
    console.log('JS with DOM');
  
    // Now, check if the ul.slides width is greater than totalWidth
    if (ulElement.offsetWidth > totalWidth) {
      ulElement.style.display = 'flex';
      ulElement.style.justifyContent = 'center'; // Add justify-content: center
      ulElement.style.width = '100%';
    } else {
      ulElement.style.display = 'block'; // Revert to the default value if it's not greater
      ulElement.style.justifyContent = ''; // Revert justify-content if not greater
      ulElement.style.width = '1000%'; // as default
      console.log('here we have ulElement.offsetWidth < totalWidth');
    }
//   };
  