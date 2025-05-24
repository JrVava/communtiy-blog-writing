@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/message.css') }}">
    <div class="chat-container">
        <!-- Chat List -->
        <div class="chat-list">
            @foreach ($users as $user)
                <div class="chat-item" data-user="{{ $user->full_name }}" data-receiver-id="{{ $user->id }}">
                    @if ($user->image)
                        <img src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="User">
                    @else
                        <div class="without-profile-avatar">
                            {{ $user->initials }}
                        </div>
                    @endif
                    <div>
                        <strong>{{ $user->full_name }}</strong>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card no-chat-available w-100 ms-2">
            <div class="card-body">
                <h1 class="text-center d-flex justify-content-center align-items-center h-100">No Chat Available</h1>
            </div>
        </div>
        <!-- Chat Box -->
        <div class="chat-box">
            <div class="chat-header">
                <i class="bi bi-arrow-left back-btn"></i>
                <span></span>
            </div>
            <div class="chat-body d-flex flex-column">
                <!-- Messages will be displayed here -->
            </div>
            <div class="chat-footer">
                <input type="hidden" name="receiver_id" id="receiver_id" class="receiver_id" value="">
                <input type="hidden" name="sender_id" id="sender_id" class="sender_id" value="{{ Auth::user()->id }}">
                <input type="text" id="messageInput" placeholder="Type a message...">
                <button class="btn btn-success" id="sendMessage"><i class="bi bi-send"></i></button>
            </div>
        </div>
    </div>

    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                $(".chat-box").hide();
                $(".chat-item").click(function() {
                    $(".chat-box").show();
                    $(".no-chat-available").hide();
    
                    let user = $(this).data("user");
                    let receiver_id = $(this).data("receiver-id");
    
                    $(".receiver_id").val(receiver_id);
    
                    $(".chat-header span").text(user);
    
                    $.ajax({
                        url: "{{ route('get-messages') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            receiver_id: receiver_id,
                        },
                        success: function(res) {
                            $(".chat-body").html(res.html);
                        }
                    })
                    // $(".chat-body").html("");
    
                    if ($(window).width() <= 768) {
                        $(".chat-list").hide();
                        $(".chat-box").show();
                    }
                });
    
                $(".back-btn").click(function() {
                    $(".chat-box").hide();
                    $(".chat-list").show();
                });
    
                $("#sendMessage").click(function() {
                    let message = $("#messageInput").val().trim();
    
                    if (message !== "") {
                        $(".chat-body").append(`<div class="message sent">${message}</div>`);
                        $("#messageInput").val("").focus();
                        $(".chat-body").scrollTop($(".chat-body")[0].scrollHeight);
    
                        let receiver_id = $('.receiver_id').val();
                        let sender_id = $('.sender_id').val();
                        $.ajax({
                            url: "{{ route('send-message') }}",
                            type: "POST",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                receiver_id: receiver_id,
                                sender_id: sender_id,
                                messages: message
                            },
                            success: function(res) {
    
                                let wsMessage = JSON.stringify({
                                    type: "chat_message",
                                    to_user_id: receiver_id,
                                    from_user_id: sender_id,
                                    message: message
                                });
                                if (socket.readyState === WebSocket.OPEN) {
                                    socket.send(wsMessage);
                                } else {
                                    console.warn("⚠️ WebSocket not open yet");
                                }
                            }
                        })
                    }
                });
    
                $("#messageInput").keypress(function(e) {
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
