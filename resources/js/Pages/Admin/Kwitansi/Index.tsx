import { type Column, DataTable } from "@/components/data-table";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { formatDate } from "@/lib/date";
import { Head, Link, router } from "@inertiajs/react";

interface Jurusan {
	id: number;
	nama: string;
	abbreviation: string;
}

interface Kwitansi {
	id: number;
	jenis_pembayaran: string;
	nominal: number;
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
	kwitansi: Kwitansi[];
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

export default function Index({ pesertappdb, tahun, years, jurusan }: Props) {
	const formatCurrency = (amount: number) => {
		return new Intl.NumberFormat("id-ID", {
			style: "currency",
			currency: "IDR",
			minimumFractionDigits: 0,
		}).format(amount);
	};

	const columns: Column<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<div className="font-medium">{row.getValue("no_pendaftaran")}</div>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.kwitansi.tambah", { uuid: row.original.id })}
					className="text-primary hover:underline font-medium"
				>
					{row.getValue("nama_lengkap")}
				</Link>
			),
		},
		{
			accessorKey: "ttl",
			header: "Tempat, Tanggal Lahir",
			cell: ({ row }) => {
				return (
					<div>
						{row.original.tempat_lahir},{" "}
						{formatDate(row.original.tanggal_lahir)}
					</div>
				);
			},
		},
		{
			accessorKey: "no_hp",
			header: "No. HP",
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
		},
		{
			accessorKey: "jurusan.nama",
			header: "Jurusan",
		},
		{
			id: "kwitansi_count",
			header: "Kwitansi",
			cell: ({ row }) => {
				const kwitansi = row.original.kwitansi;
				return (
					<div>
						<span className="font-bold">{kwitansi.length}</span>
						<span className="text-xs text-muted-foreground ml-1">
							({kwitansi.map((k) => k.jenis_pembayaran).join(", ")})
						</span>
					</div>
				);
			},
		},
		{
			id: "total_bayar",
			header: "Terbayar",
			cell: ({ row }) => {
				const total = row.original.kwitansi.reduce(
					(sum, k) => sum + k.nominal,
					0,
				);
				return (
					<div className="font-bold text-green-600 dark:text-green-400">
						{formatCurrency(total)}
					</div>
				);
			},
		},
	];

	const handleYearChange = (value: string) => {
		router.get(
			route("ppdb.kwitansi.show"),
			{ tahun: value, jurusan },
			{ preserveState: true },
		);
	};

	return (
		<>
			<Head title="Dashboard Kwitansi" />

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
						{/* Export buttons can be added here if needed */}
					</div>
				</div>

				<div className="space-y-4">
					<div className="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded text-blue-700 dark:text-blue-400 text-sm">
						<p className="font-bold">Info!</p>
						<p>
							Peserta yang tampil di halaman ini adalah peserta yang telah
							dinyatakan <strong>diterima</strong>. Setelah peserta dinyatakan
							diterima, peserta melakukan daftar ulang dengan melakukan
							pembayaran kwitansi daftar ulang.
						</p>
					</div>
					<div className="bg-blue-500/10 border-l-4 border-blue-500 p-4 rounded text-blue-700 dark:text-blue-400 text-sm">
						<p className="font-bold">Tips!</p>
						<p>Klik nama peserta untuk mengisi kwitansi.</p>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={route("ppdb.kwitansi.show")}
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
		</>
	);
}
