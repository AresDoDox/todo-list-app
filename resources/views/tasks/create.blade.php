@extends('tasks.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">+ Thêm công việc</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên công việc</label>
                            <input type="text" class="form-control" id="title" placeholder="Nhập tên công việc..."
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" rows="3" placeholder="Nhập mô tả chi tiết..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Hạn chót</label>
                            <input type="date" class="form-control" id="due_date">
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select id="status" class="form-select">
                                <option value="pending">Đang làm</option>
                                <option value="done">Hoàn thành</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">⬅ Quay lại</a>
                            <button type="submit" class="btn btn-primary">💾 Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
