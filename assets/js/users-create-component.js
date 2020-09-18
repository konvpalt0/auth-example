let container = document.createElement('div');
container.style.marginTop = '170px';

let innerHTML = `
    <form method="post" id="userSettings" >
  <div class="form-group">
    <label for="exampleInputEmail1">Login</label>
    <input type="email" class="form-control" name="login"  id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" >Password</label>
    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary">Create</button>
</form>
    `;

container.innerHTML = innerHTML;

document.body.append(container);
