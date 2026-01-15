@extends('layouts.user_type.auth')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-7 col-lg-7 col-md-9 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center pt-4">
              <h5>Create new category</h5>
            </div>
            <div class="card-body">
              <form role="form text-left" method="POST" action="{{ route('org.category-management-store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Category Name</label>
                  <input type="text" class="form-control" placeholder="Category Name" name="name" id="name" aria-label="Name" aria-describedby="name" value="{{ old('name') }}">
                  @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>

                {{-- <div class="mb-3">
                  <label for="organization_id" class="form-label">Organization</label>
                  <select class="form-control" name="organization_id" id="organization_id" aria-label="Organization" aria-describedby="organization">
                    <option value="" disabled selected>Select Organization</option>
                    @forelse($organizations as $organization)
                      <option value="{{ $organization->id }}" {{ old('organization') == $organization->id ? 'selected' : '' }}>{{ $organization->name }}</option>
                    @empty
                      <option value="">No data</option>
                    @endforelse
                  </select>
                </div> --}}

                <div class="mb-3">
                  <label for="image" class="form-label">Category Image</label>
                  <input type="file" class="form-control" name="image" id="image" aria-label="Image">
                  @error('image')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                
                <div class="text-center">
                  <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

