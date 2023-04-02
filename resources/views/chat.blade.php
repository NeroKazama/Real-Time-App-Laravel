<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/app.css') }}">

    <style>
        .list-group {
            overflow: scroll;
            height: 200px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center mt-5" id="app">
            <div class="offset-4 col-4 offset-sm-1 col-sm-10 col-md-7 col-lg-7 p-5 shadow rounded-2">
                <li class="list-group-item active bg-dark p-3 text-light" aria-current="true">Chat App 
                    <span class="badge bg-warning">
                        @{{numberOfUsers}}
                    </span>
                    <a class="float-end badge bg-danger" @click="deleteSession" href="#">X</a>
                </li>
                <div class="badge bg-primary">@{{typing}}</div>
                <ul class="list-group overflow-auto" ref="chat">
                    <message-component 
                        v-for="item,index in chat.message"
                        :color='chat.color[index]'
                        :user=chat.user[index]
                        :time=chat.time[index]>
                        @{{ item }}
                    </message-component>
                </ul>
                
                <input type="text" class="form-control" placeholder="Type Your Message here..." v-model="message"
                    @keyup.enter="send">
            </div>
        </div>
        <notifications position="bottom right" />
    </div>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
</body>

</html>
