@extends('admin.layouts')


@section('content')
  <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                        <a href="https://mdbootstrap.com/material-design-for-bootstrap/" target="_blank">Home Page</a>
                        <span>/</span>
                        <span>Dashboard</span>
                    </h4>

                    <form class="d-flex justify-content-center">
                        <!-- Default input -->
                        <input type="search" placeholder="Type your query" aria-label="Search" class="form-control">
                        <button class="btn btn-primary btn-sm my-0 p" type="submit">
                            <i class="fa fa-search"></i>
                        </button>

                    </form>

                    <a href="{{ route('category.create') }}"><button class="btn btn-primary">Add Category</button></a>

                </div>

            </div>
            <!-- Heading -->

                <!--Grid column-->
                <div class="col-md-12 mb-6">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                            @if(isset($success))
                                <div class="alert alert-success">{{ $success }}</div>
                            @endif

                            <form action="{{ route('category.update', ['id'=>$category->id]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            Category Name<br />
                            <input type="text" name="name" value="{{ $category->name }}" class="form-control"><br />
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-success">Submit</button>

                            </form>

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->


        </div>
        <!--/.Card-->
    </main>
    <!--Main layout-->

    <script type="text/javascript">
        var loadFile = function(event) {
          var output = document.getElementById('output');
          output.src = URL.createObjectURL(event.target.files[0]);
          output.style.width = "150px";
          output.style.height = "150px";
        };
    </script>
@endsection
