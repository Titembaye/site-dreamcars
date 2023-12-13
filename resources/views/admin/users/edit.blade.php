@extends('admin.admin_dashboard')

@section('title')
    DreamCars - Utilisateurs
@endsection('title')
@section('admin')
<div class="row m-5">
    <div class="col-lg-8 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Modifier le profile</h6>
                <form method="POST" action="{{route('users.update', $user->id)}}"  class="forms-sample" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')    
                    <div class="mb-3">
                        <label for="exempleUserName1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="exempleUserName1" name="username" value="{{ old('username', $user->username) }}" autocomplete="off" placeholder="Username">
                    </div>
                    @error('username')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="exempleUserName1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exempleUserName1" name="name" value="{{ old('name', $user->name) }}" autocomplete="off" placeholder="Name">
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ old('email', $user->email) }}" placeholder="Email">
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" autocomplete="off" placeholder="Phone">
                    </div>
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="adress" class="form-label">Adresse</label>
                        <input type="text" class="form-control" name="adress" id="adress" value="{{ old('adress', $user->adress) }}" autocomplete="off" placeholder="Adresse">
                    </div>
                    @error('adress')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" name="role" id="role">
                            <!-- Options de la liste déroulante -->
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror


                    <div class="col-lg-6 mb-3">
                        <label for="photo" class="form-label">Permis de conduire</label>
                        <input class="form-control" name="photo" type="file" id="image">

                    </div>
                    @error('photo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <div class="col-lg-4 mb-3">
                        <label for="image" class="form-label">Aperçu de l'image</label>
                        <img id="showImage" class="img-fluid" src="{{ asset('storage/' . $user->photo) }}" alt="Image Preview">
                    </div>


                    <button type="submit" class="btn btn-primary me-2">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('image').addEventListener('change', function() {
        var showImage = document.getElementById('showImage');
        var imageInput = this;

        if (imageInput.files && imageInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                showImage.src = e.target.result;
            }

            reader.readAsDataURL(imageInput.files[0]);
        }
    });
</script>
@endsection       
