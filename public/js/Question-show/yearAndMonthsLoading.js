function loadYearsAndMonths(selectedQuestion, yearDiv, monthDiv) {
    let years = categories.getYearsWithinQuestion(selectedQuestion);

    years.forEach(function (year, index){
         let yearElement = document.createElement('div');
         yearElement.innerHTML = year;
         yearElement.className = 'year';
         yearElement.id = index;
         yearElement.addEventListener('click', onYearClicked)
         yearDiv.appendChild(yearElement);
    });

    let months = categories.getMonthsWithinQuestion(selectedQuestion);

    months.forEach(function(month, index) {
       let monthElemetn = document.createElement('div');
       monthElemetn.innerHTML = month;
       monthElemetn.className = 'month';
       monthElemetn.id = index;
       monthElemetn.addEventListener('click', onMonthClicked);
       monthDiv.appendChild(monthElemetn);
    });
}

