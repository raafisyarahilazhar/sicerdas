<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationApprovalController extends Controller
{
    public function approve(Request $request, Application $application)
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'rt':
                if ($application->status === 'pending_rt') {
                    $application->status = 'pending_rw';
                    $application->save();
                    return back()->with('success', 'Pengajuan telah disetujui RT, menunggu persetujuan RW.');
                }
                break;

            case 'rw':
                if ($application->status === 'pending_rw') {
                    $application->status = 'pending_kades';
                    $application->save();
                    return back()->with('success', 'Pengajuan telah disetujui RW, menunggu persetujuan Kepala Desa.');
                }
                break;

            case 'kades':
                if ($application->status === 'pending_kades') {
                    $application->status = 'approved';
                    $application->save();
                    return back()->with('success', 'Pengajuan telah disetujui Kepala Desa dan dinyatakan selesai.');
                }
                break;

            case 'operator':
            case 'admin':
                $application->status = 'approved';
                $application->save();
                return back()->with('success', 'Pengajuan telah disetujui secara langsung oleh Admin/Operator.');

            default:
                return back()->with('error', 'Anda tidak memiliki akses untuk menyetujui pengajuan ini.');
        }

        return back()->with('error', 'Status pengajuan tidak sesuai untuk persetujuan.');
    }

    public function reject(Request $request, Application $application)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['rt', 'rw', 'kades'])) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menolak pengajuan ini.');
        }

        $formData = json_decode($application->form_data, true) ?? [];
        $formData['rejected_by'] = $user->role;

        $application->status = 'rejected';
        $application->form_data = json_encode($formData);
        $application->save();

        return back()->with('error', 'Pengajuan ditolak oleh ' . ucfirst($user->role) . ' dengan alasan: ' . $request->reason);
    }
}
