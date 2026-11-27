<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|string|max:50|unique:members,member_code',
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
        ]);

        Member::create($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil ditambahkan.');
    }

    public function show(Member $member)
    {
        $borrowings = \App\Models\Borrowing::with(['user', 'details.book'])
            ->where('member_id', $member->id)
            ->latest('borrowing_date')
            ->get();

        $totalTransactions = $borrowings->count();
        $activeTransactions = $borrowings->where('status', 'borrowed')->count();
        $returnedTransactions = $borrowings->where('status', 'returned')->count();

        return view('members.show', compact(
            'member',
            'borrowings',
            'totalTransactions',
            'activeTransactions',
            'returnedTransactions'
        ));
    }   

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'member_code' => 'required|string|max:50|unique:members,member_code,' . $member->id,
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->borrowings()->exists()) {
            return back()->with('error', 'Data anggota tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $member->delete();

        return redirect()->route('members.index')
            ->with('success', 'Data anggota berhasil dihapus.');
    }
}