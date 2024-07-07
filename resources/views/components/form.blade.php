<form id="add-user-form" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">First Name:</label>
        <x-input type="text" class="form-control" id="first_name" name="first_name" />
        <span id="first_nameError" style="color: red"></span>
    </div>
    <div class="form-group">
        <label for="name">Last Name:</label>
        <x-input type="text" class="form-control" id="last_name" name="last_name" />
        <span id="last_nameError" style="color: red"></span>    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <x-input type="email" class="form-control" id="email" name="email" />
        <span id="emailError" style="color: red"></span>
    </div>
    <div class="form-group">
        <label for="avatar">Avatar:</label>
        <x-input t type="file" class="form-control" id="avatar" name="avatar" />
    </div>
    <span id="avatarError" style="color: red"></span><br>
    <button type="submit" class="btn btn-primary" id="add-user">Add User</button>
</form>
