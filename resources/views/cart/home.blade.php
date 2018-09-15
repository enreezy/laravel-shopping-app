@extends('cart.layouts')


@section('content')
<!--Main layout-->
  <main>
    <div class="container">

      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

        <!-- Navbar brand -->
        <span class="navbar-brand">Categories:</span>

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
            @foreach($category as $c)
            <li class="nav-item">
              <a class="nav-link" href="#">{{ $c->name }}</a>
            </li>
            @endforeach

          </ul>
          <!-- Links -->

          <form class="form-inline">
            <div class="md-form my-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            </div>
          </form>
        </div>
        <!-- Collapsible content -->

      </nav>
      <!--/.Navbar-->

      <!--Section: Products v.3-->
      <section class="text-center mb-4">

        <!--Grid row-->
        <div class="row wow fadeIn">
          @foreach($items as $item)
          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4">

            <!--Card-->
            <div class="card">

              <!--Card image-->
              <div class="view overlay">
                <img src="{{ asset('storage/images/' . $item->img_src) }}" alt="" width="250px;" height="250px;">
                @if(Auth::user())
                  <a href="{{ route('shopping.show', ['id'=>$item->id]) }}">
                @else
                  <a href="{{ route('visitor.show', ['id'=>$item->id]) }}">
                @endif
                    <div class="mask rgba-white-slight"></div>
                  </a>
              </div>
              <!--Card image-->

              <!--Card content-->
              <div class="card-body text-center">
                <!--Category & Title-->
                <a href="" class="grey-text">
                  <h5>Shirt</h5>
                </a>
                <h5>
                  <strong>
                  @if(Auth::user())
                    <a href="{{ route('shopping.show', ['id'=>$item->id]) }}" class="dark-grey-text">
                  @else
                    <a href="{{ route('visitor.show', ['id'=>$item->id]) }}" class="dark-grey-text">
                  @endif
                    {{ $item->name }}
                      <span class="badge badge-pill danger-color">NEW</span>
                    </a>
                  </strong>
                </h5>

                <h4 class="font-weight-bold blue-text">
                  <strong>{{ $item->price }}</strong>
                </h4>

              </div>
              <!--Card content-->

            </div>
            <!--Card-->

          </div>
          <!--Grid column-->

          @endforeach

        </div>
        <!--Grid row-->

       

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
