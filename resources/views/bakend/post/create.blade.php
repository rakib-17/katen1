@extends('layouts.bakend_master')
@section('main_dashboard')
    <div class="row">
        <div class="col-12">
            <div class="card-style mb-30">
                <h3 class="mb-25">Add New Post</h3>
                <form action="{{ route('post.store') }}" class="row" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="">Title</label>
                            <input name="title" type="text" placeholder="Title" value="{{ old('title') }}">
                            @error('title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end input field -->
                    <div class="col-lg-6">
                        <div class="select-style-1">
                            <label>Category</label>
                            <div class="select-position">
                              <select name="category" id="category">
                                <option selected disabled value="" >Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            </div>
                            @error('category')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end select -->
                    <div class="col-lg-6">
                        <div class="select-style-1">
                            <label>Sub Category</label>
                            <div class="select-position">
                              <select name="sub_category" id="subCategory">
                                <option selected disabled value="">Select Category First</option>
                              </select>
                            </div>
                            @error('sub_category')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end select -->
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="">Featured Image</label>
                            <input name="featured_image" type="file">
                            @error('featured_image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end input field -->
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="">Short Description</label>
                            <textarea rows="5" name="short_description" placeholder="Short Description..." value="{{ old('short_description') }}"></textarea>
                            @error('short_description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end text-area field -->
                    <div class="col-lg-12">
                        <div class="input-style-1">
                            <label for="">Description</label>
                            <textarea id="post_description" name="description" placeholder="Description" value="{{ old('description') }}"></textarea>
                            @error('description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                        <!-- end text-area field -->
                    <div class="col-lg-12">
                        <button type="submit" class="main-btn primary-btn btn-hover w-100">Add New Post</button>
                    </div>
                        <!-- end button -->
                </form>
            </div>
        </div>
    </div>
@endsection
@push('additional-css')
    <style>
        .ck-editor__editable[role="textbox"] {
                /* editing area */
                min-height: 200px;
            }
    </style>
@endpush
@push('additional-js')
    <script src="{{ asset('bakend/assets/js/ckeditor.js') }}"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#post_description' ) )
            .catch( error => {
                console.error( error );
            } );

        $('#category').on('change', function(){
            $.ajax({
                url: `{{ route('subcategory.getSubCategory') }}`,
                method: 'GET',
                data: {
                    category: $(this).val()
                },
                success: function (subCategories){

                    if (subCategories.length > 0){
                        let options = [
                            '<option selected disabled>Select Sub Category</option>'
                        ];
                        subCategories.forEach(function(subCategory){
                        let option = `<option value="${subCategory.id}">${subCategory.name}</option>`;
                        options.push(option);
                    });
                        $('#subCategory').html(options)
                    }else{
                        $('#subCategory').html(`<option selected disabled>No Sub Category Found!</option>`)
                    }

                }
                // error:

            })
        })
    </script>
@endpush
