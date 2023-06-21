<x-HeaderFooter>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Employee Dashboard</h5>
                        <p>Date: {{ $currentDate }}</p>
                        @if ($checkedIn)
                            <p>Check-in time: {{ $checkInTime }}</p>
                            <form method="POST" action="/check-out">
                                @csrf
                                <button type="submit" class="btn btn-primary">Check Out</button>
                            </form>
                        @else
                            <form method="POST" action="/check-in">
                                @csrf
                                <button type="submit" class="btn btn-primary">Check In</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-HeaderFooter>
