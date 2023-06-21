<x-HeaderFooter>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employee Report</h5>
                        <form method="GET" action="/employee-report">
                            <div class="form-group">
                                <label for="reportDate">Select Date:</label>
                                <select class="form-control" id="reportDate" name="reportDate">
                                    <!-- Check if the current date is in the available dates array -->
                                    @if (in_array($currentDate, $availableDates->toArray()))
                                        <!-- Iterate over the available dates -->
                                        @foreach ($availableDates as $date)
                                            <option value="{{ $date }}" {{ $date == $selectedDate ? 'selected' : '' }}>
                                                {{ $date }}
                                            </option>
                                        @endforeach
                                    @else
                                        <!-- If the current date is not in the available dates, show it as selected -->
                                        <option value="{{ $currentDate }}" selected>{{ $currentDate }}</option>

                                        <!-- Iterate over the available dates -->
                                        @foreach ($availableDates as $date)
                                            <option value="{{ $date }}">{{ $date }}</option>
                                        @endforeach
                                    @endif
                                </select>


                            </div>
                            <button type="submit" class="btn btn-primary">Generate Report</button>
                        </form>
                        <hr>
                        <!-- Display the generated report here -->
                        @if ($noDataMessage)
                           <p>{{ $noDataMessage }}</p>
                        @endif

                        <h6>Employee Check-In/Check-Out Report:</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Check-In Time</th>
                                    <th>Check-Out Time</th>
                                    <th>Office Hours</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Iterate over the employee data and display the report rows -->
                                @foreach ($employeeReport as $employee)

                                        <tr>

                                            <td><a href="/individual-report/{{ $employee->employee->id }}">{{ $employee->employee->name }}</a></td>
                                            <td>{{ date('h:i A', strtotime($employee->check_in_time)) }}</td>
                                            <td>
                                                @if ($employee->check_out_time !== null)
                                                    {{ date('h:i A', strtotime($employee->check_out_time)) }}
                                                @else
                                                    Not checked out yet
                                                @endif
                                            </td>

                                            <td>
                                                @if ($employee->check_in_time && $employee->check_out_time)
                                                    <?php
                                                        $checkInTime = strtotime($employee->check_in_time);
                                                        $checkOutTime = strtotime($employee->check_out_time);
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
