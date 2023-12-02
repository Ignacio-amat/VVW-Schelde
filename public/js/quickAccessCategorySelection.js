const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const checkboxes = document.querySelectorAll('input[type=checkbox]');

const isChecked = Array.from(checkboxes).map(checkbox => checkbox.checked);

function onSavePressed() {
    checkboxes.forEach((checkbox, index) => {

        //checks if the checkbox was changed
        // if yes it will create new post request
        // if not it will continue checkin without creating a new post request
        if (!checkbox.checked === isChecked[index])
        {
            
            const id = checkbox.value;
            const isChecked = checkbox.checked;
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/quick-access-selection/' + id);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('X-HTTP-Method-Override', 'PUT');
            xhr.send(JSON.stringify({quickAccess: isChecked}));
        }
    });
}
