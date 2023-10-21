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
var totalWidth = null; // Declare totalWidth as a global variable

function calculateTotalWidth() {
  var ulElement = document.getElementById('metaslider-id-640').querySelector('ul.slides');
  var liElements = ulElement.getElementsByTagName('li');

  var width = 0; // Use a local variable for the calculation

  for (var i = 0; i < liElements.length; i++) {
    width += liElements[i].offsetWidth; // Width of the li element
    if (i < liElements.length - 1) {
      // Add space between elements (margin-right)
      width += parseInt(window.getComputedStyle(liElements[i]).marginRight, 10);
    }
  }

  // Check if width is an event object (remove this part if it's not relevant)

  console.log('forcing to be a number');
  // Ensure width is a number
  width = Number(width);

  return width; // Return the calculated value
}

// Call calculateTotalWidth to set the global variable
calculateTotalWidth();

function handleMetaslider(width = 1520) {
  // JavaScript code goes here
  var ulElement = document.getElementById('metaslider_container_640')//.querySelector('ul.slides');
  var liElements = ulElement.getElementsByTagName('li');

  // console.log('Total width including spaces: ' + totalWidth + 'px');
  // console.log('JS with DOM');

  // Now, check if the ul.slides width is greater than totalWidth
  if (ulElement.offsetWidth > width) {
    ulElement.style.display = 'flex';
    ulElement.style.justifyContent = 'center'; // Add justify-content: center
    ulElement.style.width = '100%';
    console.log('====================')
    console.log('ul.slide.width is: ' + ulElement.offsetWidth + '> totalWidth: ' + width)
  } else {
    ulElement.style.display = 'block'; // Revert to the default value if it's not greater
    ulElement.style.justifyContent = ''; // Revert justify-content if not greater
    ulElement.style.width = '1000%'; // as default
    console.log('--------------------')
    console.log('ul.slide.width is: ' + ulElement.offsetWidth + '> totalWidth: ' + width)
    console.log('ul.slide.width is < totalWidth')
  }
}

// handleMetaslider();
// Function to handle changes in zoom level
function handleZoomChange() {
  // Recalculate totalWidth when the user zooms in or out
  var totalWidth = calculateTotalWidth();
  console.log('Zooming listened')
  // Call handleMetaslider with the updated totalWidth
  handleMetaslider(totalWidth);
}

// Call the function when the window is resized
window.addEventListener('resize', handleMetaslider);

// Call the function when the page is reloaded
// window.addEventListener('load', handleMetaslider);
window.onload = function() {
    console.log('loaded the webpage')
    console.log('Total width including spaces: ' + totalWidth + 'px');
    totalWidth = calculateTotalWidth(); // Calculate totalWidth after the page has loaded
    handleMetaslider(totalWidth);
  };

// Add an event listener for changes in the user's zoom level (scaling)
// window.addEventListener('resize', handleZoomChange);
