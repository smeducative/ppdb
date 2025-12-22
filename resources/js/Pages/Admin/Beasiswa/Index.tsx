import { AlertMessages } from "@/components/alert-messages";
import { DataTable } from "@/components/data-table";
import { Button } from "@/components/ui/button";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { formatDate } from "@/lib/date";
import { Head, Link, router, usePage } from "@inertiajs/react";
import type { ColumnDef } from "@tanstack/react-table";

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
	tanggal_lahir: string; // ISO date string
	no_hp: string;
	asal_sekolah: string;
	jurusan: Jurusan;
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
	title: string;
}

export default function Index({ pesertappdb, tahun, years, title }: Props) {
	const { flash } = usePage<any>().props;

	const columns: ColumnDef<Peserta>[] = [
		{
			accessorKey: "no_pendaftaran",
			header: "No. Pendaftaran",
			cell: ({ row }) => (
				<div>
					<div className="font-medium text-primary">
						{row.getValue("no_pendaftaran")}
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
			id: "ttl",
			header: "Tempat, Tanggal Lahir",
			cell: ({ row }) => {
				return `${row.original.tempat_lahir}, ${formatDate(row.original.tanggal_lahir)}`;
			},
		},
		{
			accessorKey: "no_hp",
			header: "No. Telepon",
		},
		{
			accessorKey: "asal_sekolah",
			header: "Asal Sekolah",
		},
		{
			accessorKey: "jurusan.abbreviation",
			header: "Pilihan Jurusan",
		},
	];

	const handleYearChange = (value: string) => {
		router.visit(window.location.pathname, {
			data: { tahun: value },
			preserveState: true,
		});
	};

	const handleExport = () => {
		router.post(
			window.location.pathname,
			{ tahun },
			{
				responseType: "blob",
			},
		);
	};

	return (
		<>
			<Head title={title} />

			<div className="space-y-6">
				<AlertMessages flash={flash} />

				<div
					className="bg-blue-500/10 border-l-4 border-blue-500 text-blue-700 dark:text-blue-400 p-4"
					role="alert"
				>
					<p className="font-bold">Info!</p>
					<p>
						Daftar Peserta yang menerima <strong>{title}</strong>.
					</p>
				</div>

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
						<Button onClick={handleExport}>Export Excel</Button>
					</div>
				</div>

				<DataTable
					columns={columns}
					data={pesertappdb.data}
					pagination={{ links: pesertappdb.links }}
					searchEndpoint={window.location.pathname}
					searchPlaceholder="Cari nama..."
				/>
			</div>
		</>
	);
}
