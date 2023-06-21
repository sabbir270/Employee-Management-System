<x-HeaderFooter>
    <div class="container">

        <div class="row">
            <div class="col-md-4">
              <a href="/addEmployeeForm" class="btn btn-primary">Add New Employee</a>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-4">
              <a href="/employee-report" class="btn btn-primary">Employee Report</a>
            </div>
          </div>

        <div class="row">
          <div class="col-md-8">
            <table class="table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $employee)
                  <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

      </div>

 </x-HeaderFooter>
