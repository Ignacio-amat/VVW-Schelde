// 7 entries must be subtracted to have only array of answers

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
async function init() {
    let questionsInCategory = await getData('api/categories/get-categories-questions/1');
    
    let answers = []
    for (let i = 0; i < questionsInCategory.length; i++) {
        answer = await getData(`/api/answers/${questionsInCategory[i].id}`)
        answers.push(answer);
    }
    
}

init();




