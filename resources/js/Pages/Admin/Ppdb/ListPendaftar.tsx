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
import { formatDate, formatDateTime } from "@/lib/date";
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
			header: "Identitas Peserta",
			className: "min-w-[200px]",
			cell: ({ row }) => (
				<div className="flex flex-col">
					<span className="font-mono text-muted-foreground text-xs">
						{row.original.no_pendaftaran}
					</span>
					<Link
						href={route("ppdb.show.peserta", row.original.id)}
						className="font-bold text-primary hover:underline"
					>
						{row.original.nama_lengkap}
					</Link>
					<span className="sm:hidden mt-1 text-muted-foreground text-xs">
						{row.original.jurusan?.nama || "-"}
					</span>
				</div>
			),
		},
		{
			header: "Info Peserta",
			className: "hidden md:table-cell",
			cell: ({ row }) => (
				<div className="flex flex-col text-sm">
					<div className="flex items-center gap-1">
						<span className="text-muted-foreground">TTL:</span>
						<span>
							{row.original.tempat_lahir},{" "}
							{formatDate(row.original.tanggal_lahir)}
						</span>
					</div>
					<div className="flex items-center gap-1">
						<span className="text-muted-foreground">Asal:</span>
						<span className="max-w-[150px] truncate">
							{row.original.asal_sekolah}
						</span>
					</div>
				</div>
			),
		},
		{
			header: "Kontak",
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="flex items-center gap-1 font-medium text-green-600 dark:text-green-400 text-sm hover:underline"
				>
					{row.original.no_hp}
				</a>
			),
		},
		{
			header: "Jurusan",
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<div className="font-medium text-sm">
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
			),
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
								className="bg-yellow-500/10 hover:bg-yellow-500/20 border-yellow-500/20 text-yellow-600 dark:text-yellow-400"
							>
								Proses
							</Badge>
						);
				}
			},
		},
		{
			header: "Terdaftar",
			className: "hidden lg:table-cell",
			cell: ({ row }) => (
				<span className="text-muted-foreground text-xs">
					{formatDateTime(row.original.created_at)}
				</span>
			),
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
				<div className="flex sm:flex-row flex-col justify-between gap-4">
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
							<Link
								href={route("export.peserta.ppdb")}
								method="post"
								data={{
									tahun: tahun,
									all: 1,
									jurusan: jurusan || "",
								}}
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
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
		</>
	);
}
