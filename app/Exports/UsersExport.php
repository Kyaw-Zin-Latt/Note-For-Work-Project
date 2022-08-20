<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;


    public function collection()
    {
        return User::all();
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->profile_photo_path,
            $user->created_at->format("d M Y , h : i a"),
            $user->updated_at->format("d M Y , h : i a"),
        ];
    }

    public function headings(): array
    {
        return [
            "id", "Name", "Email", "Profile Photo Name", "Created Date", "Updated Date"
        ];
    }


}
