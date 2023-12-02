

async function getData(url) {
    try {
        
        let response = await fetch(url);
        let data = await response.json();
        
        return data;
    }
    catch (err) {
        console.error("Error: ", err);
    }
}
// 7 entries must be subtracted to have only array of answers

async function init() {
    const currentLocation = window.location;
    
    let categories = await getData(`${currentLocation.origin}/api/categories/all`);
    
    const categoriesCount = Object.values(categories).length;
    let parentList = document.getElementById('parentList')
    for (let i = 0; i < categoriesCount; i++) {
        if (categories[i].quickAccess) {

            let listItem = document.createElement('li');
            listItem.style.padding = "10px";
            listItem.className = 'asideMenuListItem';

            let link = document.createElement('a');
            link.href = `/${categories[i].id}`
            link.className = 'asideMenuLink';
            link.innerHTML = categories[i].name

            let image = document.createElement('img');
            image.src = categories[i].image;
            image.className = "categoryIcon";

            if (`/${categories[i].id}` === currentLocation.pathname.toString()) {
                listItem.classList.add('active');
            }

            listItem.appendChild(image);
            listItem.appendChild(link);
            parentList.appendChild(listItem);
            }
        }
}

init();


