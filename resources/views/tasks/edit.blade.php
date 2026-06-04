@extends('tasks.layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">✏️ Sửa công việc</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Tên công việc</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title', $task->title) }}" placeholder="Nhập tên công việc..." required>
                            @error('title')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Hạn chót</label>
                            <input type="date" name="due_date" class="form-control" id="due_date"
                                value="{{ old('due_date', $task->due_date) }}">
                            @error('due_date')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <select name="status" id="status" class="form-select">
                                <option value="0" {{ old('status', $task->status) === 0 ? 'selected' : '' }}>Chưa làm
                                </option>
                                <option value="1" {{ old('status', $task->status) === 1 ? 'selected' : '' }}>Đang làm
                                </option>
                                <option value="2" {{ old('status', $task->status) === 2 ? 'selected' : '' }}>Hoàn thành
                                </option>
                            </select>
                            @error('status')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">⬅ Quay lại</a>
                            <button type="submit" class="btn btn-success">✔ Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
