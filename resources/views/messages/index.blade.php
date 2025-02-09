@extends('layouts.app-layout')
@section('title', 'Dashboard')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/message.css') }}">
<section class="message-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="chat-area">
                    <!-- chatlist -->
                    <div class="chatlist">
                        <div class="modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="chat-header">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab" aria-controls="Open" aria-selected="true">
                                                <strong>Users</strong>
                                            </button>
                                        </li>
                                    </ul>
                                </div>

                                <div class="modal-body">
                                    <!-- chat-list -->
                                    <div class="chat-lists">
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                                                <!-- chat-list -->
                                                <div class="chat-list">
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                            <span class="active"></span>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Mehedi Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Ryhan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Malek Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Sadik Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Bulu </h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Maria SK</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Dipa Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Jhon Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Tumpa Moni</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Payel Akter</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Baby Akter</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Zuwel Rana</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Habib </h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Jalal Ahmed</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Hasan Ali</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>
                                                    <a href="#" class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <h3>Mehedi Hasan</h3>
                                                            <p>front end developer</p>
                                                        </div>
                                                    </a>


                                                </div>
                                                <!-- chat-list -->
                                            </div>
                                           
                                        </div>

                                    </div>
                                    <!-- chat-list -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- chatlist -->



                    <!-- chatbox -->
                    <div class="chatbox">
                        <div class="modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="msg-head">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="d-flex align-items-center">
                                                <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                                                <div class="flex-shrink-0">
                                                    <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h3>Mehedi Hasan</h3>
                                                    <p>front end developer</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <ul class="moreoption">
                                                <li class="navbar nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal-body">
                                    <div class="msg-body">
                                        <ul>
                                            <li class="sender">
                                                <p> Hey, Are you there? </p>
                                                <span class="time">10:06 am</span>
                                            </li>
                                            <li class="sender">
                                                <p> Hey, Are you there? </p>
                                                <span class="time">10:16 am</span>
                                            </li>
                                            <li class="repaly">
                                                <p>yes!</p>
                                                <span class="time">10:20 am</span>
                                            </li>
                                            <li class="sender">
                                                <p> Hey, Are you there? </p>
                                                <span class="time">10:26 am</span>
                                            </li>
                                            <li class="sender">
                                                <p> Hey, Are you there? </p>
                                                <span class="time">10:32 am</span>
                                            </li>
                                            <li class="repaly">
                                                <p>How are you?</p>
                                                <span class="time">10:35 am</span>
                                            </li>
                                            <li>
                                                <div class="divider">
                                                    <h6>Today</h6>
                                                </div>
                                            </li>

                                            <li class="repaly">
                                                <p> yes, tell me</p>
                                                <span class="time">10:36 am</span>
                                            </li>
                                            <li class="repaly">
                                                <p>yes... on it</p>
                                                <span class="time">junt now</span>
                                            </li>

                                        </ul>
                                    </div>
                                </div>


                                <div class="send-box">
                                    <form action="">
                                        <input type="text" class="form-control" aria-label="message…" placeholder="Write message…">

                                        <button type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- chatbox -->


            </div>
        </div>
    </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function() {

$(".chat-list a").click(function() {
    $(".chatbox").addClass('showbox');
    return false;
});

$(".chat-icon").click(function() {
    $(".chatbox").removeClass('showbox');
});


});
</script>
@endsection
