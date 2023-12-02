/**
 * Displays the option / follow-up editing menu if required by answer type
 */
function toggleOptions() {
    const optionsContainer = document.getElementById('option-container');
    const followUpQuestionContainer = document.getElementById('followUpQuestions');
    const answerType = document.getElementById('type').value;

    if (answerType === 'Radio' || answerType === 'Checkbox') {
        optionsContainer.style.display = '';
    } else {
        optionsContainer.style.display = 'none';
    }

    if (answerType === 'RadioBool' || answerType === 'RadioGrade') {
        followUpQuestionContainer.style.display = '';
        changeConditionSelectors(answerType);
    } else {
        followUpQuestionContainer.style.display = 'none';
    }
}

/**
 * Creates a new input field for the option with a remove button
 */
function addOption() {
    const optionsContainer = document.getElementById('options');
    const optionDiv = document.createElement('div');
    optionDiv.className = 'option';
    const optionInput = document.createElement('input');
    optionInput.type = 'text';
    optionInput.name = 'options[]';
    optionDiv.appendChild(optionInput);

    const removeButton = document.createElement('div');
    removeButton.className = 'option-rmv-button';
    removeButton.onclick = function() {
        removeOption(this);
    };
    optionDiv.appendChild(removeButton);

    optionsContainer.appendChild(optionDiv);
}

/**
 * Removes the option field
 */
function removeOption(button) {
    const optionDiv = button.parentNode;
    optionDiv.parentNode.removeChild(optionDiv);
}

/**
 * Search of the following questions table
 */
function searchTable() {
    const searchInput = document.getElementById("searchInput").value.toLowerCase();
    const searchResults = document.getElementById("searchResults");
    const followingQuestions = searchResults.getElementsByClassName("following-question");

    for (let i = 0; i < followingQuestions.length; i++) {
        const questionText = followingQuestions[i].getElementsByClassName("f-question-text")[0].innerText.toLowerCase();

        if (questionText.includes(searchInput)) {
            followingQuestions[i].style.display = "flex";
        } else {
            followingQuestions[i].style.display = "none";
        }
    }
}

/**
 * Creates a followup question container in the followup questions list
 * where the user can select the condition for follow
 *
 * @param questionId
 */
function addFollowUpQuestion(questionId) {
    const questionContainer = document.getElementById(questionId);
    const button = questionContainer.getElementsByClassName('fq-btn')[0];
    button.setAttribute('onclick', 'removeFollowUpQuestion("' + questionId + '")');

    const followUpContainer = document.createElement('div');
    followUpContainer.className = 'followup-container';
    const conditionContainer = document.createElement('div');
    conditionContainer.className = 'condition-container';
    const conditionIndicator = document.createElement('div');
    conditionIndicator.innerText = 'The above question will follow this one in the survey if the user selects:';
    conditionContainer.appendChild(conditionIndicator);

    const answerType = document.getElementById('type').value;
    if (answerType == 'RadioBool') {

        const ynSelector = document.createElement('select');
        const yesOption = document.createElement('option');
        yesOption.text = 'Yes';
        yesOption.value = 'Yes';
        ynSelector.add(yesOption);
        const noOption = document.createElement('option');
        noOption.text = 'No';
        noOption.value = 'No';
        ynSelector.add(noOption);
        const selectContainer = document.createElement('div');
        selectContainer.className = 'conditions';
        selectContainer.appendChild(ynSelector);
        conditionContainer.appendChild(selectContainer);
    } else if (answerType == 'RadioGrade') {
        const baSelector = document.createElement('select');
        const belowOption = document.createElement('option');
        belowOption.text = 'Below';
        belowOption.value = 'Below';
        baSelector.add(belowOption);
        const aboveOption = document.createElement('option');
        aboveOption.text = 'Above';
        aboveOption.value = 'Above';
        baSelector.add(aboveOption);
        const limitSelector = document.createElement('select')
        for (let i = 1; i <= 10; i++) {
            let option = document.createElement("option");
            option.value = i;
            option.text = i;
            limitSelector.add(option);
        }
        const selectContainer = document.createElement('div');
        selectContainer.className = 'conditions';
        selectContainer.appendChild(baSelector);
        selectContainer.appendChild(limitSelector);
        conditionContainer.appendChild(selectContainer);
    }

    followUpContainer.appendChild(questionContainer);
    followUpContainer.appendChild(conditionContainer);

    const selectedQuestions = document.getElementById('selectedQuestions');
    selectedQuestions.appendChild(followUpContainer);
}

/**
 * Removes follow-up question from list into the search table
 * @param questionId
 */
function removeFollowUpQuestion(questionId) {
    const questionContainer = document.getElementById(questionId);
    const button = questionContainer.getElementsByClassName('fq-btn')[0];
    button.setAttribute('onclick', 'addFollowUpQuestion("' + questionId + '")');

    const followUpContainer = questionContainer.parentNode;
    followUpContainer.parentNode.removeChild(followUpContainer);

    const searchResults = document.getElementById('searchResults');
    searchResults.appendChild(questionContainer);
}

/**
 * Changes the condition selector based on if question is Numeric or Boolean
 * @param answerType
 */
function changeConditionSelectors(answerType) {
    const conditionContainers = document.getElementsByClassName('conditions');
    for (let i = 0; i < conditionContainers.length; i++) {
        const conditionContainer = conditionContainers[i];

        while (conditionContainer.firstChild) {
            conditionContainer.removeChild(conditionContainer.firstChild);
        }

        if (answerType === 'RadioBool') {
            const ynSelector = document.createElement('select');
            const yesOption = document.createElement('option');
            yesOption.text = 'Yes';
            yesOption.value = 'Yes';
            ynSelector.add(yesOption);
            const noOption = document.createElement('option');
            noOption.text = 'No';
            noOption.value = 'No';
            ynSelector.add(noOption);
            conditionContainer.appendChild(ynSelector);
        } else if (answerType === 'RadioGrade') {
            const baSelector = document.createElement('select');
            const belowOption = document.createElement('option');
            belowOption.text = 'Below';
            belowOption.value = 'Below';
            baSelector.add(belowOption);
            const aboveOption = document.createElement('option');
            aboveOption.text = 'Above';
            aboveOption.value = 'Above';
            baSelector.add(aboveOption);
            const limitSelector = document.createElement('select')
            for (let j = 1; j <= 10; j++) {
                let option = document.createElement("option");
                option.value = j; // Set the option value to the number
                option.text = j; // Set the option text to the number
                limitSelector.add(option);
            }
            conditionContainer.appendChild(baSelector);
            conditionContainer.appendChild(limitSelector);
        }
    }
}

/**
 * Populates form with hidden inputs
 */
function populateForm() {
    const text = document.getElementById('text').value;
    const textInput = document.getElementById('hidden-text');
    textInput.value = text;

    const type = document.getElementById('type').value;
    const typeInput = document.getElementById('hidden-type');
    typeInput.value = type;

    if (type == 'Radio' || type == 'Checkbox') {
        const options = document.getElementsByName('options[]');
        const optionInputs = document.getElementById('hidden-options');
        Array.from(options).forEach(option => {
            const optionInput = document.createElement('input');
            optionInput.type = 'hidden';
            optionInput.name = 'options[]';
            optionInput.value = option.value;
            optionInputs.appendChild(optionInput);
        });
    }

    if (type == 'RadioGrade' || type == 'RadioBool') {
        const followUpsInput = document.getElementById('hidden-follow-ups');
        followUpsInput.innerHTML = '';

        const followUpQuestions =  document.getElementsByClassName('followup-container');
        Array.from(followUpQuestions).forEach((followUp, index) => {
            const questionContainer = followUp.getElementsByClassName('following-question')[0];
            const questionId = questionContainer.id;

            const questionIdInput = document.createElement('input');
            questionIdInput.type = 'hidden';
            questionIdInput.name = `followUps[${index}][questionId]`;
            questionIdInput.value = questionId;
            followUpsInput.appendChild(questionIdInput);

            const conditionContainer = document.getElementsByClassName('condition-container')[0];
            const conditions = conditionContainer.getElementsByTagName('select');
            const values = [];
            Array.from(conditions).forEach(selection => {
                values.push(selection.value);
            })
            const condition = values.join(" ");

            const conditionInput = document.createElement('input');
            conditionInput.type = 'hidden';
            conditionInput.name = `followUps[${index}][condition]`;
            conditionInput.value = condition;
            followUpsInput.appendChild(conditionInput);
        })
    }
}
