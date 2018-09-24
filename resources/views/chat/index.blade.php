<!doctype html>
<html>
  <head>
    <title>Web Socket</title>
    <meta name="csrf-token" content="{{ csrf_token() }} " />
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages li { padding: 5px 10px; }
      #messages li:nth-child(odd) { background: #eee; }
    </style>
  </head>
  <script src="{{ asset('jquery/jquery-1.9.0.js') }}"></script>
  <script type="text/javascript" src="{{ asset('autobahn.js') }}"></script>
  <script>

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
                  url: 'http://localhost:8000/chat',
                  data: {
                    sender:sender,
                    message:$('#m').val(),
                    topic:'{{ $topic->id }}'
                  },
                  success:function(){
                    $('#m').val('');
                  }
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
  <body>


  Sender: <input type="text" id="sender" value="{{ Auth::user()->name }}" />
    <ul id="messages">
       @foreach($messages as $message)
          <li>{{ $message->user->name }}: {{ $message->message }}</li>
       @endforeach
    </ul>
    <form action="">
      <input id="m" autocomplete="off" /><button>Send</button>
    </form>
  </body>
</html>