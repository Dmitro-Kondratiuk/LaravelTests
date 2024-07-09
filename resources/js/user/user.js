const buttonAddNewUser = document.getElementById('open-user-form');
const buttonShowMore = document.getElementById('load-more');
const divElementRow = document.querySelector('.row');
const divElementPagination = document.querySelector('.pagination');
const divElementPositions = document.querySelector('.positions')


let currentPage = 1
let maxCurrentPage = 1
let currentIdPosition =1
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

        renderPositions(response.data.positions)
        renderUsers(response.data.users);
        renderPagination(response.data.countPages,page)

        document.getElementById('loader').style.display = 'none';
        addButtonEventListeners();
        previousPage()
        nexPage()
        positionsSearch()
    } catch (error) {
        document.getElementById('loader').style.display = 'none';
        return {data: [], meta: {}};
    }

}
async function fetchUsersPositions(page =1) {
    document.getElementById('loader').style.display = 'block';

    try {
        let response = await axios.get(`user/getPositionsUsers`, {
            params: {
                position_id: currentIdPosition,
                page : page
            }
        })


        renderUsers(response.data.users);
        renderPagination(response.data.countPages,page)

        document.getElementById('loader').style.display = 'none';
        addButtonEventListeners(true);
        previousPage(true)
        nexPage(true)

    }catch (error) {
        document.getElementById('loader').style.display = 'none';
        return {data: [], meta: {}};
    }
}
function renderPositions(positions) {
    divElementPositions.innerHTML = '';
    divElementPositions.innerHTML = positionsRender(positions);
}

function renderUsers(users) {
    divElementRow.innerHTML = '';
    divElementRow.innerHTML = generateHtmlCardUsers(users);
}

function renderPagination(countPages,page) {
    const htmlContent = divElementRow.innerHTML !== '';
    divElementPagination.innerHTML = '';
    divElementPagination.innerHTML = generatePagination(htmlContent, countPages,page);
}
function addButtonEventListeners(positionsSearch =false) {
    const buttons = document.querySelectorAll('.page');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            let buttonId = button.getAttribute('id');
            currentPage = parseInt(buttonId.split('_')[1]);
            if(positionsSearch === true){
                fetchUsersPositions(currentPage)
            }
            else{
                fetchUsers(parseInt(currentPage))
            }
        });
    });
}
function positionsSearch() {
    const buttons = document.querySelectorAll('.button-like-link');
    buttons.forEach(function (button) {
        button.addEventListener('click', function () {
            let buttonId = button.getAttribute('id');
            currentIdPosition = parseInt(buttonId.split('_')[1]);
            fetchUsersPositions(1)
        });
    });
}

function previousPage(positionUser = false) {
    const buttonElementPreviousPagination = document.querySelector('.previous-page')
    buttonElementPreviousPagination.addEventListener('click', function () {
        currentPage = currentPage === 1 ? currentPage : currentPage - 1
        if(positionUser === true){
            fetchUsersPositions(currentPage)
        }
        else{
            fetchUsers(parseInt(currentPage));
        }

    })
}

function nexPage(positionUser=false) {
    const buttonElementNextPagination = document.querySelector('.next-page')
    buttonElementNextPagination.addEventListener('click', function () {
        currentPage = parseInt(currentPage) === maxCurrentPage ? parseInt(currentPage) : currentPage + 1
        if(positionUser === true){
            fetchUsersPositions(currentPage)
        }
        else{
            fetchUsers(currentPage);
        }
    })
}

function generateHtmlCardUsers(users) {
    let htmlContent = ''

    for (let user of users) {
        htmlContent += `
            <div class="col-3">
            <div class="user-card">
         <img src="${user.photo}" alt="User 1">
            <div class="user-info">
            <p><strong>Name:</strong><a href="${window.location.origin + '/user/'+ user.id}">${user.name}</a></p>
            <p><strong>Phone:</strong> ${user.phone}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Position:</strong> ${user.position.name}</p>
          </div>
       </div>
       </div>`
    }
    return htmlContent
}
function generatePagination(htmlContent,countPages,page) {
    let htmlPagination = ''
    if(htmlContent === true){
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
    return htmlPagination
}

function positionsRender(positions) {
    let positionsHtml = ''
    for(let position of positions){
        positionsHtml +=`<div class="block">
                               <button class="button-like-link" id="button_${position.id}" >${position.name}</button>
                            </div>`
    }
    return positionsHtml
}








