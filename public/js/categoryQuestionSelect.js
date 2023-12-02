// Function to filter and display search results alphabetically
function filterQuestions() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const searchTableContainer = document.getElementsByClassName('search-results')[0];
    const questions = searchTableContainer.getElementsByClassName('question-container');
    const questionsArray = Array.from(questions);

    questionsArray.sort(function (s1, s2) {
        const text1 = s1.getElementsByClassName('question-text')[0].textContent.toUpperCase();
        const text2 = s2.getElementsByClassName('question-text')[0].textContent.toUpperCase();

        if (text1 < text2) {
            return -1;
        }
        if (text1 > text2) {
            return 1;
        }
        return 0;
    });

    for (let i = 0; i < questionsArray.length; i++) {
        const question = questionsArray[i];
        const text = question.getElementsByClassName('question-text')[0].textContent.toUpperCase();

        if (text.indexOf(filter) > -1) {
            question.style.display = '';
        } else {
            question.style.display = 'none';
        }

        searchTableContainer.appendChild(question);
    }
}

// Function to add a question to the category container
function addQuestion(questionId) {
    const questionContainer = document.getElementById(questionId);
    const categoryQuestionsContainer = document.getElementsByClassName('category-questions')[0];
    const button = questionContainer.getElementsByClassName('actionBtn')[0];

    button.setAttribute('onclick', 'removeQuestion("' + questionId + '")');

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'categoryQuestions[]';
    hiddenInput.value = questionId;

    // Append the hidden input field to the idList
    const idList = document.getElementById('questionIdList');
    if (idList) {
        idList.appendChild(hiddenInput);
    }

    categoryQuestionsContainer.appendChild(questionContainer);
    filterQuestions(); // Update the search results
}

// Function to remove a question from the category container and move it back to the search results
function removeQuestion(questionId) {
    const questionContainer = document.getElementById(questionId);
    const searchResultsContainer = document.getElementsByClassName('search-results')[0];
    const button = questionContainer.getElementsByClassName('actionBtn')[0];

    button.setAttribute('onclick', 'addQuestion("' + questionId + '")');

    const hiddenInput = document.querySelector('input[name="categoryQuestions[]"][value="' + questionId + '"]');
    if (hiddenInput) {
        hiddenInput.remove();
    }

    searchResultsContainer.appendChild(questionContainer);
    filterQuestions();
}

// Attach the filterQuestions function to the search bar
document.getElementById('searchInput').addEventListener('keyup', filterQuestions);
