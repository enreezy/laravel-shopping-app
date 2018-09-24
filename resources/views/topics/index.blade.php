@extends('cart.layouts')


@section('content')
<!--Main layout-->
  <main>
    <div class="container">

      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

        <!-- Navbar brand -->
        <span class="navbar-brand">Topics:</span>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">

          <!-- Links -->
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">All
                <span class="sr-only">(current)</span>
              </a>
            </li>

          </ul>
          <!-- Links -->
        </div>
        <!-- Collapsible content -->

      </nav>
      <!--/.Navbar-->

      <!--Section: Products v.3-->
      <section class="text-center mb-4">

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
                                        <th>Topic Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <!-- Table head -->

                                <!-- Table body -->
                                <tbody>
                                @foreach($topics as $topic)
                                    <tr>
                                        <th scope="row">{{ $topic->id }}</th>
                                        <td>{{ $topic->title }}</td>
                                        <td> <button class="btn btn-info">Join</button> </td>
                                    </tr>
                            
                                </tbody>
                                @endforeach
                                <!-- Table body -->
                            </table>
                            <!-- Table  -->

                            {{ $topics->links() }}

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

       

      </section>
      <!--Section: Products v.3-->

      <!--Pagination-->
      <nav class="d-flex justify-content-center wow fadeIn">
        {{ $items->links() }}
      </nav>
      <!--Pagination-->

    </div>
  </main>
  <!--Main layout-->

@endsection
