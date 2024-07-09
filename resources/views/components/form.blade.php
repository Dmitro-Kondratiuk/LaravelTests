@props(['positions'=>null])

<form id="add-user-form" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name">Name:</label>
        <x-input type="text" class="form-control" id="name" name="name" />
        <span id="nameError" style="color: red"></span>
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <x-input type="phone" class="form-control" id="phone" name="phone" value="+380"/>
        <span id="phoneError" style="color: red"></span>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <x-input type="email" class="form-control" id="email" name="email" />
        <span id="emailError" style="color: red"></span>
    </div>
    <select id="position_id" name="position_id" class="form-select mt-3" aria-label="Default select example">
        <option selected>Please select positions</option>
        @foreach($positions as $position){
            <option value="{{$position->id}}">{{$position->name}}</option>
        @endforeach
    </select>
    <span id="positionError" style="color: red"></span><br>
    <div class="form-group">
        <label for="photo">Avatar:</label>
        <x-input t type="file" class="form-control" id="photo" name="photo" />
    </div>
    <span id="photoError" style="color: red"></span><br>
    <button type="submit" class="btn btn-primary" id="add-user">Add User</button>
</form>
