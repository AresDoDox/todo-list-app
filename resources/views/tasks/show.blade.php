@extends('tasks.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📄 Chi tiết công việc</h5>
                    <a href="{{ route('tasks.index') }}" class="btn btn-sm btn-secondary">⬅ Quay lại</a>
                </div>
                <div class="card-body">
                    <h4 class="fw-bold mb-3">Học Laravel</h4>
                    <p class="text-muted"><strong>Mô tả:</strong></p>
                    <p>Hoàn thành các chức năng CRUD và tìm hiểu middleware.</p>
                    <p><strong>Hạn chót:</strong> <span class="badge bg-danger">2025-10-01</span></p>
                    <p><strong>Trạng thái:</strong> <span class="badge bg-warning">Đang làm</span></p>

                    <div class="mt-4 d-flex justify-content-end">
                        <a href="{{ route('tasks.edit', 1) }}" class="btn btn-warning me-2">✏️ Sửa</a>
                        <button class="btn btn-danger">🗑 Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
