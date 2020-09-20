let container = document.createElement('div');
container.style.marginTop = '100 px';

$.get("api/users", {limit: 9, page: 0}, function(users) {
    users = JSON.parse(users);
    let innerHTML = '';
    innerHTML = `
        <div>
            <a href="http://auth.ru/users/create" class="btn btn-primary">Create new User</a> 
        </div>`

    users.forEach( user => {
        innerHTML += `
            <div class="card col-4" style="width: 18rem;">
                <img src="${user.image}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"> ${user.login} </h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                        content.</p>
                    <a href="http://auth.ru/users/${user.uuid}" class="btn btn-primary">Settings</a>
                </div>
            </div>
    `;
    });

    innerHTML = `<div class="container"><div class="row">${innerHTML}</div></div>`;

    container.innerHTML = innerHTML;

});

document.body.append(container);