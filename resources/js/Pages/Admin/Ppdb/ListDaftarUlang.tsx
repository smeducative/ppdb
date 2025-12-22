import { type Column, DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { Head, Link, router } from "@inertiajs/react";
import { format } from "date-fns";

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

export default function ListDaftarUlang({
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
				<div>
					<div className="font-medium">
						<Link
							href={route("ppdb.show.peserta", row.original.id)}
							className="text-blue-600 hover:underline"
						>
							{row.getValue("no_pendaftaran")}
						</Link>
					</div>
				</div>
			),
		},
		{
			accessorKey: "nama_lengkap",
			header: "Nama Lengkap",
			cell: ({ row }) => (
				<Link
					href={route("ppdb.show.peserta", row.original.id)}
					className="hover:underline font-medium"
				>
					{row.getValue("nama_lengkap")}
				</Link>
			),
		},
		{
			accessorKey: "ttl",
			header: "Tempat, Tanggal Lahir",
			cell: ({ row }) => {
				const date = new Date(row.original.tanggal_lahir);
				return (
					<div>
						{row.original.tempat_lahir}, {format(date, "dd-MM-yyyy")}
					</div>
				);
			},
		},
		{
			accessorKey: "no_hp",
			header: "No. HP",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="text-blue-600 hover:underline"
				>
					{row.getValue("no_hp")}
				</a>
			),
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
		},
		{
			accessorKey: "jurusan.abbreviation",
			header: "Jurusan",
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
			<Head title="List Peserta Daftar Ulang" />

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
								href={`${route("export.peserta.ppdb")}?tahun=${tahun}&diterima=1&all=0${jurusan ? `&jurusan=${jurusan}` : ""}`}
							>
								Export Excel
							</a>
						</Button>
					</div>
				</div>

				<div className="bg-blue-50 border-l-4 border-blue-500 p-4 rounded text-blue-700 text-sm">
					<p className="font-bold">Info!</p>
					<p>
						Peserta yang telah melakukan pembayaran daftar ulang akan tampil
						disini. Jika peserta belum tampil, silahkan melakukan proses daftar
						ulang di menu kwitansi.
					</p>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={route("ppdb.daftar.ulang.list")}
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
		</>
	);
}
