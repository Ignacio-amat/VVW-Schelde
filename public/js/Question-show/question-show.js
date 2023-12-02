let questionBlocks = Array.from(document.getElementById('scrollingSection').children);
let yearsDiv = document.getElementById('years');
let monthsDiv = document.getElementById('months');
let years = [];
let months = [];
let selectedQuestion = null;

questionBlocks.forEach(function (questionBlock, index) {
    questionBlock.addEventListener('click', questionBlockClick);
    questionBlock.id = index++;
})


function questionBlockClick() {
    selectedQuestion = this.id;
    reset();
    loadYearsAndMonths(selectedQuestion, yearsDiv,monthsDiv )
    months = Array.from(document.getElementById('months').children);
    years = Array.from(document.getElementById('years').children);
    if (categories.isQuestionNumeric(selectedQuestion)) {
        categories.chart = renderChart(categories.chart, categories.getQuestionLabels(selectedQuestion), categories.getQuestionHeader(selectedQuestion), categories.getQuestionData(selectedQuestion));
    }
    else{
        generateTable(categories.getQuestionData(selectedQuestion, true));
    }
}

/**
 * Resets the state of the selected question logic
 */
function reset() {
    selectedYear = 0;
    selectedMonth = 0;
    years.forEach(year => {year.style.background = '#E3E8F6'; year.remove();});
    months.forEach(month => {month.style.background = '#E3E8F6'; month.remove();});
    errorHandler.innerHTML = "";
    questionBlocks.forEach(questionBlock => {questionBlock.style.background = 'white'; questionBlock.style.scale= 1.0; questionBlock.style.border = "none"});
    questionBlocks[selectedQuestion].style.scale = 0.9;
    questionBlocks[selectedQuestion].style.border = "2px solid darkblue";
}


