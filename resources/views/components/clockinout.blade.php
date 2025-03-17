<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #clockButton {
            background-color: #4B49AC;
            color: white;
            border: none;
            margin: 10px 0;
            margin-left: 2px;
            margin-right: 8px;
            font-size: 16px;
            width: 90px;
            cursor: pointer;
            padding: 7px 0;
            border-radius: 100px;
        }

        #clockButton:hover {
            background-color: #3c37a6;
        }

        #clockButton:active {
            background-color: #2f2a8a;
        }
        button#clockButton.clock-out{
         border: 3px solid #3c37a6;
         border-radius: 30px;
         color: #3c37a6;
         background: transparent;
    margin: 11px 5px;
    padding: 4px;
    font-weight: 500;
        }
    </style>
</head>

<body>

    <button id="clockButton" data-user-id="{{ auth()->id() }}">Clock In</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            const clockButton = $('#clockButton');
            const userId = clockButton.data('user-id');
            const isClockedIn = localStorage.getItem('clockedIn_' + userId) === 'true';

            // Set the initial button text and state based on clock-in status
            if (isClockedIn) {
                clockButton.text('Clock Out').addClass('clock-out').removeClass('clock-in').attr('data-clocked',
                    'true');
            } else {
                clockButton.text('Clock In').addClass('clock-in').removeClass('clock-out').attr('data-clocked',
                    'false');
            }

            clockButton.on('click', function() {
                const isCurrentlyClockedIn = clockButton.attr('data-clocked') === 'true';
                const currentDate = new Date();

                // Format the date and time using JavaScript
                const formattedDate = `${currentDate.getFullYear()}-${(currentDate.getMonth() + 1)
                    .toString()
                    .padStart(2, '0')}-${currentDate.getDate().toString().padStart(2, '0')}`; // Y-m-d

                // Get the day of the week (0 - 6) and map it to the day name
                const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
                    "Saturday"
                ];
                const dayOfWeek = daysOfWeek[currentDate.getDay()]; // Get the weekday name

                const formattedTime = currentDate
                    .toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    }) // H:i (24-hour)
                    .padStart(2, '0');

                const url = isCurrentlyClockedIn ? '/clock-out' : '/clock-in';

                const formData = {
                    date: formattedDate, // Y-m-d format for database
                    day: dayOfWeek, // Day of the week (e.g., "Wednesday")
                    [isCurrentlyClockedIn ? 'clock_out' : 'clock_in']: formattedTime, // H:i format
                    _token: $('meta[name="csrf-token"]').attr('content'),
                };

                // Send AJAX request
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(data) {
                       

                        if (data.message === 'You have already clocked in today.' || data
                            .message === 'You have not clocked in today or already clocked out.'
                            ) {
                            return;
                        }

                        // Update button state and localStorage
                        if (isCurrentlyClockedIn) {
                            // Clock Out
                            clockButton.text('Clock In')
                                .removeClass('clock-out')
                                .addClass('clock-in')
                                .attr('data-clocked', 'false');
                            localStorage.setItem('clockedIn_' + userId, 'false');
                            window.location.reload(); // Corrected
                        } else {
                            // Clock In
                            clockButton.text('Clock Out')
                                .removeClass('clock-in')
                                .addClass('clock-out')
                                .attr('data-clocked', 'true');
                            localStorage.setItem('clockedIn_' + userId, 'true');
                            window.location.reload(); // Corrected
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    },
                });
            });
        });
    </script>

   

</body>

</html>
