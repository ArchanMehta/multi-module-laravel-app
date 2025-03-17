<x-adminheader />
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 15px;
            text-align: center;
        }

        th {
            background-color: #3C37A6;
            color: #F5F7FF;
            font-size: 18px;
        }

        td {
            background-color: #F5F7FF;
            color: #333;
            font-size: 16px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) td {
            background-color: #e3e4f1;
        }

        tr:hover td {
            background-color: #d1d2e6;
        }

        .table-container {
          
           width: 100%;
           height: 80%; 
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 20px;
            margin-top: 100px;
        }
        h2{
            color: #3C37A6;
            text-align: center;
            font-weight: 900
        }
    </style>
</head>
<body style="background-color: #F5F7FF">

    <div class="table-container">

        <h2>Weekly Logs</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Total Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clockData as $clock)
                    <tr>
                        <td>{{ $clock->date }}</td>
                        <td>{{ $clock->day }}</td>
                        <td>{{ $clock->clock_in }}</td>
                        <td>{{ $clock->clock_out }}</td>
                        <td>{{ $clock->total_hours }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

 
    
    <footer class="footer" style="position:absolute;width:100%;bottom:0;left:12%;">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
          <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024. All rights reserved.</span>
        
        </div>
      </footer> 

  <!-- partial -->
</div>
<!-- main-panel ends -->
</div>   
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{asset("dashboard/vendors/js/vendor.bundle.base.js")}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="{{asset("dashboard/vendors/chart.js/Chart.min.js")}}"></script>


<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{asset("dashboard/js/off-canvas.js")}}"></script>
<script src="{{asset("dashboard/js/hoverable-collapse.js")}}"></script>
<script src="{{asset("dashboard/js/template.js")}}"></script>
<script src="{{asset("dashboard/js/settings.js")}}"></script>
<script src="{{asset("dashboard/js/todolist.js")}}"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{asset("dashboard/js/dashboard.js")}}"></script>
<script src="{{asset("dashboard/js/Chart.roundedBarCharts.js")}}"></script>
<!-- End custom js for this page-->
</body>

</html>




