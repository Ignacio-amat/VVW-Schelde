let categories;
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

/**
 * Loads all of the data
 * @returns {Promise<void>} promise
 */
async function init()
{
    const currentLocation = window.location;
    let category = await getData(`api/categories/get-category-data${currentLocation.pathname}`);
    let questions = [];
    category.questions.forEach(question =>{
        let answers = [];
       question.answers.forEach(answer => {
            answers.push(new Answer(answer.text, answer.date));
       })
        questions.push(new Question(answers, question.title, question.type))
    });
    categories = new Category(questions, category.name,document.getElementById('graph') );
    categories.chart = renderChart(categories.chart, categories.getLabelsOfQuestions(),"Overview", categories.getAverage());
    
    selectedQuestion = 'overview';
}

init();

function onOverviewClick(){
    selectedQuestion = 'overview'
    categories.chart = renderChart(categories.chart, categories.getLabelsOfQuestions(),"Overview", categories.getAverage());
    reset();
}



