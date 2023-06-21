<x-HeaderFooter>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Individual Report</h5>
                        <h5 class="card-title">User Name - {{ $employee->name }}</h5>
                        <hr>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check-In Time</th>
                                    <th>Check-Out Time</th>
                                    <th>Office Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Iterate over the individual report data and display the report rows -->
                                @foreach ($individualReport as $report)
                                    <tr>
                                        <td>{{ $report->created_at->toDateString() }}</td>
                                        <td>{{ date('h:i A', strtotime($report->check_in_time)) }}</td>
                                        <td>
                                            @if ($report->check_out_time !== null)
                                                {{ date('h:i A', strtotime($report->check_out_time)) }}
                                            @else
                                                Not checked out yet
                                            @endif
                                        </td>
                                        <td>
                                            @if ($report->check_in_time && $report->check_out_time)
                                                <?php
                                                    $checkInTime = strtotime($report->check_in_time);
                                                    $checkOutTime = strtotime($report->check_out_time);
                                                    $officeHours = round(($checkOutTime - $checkInTime) / 3600, 2);
                                                ?>
                                                {{ $officeHours }} hours
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-HeaderFooter>
