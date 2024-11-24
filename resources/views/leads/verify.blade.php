@extends('layouts.app')

@section('title', 'Verify Leads')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Back
        </a>

        <h1 class="mb-0">Verify Leads - {{ $importLog->file_name }}</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Sl No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Street 1</th>
                    <th>Street 2</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Lead Source</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paginatedData as $row)
                    <tr>
                        <td>{{ ($paginatedData->currentPage() - 1) * $paginatedData->perPage() + $loop->iteration }}</td>
                        <td>{{ $row['first_name'] ?? 'N/A' }}</td>
                        <td>{{ $row['last_name'] ?? 'N/A' }}</td>
                        <td>{{ $row['email'] ?? 'N/A' }}</td>
                        <td>{{ $row['mobile_number'] ?? 'N/A' }}</td>
                        <td>{{ $row['street_1'] ?? 'N/A' }}</td>
                        <td>{{ $row['street_2'] ?? 'N/A' }}</td>
                        <td>{{ $row['city'] ?? 'N/A' }}</td>
                        <td>{{ $row['state'] ?? 'N/A' }}</td>
                        <td>{{ $row['country'] ?? 'N/A' }}</td>
                        <td>{{ $row['lead_source'] ?? 'N/A' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No Data Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $paginatedData->links() }}
    </div>
@endsection
