<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\Equipment;

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

    public function store(StoreEquipmentRequest $request)
    {
        Equipment::create($request->validated());

        return redirect()->route('admin.equipments.index')->with('success', 'Thêm dụng cụ thành công!');
    }

    public function edit($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('admin.equipments.edit', compact('equipment'));
    }

    public function update(UpdateEquipmentRequest $request, $id)
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($request->validated());

        return redirect()->route('admin.equipments.index')->with('success', 'Cập nhật dụng cụ thành công!');
    }

    public function delete($id)
    {
        $equipment = \App\Models\Equipment::findOrFail($id);
        $equipment->delete();

        return redirect()->route('admin.equipments.index')->with('success', 'Xóa dụng cụ thành công!');
    }
}
