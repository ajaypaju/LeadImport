@extends('layouts.app')

@section('title', 'Lead Generation')

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('lead.show') }}" class="btn {{ $activeTab == 'leads' ? 'btn-primary' : 'btn-secondary' }}">Leads</a>
            <a href="{{ route('lead.import') }}" class="btn {{ $activeTab == 'import' ? 'btn-primary' : 'btn-secondary' }}">Import</a>
        </div>
    </div>

    @if ($activeTab == 'leads')
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
                        <th>Leadsource</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leads as $index => $lead)
                        <tr>
                            <td>{{ ($leads->currentPage() - 1) * $leads->perPage() + $loop->iteration }}</td>
                            <td>{{ $lead->first_name }}</td>
                            <td>{{ $lead->last_name }}</td>
                            <td>{{ $lead->email }}</td>
                            <td>{{ $lead->mobile_number }}</td>
                            <td>{{ $lead->street_1 }}</td>
                            <td>{{ $lead->street_2 }}</td>
                            <td>{{ $lead->city }}</td>
                            <td>{{ $lead->state }}</td>
                            <td>{{ $lead->country }}</td>
                            <td>{{ $lead->lead_source }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No Leads Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="d-flex justify-content-center mt-4">
            {{ $leads->links() }}
        </div>
    @elseif ($activeTab == 'import')
        <div class="card mb-4">
            <div class="card-header">
                <h5>Import Leads</h5>
            </div>
            <div class="card-body">
                <!-- File Import Form -->
                <form action="{{ route('lead.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Sl No</th>
                        <th>File Name</th>
                        <th>Status</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($importData as $data)
                        <tr>
                            <td>{{ ($importData->currentPage() - 1) * $importData->perPage() + $loop->iteration }}</td>
                            <td>{{ $data->file_name }}</td>
                            <td>
                                @if ($data->status == 'Ready to import')
                                    <a href="{{ route('lead.process', encrypt($data->id)) }}" class="btn btn-sm btn-success">{{ $data->status }}</a>
                                    <a href="{{ route('lead.verify', encrypt($data->id)) }}" class="btn btn-sm btn-success">Verify</a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>{{ $data->status }}</button>
                                @endif
                            </td>
                            <td>{{ $data->error_message }}</td>
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
            {{ $importData->links() }}
        </div>
    @endif
@endsection
