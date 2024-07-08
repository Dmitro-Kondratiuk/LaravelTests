const buttonAddNewUser = document.getElementById('open-user-form');
const buttonShowMore = document.getElementById('load-more');
const divElementRow = document.querySelector('.row');
const divElementPagination = document.querySelector('.pagination');


let currentPage = 1
let maxCurrentPage = 1
buttonAddNewUser.addEventListener('click', function () {
    window.location.href = window.location.origin + "/user/create";
});
buttonShowMore.addEventListener('click', function () {
    fetchUsers(currentPage)
});


async function fetchUsers(page = 1) {
    document.getElementById('loader').style.display = 'block';
    try {
        let response = await axios.get(`user/getUsers`, {
            params: {
                page: page
            }
        })
        buttonShowMore.style.display = 'block'
        let users = response.data.users
        let countPages = response.data.countPages
        let htmlPagination = ''
        let htmlContent = ''
        for (let user of users) {
            let avatarUrl = user.avatar ? user.avatar : "https://i.ibb.co/8NfHx0d/2024-07-08-10-58-04-2024-07-06-09-16-56-pngtree-landscape-jpg-wallpapers-free-download-image-2573540.jpg";
            htmlContent += `
            <div class="col-3">
            <div class="user-card">
         <img src="${avatarUrl}" alt="User 1">
            <div class="user-info">
            <h3>${user.first_name} ${user.last_name}</h3>
            <p><strong>First Name:</strong>${user.first_name}</p>
            <p><strong>Last Name:</strong> ${user.last_name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
          </div>
       </div>
       </div>`
        }
        if(htmlContent !== ''){
            htmlPagination += `<button class="page-item previous-page">Previous</button>`
            for (let i = 1; i <= countPages; i++) {
                if (i === page) {
                    htmlPagination += ` <button class="page active" id="button_${i}">${i}</button>`
                } else {
                    htmlPagination += ` <button class="page" id="button_${i}">${i}</button>`
                }
                maxCurrentPage = i
            }
            htmlPagination += `<button  class="page-item next-page">Next</button>`
        }
        divElementRow.innerHTML = htmlContent;
        divElementPagination.innerHTML = htmlPagination;
        document.getElementById('loader').style.display = 'none';
        addButtonEventListeners();
        previousPage()
        nexPage()
    } catch (error) {
        document.getElementById('loader').style.display = 'none';
        return {data: [], meta: {}};
    }

}

function addButtonEventListeners() {
    const buttons = document.querySelectorAll('.page');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            let buttonId = button.getAttribute('id');
            currentPage = buttonId.split('_')[1];
            fetchUsers(parseInt(currentPage))
            ;
        });
    });
}

function previousPage() {
    const buttonElementPreviousPagination = document.querySelector('.previous-page')
    buttonElementPreviousPagination.addEventListener('click', function () {
        currentPage = currentPage === 1 ? currentPage : currentPage - 1
        fetchUsers(parseInt(currentPage));
    })
}

function nexPage() {
    const buttonElementNextPagination = document.querySelector('.next-page')
    buttonElementNextPagination.addEventListener('click', function () {
        currentPage = parseInt(currentPage) === maxCurrentPage ? parseInt(currentPage) : currentPage + 1
        fetchUsers(currentPage);
    })
}










