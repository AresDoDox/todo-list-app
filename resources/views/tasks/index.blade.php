@extends('tasks.layout')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách công việc</h5>
            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">+ Thêm Task</a>
        </div>
        <div class="card-body">
            <form class="filter row mb-3" method="GET" action="{{ route('tasks.index') }}">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên công việc"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa làm</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang làm</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Hoàn thành</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort_option" class="form-select">
                        <option value="default" {{ !request('sort_option') ? 'selected' : '' }}>Sắp xếp theo</option>
                        <option value="created_at" {{ request('sort_option') === 'created_at' ? 'selected' : '' }}>Thời gian
                            tạo
                        </option>
                        <option value="due_date" {{ request('sort_option') === 'due_date' ? 'selected' : '' }}>Hạn chót
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-md btn-secondary">Lọc</button>
                    <a href="{{ route('tasks.index') }}" class="btn btn-md btn-outline-secondary">Xóa lọc</a>
                </div>
            </form>

            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="w-25">Công việc</th>
                        <th>Hạn chót</th>
                        <th>Trạng thái</th>
                        <th>Thay đổi trạng thái</th>
                        <th>Thời gian tạo</th>
                        <th>Người tạo</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Demo static -->
                    @forelse ($tasks as $task)
                        <tr data-id="{{ $task->id }}">
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                @switch ($task->status)
                                    @case(0)
                                        <span class="badge bg-secondary">Chưa làm</span>
                                    @break

                                    @case(1)
                                        <span class="badge bg-warning">Đang làm</span>
                                    @break

                                    @case(2)
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">Không xác định</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        Thay đổi trạng thái
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item change-status" data-status="0">Chưa làm</a></li>
                                        <li><a class="dropdown-item change-status" data-status="1">Đang làm</a></li>
                                        <li><a class="dropdown-item change-status" data-status="2">Hoàn thành</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $task->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $task->user->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('tasks.show', $task->id) }}"
                                    class="btn btn-sm btn-info text-white">Xem</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Sửa</a>

                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa công việc này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có công việc nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- pagination --}}
                <div>
                    {{ $tasks->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.change-status').click(function(e) {
                    e.preventDefault();

                    var status = $(this).data('status');
                    var taskId = $(this).closest('tr').data('id');

                    $.ajax({
                        url: '/tasks/' + taskId + '/status',
                        method: 'PATCH',
                        data: {
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                const statusBadge = $('tr[data-id="' + taskId +
                                    '"] td:nth-child(4) .badge');
                                switch (status) {
                                    case 0:
                                        statusBadge.removeClass().addClass('badge bg-secondary')
                                            .text('Chưa làm');
                                        break;
                                    case 1:
                                        statusBadge.removeClass().addClass('badge bg-warning').text(
                                            'Đang làm');
                                        break;
                                    case 2:
                                        statusBadge.removeClass().addClass('badge bg-success').text(
                                            'Hoàn thành');
                                        break;
                                    default:
                                        statusBadge.removeClass().addClass('badge bg-secondary')
                                            .text('Không xác định');
                                }
                            } else {
                                alert('Cập nhật thất bại. Vui lòng thử lại.');
                            }
                        },
                        error: function(error) {
                            console.error(error);
                            alert('Có lỗi xảy ra. Vui lòng thử lại.');
                        }
                    });
                });
            });
        </script>
    @endpush
