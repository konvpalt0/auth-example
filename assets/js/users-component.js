let container = document.createElement('div');
container.style.marginTop = '4000px';

$.get("api/users", {}, function(users) {
    users = JSON.parse(users);
    let innerHTML = '';

    users.forEach( user => {
        innerHTML += `
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title"> ${user.login} </h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's
                        content.</p>
                    <a href="http://auth.ru/users/${user.uuid}" class="btn btn-primary">Settings</a>
                </div>
            </div>
    `;
    });


    container.innerHTML = innerHTML;
});

document.body.append(container);