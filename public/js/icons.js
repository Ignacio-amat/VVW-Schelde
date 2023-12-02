// Get all the div elements with the class "my-div"
const divs = document.getElementsByClassName("icon-item");
// Add click event listeners to each div
for (let i = 0; i < divs.length; i++) {
    divs[i].addEventListener("click", function() {

        // Remove the "selected" class from all divs
        for (let j = 0; j < divs.length; j++) {
            divs[j].classList.remove("selected");
        }

        document.getElementById('imageContainer').value = loadImage(divs[i].childNodes);

        // Add the "selected" class to the clicked div
        this.classList.add("selected");
    });
}

function loadImage(img) {
    let image = img;
    let slashCount = 0;
    let rightString = '';
    Array.from(image[0].src).forEach(char =>{
        if (char =='/' && slashCount < 3) {
            slashCount++;
        }
        if (slashCount === 3) {
            rightString += char;
        }
    });
    return rightString;
}
