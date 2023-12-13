@extends('admin.admin_dashboard')
@section('admin')
<div class="row m-5">
    <div class="col-lg-10 mx-auto m-5">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Enregistrement d'une image</h6>

                <form class="forms-sample" method="POST" action="{{route('voitures.imagestore')}}" enctype="multipart/form-data">
                    @csrf 
                    <div class="mb-3">
                        <label for="voiture_id" class="form-label">Voiture</label>
                        <select name="voiture_id" id="voiture_id" class="js-example-basic-single form-select" data-width="100%">
                            @foreach ($voitures as $voiture)
                                <option value="{{ $voiture->id }}">{{ $voiture->immatriculation }}</option>
                            @endforeach
                        </select>
                        @error('voiture_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="images" class="form-label">Photo</label>
                        <input class="form-control" type="file" name="images[]" id="images" multiple>
                    </div>

                    @error('images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="image" class="form-label">Aperçu de l'image</label>
                            <img id="showImage" class="img-fluid" src="" alt="Image Preview">
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                    <button class="btn btn-secondary">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('images').addEventListener('change', function() {
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