<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        // $tasks = Task::all();
        // $tasks = Task::latest()->paginate(10);
        // $tasks = Task::with('user')->orderBy('due_date', 'asc')->paginate(10);

        // filter by search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // DEBUG: In toàn bộ request
        Log::info('=== REQUEST DATA ===', $request->all());
        Log::info('Status raw: ' . $request->input('status'));
        Log::info('Status exists: ' . ($request->has('status') ? 'yes' : 'no'));
        Log::info('Status filled: ' . ($request->filled('status') ? 'yes' : 'no'));

        // filter by status
        if ($request->filled('status') && in_array($request->status, [Task::STATUS_PENDING, Task::STATUS_IN_PROGRESS, Task::STATUS_COMPLETED])) {
            $query->where('status', $request->status);
        }

        // sort results
        switch ($request->get('sort_option')) {
            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;
            case 'due_date':
                $query->orderBy('due_date', 'asc');
                break;
            default:
                $query->latest();
        }

        $tasks = $query->with('user')->paginate(10)->appends($request->all());
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        Task::create($data);
        return redirect()->route('tasks.index')->with('success', 'Công việc đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);
        $data = $request->validated();
        $task->update($data);
        return redirect()->route('tasks.index')->with('success', 'Công việc đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Công việc đã được xóa thành công!');
    }

    public function updateStatus(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        $request->validate([
            'status' => 'required|in:' . Task::STATUS_PENDING . ',' . Task::STATUS_IN_PROGRESS . ',' . Task::STATUS_COMPLETED,
        ]);
        $task->update(['status' => $request->status]);
        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đã được cập nhật thành công!',
            'status' => $request->status,
        ]);
    }

    public function trash(Request $request)
    {
        $query = Task::query();

        // filter by search
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // filter by status
        if ($request->filled('status') && in_array($request->status, [Task::STATUS_PENDING, Task::STATUS_IN_PROGRESS, Task::STATUS_COMPLETED])) {
            $query->where('status', $request->status);
        }

        // sort results
        switch ($request->get('sort_option')) {
            case 'created_at':
                $query->orderBy('created_at', 'desc');
                break;
            case 'due_date':
                $query->orderBy('due_date', 'asc');
                break;
            default:
                $query->latest();
        }

        $tasks = $query->onlyTrashed()->with('user')->paginate(10)->appends($request->all());
        return view('tasks.trash', compact('tasks'));
    }

    public function restore(string $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->restore();
        return redirect()->route('tasks.trash')->with('success', 'Công việc đã được khôi phục thành công!');
    }

    public function forceDelete(string $id)
    {
        $task = Task::onlyTrashed()->findOrFail($id);
        $task->forceDelete();
        return redirect()->route('tasks.trash')->with('success', 'Công việc đã được xóa vĩnh viễn!');
    }

    public function forceDeleteAll()
    {
        Task::onlyTrashed()->forceDelete();
        return redirect()->route('tasks.trash')->with('success', 'Tất cả công việc đã được xóa vĩnh viễn!');
    }
}
