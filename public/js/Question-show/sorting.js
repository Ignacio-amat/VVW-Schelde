let errorHandler = document.getElementById('errorMessages');
let selectedYear = 0;
let selectedMonth = 0;
let selectedMonthString = "";


/**
 * Handles year click event
 * Shows sorted chart/table if all of the fields are selecte
 */
function onYearClicked(){
    years.forEach(yearElement => yearElement.style.background = '#E3E8F6');
    years[this.id].style.background = 'white';
    selectedYear = 1 * this.innerText;
    handleErrors(selectedQuestion);
    if (selectedYear !== 0 && selectedMonth !== 0) {
        showSortedValues(selectedQuestion);
    }
}

/**
 * Handles month click event
 * Shows sorted chart/table if all fothe fileds are selected
 */
function onMonthClicked(){
    months.forEach(monthElement => monthElement.style.background = '#E3E8F6 ');
    months[this.id].style.background = 'white';
    selectedMonth = clearDate(this.innerText);
    selectedMonthString = this.innerText;
    handleErrors(selectedQuestion);
    if (selectedYear !== 0 && selectedMonth !== 0) {
        showSortedValues(selectedQuestion);
    }
}

/**
 * Show chart/table with the sorted answers
 *
 * @param selectedQuestion question that has been selected
 * @param chartType chart type to display
 */
function showSortedValues(selectedQuestion, chartType = 'bar') {
    if (categories.isQuestionNumeric(selectedQuestion)) {
        categories.chart = renderChart(categories.chart, categories.getLabelsBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion), categories.getQuestionHeader(selectedQuestion), categories.getValuesBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion), chartType);
    }
    else{
        generateSoredTable(categories.getValuesBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion), categories.getLabelsBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion));
    }
}

/**
 * Checks if only year is selected
 * @returns {boolean} true if only year is selected otherwise false
 */
function isOnlyYearSelected(){
    if (selectedYear !== 0 && selectedMonth === 0)
        return true;
    return false;
}

/**
 * Checks if only month is selected
 *
 * @returns {boolean} true or false accordingly
 */
function isOnlyMonthSelected(){
    if (selectedYear === 0 && selectedMonth !== 0)
        return true;
    return false;
}

/**
 * Checks if year and months are selected
 *
 * @returns {boolean} true or false accordingly
 */
function areYearAndMonthSelected() {
    if (selectedYear !== 0 && selectedMonth !== 0)
        return true;
    return false;
}

/**
 * Function that handles errors and display them
 *
 * @param selectedQuestion what question was selected
 */
function handleErrors(selectedQuestion) {
    if (isOnlyYearSelected()){
        errorHandler.innerHTML = 'Please select month as well'
    }
    else if (isOnlyMonthSelected()){
        errorHandler.innerHTML = 'Please select year as well'
    }
    else if (categories.getLabelsBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion).length == 0
        || categories.getValuesBasedOnYearAndMonth(selectedYear, selectedMonth, selectedQuestion).length== 0)
    {
        errorHandler.innerHTML = `Selected date does not exist please try to select different dates`
    }
    else {
        errorHandler.innerHTML = '';
    }
}

/**
 * Event listener for handling garph type change to LINE
 */
function lineChartSelected() {
    if (selectedQuestion == 'overview') {
        categories.chart = renderChart(categories.chart, categories.getLabelsOfQuestions(),"Overview", categories.getAverage(), 'line');
    }
    else {
        if (areYearAndMonthSelected())
            showSortedValues(selectedQuestion, 'line')
        else
            categories.chart = renderChart(categories.chart, categories.getQuestionLabels(selectedQuestion), categories.getQuestionHeader(selectedQuestion), categories.getQuestionData(selectedQuestion), 'line');
    }
}

/**
 * Event listener for handling garph type change to BAR
 */
function barChartSelected() {
    if (selectedQuestion == 'overview') {
        categories.chart = renderChart(categories.chart, categories.getLabelsOfQuestions(),"Overview", categories.getAverage(), 'bar');
    }
    else {
        if (areYearAndMonthSelected())
            showSortedValues(selectedQuestion, 'bar')
        else
            categories.chart = renderChart(categories.chart, categories.getQuestionLabels(selectedQuestion), categories.getQuestionHeader(selectedQuestion), categories.getQuestionData(selectedQuestion), 'bar');
    }
}

