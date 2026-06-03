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
                    <tr>
                        <td>1</td>
                        <td>Học Laravel</td>
                        <td>2025-10-01</td>
                        <td><span class="badge bg-warning">Đang làm</span></td>
                        <td class="text-end">
                            <a href="{{ route('tasks.show', 1) }}" class="btn btn-sm btn-info text-white">Xem</a>
                            <a href="{{ route('tasks.edit', 1) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><span class="text-decoration-line-through text-muted">Hoàn thành Todo List</span></td>
                        <td>2025-09-30</td>
                        <td><span class="badge bg-success">Hoàn thành</span></td>
                        <td class="text-end">
                            <a href="{{ route('tasks.show', 2) }}" class="btn btn-sm btn-info text-white">Xem</a>
                            <a href="{{ route('tasks.edit', 2) }}" class="btn btn-sm btn-warning">Sửa</a>
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
