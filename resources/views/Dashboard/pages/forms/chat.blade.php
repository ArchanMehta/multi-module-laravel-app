<x-adminheader />
@include('Dashboard.pages.forms.select2');
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.3.0/pusher.min.js"></script>

<script>
    $(document).ready(function() {
        var selectedUserId = null;
        var pusher = new Pusher('eca0f54976d83f653bc1', {
            cluster: 'ap2'
        });

        // Load Users
        $.get('/users', function(users) {
            users.forEach(function(user) {
                $('#userList').append('<li data-id="' + user.id + '">' + user.name + '</li>');
            });
        });

        // User Click Event
        $(document).on('click', '.user-list li', function() {
            $('.user-list li').removeClass('active');
            $(this).addClass('active');

            selectedUserId = $(this).data('id');
            $('#chatMessages').html('');
            $('#chatHeader').text('Chatting with ' + $(this).text());
            loadMessages(selectedUserId);

            $('#message').prop('disabled', false);
            $('#chatForm input[type="submit"]').prop('disabled', false);

            // Unsubscribe from the previous channel and subscribe to the new one
            if (window.channel) {
                window.channel.unsubscribe();
            }
            window.channel = pusher.subscribe('chat.' +
                selectedUserId); // Subscribe to the user's specific channel

            // Listen for messages in the selected user's channel
            window.channel.bind('message.sent', function(data) {
                if (data.receiver_id == selectedUserId || data.sender_id == selectedUserId) {
                    appendMessage(data.sender_name, data.message, data.sent_time, data
                        .sender_id === selectedUserId ? 'other' : 'own');
                }
            });
        });

        // Load Messages
        function loadMessages(userId) {
            $.get('/messages/' + userId, function(messages) {
                messages.forEach(function(message) {
                    appendMessage(message.sender_name, message.message, message.sent_time,
                        message.sender_id === userId ? 'other' : 'own');
                });
            });
        }

        // Append Message Function
        function appendMessage(sender, text, time, type) {
            $('#chatMessages').append(
                '<div class="message-container ' + type + '">' +
                '<div><strong>' + sender + '</strong>: ' + text + '</div>' +
                '<div class="meta">[' + time + ']</div>' +
                '</div>'
            );
            $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
        }

        // Send Message
        $('#chatForm').submit(function(e) {
            e.preventDefault();
            var message = $('#message').val();
            if (message && selectedUserId) {
                $.post('/send-message', {
                    _token: '{{ csrf_token() }}',
                    receiver_id: selectedUserId,
                    message: message
                }, function(data) {
                    appendMessage(data.sender_name, data.message, data.sent_time, 'own');
                    $('#message').val('');
                });
            }
        });
    });
</script>



<style>
    .container {
        display: flex;
        max-width: 1000px;
        margin: 20px auto;
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .user-list {
        width: 30%;
        background-color: #f4f4f4;
        padding: 10px;
        overflow-y: auto;
        border-right: 1px solid #ddd;
    }

    .user-list h3 {
        margin-top: 0;
        text-align: center;
        font-family: Arial, sans-serif;
        color: #333;
    }

    .user-list ul {
        list-style: none;
        padding: 0;
    }

    .user-list ul li {
        padding: 10px;
        cursor: pointer;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s;
    }

    .user-list ul li:hover {
        background-color: #e0e0e0;
    }

    .user-list ul li.active {
        background-color: #ddd;
    }

    .chat {
        width: 70%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #4B49AC;
        color: white;
        font-family: Arial, sans-serif;
    }

    .chat .top {
        padding: 10px;
        background-color: #3f3d8c;
        border-bottom: 1px solid #ddd;
    }

    .chat .top p {
        margin: 0;
        font-size: 16px;
        color: white;
    }

    .chat .messages {
        flex-grow: 1;
        padding: 10px;
        overflow-y: auto;
        background-color: #5A57CA;
        max-height: 500px;
        /* Set the max height for the chat messages */
    }

    .chat .bottom {
        display: flex;
        padding: 10px;
        gap: 10px;
        background-color: #3f3d8c;
    }

    .chat .bottom input[type="text"] {
        flex-grow: 1;
        padding: 10px;
        border: none;
        border-radius: 4px;
    }

    .chat .bottom input[type="submit"] {
        background-color: #6C63FF;
        border: none;
        padding: 10px 20px;
        color: white;
        border-radius: 4px;
        cursor: pointer;
    }

    .chat .bottom input[type="submit"]:hover {
        background-color: #5A57CA;
    }

    .message-container {
        margin: 10px 0;
        padding: 10px;
        border-radius: 10px;
        background-color: #6C63FF;
        color: white;
        width: fit-content;
        max-width: 70%;
    }

    .message-container .meta {
        font-size: 0.8em;
        color: #bbb;
        margin-top: 5px;
    }

    .message-container.own {
        background-color: #3f3d8c;
        margin-left: auto;
    }

    .message-container.other {
        background-color: #5A57CA;
    }
</style>

<body>


    <div class="container">
        <div class="user-list">
            <h3>Users</h3>
            <ul id="userList">
                <!-- Dynamic user list -->
            </ul>
        </div>
        <div class="chat">
            <div class="top">
                <p id="chatHeader">Select a user to start chatting</p>
            </div>
            <div class="messages" id="chatMessages">
                <!-- Dynamic messages will be appended here -->
            </div>
            <div class="bottom">
                <form id="chatForm">
                    <input type="text" id="message" name="message" placeholder="Enter a message ..." disabled>
                    <input type="submit" value="Send" disabled>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
