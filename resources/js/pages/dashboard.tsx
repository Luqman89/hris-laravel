import { Head, useForm } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

interface DashboardProps {
    stats: {
        total_employees: number;
        on_leave: number;
        pending_approval: number;
    };
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];

export default function Dashboard({ stats }: DashboardProps) {
    const { post, processing } = useForm({});

    const handleClockIn = () => {
        post('/attendance/clock-in', {
            onSuccess: () => alert('Berhasil Absen Masuk!'),
        });
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard HRIS" />

            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                {/* Baris Atas: Kartu Statistik */}
                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    {/* Kartu 1: Total Karyawan */}
                    <div className="flex flex-col justify-center gap-2 rounded-xl border border-sidebar-border/70 bg-card p-6 text-card-foreground shadow dark:border-sidebar-border">
                        <span className="text-sm font-medium text-muted-foreground">
                            Total Karyawan
                        </span>
                        <span className="text-3xl font-bold tracking-tight">
                            {stats?.total_employees ?? 0}
                        </span>
                    </div>

                    {/* Kartu 2: Sedang Cuti */}
                    <div className="flex flex-col justify-center gap-2 rounded-xl border border-sidebar-border/70 bg-card p-6 text-card-foreground shadow dark:border-sidebar-border">
                        <span className="text-sm font-medium text-muted-foreground">
                            Sedang Cuti
                        </span>
                        <span className="text-3xl font-bold tracking-tight text-orange-500">
                            {stats?.on_leave ?? 0}
                        </span>
                    </div>

                    {/* Kartu 3: Menunggu Approval */}
                    <div className="flex flex-col justify-center gap-2 rounded-xl border border-sidebar-border/70 bg-card p-6 text-card-foreground shadow dark:border-sidebar-border">
                        <span className="text-sm font-medium text-muted-foreground">
                            Menunggu Approval
                        </span>
                        <span className="text-3xl font-bold tracking-tight text-red-500">
                            {stats?.pending_approval ?? 0}
                        </span>
                    </div>
                </div>

                {/* Baris Bawah: Placeholder untuk Grafik atau Tabel Absensi Terakhir */}
                <div className="relative min-h-[200px] flex-1 rounded-xl border border-sidebar-border/70 bg-card p-6 shadow dark:border-sidebar-border">
                    <h3 className="mb-2 text-lg font-semibold">
                        Presensi Hari Ini
                    </h3>
                    <p className="mb-6 text-sm text-muted-foreground">
                        Silakan lakukan absensi masuk atau pulang.
                    </p>

                    <button
                        onClick={handleClockIn}
                        disabled={processing}
                        className="rounded-lg bg-indigo-600 px-6 py-2 font-medium text-white transition hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {processing ? 'Processing...' : 'Clock In (Masuk)'}
                    </button>
                </div>
            </div>
        </AppLayout>
    );
}
