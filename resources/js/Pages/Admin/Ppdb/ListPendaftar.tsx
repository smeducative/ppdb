import { type Column, DataTable } from "@/components/data-table";
import { ExportStatusDialog } from "@/components/export-status-dialog";
import { Badge } from "@/components/ui/badge";
import {
	Select,
	SelectContent,
	SelectItem,
	SelectTrigger,
	SelectValue,
} from "@/components/ui/select";
import { formatDate, formatDateTime } from "@/lib/date";
import { Head, Link, router } from "@inertiajs/react";
import {
	CalendarClock,
	CheckCircle2,
	ClipboardList,
	GraduationCap,
	Hash,
	Info,
	Phone,
	School,
	User,
	XCircle,
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
	bertindik: boolean;
	bertato: boolean;
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
					<div className="mt-1 flex items-center gap-2">
						<Badge variant={row.original.bertindik ? "default" : "outline"}>
							Bertindik: {row.original.bertindik ? "Ya" : "Tidak"}
						</Badge>
						<Badge variant={row.original.bertato ? "default" : "outline"}>
							Bertato: {row.original.bertato ? "Ya" : "Tidak"}
						</Badge>
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
		{
			header: "Status",
			icon: ClipboardList,
			cell: ({ row }) => {
				switch (row.original.diterima) {
					case 1:
						return (
							<Badge className="bg-green-500 hover:bg-green-600">
								<CheckCircle2 className="size-3.5" />
								Diterima
							</Badge>
						);
					case 2:
						return (
							<Badge variant="destructive">
								<XCircle className="size-3.5" />
								Ditolak
							</Badge>
						);
					default:
						return (
							<Badge
								variant="secondary"
								className="border-yellow-500/20 bg-yellow-500/10 text-yellow-600 hover:bg-yellow-500/20 dark:text-yellow-400"
							>
								<ClipboardList className="size-3.5" />
								Proses
							</Badge>
						);
				}
			},
		},
		{
			header: "Terdaftar",
			icon: CalendarClock,
			className: "hidden lg:table-cell",
			cell: ({ row }) => (
				<span className="inline-flex items-center gap-1.5 text-xs text-muted-foreground">
					<CalendarClock className="size-3.5 shrink-0" />
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
			<Head title="List Peserta SPMB" />

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
							defaultStatus="semua"
						/>
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
