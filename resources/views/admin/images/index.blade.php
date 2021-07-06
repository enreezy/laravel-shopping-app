@extends('admin.layouts')


@section('content')
  <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">
            @if(session('message'))
              <div class="alert alert-danger">Image Deleted!</div>
            @endif
            <!-- Heading -->
            <div class="card mb-4 wow fadeIn">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="https://mdbootstrap.com/material-design-for-bootstrap/" target="_blank">Home Page</a>
                        <span>/</span>
                        <span>Dashboard</span>
                    </h4>

                </div>

            </div>
            <!-- Heading -->

                <!--Grid column-->
                <div class="col-md-12 mb-6">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                            <!-- Table  -->
                            <table class="table table-hover">
                                <!-- Table head -->
                                <thead class="blue lighten-4">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Sender</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- Table head -->

                                <!-- Table body -->
                                <tbody>
                                @foreach($images as $image)
                                    <tr>
                                        <th scope="row">{{ $image->id }}</th>
                                        <td><img id="output" style="width:150px;height:150px;" src="{{ asset('storage/images/' . $image->img_src) }}"></td>
                                        <td>{{ $image->sender->name }}</td>
                                        <td>
                                            
                                            <a href="{{ route('adminimage.destroy', ['id'=>$image->id]) }}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button></a>
                                          
                                        </td>
                                    </tr>
                            
                                </tbody>
                                @endforeach
                                <!-- Table body -->
                            </table>
                            <!-- Table  -->

                            {{ $images->links() }}

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->


        </div>
        <!--/.Card-->
    </main>
    <!--Main layout-->
@endsection
