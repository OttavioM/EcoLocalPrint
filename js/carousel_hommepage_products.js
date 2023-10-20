//js/carousel_hommepage_products.js

// window.onload = function() {
//     // JavaScript code goes here
//     var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
//     var liElements = ulElement.getElementsByTagName('li');
  
//     ulElement.style.width = '100%';
//     console.log('ulElement:', ulElement); // Log the ul element
//     console.log('ul.slide width is: ' + ulElement.offsetWidth)
  
//     var totalWidth = 0;
  
//     for (var i = 0; i < liElements.length; i++) {
//       totalWidth += liElements[i].offsetWidth; // Width of the li element
//       if (i < liElements.length - 1) {
//         // Add space between elements (margin-right)
//         totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
//       }
  
//       console.log('liElement ' + i + ':', liElements[i]); // Log each li element
//     }
  
//     console.log('Total width including spaces: ' + totalWidth + 'px');
//     console.log('JS with DOM');
  
//     // Now, check if the ul.slides width is greater than totalWidth
//     if (ulElement.offsetWidth/10 > totalWidth) {
//       ulElement.style.display = 'flex';
//       ulElement.style.justifyContent = 'center'; // Add justify-content: center
//       ulElement.style.width = '100%';
//     } else {
//       ulElement.style.display = 'block'; // Revert to the default value if it's not greater
//       ulElement.style.justifyContent = ''; // Revert justify-content if not greater
//       ulElement.style.width = '1000%'; // as default
//       console.log('here we have ulElement.offsetWidth < totalWidth');
//     }
//   };

// function handleMetaslider() {
//   // JavaScript code goes here
//   var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
//   var liElements = ulElement.getElementsByTagName('li');

//   var totalWidth = 0;

//   for (var i = 0; i < liElements.length; i++) {
//     totalWidth += liElements[i].offsetWidth; // Width of the li element
//     if (i < liElements.length - 1) {
//       // Add space between elements (margin-right)
//       totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
//     }
//   }

//   console.log('Total width including spaces: ' + totalWidth + 'px');
//   console.log('JS with DOM');

//   // Now, check if the ul.slides width is greater than totalWidth
//   if (ulElement.offsetWidth > totalWidth) {
//     ulElement.style.display = 'flex';
//     ulElement.style.justifyContent = 'center'; // Add justify-content: center
//     ulElement.style.width = '100%';
//   } else {
//     ulElement.style.display = 'block'; // Revert to the default value if it's not greater
//     ulElement.style.justifyContent = ''; // Revert justify-content if not greater
//     ulElement.style.width = '1000%'; // as default
//   }
// }

function calculateTotalWidth() {
  var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
  var liElements = ulElement.getElementsByTagName('li');

  var totalWidth = 0;

  for (var i = 0; i < liElements.length; i++) {
    totalWidth += liElements[i].offsetWidth; // Width of the li element
    if (i < liElements.length - 1) {
      // Add space between elements (margin-right)
      totalWidth += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
    }
  }

  return totalWidth;
}


function handleMetaslider(totalWidth = 1520) {
  // JavaScript code goes here
  var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
  var liElements = ulElement.getElementsByTagName('li');

  // console.log('Total width including spaces: ' + totalWidth + 'px');
  // console.log('JS with DOM');

  console.log('ul.slides.width: ' +ulElement.offsetWidth)
  // Now, check if the ul.slides width is greater than totalWidth
  if (ulElement.offsetWidth > totalWidth) {
    ulElement.style.display = 'flex';
    ulElement.style.justifyContent = 'center'; // Add justify-content: center
    ulElement.style.width = '100%';
    console.log('ul.slide.width is > totalWidth')
  } else {
    ulElement.style.display = 'block'; // Revert to the default value if it's not greater
    ulElement.style.justifyContent = ''; // Revert justify-content if not greater
    ulElement.style.width = '1000%'; // as default
    console.log('ul.slide.width is < totalWidth')
  }
}

// You can call the function without providing a totalWidth argument,
// and it will use the default value of 1520 pixels.
handleMetaslider(); // Default totalWidth of 1520px is used

// Call the function when the DOM content is loaded
document.addEventListener('DOMContentLoaded', handleMetaslider);

// Call the function when the window is resized
window.addEventListener('resize', handleMetaslider);

// Call the function when the page is reloaded
window.addEventListener('load', handleMetaslider);
window.onload = function() {
    var totalWidth = calculateTotalWidth();
    console.log('Total width including spaces: ' + totalWidth + 'px');
    handleMetaslider(totalWidth);
  };
