@extends('cart.layouts')


@section('content')

<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  #messages { list-style-type: none; margin: 0; padding: 0; }
  #messages li { padding: 5px 10px; }
  #messages li:nth-child(odd) { background: #eee; }
</style>



<!--Main layout-->
  <main>
    <div class="container">

      <!--Navbar-->
      <nav class="navbar navbar-expand-lg navbar-dark mdb-color lighten-3 mt-3 mb-5">

        <!-- Navbar brand -->
        <span class="navbar-brand">Chat</span>

        <!-- Collapse button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
          aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="basicExampleNav">
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
                          
                            <script type="text/javascript" src="{{ asset('autobahn.js') }}"></script>
                            <script src="{{ asset('jquery/jquery-1.9.0.js') }}"></script>
                            <script>

                              const messages = document.getElementById("messages")
                              let c = 0

                              setInterval(function() {
                                  // allow 1px inaccuracy by adding 1
                                  const isScrolledToBottom = messages.scrollHeight - messages.clientHeight <= messages.scrollTop + 1

                                  const newElement = document.createElement("div")

                                  newElement.textContent = format(c++, 'Bottom position:', messages.scrollHeight - messages.clientHeight,  'Scroll position:', messages.scrollTop)

                                  messages.appendChild(newElement)

                                  // scroll to bottom if isScrolledToBottom is true
                                  if (isScrolledToBottom) {
                                    messages.scrollTop = messages.scrollHeight - messages.clientHeight
                                  }
                              }, 500)

                              function format () {
                                return Array.prototype.slice.call(arguments).join(' ')
                              }

                                $.ajaxSetup({
                                  headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                                });


                                $(document).ready(function(){
                                    var conn = new ab.Session('ws://localhost:8005',
                                      //handle onOpen Connection Event
                                      function(session) {
                                          
                                          // subscribe/receive data to a certain topic
                                          conn.subscribe('{{ $topic->title }}', function(topic, data) {
                                              $('#messages').append($('<li>').text(data));
                                          });

                                          // publish/send data to a certain topic
                                          
                                          $('form').submit(function(){
                                            conn.publish('{{ $topic->title }}','{{Auth::user()->name}}: ' + $('#m').val());
                                            
                                            
                                            var sender = '{{Auth::user()->id}}';

                                            $.ajax({
                                              type:'POST',
                                              url: 'http://localhost:8000/fashionsavvy/customer/chat',
                                              data: {
                                                sender:sender,
                                                receiver:1,
                                                message:$('#m').val(),
                                                topic:'{{ $topic->id }}'
                                              },
                                              success:function(){
                                                $('#m').val('');
                                              }
                                            }).fail( function(xhr, textStatus, errorThrown) {
                                                alert(xhr.responseText);
                                            });
      

                                            return false;
                                          });
                                      },
                                      //handle onClose Connection Event
                                      function() {
                                          console.warn('WebSocket connection closed');
                                      },
                                      {'skipSubprotocolCheck': true}
                                  );
                                })
                              
                            </script>

                            <div id="senderInfo" class="pull-left">
                              Sender: <input type="text" id="sender" value="{{ Auth::user()->name }}" class="form-control"/>
                            </div> <br /><br /><br />

                            <div id="messageInfo">
                              <ul id="messages" class="out" style="height:500px;overflow:scroll;" >
                                 @foreach($messages as $message)
                                    <li>{{ $message->user->name }}: {{ $message->message }}</li>
                                 @endforeach
                              </ul>
                            </div>


                            <form action="">
                              
                              <input id="m" autocomplete="off" class="form-control" /><button class="btn btn-success"><i class="fa fa-message"></i> Send</button>
                            </form>

                            

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

       

      </section>
      <!--Section: Products v.3-->
    </div>
  </main>
  <!--Main layout-->

@endsection
