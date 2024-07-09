const form = document.getElementById("add-user-form");


form.addEventListener('submit', addUser)

async function addUser(event) {
    event.preventDefault();
    let formData = new FormData(form)
    let objectError = {
        emailErrorSpan: document.getElementById('emailError'),
        nameErrorSpan: document.getElementById('nameError'),
        phoneErrorSpan: document.getElementById('phoneError'),
        photoErrorSpan: document.getElementById('photoError'),
        positionErrorSpan: document.getElementById('positionError'),
    }

    for(let errorEntity of Object.values(objectError) ){
        errorEntity.textContent = ''
    }

    try {
        document.getElementById('loader').style.display = 'block';
         await axios.post(`/user/add`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        document.cookie = "name=value; max-age=10";
        window.location.href = '/';
    } catch (error) {

        if (error.response && error.response.data ) {
            if(error.response.data.errors) {
                if(error.response.data.errors.email){
                    objectError.emailErrorSpan.textContent = error.response.data.errors.email
                }
                if (error.response.data.errors.name) {
                    objectError.nameErrorSpan.textContent = error.response.data.errors.name
                }
                if (error.response.data.errors.photo) {
                    objectError.photoErrorSpan.textContent = error.response.data.errors.photo

                }
                if (error.response.data.errors.phone) {
                    objectError.phoneErrorSpan.textContent = error.response.data.errors.phone
                }
                if (error.response.data.errors.position_id) {
                    objectError.positionErrorSpan.textContent = error.response.data.errors.position_id
                }
            }
        }
    }
    document.getElementById('loader').style.display = 'none';
}
