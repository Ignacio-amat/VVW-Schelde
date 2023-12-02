/**
 * Populates the form with hidden inputs based on the topics and unassigned questions
 */
function populateForm() {
    const hiddenInputs = document.getElementById('hiddenInputs');
    hiddenInputs.innerHTML = '';

    const topicContainers = document.querySelectorAll('.topic-container');

    topicContainers.forEach((topicContainer, i) => {
        const titleInput = document.createElement('input');
        titleInput.type = 'hidden';
        titleInput.name = 'topics[' + i + '][title]';
        titleInput.value = topicContainer.querySelector('.topic-title').value;
        hiddenInputs.appendChild(titleInput);

        const questions = topicContainer.querySelectorAll('.question');
        questions.forEach((question, j) => {
            const questionIdInput = document.createElement('input');
            questionIdInput.type = 'hidden';
            questionIdInput.name = 'topics[' + i + '][questions][' + j + '][id]';
            questionIdInput.value = question.getAttribute('id');
            hiddenInputs.appendChild(questionIdInput);

            const questionContentInput = document.createElement('input');
            const content = question.getElementsByClassName('question-handle')[0];
            questionContentInput.type = 'hidden';
            questionContentInput.name = 'topics[' + i + '][questions][' + j + '][content]';
            questionContentInput.value = content.innerHTML;
            hiddenInputs.appendChild(questionContentInput);

            const questionRequiredInput = document.createElement('input');
            const checkbox = question.querySelector('input[type="checkbox"]');
            questionRequiredInput.type = 'hidden';
            questionRequiredInput.name = 'topics[' + i + '][questions][' + j + '][is_required]';
            questionRequiredInput.value = checkbox.checked ? '1' : '0';
            hiddenInputs.appendChild(questionRequiredInput);
        });
    });

    const unassignedQuestionContainer = document.getElementsByClassName('unassigned-questions')[0];
    const unassignedQuestions = unassignedQuestionContainer.querySelectorAll('.question');
    unassignedQuestions.forEach((question, i) => {
        const questionIdInput = document.createElement('input');
        questionIdInput.type = 'hidden';
        questionIdInput.name = 'unassignedQuestions][' + i + '][id]';
        questionIdInput.value = question.getAttribute('id');
        hiddenInputs.appendChild(questionIdInput);

        const questionContentInput = document.createElement('input');
        const content = question.getElementsByClassName('question-handle')[0];
        questionContentInput.type = 'hidden';
        questionContentInput.name = 'unassignedQuestions][' + i + '][id[content]';
        questionContentInput.value = content.innerHTML;
        hiddenInputs.appendChild(questionContentInput);
    })
}

/**
 * Deletes topic and moves contents to unassigned questions
 */
function removeTopic() {
    const topic = $(this).closest('.topic-container');
    const questions = topic.find('.question');
    questions.appendTo('.unassigned-container .question-list');
    topic.remove();
}

//Initiates sortable functionality and attaches action to new topic button
$(document).ready(function() {
    $('.remove-topic-btn').click(removeTopic);

    $('.topic-list').sortable({
        handle: '.topic-handle',
    });

    $('.question-list').sortable({
        connectWith: '.question-list',
        handle: '.question-handle',
        dropOnEmpty: true
    });

    //Attaches function for creating new topic container to a button
    $('#new-topic-btn').click(function() {
        const newTopicContainer = $('<div>').addClass('topic-container');
        const newTopic = $('<div>').addClass('topic');
        const topicHandle = $('<div>').addClass('topic-handle').html('&#9776; Topic*:');
        const topicTitle = $('<input>').addClass('topic-title').attr('type', 'text').attr('placeholder', 'New topic');
        const topicQuestions = $('<div>').addClass('topic-questions');
        const questionList = $('<div>').addClass('question-list');
        const questionListHeader = $('<div>').addClass('question-list-header').html('<div>QUESTION</div><div>Require response</div>');
        const emptyMessage = $('<div>').addClass('empty-questions').html('DRAG QUESTIONS HERE');
        const removeTopicBtn = $('<button>').addClass('remove-topic-btn');

        topicHandle.append(topicTitle);
        newTopic.append(topicHandle);
        newTopic.append(removeTopicBtn);

        newTopicContainer.append(newTopic);
        questionList.append(emptyMessage);
        topicQuestions.append(questionListHeader);
        topicQuestions.append(questionList)
        newTopicContainer.append(topicQuestions);

        $('.topic-list').children().eq(0).after(newTopicContainer);

        questionList.sortable({
            connectWith: '.question-list',
            handle: '.question-handle',
            dropOnEmpty: true
        });

        removeTopicBtn.click(removeTopic);
    });
});

/**
 * Updates the table of unassigned questions based on input
 */
function searchQuestions() {
    const query = document.getElementById('searchInput').value.toLowerCase();

    const unassignedContainer = document.getElementsByClassName('unassigned-questions')[0];
    const questions = unassignedContainer.querySelectorAll('.question');

    for (let i = 0; i < questions.length; i++) {
        const question = questions[i];
        const questionText = question.getElementsByClassName('question-handle')[0].innerText.toLowerCase();

        if (questionText.includes(query)) {
            question.style.display = 'block'; // Show the question
        } else {
            question.style.display = 'none'; // Hide the question
        }
    }
}

