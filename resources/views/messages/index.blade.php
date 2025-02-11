@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/message.css') }}">
<div class="chat-container">
    <!-- Chat List -->
    <div class="chat-list">
        <div class="chat-item" data-user="John Doe">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>John Doe</strong>
                <p class="text-muted">Hey, how are you?</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
        <div class="chat-item" data-user="Jane Smith">
            <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
            <div>
                <strong>Jane Smith</strong>
                <p class="text-muted">Let's catch up!</p>
            </div>
        </div>
    </div>

    <!-- Chat Box -->
    <div class="chat-box">
        <div class="chat-header">
            <i class="bi bi-arrow-left back-btn"></i>
            <span>Select a chat</span>
        </div>
        <div class="chat-body d-flex flex-column">
            <!-- Messages will be displayed here -->
            <div class="message recieve">Ashosh</div>
        </div>
        <div class="chat-footer">
            <input type="text" id="messageInput" placeholder="Type a message...">
            <button class="btn btn-success" id="sendMessage"><i class="bi bi-send"></i></button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $(".chat-item").click(function () {
            let user = $(this).data("user");
            $(".chat-header span").text(user);
            $(".chat-body").html(""); // Clear previous messages

            if ($(window).width() <= 768) {
                $(".chat-list").hide();
                $(".chat-box").show();
            }
        });

        $(".back-btn").click(function () {
            $(".chat-box").hide();
            $(".chat-list").show();
        });

        $("#sendMessage").click(function () {
            let message = $("#messageInput").val().trim();
            if (message !== "") {
                $(".chat-body").append(`<div class="message sent">${message}</div>`);
                $("#messageInput").val("").focus();
                $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);

                setTimeout(function () {
                    let responses = ["Sounds good!", "Okay!", "I'll get back to you.", "Nice!", "What do you mean?"];
                    let randomResponse = responses[Math.floor(Math.random() * responses.length)];
                    $(".chat-body").append(`<div class="message received">${randomResponse}</div>`);
                    $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);
                }, 1000);
            }
        });

        $("#messageInput").keypress(function (e) {
            if (e.which === 13) {
                $("#sendMessage").click();
            }
        });

        if ($(window).width() <= 768) {
            $(".chat-box").hide();
        }
    });
</script>

@endsection
