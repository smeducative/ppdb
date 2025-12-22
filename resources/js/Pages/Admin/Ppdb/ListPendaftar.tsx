import { type Column, DataTable } from "@/components/data-table";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Head, Link, router } from "@inertiajs/react";

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
}

interface Peserta {
	id: string;
	no_pendaftaran: string;
	nama_lengkap: string;
	tempat_lahir: string;
	tanggal_lahir: string;
	no_hp: string;
	asal_sekolah: string;
	jurusan: Jurusan;
	diterima: number; // 0: proses, 1: diterima, 2: ditolak
	created_at: string;
}

interface Props {
	pesertappdb: {
		data: Peserta[];
		links: any[];
		meta: any;
	};
	tahun: number;
	years: number[];
	jurusan?: string | number;
}

export default function ListPendaftar({
	pesertappdb,
	tahun,
	years,
	jurusan,
}: Props) {
	const columns: Column<Peserta>[] = [
		{
			header: "No. Pendaftaran",
			accessorKey: "no_pendaftaran",
		},
		{
			header: "Nama",
			accessorKey: "nama_lengkap",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.show.peserta", row.original.id)}
					className="text-blue-600 hover:underline"
				>
					{row.original.nama_lengkap}
				</Link>
			),
		},
		{
			header: "TTL",
			cell: ({ row }) => (
				<span>
					{row.original.tempat_lahir}, {row.original.tanggal_lahir}
				</span>
			),
		},
		{
			header: "No. Telepon",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="text-green-600 hover:underline"
				>
					{row.original.no_hp}
				</a>
			),
		},
		{
			header: "Asal Sekolah",
			accessorKey: "asal_sekolah" as keyof Peserta,
		},
		{
			header: "Pilihan Jurusan",
			cell: ({ row }) => row.original.jurusan?.nama || "-",
		},
		{
			header: "Status",
			cell: ({ row }) => {
				switch (row.original.diterima) {
					case 1:
						return (
							<Badge className="bg-green-500 hover:bg-green-600">
								Diterima
							</Badge>
						);
					case 2:
						return <Badge variant="destructive">Ditolak</Badge>;
					default:
						return (
							<Badge
								variant="secondary"
								className="bg-yellow-500 hover:bg-yellow-600 text-white"
							>
								Proses Seleksi
							</Badge>
						);
				}
			},
		},
		{
			header: "Tanggal Daftar",
			cell: ({ row }) => <span>{formatDateTime(row.original.created_at)}</span>,
		},
	];

	const handleYearChange = (year: string) => {
		router.get(
			window.location.pathname,
			{ tahun: year },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="List Peserta PPDB" />

			<div className="space-y-6">
				<div className="flex flex-col sm:flex-row justify-between gap-4">
					<div className="w-full sm:w-1/4">
						<Select value={String(tahun)} onValueChange={handleYearChange}>
							<SelectTrigger>
								<SelectValue placeholder="Pilih Tahun" />
							</SelectTrigger>
							<SelectContent>
								{years.map((y) => (
									<SelectItem key={y} value={String(y)}>
										{y}
									</SelectItem>
								))}
							</SelectContent>
						</Select>
					</div>

					<div className="flex items-center gap-2">
						<Button asChild>
							{/* Using Link with method post for export */}
							<Link
								href={`${route("export.peserta.ppdb")}?tahun=${tahun}&all=1&jurusan=${jurusan || ""}`}
								method="post"
								as="button"
							>
								Export Excel
							</Link>
						</Button>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={route("ppdb.list.pendaftar")}
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
				/>
			</div>
		</>
	);
}
