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

                    <a href="{{ route('item.create') }}"><button class="btn btn-primary">Add Item</button></a>

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

                            <form action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            Item Name<br />
                            <input type="text" name="name" class="form-control"><br />
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </div>
                            @endif
                            Price<br />
                            <input type="text" name="price" class="form-control"><br />
                            @if ($errors->has('price'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </div>
                                @endif
                            Quantity<br />
                            <input type="number" name="quantity" class="form-control"><br />
                            @if ($errors->has('quantity'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('quantity') }}</strong>
                                </div>
                            @endif
                            Image<br />
                            <input type="file" name="img_src" class="form-control" accept="image/*" onchange="loadFile(event)"><br />
                            @if ($errors->has('img_src'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('img_src') }}</strong>
                                </div>
                            @endif
                            <center>
                                <img id="output">
                            </center>
                            Size<br />
                            <input type="text" name="size" class="form-control"><br />
                            @if ($errors->has('size'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('size') }}</strong>
                                </div>
                            @endif
                            Color<br />
                            <select name="color" class="form-control">
                                <option>Red</option>
                                <option>Blue</option>
                                <option>Green</option>
                                <option>White</option>
                                <option>Black</option>
                            </select>
                            @if ($errors->has('color'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('color') }}</strong>
                                </div>
                            @endif
                            Category<br />
                            <select class="form-control" name="category">
                                @foreach($categories as $category)
                                    <option>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('category') }}</strong>
                                </div>
                            @endif
                            Description<br />
                            <input type="text" name="description" class="form-control"><br />
                            @if ($errors->has('description'))
                                <div class="alert alert-danger">
                                    <strong>{{ $errors->first('description') }}</strong>
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
