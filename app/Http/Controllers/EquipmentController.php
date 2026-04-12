<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = \App\Models\Equipment::orderBy('id', 'desc')->paginate(10);
        return view('admin.equipments.index', compact('equipments'));
    }

    public function create()
    {
        return view('admin.equipments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'status' => 'required|in:active,maintenance,broken',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Vui lòng nhập tên dụng cụ',
            'status.in' => 'Trạng thái không hợp lệ',
        ]);

        \App\Models\Equipment::create($request->all());

        return redirect()->route('equipments.index')->with('success', 'Thêm dụng cụ thành công!');
    }

    public function edit($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        return view('admin.equipments.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'status' => 'required|in:active,maintenance,broken',
            'description' => 'nullable|string'
        ], [
            'name.required' => 'Vui lòng nhập tên dụng cụ',
            'status.in' => 'Trạng thái không hợp lệ',
        ]);

        $equipment = \App\Models\Equipment::findOrFail($id);
        $equipment->update($request->all());

        return redirect()->route('equipments.index')->with('success', 'Cập nhật dụng cụ thành công!');
    }

    public function delete($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('equipments.index')->with('success', 'Xóa dụng cụ thành công!');
    }
}
