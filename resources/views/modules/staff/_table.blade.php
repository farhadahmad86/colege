<div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>UserName</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($staff as $index => $user)
            <tr>
                <th>{{ $index + 1 }}</th>
                <td>{{ $user->name }}</td>
                <td>{{ $user->userName }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('staff.edit', ['staff' => $user]) }}" class="btn btn-sm btn-warning d-inline"><i class="fa fa-edit"></i></a>
                    <form action="{{ route('staff.destroy', ['staff' => $user]) }}" method="post" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger d-inline"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <th colspan="5" class="text-danger text-center font-weight-bold">No Staff Available</th>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="text-center">
        {{ $staff->links() }}
    </div>
</div>
