import { type Column, DataTable } from "@/components/data-table";
import { ExportStatusDialog } from "@/components/export-status-dialog";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { formatDate } from "@/lib/date";
import { Head, Link, router } from "@inertiajs/react";
import {
	CalendarClock,
	GraduationCap,
	Hash,
	Info,
	Phone,
	School,
	User,
} from "lucide-react";

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
			header: "Identitas Peserta",
			icon: User,
			className: "min-w-[200px]",
			cell: ({ row }) => (
				<div className="flex flex-col gap-0.5">
					<span className="inline-flex items-center gap-1 font-mono text-xs text-muted-foreground">
						<Hash className="size-3 shrink-0" />
						{row.original.no_pendaftaran}
					</span>
					<Link
						href={route("ppdb.show.peserta", row.original.id)}
						className="font-bold text-primary hover:underline"
					>
						{row.original.nama_lengkap}
					</Link>
					<span className="mt-1 inline-flex items-center gap-1 text-xs text-muted-foreground sm:hidden">
						<GraduationCap className="size-3 shrink-0" />
						{row.original.jurusan?.nama || "-"}
					</span>
				</div>
			),
		},
		{
			header: "Info Peserta",
			icon: Info,
			className: "hidden md:table-cell",
			cell: ({ row }) => (
				<div className="flex flex-col gap-1 text-sm">
					<div className="flex items-center gap-1.5">
						<CalendarClock className="size-3.5 shrink-0 text-muted-foreground" />
						<span>
							{row.original.tempat_lahir},{" "}
							{formatDate(row.original.tanggal_lahir)}
						</span>
					</div>
					<div className="flex items-center gap-1.5">
						<School className="size-3.5 shrink-0 text-muted-foreground" />
						<span className="max-w-[150px] truncate">
							{row.original.asal_sekolah}
						</span>
					</div>
				</div>
			),
		},
		{
			header: "Kontak",
			icon: Phone,
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<a
					href={`https://wa.me/${row.original.no_hp}`}
					target="_blank"
					rel="noreferrer"
					className="inline-flex items-center gap-1.5 text-sm font-medium text-green-600 hover:underline dark:text-green-400"
				>
					<Phone className="size-3.5 shrink-0" />
					{row.original.no_hp}
				</a>
			),
		},
		{
			header: "Jurusan",
			icon: GraduationCap,
			className: "hidden sm:table-cell",
			cell: ({ row }) => (
				<div className="inline-flex items-center gap-1.5 text-sm font-medium">
					<GraduationCap className="size-3.5 shrink-0 text-muted-foreground" />
					{row.original.jurusan?.abbreviation ||
						row.original.jurusan?.nama ||
						"-"}
				</div>
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
			<Head title="List Peserta Daftar Ulang" />

			<div className="space-y-6">
				<div className="flex flex-col justify-between gap-4 sm:flex-row">
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
						<ExportStatusDialog
							routeName="export.peserta.ppdb"
							params={{ tahun, jurusan: jurusan || "" }}
							defaultStatus="sudah_du"
						/>
					</div>
				</div>

				<div className="rounded border-l-4 border-blue-500 bg-blue-500/10 p-4 text-sm text-blue-700 dark:text-blue-400">
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
					searchPlaceholder="Cari nama, no pend, asal sekolah..."
					additionalParams={{ jurusan }}
				/>
			</div>
		</>
	);
}
