@extends('layouts.bakend_master')

@section('main_dashboard')
    <div class="row">
        <div class="col-lg-8">
            <div class="card-style mb-30">
                <h6 class="mb-10">All Categories</h6>
                <div class="table-wrapper table-responsive">
                  <table class="table striped-table">
                    <thead>
                      <tr>
                        <th>
                          <h6>Sl. No</h6>
                        </th>
                        <th>
                          <h6>Name</h6>
                        </th>
                        <th>
                          <h6>Slug</h6>
                        </th>
                        <th>
                          <h6>Status</h6>
                        </th>
                        <th>
                          <h6>Action</h6>
                        </th>
                      </tr>
                      <!-- end table row-->
                    </thead>
                    <tbody>

                        @forelse ($categories as $key=> $category)
                        <tr>
                            <td>
                              <h6 class="text-sm">#{{  $categories->firstItem() + $key }}</h6>
                            </td>
                            <td>
                              <p>{{ $category->name }}</p>
                            </td>
                            <td>
                              <p>{{ $category->slug }}</p>
                            </td>
                            <td>
                              <div class="form-check form-switch toggle-switch">
                                <input class="form-check-input" type="checkbox" id="toggleSwitch2" {{ $category->status ? 'checked':'' }}>
                              </div>
                            </td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning btn-hover">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="submit" class="btn btn-danger btn-hover delete_btn">
                                    <i class="fas fa-trash"></i>
                                </button>

                                <form class="d-inline-block" action="{{ route('category.delete', $category->id) }}" method="POST">
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
                    {{ $categories->links() }}
                </div>
              </div>
        </div>
        <div class="col-lg-4">
            <div class="card-style mb-30">
                <h6 class="mb-25">{{ isset($edit_data) ? 'Update' : 'Create New' }} Category</h6>
                <form action="{{ isset($edit_data) ? route('category.update', $edit_data->id) : route('category.store') }}" method="POST">
                    @isset($edit_data)
                        @method('PUT')
                    @endisset
                    @csrf
                    <div class="input-style-1">
                        <label>Category Name</label>
                        <input type="text" placeholder="Category Name" name="name" value="{{ isset($edit_data) ? $edit_data->name : '' }}">
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                      <!-- end input -->
                    <button type="submit" class="main-btn primary-btn btn-hover w-100 btn-sm">{{ isset($edit_data) ? 'Update' : 'Create New' }} Category</button>
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
