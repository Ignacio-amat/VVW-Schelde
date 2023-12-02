const RADIO_BUTTON = "Radio";
const RADIO_BUTTON_GRADE = "RadioGrade";
const TEXT = "Text";
let isFirstChart = true;


class Answer {
    constructor(value, date) {
        this.value = value;
        this.date = date;
        this.month = 1 * date.slice(5, 7);
        this.year = 1 * date.slice(0, 4);
    }
}


class Question {
    constructor(answers, text, type) {
        this.answers = answers;
        this.text = text;
        this.type = type;
    }
}

class Category {
    constructor(questions, title, chart) {
        this.questions = questions;
        this.title = title;
        this.chart = chart;
    }

    /**
     * Get the labels of the questions that are within the category
     *
     * @param numeric:bool should return labels from numeric questions
     * @returns {[]} labels of every question
     */
    getLabelsOfQuestions(numeric = true) {
        let labels = []
        this.questions.forEach(question => {
            if (question.text != null && numeric) {
                if (question.type === RADIO_BUTTON || question.type === RADIO_BUTTON_GRADE)
                    labels.push(question.text);
            } else if (question.text != null && !numeric) {
                if (question.type === TEXT)
                    labels.push(question.text);
            }
        });
        return labels;
    }

    /**
     * Gets average of every category
     * @returns {[]} array of numbers of every cattegory
     */
    getAverage() {
        let averages = [];
        this.questions.forEach(question => {
            let sum = 0;
            let count = 0;
            if (question.type === RADIO_BUTTON || question.type === RADIO_BUTTON_GRADE) {
                if (question.text != null) {
                    question.answers.forEach(answer => {
                        sum += 1 * answer.value;
                        count += 1;
                    })
                }
                averages.push(sum / count)
            }
        })

        return averages;
    }

    /**
     * Gets the labels (dates) of the specified question
     *
     * @param questionIndex question for which to return the labels
     * @returns {[]} array of labels :string
     */
    getQuestionLabels(questionIndex) {
        let labels = [];
        if (this.questions[questionIndex].type === RADIO_BUTTON || this.questions[questionIndex].type === RADIO_BUTTON_GRADE) {
            this.questions[questionIndex].answers.forEach(answer => {
                if (answer.value !== null) {
                    labels.push(answer.date)
                }
            })
        } else if (this.questions[questionIndex].type === TEXT) {
            this.questions[questionIndex].answers.forEach(answer => {
                if (answer.value !== null) {
                    labels.push(answer.date);
                }
            })
        }
        return labels;
    }

    /**
     * Gets the header of the selected question
     *
     * @param questionIndex question that was slected
     * @returns {*}
     */
    getQuestionHeader(questionIndex) {
        return this.questions[questionIndex].text;
    }

    /**
     * Get all the data for the specified question
     *
     * @param questionIndex question for which to retried the data
     * @param asObj default FALSE if data should be returned as array that contains both date and value or onyl values should be returned
     * @returns retrieved values of the question
     */
    getQuestionData(questionIndex, asObj = false) {
        let data = [];
        this.questions[questionIndex].answers.forEach(answer => {
            if (answer.value !== null) {
                if (asObj) {
                    data.push(answer);
                } else {
                    data.push(answer.value);
                }
            }
        })
        return data;
    }

    /**
     * Specified if question is of numeric type
     * this function can be used to determine weather the dashboard should generate table of graph
     * @param questionIndex question that was selected
     * @returns {boolean} ture if question is numeric otherwise false
     */
    isQuestionNumeric(questionIndex) {
        if (this.questions[questionIndex].type === RADIO_BUTTON || this.questions[questionIndex].type === RADIO_BUTTON_GRADE)
            return true;
        else if (this.questions[questionIndex].type === TEXT)
            return false;
    }

    /**
     * Get values that are within the specified year and month
     *
     * @param year in which year to look for
     * @param month in which month to look for
     * @param selectedQuestion question that was selected
     * @returns values of every ansers that was mathcing the specified parameters
     */
    getValuesBasedOnYearAndMonth(year, month, selectedQuestion) {
        let returnValues = [];
        this.questions[selectedQuestion].answers.forEach(answer => {
            if (answer.value !== null && answer.date !== null) {
                if (answer.year === year && answer.month === month) {
                    
                    returnValues.push(answer.value);
                }
            }
        })
        return returnValues;
    }

    /**
     * Get labels (dates) that are withing the specified date
     *
     * @param year which year to select from
     * @param month which month to select from
     * @param selectedQuestion question that was selected and where to look for the answers
     * @returns dates that are matching the parameter's specification
     */
    getLabelsBasedOnYearAndMonth(year, month, selectedQuestion) {
        let returnValues = [];
        this.questions[selectedQuestion].answers.forEach(answer => {
            if (answer.value !== null && answer.date !== null) {
                if (answer.year === year && answer.month === month) {
                    returnValues.push(answer.date);
                }
            }
        })
        return returnValues;
    }

    /**
     * Get years that are within selected question
     *
     * @param selectedQuestion question that was selected
     * @returns array of years that are in the questtion
     * */
    getYearsWithinQuestion(selectedQuestion) {
        let years = []
        this.questions[selectedQuestion].answers.forEach(answer => {
            if (!years.includes(answer.year)) {
                years.push(answer.year);
                
            }
        });
        return years;
    }

    /**
     * Get months that are within selected question
     *
     * @param selectedQuestion question that was selected
     * @returns array of months that are in the questtion
     * */
    getMonthsWithinQuestion(selectedQuestion) {
        let months = [];
        this.questions[selectedQuestion].answers.forEach(answer => {
            if (!months.includes(monthToString(answer.month))) {
                
                
                months.push(monthToString(answer.month));
            }
        });
        return months;
    }
}

/**
 * Renders chart with the specified parameters
 *
 * @param cahrt instance of chart object
 * @param labels list of strings to be used as labels on X-axis
 * @param title title of the chart
 * @param chartData data to be displayed in the chart
 * @param chartType optional sets the type of chart DEFAULT = bar
 * @returns Chart instance of newly created cahrt classs
 * */
function renderChart(chart, labels, title, chartData, chartType = "bar") {

    try {
        oldTable = document.getElementById('table');
        oldTable.remove()
    } catch (e) {
        //  console.error("Table was not created yet, crating a new one")
    }
    document.getElementById('graph').style.display = "block";
    document.getElementById('selection').style.display = "block";
    let data = {
        labels: labels,
        datasets: [{
            label: title,
            data: chartData,
            borderWidth: 1,
            options: {
                scales: {
                    x: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        border: {
                            display: false
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        }]
    }
    let createdChart
    if (isFirstChart) {
        createdChart = new Chart(document.getElementById('graph'), {
            type: chartType,
            data: data,
        });
        isFirstChart = false;
    } else {
        chart.destroy();
        createdChart = new Chart(document.getElementById('graph'), {
            type: chartType,
            data: data,
        });
    }
    return createdChart;
}

/**
 * Generates table with the given answers
 *
 * @param answers answers to be displayed in the table
 **/
function generateTable(answers) {
    let oldTable;
    try {
        oldTable = document.getElementById('table');
        oldTable.remove()
    } catch (e) {
        console.error("Table was not created yet, crating a new one")
    }
    document.getElementById('graph').style.display = "none";
    document.getElementById('selection').style.display = "none";

    let table = document.createElement('table');
    table.id = 'table';
    let headerRow = document.createElement('th');

    let dateHeader = document.createElement('th');
    dateHeader.textContent = 'Date';
    dateHeader.className = "dateHeader";
    headerRow.appendChild(dateHeader);

    let valueHeader = document.createElement('th');
    valueHeader.textContent = 'Value';
    valueHeader.className = 'answerHeader';
    headerRow.appendChild(valueHeader);


    let tableHeader = document.createElement('thead');
    tableHeader.appendChild(dateHeader);
    tableHeader.appendChild(valueHeader);

    table.appendChild(tableHeader);


    let tableBody = document.createElement('tbody');
    answers.forEach(answer => {
        let date = answer.date;

        let value = answer.value;

        let row = document.createElement('tr');

        let dateCell = document.createElement('td');
        dateCell.textContent = date;
        dateCell.className = "dateCells"
        row.appendChild(dateCell);

        let valueCell = document.createElement('td');
        valueCell.textContent = value;
        valueCell.className = "answersCells";
        row.appendChild(valueCell);

        tableBody.appendChild(row)

    });
    table.appendChild(tableBody);

    document.getElementById('graphDiv').appendChild(table);

}

/**
 * Generates table with sorted answers
 * @param answer answers to be displayed
 * @param dates dates to be displayed
 **/
function generateSoredTable(answers, dates) {
    let oldTable;
    try {
        oldTable = document.getElementById('table');
        oldTable.remove()
    } catch (e) {
        console.error("Table was not created yet, crating a new one")
    }
    
    
    document.getElementById('graph').style.display = "none";
    document.getElementById('selection').style.display = "none";

    let table = document.createElement('table');
    table.id = 'table';
    let headerRow = document.createElement('th');

    let dateHeader = document.createElement('th');
    dateHeader.textContent = 'Date';
    dateHeader.className = "dateHeader";
    headerRow.appendChild(dateHeader);

    let valueHeader = document.createElement('th');
    valueHeader.textContent = 'Value';
    valueHeader.className = 'answerHeader';
    headerRow.appendChild(valueHeader);


    let tableHeader = document.createElement('thead');
    tableHeader.appendChild(dateHeader);
    tableHeader.appendChild(valueHeader);

    table.appendChild(tableHeader);

    
    

    let tableBody = document.createElement('tbody');
    answers.forEach(function (answer, index) {

        let row = document.createElement('tr');

        let dateCell = document.createElement('td');
        dateCell.textContent = dates[index];
        dateCell.className = "dateCells"
        row.appendChild(dateCell);

        let valueCell = document.createElement('td');
        valueCell.textContent = answer;
        valueCell.className = "answersCells";
        row.appendChild(valueCell);
        
        
        tableBody.appendChild(row)

    });
    table.appendChild(tableBody);

    document.getElementById('graphDiv').appendChild(table);

}

/**
 * Converts month string to number
 *
 * @param month month to convert
 * @returns {number|null} month in numeric format
 */
function clearDate(month) {
    
    switch (month) {
        case "Jan":
            return 1;
        case 'Feb':
            return 2;
        case 'Mar':
            return 3;
        case 'Apr':
            return 4;
        case 'May':
            return 5;
        case 'Jun':
            return 6;
        case 'Jul':
            return 7;
        case 'Aug':
            return 8;
        case 'Sep':
            return 9;
        case 'Oct':
            return 10;
        case 'Nov':
            return 11;
        case 'Dec':
            return 12;
        default:
            return null;
    }
}

/**
 * Converts month number to string
 * @param month month to convert
 * @returns {null|string} string format of the month
 */
function monthToString(month) {
    switch (month) {
        case 1:
            return 'Jan';
        case 2:
            return 'Feb';
        case 3:
            return 'Mar';
        case 4:
            return 'Apr';
        case 5:
            return 'May';
        case 6:
            return 'Jun';
        case 7:
            return 'Jul';
        case 8:
            return 'Aug';
        case 9:
            return 'Sep';
        case 10:
            return 'Oct';
        case 11:
            return 'Nov';
        case 12:
            return 'Dec';
        default:
            return null;
    }
}



