@extends('tasks.layout')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Danh sách công việc</h5>
            <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">+ Thêm Task</a>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Công việc</th>
                        <th>Hạn chót</th>
                        <th>Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Demo static -->
                    @forelse ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->due_date }}</td>
                            <td>
                                @switch ($task->status)
                                    @case('pending')
                                        <span class="badge bg-secondary">Chưa làm</span>
                                    @break

                                    @case('in_progress')
                                        <span class="badge bg-warning">Đang làm</span>
                                    @break

                                    @case('completed')
                                        <span class="badge bg-success">Hoàn thành</span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">Không xác định</span>
                                @endswitch
                            </td>
                            <td class="text-end">
                                <a href="{{ route('tasks.show', $task->id) }}"
                                    class="btn btn-sm btn-info text-white">Xem</a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <button class="btn btn-sm btn-danger">Xóa</button>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có công việc nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
