
let updatedProfileImage = '';
const editButton = document.querySelector('.edit-button');
const detailsSection = document.querySelector('.details');
const profileForm = document.getElementById('profileForm');

editButton.addEventListener('click', () => {
    editButton.style.display = 'none';
    detailsSection.style.display = 'none';
    profileForm.style.display = 'block';
});

profileForm.addEventListener('submit', (e) => {
    e.preventDefault();

    const nameInput = document.getElementById('nameInput').value;
    const emailInput = document.getElementById('emailInput').value;

    const nameLabel = document.querySelector('.name');
    const emailLabel = document.querySelector('.email');

    nameLabel.textContent = nameInput;
    emailLabel.textContent = emailInput;

    // Send updated data to server using AJAX
    const formData = new FormData(profileForm);
    
fetch('../actions/action_updateUser.php', {
    method: 'POST',
    body: formData
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        // Handle success or display any messages from the server
        console.log(data); // You can log the response from the server for debugging
        location.reload();
    })
    .catch(error => {
        console.error('There was a problem with your fetch operation:', error);
    });

    editButton.style.display = 'block';
    detailsSection.style.display = 'block';
    profileForm.style.display = 'none';
    profileForm.reset();
    updatedProfileImage = '';
});

document.addEventListener('DOMContentLoaded', () => {
    const promoteButton = document.getElementById('promoteButton');
    const userTypeSelect = document.getElementById('userTypeSelect');
    const profileContainer = document.querySelector('.profile-container');
    const userId = profileContainer.getAttribute('data-user-id');

    if (promoteButton) {
        promoteButton.addEventListener('click', () => {
            const newUserType = userTypeSelect.value;

            fetch('../actions/action_promoteUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ userId, newUserType })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('userType').textContent = newUserType.charAt(0).toUpperCase() + newUserType.slice(1);
                } else {
                    alert('Failed to promote user.');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});



