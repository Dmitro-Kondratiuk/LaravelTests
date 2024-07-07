const form = document.getElementById("add-user-form");


form.addEventListener('submit', addUser)

async function addUser(event) {
    event.preventDefault();
    let formData = new FormData(form)
    let objectError = {
        emailErrorSpan: document.getElementById('emailError'),
        first_nameErrorSpan: document.getElementById('first_nameError'),
        last_nameErrorSpan: document.getElementById('last_nameError'),
        avatarErrorSpan: document.getElementById('avatarError'),
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
                if (error.response.data.errors.first_name) {
                    objectError.first_nameErrorSpan.textContent = error.response.data.errors.first_name
                }
                if (error.response.data.errors.last_name) {
                    objectError.last_nameErrorSpan.textContent = error.response.data.errors.last_name
                }
                if (error.response.data.errors.avatar) {
                    objectError.avatarErrorSpan.textContent = error.response.data.errors.avatar
                }
            }
        }
    }
    document.getElementById('loader').style.display = 'none';
}
