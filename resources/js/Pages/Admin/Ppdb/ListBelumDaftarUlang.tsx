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
	created_at: string;
	diterima: number;
}

interface PaginationLink {
	url: string | null;
	label: string;
	active: boolean;
}

interface Props {
	pesertappdb: {
		data: Peserta[];
		links: PaginationLink[];
		current_page: number;
		last_page: number;
		total: number;
	};
	tahun: number;
	years: number[];
	jurusan: string | null;
}

export default function ListBelumDaftarUlang({
	pesertappdb,
	tahun,
	years,
	jurusan,
}: Props) {
	const columns: Column<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.show.peserta", row.original.id)}
					className="text-primary hover:underline font-medium"
				>
					{row.getValue("no_pendaftaran")}
				</Link>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			cell: ({ row }) => (
				<div className="font-medium">{row.getValue("nama_lengkap")}</div>
			),
		},
		{
			header: "Jurusan",
			cell: ({ row }) => (
				<div className="text-sm font-medium">
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
			),
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
			cell: ({ row }) => (
				<div
					className="text-sm text-muted-foreground truncate max-w-[200px]"
					title={row.original.asal_sekolah}
				>
					{row.original.asal_sekolah}
				</div>
			),
		},
		{
			accessorKey: "no_hp",
			header: "No. HP",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="text-green-600 dark:text-green-400 hover:underline font-medium"
				>
					{row.getValue("no_hp")}
				</a>
			),
		},
		{
			accessorKey: "diterima",
			header: "Status",
			cell: ({ row }) => {
				const status = row.getValue("diterima");
				if (status === 1) {
					return (
						<Badge className="bg-green-500 hover:bg-green-600">Diterima</Badge>
					);
				} else if (status === 2) {
					return <Badge variant="destructive">Ditolak</Badge>;
				} else {
					return (
						<Badge
							variant="secondary"
							className="bg-yellow-500/10 text-yellow-600 border-yellow-500/20 hover:bg-yellow-500/20 dark:text-yellow-400"
						>
							Belum Diverifikasi
						</Badge>
					);
				}
			},
		},
		{
			id: "actions",
			header: "Aksi",
			cell: ({ row }) => (
				<Button asChild size="sm" variant="outline">
					<Link href={route("ppdb.show.peserta", row.original.id)}>Lihat</Link>
				</Button>
			),
		},
	];

	const handleYearChange = (value: string) => {
		router.get(
			window.location.pathname,
			{ tahun: value },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="List Peserta Belum Daftar Ulang" />

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
							<a
								href={`${route("export.belum.daftar.ulang")}?tahun=${tahun}${jurusan ? `&jurusan=${jurusan}` : ""}`}
							>
								Export Excel
							</a>
						</Button>
					</div>
				</div>

				<div className="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded text-blue-700 dark:text-blue-400 text-sm">
					<p className="font-bold">Info!</p>
					<p>
						Peserta yang belum melakukan pembayaran daftar ulang akan tampil
						disini. Jika peserta belum tampil, silahkan melakukan proses daftar
						ulang di menu kwitansi.
					</p>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
		</>
	);
}
