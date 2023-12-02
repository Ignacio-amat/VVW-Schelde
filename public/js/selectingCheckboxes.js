document.addEventListener('DOMContentLoaded', function() {
    let checkboxes = document.querySelectorAll('input[type=checkbox]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let deleteSelected = document.getElementById('delete-button');
    
    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].style.display = 'none';
    }

    deleteSelected.style.display = 'none';

    document.getElementById('toggle-checkboxes').addEventListener('click', function() {
        let displayValue = (checkboxes[0].style.display === 'none') ? 'inline' : 'none';

        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].style.display = displayValue;
        }

        deleteSelected.style.display = 'none';
    });

    for (let i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function() {
            let selected = false;

            for (let j = 0; j < checkboxes.length; j++) {
                if (checkboxes[j].checked) {
                    selected = true;
                    break;
                }
            }

            if (selected) {
                deleteSelected.style.display = 'block';
            } else {
                deleteSelected.style.display = 'none';
            }
        });
    }

    deleteSelected.addEventListener('click', function() {
        let categoryIds = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                let categoryBlock = checkbox.closest('.categoryBlock');
                categoryIds.push(checkbox.value);
            }
        });

        if (categoryIds.length > 0) {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('categories').classList.add('blur');
        }
    });

    document.getElementById('delete-yes').addEventListener('click', function() {
        let categoryIds = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                let categoryBlock = checkbox.closest('.categoryBlock');
                categoryBlock.remove();

                categoryIds.push(checkbox.value);
            }
        });

        deleteSelected.style.display = 'none';

        if (categoryIds.length > 0) {
            categoryIds.forEach(categoryID => {
                let xhr = new XMLHttpRequest();
                xhr.open('DELETE', `/categories/${categoryID}`, true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader("x-csrf-token", csrfToken);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {}
                    }
                };

                xhr.send(JSON.stringify({ id: categoryID }));
            });
        }

        document.getElementById('popup').style.display = 'none';
        document.getElementById('categories').classList.remove('blur')
    });

    document.getElementById('delete-no').addEventListener('click', function() {
        document.getElementById('popup').style.display = 'none';
        document.getElementById('categories').classList.remove('blur');
    });
});
