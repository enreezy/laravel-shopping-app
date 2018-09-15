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

                    <a href="{{ route('item.create') }}"><button class="btn btn-primary">Add Item</button></a>

                </div>

            </div>
            <!-- Heading -->
            <div class="row">
                <!--Grid column-->
                <div class="col-md-4 mb-6">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                           <img src="{{ asset('storage/images/' . $item->img_src) }}" alt="" width="70%;" height="280px;">

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-8 mb-6">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">

                            <p>Name:  {{ $item->name }}</p>
                            <p>Price: {{ $item->price }}</p>
                            <p>Quantity: {{ $item->quantity }}</p>
                            <p>Color: {{ $item->attributes['color'] }}</p>
                            <p>Size: {{ $item->attributes['size'] }}</p>
                            <p>Category: {{ $item->category }}</p>
                            <p>Description: {{ $item->description }}</p>
                           
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
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
