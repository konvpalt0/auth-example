

let container = document.createElement('div');
container.style.marginTop = '170px';
let uuid = document.URL.split('/')[4];

let innerHTML = `
<form 
    method="post" 
    action="/api/users/${uuid}" 
    id="userSettings" 
    enctype="multipart/form-data"
    >
    
    <div class="form-group">
        <label for="exampleInputUuid" >Uuid</label>
        <input type="uuid" class="form-control" name="id" id="exampleInputUuid" aria-describedby="emailHelp" readonly>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Login</label>
        <input type="email" class="form-control" name="login"  id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1" >Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
    </div>
      
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">User picture</span>
        </div>
        <div class="custom-file">
            <input 
               type="file" 
               class="custom-file-input" 
               id="inputGroupFile01"
               aria-describedby="inputGroupFileAddon01"
               name="picture">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" name="active" id="exampleCheck1" checked>
        <label class="form-check-label" for="exampleCheck1">Active</label>
    </div>
 
    <button type="submit" class="btn btn-primary">Submit</button>
    </form>
        `;

container.innerHTML = innerHTML;


$.get(`http://auth.ru/api/users/${uuid}`, {}, function (user) {
    user = JSON.parse(user);
    container.querySelector('#exampleInputUuid').value = user.id;
    container.querySelector('#exampleInputEmail1').value = user.login;
    container.querySelector('#exampleCheck1').checked = user.active;
});

document.body.append(container);
