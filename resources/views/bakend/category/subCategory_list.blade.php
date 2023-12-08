@extends('layouts.bakend_master')

@section('main_dashboard')
    <div class="row">
        <div class="col-lg-8">
            <div class="card-style mb-30">
                <h4 class="mb-10">All Categories</h4>
                <div class="table-wrapper table-responsive">
                  <table class="table striped-table text-center">
                    <thead>
                      <tr>
                        <th>Sl. No</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent Category</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      <!-- end table row-->
                    </thead>
                    <tbody>
                        @forelse ($sub_categories as $key=> $sub_category)
                        <tr>
                            <td>
                              <h6 class="text-sm">#{{  $sub_categories->firstItem() + $key }}</h6>
                            </td>
                            <td>
                              <p>{{ $sub_category->name }}</p>
                            </td>
                            <td>
                              <p>{{ $sub_category->slug }}</p>
                            </td>
                            <td>
                              <p>{{ $sub_category->category->name }}</p>
                            </td>
                            <td>
                              <div class="form-check form-switch toggle-switch">
                                <input class="form-check-input" type="checkbox" id="toggleSwitch2" {{ $sub_category->status ? 'checked':''}}>
                              </div>
                            </td>
                            <td>
                                <a href="{{ route('subcategory.edit', $sub_category->id) }}" class="btn btn-warning btn-hover">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="submit" class="btn btn-danger btn-hover delete_btn">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form class="d-inline-block" action="{{ route('subcategory.delete', $sub_category->id) }}" method="POST">
                                    @csrf
                                    @method("DELETE")
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger"><strong>No Data Found!</strong></td>
                         </tr>
                        @endforelse

                    </tbody>
                  </table>
                  <!-- end table -->
                </div>
                <div>
                    {{ $sub_categories->links() }}
                </div>
              </div>
        </div>
        <div class="col-lg-4">
            <div class="card-style mb-30">
                <h6 class="mb-25">{{ isset($edit_data) ? 'Update' : 'Create New' }} Sub Category</h6>
                <form action="{{ isset($edit_data) ? route('subcategory.update', $edit_data->id) : route('subcategory.store') }}" method="POST">
                    @isset($edit_data)
                        @method('PUT')
                    @endisset
                    @csrf
                    <div class="select-style-1">
                        <label>Category Name</label>
                        <div class="select-position">
                          <select name="category">
                            <option>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                          </select>
                        </div>
                                @error('category')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                    </div>
                    <div class="input-style-1">
                        <label>Sub Category Name</label>
                        <input type="text" placeholder="Sub Category Name" name="name" value="{{ isset($edit_data) ? $edit_data->name : '' }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                      <!-- end input -->
                    <button type="submit" class="main-btn primary-btn btn-hover w-100 btn-sm">{{ isset($edit_data) ? 'Update' : 'Create New' }} Sub Category</button>
                </form>
            </div>
        </div>
@endsection

@push('additional-js')
<script src="{{ asset('bakend/assets/js/sweetalert2@11.js') }}"></script>
<script>

    $('.delete_btn').on('click', function(){
            Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).next('form').submit()
                // Swal.fire({
                // title: "Deleted!",
                // text: "Your file has been deleted.",
                // icon: "success"
                // });
            }
        });
    })

</script>

@endpush
