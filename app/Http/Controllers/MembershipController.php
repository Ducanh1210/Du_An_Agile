<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Models\Membership;

class MembershipController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = [];
    }

    /**
     * Danh sách gói tập
     */
    public function index()
    {
        $objMem = new Membership();
        $this->view['listMem'] = $objMem->loadAllDataMembershipWithPage();
        return view('admin.membership.index', $this->view);
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        return view('admin.membership.create');
    }

    /**
     * Lưu gói tập mới
     */
    public function store(StoreMembershipRequest $request)
    {
        $data = $request->all();
        $objMem = new Membership();
        $res = $objMem->insertDataMembership($data);
        if ($res) {
            return redirect()->route('admin.memberships.index')->with('success', 'Thêm mới gói tập thành công!');
        } else {
            return redirect()->back()->with('error', 'Thêm mới gói tập không thành công!');
        }
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $objMem = new Membership();
        $this->view['memDetail'] = $objMem->loadDataMembershipById($id);
        if (empty($this->view['memDetail'])) {
            return redirect()->route('admin.memberships.index')->with('error', 'Gói tập không tồn tại!');
        }
        return view('admin.membership.edit', $this->view);
    }

    /**
     * Cập nhật gói tập
     */
    public function update(UpdateMembershipRequest $request, $id)
    {
        $data = $request->except(['_token', '_method']);
        $objMem = new Membership();
        $res = $objMem->updateDataMembership($id, $data);
        if ($res) {
            return redirect()->route('admin.memberships.index')->with('success', 'Cập nhật gói tập thành công!');
        } else {
            return redirect()->back()->with('error', 'Cập nhật gói tập không thành công!');
        }
    }

    /**
     * Xóa gói tập
     */
    public function delete($id)
    {
        $objMem = new Membership();
        $res = $objMem->deleteDataMembership($id);
        if ($res) {
            return redirect()->route('admin.memberships.index')->with('success', 'Xóa gói tập thành công!');
        } else {
            return redirect()->route('admin.memberships.index')->with('error', 'Xóa gói tập không thành công!');
        }
    }
}
