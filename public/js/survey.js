let questions = null;
let surveyTopics = null;
let conditionalQuestions = null;
const surveyFormElement = document.getElementById('surveyList');
let surveyTopicArray = [];
let surveyIterator = 0;
const backButton = document.getElementById('backButton');
const nextButton = document.getElementById('nextButton');


backButton.addEventListener('click', function () {
    surveyIterator--;
    surveyCheck();
});
nextButton.addEventListener('click', function (){

            surveyIterator++;
            surveyCheck();
});


function setFollowingQuestion() {
    for (let i = 0; i <conditionalQuestions.length; i++) {
        const questionID = conditionalQuestions[i].question_id;
        const conditionalQuestionID = conditionalQuestions[i].conditional_question_id;
        if (checkQuestionInSurvey(conditionalQuestionID)) hiddenFollowingQuestion(conditionalQuestionID);
        if (checkQuestionInSurvey(questionID)) {
            const inputElements = document.getElementsByName('Radio' + questionID);
            if (getQuestionById(questionID).type === 'RadioBool' ) {
                inputElements[0].addEventListener('click', function () {
                    if (conditionalQuestions[i].condition === 'Yes') {
                        showFollowingQuestion(conditionalQuestionID);
                    } else {
                        hiddenFollowingQuestion(conditionalQuestionID);
                    }
                });
                inputElements[1].addEventListener('click', function () {
                    if (conditionalQuestions[i].condition === 'No') {
                        showFollowingQuestion(conditionalQuestionID);
                    } else {
                        hiddenFollowingQuestion(conditionalQuestionID);
                    }
                });
            }
            if (getQuestionById(questionID).type === 'RadioGrade') {
                const conditionArray = conditionalQuestions[i].condition.split(' ');
                if (conditionArray[0] === 'below'){
                    for (let j = 0; j < inputElements.length; j++) {
                        if (j < conditionArray[1]) {
                            inputElements[j].addEventListener('click', function () {
                                showFollowingQuestion(conditionalQuestionID);
                            });
                        } else {
                            inputElements[j].addEventListener('click', function () {
                                hiddenFollowingQuestion(conditionalQuestionID);
                            });
                        }
                    }
                }else if (conditionArray[0] === 'above') {
                    for (let j = 0; j < inputElements.length; j++) {
                        if (j > conditionArray[1] - 1) {
                            inputElements[j].addEventListener('click', function () {
                                showFollowingQuestion(conditionalQuestionID);
                            });
                        } else {
                            inputElements[j].addEventListener('click', function () {
                                hiddenFollowingQuestion(conditionalQuestionID);
                            });
                        }
                    }
                }
            }
        }
    }
}


//create survey topic divElement on asideMenu
function createTopicOnAsideMenu(){
    const asideMenu = document.getElementById('asideMenu');
    for (let i = 0; i < surveyTopicArray.length; i++) {
        const divTopicElement = document.createElement('div');
        divTopicElement.id = surveyTopicArray[i] + 'asideMenu';
        divTopicElement.innerText = surveyTopicArray[i];
        divTopicElement.addEventListener('click', function () {
            surveyIterator = i;
            surveyCheck();
        });
        asideMenu.appendChild(divTopicElement);
    }
}

// create question
function checkQuestionInSurvey(questionId) {
    for (let i = 0; i < questions.length; i++) {
        if (questions[i].id === questionId && questions[i].in_survey === 1) return true;
    }
}



    function getQuestionById(questionId) {
        for (let i = 0; i < questions.length; i++) {
            if (questions[i].id === questionId) return questions[i];
        }
        return null;
    }


    function hiddenFollowingQuestion(questionId) {
        document.getElementById('questionID_' + questionId).style.display = 'none';
        document.getElementById('questionID_' + questionId).value = '';
    }

    function showFollowingQuestion(questionId) {

        document.getElementById('questionID_' + questionId).style.display = 'block';
    }

    function displaySurveyTopic() {
        for (let i = 0; i < surveyTopicArray.length; i++) {
            document.getElementById(surveyTopicArray[i]).style.display = 'none';
        }
        document.getElementById(surveyTopicArray[surveyIterator]).style.display = 'block';
    }

    function surveyCheck() {
        document.getElementById('pageHeader').innerText = surveyTopicArray[surveyIterator];

        for (let i = 0; i < surveyTopicArray.length; i++) {
            document.getElementById(surveyTopicArray[i] + 'asideMenu').className = 'topic';
        }
        document.getElementById(surveyTopicArray[surveyIterator] + 'asideMenu').className = 'topic divActive';


        if (surveyIterator === 0) {
            backButton.style.display = 'none';
        }
        if (surveyIterator !== 0) backButton.style.display = 'block';
        if (surveyIterator !== surveyTopicArray.length - 1) {
            nextButton.style.display = 'block';
            document.getElementById('submit').style.display = 'none';
        }
        if (surveyIterator === surveyTopicArray.length - 1) {
            nextButton.style.display = 'none';
            backButton.style.display = 'none';
            document.getElementById('submit').style.display = 'block';
        }
        displaySurveyTopic();
    }

// get data from database
    async function init() {
        const path = window.location;
        try {
            let response = await fetch(`${path.origin}/api/questions/all`);
            questions = await response.json();
        } catch (err) {
            console.error("Error: ", err);
        }

        try {
            const response = await fetch(`${path.origin}/api/survey_questions/all`);
            surveyTopics = await response.json();
        } catch (err) {
            console.error("Error: ", err);
        }

        try {
            const response = await fetch(`${path.origin}/api/conditional_questions/all`);
            conditionalQuestions = await response.json();
        } catch (err) {
            console.error("Error: ", err);
        }

        for (let i = 0; i < surveyTopics.length; i++) {

            if (!surveyTopicArray.includes(surveyTopics[i].topic)) {
                surveyTopicArray.push(surveyTopics[i].topic);
            }
        }

        displaySurveyTopic();
        if (surveyIterator === 0) backButton.style.display = 'none';
        const submitElement = document.createElement('div');
        submitElement.id = 'submit';
        submitElement.innerHTML = '<input type="submit">';
        submitElement.style.display = 'none';
        surveyFormElement.appendChild(submitElement);
        createTopicOnAsideMenu();
        surveyCheck();
        setFollowingQuestion();

    }

init();
